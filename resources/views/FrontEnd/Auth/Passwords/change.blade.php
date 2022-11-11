@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.app', ['activePage' => 'password-setting', 'title' => __('パスワード設定')])

@section('content')
    <div class="login-page">
        <div class="container" style="height: auto;">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-10 ml-auto mr-auto">
                    <form class="form" method="post" action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.operator_post_change_password') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$checkExist[0]->id}}">
                        <input type="hidden" name="isOperatorAccount" value="1">
                        <div class="card-page-login card card-main-page card-hidden mb-3">
                            <div class="card-header card-header-rose text-center">
                                <h3 class="card-title"><strong>{{ __('パスワード設定') }}</strong></h3>
                            </div>
                            <div class="card-body">
                                <div class="bmd-form-group {{ $errors->has('password_new') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <label class="col-sm-4 col-form-label mt-3" for="input-password">パスワード<span class="text-danger">*</span></label>
                                        <input type="password" name="password_new" value="{{old('password_new')}}" class="form-control w-60" placeholder="{{ __('パスワード') }}">
                                    </div>
                                    @if ($errors->has('password_new'))
                                        <div class="error text-danger text-error-reset-password" for="password">
                                            <span>{{ $errors->first('password_new') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="bmd-form-group {{ $errors->has('password_confirm') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <label class="col-sm-4 col-form-label mt-3" for="input-password">パスワード確認<span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirm" class="form-control w-60" placeholder="{{ __('パスワード確認') }}">
                                    </div>
                                    @if ($errors->has('password_confirm'))
                                        <div class="error text-danger text-error-reset-password" for="password">
                                            <span>{{ $errors->first('password_confirm') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary button-sm">{{ __('更新') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
