@extends(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.index', ['activePage' => 'banner-create', 'title' => isset($getBanner->id) ? 'バナー編集' : 'バナー登録'])

@section('content')
    @php
        $urlCloudFront = \App\Common\RuleApp::urlCloudFront();
    @endphp
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_message')
    <div class="block-header">
        <div class="col-md-6">
            <h2 class="block-title">{{ isset($getBanner->id) ? 'バナー編集' : 'バナー登録' }}</h2>
        </div>
        @if (isset($getBanner->id))
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-default button-sm btn-right" data-toggle="modal"
                        data-target="#dialog_confirm" id="delete_banner">
                    {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.SUBMIT_DELETE') }}
                </button>
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card block-list-multi">
            <form action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.banner_create_edit') }}"
                  method="post" id="frmBanner" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="block-list">
                        <div class="card-body">
                            <h3 class="search-panel-title">{{ isset($getBanner->id) ? 'バナー編集' : 'バナー登録' }}</h3>
                            <div class="table-responsive block-list-content">
                                <table class="custom-table table table-bordered dt-responsive nowrap">
                                    <tbody>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('バナー名') }}<span class="text-danger">*</span></th>
                                        <td>
                                            <div class="{{$errors->has('name') ? 'has-danger' : ''}}">
                                                <input type="text" name="name" class="w-100 form-control"
                                                       value="{{ old('name') ?? $getBanner->name ?? '' }}">
                                                </div>
                                                @if ($errors->has('name'))
                                                    <div class="col-md-12">
                                                        <div class="error text-danger">
                                                            <span class="icon-error"></span>
                                                            <span>{{ $errors->first('name') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('区分') }}<span class="text-danger">*</span></th>
                                        <td>
                                            <div class="form-inline checkbox-radios">
                                                @foreach(\App\Common\Constant::CLASS_TYPE as $key => $value)
                                                    @php
                                                        if (empty($getBanner->id)) {
                                                            if(old('class')) {$class = old('class');}
                                                            else {$class = \App\Common\Constant::CLASS_TYPE_MAIN;}
                                                        } else {
                                                            if(old('class')) $class = old('class');
                                                            else if(!empty($getBanner->class))
                                                                 $class = $getBanner->class;
                                                            else $class = "";
                                                        }
                                                    @endphp
                                                    <div class="form-check col-md-2 justify-content-start">
                                                        <label class="form-check-label pr-60">
                                                            <input class="form-check-input" type="radio" name="class"
                                                                   value="{{ $key }}" {{ ($class == $key) ? 'checked' : '' }} {{isset($getBanner->id) ? 'disabled' : ''}}> {{ $value }}
                                                            <span class="circle">
                                                              <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($errors->has('class'))
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $errors->first('class') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('並び順') }}<span class="text-danger">*</span></th>
                                        <td class="">
                                            <div class="col-md-5 {{$errors->has('order') ? 'has-danger' : ''}}">
                                                <input type="number" name="order" maxlength="{{App\Common\Constant::NUMBER_2}}" class="form-control js-number" value="{{ old('order') ?? $getBanner->seq ?? '' }}">
                                            </div>
                                            @if ($errors->has('order'))
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $errors->first('order') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('フロント表示') }}<span class="text-danger">*</span>
                                        </th>
                                        <td>
                                            <div class="form-inline checkbox-radios">
                                                @foreach(\App\Common\Constant::DISPLAY_FLAG as $key => $value)
                                                    @php
                                                        if (empty($getBanner->id)) {
                                                           if(old('display_flag') || old('display_flag') == '0')
                                                                $display_flag = old('display_flag');
                                                           else $display_flag = \App\Common\Constant::DISPLAY_FLAG_SHOW;
                                                        } else {
                                                            if (old('display_flag')) $display_flag = old('display_flag');
                                                            elseif (!empty($getBanner->display_flag))
                                                                $display_flag = $getBanner->display_flag;
                                                            else $display_flag = "";
                                                        }
                                                    @endphp
                                                    <div class="form-check col-md-2 justify-content-start">
                                                        <label class="form-check-label pr-60">
                                                            <input class="form-check-input" type="radio"
                                                                   name="display_flag"
                                                                   value="{{ $key }}" {{ ($display_flag == $key) ? 'checked' : '' }}> {{ $value }}
                                                            <span class="circle">
                                                              <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($errors->has('display_flag'))
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $errors->first('display_flag') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('公開期間') }}<span class="text-danger">*</span></th>
                                        <td>
                                            @php
                                                $periodFrom = '';
                                                $periodTo = '';
                                                if (isset($getBanner->period_from)) {
                                                    $periodFrom = \App\Common\RuleApp::formatDateHi($getBanner->period_from);
                                                    $periodTo = \App\Common\RuleApp::formatDateHi($getBanner->period_to);
                                                }
                                            @endphp
                                            <div class="col-md-5 pr-2">
                                                <div class="input-group {{$errors->has('period_from') ? 'has-danger' : ''}}">
                                                    <input type="text" name="period_from" id="period_from"
                                                           class="w-48 form-control datetimepicker form-control-datepicker"
                                                           value="{{old('period_from')??$periodFrom??''}}">
                                                    <label class="input-group-addon btn-datepicker" for="period_from">
                                                        <span class="fa fa-calendar"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center pt-3">
                                                <label class="text-center">～</label>
                                            </div>
                                            <div class="col-md-5 pl-2">
                                                <div class="input-group {{$errors->has('period_to') ? 'has-danger' : ''}}">
                                                    <input type="text" name="period_to" id="period_to"
                                                           class="form-control datetimepicker form-control-datepicker"
                                                           value="{{old('period_to')??$periodTo??''}}">
                                                    <label class="input-group-addon btn-datepicker" for="period_to">
                                                        <span class="fa fa-calendar"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('period_from') || $errors->has('period_to'))
                                                <div class="col-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ !empty($errors->first('period_from')) ? $errors->first('period_from') : $errors->first('period_to') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">
                                            <p>{{ __('PC画像') }}<span class="text-danger">*</span></p>
                                            <p class="ml-6">メイン：880px ✕ 500px</p>
                                            <p class="ml-6">サブ　：280px ✕ 100px</p>
                                        </th>
                                        <td>
                                            @php
                                                $isDisabledFile = '';
                                                $isDisabledClass = '';
                                                if (isset($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_DISPLAY]) &&
                                                    count($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_DISPLAY])) {
                                                    $isDisabledFile = 'disabled';
                                                    $isDisabledClass = 'upload-singer-file';
                                                }
                                            @endphp
                                            <div class="upload-file-part">
                                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-6 pr-4">
                                                    <div class="content-form-document upload-singer {{$isDisabledClass}}">
                                                        <input class="file-input-document" type="file" accept="image/*"
                                                               name="listFilesDisplay[]"
                                                               id="listFilesDisplay"
                                                               onchange="listFilesChange('Display', true)" {{$isDisabledFile}}>
                                                        <input type="hidden" name="listFilesRemoveDisplay"
                                                               id="listFilesRemoveDisplay" value="">
                                                        <input type="hidden" name="listFilesRemoveBannerDisplay"
                                                               id="listFilesRemoveBannerDisplay" value="">
                                                        <input type="hidden" name="countFilesUploadDisplay"
                                                               id="countFilesUploadDisplay" value="0">
                                                        <span id="listInputFileDisplay"></span>
                                                        <div class="text-form-upload-document">
                                                            <p>{{ __('message.TEXT_FILE_UPLOAD') }}</p>
                                                            <button type="button" class="btn btn-primary button-small">
                                                                {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.FILE_REFERENCE') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-6" id="listDetailFilesDisplay">
                                                    @if (!empty($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_DISPLAY]))
                                                        @foreach($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_DISPLAY] as $key => $imageDisplay)
                                                            <div class="info-file form-inline"
                                                                 id="elementOrder{{$key . '_s3'}}">
                                                                <div class="w-50">
                                                                    <span>{{\App\Common\RuleApp::strimWidthFileName($imageDisplay->file_name)}}</span></div>
                                                                <div class="w-50 text-right">
                                                                    <a class="imageModal upload-file-icon"
                                                                       data-src="{{ $urlCloudFront }}/{{$imageDisplay->image_path}}"
                                                                       data-alt="{{$imageDisplay->file_name}}"><span
                                                                                class="fa fa-search-plus"></span></a>
                                                                    <a class="upload-file-icon"
                                                                       onclick="downloadImage('{{$imageDisplay->id}}','{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.download_common_banner') }}')">
                                                                        <span class="fa fa-download"></span>
                                                                    </a>
                                                                    <a class="upload-file-icon"
                                                                       onclick="deleteFileDetailInList('{{$key . "_s3"}}', 'Display', {{$imageDisplay->id??'\'\''}})"><span
                                                                                class="fa fa-trash"></span></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if ($errors->has('filesDisplay'))
                                                    <div class="col-md-12">
                                                        <div class="error text-danger">
                                                            <span class="icon-error"></span>
                                                            <span>{{ $errors->first('filesDisplay') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($errors->has('listFilesDisplay'))
                                                    <div class="col-md-12">
                                                        <div class="error text-danger">
                                                            <span class="icon-error"></span>
                                                            <span>{{ $errors->first('listFilesDisplay') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @error('listFilesDisplay.*')
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                </div>
                                                @enderror
                                                @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_error_file_size', ['className' => 'errorFileSizeDisplay', 'attribute' => 'PC画像'])

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">
                                            <p>{{ __('スマホ画像') }}<span class="text-danger">*</span></p>
                                            <p class="ml-6">メイン：375px ✕ 200px</p>
                                            <p class="ml-6"> サブ　：338px ✕ 100px</p>
                                        </th>
                                        <td>
                                            @php
                                                $isDisabledFile = '';
                                                $isDisabledClass = '';
                                                if (isset($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_STORE]) &&
                                                    count($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_STORE])) {
                                                    $isDisabledFile = 'disabled';
                                                    $isDisabledClass = 'upload-singer-file';
                                                }
                                            @endphp
                                            <div class="upload-file-part">
                                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-6 pr-4">
                                                    <div class="content-form-document upload-singer {{$isDisabledClass}}">
                                                        <input class="file-input-document" type="file" accept="image/*"
                                                               name="listFilesStore[]"
                                                               id="listFilesStore"
                                                               onchange="listFilesChange('Store', true)" {{$isDisabledFile}}>
                                                        <input type="hidden" name="listFilesRemoveStore"
                                                               id="listFilesRemoveStore" value="">
                                                        <input type="hidden" name="listFilesRemoveBannerStore"
                                                               id="listFilesRemoveBannerStore" value="">
                                                        <input type="hidden" name="countFilesUploadDisplay"
                                                               id="countFilesUploadDisplay" value="0">
                                                        <span id="listInputFileStore"></span>
                                                        <div class="text-form-upload-document">
                                                            <p>{{ __('message.TEXT_FILE_UPLOAD') }}</p>
                                                            <button type="button" class="btn btn-primary button-small">
                                                                {{ \Illuminate\Support\Facades\Lang::get('button.BUTTON.FILE_REFERENCE') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-6" id="listDetailFilesStore">
                                                    @if (!empty($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_STORE]))
                                                        @foreach($bannerImages[\App\Common\Constant::STORE_IMAGE_CLASS_STORE] as $key => $imageDisplay)
                                                            <div class="info-file form-inline"
                                                                 id="elementOrder{{$key . '_s3'}}">
                                                                <div class="w-50">
                                                                    <span>{{\App\Common\RuleApp::strimWidthFileName($imageDisplay->file_name)}}</span></div>
                                                                <div class="w-50 text-right">
                                                                    <a class="imageModal upload-file-icon"
                                                                       data-src="{{ $urlCloudFront }}/{{$imageDisplay->image_path}}"
                                                                       data-alt="{{$imageDisplay->file_name}}"><span
                                                                                class="fa fa-search-plus"></span></a>
                                                                    <a class="upload-file-icon"
                                                                       onclick="downloadImage('{{$imageDisplay->id}}','{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.download_common_banner') }}')">
                                                                        <span class="fa fa-download"></span>
                                                                    </a>
                                                                    <a class="upload-file-icon"
                                                                       onclick="deleteFileDetailInList('{{$key . "_s3"}}', 'Store', {{$imageDisplay->id??'\'\''}})"><span
                                                                                class="fa fa-trash"></span></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if ($errors->has('filesStore'))
                                                    <div class="col-md-12">
                                                        <div class="error text-danger">
                                                            <span class="icon-error"></span>
                                                            <span>{{ $errors->first('filesStore') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($errors->has('listFilesStore'))
                                                    <div class="col-md-12">
                                                        <div class="error text-danger">
                                                            <span class="icon-error"></span>
                                                            <span>{{ $errors->first('listFilesStore') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @error('listFilesStore.*')
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                </div>
                                                @enderror
                                                @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.flash_error_file_size', ['className' => 'errorFileSizeStore', 'attribute' => 'スマホ画像'])
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('リンク先') }}<span class="text-danger">*</span></th>
                                        <td>
                                            <div class="form-inline checkbox-radios">
                                                @foreach(\App\Common\Constant::TARGET as $key => $value)
                                                    @php
                                                        if (empty($getBanner->id)) {
                                                           if(old('target') || old('target') == '0')
                                                               $target = old('target');
                                                           else $target = \App\Common\Constant::TARGET_EXTERNAL;
                                                        } else {
                                                           if (old('target') || old('target') == '0')
                                                               $target = old('target');
                                                           else if(!empty($getBanner->image_link)) {
                                                               $target = \App\Common\Constant::TARGET_EXTERNAL;
                                                           } else if(!empty($getBanner->special_feature_id)) {
                                                               $target = \App\Common\Constant::TARGET_SPECIAL_PAGE;
                                                           } else
                                                                $target = '';
                                                       }
                                                    @endphp
                                                    <div class="form-check col-md-2 justify-content-start">
                                                        <label class="form-check-label pr-60">
                                                            <input class="form-check-input" id="target" type="radio" name="target"
                                                                   value="{{ $key }}" {{ ($target == $key) ? 'checked' : '' }}>{{ $value }}
                                                            <span class="circle">
                                                                  <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($errors->has('target'))
                                                <div class="col-md-12">
                                                    <div class="error text-danger">
                                                        <span class="icon-error"></span>
                                                        <span>{{ $errors->first('target') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('外部リンク') }}<span class="text-danger">*</span>
                                        </th>
                                        <td>
                                            <div class="form-inline {{$errors->has('image_link') ? 'has-danger' : ''}}">
                                                <input type="text" name="image_link" class="w-48 form-control"
                                                       value="{{ old('image_link') ?? $getBanner->image_link ?? '' }}">
                                                <div class="form-check form-check-inline pl-50">
                                                    <label class="form-check-label">
                                                        @php
                                                            if (old('prostock_paper_flag')) {
                                                                $paper = 'checked';
                                                            } elseif(!empty($getBanner->prostock_paper_flag)) {
                                                                $paper = 'checked';
                                                                $disable = 'disabled';
                                                            } else {
                                                                $paper = '';
                                                                $disable = '';
                                                            }
                                                        @endphp
                                                        <input class="form-check-input" id="prostock_paper_flag" type="checkbox"
                                                               name="prostock_paper_flag" value="1" {{ !empty($paper) ? $paper : '' }}
                                                                {{ !empty($disable) ? $disable : '' }}>プロストック新聞
                                                        <span class="form-check-sign"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('image_link'))
                                                <div class="error text-danger">
                                                    <span class="icon-error"></span>
                                                    <span>{{ $errors->first('image_link') }}</span>
                                                </div>
                                            @endif
                                            @if ($errors->has('prostock_paper_flag'))
                                                <div class="error text-danger">
                                                    <span class="icon-error"></span>
                                                    <span>{{ $errors->first('prostock_paper_flag') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('特集ページ') }}<span class="text-danger">*</span>
                                        </th>
                                        <td>
                                            <div class="selectWrapper {{$errors->has('special_id') ? 'has-danger' : ''}}">
                                                <select name="special_id" id="special_id">
                                                    <option value="">{{\App\Common\Constant::SELECT_INPUT_NOT_CHOICE_TEXT}}</option>
                                                    @if (!empty($listSpecial))
                                                        @foreach($listSpecial as $special)
                                                            @php
                                                                $selected = '';
                                                                if (old('special_id')) {
                                                                    if (old('special_id') == $special->id) {
                                                                        $selected = 'selected';
                                                                    }
                                                                } else {
                                                                    if (isset($getBanner->special_feature_id)) {
                                                                        if ($getBanner->special_feature_id == $special->id) {
                                                                            $selected = 'selected';
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{$special->id}}" {{$selected}}>{{$special->title}}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('special_id'))
                                                <div class="error text-danger">
                                                    <span class="icon-error"></span>
                                                    <span>{{ $errors->first('special_id') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @if (isset($getBanner->id))
                                    <tr>
                                        <th class="w-25 bg-grey">{{ __('最終更新') }}</th>
                                        <td>
                                            <div class="form-inline">
                                                <div class="col-md-2">{{ !empty($infoAccounts->updated_full_name) ? $infoAccounts->updated_full_name : __('message.SYSTEM_MEMBER_NAME') }}</div>
                                                <div class="col-md-10">{{ !empty($getBanner->updated_at) ? \App\Common\RuleApp::formatDateHi($getBanner->updated_at) : '' }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary button-sm btn-load">{{ isset($getBanner->id) ? \Illuminate\Support\Facades\Lang::get('button.BUTTON.SUBMIT_UPDATE') : \Illuminate\Support\Facades\Lang::get('button.BUTTON.SUBMIT_CREATE') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" id="banner_id" value="{{$getBanner->id??''}}">
                <input type="hidden" name="class_update" id="class_update" value="{{$getBanner->class??''}}">
                <input type="hidden" name="countFileOnViewDisplay" id="countFileOnViewDisplay"
                       value="{{isset($bannerImages[\App\Common\Constant::BANNER_IMAGE_CLASS_DISPLAY]) ? count($bannerImages[\App\Common\Constant::BANNER_IMAGE_CLASS_DISPLAY]) : '0'}}">
                <input type="hidden" name="countFileOnViewStore" id="countFileOnViewStore"
                       value="{{isset($bannerImages[\App\Common\Constant::BANNER_IMAGE_CLASS_STORE]) ? count($bannerImages[\App\Common\Constant::BANNER_IMAGE_CLASS_STORE]) : '0'}}">
            </form>
        </div>
    </div>
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.Dialog.confirm')
    @include(''.\App\Common\Constant::FOLDER_URL_ADMIN.'.Commons.Dialog.show_image_modal')
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var imagelink = $("input[name='image_link']"),
                prostockPaper = $("#prostock_paper_flag"),
                special_id = $('#special_id');
            if ($('input:radio[name="target"][value="0"]').is(':checked')) {
                special_id.prop('disabled', false);
                imagelink.prop('disabled', true).val('');
                prostockPaper.prop('disabled', true).prop("checked", false);
            } else {
                imagelink.prop('disabled', false);
                special_id.prop('disabled', true).val('');
            }

            $("input[name='target']").click(function () {
                var check = $('input[name="target"]:checked').val();
                if (check == 1) {
                    special_id.prop('disabled', true).val('');
                    imagelink.prop('disabled', false);
                    prostockPaper.prop('disabled', false);
                } else {
                    special_id.prop('disabled', false);
                    imagelink.prop('disabled', true).val('');
                    prostockPaper.prop('disabled', true).prop("checked", false);
                }
            });

            prostockPaper.change(function(){
                this.value = (Number(this.checked));
            });

            $(document).on('click', '#delete_banner', function (e) {
                $('#confirm_message_content').text('{{ __('message.CONFIRM_MESSAGE_CONTENT') }}')
            });
            $('#button_confirm_yes').click(function () {
                $.ajax({
                    url: "{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.banner_delete') }}",
                    method: "POST",
                    data: {
                        id: $('#banner_id').val(),
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (result) {
                        if (result.status) {
                           window.location.href = "{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.banner_search') }}";
                        } else {
                            location.reload();
                        }
                    },
                    error: function (result) {
                        location.reload();
                    }
                });
            });

            $('#frmBanner').submit(function() {
                $('#prostock_paper_flag').removeAttr('disabled');
            });
        });

        function deleteFileDetailInList(key, suffixName, bannerImageId) {
            let selectorListDetailFile = $('#listDetailFiles' + suffixName);
            selectorListDetailFile.find('#elementOrder' + key).remove();
            let parentSelector = $('#listFilesRemove' + suffixName);
            let valListKey = parentSelector.val();
            let listS3Remove = $('#listFilesRemoveBanner' + suffixName);
            let valListS3Key = listS3Remove.val();
            if (bannerImageId == '') {
                if (valListKey === '' || valListKey === null) {
                    parentSelector.val(key);
                } else {
                    parentSelector.val(valListKey + '_' + key);
                }
            } else {
                if (valListS3Key === '' || valListS3Key === null) {
                    listS3Remove.val(bannerImageId);
                } else {
                    listS3Remove.val(valListS3Key + '_' + bannerImageId);
                }
            }
            let countElement = $("#listDetailFiles" + suffixName + " div").length;
            let countFileOnView = $('#countFileOnView' + suffixName).val();
            $('#countFileOnView' + suffixName).val(countFileOnView - 1);
            if (countElement === 0) {
                selectorListDetailFile.removeClass();
                $('#listFiles' + suffixName).prop('disabled', false);
            }

            //remove class on click icon
            removeClassUploadSinger(suffixName);
        }
    </script>
@endpush
