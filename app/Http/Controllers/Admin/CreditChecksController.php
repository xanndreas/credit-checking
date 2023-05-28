<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDealerInformationRequest;
use App\Http\Requests\StoreDealerInformationRequest;
use App\Http\Requests\UpdateDealerInformationRequest;
use App\Models\Brand;
use App\Models\Dealer;
use App\Models\DealerInformation;
use App\Models\DebtorInformation;
use App\Models\Insurance;
use App\Models\Product;
use App\Models\Tenor;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CreditChecksController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('dealer_information_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DealerInformation::with(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information'])->select(sprintf('%s.*', (new DealerInformation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'dealer_information_show';
                $editGate      = 'dealer_information_edit';
                $deleteGate    = 'dealer_information_delete';
                $crudRoutePart = 'dealer-informations';

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
            $table->addColumn('dealer_name', function ($row) {
                return $row->dealer ? $row->dealer->name : '';
            });

            $table->editColumn('sales_name', function ($row) {
                return $row->sales_name ? $row->sales_name : '';
            });
            $table->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '';
            });

            $table->addColumn('brand_name', function ($row) {
                return $row->brand ? $row->brand->name : '';
            });

            $table->editColumn('models', function ($row) {
                return $row->models ? $row->models : '';
            });
            $table->editColumn('number_of_units', function ($row) {
                return $row->number_of_units ? $row->number_of_units : '';
            });
            $table->editColumn('otr', function ($row) {
                return $row->otr ? $row->otr : '';
            });
            $table->editColumn('debt_principal', function ($row) {
                return $row->debt_principal ? $row->debt_principal : '';
            });
            $table->addColumn('insurance_name', function ($row) {
                return $row->insurance ? $row->insurance->name : '';
            });

            $table->editColumn('down_payment', function ($row) {
                return $row->down_payment ? $row->down_payment : '';
            });
            $table->addColumn('tenors_year', function ($row) {
                return $row->tenors ? $row->tenors->year : '';
            });

            $table->editColumn('addm_addb', function ($row) {
                return $row->addm_addb ? $row->addm_addb : '';
            });
            $table->editColumn('effective_rates', function ($row) {
                return $row->effective_rates ? $row->effective_rates : '';
            });
            $table->editColumn('debtor_phone', function ($row) {
                return $row->debtor_phone ? $row->debtor_phone : '';
            });
            $table->editColumn('id_photos', function ($row) {
                if (! $row->id_photos) {
                    return '';
                }
                $links = [];
                foreach ($row->id_photos as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });
            $table->addColumn('debtor_information_debtor_name', function ($row) {
                return $row->debtor_information ? $row->debtor_information->debtor_name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'dealer', 'product', 'brand', 'insurance', 'tenors', 'id_photos', 'debtor_information']);

            return $table->make(true);
        }

        return view('admin.dealerInformations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('dealer_information_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealers = Dealer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $brands = Brand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $insurances = Insurance::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tenors = Tenor::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $debtor_informations = DebtorInformation::pluck('debtor_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dealerInformations.create', compact('brands', 'dealers', 'debtor_informations', 'insurances', 'products', 'tenors'));
    }

    public function store(StoreDealerInformationRequest $request)
    {
        $dealerInformation = DealerInformation::create($request->all());

        foreach ($request->input('id_photos', []) as $file) {
            $dealerInformation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('id_photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dealerInformation->id]);
        }

        return redirect()->route('admin.dealer-informations.index');
    }

    public function edit(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealers = Dealer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $brands = Brand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $insurances = Insurance::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tenors = Tenor::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $debtor_informations = DebtorInformation::pluck('debtor_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dealerInformation->load('dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information');

        return view('admin.dealerInformations.edit', compact('brands', 'dealerInformation', 'dealers', 'debtor_informations', 'insurances', 'products', 'tenors'));
    }

    public function update(UpdateDealerInformationRequest $request, DealerInformation $dealerInformation)
    {
        $dealerInformation->update($request->all());

        if (count($dealerInformation->id_photos) > 0) {
            foreach ($dealerInformation->id_photos as $media) {
                if (! in_array($media->file_name, $request->input('id_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $dealerInformation->id_photos->pluck('file_name')->toArray();
        foreach ($request->input('id_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $dealerInformation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('id_photos');
            }
        }

        return redirect()->route('admin.dealer-informations.index');
    }

    public function show(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealerInformation->load('dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information');

        return view('admin.dealerInformations.show', compact('dealerInformation'));
    }

    public function destroy(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealerInformation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDealerInformationRequest $request)
    {
        $dealerInformations = DealerInformation::find(request('ids'));

        foreach ($dealerInformations as $dealerInformation) {
            $dealerInformation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dealer_information_create') && Gate::denies('dealer_information_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DealerInformation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
