<!-- Offcanvas to add -->
<div class="offcanvas offcanvas-end {{ $errors->any() ? 'show' : '' }}" tabindex="-1" id="offcanvasAddYear"
     aria-labelledby="offcanvasAddYearLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddYearLabel" class="offcanvas-title">Year</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-year pt-0" id="addNewYearForm" method="POST"
              action="" enctype="multipart/form-data" >
            @method('put')
            @csrf
            <div class="mb-3">
                <label class="required" for="title">{{ trans('cruds.year.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            <a  id="submitAddYear" data-id="" class="btn btn-outline-primary waves-effect text-primary me-sm-3 me-1 ">{{ trans('global.save') }}</a>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
