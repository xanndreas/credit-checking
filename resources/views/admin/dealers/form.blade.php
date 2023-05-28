<!-- Offcanvas to add -->
<div class="offcanvas offcanvas-end {{ $errors->any() ? 'show' : '' }}" tabindex="-1" id="offcanvasAddDealer"
     aria-labelledby="offcanvasAddDealerLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddDealerLabel" class="offcanvas-title">Dealer</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-dealer pt-0" id="addNewDealerForm" method="POST"
              action="" enctype="multipart/form-data" >
            @method('put')
            @csrf
            <div class="mb-3">
                <label class="required" for="name">{{ trans('cruds.dealer.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label for="aliases">{{ trans('cruds.dealer.fields.aliases') }}</label>
                <input class="form-control {{ $errors->has('aliases') ? 'is-invalid' : '' }}" type="text" name="aliases" id="aliases" value="{{ old('aliases', '') }}">
                @if($errors->has('aliases'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aliases') }}
                    </div>
                @endif
            </div>

            <a  id="submitAddDealer" data-id="" class="btn btn-outline-primary waves-effect text-primary me-sm-3 me-1 ">{{ trans('global.save') }}</a>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
