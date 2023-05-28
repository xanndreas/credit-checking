<!-- Offcanvas to add -->
<div class="offcanvas offcanvas-end {{ $errors->any() ? 'show' : '' }}" tabindex="-1" id="offcanvasAddTenor"
     aria-labelledby="offcanvasAddTenorLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddTenorLabel" class="offcanvas-title">Tenor</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-tenor pt-0" id="addNewTenorForm" method="POST"
              action="" enctype="multipart/form-data" >
            @method('put')
            @csrf
            <div class="mb-3">
                <label class="required" for="year">{{ trans('cruds.tenor.fields.year') }}</label>
                <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="number" name="year" id="year" value="{{ old('year', '') }}" step="1" required>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
            </div>
            <a  id="submitAddTenor" data-id="" class="btn btn-outline-primary waves-effect text-primary me-sm-3 me-1 ">{{ trans('global.save') }}</a>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
