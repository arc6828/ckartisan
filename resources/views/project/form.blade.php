<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($project->title) ? $project->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" >{{ isset($project->content) ? $project->content : ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('begin_date') ? 'has-error' : ''}}">
    <label for="begin_date" class="control-label">{{ 'Begin Date' }}</label>
    <input class="form-control" name="begin_date" type="date" id="begin_date" value="{{ isset($project->begin_date) ? $project->begin_date : ''}}" >
    {!! $errors->first('begin_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('deadline') ? 'has-error' : ''}}">
    <label for="deadline" class="control-label">{{ 'Deadline' }}</label>
    <input class="form-control" name="deadline" type="date" id="deadline" value="{{ isset($project->deadline) ? $project->deadline : ''}}" >
    {!! $errors->first('deadline', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('complete_date') ? 'has-error' : ''}}">
    <label for="complete_date" class="control-label">{{ 'Complete Date' }}</label>
    <input class="form-control" name="complete_date" type="datetime-local" id="complete_date" value="{{ isset($project->complete_date) ? $project->complete_date : ''}}" >
    {!! $errors->first('complete_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_name" type="text" id="user_name" value="{{ isset($project->user_id) ? $project->user->name : Auth::user()->name }}" disabled >
    <input class="form-control" name="user_id" type="hidden" id="user_id" value="{{ isset($project->user_id) ? $project->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
    <label for="remark" class="control-label">{{ 'Remark' }}</label>
    <textarea class="form-control" rows="5" name="remark" type="textarea" id="remark" >{{ isset($project->remark) ? $project->remark : ''}}</textarea>
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
    <label for="photo" class="control-label">{{ 'Photo' }}</label>
    <input class="form-control" name="photo" type="file" id="photo" value="{{ isset($project->photo) ? $project->photo : ''}}" >
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
