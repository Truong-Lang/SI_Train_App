@extends(\App\Common\Constant::FOLDER_URL_ADMIN.'.layouts.app', [
'activePage' => 'user', 'titlePage' => __('User Management'), 'title' => __('User Management')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.commons.flash_message')
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('User Management') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr class="text-center">
                                        <th>
                                            {{ __('No') }}
                                        </th>
                                        <th>
                                            {{ __('Username') }}
                                        </th>
                                        <th>
                                            {{ __('First Name') }}
                                        </th>
                                        <th>
                                            {{ __('Last Name') }}
                                        </th>
                                        <th>
                                            {{ __('Email') }}
                                        </th>
                                        <th>
                                            {{ __('Role') }}
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
                                    @forelse($users as $key => $value)
                                        <tr class="text-center">
                                            <td>
                                                {{ $key  + $users->firstItem() }}
                                            </td>
                                            <td>
                                                {{ $value->username }}
                                            </td>
                                            <td>
                                                {{ $value->first_name }}
                                            </td>
                                            <td>
                                                {{ $value->last_name }}
                                            </td>
                                            <td>
                                                {{ $value->email }}
                                            </td>
                                            <td>
                                                {{ $value->role_name }}
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
                                                <a href="{{ route(\App\Common\Constant::FOLDER_URL_ADMIN . '.user.edit',$value->id) }}"
                                                   rel="tooltip" class="btn btn-success" data-original-title=""
                                                   title="{{__("Edit")}}">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="9">{{ __('message.NOT_DATA_SEARCH') }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include(\App\Common\Constant::FOLDER_URL_ADMIN.'.commons.modal_delete')
@endsection