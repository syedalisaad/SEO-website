@php
use Spatie\Permission\Models\Role;

$roles      = Role::all();
$role_ids   = (isset($data) && $data->roles->count() ? $data->roles->pluck('id')->toArray() : []);
@endphp
<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 10px">#</th>
        <th colspan="3">Permissions</th>
        {{--<th></th>--}}
        {{--<th style="width: 40px">All</th>--}}
    </tr>
    </thead>
    <tbody>
    @if( count($roles))
        @php $chunk = 3; @endphp
        @foreach( $roles as $key => $role )

            @if( $role->permissions->count() )
                <tr style="background-color: #f9d020; color: #e9170d">
                    <th>
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, $role_ids)?'checked':'' }} class="const-roles" />
                    </th>
                    <th colspan="3">{{ $role->name }}</th>
                </tr>
                @foreach( array_group_dot( $role->permissions->pluck('name')->toArray() ) as $role => $perms )
                    <tr>
                        <th><i class="fa fa-book"></i></th>
                        <th colspan="3">{{ ucfirst($role) }}</th>
                    </tr>
                    @foreach( array_chunk($perms, $chunk) as $permissions )
                        <tr>
                            <td><i class="fa fa-book"></i></td>
                            @php $permissions = array_values($permissions); @endphp
                            @for( $i=0; $i<$chunk; $i++)
                                <td>{{ (isset($permissions[$i])?dot_heading($permissions[$i]):'-') }}</td>
                            @endfor
                        </tr>
                    @endforeach
                @endforeach
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="5">Not available permissions</td>
        </tr>
    @endif
    </tbody>
</table>
@push('scripts')
<script>
$(function () {


    /*$(document).on('change', '.const-roles', function(){

        $('.const-contaier-role').css('visibility', 'collapse');

        let role_id = $(this).val();
        $('.const-contaier-role-'+ role_id).css('visibility', 'inherit');
        $('.const-permission-id').prop('checked', false);
    });*/
})
</script>
@endpush
