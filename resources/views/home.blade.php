@extends('layouts/layoutMaster')

@section('title', 'Credit Checking')


@section('vendor-style')
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/dashboards-ecommerce.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <!-- View sales -->
        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">Here available task</h5>
                            <p class="mb-2">Click button below to start credit checking</p>
                            <a href="javascript:;" class="btn btn-primary">Start </a>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{asset('assets/img/illustrations/card-advance-sale.png')}}" height="140" alt="view sales">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View sales -->
    </div>

@endsection
