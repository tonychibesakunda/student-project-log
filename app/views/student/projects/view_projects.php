{% extends 'templates/default.php' %}

{% block title %}View Completed Projects{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('student.view_projects') }}">View Completed Projects</a></p>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.view_projects.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">View Completed Projects</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Student Name</th>
                                    <th>Supervisor Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if projects is empty %}
                                    <tr><td colspan="4"><h4 style="text-align: center; color: gray;">no completed projects have been added to the system yet!</h4></td></tr>
                                {% else %}
                                {% for pr in projects %}
                                    <tr>
                                        <td>{{ pr.projectName }}</td>
                                        <td>{{ pr.stFName }} {{ pr.stONames }} {{ pr.stLName }}</td>
                                        <td>{{ pr.suFName }} {{ pr.suONames }} {{ pr.suLName }}</td>
                                        <td>{{ pr.project_start_date|date("d-M-Y") }}</td>
                                        <td>{{ pr.project_end_date|date("d-M-Y") }}</td>
                                        <td><button type='button' class='btn btn-link'><a href="{{ urlFor('student.view_project_details', {id: pr.supervision_id}) }}">More Details..</a></button>
                                    </tr>
                                {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                            
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing completed projects</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
