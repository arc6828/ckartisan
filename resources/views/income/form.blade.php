<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($income->title) ? $income->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
    <label for="remark" class="control-label">{{ 'Remark' }}</label>
    <textarea class="form-control" rows="5" name="remark" type="textarea" id="remark" >{{ isset($income->remark) ? $income->remark : ''}}</textarea>
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
    <label for="project_id" class="control-label">{{ 'Project Id' }}</label>
    <select class="form-control" name="project_id" id="project_id">
        @php
          $project_id = isset($income->project_id) ? $income->project_id : '';
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
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($income->user_id) ? $income->user_id : Auth::id() }}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
    <label for="total" class="control-label">{{ 'Total' }}</label>
    <input class="form-control" name="total" type="number" id="total" value="{{ isset($income->total) ? $income->total : ''}}" >
    {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('paid_date') ? 'has-error' : ''}}">
    <label for="paid_date" class="control-label">{{ 'Paid Date' }}</label>
    <input class="form-control" name="paid_date" type="date" id="paid_date" value="{{ isset($income->paid_date) ? $income->paid_date : ''}}" >
    {!! $errors->first('paid_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('receipt') ? 'has-error' : ''}}">
    <label for="receipt" class="control-label">{{ 'Receipt' }}</label>
    <input class="form-control" name="receipt" type="file" id="receipt" value="{{ isset($income->receipt) ? $income->receipt : ''}}" >
    {!! $errors->first('receipt', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
