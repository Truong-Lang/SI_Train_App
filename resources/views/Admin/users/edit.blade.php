@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'user', 'titlePage' => $title, 'title' => $title])

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
                            <form method="post" action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.user.store') }}" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">User Name</label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('username') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="username" id="input-username" value="{{ old('username') ?? $getUser->username ?? '' }}" readonly>
                                            @if ($errors->has('username'))
                                                <span id="username-error" class="error text-danger" for="input-username">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('email') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="email" id="input-email" value="{{ old('email') ?? $getUser->email ?? '' }}" readonly>
                                            @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <div class="form-group {{ $errors->has('role_id') ? 'has-danger' : '' }} bmd-form-group">
                                            <div>
                                                <select name="role_id" class="selectpicker" id="select-role"
                                                        data-style="select-with-transition" title="Choose Role">
                                                    <option disabled> Choose Options</option>
                                                    @foreach($roles as $role)
                                                        <option {{ old('role_id') == $role->id || (isset($getUser->role_id) && $getUser->role_id == $role->id) ? "selected" : "" }}
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
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">Submit<div class="ripple-container"></div></button>
                                </div>
                                <input type="hidden" name="id" id="user_id" value="{{ $getUser->id ?? '' }}">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection