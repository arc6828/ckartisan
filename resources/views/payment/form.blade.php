<div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
    <label for="total" class="control-label">{{ 'total' }}</label>
    <input class="form-control" name="total" type="number" id="total" value="{{ isset($payment->total) ? $payment->total : ''}}" readonly>
    {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_name" class="control-label">{{ 'User Name' }}</label>
    <input class="form-control" name="user_name" type="text" id="user_name" value="{{ isset($payment->user_id) ? $payment->user->name : request('user_name') }}" disabled>
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group d-none {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($payment->user_id) ? $payment->user_id : request('user_id')}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
    <label for="remark" class="control-label">{{ 'Remark' }}</label>
    <textarea class="form-control" rows="5" name="remark" type="textarea" id="remark" >{{ isset($payment->remark) ? $payment->remark : ''}}</textarea>
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group d-none {{ $errors->has('paid_at') ? 'has-error' : ''}}">
    <label for="paid_at" class="control-label">{{ 'Paid At' }}</label>
    <input class="form-control" name="paid_at" type="datetime-local" id="paid_at" value="{{ isset($payment->paid_at) ? $payment->paid_at : ''}}" >
    {!! $errors->first('paid_at', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('receipt') ? 'has-error' : ''}}">
    <label for="receipt" class="control-label">{{ 'Payment Receipt' }}</label>
    <input class="form-control" name="receipt" type="file" id="receipt" value="{{ isset($payment->receipt) ? $payment->receipt : ''}}" >
    {!! $errors->first('receipt', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
