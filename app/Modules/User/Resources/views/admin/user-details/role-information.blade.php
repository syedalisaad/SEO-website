@if( $data->roles->count() )
    @foreach( $data->roles as $role )

        <p class="lead font-weight-bold mt-2">Role - {{ $role->name }} Information</p>

        @if( $role->permissions->count() )
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    @foreach( array_group_dot( $role->permissions->pluck('name')->toArray() ) as $page => $perms )
                        @php $perms = array_values($perms);  @endphp
                        <tr>
                            <th width="20%">{{ ucfirst($page) }}</th>
                            <td>
                                @for( $i=0; $i<count($perms); $i++)
                                    {{ dot_heading($perms[$i]) }} <br/>
                                @endfor
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach
@endif

@if( $data->permissions->count() )

    @php $permissions = $data->permissions->pluck('name')->toArray(); @endphp

    <p class="lead font-weight-bold mt-2">Custom Permissions</p>

    <div class="table-responsive">
        <table class="table">
            <tbody>
            @foreach( array_group_dot($permissions) as $page => $perms )
                <tr>
                    <th width="20%">{{ ucfirst($page) }}</th>
                    <td>
                        @php $perms = array_values($perms); @endphp

                        @for( $i=0; $i<count($perms); $i++)
                            {{ isset($perms[$i]) ? dot_heading($perms[$i]) : '-' }} <br/>
                        @endfor
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

@if( $data->roles->count() && $data->permissions->count() )
<p>No assign permissions</p>
@endif
