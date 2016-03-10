<input type="hidden" name="id" value="{{ (isset($epic))?$epic->id:'' }}" id="epic_id" />
<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

<div class="row">
    <div class="form-group">
        <label>Name:</label>
        <input id="name" value="{{ (isset($epic))?$epic->name:'' }}" type="text" name="name" class="form-control" autocomplete="off" placeholder="ex. Application GUI" required />
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Description:</label>
        <input id="description" value="{{ (isset($epic))?$epic->description:'' }}" type="text" name="description" class="form-control" autocomplete="off" placeholder="ex. This Epic will contains all the tasks related to the application GUI." />
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Color:</label>
        <input type="text" id="color" name="color" class="form-control" value="{{(isset($epic))?$epic->color:''}}" autocomplete="off">
    </div>

</div>

<script>
$('input#color').minicolors({
                    control: 'hue',
                    hideSpeed: 100,
                    position: 'bottom left',
                    change: function(hex, opacity) {
                        if( !hex ) return;
                        if( opacity ) hex += ', ' + opacity;

                        $('input.color').val(hex);

                    },
                    theme: 'bootstrap'
                });
</script>
