{% extends 'templates/default.php' %}

{% block title %}Complete Task{% endblock %}

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

            {% for ts in tasks %}
            <form action="{{ urlFor('student.complete_task.post', {id: ts.task_id }) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Complete Task</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="task">Project Task:</label>
                      {% for ts in tasks %}
                      <input type="text" class="form-control" id="task" aria-describedby="taskHelp" placeholder="Enter project task" name="task" value="{{ request.post('task') ? request.post('task') : ts.task_description }}" readonly="true">
                      {% endfor %} 
                    </div>
                    <div class="form-group">
                      <label for="selectMeeting">Supervisory Meeting:</label>
                      <select class="form-control" id="selectMeeting" name="selectMeeting" disabled>
                        {% for sm in supervisory_meetings %}
                        {% for ts in tasks %}
                          {% if sm.supervisory_meeting_id == ts.supervisory_meeting_id %}
                            <option  value="{{ sm.supervisory_meeting_id }}" selected>{{ sm.scheduled_date|date("d-M-Y") }} < {{ sm.duration|date("H:i") }} hour(s) ></option>
                          {% endif %}
                        {% endfor %}
                        {% endfor %}
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="file_attachments">Add File (Optional):</label>
                      <div class="input-group">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  {% for ts in tasks %}
                                  Browse&hellip; <input type="file" style="display: none;" id="file_attachments" name="file_attachments">
                                  {% endfor %}
                              </span>
                          </label>
                          {% for ts in tasks %}
                          <input type="text" class="form-control" name="file_name" value="{{ request.post('file_name') ? request.post('file_name') : ts.file_name }}" readonly>
                          {% endfor %}
                      </div>
                      {% if errors.has('file_attachments')%}<small class="form-text text-muted" style="color: red;">{{errors.first('file_attachments')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                      <label for="student_comments">Comments:</label>
                      {% for ts in tasks %}
                      <textarea class="form-control" rows="5" id="student_comments" placeholder="Add a comment.." name="student_comments">{% if request.post('student_comments') %} value="{{request.post('student_comments')}}" {% else %}{{ ts.student_comments }} {% endif %}</textarea>
                      {% endfor %}
                      {% if errors.has('student_comments')%}<small class="form-text text-muted" style="color: red;">{{errors.first('student_comments')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary" name="send">Send for Approval</button>
                    <button type='button' class='btn btn-link' name="back"><a href="{{ urlFor('student.view_tasks') }}">&larr; Back</a></button> 
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for completing a task to your project log</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
