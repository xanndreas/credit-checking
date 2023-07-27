@extends('layouts/layoutMaster')

@section('title', 'Survey Reports - Pages')

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/admin/survey-reports.js')}}"></script>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.surveys.reports.store', ['survey' => $survey->id] ) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <h5 class="card-header">
                        Survey Report
                    </h5>

                    <div class="card-body">
                        <div class="survey_address-repeater form-repeater-container mb-3">
                            <div data-repeater-list="survey_address">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-2 mb-0">
                                            <label class="form-label" for="survey_address-1-1">Tipe Alamat</label>
                                            <input type="text" id="survey_address-1-1" name="attribute_1" class="form-control" />
                                        </div>
                                        <div class="mb-3 col-4 mb-0">
                                            <label class="form-label" for="survey_address-1-2">Alamat</label>
                                            <input type="text" id="survey_address-1-2" name="attribute_2" class="form-control" />
                                        </div>
                                        <div class="mb-3 col-4 mb-0">
                                            <label class="form-label" for="survey_address-1-2">Catatan</label>
                                            <input type="text" id="survey_address-1-2" name="attribute_2" class="form-control" />
                                        </div>
                                        <div class="mb-3 col-2 d-flex align-items-center mb-0">
                                            <a class="btn btn-label-danger text-danger mt-4" data-repeater-delete>
                                                <i class="ti ti-x ti-xs me-1"></i>
                                                <span class="align-middle">Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <a class="btn btn-xs text-lightest btn-primary" data-repeater-create>
                                    <i class="ti ti-plus me-1"></i>
                                    <span class="align-middle">Add</span>
                                </a>
                            </div>
                        </div>
                        <div class="document_attachment-repeater form-repeater-container mb-3">
                            <div data-repeater-list="document_attachment">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-2 mb-0">
                                            <label class="form-label" for="document_attachment-1-1">Tipe Dokumen</label>
                                            <input type="text" id="document_attachment-1-1" name="attribute_1" class="form-control" />
                                        </div>
                                        <div class="mb-3 col-8 mb-0">
                                            <label class="form-label" for="document_attachment-1-2">Description</label>
                                            <input type="text" id="document_attachment-1-2" name="attribute_2" class="form-control" />
                                        </div>
                                        <div class="mb-3 col-2 d-flex align-items-center mb-0">
                                            <a class="btn btn-label-danger text-danger mt-4" data-repeater-delete>
                                                <i class="ti ti-x ti-xs me-1"></i>
                                                <span class="align-middle">Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <a class="btn btn-xs text-lightest btn-primary" data-repeater-create>
                                    <i class="ti ti-plus me-1"></i>
                                    <span class="align-middle">Add</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success text-white">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
