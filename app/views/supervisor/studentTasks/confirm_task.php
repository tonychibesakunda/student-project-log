{% extends 'templates/default.php' %}

{% block title %}Confirm Student Task{% endblock %}

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
            <form action="{{ urlFor('supervisor.confirm_task.post', {id: ts.task_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Confirm Student Task</legend>

                <div class="col-sm-3">
                    <button type='button' class='btn btn-link'><a href="{{ urlFor('supervisor.student_tasks') }}">&larr; Back</a></button>
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

                    <button type="submit" class="btn btn-primary" name="approve_task">Approve Task</button>
                    {% for ts in tasks %}
                    <button type="submit" class="btn btn-link"><a href="{{ urlFor('supervisor.review_task',{id: ts.task_id}) }}">Review Task</a></button>
                    {% endfor %}
                </div>
                

                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

                <div class="col-sm-3"></div>  
        </fieldset>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for confirming student tasks</p>
            </div>
        </div>

    </div>
</div>

{% endblock %}
