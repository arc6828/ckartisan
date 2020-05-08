<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    <label for="address" class="control-label">{{ 'Address' }}</label>
    <textarea class="form-control" rows="5" name="address" type="textarea" id="address" >{{ isset($location->address) ? $location->address : ''}}</textarea>
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('latitude') ? 'has-error' : ''}}">
    <label for="latitude" class="control-label">{{ 'Latitude' }}</label>
    <input class="form-control" name="latitude" type="text" id="latitude" value="{{ isset($location->latitude) ? $location->latitude : ''}}" >
    {!! $errors->first('latitude', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('longitude') ? 'has-error' : ''}}">
    <label for="longitude" class="control-label">{{ 'Longitude' }}</label>
    <input class="form-control" name="longitude" type="text" id="longitude" value="{{ isset($location->longitude) ? $location->longitude : ''}}" >
    {!! $errors->first('longitude', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('typegroup') ? 'has-error' : ''}}">
    <label for="typegroup" class="control-label">{{ 'Typegroup' }}</label>
    <input class="form-control" name="typegroup" type="text" id="typegroup" value="{{ isset($location->typegroup) ? $location->typegroup : ''}}" >
    {!! $errors->first('typegroup', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('lineid') ? 'has-error' : ''}}">
    <label for="lineid" class="control-label">{{ 'Lineid' }}</label>
    <input class="form-control" name="lineid" type="text" id="lineid" value="{{ isset($location->lineid) ? $location->lineid : ''}}" >
    {!! $errors->first('lineid', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('staffgaugeid') ? 'has-error' : ''}}">
    <label for="staffgaugeid" class="control-label">{{ 'Staffgaugeid' }}</label>
    <input class="form-control" name="staffgaugeid" type="text" id="staffgaugeid" value="{{ isset($location->staffgaugeid) ? $location->staffgaugeid : ''}}" >
    {!! $errors->first('staffgaugeid', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($location->user_id) ? $location->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('msglocid') ? 'has-error' : ''}}">
    <label for="msglocid" class="control-label">{{ 'Msglocid' }}</label>
    <input class="form-control" name="msglocid" type="text" id="msglocid" value="{{ isset($location->msglocid) ? $location->msglocid : ''}}" >
    {!! $errors->first('msglocid', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
