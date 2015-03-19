@if($errors->has($field))
    <div class="alert alert-danger spacer-top-1x">
        <span class="error-text error-danger"><i class="fa fa-warning"></i>{!! $errors->first($field, ':message') !!}</span>
    </div>
@endif