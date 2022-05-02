<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/layout.css') }}" />
        <title>{{ config('kblis.name') }} {{ config('kblis.version') }}</title>
    </head>
    <body>
        <div class="container login-page">
            <div class="header" style="margin-top: 40px;">
                @include('user.loginHeader')
            </div>
            <div class="login-form">
                <div class="form-head">
                    <br>
                    <h2><b> NANA PROPERTIES </b></h2>
                    <!-- <img src="{{ asset('/i/home.jpeg') }} " width="200px"> -->
                    @if($errors->all())
                        <div class="alert alert-danger">
                            {{ HTML::ul($errors->all()) }}
                        </div>
                    @elseif (Session::has('message'))
                        <div class="alert alert-danger">{{ Session::get('message') }}</div>
                    @endif
                </div>

                {{ Form::open(array(
                    "route"        => "login",
                    "autocomplete" => "off",
                    "class" => "form-horizontal",
                    "role" => "form"
                )) }}
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            {{ Form::text("username", old("username"), array(
                                "placeholder" => trans('messages.username'),
                                "class" => "form-control"
                            )) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-lock"></span>
                            {{ Form::password("password", array(
                                "placeholder" => Lang::choice('messages.password',1),
                                "class" => "form-control"
                            )) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            {{ Form::button(trans('messages.login'), array(
                                "type" => "submit",
                                "class" => "btn btn-primary btn-block"
                            )) }}
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="smaller-text alone foot">
                    
                </div>
            </div>
            <div class="footer">
            @include('user.loginFooter')
            </div>

        </div>
    </body>
</html>
