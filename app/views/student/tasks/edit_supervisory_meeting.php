{% extends 'templates/default.php' %}

{% block title %}Edit Supervisory Meeting{% endblock %}

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

            {% for sm in supervisory_meetings%}
            <form action="{{ urlFor('student.edit_supervisory_meeting.post', {id: sm.supervisory_meeting_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Edit Supervisory Meeting</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="scheduledMeeting">Scheduled Meeting:</label>

                      <select class="form-control" id="scheduledMeeting" name="scheduledMeeting" readonly>
                        {% for sc in scheduled_meetings %}
                        {% for sm in supervisory_meetings %}
                          {% if sc.scheduled_meeting_id == sm.scheduled_meeting_id %}
                            <option  value="{{ sc.scheduled_meeting_id }}" selected>{{ sc.scheduled_date|date("d-M-Y") }}</option>
                          {% endif %}
                        {% endfor %}
                        {% endfor %}
                      </select>
                      {% if errors.has('scheduledMeeting')%}<small class="form-text text-muted" style="color: red;">{{errors.first('scheduledMeeting')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                      <label for="duration">Duration (hour(s):mins):</label>
                      {% for sm in supervisory_meetings %}
                      <input type="time" class="form-control" id="duration" aria-describedby="durationHelp" placeholder="Enter duration of meeting" name="duration" value="{{ request.post('duration') ? request.post('duration') : sm.duration|date('H:i') }}" ">
                      {% endfor %}
                      {% if errors.has('duration')%}<small class="form-text text-muted" style="color: red;">{{errors.first('duration')}}</small>{% endif %} 
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                    <button type='button' class='btn btn-link' name="back"><a href="{{ urlFor('student.view_supervisory_meetings') }}">&larr; Back</a></button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for editing a supervisory meeting to your project log</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
