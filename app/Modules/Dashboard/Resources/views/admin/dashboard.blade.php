@extends( admin_module_layout('master') )
@section('title', 'Admin Dashboard')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
@endsection
@section('content')
<div class="container-fluid">

    @include( admin_view('partials.simple-messages') )

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\User::isUser()->count() }}</h3>
                    <p>Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route(admin_route('user.index')) }}" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>0</h3>
                    <p>Hospitals Average</p>
                </div>
                <div class="icon"><i class="fas fa-hospital-symbol"></i></div>
                <a href="" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>0</h3>
                    <p>National Average</p>
                </div>
                <div class="icon"><i class="fas fa-hospital"></i></div>
                <a href="" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>0</h3>
                    <p>State Average</p>
                </div>
                <div class="icon"><i class="fas fa-hospital-user"></i></div>
                <a href="" class="small-box-footer">More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <form method="POST" action="{{ route( admin_route('newsletter.send') ) }}" id="newsletter">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Newsletter Template</h3>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="cust-label">Subject <span class="text-denger font-weight-bold">*</span></label>
                                <input type="text" name="newsletter_subject" class="form-control @error('newsletter_subject') is-invalid @enderror" placeholder="Subject" value="{{ old('newsletter_subject')?:null }}">
                                @error('newsletter_subject')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="cust-label">Message <span class="text-denger font-weight-bold">*</span></label>
                                <div class="input-group">
                                    <textarea maxlength="255" rows="8" name="newsletter_message" class="texteditor form-control @error('newsletter_message') is-invalid @enderror" placeholder="Message">{{ old('newsletter_message')?:null }}</textarea>
                                    @error('newsletter_message')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="cust-label">Candidates <span class="text-denger font-weight-bold">*</span></label>
                            </div>
                            <div class="col-sm-9">
                                <select name="newsletter_candidate" class="form-control form-control-sm select2 @error('newsletter_candidate') is-invalid @enderror">
                                    <option>Select Candidates</option>
                                    @php $candidates = \App\Models\Newsletter::$CANDIDATES_NEWSLETTER; @endphp
                                    @if( count($candidates) )
                                        @foreach($candidates as $key => $value )
                                        <option {{ old('newsletter_candidate') == $key?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('newsletter_candidate')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-yarn">Send</button>
                        <button type="reset" class="btn btn-default">Clear</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title float-none">Orders Management</h3>
                    <a href="" class="btn btn-sm btn-yarn float-right ">View All Orders</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th width="20%">Users</th>
                                <th>Description</th>
                                <th width="15%">Total</th>
                                <th width="22%">Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $orders = collect([]);
                            @endphp
                            @if( $orders->count() )
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->user->full_name??'-' }}</td>
                                        <td>{!! $order->order_items_detail !!}</td>
                                        <td>{{ $order->order_total_amount }}</td>
                                        <td>{{ $order->created_at->format('F d, Y') }}</td>
                                        <td>
                                            <a href="{{ route(admin_route('order.show'), [$order->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No orders available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
@push('css')
    <link rel="stylesheet" href="{{ admin_asset('/plugins/summernote/summernote-bs4.css') }}" />
@endpush
@push('scripts')
    <!-- Summernote -->
    <script src="{{ admin_asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>

        $('.texteditor').summernote({
            width: '100%',
            height: 200,
            placeholder: 'Write message here...',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });

    </script>
@endpush
