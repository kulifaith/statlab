@section ("header")


        <header class="navbar navbar-fixed-top">
            <div class="container-fluid">

                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#">
                                <span style="font-size:18px; align:right;">{{ config('constants.FACILITY_NAME') }} </span>
                            
                        </a>
                    </li>
                    <li>
                <a href="{{ route('payment.index') }}">
                    <span class="nav_title">Payment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tenant.index') }}">
                    <span class="nav_title">Tenant</span>
                </a>
            </li>
            <li class="hidden">
                <a href="{{ route('maintenance.index') }}">
                    <span class="nav_title">Maintenance</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tenant.summary') }}">
                    <span class="nav_title">Summary</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span>Management</span><span class="caret"></span>
                        </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a class="dropdown-item" href="{{ route('site.index') }}">
                            <span>Site</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('housetype.index') }}">
                            <span>House Type</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('house.index') }}">
                            <span>House</span>
                        </a>
                    </li>
                    </ul>
            </li>

                </ul>
                
                @if (Illuminate\Support\Facades\Auth::check())
                <ul class="nav navbar-nav navbar-right">

                    <li class="user_menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							     {{Illuminate\Support\Facades\Auth::user()->name}}
							<span class="navbar_el_icon ion-person"></span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href='{{ URL::to("user/".Illuminate\Support\Facades\Auth::user()->id."/edit") }}'>{{trans('messages.edit-profile')}}</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route("user.logout") }}">{{trans('messages.logout')}}</a></li>
                        </ul>
                    </li>

                </ul>

                @endif


            </div>
        </header>




@show
