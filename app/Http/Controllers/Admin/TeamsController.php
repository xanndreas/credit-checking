<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TeamsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Team::query()->select(sprintf('%s.*', (new Team)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'team_show';
                $editGate = 'team_edit';
                $deleteGate = 'team_delete';
                $otherDetailGate = 'team_show';
                $otherDetailUrl = route('admin.teams.show', ['team' => $row->id]);
                $crudRoutePart = 'teams';

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
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });

            $table->addColumn('owner_name', function ($row) {
                return $row->owner ? $row->owner->name : '';
            });

            $table->editColumn('owner_id', function ($row) {
                return $row->owner ? $row->owner->id : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $owners = User::all()->pluck('name', 'id');

        return view('admin.teams.index', compact('owners'));
    }

    public function create()
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function store(StoreTeamRequest $request)
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team = Team::create($request->all());

        return redirect()->route('admin.teams.index');
    }

    public function edit(Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->update($request->all());

        return redirect()->route('admin.teams.index');
    }

    public function show(Team $team, Request $request)
    {
        abort_if(Gate::denies('team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            if (Gate::allows('tenant_auto_planner') ||
                Gate::allows('tenant_branch_manager') ||
                Gate::allows('tenant_area_manager')) {
                $tenants = self::getChildTenants(Auth::user());
                $user = Auth::user();

                $teamTree = [[
                    'tt_key' => $user->id,
                    'tt_parent' => 0,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'status' => $user->approved == 1 ? 'Active' : 'Inactive',
                    'roles' => $user->roles->first()->title,
                    'children' => []
                ]];
            } else {
                $tenants = Tenant::with('user', 'team', 'parent')
                    ->whereRelation('team', 'id', $team->id)
                    ->pluck('user_id')->toArray();

                $team->load('owner');
                $teamTree = [[
                    'tt_key' => $team->owner->id,
                    'tt_parent' => 0,
                    'name' => $team->owner->name,
                    'email' => $team->owner->email,
                    'email_verified_at' => $team->owner->email_verified_at,
                    'status' => $team->owner->approved == 1 ? 'Active' : 'Inactive',
                    'roles' => $team->owner->roles->first()->title,
                    'children' => []
                ]];
            }

            $users = User::with(['roles'])->whereIn('id', $tenants)->get();
            foreach ($users as $user) {
                $parent = Tenant::with('user')
                    ->where('user_id', $user->id)
                    ->where('parent_id', '!=', null)
                    ->first();

                $teamTree[] = [
                    'tt_key' => $user->id,
                    'tt_parent' => $parent ? $parent->parent_id : 0,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'status' => $user->approved == 1 ? 'Active' : 'Inactive',
                    'roles' => $user->roles->first()->title,
                    'children' => []
                ];
            }

            $teamTreeOrderChild = $this->unflattering($teamTree);
            $teamTreeFlatten = $this->flattenArray($teamTreeOrderChild);

            return response()->json($teamTreeFlatten);
        }

        return view('admin.teams.show');
    }

    private function getChildTenants($user): array
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

    function flattenArray($array, &$result = [])
    {
        foreach ($array as $value) {
            $result[] = array_diff_key($value, array_flip(["children"]));

            if (isset($value['children']) && is_array($value['children'])) {
                $this->flattenArray($value['children'], $result);
            }
        }

        return $result;
    }

    function unflattering($flatArray): array
    {
        $refs = array();
        $result = array();

        while (count($flatArray) > 0) {
            for ($i = count($flatArray) - 1; $i >= 0; $i--) {
                if ($flatArray[$i]["tt_parent"] == 0) {
                    $result[$flatArray[$i]["tt_key"]] = $flatArray[$i];
                    $refs[$flatArray[$i]["tt_key"]] = &$result[$flatArray[$i]["tt_key"]];
                    unset($flatArray[$i]);
                    $flatArray = array_values($flatArray);
                } else if (array_key_exists($flatArray[$i]["tt_parent"], $refs)) {
                    $o = $flatArray[$i];
                    $refs[$flatArray[$i]["tt_key"]] = $o;
                    $refs[$flatArray[$i]["tt_parent"]]["children"][] = &$refs[$flatArray[$i]["tt_key"]];
                    unset($flatArray[$i]);
                    $flatArray = array_values($flatArray);
                }
            }
        }
        return $result;
    }

    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->delete();

        return back();
    }
}
