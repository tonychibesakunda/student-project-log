{% extends 'templates/default.php' %}

{% block title %}View Supervisory Meetings{% endblock %}

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
            
            
        <fieldset>
            <legend class="text-center">View Supervisory Meetings</legend>
            <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Duration (hour(s):mins)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if supervisory_meetings is empty %}
                                <tr><td colspan="3"><h4 style="text-align: center; color: gray;">no supervisory meetings have been added to the system yet!</h4></td></tr>
                            {% else %}
                            {% for sm in supervisory_meetings %}
                                <tr>
                                    <td>{{ sm.scheduled_date|date("d-M-Y") }}</td>
                                    <td>{{ sm.duration|date("H:i")}}</td>
                                    <td>
                                      <button type='button' class='btn btn-warning'><a href="{{ urlFor('student.edit_supervisory_meeting', {id: sm.supervisory_meeting_id}) }}" title="Edit Supervisory Meeting"><span class="glyphicon glyphicon-edit"></span></a></button>
                                        &nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ sm.supervisory_meeting_id }}' title="Remove Supervisory Meeting"><span class="glyphicon glyphicon-trash text-center"></span></button>
                                    </td>
                                </tr>
                            {% endfor %}
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                
        </fieldset>
    
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing added supervisory meetings to your project log</p>
            </div>
        </div>
        {% for sm in supervisory_meetings %}
        <div class="modal fade" id="verifyDelete{{ sm.supervisory_meeting_id }}" role="dialog">
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
                        <form action="{{ urlFor('student.view_supervisory_meetings.post', {id: sm.supervisory_meeting_id}) }}" method="POST" autocomplete="off">
                            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                            <button type="submit" class="btn btn-primary" value="{id: sm.supervisory_meeting_id}" name="delete">Yes</button>&nbsp;
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        {% endfor %}
    </div>
</div>

{% endblock %}
