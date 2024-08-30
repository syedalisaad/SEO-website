<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">{{ getAuth()->full_name??'' }}</a>
        </div>
    </div>

    <nav class="mt-2 constActiveSidebar">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat text-sm nav-legacy nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route( admin_route('dashboard') ) }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-users"></i>
                    <p>User Management <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview {{ (Request::segment(3) == 'change-info-request' && Request::segment(4) == 'form') ? 'menu-open' : '' }} ">
                    <li class="nav-item">
                        <a href="{{ route( admin_route('user.index') ) }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User Data List</p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route( admin_route('user.hospital.unverified.index') ) }}" class="nav-link">--}}
{{--                            <i class="far fa-circle nav-icon"></i>--}}
{{--                            <p>Approved User</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ route( admin_route('user.unverified.index') ) }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Resend Account Activation</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route( admin_route('hospitalsurvey.change_info_req') ) }}" class="nav-link {{ (Request::segment(3) == 'change-info-request' && Request::segment(4) == 'form') ? 'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User Update Request</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-hospital-user"></i>
                    <p>General User <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route( admin_route('hospitalsurvey.list') ) }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User List</p>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route(admin_route('order.delivered.manage')) }}" class="nav-link">
                    <i class="nav-icon fas fa-dolly-flatbed"></i>
                    <p>User Payments</p>
                </a>
            </li>

            @php $is_contact = (
               in_array(\Perms::$CONTACT['LIST'], getAuth()->role_permissions) ||
               in_array(\Perms::$CONTACT['VIEW'], getAuth()->role_permissions)
           ); @endphp

            @php $is_newsletter = (
              in_array(\Perms::$NEWSLETTER['LIST'], getAuth()->role_permissions)
            ); @endphp

            @if( isAdmin() || $is_contact || $is_newsletter )
                <li class="nav-header">SUPPORT</li>
                @if( isAdmin() || $is_newsletter )
                    <li class="nav-item">
                        <a href="{{ route(admin_route('newsletter.index')) }}" class="nav-link">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>Newsletters</p>
                        </a>
                    </li>
                @endif
                @if( isAdmin() || $is_contact )
                    <li class="nav-item">
                        <a href="{{ route(admin_route('contact.index')) }}" class="nav-link">
                            <i class="nav-icon fas fa-mail-bulk"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                @endif
            @endif

            <li class="nav-header">SETUP & SETTINGS</li>

            @php $is_blog = (
               in_array(\Perms::$BLOG['ADD'], getAuth()->role_permissions) ||
               in_array(\Perms::$BLOG['UPDATE'], getAuth()->role_permissions) ||
               in_array(\Perms::$BLOG['LIST'], getAuth()->role_permissions)
           ); @endphp
            @if( isAdmin() || $is_blog )
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Blogs Management <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if( isAdmin() || getAuth()->can(\Perms::$BLOG['ADD']) )
                            <li class="nav-item">
                                <a href="{{ route(admin_route('blog.create')) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        @endif
                        @if( isAdmin() || (getAuth()->can(\Perms::$BLOG['UPDATE']) || getAuth()->can(\Perms::$BLOG['LIST'])) )
                            <li class="nav-item">
                                <a href="{{ route(admin_route('blog.index')) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @php $is_page = (
               in_array(\Perms::$PAGE['ADD'], getAuth()->role_permissions) ||
               in_array(\Perms::$PAGE['UPDATE'], getAuth()->role_permissions) ||
               in_array(\Perms::$PAGE['LIST'], getAuth()->role_permissions)
           ); @endphp
            @if( isAdmin() || $is_page )
                <li class="nav-item">
                    <a href="{{ route(admin_route('page.index')) }}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Page Management</p>
                    </a>
                </li>
            @endif


            @php $is_page = (
               in_array(\Perms::$PACKAGEPRICE['ADD'], getAuth()->role_permissions) ||
               in_array(\Perms::$PACKAGEPRICE['LIST'], getAuth()->role_permissions)
           ); @endphp
            @if( isAdmin() || $is_page )
                <li class="nav-item">
                    <a href="{{ route(admin_route('packageprice.list')) }}" class="nav-link" style="display: none">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Package Price</p>
                    </a>
                </li>
            @endif

            @php $is_settings = (in_array(\Perms::$SETTING['GENERAL'], getAuth()->role_permissions) || in_array(\Perms::$SETTING['SOCIAL_NETWORK'], getAuth()->role_permissions) || in_array(\Perms::$SETTING['CONTACT_SUPPORT'], getAuth()->role_permissions) || in_array(\Perms::$SETTING['CHANGE_PASSWORD'], getAuth()->role_permissions)); @endphp
            @if( isAdmin() || $is_settings)

                <li class="nav-item">
                    <a href="{{ route(admin_route('site.setting')) }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-logout" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>

        </ul>
    </nav>
</div>

@push('modals')
    <div class="modal fade" id="modal-logout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logout</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure sure you want to log out ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yarn" onclick="javascript:window.location='{{ route( admin_route('logout') ) }}'">Logout</button>
                </div>
            </div>
        </div>
    </div>
@endpush
