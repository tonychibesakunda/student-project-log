{% extends 'templates/default.php' %}

{% block title %}Assign Supervisors{% endblock %}

{% block content %}
	<div class="container-fluid text-center" style="margin-bottom: 10%;">
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
          <form action="{{ urlFor('coordinator.assign_supervisors.post') }}" method="POST" autocomplete="off">
          
<fieldset>
          <legend class="text-center">Assign Supervisors</legend>

          <div class="col-sm-3"></div>

          <div class="col-sm-6">
            
            <div class="form-group">
              <label for="selectStudent">Student:</label>
              <select class="form-control" id="selectStudent" name="selectStudent">
                {% if unassignedStudents is empty %}
                    <option>All students have been assigned</option>
                {% else %}
                    <option>-- select student --</option>
                    {% for student in unassignedStudents %}
                    <option value="{{ student.id }}">{{ student.first_name }} {{ student.other_names }} {{ student.last_name }}</option>
                    {% endfor %}
                {% endif %}
              </select>
              {% if errors.has('selectStudent')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectStudent')}}</small>{% endif %}
            </div>

            <div class="form-group">
              <label for="selectSupervisor">Supervisor:</label>
              <select class="form-control" id="selectSupervisor" name="selectSupervisor">
                {% if supervisors is empty %}
                    <option>No supervisor records</option>
                {% else %}
                    <option>-- select supervisor --</option>
                    {% for supervisor in supervisors %}
                    <option value="{{ supervisor.id }}">{{ supervisor.first_name }} {{ supervisor.other_names }} {{ supervisor.last_name }}</option>
                    {% endfor %}
                {% endif %}
              </select>
              {% if errors.has('selectSupervisor')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSupervisor')}}</small>{% endif %}
            </div>
            
            <button type="submit" class="btn btn-primary">Assign</button>
          </div>
          <div class="col-sm-3"></div>
         
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

        </fieldset><br><br>
    </form>

    <fieldset>
      <legend class="text-center">Unassigned Students and Supervisors</legend>
                    <div class="col-sm-2"></div>

                    <div class="col-sm-8">
                      <h3><b>Students</b></h3>
                      <div class="table-responsive">
                        <table id="myTable" class="table table-bordered display">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                              {% if unassignedStudents is empty %}
                                <tr>
                                  <td colspan="2"><h4 style="text-align: center; color: gray;">no unassigned student records found in the system!</h4></td>
                                </tr>
                              {% else %}
                              {% for unassignedStudent in unassignedStudents %}
                                <tr>
                                    <td>{{ unassignedStudent.first_name }} {{ unassignedStudent.other_names }} {{ unassignedStudent.last_name }}</td>
                                    <td>{{ unassignedStudent.username }}</td>
                                </tr>
                              {% endfor %}
                              {% endif %}
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                      <h3><b>Supervisors</b></h3>
                      <div class="table-responsive">
                        <table id="myTable1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Supervisor Name</th>
                                    <th>Number of students</th>
                                </tr>
                            </thead>
                            <tbody>
                              {% if supervisors is empty %}
                                <tr>
                                  <td colspan="2"><h4 style="text-align: center; color: gray;">no unassigned supervisor records found in the system!</h4></td>
                                </tr>
                              {% else %}
                              {% for supervisor in supervisors %}
                                <tr>
                                    <td>{{ supervisor.first_name }} {{ supervisor.other_names }} {{ supervisor.last_name }}</td>
                                    <td>{{ val[supervisor.id]  }}</td>
                                </tr>
                              {% endfor %}
                              {% endif %}
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-sm-2"></div>
                     
    </fieldset>

    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for assigning supervisors to students</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
