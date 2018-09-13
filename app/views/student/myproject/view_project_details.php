{% extends 'templates/default.php' %}

{% block title %}View Project{% endblock %}

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
            <legend class="text-center">View Project Details</legend>
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_name">Project Name:</label>
                        <p>Student Project Logbook</p>
                        {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_category">Project Category</label>
                        <p>Project Category</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_description">Project Description:</label>
                        <p>this project will what and what</p>
                        {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_start_date">Project start date:</label>
                        <p>12-Aug-2018</p>
                        {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_end_date">Project end date:</label>
                        <p>10-Oct-2018</p>
                        {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        <p>Project Type</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_aim">Project Aim(s):</label>
                        <p>To develop a web based system that keeps track of a student's project</p>
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
                    <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.edit_project') }}">Edit Details</a></button>
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
                <p>This section is used for viewing your project details</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
