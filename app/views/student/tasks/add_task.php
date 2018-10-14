{% extends 'templates/default.php' %}

{% block title %}Add Task{% endblock %}

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
            <legend class="text-center">Add Task</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="task">Project Task:</label>
                      <input type="text" class="form-control" id="task" aria-describedby="taskHelp" placeholder="Enter project task" name="task"{% if request.post('task') %} value="{{request.post('task')}}" {% endif %}>
                      {% if errors.has('task')%}<small class="form-text text-muted" style="color: red;">{{errors.first('task')}}</small>{% endif %} 
                    </div>
                    <div class="form-group">
                      <label for="selectMeeting">Supervisory Meeting:</label>

                      <select class="form-control" id="selectMeeting" name="selectMeeting">
                        {% if supervisory_meetings is empty %}
                          <option> *** No supervisory meetings have been added *** </option>
                        {% else %}
                          <option>-- select supervisory meeting --</option>
                          {% for sm in supervisory_meetings %}
                            {% if request.post('selectMeeting') == sm.supervisory_meeting_id %}
                              <option value="{{ sm.supervisory_meeting_id }}" selected>{{ sm.scheduled_date|date("d-M-Y") }} [ {{ sm.duration|date("H:i") }} hour(s) ]</option>
                            {% else %}
                              <option value="{{ sm.supervisory_meeting_id }}">{{ sm.scheduled_date|date("d-M-Y") }} [ {{ sm.duration|date("H:i") }} hour(s) ]</option>
                            {% endif %}
                          {% endfor %}
                        {% endif %}
                      </select>
                      {% if errors.has('selectMeeting')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectMeeting')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding a task to your project log</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
