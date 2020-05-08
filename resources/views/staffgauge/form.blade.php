<div class="form-group {{ $errors->has('latitudegauge') ? 'has-error' : ''}}">
    <label for="latitudegauge" class="control-label">{{ 'Latitudegauge' }}</label>
    <input class="form-control" name="latitudegauge" type="text" id="latitudegauge" value="{{ isset($staffgauge->latitudegauge) ? $staffgauge->latitudegauge : ''}}" >
    {!! $errors->first('latitudegauge', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('longitudegauge') ? 'has-error' : ''}}">
    <label for="longitudegauge" class="control-label">{{ 'Longitudegauge' }}</label>
    <input class="form-control" name="longitudegauge" type="text" id="longitudegauge" value="{{ isset($staffgauge->longitudegauge) ? $staffgauge->longitudegauge : ''}}" >
    {!! $errors->first('longitudegauge', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('addressgauge') ? 'has-error' : ''}}">
    <label for="addressgauge" class="control-label">{{ 'Addressgauge' }}</label>
    <textarea class="form-control" rows="5" name="addressgauge" type="textarea" id="addressgauge" >{{ isset($staffgauge->addressgauge) ? $staffgauge->addressgauge : ''}}</textarea>
    {!! $errors->first('addressgauge', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('amphoe') ? 'has-error' : ''}}">
    <label for="amphoe" class="control-label">{{ 'Amphoe' }}</label>
    <input class="form-control" name="amphoe" type="text" id="amphoe" value="{{ isset($staffgauge->amphoe) ? $staffgauge->amphoe : ''}}" >
    {!! $errors->first('amphoe', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('district') ? 'has-error' : ''}}">
    <label for="district" class="control-label">{{ 'District' }}</label>
    <input class="form-control" name="district" type="text" id="district" value="{{ isset($staffgauge->district) ? $staffgauge->district : ''}}" >
    {!! $errors->first('district', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province') ? 'has-error' : ''}}">
    <label for="province" class="control-label">{{ 'Province' }}</label>
    <input class="form-control" name="province" type="text" id="province" value="{{ isset($staffgauge->province) ? $staffgauge->province : ''}}" >
    {!! $errors->first('province', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
