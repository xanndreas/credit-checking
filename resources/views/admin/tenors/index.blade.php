@extends('layouts/layoutMaster')

@section('title', 'Tenor List - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/admin/tenors.js')}}"></script>
    <script src="{{asset('assets/js/forms-selects.js')}}"></script>
@endsection


@section('content')

    <!-- Tenors List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Tenors</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-tenors table border-top table-hover datatable-Tenor">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.tenor.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.tenor.fields.year') }}
                    </th>
                    <th class="w-px-18">
                        {{ trans('global.actions') }}
                    </th>
                </tr>
                </thead>
            </table>
        </div>
        @include('admin/tenors/form')
    </div>
@endsection

