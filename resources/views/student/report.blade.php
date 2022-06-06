@extends("layout")
@section("content")

    <style type="text/css">

    </style>
    <div>
        <ol class="breadcrumb">
            <li><a href="{{{route('user.home')}}}">{{ trans('messages.home') }}</a></li>
            <li class="active"><a href="{{ route('student.index') }}">Lab Records</a></li>
            <li class="active">Report</li>
        </ol>
    </div>
    {{ Form::open(array('route' => array('lab.report'), 'id' => 'prevalence_rates', 'method' => 'post')) }}
    <div class="container-fluid">
        <div class="row report-filter">
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('start', trans("messages.from")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'),
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-2">
                    {{ Form::label('to', trans("messages.to")) }}
                </div>
                <div class="col-md-10">
                    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'),
                        array('class' => 'form-control standard-datepicker')) }}
                </div>
            </div>
            <div class="col-md-3">
                {{Form::submit(trans('messages.view'),
                    array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
            </div>
            <div class="col-sm-3">
                {{Form::submit(trans('Export to Excel'), 
                    array('class' => 'btn btn-success', 'id'=>'excel', 'name'=>'excel'))}}
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <br />
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-8">
                        <span class="glyphicon glyphicon-user"></span>
                        Lab Report
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <!-- if there are filter errors, they will show here -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
            @endif
            <div class="table-responsive">
                <div id="summary">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="rates">
                            <tbody>
                            <tr>
                                <th>Course</th>
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                            @foreach($data as $key => $stat)
                                <tr>
                                    <td>{{$stat->name}}</td>
                                    <td>{{$stat->male}}</td>
                                    <td>{{$stat->female}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@stop
