<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Approval;
use App\Models\Survey;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SurveysController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('survey_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Survey::with(['approval', 'requester', 'surveyors'])
                ->select(sprintf('%s.*', (new Survey)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('surveyor_ids', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'survey_show';
                $editGate = 'survey_edit';
                $deleteGate = 'survey_delete';
                $crudRoutePart = 'surveys';

                return view('_partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('domicile_address', function ($row) {
                return $row->domicile_address ? $row->domicile_address : '';
            });
            $table->editColumn('office_address', function ($row) {
                return $row->office_address ? $row->office_address : '';
            });
            $table->editColumn('guarantor_address', function ($row) {
                return $row->guarantor_address ? $row->guarantor_address : '';
            });
            $table->editColumn('approval_id', function ($row) {
                return $row->approval_id ? $row->approval_id : '';
            });
            $table->editColumn('requester_id', function ($row) {
                return $row->requester_id ? $row->requester_id : '';
            });

            $table->editColumn('surveyors', function ($row) {
                $labels = [];
                foreach ($row->surveyors as $surveyor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $surveyor->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('surveyor_ids', function ($row) {
                $labels = [];
                foreach ($row->surveyors as $surveyor) {
                    $labels[] = $surveyor->id;
                }

                return $labels;
            });

            $table->rawColumns(['actions', 'placeholder', 'surveyors']);

            return $table->make(true);
        }

        $surveyor = User::with('roles')->get()->filter(function ($user) {
            $user->roles->load('permissions');
            $permissions = $user->roles->filter(function ($role) {
                $gett = $role->permissions->filter(function ($permission) {
                    return $permission->title == 'survey_surveyors';
                });

                return count($gett) > 0;
            });

            return count($permissions) > 0;
        });

        $approvals = Approval::with('dealer_information', 'dealer_information.debtor_information')->get()
            ->filter(function ($approval) {
                return $approval->dealer_information != null;
            });

        return view('admin.surveys.index', compact('surveyor', 'approvals'));
    }

    public function create()
    {
        abort_if(Gate::denies('survey_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surveys.create');
    }

    public function store(StoreSurveyRequest $request)
    {
        $survey = Survey::create($request->all());

        if ($request->has('surveyors')) {
            $survey->surveyors()->sync($request->input('surveyors', []));
        }

        return redirect()->route('admin.surveys.index');
    }

    public function edit(Survey $survey)
    {
        abort_if(Gate::denies('survey_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surveys.edit', compact('survey'));
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $survey->update($request->all());

        if ($request->has('surveyors')) {
            $survey->surveyors()->sync($request->input('surveyors', []));
        }

        return redirect()->route('admin.surveys.index');
    }

    public function show(Survey $survey)
    {
        abort_if(Gate::denies('survey_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surveys.show', compact('survey'));
    }

    public function destroy(Survey $survey)
    {
        abort_if(Gate::denies('survey_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $survey->delete();

        return back();
    }
}
