<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TeamsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Team::with('owner')->select(sprintf('%s.*', (new Team)->table));
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
            $tenants = Tenant::with('user', 'team', 'parent')
                ->whereRelation('team', 'id', $team->id)->pluck('user_id')->toArray();

            $query = User::with(['roles'])->whereIn('id', $tenants)
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

        return view('admin.teams.show');
    }

    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->delete();

        return back();
    }
}
