<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDealerRequest;
use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Models\Dealer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DealerController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('dealer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Dealer::query()->select(sprintf('%s.*', (new Dealer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'dealer_show';
                $editGate      = 'dealer_edit';
                $deleteGate    = 'dealer_delete';
                $crudRoutePart = 'dealers';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('aliases', function ($row) {
                return $row->aliases ? $row->aliases : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.dealers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('dealer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealers.create');
    }

    public function store(StoreDealerRequest $request)
    {
        $dealer = Dealer::create($request->all());

        return redirect()->route('admin.dealers.index');
    }

    public function edit(Dealer $dealer)
    {
        abort_if(Gate::denies('dealer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealers.edit', compact('dealer'));
    }

    public function update(UpdateDealerRequest $request, Dealer $dealer)
    {
        $dealer->update($request->all());

        return redirect()->route('admin.dealers.index');
    }

    public function show(Dealer $dealer)
    {
        abort_if(Gate::denies('dealer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dealers.show', compact('dealer'));
    }

    public function destroy(Dealer $dealer)
    {
        abort_if(Gate::denies('dealer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealer->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealerRequest $request)
    {
        $dealers = Dealer::find(request('ids'));

        foreach ($dealers as $dealer) {
            $dealer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
