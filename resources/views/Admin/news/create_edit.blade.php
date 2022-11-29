@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'news', 'titlePage' => $title, 'title' => $title])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.commons.flash_message')
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">{{ $title }}</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <form method="post"
                                  action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.news.store') }}"
                                  class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Title <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('title') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="title" id="input-title"
                                                   value="{{ old('title') ?? $getNews->title ?? '' }}">
                                            @if ($errors->has('title'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-title">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Description <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('description') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="description"
                                                   id="input-description"
                                                   value="{{ old('description') ?? $getNews->description ?? '' }}">
                                            @if ($errors->has('description'))
                                                <span id="description-error" class="error text-danger"
                                                      for="input-description">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Content <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('content') ? 'has-danger' : '' }} bmd-form-group">
                                            <textarea class="form-control" id="input-tinymce-area"
                                                      name="content">{{ old('content') ?? $getNews->content ?? '' }}</textarea>
                                            @if ($errors->has('content'))
                                                <span id="content-error" class="error text-danger"
                                                      for="input-content-area">{{ $errors->first('content') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row image">
                                    <label class="col-sm-2 col-form-label">Image <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="image" name="image"
                                               accept="image/png, image/jpeg">
                                        @if ($errors->has('image'))
                                            <span id="image-error" class="error text-danger"
                                                  for="input-image">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <div class="form-group {{ $errors->has('category_id') ? 'has-danger' : '' }} bmd-form-group">
                                            <div>
                                                <select name="category_id" class="selectpicker" id="select-category"
                                                        data-style="select-with-transition" title="Choose Category">
                                                    <option disabled> Choose Options</option>
                                                    @foreach($categories as $category)
                                                        <option {{ old('category_id') == $category->id || (isset($getNews->category_id) && $getNews->category_id == $category->id) ? "selected" : "" }}
                                                                value="{{ $category->id }}">{{ $category->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category_id'))
                                                <span id="category-id-error" class="error text-danger"
                                                      for="select-category">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-3">
                                        <div class="form-group bmd-form-group">
                                            <input type="number" class="form-control" name="status"
                                                   value="{{ old('status') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Active</label>
                                    <div class="col-sm-3 checkbox-radios">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="active"
                                                       value="1" {{ old('active') || (isset($getNews->active) && (int)$getNews->active != \App\Common\Constant::NUMBER_ONE) ? "" : "checked" }} >
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">Submit
                                        <div class="ripple-container"></div>
                                    </button>
                                </div>
                                <input type="hidden" name="id" id="news_id" value="{{ $getNews->id ?? '' }}">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection