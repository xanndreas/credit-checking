<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTenorRequest;
use App\Http\Requests\StoreTenorRequest;
use App\Http\Requests\UpdateTenorRequest;
use App\Models\Tenor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TenorsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('tenor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Tenor::query()->select(sprintf('%s.*', (new Tenor)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'tenor_show';
                $editGate      = 'tenor_edit';
                $deleteGate    = 'tenor_delete';
                $crudRoutePart = 'tenors';

                return view('partials.datatablesActions', compact(
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
            $table->editColumn('year', function ($row) {
                return $row->year ? $row->year : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.tenors.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tenor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tenors.create');
    }

    public function store(StoreTenorRequest $request)
    {
        $tenor = Tenor::create($request->all());

        return redirect()->route('admin.tenors.index');
    }

    public function edit(Tenor $tenor)
    {
        abort_if(Gate::denies('tenor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tenors.edit', compact('tenor'));
    }

    public function update(UpdateTenorRequest $request, Tenor $tenor)
    {
        $tenor->update($request->all());

        return redirect()->route('admin.tenors.index');
    }

    public function show(Tenor $tenor)
    {
        abort_if(Gate::denies('tenor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tenors.show', compact('tenor'));
    }

    public function destroy(Tenor $tenor)
    {
        abort_if(Gate::denies('tenor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenor->delete();

        return back();
    }

    public function massDestroy(MassDestroyTenorRequest $request)
    {
        $tenors = Tenor::find(request('ids'));

        foreach ($tenors as $tenor) {
            $tenor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
