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
            
            
<fieldset>
            <legend class="text-center">Scheduled Meetings</legend>

            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Scheduled Date</th>
                                <th>Days Remaining</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if scheduled_meetings is empty %}
                                <tr><td colspan="3"><h4 style="text-align: center; color: gray;">no scheduled meetings have been added to the system yet!</h4></td></tr>
                            {% else %}
                            {% for sm in scheduled_meetings %}
                            <tr>
                                <td>{{ sm.scheduled_date|date("d-M-Y") }}</td>
                                {% set difference = date(sm.scheduled_date).diff(date(current_date)) %}
                                {% set leftDays = difference.days %}
                                <th>
                                    {% if leftDays <= 0 or date(sm.scheduled_date) < date(current_date) %} 
                                        <p style="color: red;"><b>0</b></p> 
                                    {% else %}
                                        <p style="color: green;"><b>{{ leftDays }}</b></p>
                                    {% endif %}
                                </th>
                                <td><button type='button' class='btn btn-link'><a href="{{ urlFor('student.edit_scheduled_meeting', {id: sm.scheduled_meeting_id}) }}">Edit</a></button>&nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ sm.scheduled_meeting_id }}'>Delete</button></td>
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
                <p>This section is used for viewing scheduled meetings</p>
            </div>
        </div>
{% for sm in scheduled_meetings %}
        <div class="modal fade" id="verifyDelete{{ sm.scheduled_meeting_id }}" role="dialog">
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
                        <form action="{{ urlFor('student.view_scheduled_meetings.post', {id: sm.scheduled_meeting_id}) }}" method="POST" autocomplete="off">
                            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                            <button type="submit" class="btn btn-primary" name="delete" value="{{ sm.scheduled_meeting_id }}">Yes</button>&nbsp;
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
