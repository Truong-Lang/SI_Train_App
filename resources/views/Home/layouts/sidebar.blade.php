<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 primary-sidebar sticky-sidebar">
    <div class="widget-area mb-5">
        <div class="sidebar-widget">
            <h6 class="widget-header widget-header-style-4 mb-20 text-center text-uppercase border-top-1 border-bottom-1 pt-2 pb-2">
                <span>{{ __('BÀI VIẾT CÙNG CHUYÊN MỤC') }}</span>
            </h6>
        </div>
        <div>
            <ul class="list-group list-group-flush">
                @foreach($listNews as $key=>$value)
                    <li class="list-group-item {{ request()->newsAlias == $value->alias ? 'list-group-item-dark' : '' }} pl-1 pr-0 ">
                        <a href="{{ route(\App\Common\Constant::FOLDER_URL_HOME . '.index', [$category->alias, $value->alias]) }}">
                            {{ $loop->iteration  . ': ' . $value->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>