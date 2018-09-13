{% extends 'templates/default.php' %}

{% block title %}View Tasks{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project Tasks</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_task') }}">Add Task</a></p>
                     <p><a href="{{ urlFor('student.view_tasks') }}">View Tasks</a></p>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Supervisory Meetings</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_supervisory_meeting') }}">Add Meeting</a></p> 
                     <p><a href="{{ urlFor('student.view_supervisory_meetings') }}">View Meetings</a></p> 
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.add_task.post') }}" method="POST" autocomplete="off">
            
        <fieldset>
            <legend class="text-center">View Tasks</legend>
            <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Agreed On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Develop Database</td>
                                <td>12-Aug-2018 (2 hours)</td>
                                <td>Pending</td>
                                <td>
                                  <button type='button' class='btn btn-warning'><a href="{{ urlFor('student.edit_task') }}" title="Edit Task"><span class="glyphicon glyphicon-edit"></span></a></button>
                                        <button type='button' class='btn btn-success'><a href="{{ urlFor('student.complete_task') }}" title="Complete Task"><span class="glyphicon glyphicon-check"></span></a></button>
                                        &nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete' title="Remove Task"><span class="glyphicon glyphicon-trash text-center"></span></button>
                                </td>
                            </tr>
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
                <p>This section is used for viewing added tasks to your project log</p>
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
