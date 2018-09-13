{% extends 'templates/default.php' %}

{% block title %}View Scheduled Meetings{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Schedule Meetings</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_scheduled_meeting') }}">Add Schedule</a></p>
                     <p><a href="{{ urlFor('student.view_scheduled_meetings') }}">View Schedules</a></p>
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
            <legend class="text-center">Scheduled Meetings</legend>

                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Scheduled Date</th>
                                <th>Days Remaining</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>13-Aug-2018</td>
                                <td>14</td>
                                <td>Pending</td>
                                <td><button type='button' class='btn btn-link'><a href="{{ urlFor('student.edit_scheduled_meeting') }}">Edit</a></button>&nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete'>Delete</button></td>
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
                <p>This section is used for viewing scheduled meetings</p>
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
