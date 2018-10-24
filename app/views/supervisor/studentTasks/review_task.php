{% extends 'templates/default.php' %}

{% block title %}Review Student Task{% endblock %}

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

            {% for ts in tasks %}
            <form action="{{ urlFor('supervisor.review_task.post', {id: ts.task_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Review Student Task</legend>

                <div class="col-sm-3">
                  {% for ts in tasks %}
                    <button type='button' class='btn btn-link'><a href="{{ urlFor('supervisor.confirm_task', {id:ts.task_id}) }}">&larr; Back</a></button>
                  {% endfor %}
                </div>

               <div class="col-sm-6">
                    <div class="form-group">
                        <label for="task">Student Name:</label>
                        {% for ts in tasks %}
                          <p>{{ ts.stFName }} {{ ts.stONames }} {{ ts.stLName }}</p>
                        {% endfor %}
                    </div>
                    <div class="form-group">
                        <label for="task">Project Name:</label>
                        {% for ts in tasks %}
                          <p>{{ ts.project_name }}</p>
                        {% endfor %}
                    </div>
                    <div class="form-group">
                        <label for="task">Project Task:</label>
                        {% for ts in tasks %}
                          <p>{{ ts.task_description }}</p>
                        {% endfor %}
                    </div>
                    <div class="form-group">
                        <label for="selectMeeting">Supervisory Meeting:</label>
                        {% for ts in tasks %}
                          <p>{{ ts.scheduled_date|date("d-M-Y") }} < {{ ts.duration|date("H:i") }} hour(s) ></p>
                        {% endfor %}
                    </div>
                    <div class="form-group">
                        <label for="supervisor_comments">Suggestions / Comments:</label>
                        {% for ts in tasks %}
                        {% if ts.supervisor_approval_comments is empty %}
                            <textarea class="form-control" rows="5" id="supervisor_comments" name="supervisor_comments" placeholder="Add comments">{% if request.post('supervisor_comments') %}{{request.post('supervisor_comments')}} {% endif %}</textarea>
                        {% else %}
                            <textarea class="form-control" rows="5" id="supervisor_comments" name="supervisor_comments" placeholder="Add comments">{% if request.post('supervisor_comments') %}{{request.post('supervisor_comments')}} {% else %}{{ ts.supervisor_approval_comments }} {% endif %}</textarea>
                        {% endif %}
                        {% endfor %}
                        {% if errors.has('supervisor_comments')%}<small class="form-text text-muted" style="color: red;">{{errors.first('supervisor_comments')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary" name="send_review">Send Review</button>
                </div>
                

                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

                <div class="col-sm-3"></div>  
        </fieldset>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for reviewing student tasks</p>
            </div>
        </div>

    </div>
</div>

{% endblock %}
