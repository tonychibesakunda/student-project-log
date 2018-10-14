{% extends 'templates/default.php' %}

{% block title %}Add Supervisory Meeting{% endblock %}

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
            <form action="{{ urlFor('student.add_supervisory_meeting.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Add Supervisory Meeting</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="scheduledMeeting">Scheduled Meeting:</label>

                      <select class="form-control" id="scheduledMeeting" name="scheduledMeeting">
                        {% if scheduled_meetings is empty %}
                          <option>** no scheduled meetings have been added yet **</option>
                        {% else %}
                          <option>-- select scheduled meeting --</option>
                        {% for sm in scheduled_meetings %}
                          {% if request.post('scheduledMeeting') == sm.scheduled_meeting_id %}
                            <option  value="{{ sm.scheduled_meeting_id }}" selected>{{ sm.scheduled_date|date("d-M-Y") }}</option>
                          {% else %}
                            <option  value="{{ sm.scheduled_meeting_id }}">{{ sm.scheduled_date|date("d-M-Y") }}</option>
                          {% endif %}
                        {% endfor %}
                        {% endif %}
                      </select>
                      {% if errors.has('scheduledMeeting')%}<small class="form-text text-muted" style="color: red;">{{errors.first('scheduledMeeting')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                      <label for="duration">Duration (hour(s):mins):</label>
                      <input type="time" class="form-control" id="duration" aria-describedby="durationHelp" placeholder="Enter duration of meeting" name="duration"{% if request.post('duration') %} value="{{request.post('duration')}}" {% endif %}>
                      {% if errors.has('duration')%}<small class="form-text text-muted" style="color: red;">{{errors.first('duration')}}</small>{% endif %} 
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Supervisory Meeting</button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding a supervisory meeting to your project log</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
