@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'server-error', 'titlePage' => __('システムエラー')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <errors error-msg="{{ \Illuminate\Support\Facades\Lang::get('message.TRANSACTION_FAIL')}}"></errors>
                </div>
            </div>
        </div>
    </div>
@endsection
