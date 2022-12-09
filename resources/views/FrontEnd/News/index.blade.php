@extends(\App\Common\Constant::FOLDER_URL_FRONTEND . '.layouts.app')

@section('content')
    <main class="mt-30">
        <div class="container">
            @if($category)
                <div class="archive-header">
                    <h2 class="font-weight-bold"><span class="font-family-normal">{{ $category->name }}</span></h2>
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
                                    @if($listNews->isNotEmpty())
                                        @foreach($listNews as $key=>$value)
                                            <tr>
                                                <td>{{ $loop->iteration  . ': ' . $value->title }} </td>
                                                <td>
                                                    <a class="btn btn-outline-dark" href="{{ url()->current() }}/{{ $value->alias }}">Xem</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ __('(Empty)') }}</td>
                                            <td>{{ __('(Empty)') }}</td>
                                        </tr>
                                    @endif
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