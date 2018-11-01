{% extends 'templates/default.php' %}

{% block title %}View Assigned Students{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('hod.view_assigned_students') }}">View Assigned Students</a></p>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('hod.view_assigned_students.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">View Assigned Students and Supervisors</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Supervisor Name</th>
                                    <th>Project Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if supervisions is empty %}
                                    <tr>
                                      <td colspan="3"><h4 style="text-align: center; color: gray;">no records have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                {% for supervision in supervisions %}
                                <tr>
                                    <td>{{ supervision.stFName }} {{ supervision.stONames }} {{ supervision.stLName }}</td>
                                    <td>{{ supervision.suFName }} {{ supervision.suONames }} {{ supervision.suLName }}</td>
                                    <td>{% if supervision.projectName is empty %}<p style="color: red;"><b>not yet added..</b></p>{% else %}{{ supervision.projectName }}{% endif %}</td>
                                </tr>
                              {% endfor %}
                              {% endif %}
                            </tbody>
                        </table><br><br>
                    </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                    <div class="col-sm-12">
                        <legend class="text-center">Supervisions</legend>
                        <div class="col-sm-2"></div>

                    <div class="col-sm-8">
                      <h3><b>Unassigned Students</b></h3>
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
                                  <td colspan="2"><h4 style="text-align: center; color: gray;">All students have been assigned supervisors!</h4></td>
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
                                    <th>Number of students supervising</th>
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
                    </div>   
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing assigned students</p>
            </div>
        </div>

        <div class="modal fade" id="verifyDelete" role="dialog">
            <div class="modal-dialog">
                <!-- Modal Content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title"><span class="label label-danger">Are You Sure?</span></h1>
                    </div>
                    <div class="modal-body">
                        <p>This record will permanently be deleted / removed from the system. Do you wish to continue?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{% endblock %}
