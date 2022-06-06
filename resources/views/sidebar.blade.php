@section("sidebar")
    <nav id="side_nav">
        <ul>
            <br>
            <li>
                <a href="{{ route('user.home')}}"><span class="ionicons ion-grid"></span> <span class="nav_title">Dashboard</span></a>
            </li>
            <li>
                <a href="{{ route('lab.report') }}">
                    <span class="ionicons ion-ios-people"></span>
                    <span class="nav_title">Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.index') }}">
                    <span class="ionicons ion-ios-people"></span>
                    <span class="nav_title">Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('labrows.index') }}">
                    <span class="ionicons ion-ios-home"></span>
                    <span class="nav_title">Lab rows</span>
                </a>
            </li>
            <li>
                <a href="{{ route('course.index') }}">
                    <span class="ionicons ion-ios-people"></span>
                    <span class="nav_title">Courses</span>
                </a>
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
                    
                            </ul>

                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 215px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 620px; display: none;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></div>
                    </div>
                </li>
            @endcan

        </ul>
    </nav>
@show
