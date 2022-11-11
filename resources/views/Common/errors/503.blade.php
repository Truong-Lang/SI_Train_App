@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'page-503', 'titlePage' => __('503エラー')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <errors error-msg="{{ \Illuminate\Support\Facades\Lang::get('message.PAGE_503')}}"></errors>
                </div>
            </div>
        </div>
    </div>
@endsection
