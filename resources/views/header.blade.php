@section ("header")


        <header class="navbar navbar-fixed-top">
            <div class="container-fluid">

                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#">
                                <span style="font-size:18px; align:right;">{{ config('constants.FACILITY_NAME') }} </span>
                            
                        </a>
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
