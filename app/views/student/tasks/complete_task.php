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
            <form action="{{ urlFor('student.complete_task.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Complete Task</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="task">Project Task:</label>
                      <input type="text" class="form-control" id="task" aria-describedby="taskHelp" placeholder="Enter project task" name="task"{% if request.post('project_name') %} value="{{request.post('project_name')}}" {% endif %} readonly="true">
                      {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %} 
                    </div>
                    <div class="form-group">
                      <label for="selectMeeting">Supervisory Meeting:</label>
                      <input type="text" class="form-control" id="task" aria-describedby="taskHelp" placeholder="Enter project task" name="task"{% if request.post('project_name') %} value="12-Aug-2018 (2 hours)" {% endif %} readonly="true">
                      {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                      <label for="file_attachments">Add File(s) (Optional):</label>
                      <div class="input-group">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Browse&hellip; <input type="file" style="display: none;" multiple id="file_attachments" name="file_attachments">
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="student_comments">Comments:</label>
                      <textarea class="form-control" rows="5" id="student_comments" placeholder="Add a comment.."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send for Approval</button>
                    <button type='button' class='btn btn-link'><a href="{{ urlFor('student.view_tasks') }}">&larr; Back</a></button>
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
