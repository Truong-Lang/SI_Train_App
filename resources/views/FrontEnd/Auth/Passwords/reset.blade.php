@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.app', ['activePage' => 'forgot_password', 'title' => __('パスワードリセット')])

@section('content')
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_message')
    <div class="login-page">
        <div class="container" style="height: auto;">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-10 ml-auto mr-auto">
                    <form class="form" method="post" action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.auth.check_mail') }}">
                        @csrf
                        <div class="card-page-login card card-main-page card-hidden mb-3">
                            <div class="card-header card-header-rose text-center">
                                <h3 class="card-title"><strong>{{ __('パスワードリセット') }}</strong></h3>
                            </div>
                            <div class="card-body">
                                <div class="mr-auto ml-4 mt-5">
                                    {{ __('アカウントに関連付けられているメールアドレスを入力してください。') }}
                                </div>
                                <div class="bmd-form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                          </span>
                                        </div>
                                        <input type="text" name="email" class="form-control w-80"
                                               value="{{!empty(old('email')) ? old('email') : ''}}"
                                               placeholder="{{ __('メールアドレス') }}" >

                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="error text-danger text-error" for="password">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer justify-content-center mt-4">
                                <button type="submit" is="btnConfirm" class="btn btn-primary button-sm btn-load">{{ __('確認') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
