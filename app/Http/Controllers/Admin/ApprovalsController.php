<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Models\Approval;
use App\Models\DealerInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ApprovalsController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('approval_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $query = DealerInformation::with(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information']);

            if (Gate::denies('approval_approve_request')) {
                $query->whereRelation('debtor_information.auto_planner_information', 'auto_planner_name_id', auth()->user()->id);
            }

            $query->select(sprintf('%s.*', (new DealerInformation)->table));

            $table = Datatables::eloquent($query);


            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'approval_show';
                $editGate = 'approval_edit';
                $deleteGate = 'approval_delete';

                $crudRoutePart = 'approvals';

                $otherDetailGate = 'approval_show';
                $otherDetailUrl = 'javascript:void(0);';

                $approvals = Approval::with('dealer_information')
                    ->where('dealer_information_id', $row->id)->first();

                if ($approvals) {
                    $row = $approvals;

                    $otherDetailGate = 'approval_show';
                    $otherDetailUrl = route('admin.approvals.show', ['approval' => $approvals->id]);
                }

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


            $table->editColumn('status', function ($row) {
                $approvals = null;
                if ($row) {
                    $approvals = Approval::with('dealer_information')
                        ->where('dealer_information_id', $row->id)->first();
                }

                $approveGate = 'approval_approve_request';

                return view('admin.approvals._partials.approveActions', compact(
                    'approveGate',
                    'approvals',
                    'row'
                ));
            });

            $table->addColumn('dealer_information_id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->addColumn('dealer_name', function ($row) {
                return $row->dealer ? ($row->dealer_id == DealerInformation::dealer_others_id ?
                    $row->dealer_text : $row->dealer->name) : '';
            });

            $table->editColumn('sales_name', function ($row) {
                return $row->sales_name ? $row->sales_name : '';
            });

            $table->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '';
            });

            $table->editColumn('otr', function ($row) {
                return $row->otr ? $row->otr : '';
            });

            $table->editColumn('debt_principal', function ($row) {
                return $row->debt_principal ? $row->debt_principal : '';
            });

            $table->editColumn('down_payment', function ($row) {
                return $row->down_payment ? $row->down_payment : '';
            });

            $table->addColumn('tenors_year', function ($row) {
                return $row->tenors ? $row->tenors->year : '';
            });

            $table->editColumn('debtor_phone', function ($row) {
                return $row->debtor_phone ? $row->debtor_phone : '';
            });

            $table->addColumn('debtor_information_debtor_name', function ($row) {
                return $row->debtor_information ? $row->debtor_information->debtor_name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.approvals.index');
    }

    public function approve(Request $request)
    {
        if ($request->has('dealer_information_id') && $request->has('status')) {
            Approval::create([
                'status' => $request->status,
                'slik' => $request->has('slik') ? $request->slik : '',
                'approval_user_id' => Auth::id(),
                'dealer_information_id' => $request->dealer_information_id,
            ]);
        }

        return redirect()->back();
    }

    public function create()
    {
        abort_if(Gate::denies('approval_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.approvals.create');
    }

    public function store(StoreApprovalRequest $request)
    {
        $approval = Approval::create($request->all());

        return redirect()->route('admin.approvals.index');
    }

    public function edit(Approval $approval)
    {
        abort_if(Gate::denies('approval_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.approvals.edit', compact('approval'));
    }

    public function update(UpdateApprovalRequest $request, Approval $approval)
    {
        $approval->update($request->all());

        return redirect()->route('admin.approvals.index');
    }

    public function show(Approval $approval)
    {
        abort_if(Gate::denies('approval_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $approval->load('dealer_information', 'approver');

        return view('admin.approvals.show', compact('approval'));
    }

    public function destroy(Approval $approval)
    {
        abort_if(Gate::denies('approval_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $approval->delete();

        return back();
    }

}
