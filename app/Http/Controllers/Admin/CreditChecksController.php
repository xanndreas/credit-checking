<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDealerInformationRequest;
use App\Http\Requests\StoreCreditCheckRequest;
use App\Http\Requests\StoreDealerInformationRequest;
use App\Http\Requests\UpdateDealerInformationRequest;
use App\Models\AutoPlanner;
use App\Models\Brand;
use App\Models\Dealer;
use App\Models\DealerInformation;
use App\Models\DebtorInformation;
use App\Models\Insurance;
use App\Models\Product;
use App\Models\Tenor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CreditChecksController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('credit_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DealerInformation::with(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information']);

            if (Gate::denies('credit_check_access_super')) {
                $query->whereRelation('debtor_information.auto_planner_information', 'auto_planner_name_id', auth()->user()->id);
            }

            $query->select(sprintf('%s.*', (new DealerInformation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'credit_check_show';
                $editGate = 'credit_check_edit';
                $deleteGate = 'credit_check_delete';
                $crudRoutePart = 'credit-checks';

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
                return $row->dealer ? ($row->dealer_id == DealerInformation::dealer_others_id ?
                    $row->dealer_text : $row->dealer->name) : '';
            });

            $table->editColumn('sales_name', function ($row) {
                return $row->sales_name ? $row->sales_name : '';
            });
            $table->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '';
            });

            $table->addColumn('brand_name', function ($row) {
                return $row->brand ? ($row->brand_id == DealerInformation::brand_others_id ?
                    $row->brand_text : $row->brand->name) : '';
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
                if (!$row->id_photos) {
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

            $table->rawColumns(['actions', 'placeholder', 'insurance', 'dealer', 'tenors', 'id_photos', 'debtor_information']);

            return $table->make(true);
        }

        return view('admin.creditCheck.index');
    }

    public function create()
    {
        abort_if(Gate::denies('credit_check_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealers = Dealer::pluck('name', 'id');

        $products = Product::pluck('name', 'id');

        $brands = Brand::pluck('name', 'id');

        $insurances = Insurance::pluck('name', 'id');

        $tenors = Tenor::pluck('year', 'id');

        return view('admin.creditCheck.create', compact('brands', 'dealers', 'insurances', 'products', 'tenors'));
    }

    public function store(StoreCreditCheckRequest $request)
    {
        abort_if(Gate::denies('credit_check_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autoPlannerStore = AutoPlanner::create($request->only(
            [
                'auto_planner_name_id',
                'type'
            ]
        ));

        if ($autoPlannerStore) {
            $debtorInformationStore = DebtorInformation::create(array_merge($request->only(
                [
                    'debtor_name',
                    'id_type',
                    'id_number',
                    'partner_name',
                    'shareholders',
                    'shareholder_id_number',
                    'guarantor_id_number',
                    'guarantor_name',
                ]
            ),
                [
                    'auto_planner_information_id' => $autoPlannerStore->id
                ]
            ));

            if ($debtorInformationStore) {

                $findBrands = Brand::where('id', $request->brand_id)->first();
                $findDealers = Dealer::where('id', $request->dealer_id)->first();

                $dealerInformationStore = DealerInformation::create(array_merge($request->only(
                    [
                        'sales_name',
                        'product_id',
                        'models',
                        'number_of_units',
                        'otr',
                        'debt_principal',
                        'insurance_id',
                        'down_payment',
                        'tenors_id',
                        'addm_addb',
                        'effective_rates',
                        'debtor_phone',
                        'remarks',
                    ]
                ),
                    [
                        'debtor_information_id' => $debtorInformationStore->id,
                        'dealer_id' => $request->dealer_text == null ? ($findDealers ? $request->dealer_id : DealerInformation::dealer_others_id) : DealerInformation::dealer_others_id,
                        'brand_id' => $request->brand_text == null ? ($findBrands ? $request->brand_id : DealerInformation::brand_others_id) : DealerInformation::brand_others_id,
                        'down_payment' => $request->down_payment_text == null ? $request->down_payment : null,
                        'dealer_text' => $request->dealer_text,
                        'brand_text' => $request->brand_text,
                        'down_payment_text' => $request->down_payment_text,
                    ]
                ));

                foreach ($request->input('id_photos', []) as $file) {
                    $dealerInformationStore->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('id_photos');
                }
            }
        }

        return redirect()->route('admin.home');
    }

    public function edit(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    }

    public function update(UpdateDealerInformationRequest $request, DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function show(DealerInformation $credit_check)
    {
        abort_if(Gate::denies('credit_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $credit_check->load('dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information');

        if ($credit_check->debtor_information) {
            $debtorInformation = $credit_check->debtor_information->load('auto_planner_information');
            if ($debtorInformation->auto_planner_information) {
                $debtorInformation->auto_planner_information->load('auto_planner_name');
            }
        }

        return view('admin.creditCheck.show', compact('credit_check'));
    }

    public function destroy(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealerInformation->delete();

        return back();
    }
}
