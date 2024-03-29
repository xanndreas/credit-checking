<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSurveyReportRequest;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Approval;
use App\Models\Survey;
use App\Models\SurveyReport;
use App\Models\SurveyReportAttribute;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SurveysController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {

        abort_if(Gate::denies('survey_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Survey::with('office_surveyors');

            if (Gate::allows('survey_surveyors') && Gate::denies('credit_check_access_super')) {
                $query->whereRelation('office_surveyors', 'id', Auth::id());
                $query->orWhereRelation('domicile_surveyors', 'id', Auth::id());
                $query->orWhereRelation('guarantor_surveyors', 'id', Auth::id());
            }

            $query->select(sprintf('%s.*', (new Survey)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('report_actions', '&nbsp;');
            $table->addColumn('office_surveyor_ids', '&nbsp;');
            $table->addColumn('domicile_surveyor_ids', '&nbsp;');
            $table->addColumn('guarantor_ids', '&nbsp;');
            $table->addColumn('requester_name', '&nbsp;');

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

            $table->editColumn('report_actions', function ($row) {
                $survey = $row;
                $surveyReports = SurveyReport::with('survey')
                    ->where('survey_id', $row->id)->first();

                return view('admin.surveys.reports._partials.reportActions', compact('surveyReports', 'survey'));
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
            $table->editColumn('requester_name', function ($row) {
                return $row->requester ? $row->requester->name : '';
            });

            $table->editColumn('office_surveyors', function ($row) {
                $labels = [];

                $row->load('office_surveyors');
                foreach ($row->office_surveyors as $office_surveyor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $office_surveyor->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('office_surveyor_ids', function ($row) {
                $labels = [];

                $row->load('office_surveyors');
                foreach ($row->office_surveyors as $office_surveyor) {
                    $labels[] = $office_surveyor->id;
                }

                return $labels;
            });

            $table->editColumn('domicile_surveyors', function ($row) {
                $labels = [];

                $row->load('domicile_surveyors');
                foreach ($row->domicile_surveyors as $domicile_surveyor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $domicile_surveyor->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('domicile_surveyor_ids', function ($row) {
                $labels = [];

                $row->load('domicile_surveyors');
                foreach ($row->domicile_surveyors as $domicile_surveyor) {
                    $labels[] = $domicile_surveyor->id;
                }

                return $labels;
            });

            $table->editColumn('guarantor_surveyors', function ($row) {
                $labels = [];

                $row->load('guarantor_surveyors');
                foreach ($row->guarantor_surveyors as $guarantor_surveyor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $guarantor_surveyor->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('guarantor_surveyor_ids', function ($row) {
                $labels = [];

                $row->load('guarantor_surveyors');
                foreach ($row->guarantor_surveyors as $guarantor_surveyor) {
                    $labels[] = $guarantor_surveyor->id;
                }

                return $labels;
            });

            $table->rawColumns(['actions', 'placeholder', 'office_surveyors', 'report_actions', 'domicile_surveyors', 'guarantor_surveyors']);

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
                if ($approval->status == 'Approved') return true;
                elseif ($approval->status == 'Rejected' && $approval->slik != null) return true;
                else return false;
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

        if ($request->has('office_surveyors')) {
            $survey->office_surveyors()->sync($request->input('office_surveyors', []));
        }

        if ($request->has('domicile_surveyors')) {
            $survey->domicile_surveyors()->sync($request->input('domicile_surveyors', []));
        }

        if ($request->has('guarantor_surveyors')) {
            $survey->guarantor_surveyors()->sync($request->input('guarantor_surveyors', []));
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

        if ($request->has('office_surveyors')) {
            $survey->office_surveyors()->sync($request->input('office_surveyors', []));
        }

        if ($request->has('domicile_surveyors')) {
            $survey->domicile_surveyors()->sync($request->input('domicile_surveyors', []));
        }

        if ($request->has('guarantor_surveyors')) {
            $survey->guarantor_surveyors()->sync($request->input('guarantor_surveyors', []));
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

    public function createReports(Survey $survey)
    {
        return view('admin.surveys.reports.form', compact('survey'));
    }

    public function storeReports(Survey $survey, StoreSurveyReportRequest $request)
    {
        $surveyReportStore = SurveyReport::create(array_merge($request->only(
            [
                'parking_access',
                'owner_status',
                'owner_beneficial',
                'office_note',
                'office_note',
            ]
        ),
            [
                'survey_id' => $survey->id,
                'surveyor_id' => Auth::id(),
            ]
        ));

        $surveyAttributeId = [];

        if ($request->has('survey_address')) {
            foreach ($request->survey_address as $survey_address) {
                $createSurveyAttribute = SurveyReportAttribute::create(array_merge($survey_address, ['object_name' => 'survey_address']));
                if ($createSurveyAttribute) {
                    $surveyAttributeId[] = $createSurveyAttribute->id;
                }
            }
        }

        if ($request->has('document_attachment')) {
            foreach ($request->document_attachment as $document_attachment) {
                $createSurveyAttribute = SurveyReportAttribute::create(array_merge($document_attachment, ['object_name' => 'document_attachment']));
                if ($createSurveyAttribute) {
                    $surveyAttributeId[] = $createSurveyAttribute->id;
                }
            }

        }
        if ($request->has('environmental_check')) {
            foreach ($request->environmental_check as $environmental_check) {
                $createSurveyAttribute = SurveyReportAttribute::create(array_merge($environmental_check, ['object_name' => 'environmental_check']));
                if ($createSurveyAttribute) {
                    $surveyAttributeId[] = $createSurveyAttribute->id;
                }
            }
        }

        if ($request->has('note')) {
            foreach ($request->note as $note) {
                $createSurveyAttribute = SurveyReportAttribute::create(array_merge($note, ['object_name' => 'note']));
                if ($createSurveyAttribute) {
                    $surveyAttributeId[] = $createSurveyAttribute->id;
                }
            }
        }

        if ($request->has('incomplete_document')) {
            foreach ($request->incomplete_document as $incomplete_document) {
                $createSurveyAttribute = SurveyReportAttribute::create(array_merge($incomplete_document, ['object_name' => 'incomplete_document']));
                if ($createSurveyAttribute) {
                    $surveyAttributeId[] = $createSurveyAttribute->id;
                }
            }
        }

        $surveyReportStore->survev_report_attributes()->sync($surveyAttributeId);

        foreach ($request->input('attachments', []) as $file) {
            $surveyReportStore->addMedia(storage_path('tmp/uploads/' . basename($file)))
                ->toMediaCollection('attachments');
        }

        return redirect()->route('admin.surveys.index');
    }

    public function downloadReports(Survey $survey)
    {
        $surveyReport = SurveyReport::with('survev_report_attributes', 'surveyor', 'survey')
            ->where('survey_id', $survey->id)->first();

        if ($surveyReport) {
            $pdf = Pdf::loadView('admin.printTemplates.surveyReport', compact('surveyReport'));
            return $pdf->download('SURVEY-'.$surveyReport->created_at.'.pdf');
        }

        return response(null, Response::HTTP_NOT_FOUND);
    }
}
