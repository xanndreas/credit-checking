@extends('layouts/layoutMaster')

@section('title', 'Credit Check Approval- Page')

@section('content')
    <div class="row">
        <div class="col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('global.show') }} {{ trans('cruds.creditCheck.title') }} Approval</h5>
                </div>

                <div class="card-body">
                    <table class="table table-responsive table-striped">
                        <tbody>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.dealer') }}
                            </th>
                            <td>
                                {{ $approval->status ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.sales_name') }}
                            </th>
                            <td>
                                {{ $approval->slik }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.product') }}
                            </th>
                            <td>
                                {{ $approval->approver->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.debt_principal') }}
                            </th>
                            <td>
                                {{ $approval->dealer_information->debt_principal }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">
                                {{ trans('cruds.dealerInformation.fields.down_payment') }}
                            </th>
                            <td>
                                {{ $approval->dealer_information->down_payment }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ route('admin.approvals.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>

@endsection
