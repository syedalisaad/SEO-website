<div class="row info">
    <div class="col-md-6">
        @include(frontend_module_view('premium-info._left_info', 'Page'), ['hospital' => $hospital])
    </div>
    <div class="col-md-6 box">
        @include(frontend_module_view('premium-info._right_info', 'Page'), ['hospital' => $hospital])
    </div>
</div>
