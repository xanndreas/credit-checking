@extends('layouts/layoutMaster')

@section('title', 'Credit Check - Page')

@section('content')
    <div class="row">
        <div class="col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('global.show') }} {{ trans('cruds.creditCheck.title') }}</h5>
                </div>

                <div class="card-body">
                    <table class="table table-responsive table-striped">
                        <tbody>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.dealer') }}
                            </th>
                            <td>
                                {{ $credit_check->dealer->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.sales_name') }}
                            </th>
                            <td>
                                {{ $credit_check->sales_name }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.product') }}
                            </th>
                            <td>
                                {{ $credit_check->product->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.brand') }}
                            </th>
                            <td>
                                {{ $credit_check->brand->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.models') }}
                            </th>
                            <td>
                                {{ $credit_check->models }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.number_of_units') }}
                            </th>
                            <td>
                                {{ $credit_check->number_of_units }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.otr') }}
                            </th>
                            <td>
                                {{ $credit_check->otr }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.debt_principal') }}
                            </th>
                            <td>
                                {{ $credit_check->debt_principal }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.insurance') }}
                            </th>
                            <td>
                                {{ $credit_check->insurance->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.down_payment') }}
                            </th>
                            <td>
                                {{ $credit_check->down_payment }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.tenors') }}
                            </th>
                            <td>
                                {{ $credit_check->tenors->year ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.addm_addb') }}
                            </th>
                            <td>
                                {{ $credit_check->addm_addb }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.effective_rates') }}
                            </th>
                            <td>
                                {{ $credit_check->effective_rates }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.debtor_phone') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_phone }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.id_photos') }}
                            </th>
                            <td>
                                @foreach($credit_check->id_photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl() }}" height="70px">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.kk_photos') }}
                            </th>
                            <td>
                                @foreach($credit_check->kk_photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl() }}" height="70px">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.npwp_photos') }}
                            </th>
                            <td>
                                @foreach($credit_check->npwp_photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl() }}" height="70px">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.other_photos') }}
                            </th>
                            <td>
                                @foreach($credit_check->other_photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl() }}" height="70px">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.remarks') }}
                            </th>
                            <td>
                                {{ $credit_check->remarks }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.car_year') }}
                            </th>
                            <td>
                                {{ $credit_check->car_year }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.id_type') }}
                            </th>
                            <td>
                                {{ App\Models\DebtorInformation::ID_TYPE_SELECT[$credit_check->debtor_information->id_type] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.id_number') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->id_number }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.partner_name') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->partner_name }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.guarantor_id_number') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->guarantor_id_number }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.guarantor_name') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->guarantor_name }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.shareholders') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->shareholders }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.shareholder_id_number') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->shareholder_id_number }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.debtorInformation.fields.auto_planner_information') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->auto_planner_information->type ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.autoPlanner.fields.auto_planner_name') }}
                            </th>
                            <td>
                                {{ $credit_check->debtor_information->auto_planner_information->auto_planner_name->name ?? '' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ route('admin.credit-checks.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>

@endsection
