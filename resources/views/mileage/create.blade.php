@extends('app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {!! Form::open(array('route' => 'mileage.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
            <legend>Submit Your Expenses</legend>
            <div class="form-group">
                {!! Form::label('Mileage') !!}
                {!! Form::file('mileage', null, array('class' => 'form-control input-lg')) !!}
                @include('partials/forms/_error', [ 'field' => 'mileage' ] )
            </div>

            {!! Form::submit('Submit', array('name' => 'submit', 'class' => 'button button-secondary button-large')) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop