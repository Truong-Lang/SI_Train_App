@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'category', 'titlePage' => $title, 'title' => $title])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">{{ $title }}</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <form method="post" action="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.category.store') }}" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }} bmd-form-group">
                                            <input type="text" class="form-control" name="name" id="input-name" value="{{ old('name') ?? $getCategory->name ?? '' }}">
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if(!isset($getCategory->parent))
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Parent</label>
                                    <div class="col-sm-3">
                                        <div class="form-group bmd-form-group">
                                            <select name="parent" class="selectpicker" data-style="select-with-transition" title="Choose Parent">
                                                <option disabled> Choose Options</option>
                                                @if($listParent)
                                                    @foreach($listParent as $key => $val)
                                                        <option {{ old('parent') == $val->id || (isset($getCategory->parent) && $getCategory->parent == $val->id) ? "selected" : "" }} value="{{ $val->id }}">{{ $val->name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-3">
                                        <div class="form-group bmd-form-group">
                                            <input type="number" id="number" min="0" class="form-control" name="status" value="{{ old('status') ?? $getCategory->status ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Active</label>
                                    <div class="col-sm-3 checkbox-radios">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="active" value="1" {{ old('active') || (isset($getCategory->active) && (int)$getCategory->active != \App\Common\Constant::NUMBER_ONE) ? "" : "checked" }} >
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">Submit<div class="ripple-container"></div></button>
                                </div>
                                <input type="hidden" name="id" id="category_id" value="{{ $getCategory->id ?? '' }}">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection