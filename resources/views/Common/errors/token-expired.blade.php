@extends(''.\App\Common\Constant::FOLDER_URL_FRONTEND.'.app', ['activePage' => 'token-expired', 'titlePage' => __('message.TOKEN_EXPIRED')])

@section('content')
    <div id="app">
        <div class="container homepage">
            <div class="row wrapper">
                <div class="col-md-12 container-full">
                    <div class="errors errors_token">
                        <p class="errors-msg">リンクの有効期限が切れました。</p>
                        <p class="errors-msg">お手数ですが<a href='{{route(\App\Common\Constant::FOLDER_URL_FRONTEND . '.enquiry_non_member_initial_display')}}'>こちら</a>よりお問い合わせください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
