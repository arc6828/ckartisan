<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($fastwork->title) ? $fastwork->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" >{{ isset($fastwork->content) ? $fastwork->content : ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('deadline') ? 'has-error' : ''}}">
    <label for="deadline" class="control-label">{{ 'Deadline' }}</label>
    <input class="form-control" name="deadline" type="date" id="deadline" value="{{ isset($fastwork->deadline) ? $fastwork->deadline : ''}}" >
    {!! $errors->first('deadline', '<p class="help-block">:message</p>') !!}
</div>
@if(false)
<div class="d-none form-group {{ $errors->has('reserve_date') ? 'has-error' : ''}}">
    <label for="reserve_date" class="control-label">{{ 'Reserve Date' }}</label>
    <input class="form-control" name="reserve_date" type="datetime-local" id="reserve_date" value="{{ isset($fastwork->reserve_date) ? $fastwork->reserve_date : ''}}"  disabled>
    {!! $errors->first('reserve_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="d-none form-group {{ $errors->has('accept_date') ? 'has-error' : ''}}">
    <label for="accept_date" class="control-label">{{ 'Accept Date' }}</label>
    <input class="form-control" name="accept_date" type="datetime-local" id="accept_date" value="{{ isset($fastwork->accept_date) ? $fastwork->accept_date : ''}}"  disabled>
    {!! $errors->first('accept_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="d-none form-group {{ $errors->has('complete_date') ? 'has-error' : ''}}">
    <label for="complete_date" class="control-label">{{ 'Complete Date' }}</label>
    <input class="form-control" name="complete_date" type="datetime-local" id="complete_date" value="{{ isset($fastwork->complete_date) ? $fastwork->complete_date : ''}}" disabled>
    {!! $errors->first('complete_date', '<p class="help-block">:message</p>') !!}
</div>
@endif
<div class="form-group {{ $errors->has('hours') ? 'has-error' : ''}}">
    <label for="hours" class="control-label">{{ 'Hours' }}  </label>
    <input class="form-control" name="hours" type="number" step="any" id="hours" value="{{ isset($fastwork->hours) ? $fastwork->hours : '0'}}" onkeyup="calculatePrice();">
    {!! $errors->first('hours', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('price_per_hour') ? 'has-error' : ''}}">
    <label for="price_per_hour" class="control-label">{{ 'Price per Hour' }}</label>
    <input class="form-control" name="price_per_hour" type="number" step="any" id="price_per_hour" value="{{ isset($fastwork->price_per_hour) ? $fastwork->price_per_hour : '0'}}" onkeyup="calculatePrice();">
    {!! $errors->first('price_per_hour', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    <label for="price" class="control-label">{{ 'Price' }}</label>
    <input class="form-control" name="price" type="number" step="any" id="price"  value="{{ isset($fastwork->price) ? $fastwork->price : '0'}}" readonly>
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('developer_id') ? 'has-error' : ''}}">
    <label for="developer_id" class="control-label">{{ 'Developer' }}</label>
    <input class="form-control" name="developer_name" type="text" id="developer_name" value="{{ isset($fastwork->developer->name) ? $fastwork->developer->name : ''}}" disabled>
    <input class="form-control" name="developer_id" type="hidden" id="developer_id" value="{{ isset($fastwork->developer_id) ? $fastwork->developer_id : ''}}" disabled>
    <select class="form-control" name="developer_id" id="developer_id">
        @php
          $developer_id = isset($fastwork->developer_id) ? $fastwork->developer_id : '';
        @endphp
        @foreach($profiles as $profile)
        <option value="{{ $profile->user_id }}"  {{ ( $profile->user_id  ==  $developer_id  ) ? 'selected' : '' }} >
            {{ $profile->user->name }}
        </option>
        @endforeach
    </select>
    {!! $errors->first('developer_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ isset($fastwork->status) ? $fastwork->status : ''}}" readonly>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
    <label for="project_id" class="control-label">{{ 'Project Id' }}</label>
    <select class="form-control" name="project_id" id="project_id">
        @php
          $project_id = isset($fastwork->project_id) ? $fastwork->project_id : '';
        @endphp
        @foreach($projects as $project)
        <option value="{{ $project->id }}"  {{ ( $project->id  ==  $project_id  ) ? 'selected' : '' }} >
            {{ $project->title }}
        </option>
        @endforeach
    </select>
    {!! $errors->first('project_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_name" type="text" id="user_name" value="{{ isset($fastwork->user->name) ? $fastwork->user->name : Auth::user()->name }}"  disabled>

    <input class="form-control" name="user_id" type="hidden" id="user_id" value="{{ isset($fastwork->user_id) ? $fastwork->user_id : Auth::id()}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
    <label for="remark" class="control-label">{{ 'Remark' }}</label>
    <textarea class="form-control" rows="5" name="remark" type="textarea" id="remark" >{{ isset($fastwork->remark) ? $fastwork->remark : ''}}</textarea>
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
    <label for="photo" class="control-label">{{ 'Photo' }}</label>
    <input class="form-control" name="photo" type="file" id="photo" value="{{ isset($fastwork->photo) ? $fastwork->photo : ''}}" >
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>


<script>
function calculatePrice(){
    var price_per_hour = parseFloat(document.querySelector("#price_per_hour").value);
    var hours = parseFloat(document.querySelector("#hours").value);
    var price = price_per_hour * hours;
    document.querySelector("#price").value = price;
}
</script>