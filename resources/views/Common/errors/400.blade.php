@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'page-400', 'titlePage' => __('探しているページは見つかりませんでした')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <error-404></error-404>
                </div>
            </div>
        </div>
    </div>
@endsection
