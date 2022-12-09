@extends(\App\Common\Constant::FOLDER_URL_FRONTEND . '.layouts.app')

@section('content')
    <main class="mt-30">
        <div class="container">
            <div class="row vertical-divider">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 single-content">
                    <div class="entry-header mb-30">
                        <h1 class="entry-title mb-30 font-weight-500">
                            @foreach($listNews as $key=>$value)
                                @if($getNews->id == $value->id)
                                    {{ $loop->iteration . ': ' . $getNews->title }}
                                @endif
                            @endforeach
                        </h1>
                    </div>
                    <article class="mb-50">
                        <div class="entry-main-content">
                            <div class="content dropcap">
                                {{ $getNews->description }}
                                {!! $getNews->content !!}
                            </div>
                        </div>
                    </article>
                </div>
                @include(\App\Common\Constant::FOLDER_URL_FRONTEND . '.layouts.navbars.sidebar')
            </div>
        </div>
    </main>
@endsection