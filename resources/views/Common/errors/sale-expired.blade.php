@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'sale-expired', 'titlePage' => __('期限切れ')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <errors error-msg="{{ \Illuminate\Support\Facades\Lang::get('message.SALE_EXPIRED')}}"></errors>
                </div>
            </div>
        </div>
    </div>
@endsection
