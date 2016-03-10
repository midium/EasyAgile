<input type="hidden" name="id" value="" id="role_id" />
<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

<div class="row">
    <div class="form-group">
        <label>Name:</label>
        <input id="name" value="{{ (isset($form_role))?$form_role->name:'' }}" type="text" name="name" class="form-control" autocomplete="off" placeholder="ex. PHP Developer" required />
    </div>
</div>
