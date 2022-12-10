@extends(\App\Common\Constant::FOLDER_URL_FRONTEND . '.layouts.app')

@section('content')
    <main class="mt-30">
        <div class="container">
            @if($categoryAlias && $listNews->isNotEmpty())
                <div class="archive-header">
                    <h2 class="font-weight-bold"><span class="font-family-normal">{{ $listNews->first()->name }}</span></h2>
                    <span class="line-dots mt-20 mb-20"></span>
                </div>
                <div class="row vertical-divider">
                    <div class="col-lg-12 col-md-12">
                        <div class="mb-30">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <th>Name</th>
                                    <th>Link</th>
                                    </thead>
                                    <tbody>
                                    @foreach($listNews as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{ url()->current() }}/{{ $value->news_alias }}">{{ $loop->iteration  . ': ' . $value->title }}</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-dark"
                                                   href="{{ url()->current() }}/{{ $value->news_alias }}">Xem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection