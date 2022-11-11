@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.app', ['activePage' => 'login', 'title' => __('ログイン')])

@section('content')
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_message')
  <div class="login-page">
    <div class="container" style="height: auto;">
      <div class="row align-items-center">
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
          <form class="form" method="post" action="{{ url(''.\App\Common\Constant::FOLDER_URL_ADMIN_ROUTE.'') }}">
            @csrf
            <div class="card-page-login card card-main-page card-hidden mb-3">
              <div class="card-header card-header-rose text-center">
                <h3 class="card-title"><strong>{{ __('ログイン') }}</strong></h3>
              </div>
              <div class="card-body">
                <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                      </span>
                    </div>
                    <input type="text" name="email" class="form-control w-80"
                           placeholder="{{ __('メールアドレス') }}"
                           value="{{ old('email') ? old('email') : '' }}">
                  </div>
                  @if ($errors->has('email'))
                    <div class="error text-danger text-error" for="email">
                      <strong>{{ $errors->first('email') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group mt-3">
                  <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                      </span>
                    </div>
                    <input type="password" name="password" id="password"
                           class="form-control w-80" placeholder="{{ __('パスワード') }}"
                           value="{{ old('password') ? old('password') : '' }}">
                  </div>
                  @if ($errors->has('password'))
                    <div class="error text-danger text-error" for="password">
                      <strong>{{ $errors->first('password') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="form-check mr-auto ml-4 mt-3">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('ログインを維持する') }}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div>
                <div class="form-check mr-auto ml-4 mt-3">
                  <a href="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.auth.reset') }}" class="text-primary">
                    {{ __('パスワードをお忘れの方はこちら') }}
                  </a>
                </div>
              </div>
              <div class="card-footer justify-content-center">
                <button type="submit" class="btn btn-primary button-sm">{{ __('ログイン') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
