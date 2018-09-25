{% extends 'templates/default.php' %}

{% block title %}Edit Project{% endblock %}

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

            {% for project in projects %}
            <form action="{{ urlFor('student.edit_project.post', {id: project.project_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Edit Project</legend>
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        {% for project in projects %}
                        <input type="text" class="form-control" id="project_name" aria-describedby="projectNameHelp" placeholder="Enter the title of your project" name="project_name" value="{{ request.post('project_name') ? request.post('project_name') : project.project_name }}">
                        {% endfor %}
                        {% if errors.has('project_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_name')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_category">Project Category</label>
                        <select class="form-control" id="project_category" name="project_category">
                            <option>-- select project category --</option>
                            {% for project in projects %}
                                {% for pc in project_categories %}
                                    {% if project.project_cat_id == pc.project_cat_id %}
                                       <option value="{{ pc.project_cat_id }}" selected>{{ pc.project_category }}</option>
                                    {% else %}
                                        <option value="{{ pc.project_cat_id }}">{{ pc.project_category }}</option>
                                    {% endif %}
                                {% endfor %}
                            {% endfor %}   
                        </select>
                        {% if errors.has('project_category')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_category')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_description">Project Description</label>
                        {% for project in projects%}
                        <textarea class="form-control" rows="5" id="project_description" aria-describedby="projectDescriptionHelp" placeholder="Add a brief description about your project" name="project_description">{{ request.post('project_description') ? request.post('project_description') : project.project_description }}</textarea>
                        {% endfor %}
                        {% if errors.has('project_description')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_description')}}</small>{% endif %}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_start_date">Project start date</label>
                        {% for project in projects%}
                        <input type="date" name="project_start_date" class="form-control" id="project_start_date" value='{{ request.post("project_start_date") ? request.post("project_start_date") : project.project_start_date|date("Y-m-d") }}'>
                        {% endfor %}
                        {% if errors.has('project_start_date')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_start_date')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_end_date">Project end date</label>
                        {% for project in projects%}
                        <input type="date" name="project_end_date" class="form-control" id="project_end_date" value='{{ request.post("project_end_date") ? request.post("project_end_date") : project.project_end_date|date("Y-m-d") }}'>
                        {% endfor %}
                        {% if errors.has('project_end_date')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_end_date')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        <select class="form-control" id="project_type" name="project_type">
                            <option>-- select project type --</option>
                            {% for project in projects %}
                                {% for pt in project_types %}
                                    {% if project.project_type_id == pt.project_type_id %}
                                       <option value="{{ pt.project_type_id }}" selected>{{ pt.project_type }}</option>
                                    {% else %}
                                        <option value="{{ pt.project_type_id }}">{{ pt.project_type }}</option>
                                    {% endif %}
                                {% endfor %}
                            {% endfor %}
                        </select>
                        {% if errors.has('project_type')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_type')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_aim">Project Aim(s)</label>
                        {% for project in projects %}
                        <textarea class="form-control" rows="5" id="project_aim" aria-describedby="projectDescriptionHelp" placeholder="Add your project aim(s)" name="project_aim">{{ request.post('project_aim') ? request.post('project_aim') : project.project_aims }}</textarea>
                        {% endfor %}
                        {% if errors.has('project_aim')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_aim')}}</small>{% endif %}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                    <button type="button" class="btn btn-link" name="back"><a href="{{ urlFor('student.view_project_detail') }}">&larr; Back</a></button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                </div>
            </div>
            <div class="col-sm-6"></div>
        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for editing your project</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
