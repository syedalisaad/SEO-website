@php
use Spatie\Permission\Models\Permission;

$permissions = Permission::pluck('name', 'id')->toArray();
$exist_perms = (isset($data) && $data->permissions->count() ? $data->permissions->pluck('name')->toArray() : []);
@endphp
<div class="row">
    <div class="col-sm-9">
        <select multiple name="permissions[]" class="form-control select2 const-permissions">
            @if( count($exist_perms) )
                @foreach($exist_perms as $value)
                    <option value="{{ $value }}" selected>{{ dot_heading($value) }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-sm-2">
        <button type="button" class="btn btn-yarn offset-1" data-toggle="modal" data-target="#modal-permissions">Permissions</button>
    </div>
</div>

@push('modals')
<div class="modal fade" id="modal-permissions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Permissions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th colspan="3">Permissions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( count($permissions))

                        @foreach( array_group_dot($permissions) as $role => $perms )
                            <tr style="background-color: #f9d020; color: #e9170d">
                                <th><i class="fa fa-book"></i></th>
                                <th colspan="2">{{ $role }}</th>
                            </tr>
                            @foreach( $perms as $key => $value )
                                <tr>
                                    <td><i class="fa fa-book"></i></td>
                                    <td>{{ dot_heading($value) }}</td>
                                    <td>
                                        <input type="checkbox" value="{{ $value }}" class="const-permission-ids" {{ in_array($value, $exist_perms)?'checked':'' }} />
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-yarn" name="assign_perms">Assign</button>
            </div>
        </div>
    </div>
</div>
@endpush
@push('scripts')
<script>
$(function () {
    $("button[name=assign_perms]").on('click', function(){

        let perms_container = $('.const-permissions');
        perms_container.html('');

        let permsHTML = '';
        $('.const-permission-ids:checked').each(function(index, value){
            permsHTML +='<option selected value="'+value.value+'">'+value.value+'</option>';
        });

        perms_container.html( permsHTML ).trigger('change');

        $('#modal-permissions').modal('toggle');
    });

    $(".const-permissions").on('change', function(){

        let permission_id = $(this).find(':checked').val();
        console.log('permission_id', permission_id);

        //$('.const-permission-ids').find('input[value="'+permission_id+'"]').prop('checked', false).trigger('change');
        $('input[value="setting.contact.support"]').prop('checked', false);
    });
});
</script>
@endpush
