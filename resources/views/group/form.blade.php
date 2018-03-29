{!! Form::model($group, [ 'route' => ['group.'.$action, $group->id], 'class' => 'form-horizontal', 'data-validate' => 'true' ]) !!}

{!! Form::hidden('id', $group->id) !!}
<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', $group->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Name of the client']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('warning', 'Warning Time', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::number('warning', $group->warning, ['id' => 'warning', 'class' => 'form-control', 'placeholder' => 'Warning Time (in seconds)']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('critical', 'Critical Time', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::number('critical', $group->critical, ['id' => 'critical', 'class' => 'form-control', 'placeholder' => 'Critical Time (in seconds)']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
        <a href="{{ route('group.list') }}" class="btn btn-danger btn-flat">Cancel</a>
    </div>
</div>
{!! Form::close() !!}