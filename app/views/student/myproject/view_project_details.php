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
                     <p><a href="{{ urlFor('student.view_project_objective') }}">View</a></p>   
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Project Report</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('student.add_project_report') }}">Add</a></p>  
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="#" method="POST" autocomplete="off">
                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
            </form>
            
<fieldset>
            <legend class="text-center">View Project Details</legend>
            {% if projects is empty %}

                <h2 style="color: gray; text-align: center;"><b>You have not yet added a project to the system!<b></h2>
            {% else %}
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_name">Project Name:</label>
                        {% for project in projects %}
                            <p>{{ project.project_name }}</p>
                        {% endfor %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_category">Project Category</label>
                        {% for project in projects %}
                            {% for pc in project_categories %}
                                {% if project.project_cat_id == pc.project_cat_id %}
                                    <p>{{ pc.project_category }}</p>
                                {% endif %}
                            {% endfor %}
                        {% endfor %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_description">Project Description:</label>
                        {% for project in projects %}
                            <textarea class="form-control" rows="5" id="project_description" aria-describedby="projectDescriptionHelp" name="project_description" readonly>{{ project.project_description }}</textarea>
                        {% endfor %}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_start_date">Project start date:</label>
                        {% for project in projects %}
                            <p>{{ project.project_start_date|date("d-M-Y") }}</p>
                        {% endfor %}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_end_date">Project end date:</label>
                        {% for project in projects %}
                            <p>{{ project.project_end_date|date("d-M-Y") }}</p>
                        {% endfor %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        {% for project in projects %}
                            {% for pt in project_types %}
                                {% if project.project_type_id == pt.project_type_id %}
                                    <p>{{ pt.project_type }}</p>
                                {% endif %}
                            {% endfor %}
                        {% endfor %}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="project_aim">Project Aim(s):</label>
                        {% for project in projects %}
                            <textarea class="form-control" rows="5" id="project_aim" aria-describedby="projectDescriptionHelp" name="project_aim" readonly>{{ project.project_aims }}</textarea>
                        {% endfor %}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                    {% for project in projects %}
                    <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.edit_project', {id:project.project_id}) }}">Edit Details</a></button>
                    {% endfor %}
                       
            </div>
        {% endif %}
        </fieldset>
    
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
