<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('role_ids', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $otherDetailGate = 'user_show';
                $otherDetailUrl = route('admin.users.show', ['user' => $row->id]);
                $crudRoutePart = 'users';

                return view('_partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'otherDetailGate',
                    'otherDetailUrl',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('role_ids', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = $role->id;
                }

                return $labels;
            });

            $table->rawColumns(['actions', 'placeholder', 'approved', 'roles']);

            return $table->make(true);
        }

        $roles = Role::pluck('title', 'id');

        return view('admin.users.index', compact('roles'));
    }

    public function getTenantParents(Request $request): JsonResponse
    {
        $roles = Role::with('permissions')->where('id', $request->role_id)
            ->whereRelation('permissions', 'title', 'like', 'tenant_%')->first();

        if ($roles) {
            $tenant = null;
            foreach ($roles->permissions as $role) {
                if (str_starts_with($role->title, 'tenant_')) {
                    $tenant = $role;
                }
            }

            $tenant_ids = [];

            foreach (User::TENANT_HIERARCHY as $index => $item) {
                if (isset(User::TENANT_HIERARCHY[$tenant->title])) {
                    if ((User::TENANT_HIERARCHY[$tenant->title] - $item) == -1) {
                        $tenant_ids[] = $index;
                    }
                }
            }

            $user_ids = User::with('roles')->whereHas('roles.permissions',
                fn($q) => $q->whereIn('title', $tenant_ids))->pluck('id');

            $tenants = Tenant::with('user', 'team')->whereHas('user',
                fn($q) => $q->whereIn('id', $user_ids))->get();

            if ($tenants->count() == 0 && $tenant->title == 'tenant_area_manager') {

                $customResponse = [];
                $teams = Team::with('owner')->get();

                foreach ($teams as $team) {
                    $customResponse[] = [
                        'user' => $team->owner,
                        'team' => $team
                    ];
                }

                return response()->json($customResponse);
            } else {
                return response()->json($tenants->toArray());
            }
        }

        return response()->json();
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function store(StoreUserRequest $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::create($request->except('tenant_parent_id'));
        $user->roles()->sync($request->input('roles', []));

        $tenant = Tenant::with('user', 'team')->where('id', $request->tenant_parent_id)->first();
        if ($tenant) {
            Tenant::create([
                'slug' => Str::random(7),
                'team_id' => $tenant->team_id,
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->update($request->except('tenant_parent_id'));
        $user->roles()->sync($request->input('roles', []));

        $exists = Tenant::with('user', 'team')
            ->where('team_id', $request->tenant_parent_id)
            ->where('user_id', $user->id)
            ->first();

        if ($exists) {
            $user->update([
                'team_id' => $exists->team_id
            ]);
        } else {
            Tenant::create([
                'slug' => Str::random(7),
                'team_id' => $request->tenant_parent_id,
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('admin.users.index');
    }

    private function getChildTenants($user)
    {
        $tenants = [];
        if ($user) {
            $firstLevel = Tenant::with('user')->where('parent_id', $user->id)->get();
            if ($firstLevel->count() > 0) {
                foreach ($firstLevel as $first) {
                    $secondLevel =  Tenant::with('user')->where('parent_id', $first->user_id)->get();
                    if ($secondLevel->count() > 0) {
                        foreach ($secondLevel as $second) {
                            $thirdLevel = Tenant::with('user')->where('parent_id', $second->user_id)->get();
                            if ($thirdLevel->count() > 0) foreach ($thirdLevel as $third) $tenants[] = $third->user_id;

                            $tenants[] = $second->user_id;
                        }
                    }

                    $tenants[] = $first->user_id;
                }
            }
        }

        return $tenants;
    }

    public function show(User $user, Request $request)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = User::with(['roles'])->whereIn('id', self::getChildTenants($user))
                ->select(sprintf('%s.*', (new User)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at : '';
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });

            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('role_ids', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = $role->id;
                }

                return $labels;
            });

            $table->rawColumns(['placeholder', 'approved', 'roles']);

            return $table->make(true);
        }

        return view('admin.users.show');
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }
}
