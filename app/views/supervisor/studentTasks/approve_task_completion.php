{% extends 'templates/default.php' %}

{% block title %}Approve Student Task Completion{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.student_tasks') }}">Student Tasks</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('supervisor.confirm_task.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Approve Student Task Completion</legend>

                <div class="col-sm-3">
                    <button type='button' class='btn btn-link'><a href="{{ urlFor('supervisor.student_tasks') }}">&larr; Back</a></button>
                </div>

               <div class="col-sm-6">
                    <div class="form-group">
                      <label for="student_name">Student Name:</label>
                      <p>Name of Student</p>
                    </div>
                    <div class="form-group">
                      <label for="project_name">Project Name:</label>
                      <p>Name of Project</p>
                    </div>
                    <div class="form-group">
                      <label for="task">Project Task:</label>
                      <p>Develop Database</p>
                    </div>
                    <div class="form-group">
                      <label for="selectMeeting">Supervisory Meeting:</label>
                      <p>12-Aug-2018 (2 hours)</p>
                    </div>
                    <div class="form-group">
                      <label for="attached_file">Attached Files:</label>
                      <div>
                          <a href="#"><i aria-hidden="true" class="glyphicon  glyphicon-file"></i> Journal artcle. (155.5Kb)</a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="student_comments">Student Comments:</label>
                      <p>Student Comments will be added here</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Approve Task</button>
                    <button type='button' class='btn btn-link'><a href="{{ urlFor('supervisor.review_task_completion') }}">Review Task</a></button>
                </div>
                

                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

                <div class="col-sm-3"></div>  
        </fieldset>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for approving the completion of student tasks</p>
            </div>
        </div>

    </div>
</div>

{% endblock %}
