{% extends 'templates/default.php' %}

{% block title %}Student Projects{% endblock %}

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
            <form action="{{ urlFor('supervisor.student_expectations.post') }}" method="POST" autocomplete="off">
            
                <fieldset>
                <legend style="text-align: center;">Student Projects</legend>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Student</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if student_projects is empty %}
                                    <tr><td colspan="4"><h4 style="text-align: center; color: gray;">student projects have not yet been added to the system!</h4></td></tr>
                                {% else %}
                                {% for sp in student_projects %}
                                    <tr>
                                        <td>
                                            {% if sp.project_name is empty%}
                                                <h4 style="text-align: center; color: gray;">project has not been added yet</h4>
                                            {% else %}
                                                {{ sp.project_name }}
                                            {% endif %}
                                        </td>
                                        <td>{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}</td>
                                        <td>
                                            {% if sp.is_final_project_report_approved == 1 %}
                                                <p style="color: green;"><b>Project is completed</b></p>
                                            {% else %}
                                                <p style="color: orange;"><b>Project in progress...</b></p>
                                            {% endif %}
                                        </td>
                                        <td>
                                            <button type='button' class='btn btn-link'><a href="{{ urlFor('supervisor.student_project_details', {id: sp.supervision_id}) }}">More Details..</a></button>
                                        </td>
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
                <p>This section is used for viewing student projects</p>
            </div>
        </div>

        <div class="modal fade" id="verifyDelete" role="dialog">
            <div class="modal-dialog">
                <!-- Modal Content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title"><span class="label label-danger">Are You Sure?</span></h1>
                    </div>
                    <div class="modal-body">
                        <p>This record will permanently be deleted / removed from the system. Do you wish to continue?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{% endblock %}
