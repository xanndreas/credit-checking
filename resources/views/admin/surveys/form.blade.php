<!-- Offcanvas to add -->
<div class="offcanvas offcanvas-end {{ $errors->any() ? 'show' : '' }}" tabindex="-1" id="offcanvasAddSurvey"
     aria-labelledby="offcanvasAddSurveyLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddSurveyLabel" class="offcanvas-title">Survey</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-survey pt-0" id="addNewSurveyForm" method="POST"
              action="" enctype="multipart/form-data">
            @method('put')
            @csrf
            <input type="hidden" name="requester_id" value="{{ auth()->id() }}">
            <div class="mb-3">
                <label class="required"
                       for="domicile_address">{{ trans('cruds.survey.fields.domicile_address') }}</label>
                <textarea class="form-control {{ $errors->has('domicile_address') ? 'is-invalid' : '' }}"
                          name="domicile_address" id="domicile_address" required></textarea>
                @if($errors->has('domicile_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('domicile_address') }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="required" for="office_address">{{ trans('cruds.survey.fields.office_address') }}</label>
                <textarea class="form-control {{ $errors->has('office_address') ? 'is-invalid' : '' }}"
                          name="office_address" id="office_address" required></textarea>
                @if($errors->has('office_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('office_address') }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="required"
                       for="guarantor_address">{{ trans('cruds.survey.fields.guarantor_address') }}</label>
                <textarea class="form-control {{ $errors->has('guarantor_address') ? 'is-invalid' : '' }}"
                          name="guarantor_address" id="guarantor_address" required></textarea>
                @if($errors->has('guarantor_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('guarantor_address') }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="required" for="approval_id">Approval ID / Debtor Name</label>
                <select class="form-control select2 {{ $errors->has('approval_id') ? 'is-invalid' : '' }}"
                        name="approval_id" id="approval_id" required>
                    @foreach($approvals as $id => $val)
                        <option
                            value="{{ $val->id }}" {{ in_array($val->id, old('approval_id', [])) ? 'selected' : '' }}>{{ $val->dealer_information->debtor_information->debtor_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('approval_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('approval_id') }}
                    </div>
                @endif
            </div>

            @can('survey_assign_surveyors')
                <div class="mb-3">
                    <label class="required" for="office_surveyors">Office Surveyors</label>
                    <select multiple class="form-control select2 {{ $errors->has('office_surveyors') ? 'is-invalid' : '' }}"
                            name="office_surveyors[]" id="office_surveyors" required>
                        @foreach($surveyor as $id => $val)
                            <option
                                value="{{ $val->id }}" {{ in_array($val->id, old('office_surveyors', [])) ? 'selected' : '' }}>{{ $val->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('office_surveyors'))
                        <div class="invalid-feedback">
                            {{ $errors->first('office_surveyors') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="required" for="domicile_surveyors">Surveyors</label>
                    <select multiple class="form-control select2 {{ $errors->has('domicile_surveyors') ? 'is-invalid' : '' }}"
                            name="domicile_surveyors[]" id="domicile_surveyors" required>
                        @foreach($surveyor as $id => $val)
                            <option
                                value="{{ $val->id }}" {{ in_array($val->id, old('domicile_surveyors', [])) ? 'selected' : '' }}>{{ $val->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('domicile_surveyors'))
                        <div class="invalid-feedback">
                            {{ $errors->first('domicile_surveyors') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="required" for="guarantor_surveyors">Surveyors</label>
                    <select multiple class="form-control select2 {{ $errors->has('guarantor_surveyors') ? 'is-invalid' : '' }}"
                            name="guarantor_surveyors[]" id="guarantor_surveyors" required>
                        @foreach($surveyor as $id => $val)
                            <option
                                value="{{ $val->id }}" {{ in_array($val->id, old('guarantor_surveyors', [])) ? 'selected' : '' }}>{{ $val->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('guarantor_surveyors'))
                        <div class="invalid-feedback">
                            {{ $errors->first('guarantor_surveyors') }}
                        </div>
                    @endif
                </div>
            @endcan

            <a id="submitAddSurvey" data-id=""
               class="btn btn-outline-primary waves-effect text-primary me-sm-3 me-1 ">{{ trans('global.save') }}</a>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
