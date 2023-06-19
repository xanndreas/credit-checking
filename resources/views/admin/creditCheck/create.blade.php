@extends('layouts/layoutMaster')

@section('title', 'Credit Check')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>

@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

@endsection

@section('page-script')
    <script src="{{asset('assets/js/admin/credit-checking.js')}}"></script>
    <script>
        let uploadedIdPhotosMap = {}
        let uploadedKkPhotosMap = {}
        let uploadedNpwpPhotosMap = {}
        let uploadedOtherPhotosMap = {}

        Dropzone.options.idPhotosDropzone = {
            url: '{{ route('admin.credit-checks.dealer-informations.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 40960,
                height: 40960
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="id_photos[]" value="' + response.name + '">')
                uploadedIdPhotosMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedIdPhotosMap[file.name]
                }
                $('form').find('input[name="id_photos[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($dealerInformation) && $dealerInformation->id_photos)
                let files = {!! json_encode($dealerInformation->id_photos) !!}

                for(let
                i in files
            )
                {
                    let file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="id_photos[]" value="' + file.file_name + '">')
                }

                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    let message = response //dropzone sends it's own error messages in string
                } else {
                    let message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        Dropzone.options.kkPhotosDropzone = {
            url: '{{ route('admin.credit-checks.dealer-informations.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 40960,
                height: 40960
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="kk_photos[]" value="' + response.name + '">')
                uploadedIdPhotosMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedIdPhotosMap[file.name]
                }
                $('form').find('input[name="kk_photos[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($dealerInformation) && $dealerInformation->kk_photos)
                let files = {!! json_encode($dealerInformation->kk_photos) !!}

                for(let
                i in files
            )
                {
                    let file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="kk_photos[]" value="' + file.file_name + '">')
                }

                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    let message = response //dropzone sends it's own error messages in string
                } else {
                    let message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        Dropzone.options.npwpPhotosDropzone = {
            url: '{{ route('admin.credit-checks.dealer-informations.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 40960,
                height: 40960
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="npwp_photos[]" value="' + response.name + '">')
                uploadedIdPhotosMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedIdPhotosMap[file.name]
                }
                $('form').find('input[name="npwp_photos[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($dealerInformation) && $dealerInformation->npwp_photos)
                let files = {!! json_encode($dealerInformation->npwp_photos) !!}

                for(let
                i in files
            )
                {
                    let file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="npwp_photos[]" value="' + file.file_name + '">')
                }

                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    let message = response //dropzone sends it's own error messages in string
                } else {
                    let message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        Dropzone.options.otherPhotosDropzone = {
            url: '{{ route('admin.credit-checks.dealer-informations.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 40960,
                height: 40960
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="other_photos[]" value="' + response.name + '">')
                uploadedIdPhotosMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedIdPhotosMap[file.name]
                }
                $('form').find('input[name="other_photos[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($dealerInformation) && $dealerInformation->other_photos)
                let files = {!! json_encode($dealerInformation->other_photos) !!}

                for(let
                i in files
            )
                {
                    let file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="other_photos[]" value="' + file.file_name + '">')
                }

                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    let message = response //dropzone sends it's own error messages in string
                } else {
                    let message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection

@section('content')

    <!-- Modern -->
    <div class="row">
        <div class="col-12">
            <h5>Credit Check</h5>
        </div>

        <!-- Modern Icons Wizard -->
        <div class="col-12 mb-4">
            <small class="text-light fw-semibold">Please fill information below</small>
            <div class="bs-stepper wizard-icons wizard-modern wizard-modern-icons mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#basic-information">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-icon">
                                <svg viewBox="0 0 54 54">
                                    <use
                                        xlink:href='{{asset('assets/svg/icons/form-wizard-account.svg#wizardAccount')}}'></use>
                                </svg>
                            </span>
                            <span class="bs-stepper-label">Basic Information </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#debtor-candidate-info">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-icon">
                                <svg viewBox="0 0 58 54">
                                    <use
                                        xlink:href='{{asset('assets/svg/icons/form-wizard-personal.svg#wizardPersonal')}}'></use>
                                </svg>
                            </span>
                            <span class="bs-stepper-label">Debtor Candidate Information</span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#loan-info">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-icon">
                                 <svg viewBox="0 0 54 54">
                                    <use
                                        xlink:href='{{asset('assets/svg/icons/form-wizard-address.svg#wizardAddress')}}'></use>
                                 </svg>
                            </span>
                            <span class="bs-stepper-label">Loan Information</span>
                        </button>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <!-- Account Details -->
                    <form enctype="multipart/form-data" id="basic-information-form" action="{{ route('admin.credit-checks.store') }}" method="post" novalidate>
                        @csrf
                        <div id="basic-information" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Auto Planner</h6>
                                <small>Enter Details.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="auto_planner_name_id">{{ trans('cruds.autoPlanner.fields.auto_planner_name') }}</label>

                                    <input type="text" id="auto_planner_names" class="form-control"
                                           value="{{ auth()->user()->name }}" disabled/>

                                    <input type="hidden" id="auto_planner_name_id" name="auto_planner_name_id"
                                           value="{{ auth()->user()->id }}"/>
                                </div>
                                <div class="col-sm-6">
                                    <label class="d-block">{{ trans('cruds.autoPlanner.fields.type') }}</label>
                                    @foreach(App\Models\AutoPlanner::TYPE_RADIO as $key => $label)
                                        <div
                                            class="form-check form-check-inline mt-3 {{ $errors->has('type') ? 'is-invalid' : '' }}">
                                            <input class="form-check-input" type="radio" id="type_{{ $key }}"
                                                   name="type"
                                                   value="{{ $key }}" {{ old('type', '') === (string) $key ? 'checked' : '' }} >
                                            <label class="form-check-label" for="type_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @if($errors->has('type'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('type') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button type="button" class="btn btn-label-secondary btn-prev" disabled><i
                                            class="ti ti-arrow-left me-sm-1"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-next"><span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Info -->
                        <div id="debtor-candidate-info" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Debtor Candidate Information</h6>
                                <small>Enter Candidate Info.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="debtor_name">{{ trans('cruds.debtorInformation.fields.debtor_name') }}</label>
                                    <input class="form-control {{ $errors->has('debtor_name') ? 'is-invalid' : '' }}"
                                           type="text" name="debtor_name" id="debtor_name"
                                           value="{{ old('debtor_name', '') }}" required>
                                    @if($errors->has('debtor_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('debtor_name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        class="required">{{ trans('cruds.debtorInformation.fields.id_type') }}</label>
                                    <select class="form-control {{ $errors->has('id_type') ? 'is-invalid' : '' }}"
                                            name="id_type" id="id_type" required>
                                        <option value
                                                disabled {{ old('id_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\DebtorInformation::ID_TYPE_SELECT as $key => $label)
                                            <option
                                                value="{{ $key }}" {{ old('id_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_type'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_type') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="id_number">{{ trans('cruds.debtorInformation.fields.id_number') }}</label>
                                    <input class="form-control {{ $errors->has('id_number') ? 'is-invalid' : '' }}"
                                           type="number" name="id_number" id="id_number"
                                           value="{{ old('id_number', '') }}"
                                           required>
                                    @if($errors->has('id_number'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_number') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        for="partner_name">{{ trans('cruds.debtorInformation.fields.partner_name') }}</label>
                                    <input class="form-control {{ $errors->has('partner_name') ? 'is-invalid' : '' }}"
                                           type="text" name="partner_name" id="partner_name"
                                           value="{{ old('partner_name', '') }}">
                                    @if($errors->has('partner_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('partner_name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        for="guarantor_id_number">{{ trans('cruds.debtorInformation.fields.guarantor_id_number') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('guarantor_id_number') ? 'is-invalid' : '' }}"
                                        type="number" name="guarantor_id_number" id="guarantor_id_number"
                                        value="{{ old('guarantor_id_number', '') }}">
                                    @if($errors->has('guarantor_id_number'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('guarantor_id_number') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        for="guarantor_name">{{ trans('cruds.debtorInformation.fields.guarantor_name') }}</label>
                                    <input class="form-control {{ $errors->has('guarantor_name') ? 'is-invalid' : '' }}"
                                           type="text" name="guarantor_name" id="guarantor_name"
                                           value="{{ old('guarantor_name', '') }}">
                                    @if($errors->has('guarantor_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('guarantor_name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        for="shareholders">{{ trans('cruds.debtorInformation.fields.shareholders') }}</label>
                                    <input class="form-control {{ $errors->has('shareholders') ? 'is-invalid' : '' }}"
                                           type="text" name="shareholders" id="shareholders"
                                           value="{{ old('shareholders', '') }}">
                                    @if($errors->has('shareholders'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('shareholders') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label
                                        for="shareholder_id_number">{{ trans('cruds.debtorInformation.fields.shareholder_id_number') }}</label>
                                    <input class="form-control {{ $errors->has('shareholder_id_number') ? 'is-invalid' : '' }}"
                                           type="text" name="shareholder_id_number" id="shareholder_id_number"
                                           value="{{ old('shareholder_id_number', '') }}">
                                    @if($errors->has('shareholder_id_number'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('shareholder_id_number') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button type="button" class="btn btn-label-secondary btn-prev"><i
                                            class="ti ti-arrow-left me-sm-1"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-next"><span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- Address -->
                        <div id="loan-info" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Loan Information</h6>
                                <small>Enter Loan Information.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="dealer_id">{{ trans('cruds.dealerInformation.fields.dealer') }}</label>
                                    <select
                                        class="form-select select2 {{ $errors->has('dealer_id') ? 'is-invalid' : '' }}"
                                        name="dealer_id" id="dealer_id" required>
                                        <option value
                                                disabled {{ old('dealer_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach($dealers as $id => $entry)
                                            <option
                                                value="{{ $id }}" {{ old('dealer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('dealer_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dealer_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12 dealer_text-container">
                                    <label class="required"
                                           for="dealer_text">{{ trans('cruds.dealerInformation.fields.dealer_text') }}</label>
                                    <input class="form-control {{ $errors->has('dealer_text') ? 'is-invalid' : '' }}"
                                           type="text" name="dealer_text" id="dealer_text"
                                           value="{{ old('dealer_text', '') }}"
                                           required>
                                    @if($errors->has('dealer_text'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dealer_text') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="sales_name">{{ trans('cruds.dealerInformation.fields.sales_name') }}</label>
                                    <input class="form-control {{ $errors->has('sales_name') ? 'is-invalid' : '' }}"
                                           type="text" name="sales_name" id="sales_name"
                                           value="{{ old('sales_name', '') }}"
                                           required>
                                    @if($errors->has('sales_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sales_name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="product_id">{{ trans('cruds.dealerInformation.fields.product') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                                        name="product_id" id="product_id" required>
                                        <option value
                                                disabled {{ old('product_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>

                                    @foreach($products as $id => $entry)
                                            <option
                                                value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('product_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('product_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="brand_id">{{ trans('cruds.dealerInformation.fields.brand') }}</label>
                                    <select class="form-control select2 {{ $errors->has('brand_id') ? 'is-invalid' : '' }}"
                                            name="brand_id" id="brand_id" required>
                                        <option value
                                                disabled {{ old('brand_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>

                                    @foreach($brands as $id => $entry)
                                            <option
                                                value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('brand_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('brand_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12 brand_text-container">
                                    <label class="required"
                                           for="brand_text">{{ trans('cruds.dealerInformation.fields.brand_text') }}</label>
                                    <input class="form-control {{ $errors->has('brand_text') ? 'is-invalid' : '' }}"
                                           type="text"
                                           name="brand_text" id="brand_text" value="{{ old('brand_text', '') }}" required>
                                    @if($errors->has('brand_text'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('brand_text') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="models">{{ trans('cruds.dealerInformation.fields.models') }}</label>
                                    <input class="form-control {{ $errors->has('models') ? 'is-invalid' : '' }}"
                                           type="text"
                                           name="models" id="models" value="{{ old('models', '') }}" required>
                                    @if($errors->has('models'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('models') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="number_of_units">{{ trans('cruds.dealerInformation.fields.number_of_units') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('number_of_units') ? 'is-invalid' : '' }}"
                                        type="number" name="number_of_units" id="number_of_units"
                                        value="{{ old('number_of_units', '') }}" step="1" required>
                                    @if($errors->has('number_of_units'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('number_of_units') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="otr">{{ trans('cruds.dealerInformation.fields.otr') }}</label>
                                    <input class="form-control {{ $errors->has('otr') ? 'is-invalid' : '' }}"
                                           type="number"
                                           name="otr" id="otr" value="{{ old('otr', '') }}" step="0.01" required>
                                    @if($errors->has('otr'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('otr') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="debt_principal">{{ trans('cruds.dealerInformation.fields.debt_principal') }}</label>
                                    <input class="form-control {{ $errors->has('debt_principal') ? 'is-invalid' : '' }}"
                                           type="text" name="debt_principal" id="debt_principal"
                                           value="{{ old('debt_principal', '') }}" required>
                                    @if($errors->has('debt_principal'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('debt_principal') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="insurance_id">{{ trans('cruds.dealerInformation.fields.insurance') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('insurance_id') ? 'is-invalid' : '' }}"
                                        name="insurance_id" id="insurance_id" required>
                                        <option value
                                                disabled {{ old('insurance_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach($insurances as $id => $entry)
                                            <option
                                                value="{{ $id }}" {{ old('insurance_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('insurance_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('insurance_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="tenors_id">{{ trans('cruds.dealerInformation.fields.tenors') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('tenors_id') ? 'is-invalid' : '' }}"
                                        name="tenors_id" id="tenors_id" required>
                                        <option value
                                                disabled {{ old('tenors_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>

                                    @foreach($tenors as $id => $entry)
                                            <option
                                                value="{{ $id }}" {{ old('tenors_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('tenors_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tenors_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label
                                        for="down_payment">{{ trans('cruds.dealerInformation.fields.down_payment') }}</label>

                                    <select
                                        class="form-control select2 {{ $errors->has('down_payment') ? 'is-invalid' : '' }}"
                                        name="down_payment" id="down_payment" required>
                                        <option value
                                                disabled {{ old('down_payment', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\DealerInformation::DOWN_PAYMENT_SELECT as $key => $label)
                                            <option
                                                value="{{ $key }}" {{ old('down_payment', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('down_payment'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('down_payment') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12 down_payment_text-container">
                                    <label class="required"
                                           for="down_payment_text">{{ trans('cruds.dealerInformation.fields.down_payment_text') }}</label>
                                    <input class="form-control {{ $errors->has('down_payment_text') ? 'is-invalid' : '' }}"
                                           type="number" name="down_payment_text" id="down_payment_text"
                                           value="{{ old('down_payment_text', '') }}"
                                           required>
                                    @if($errors->has('down_payment_text'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('down_payment_text') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="addm_addb">{{ trans('cruds.dealerInformation.fields.addm_addb') }}</label>
                                    <input class="form-control {{ $errors->has('addm_addb') ? 'is-invalid' : '' }}"
                                           type="text" name="addm_addb" id="addm_addb"
                                           value="{{ old('addm_addb', '') }}"
                                           required>
                                    @if($errors->has('addm_addb'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('addm_addb') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <label class="required"
                                           for="effective_rates">{{ trans('cruds.dealerInformation.fields.effective_rates') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('effective_rates') ? 'is-invalid' : '' }}"
                                        type="number" name="effective_rates" id="effective_rates"
                                        value="{{ old('effective_rates', '') }}" step="0.01" required>
                                    @if($errors->has('effective_rates'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('effective_rates') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <label class="required"
                                           for="car_year">{{ trans('cruds.dealerInformation.fields.car_year') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('car_year') ? 'is-invalid' : '' }}"
                                        type="number" name="car_year" id="car_year"
                                        value="{{ old('car_year', '') }}" step="0.01" required>
                                    @if($errors->has('car_year'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('car_year') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="required"
                                           for="debtor_phone">{{ trans('cruds.dealerInformation.fields.debtor_phone') }}</label>
                                    <input class="form-control {{ $errors->has('debtor_phone') ? 'is-invalid' : '' }}"
                                           type="text" name="debtor_phone" id="debtor_phone"
                                           value="{{ old('debtor_phone', '') }}" required>
                                    @if($errors->has('debtor_phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('debtor_phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="remarks">{{ trans('cruds.dealerInformation.fields.remarks') }}</label>
                                    <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}"
                                           type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}">
                                    @if($errors->has('remarks'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('remarks') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="id_photos">{{ trans('cruds.dealerInformation.fields.id_photos') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('id_photos') ? 'is-invalid' : '' }}"
                                         id="id_photos-dropzone">
                                    </div>
                                    @if($errors->has('id_photos'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_photos') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="kk_photos">{{ trans('cruds.dealerInformation.fields.kk_photos') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('kk_photos') ? 'is-invalid' : '' }}"
                                         id="kk_photos-dropzone">
                                    </div>
                                    @if($errors->has('kk_photos'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('kk_photos') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="npwp_photos">{{ trans('cruds.dealerInformation.fields.npwp_photos') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('npwp_photos') ? 'is-invalid' : '' }}"
                                         id="npwp_photos-dropzone">
                                    </div>
                                    @if($errors->has('npwp_photos'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('npwp_photos') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <label class="required"
                                           for="other_photos">{{ trans('cruds.dealerInformation.fields.other_photos') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('other_photos') ? 'is-invalid' : '' }}"
                                         id="other_photos-dropzone">
                                    </div>
                                    @if($errors->has('other_photos'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('other_photos') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button type="button" class="btn btn-label-secondary btn-prev"><i
                                            class="ti ti-arrow-left me-sm-1"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Modern Icons Wizard -->
    </div>
@endsection
