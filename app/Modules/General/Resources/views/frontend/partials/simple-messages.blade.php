@if( \Session::has('alert-message') && in_array( \Session::get('alert-message')['status'], ['danger', 'warning', 'success', 'info']))
    @php $alert = \Session::get('alert-message'); @endphp
    <div class="alert alert-{{ $alert['status']  }} alert-dismissible">
        <div type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</div>
        @if(isset($alert['title']))
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
        @endif
        {!! $alert['message'] ?? 'No Display Message' !!}
    </div>
    <br/><br/>
@endif
