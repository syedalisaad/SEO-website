@if( isset($actions) && count($actions) )
<div class="row clearfix">
    <div class="col-12 mb-3">
        @if( getAuth()->is_developer && array_key_exists('deleted', $actions))
            <a href="{{ route( $actions['deleted'], ['trash' => true] ) }}" class="float-right btn bg-danger"><i class="fas fa-trash-alt"></i> Trash </a>
        @endif
        @if( isAdmin() || getAuth()->can(\Perms::$USER['ADD']) && array_key_exists('added', $actions))
            <a href="{{ route( $actions['added'] ) }}" class="float-right btn bg-yarn mr-2"><i class="fas fa-plus"></i> Add New </a>
        @endif
        @if( array_key_exists('optional', $actions) )
            @php $actions = is_array($actions['optional']) ? $actions['optional'] : [$actions['optional']]; @endphp
            @foreach($actions as $action)
                {!! $action !!}
            @endforeach
        @endif
    </div>
</div>
@endif
