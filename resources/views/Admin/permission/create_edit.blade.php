@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'permission', 'titlePage' => $title, 'title' => $title])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">{{ $title }}</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <form method="post" action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.permission.store') }}" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <div class="form-group {{ $errors->has('role_id') ? 'has-danger' : '' }} bmd-form-group">
                                            <div>
                                                <select name="role_id" class="selectpicker" id="select-role"
                                                        data-style="select-with-transition" title="Choose Role">
                                                    <option disabled> Choose Options</option>
                                                    @foreach($roles as $role)
                                                        <option {{ old('role_id') == $role->id || (isset($getPermission->role_id) && $getPermission->role_id == $role->id) ? "selected" : "" }}
                                                                value="{{ $role->id }}">{{ $role->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('role_id'))
                                                <span id="role-id-error" class="error text-danger"
                                                      for="select-role">{{ $errors->first('role_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Permission <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('permission') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="permission" id="input-permission" value="{{ old('permission') ?? $getPermission->permission ?? '' }}">
                                            @if ($errors->has('permission'))
                                                <span id="permission-error" class="error text-danger" for="input-permission">{{ $errors->first('permission') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Active</label>
                                    <div class="col-sm-3 checkbox-radios">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="active" value="1" {{ old('active') || (isset($getPermission->active) && (int)$getPermission->active != \App\Common\Constant::NUMBER_ONE) ? "" : "checked" }} >
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">Submit<div class="ripple-container"></div></button>
                                </div>
                                <input type="hidden" name="id" id="permission_id" value="{{ $getPermission->id ?? '' }}">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection