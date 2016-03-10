                <form action="{{URL::to($uri)}}" method="post" id="save_project" class="form" enctype="multipart/form-data">
                  @include('projects.forms.project_details_form_body')
                  <div class="row">
                    @if(!isset($isSettings) || $isSettings == false)
                      <button type="button" class="btn btn-default" id="cancel">Abort<div class="ripple-wrapper"></div></button>
                    @endif
                    @if(Auth::user()->role->id ==11 || ($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3))
                      <button type="submit" class="btn btn-primary pull-right">Save</button>
                    @else
                      @if(Auth::user()->id == $project->manager->id && $project->status->id != 5)
                      <button type="submit" class="btn btn-primary pull-right">Save</button>
                      @endif
                    @endif
                  </div>
                </form>
