{!! Form::model($user, [ 'route' => ['user.'.$action, $user->id], 'class' => 'form-horizontal', 'data-validate' => 'true', 'autocomplete' => 'off' ]) !!}

{!! Form::hidden('id', $user->id) !!}
<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', $user->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Name of the user']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email ID', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::email('email', $user->email, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email ID']) !!}
    </div>
</div>

@if(!$user->id)
<div class="form-group">
    {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('password', $user->password, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Plain password']) !!}
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
        <a href="{{ route('user.list') }}" class="btn btn-danger btn-flat">Cancel</a>
    </div>
</div>
{!! Form::close() !!}