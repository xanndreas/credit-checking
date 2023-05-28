<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInsuranceRequest;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Models\Insurance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('insurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Insurance::query()->select(sprintf('%s.*', (new Insurance)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'insurance_show';
                $editGate      = 'insurance_edit';
                $deleteGate    = 'insurance_delete';
                $crudRoutePart = 'insurances';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.insurances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.insurances.create');
    }

    public function store(StoreInsuranceRequest $request)
    {
        $insurance = Insurance::create($request->all());

        return redirect()->route('admin.insurances.index');
    }

    public function edit(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.insurances.edit', compact('insurance'));
    }

    public function update(UpdateInsuranceRequest $request, Insurance $insurance)
    {
        $insurance->update($request->all());

        return redirect()->route('admin.insurances.index');
    }

    public function show(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.insurances.show', compact('insurance'));
    }

    public function destroy(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurance->delete();

        return back();
    }

    public function massDestroy(MassDestroyInsuranceRequest $request)
    {
        $insurances = Insurance::find(request('ids'));

        foreach ($insurances as $insurance) {
            $insurance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
