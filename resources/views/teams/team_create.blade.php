<div class="modal fade" id="teamCreateModal" tabindex="-1" role="dialog" aria-labelledby="teamCreateModalLabel">
  <form id="team_form" action="{{url($team_form_uri)}}" method="post">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="exampleModalLabel">Create/Edit Team</h4>
      </div>
      <div class="modal-body" id="team_form_modal_content">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Team</button>
      </div>
    </div>
  </div>
</form>
</div>
