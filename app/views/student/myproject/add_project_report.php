{% extends 'templates/default.php' %}

{% block title %}Add Project Report{% endblock %}

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
            <form action="{{ urlFor('student.add_project_report.post') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            
                <fieldset>
                    <legend class="text-center">Add Project Report</legend>
                    <div class="col-sm-3"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                          <label for="project_report_file">Add Project Report:</label>
                          <div class="input-group">
                              <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                      {% for pr in project_report %}
                                      Browse&hellip; <input type="file" style="display: none;" id="project_report_file" name="project_report_file" value="{{ request.post('project_report_file') ? request.post('project_report_file') : pr.final_project_report_file }}">
                                      {% endfor %}
                                  </span>
                              </label>
                              {% for pr in project_report %}
                              <input type="text" class="form-control" name="project_report_name" value="{{ request.post('project_report_name') ? request.post('project_report_name') : pr.final_project_report_file_name }}" readonly>
                              {% endfor %}
                          </div>
                          {% if errors.has('project_report_file')%}<small class="form-text text-muted" style="color: red;">{{errors.first('project_report_file')}}</small>{% endif %}
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="add">Add Report</button><br><br> 
                        <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                    </div>

                    <div class="col-sm-3"></div>

                    <div class="col-sm-12">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-10">
                        <div class="table-responsive">
                          <table id="" class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Project Report</th>
                                      <th>Approved</th>
                                      <th>Supervisor Comments</th>
                                  </tr>
                              </thead>
                              <tbody>
                                {% for pr in project_report %}
                                {% if pr.final_project_report_file_name is empty %}
                                  <td colspan="3"><h4 style="text-align: center; color: gray;">you have not added your project report!</h4></td>
                                {% else %}
                                  <tr>
                                      <td>{{ pr.final_project_report_file_name }}</td>
                                      <td>
                                          {% if pr.is_final_project_report_approved is empty %}
                                              <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                          {% else %}
                                              <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                          {% endif %}
                                      </td>
                                      <td>
                                        {% if pr.supervisor_comments is empty %}
                                          <p style="color: gray;"><b>* no supervisor comments...</b></p>
                                        {% else %}
                                          <p>{{ pr.supervisor_comments }}</p>
                                        {% endif %}
                                      </td>
                                  </tr>
                                  {% endif %}
                                 {% endfor %} 
                              </tbody>
                          </table>
                      
                        </div>
                      </div>
                      <div class="col-sm-1"></div>
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding your final project report or thesis to the system</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
