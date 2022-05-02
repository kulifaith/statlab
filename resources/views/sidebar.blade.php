@section("sidebar")
    <nav id="side_nav">
        <ul>
            <br>
            <li>
                <a href="{{ route('user.home')}}"><span class="ionicons ion-grid"></span> <span class="nav_title">Dashboard</span></a>
            </li>

            <li>
                <a href="{{ route('payment.index') }}">
                    <span class="ionicons ion-calendar"></span>
                    <span class="nav_title">Payment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tenant.index') }}">
                    <span class="ionicons ion-ios-people"></span>
                    <span class="nav_title">Tenant</span>
                </a>
            </li>
            <li class="hidden">
                <a href="{{ route('maintenance.index') }}">
                    <span class="ion-stats-bars"></span>
                    <span class="nav_title">Maintenance</span>
                </a>
            </li>
            <li class="nav_trigger">
                <a href="#">
                    <span class="ion-home"></span>
                    <span class="nav_title">house Management</span>
                </a>
                <div class="sub_panel" style="left: -220px;">
                    <div class="side_inner ps-ready ps-container" style="height: 620px;">
                        <h4 class="panel_heading panel_heading_first">CONFIGURATIONS</h4>
                <ul>
                    <li>
                        <a href="{{ route('site.index') }}">
                            <span class="glyphicon glyphicon-tag">Site</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('housetype.index') }}">
                            <span class="glyphicon glyphicon-tag">House Type</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('house.index') }}">
                            <span class="glyphicon glyphicon-tag">House</span>
                        </a>
                    </li>
                    </ul>
                    </div>
                </div>
            </li>

            @can('manage_users')

                <li class="nav_trigger">
                    <a href="#">
                        <span class="ion-key"></span>
                        <span class="nav_title">Access Control</span>
                    </a>
                    <div class="sub_panel" style="left: -220px;">
                        <div class="side_inner ps-ready ps-container" style="height: 620px;">
                            <h4 class="panel_heading panel_heading_first">Access Control</h4>
                            <ul>
                                <li>
                                    <div>
{{--                                        <a href="{{ Auth::user()->can('manage_users') ? route('user.index') : URL::to('user/'.Auth::user()->id.'/edit') }}">--}}
                                        <a href="{{ Auth::user()->can('manage_users') ? route('user.index') : URL::to('user') }}">
                                            <span class="glyphicon glyphicon-tag"></span> {{trans('messages.user-accounts')}}</a>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <a href="{{ route("permission.index")}}">
                                            <span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.permission', 2)}}</a>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <a href="{{ route("role.index")}}">
                                            <span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.role', 2)}}</a>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <a href="{{ route("role.assign")}}">
                                            <span class="glyphicon glyphicon-tag"></span> {{trans('messages.assign-roles')}}</a>
                                    </div>
                                </li>
                            </ul>

                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 215px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 620px; display: none;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></div>
                    </div>
                </li>
            @endcan

         <!--    <li class="nav_trigger">
                <a href="#">
                    <span class="ion-ios-folder"></span>
                    <span class="nav_title">Other Resouces</span>
                </a>
                <div class="sub_panel" style="left: -220px;">
                    <div class="side_inner ps-ready ps-container" style="height: 620px;">
                        <h4 class="panel_heading panel_heading_first">Other Resources</h4>
                        <ul>
                            <li>
                                <a href="http://www.cphluganda.org/" target="_blank">
                                    <span class=""></span> EID Dashboard</a>
                            </li>
                            <li>
                                <a href="http://vldash.cphluganda.org/" target="_blank">
                                    <span class=""></span> Viral Load Dashboard</a>
                            </li>
                            <li>
                                <a href="http://cphl.go.ug/" target="_blank">
                                    <span class=""></span> CPHL/UNHLS Website</a>
                            </li>
                            <li>
                                <a href="http://health.go.ug/" target="_blank">
                                    <span class=""></span> MoH Website</a>
                            </li>
                        </ul>

                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 215px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 620px; display: none;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></div>
                </div>
            </li> -->

        </ul>
    </nav>
@show
