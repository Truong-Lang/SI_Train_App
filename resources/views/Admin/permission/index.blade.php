@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'permission', 'titlePage' => __('Permission Management'), 'title' => __('Permission Management')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.commons.flash_message')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('Permission Management') }}</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.permission.createAndEdit') }}" class="btn btn-success pull-right" >
                            <i class="material-icons">add</i> {{ __('button.CREATE') }}<div class="ripple-container"></div>
                        </a>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                <tr class="text-center">
                                    <th>
                                        {{ __('No') }}
                                    </th>
                                    <th>
                                        {{ __('Permission') }}
                                    </th>
                                    <th>
                                        {{ __('Role') }}
                                    </th>
                                    <th>
                                        {{ __('Active') }}
                                    </th>
                                    <th>
                                        {{ __('Created') }}
                                    </th>
                                    <th>
                                        {{ __('Updated') }}
                                    </th>
                                    <th>
                                        {{ __('Author') }}
                                    </th>
                                    <th>
                                        {{ __('Actions') }}
                                    </th>
                                </tr></thead>
                                <tbody>
                                    @forelse($permissions as $key => $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $value->permission }}
                                            </td>
                                            <td>
                                                {{ $value->role_name }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-{{ $value->active == \App\Common\Constant::NUMBER_ONE ? 'success' : 'danger' }} btn-round btn-fab">
                                                    <i class="material-icons">{{ $value->active == \App\Common\Constant::NUMBER_ONE ? 'done' : 'clear' }}</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </td>
                                            <td class="text-primary">
                                                {{ $value->created_at }}
                                            </td>
                                            <td class="text-primary">
                                                {{ $value->updated_at }}
                                            </td>
                                            <td>
                                                <div class="btn btn-link btn-youtube">
                                                    <i class="material-icons">person</i> {{ $value->full_name }}
                                                    <div class="ripple-container"></div>
                                                </div>
                                            </td>
                                            <td class="td-actions text-right">
                                                <a href="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.permission.createAndEdit',$value->id) }}"
                                                   rel="tooltip" class="btn btn-success" data-original-title=""
                                                   title="{{__("Edit")}}">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <button type="button" data-id="{{$value->id}}" rel="tooltip"
                                                        class="btn btn-danger btn-round delete" title="{{__("Delete")}}"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                    <i class="material-icons">close</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="9">{{ __('message.NOT_DATA_SEARCH') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include(\App\Common\Constant::FOLDER_URL_ADMIN.'.commons.modal_delete')
@endsection