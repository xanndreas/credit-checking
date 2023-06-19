<!-- Offcanvas to add -->
<div class="offcanvas offcanvas-end {{ $errors->any() ? 'show' : '' }}" tabindex="-1"
     id="offcanvasAddTeam"
     aria-labelledby="offcanvasAddTeamLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddTeamLabel" class="offcanvas-title">Team</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="addNewTeamForm" method="POST"
              action="" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label class="required" for="slug">{{ trans('cruds.team.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text"
                       name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label class="required"
                       for="owner_id">{{ trans('cruds.team.fields.owner_name') }}</label>
                <select
                    class="form-select select2 {{ $errors->has('owner_id') ? 'is-invalid' : '' }}"
                    name="owner_id" id="owner_id" required>
                    <option value
                            disabled {{ old('owner_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($owners as $id => $entry)
                        <option
                            value="{{ $id }}" {{ old('owner_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('owner_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owner_id') }}
                    </div>
                @endif
            </div>

            <a id="submitAddTeam" data-id=""
               class="btn btn-outline-primary waves-effect text-primary me-sm-3 me-1 ">{{ trans('global.save') }}</a>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
