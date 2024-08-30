{{--<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
    Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
    entire.
</div>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Alert!</h5>
    Info alert preview. This alert is dismissable.
</div>
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
    Warning alert preview. This alert is dismissable.
</div>--}}

@if( \Session::has('alert-message') && in_array( \Session::get('alert-message')['status'], ['danger', 'warning', 'success', 'info']))
@php $alert = \Session::get('alert-message'); @endphp
<div class="alert alert-{{ $alert['status']  }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @if(isset($alert['title']))
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
    @endif
    {!! $alert['message'] ?? 'No Display Message' !!}
</div>
@endif


