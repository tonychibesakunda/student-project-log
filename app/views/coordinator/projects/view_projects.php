{% extends 'templates/default.php' %}

{% block title %}View Projects{% endblock %}

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
            <form action="{{ urlFor('coordinator.view_projects.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">View Student Projects</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Student Name</th>
                                    <th>Supervisor Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Project Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if projects is empty %}
                                    <tr><td colspan="7"><h4 style="text-align: center; color: gray;">no projects have been added to the system yet!</h4></td></tr>
                                {% else %}
                                {% for pr in projects %}
                                    <tr>
                                        <td>
                                          {% if pr.projectName is empty %}
                                            <p style="color: red;"><b>project has not yet been added.</b></p>
                                          {% else %}
                                            {{ pr.projectName }}
                                          {% endif %}
                                        </td>
                                        <td>{{ pr.stFName }} {{ pr.stONames }} {{ pr.stLName }}</td>
                                        <td>{{ pr.suFName }} {{ pr.suONames }} {{ pr.suLName }}</td>
                                        <td>{{ pr.project_start_date|date("d-M-Y") }}</td>
                                        <td>{{ pr.project_end_date|date("d-M-Y") }}</td>
                                        <td>
                                          {% if pr.is_final_project_report_approved is empty %}
                                            <p style="color: orange;"><b>In Progress...</b></p>
                                          {% else %}
                                            <p style="color: green;"><b>Completed</b></p>
                                          {% endif %}
                                        </td>
                                        <td><button type='button' class='btn btn-link'><a href="{{ urlFor('coordinator.view_project_details', {id: pr.supervision_id}) }}">More Details..</a></button>
                                    </tr>
                                {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                            
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing student projects</p>
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
