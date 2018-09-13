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
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.add_project.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Edit Project</legend>
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        <input type="text" class="form-control" id="project_name" aria-describedby="projectNameHelp" placeholder="Enter the title of your project" name="project_name"{% if request.post('project_name') %} value="{{request.post('project_name')}}" {% endif %}>
                        {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_category">Project Category</label>
                        <select class="form-control" id="project_category" name="project_category">
                            <option>-- select project category --</option>
                            <option>Web Application</option>
                            <option>Data Mining</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_description">Project Description</label>
                        <textarea class="form-control" rows="5" id="project_description" aria-describedby="projectDescriptionHelp" placeholder="Add a brief description about your project" name="project_description"></textarea>
                        {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_start_date">Project start date</label>
                        <input type="date" name="project_start_date" class="form-control" id="project_start_date">
                        {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_end_date">Project end date</label>
                        <input type="date" name="project_end_date" class="form-control" id="project_end_date">
                        {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        <select class="form-control" id="project_type" name="project_type">
                            <option>-- select project type --</option>
                            <option>Taught</option>
                            <option>Research</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_aim">Project Aim(s)</label>
                        <textarea class="form-control" rows="5" id="project_aim" aria-describedby="projectDescriptionHelp" placeholder="Add your project aim(s)" name="project_aim"></textarea>
                        {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                    </div>
                </div>
            </div>

            <!--<div class="form-group form-inline">
                <label for="accountStatus">Account status:</label>
                <select class="form-control" id="accountStatus" style="width: 10%;">
                    <option>Active</option>
                    <option>Inactive</option>
                  </select>
            </div>-->
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.view_project_detail') }}">&larr; Back</a></button>
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
