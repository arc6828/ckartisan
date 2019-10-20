<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($fastworkstatus->title) ? $fastworkstatus->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('fastwork_id') ? 'has-error' : ''}}">
    <label for="fastwork_id" class="control-label">{{ 'Fastwork Id' }}</label>
    <input class="form-control" name="fastwork_id" type="number" id="fastwork_id" value="{{ isset($fastworkstatus->fastwork_id) ? $fastworkstatus->fastwork_id : ''}}" >
    {!! $errors->first('fastwork_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
