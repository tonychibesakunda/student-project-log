{% extends 'templates/default.php' %}

{% block title %}View Project Details{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('student.view_projects') }}">View Completed Projects</a></p>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.view_project_details.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">Project Details</legend>

                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.view_projects') }}">&larr; Back</a></button>
                    </div>
                    <div class=" col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                {% for pd in project_details %}
                                <h3 class="panel-title"><b>{{ pd.stFName }} {{ pd.stONames }} {{ pd.stLName }}</b></h3>
                                {% endfor %}
                            </div>
                            <div class="panel-body">
                                
                                 <div class="table-responsive">
                                  <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <th>Student Name:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.stFName }} {{ pd.stONames }} {{ pd.stLName }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Supervisor Name:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.suFName }} {{ pd.suONames }} {{ pd.suLName }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Title:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.projectName }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Category:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.project_category }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Type:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.project_type }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Start Date:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.project_start_date|date("d-M-Y") }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project End Date:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.project_end_date|date("d-M-Y") }}</td>
                                            {% endfor %}
                                        </tr>
                                    </tbody>
                                  </table>
                                </div><!-- end of table responsive -->
                            </div><!-- end of panel body div -->  
                          </div><!-- end of panel div -->
                          <h4><b>Project Aims:</b></h4>
                          {% for pd in project_details %}
                              <p>{{ pd.project_aims }}</p><br>
                          {% endfor %}
                          <div class="item-page-field-wrapper table word-break">
                            <h4><b>Project Report (Thesis):</b></h4>
                            <div>
                                {% for pd in project_details %}
                                <a href="/sprl_slim/uploads/project_reports/{{ pd.final_project_report_new_file_name }}"><i aria-hidden="true" class="glyphicon  glyphicon-file"></i> {{ pd.final_project_report_file_name }}</a>
                                {% endfor %}
                            </div>
                        </div>
                        </div><!-- end of col-sm-6 div -->

                      <div class="col-sm-6">
                          <h4><b>Project Description:</b></h4>
                          {% for pd in project_details%}
                          <p>{{ pd.project_description }}</p>
                          {% endfor %}
                      </div>

                      <div class="col-sm-12">
                        <h3 style="text-align: center;"><b>Tasks taken during the project</b></h3>
                          <div class="table-responsive">
                            <table id="myTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Agreed On</th>
                                        <th>Task</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for ts in tasks %}    
                                        <tr>
                                            <td>{{ ts.scheduled_date|date("d-M-Y") }}</td>
                                            <td>{{ ts.task_description }}</td>
                                            <td>
                                               <a href="/sprl_slim/uploads/tasks/{{ ts.new_file_name }}"><i aria-hidden="true" class="glyphicon  glyphicon-file"></i> {{ ts.file_name }}</a> 
                                            </td>
                                        </tr>
                                    {% endfor %}    
                                </tbody>
                            </table>
                        </div>
                      </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                            
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing project details</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
