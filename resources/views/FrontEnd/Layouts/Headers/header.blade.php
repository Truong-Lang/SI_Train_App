<nav class="content-header">
    <div class="container-fluid row align-items-center p-0 m-0">
        <div class="logo col-sm-3 col-md-3 col-lg-3 col-xl-2">
            <a href="{{ route(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.top') }}" class="logo-normal">
                <img src="{{ asset('img') }}/logo_new.png">
            </a>
        </div>
        <div class="content-menu col-sm-6 col-md-6 col-lg-6 col-xl-8">
            {{--      <ul class="navbar-nav d-flex flex-row align-items-center">--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/bukken_search" class="global-menu-link">物件検索</a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/tasklist" class="global-menu-link">タスクリスト</a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/advance_materials_submission" class="global-menu-link">事前資料提出</a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/owner_club" class="global-menu-link">オーナー会</a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/complete_guarantee" class="global-menu-link">完成保証</a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item">--}}
            {{--          <a href="/monthly-report-search" class="global-menu-link">着工月次報告</a>--}}
            {{--        </li>--}}
            {{--      </ul>--}}
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-2 d-flex justify-content-end dropdown">
            <button type="button" class="btn dropdown-toggle account-info" data-toggle="dropdown">
                <img src="{{ asset('img') }}/avatar.png" class="avatar">
                 {{ !empty($userName) ? $userName : '' }}
            </button>
            <div class="header-menu-right dropdown-menu dropdown-menu-right">
                @if($headerMenu)
                    @foreach($headerMenu as $items)
                        @if ($items->seq == 2)
                        <a class="dropdown-item"
                           href="{{ route(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ $items->name }}
                        </a>
                        @else
                            <a class="dropdown-item" href="{{ !empty($items->url) ? '/'. \App\Common\Constant::FOLDER_URL_ADMIN_ROUTE . '/' . $items->url : '' }}">{{ $items->name }}</a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
