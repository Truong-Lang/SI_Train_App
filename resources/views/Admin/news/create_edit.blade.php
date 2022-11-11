@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'news', 'titlePage' => __('News Management'), 'title' => __('News Management')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">News Form Elements</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <form method="post" action="/" class="form-horizontal">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <div class="form-group bmd-form-group">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Parent</label>
                                    <div class="col-sm-3">
                                        <div class="form-group bmd-form-group">
                                            <select name="parent" class="form-control" id="ParentSelect">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-3">
                                        <div class="form-group bmd-form-group">
                                            <input type="number" class="form-control" name="status" value="{{ old('status') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">Submit<div class="ripple-container"></div></button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection