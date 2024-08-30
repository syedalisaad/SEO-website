@extends( admin_module_layout('master') )
@section('title', admin_module_lang('lang.default.title'))
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>{{ admin_module_lang('lang.default.title') }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ admin_module_lang('lang.manage.list', 'Lists', true) }}</li>
        </ol>
    </div>
@endsection
@section('content')
<section class="content">

    <div class="container-fluid">

        @include( admin_module_view('partials.simple-messages') )

        @include( admin_module_view('partials.manage-action-buttons'))

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ admin_module_lang('lang.default.title') }} {{ admin_module_lang('lang.manage.list', 'Lists', true) }}</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="8%">Actions</th>
                                    <th width="30%">Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th width="10%">Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('modals')
<div class="modal fade" id="show-more-details">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ admin_module_lang('lang.default.title') }} Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body show-more-details">
                <h3 class="text-yarn">
                    <i class="fas fa-paint-brush"></i> <span class="name">-</span>
                </h3>
                <p class="text-muted message">-</p>
                {{--<br>
                <div class="text-muted row">
                    <div class="user-block agent-block">
                        <img class="img-circle img-bordered-sm" src="{{ default_media_url() }}" alt="user image">
                        <span class="username">
                          <a href="javascript:void(0)">-</a>
                        </span>
                        <span class="description">-</span>
                    </div>
                </div>--}}

                <h5 class="mt-5 text-muted">Personal Detail</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:copyEmail($(this).find('span.email').text())" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> <span class="email">-</span>
                            <i class="fas fa-clipboard"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="btn-link text-secondary"><i class="fas fa-book"></i> <span class="subject">-</span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="btn-link text-secondary"><i class="fas fa-business-time"></i> <span class="created">-</span></a>
                    </li>
                </ul>
                {{--<div class="text-center mt-5 mb-3">
                    <a href="#" class="btn btn-sm btn-primary">Add files</a>
                    <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                </div>--}}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('css')
    <!-- DataTables -->
     <link rel="stylesheet" href="{{ admin_asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
     <link rel="stylesheet" href="{{ admin_asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{ admin_asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ admin_asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ admin_asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<script>
$(function () {

    function copyEmail(text) {
        navigator.clipboard.writeText(text).then(function () {
            alert('Copying to clipboard was successful!');
        }, function (err) {
            alert('Could not copy text: ', err);
        });
    }

    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        ajax:'{{ route(admin_route('contact.ajaxlist')) }}',
        order: [[ 4, "desc" ]],
        columns: [
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'message', name: 'message'},
            {data: 'created_at', name: 'created_at'},
        ]
    });

    $(document).on('click', '.const-show-more-details', function(){

        const details       = $(this).data();
        const details_box   = $('.show-more-details');
        console.log('details', details)

        let agent_block = details_box.find('.agent-block');
        //Contact Details
        details_box.find('.name').html( details.name );
        details_box.find('.email').html( details.email );
        details_box.find('.subject').html( details.subject );
        details_box.find('.message').html( details.message );
        details_box.find('.created').html( details.created );

        $('#show-more-details').modal('show');
    });
});
</script>
@endpush
