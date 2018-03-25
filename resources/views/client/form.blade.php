{!! Form::model($client, [ 'route' => ['client.'.$action, $client->id], 'class' => 'form-horizontal', 'data-validate' => 'true' ]) !!}

{!! Form::hidden('id', $client->id) !!}
<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', $client->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Name of the client']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('external_id', 'External ID', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('external_id', $client->external_id, ['id' => 'external_id', 'class' => 'form-control', 'placeholder' => 'External ID of the client']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('group', 'Group', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('group_id', \App\Entity\Group::pluck('name', 'id'), $client->group) !!}
    </div>
</div>


<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        {!! Form::checkbox('alive', $client->alive, true) !!} Is Alive
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
        <a href="{{ route('client.list') }}" class="btn btn-danger btn-flat">Cancel</a>
    </div>
</div>
{!! Form::close() !!}