@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.app', ['activePage' => 'change', 'title' => __('Change password')])

@section('content')
    <div class="login-page">
        <div class="container">
            <div class="col-md-7 col-sm-8 ml-auto mr-auto flash-message message">
                @if(session()->has('messageSaveFail'))
                    <p class="alert alert-danger">{{session()->get('messageSaveFail') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </p>
                @endif
            </div> <!-- end .flash-message -->
            <div class="row align-items-center">
                <div class="col-md-7 col-sm-8 ml-auto mr-auto">
                    <form action="{{route('ProstockAdmin.auth.post_change_password')}}" method="post">
                        {{ @csrf_field() }}
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                    <i class="material-icons">lock</i>
                                </div>
                                <h4 class="card-title">{{ __('Change password') }}</h4>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label" for="input-current-password">{{ __('Current Password') }}</label>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input class="form-control{{ isset($messages['password_old'][0]) ? ' is-invalid' : '' }}" input type="password" name="password_old" id="input-current-password" placeholder="{{ __('Current Password') }}" value="{{isset($valListRequest['password_old']) ? $valListRequest['password_old'] : ''}}"/>
                                            <span class="text-danger">{{ isset($messages['password_old'][0]) ? $messages['password_old'][0] : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label" for="input-password">{{ __('New Password') }}</label>
                                    <div class="col-sm-8">
                                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <input class="form-control{{isset($messages['password_new'][0]) ? ' is-invalid' : '' }}" name="password_new" id="input-password" type="password" placeholder="{{ __('New Password') }}" value="{{isset($valListRequest['password_new']) ? $valListRequest['password_new'] : ''}}"/>
                                            <span class="text-danger">{{ isset($messages['password_new'][0]) ? $messages['password_new'][0] : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input class="form-control{{isset($messages['password_new_confirmation'][0]) ? ' is-invalid' : '' }}" name="password_new_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm New Password') }}" value="{{isset($valListRequest['password_new_confirmation']) ? $valListRequest['password_new_confirmation'] : ''}}"/>
                                            <span class="text-danger">{{ isset($messages['password_new_confirmation'][0]) ? $messages['password_new_confirmation'][0] : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-rose">{{ __('Change password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
