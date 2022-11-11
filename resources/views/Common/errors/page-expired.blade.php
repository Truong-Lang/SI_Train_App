@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'page-expired', 'titlePage' => __('タイムアウトしました。前の画面に戻り、再度操作をやり直してください。')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <errors error-msg="{{ \Illuminate\Support\Facades\Lang::get('message.PAGE_EXPIRED')}}"></errors>
                </div>
            </div>
        </div>
    </div>
@endsection
