<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($profile->user->name) ? $profile->user->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ isset($profile->user->email) ? $profile->user->email : ''}}" disabled>
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="role" class="control-label">{{ 'Role' }}</label>
    <input class="form-control" name="role" type="text" id="role" value="{{ isset($profile->role) ? $profile->role : ''}}" disabled >
    {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($profile->user_id) ? $profile->user_id : ''}}"  disabled>
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('bank_name') ? 'has-error' : ''}}">
    <label for="bank_name" class="control-label">{{ 'ชื่อธนาคาร' }}</label>
    <input class="form-control" name="bank_name" type="text" id="bank_name" value="{{ isset($profile->bank_name) ? $profile->bank_name : ''}}" placeholder="เช่น กรุงไทย, ไทยพาณิชย์, กสิกร เป็นต้น" >
    {!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('bank_account') ? 'has-error' : ''}}">
    <label for="bank_account" class="control-label">{{ 'เลขที่บัญชีธนาคาร' }}</label>
    <input class="form-control" name="bank_account" type="text" id="bank_account" value="{{ isset($profile->bank_account) ? $profile->bank_account : ''}}" placeholder="เช่น 123-123-55555-5 เป็นต้น" >
    {!! $errors->first('bank_account', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
    <label for="photo" class="control-label">{{ 'Photo' }}</label>
    <input class="form-control" name="photo" type="file" id="photo" value="{{ isset($profile->photo) ? $profile->photo : ''}}" >
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
