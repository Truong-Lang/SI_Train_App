<div class="wrapper ">
  @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.navbars.sidebar')
  <div class="main-panel">
    @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.navbars.navs.auth')
    @yield('content')
    @yield('scripts')
    @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.footers.auth')
  </div>
</div>