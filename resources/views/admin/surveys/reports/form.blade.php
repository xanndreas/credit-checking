@extends('layouts/layoutMaster')

@section('title', 'Survey Reports - Pages')

@section('vendor-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/admin/survey-reports.js')}}"></script>
    <script>
        let uploadedAttachmentsMap = {}

        Dropzone.options.attachmentsDropzone = {
            url: '{{ route('admin.surveys.reports.storeMedia', ['survey' => $survey->id]) }}',
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
                $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
                uploadedAttachmentsMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAttachmentsMap[file.name]
                }
                $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($surveyReport) && $surveyReport->attachments)
                let files = {!! json_encode($surveyReport->attachments) !!}

                for(let
                i in files
            )
                {
                    let file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
                }

                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    let message = response
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
                                            <input type="text" id="survey_address-1-1" name="attribute_1"
                                                   class="form-control"/>
                                        </div>
                                        <div class="mb-3 col-4 mb-0">
                                            <label class="form-label" for="survey_address-1-2">Alamat</label>
                                            <input type="text" id="survey_address-1-2" name="attribute_2"
                                                   class="form-control"/>
                                        </div>
                                        <div class="mb-3 col-4 mb-0">
                                            <label class="form-label" for="survey_address-1-2">Catatan</label>
                                            <input type="text" id="survey_address-1-2" name="attribute_2"
                                                   class="form-control"/>
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
                        <div class="mb-3 col-12 mb-0">
                            <label class="form-label" for="parking_access">parking_access</label>
                            <textarea id="parking_access" name="parking_access"
                                      class="form-control {{ $errors->has('parking_access') ? 'is-invalid' : '' }}"></textarea>
                            @if($errors->has('parking_access'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('parking_access') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 col-12 mb-0">
                            <label class="form-label" for="owner_status">owner_status</label>
                            <textarea id="owner_status" name="owner_status"
                                      class="form-control {{ $errors->has('owner_status') ? 'is-invalid' : '' }}"></textarea>
                            @if($errors->has('owner_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('owner_status') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 col-12 mb-0">
                            <label class="form-label" for="owner_beneficial">owner_beneficial</label>
                            <textarea id="owner_beneficial" name="owner_beneficial"
                                      class="form-control {{ $errors->has('owner_beneficial') ? 'is-invalid' : '' }}"></textarea>
                            @if($errors->has('owner_beneficial'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('owner_beneficial') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 col-12 mb-0">
                            <label class="form-label" for="office_note">office_note</label>
                            <textarea id="office_note" name="office_note"
                                      class="form-control {{ $errors->has('office_note') ? 'is-invalid' : '' }}"></textarea>
                            @if($errors->has('office_note'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('office_note') }}
                                </div>
                            @endif
                        </div>
                        <div class="document_attachment-repeater form-repeater-container mb-3">
                            <div data-repeater-list="document_attachment">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-2 mb-0">
                                            <label class="form-label" for="document_attachment-1-1">Tipe Dokumen</label>
                                            <input type="text" id="document_attachment-1-1" name="attribute_1"
                                                   class="form-control"/>
                                        </div>
                                        <div class="mb-3 col-8 mb-0">
                                            <label class="form-label" for="document_attachment-1-2">Description</label>
                                            <input type="text" id="document_attachment-1-2" name="attribute_2"
                                                   class="form-control"/>
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
                        <div class="environmental_check-repeater form-repeater-container mb-3">
                            <div data-repeater-list="environmental_check">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-2 mb-0">
                                            <label class="form-label" for="environmental_check-1-1">Witness</label>
                                            <input type="text" id="environmental_check-1-1" name="attribute_1"
                                                   class="form-control"/>
                                        </div>
                                        <div class="mb-3 col-8 mb-0">
                                            <label class="form-label" for="environmental_check-1-2">Note</label>
                                            <input type="text" id="environmental_check-1-2" name="attribute_2"
                                                   class="form-control"/>
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
                        <div class="note-repeater form-repeater-container mb-3">
                            <div data-repeater-list="note">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-10 mb-0">
                                            <label class="form-label" for="note-1-1">Notes</label>
                                            <input type="text" id="note-1-1" name="attribute_1" class="form-control"/>
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
                        <div class="incomplete_document-repeater form-repeater-container mb-3">
                            <div data-repeater-list="incomplete_document">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-3 col-2 mb-0">
                                            <label class="form-label" for="incomplete_document-1-1">Types</label>
                                            <input type="text" id="incomplete_document-1-1" name="attribute_1"
                                                   class="form-control"/>
                                        </div>
                                        <div class="mb-3 col-8 mb-0">
                                            <label class="form-label" for="incomplete_document-1-2">Note</label>
                                            <input type="text" id="incomplete_document-1-2" name="attribute_2"
                                                   class="form-control"/>
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
                        <div class="mb-3 col-sm-12">
                            <label class="required"
                                   for="attachments">Attachments</label>
                            <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}"
                                 id="attachments-dropzone">
                            </div>
                            @if($errors->has('attachments'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('attachments') }}
                                </div>
                            @endif
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
