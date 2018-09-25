{% extends 'templates/default.php' %}

{% block title %}Edit Project Objective{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_project') }}">Add Project</a></p>
                     <p><a href="{{ urlFor('student.view_project_detail') }}">View Project Details</a></p>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Project Objectives</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_project_objective') }}">Add</a></p>  
                     <p><a href="{{ urlFor('student.view_project_objective') }}">View</a></p> 
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}

            {% for po in project_objective %}
            <form action="{{ urlFor('student.edit_project_objective.post', {id: po.po_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Edit Project Objective</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_objective">Project Objective</label>
                        {% for po in project_objective %}
                        <input type="text" class="form-control" id="project_objective" aria-describedby="projectObjectiveHelp" placeholder="Enter project objective" name="project_objective" value="{{ request.post('project_objective') ? request.post('project_objective') : po.project_objective }}">
                        {% endfor %}
                        {% if errors.has('project_objective')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_objective')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary" name="save">Save</button>
                    <button type="button" class="btn btn-link" name="back"><a href="{{ urlFor('student.view_project_objective') }}">&larr; Back</a></button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form>
    
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for editing your project objectives</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
