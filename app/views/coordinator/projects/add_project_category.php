{% extends 'templates/default.php' %}

{% block title %}Add Project Category{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project Categories</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('coordinator.add_project_category') }}">Add</a></p> 
                     <p><a href="{{ urlFor('coordinator.view_project_category') }}">View</a></p> 
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Project Types</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.add_project_type') }}">Add</a></p>
                      <p><a href="{{ urlFor('coordinator.view_project_type') }}">View</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Supervision</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.assign_supervisors') }}">Assign Supvervisors</a></p>
                      <p><a href="{{ urlFor('coordinator.view_assigned_supervisors') }}">View Assigned Supvervisors</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Student Projects</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.view_projects') }}">View Projects</a></p>
                  </div>
                </div>
          </div>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
          {% include 'templates/partials/error_messages.php' %}
          {% include 'templates/partials/success_messages.php' %}
          {% include 'templates/partials/info_messages.php' %}
          {% include 'templates/partials/warning_messages.php' %}
          <form action="{{ urlFor('coordinator.add_project_category.post') }}" method="POST" autocomplete="off">
          
<fieldset>
          <legend class="text-center">Add Project Category</legend>

          <div class="col-sm-3"></div>

          <div class="col-sm-6">
            
            <div class="form-group">
                    <label for="project_category">Project Category</label>
                    <input type="text" class="form-control" id="project_category" aria-describedby="project_categoryHelp" placeholder="Enter project category" name="project_category"{% if request.post('project_category') %} value="{{request.post('project_category')}}" {% endif %} required>
                    {% if errors.has('project_category')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_category')}}</small>{% endif %}
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
          <div class="col-sm-3"></div>
         
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding project categories</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
