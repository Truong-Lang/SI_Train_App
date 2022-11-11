@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.index', ['activePage' => 'banner-search', 'title' => __('バナー検索')])

@section('content')
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_message')
    <div class="block-header">
        <div class="col-md-6">
            <h2 class="block-title">{{ __('バナー検索') }}</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.banner') }}" class="btn btn-primary button-sm btn-right">
                {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.CREATE') }}
            </a>
        </div>
    </div>

    {{-- search part --}}
    <div class="block-search">
        <div class="col-md-12">
            <form id="frmSearch" class="form-horizontal" method="POST">
                <div class="card ">
                    <div class="card-header search-header-text">
                        <div class="search-text">
                            <h3 class="search-panel-title">{{ __('検索条件') }}</h3>
                        </div>
                    </div>
                    <div class="card-body search-panel">
                        <div class="card-content">
                            <div class="col-md-12 py-2">
                                <div class="col-md-2 px-4">
                                    <label class="col-form-label">{{ __('バナー名') }}</label>
                                </div>
                                <div class="col-md-4 px-4">
                                    <input type="text" name="name" placeholder="" class="form-control"
                                           value="">
                                </div>
                                <div class="col-md-2 px-4">
                                    <label class="col-form-label">{{ __('区分') }}</label>
                                </div>
                                <div class="col-md-4 px-4">
                                    @foreach(\App\Common\Constant::CLASS_TYPE as $key => $value)
                                        <div class="form-check form-check-inline pl-0">
                                            <label class="form-check-label {{ $key == 1 ? 'w-103' : '' }}">
                                                <input class="form-check-input" type="checkbox" name="class[]"
                                                       value="{{ $key }}"> {{ $value }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 py-2">
                                <div class="col-md-2 px-4">
                                    <label class="col-form-label">{{ __('公開期間') }}</label>
                                </div>
                                <div class="col-md-4 px-4">
                                    <div class="input-group">
                                        <input type="text" id="period_from"
                                               class="form-control datetimepicker form-control-datepicker"
                                               name="period_from">
                                        <label class="input-group-addon btn-datepicker" for="period_from">
                                            <span class="fa fa-calendar"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center py-3"><strong>～</strong></div>
                                <div class="col-md-4 px-4">
                                    <div class="input-group">
                                        <input type="text" id="period_to"
                                               class="form-control datetimepicker form-control-datepicker"
                                               name="period_to">
                                        <label class="input-group-addon btn-datepicker" for="period_to">
                                            <span class="fa fa-calendar"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-2">
                                <div class="col-md-2 px-4">
                                    <label class="col-form-label">{{ __('フロント表示') }}</label>
                                </div>
                                <div class="col-md-4 px-4">
                                    @foreach(\App\Common\Constant::DISPLAY_FLAG as $key => $value)
                                        <div class="form-check form-check-inline pl-0">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="display_flag[]"
                                                       value="{{ $key }}"> {{ $value }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-2 px-4">
                                    <label class="col-form-label">{{ __('リンク先') }}</label>
                                </div>
                                <div class="col-md-4 px-4">
                                    @foreach(\App\Common\Constant::TARGET as $key => $value)
                                        <div class="form-check form-check-inline pl-0">
                                            <label class="form-check-label {{ $key == 1 ? 'w-103' : '' }}">
                                                <input class="form-check-input" type="checkbox" name="target[]"
                                                       value="{{ $key }}"> {{ $value }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center card-block-footer ml-auto mr-auto mt-5">
                                    <button type="reset" class="btn button-sm btn-default mx-5" id="btnResetSearch"> {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.RESET_SEARCH')}}</button>
                                    <button type="button" id="btnSearch" class="btn btn-primary btn-load btn-load-ajax button-sm mx-5"> {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.SEARCH') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end search part --}}

    <div class="col-md-12">
        <div class="card">

            <div class="col-md-12">
                <div class="col-md-6">
                    <h3 class="card-title-table">
                        <strong>{{ __('検索結果') }}</strong>
                        <span class="resultTotal">{{ __('件数') }}：<span id="recordsTotal"></span></span>
                    </h3>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-block" class="table table-striped- table-bordered table-hover table-checkable nowrap">
                        <colgroup>
                            <col width="50">
                            <col width="auto">
                            <col width="auto">
                            <col width="auto">
                            <col width="auto">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('区分') }}</th>
                            <th>{{ __('並び順') }}</th>
                            <th>{{ __('バナー名') }}</th>
                            <th>{{ __('公開期間') }}</th>
                            <th>{{ __('フロント表示') }}</th>
                            <th>{{ __('リンク種別') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var pageLength = "{{ \App\Common\Constant::ROWS_PER_PAGE }}",
            createNewsUrl = "{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.banner') }}",
            searchBannerProcessUrl = "{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.ajax_banner_search_process') }}",
             displayFlag1 = "{{ \App\Common\Constant::DISPLAY_FLAG[\App\Common\Constant::DISPLAY_FLAG_SHOW] }}",
             displayFlag0 = "{{ \App\Common\Constant::DISPLAY_FLAG[\App\Common\Constant::DISPLAY_FLAG_HIDE] }}",
             displayFlagShow = {{ \App\Common\Constant::DISPLAY_FLAG_SHOW }},
             classType1 = "{{ \App\Common\Constant::CLASS_TYPE[\App\Common\Constant::CLASS_TYPE_MAIN] }}",
             classType2 = "{{ \App\Common\Constant::CLASS_TYPE[\App\Common\Constant::CLASS_TYPE_SUB] }}",
             target1 = "{{ \App\Common\Constant::TARGET[\App\Common\Constant::TARGET_EXTERNAL] }}",
             target0 = "{{ \App\Common\Constant::TARGET[\App\Common\Constant::TARGET_SPECIAL_PAGE] }}",
             messageZero = "{{ __('message.NOT_DATA_SEARCH') }}";
    </script>
    <script src="{{ MyHelpers::styleAsset('js/prostock_admin/banner_search.js') }}"></script>
@endpush
