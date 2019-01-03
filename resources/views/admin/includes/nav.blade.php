<?php 
$page = Request::segment(2);
$nav = Request::segment(3);
$$page = 'active open';
$$nav = 'active';
?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <ul class="sidenav">
                    <li class="sidenav-item {{ $dashboard }}">
                        <a href="{{ url ('admin/dashboard') }}">
                        <span class="sidenav-icon icon icon-home"></span>
                        <span class="sidenav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidenav-item has-subnav {{ $settings }}">
                        <a href="#" aria-haspopup="true">
                            <span class="sidenav-icon icon icon-gear"></span>
                            <span class="sidenav-label">Setting</span>
                        </a>
                        <ul class="sidenav-subnav">
                            <li class="sidenav-subheading">Settings</li>
                            <li class="{{ $profile }}">
                                <a href="{{ url('admin/settings/profile') }}">Profile</a>
                            </li>
                            <li class="{{ $website }}">
                                <a href="{{ url('admin/settings/website') }}">Website</a>
                            </li>
                            <li class="{{ $accounts }}">
                                <a href="{{ url('admin/settings/accounts') }}">Accounts</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidenav-item has-subnav {{ $users }}">
                        <a href="#" aria-haspopup="true">
                            <span class="sidenav-icon icon icon-users"></span>
                            <span class="sidenav-label">User Management</span>
                        </a>
                        <ul class="sidenav-subnav">
                            <li class="sidenav-subheading">User Management</li>
                            <li class="{{ $view }}">
                                <a href="{{ url('admin/users/view') }}">Users</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="sidenav-item has-subnav {{ $addnews }}">
                        <a href="#" aria-haspopup="true">
                            <span class="sidenav-icon icon icon-bolt"></span>
                            <span class="sidenav-label">News</span>
                        </a>
                         <ul class="sidenav-subnav">
                            <li class="sidenav-subheading">Add News</li>
                            <li class="{{ $profile }}">
                                <a href="{{ url('admin/news/new') }}">Add News</a>
                            </li>
                            <li class="{{ $website }}">
                                <a href="{{ url('admin/cms/news') }}">Show News</a>
                            </li>
                           
                        </ul>
                     </li>
                    <li class="sidenav-item">
                        <a href="{{ url ('admin/logout') }}">
                        <span class="sidenav-icon icon icon-sign-out"></span>
                        <span class="sidenav-label">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>