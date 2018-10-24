{% extends 'templates/default.php' %}

{% block title %}Project Report Comments{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.student_projects') }}">Student Projects</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}

            {% for pr in project_report %}
            <form action="{{ urlFor('supervisor.project_report_comments.post',{id: pr.student_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
                <fieldset>
                
                    <legend class="text-center">Project Report Comments</legend>
                    <div class="col-sm-3">
                        {% for si in supervision_id %}
                        <button type="submit" class="btn btn-link"><a href="{{ urlFor('supervisor.student_project_details', {id: si.supervision_id}) }}">&larr; Back</a></button>
                        {% endfor %}
                    </div>

                <div class="col-sm-6">

                    <div class="form-group">
                        <label for="project_objective">Project Report Name:</label>
                        {% for pr in project_report %}
                            <p>{{ pr.final_project_report_file_name }}</p>
                        {% endfor %}
                    </div>
                    
                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        {% for pr in project_report %}
                        {% if pr.supervisor_comments is empty %}
                            <textarea class="form-control" rows="5" id="comments" name="comments" placeholder="Add your comments...">{% if request.post('comments') %}{{request.post('comments')}} {% endif %}</textarea>
                        {% else %}
                            <textarea class="form-control" rows="5" id="comments" name="comments" placeholder="Add your comments...">{% if request.post('comments') %}{{request.post('comments')}} {% else %}{{ pr.supervisor_comments }} {% endif %}</textarea>
                        {% endif %}
                        {% endfor %}
                        {% if errors.has('comments')%}<small class="form-text text-muted" style="color: red;">{{errors.first('comments')}}</small>{% endif %}
                    </div>
 
                    <button type="submit" class="btn btn-primary">Add Comments</button>
                </div>

                <div class="col-sm-3"></div>

                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                    
                </fieldset>
            </form>

        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding comments to a student's final project report</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
