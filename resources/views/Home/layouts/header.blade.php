<header class="main-header header-style-2 header-sticky">
    <div class="container pt-30 pb-30 position-relative text-center header-top">
        <div class="logo-text">
            <h1 class="logo text-uppercase d-md-inline d-none">
                <a href="#">
                    <img src="{{ url('img/logoIDS.png') }}" alt="IDS Vietnam"/>
                </a>
            </h1>
            <p class="head-line font-heading text-muted d-none d-lg-block">IDS Vietnam</p>
        </div>
    </div>
    <div class="main-navigation text-center text-uppercase font-heading">
        <div class="container">
            <div class="horizontal-divider-black"></div>
        </div>
        <div class="main-nav d-none d-lg-block">
            <nav>
                <ul class="main-menu d-none d-lg-inline">
                    @foreach($listCategories as $key=>$value)
                        <li><a class="{{ $category && $value->id == $category->id ? 'active' : '' }}"
                               href="{{ route(\App\Common\Constant::FOLDER_URL_HOME . '.index', $value->alias) }}">{{ $value->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="container">
            <div class="horizontal-divider-black mb-1px"></div>
        </div>
        <div class="container">
            <div class="horizontal-divider-black"></div>
        </div>
    </div>
</header>