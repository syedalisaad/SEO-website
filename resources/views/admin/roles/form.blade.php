@extends( admin_module_layout('master') )
@section('title', 'Role')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Role</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('role.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Role</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @include( admin_module_view('partials.simple-messages') )

    @php
    use Spatie\Permission\Models\Permission;

    $permissions    = Permission::pluck('name', 'id')->toArray();
    $action         = route(admin_route('role.store'));
    $exists_perms   = isset($data)?$data->permissions->pluck('id')->toArray():[];

    if ( $is_update ) {
        $action = route(admin_route('role.update'), [$data->id]);
    }
    @endphp

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf @method( !$is_update ? 'POST' : 'PUT' )
        <div class="row">
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} Role</h3>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm-8">
                                <label class="cust-label">Name <strong style="color:#c00">*</strong></label>
                                <input type="text" name="name" value="{{ old('name') ?? $data->name ?? null }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Name">
                                @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @empty( $is_update )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="role.create">Save & New</button>
                        @endempty

                        @if( isAdmin() || getAuth()->can(\Perms::$ROLE['LIST']) )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="role.index">Save & Exit</button>
                            <button type="button" onclick="javascript:window.location='{{ route(admin_route('role.index')) }}'" class="btn btn-default">Cancel</button>
                        @endif
                   </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Permissions</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Permissions</th>
                                    <th></th>
                                    {{--<th></th>--}}
                                    {{--<th style="width: 40px">All</th>--}}
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($permissions))
                                    @foreach( array_group_dot($permissions) as $page => $perms )
                                        <tr style="background-color: #f9d020; color: #e9170d">
                                            <th><i class="fa fa-book"></i></th>
                                            <th colspan="2">{{ ucfirst($page) }}</th>
                                        </tr>
                                        @foreach($perms as $key => $value)
                                            <tr>
                                                <td><i class="fa fa-book"></i></td>
                                                <td>{{ dot_heading($value) }}</td>
                                                <td>
                                                    <input type="checkbox" {{ in_array($key, $exists_perms)?'checked':'' }} name="permissions[]" value="{{ $key }}"/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Not available permissions</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </form>

</div>
@endsection
