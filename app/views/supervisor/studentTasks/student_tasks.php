{% extends 'templates/default.php' %}

{% block title %}Student Tasks{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.student_tasks') }}">Student Tasks</a></p>
        </div>

        <div class="col-sm-9  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('supervisor.scheduled_meetings.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Student Tasks</legend>

                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Student</th>
                                <th style="text-align: center;">Task</th>
                                <th style="text-align: center; width: 100px;">Agreed On</th>
                                <th colspan="2" style="">
                                    <p style="text-align: center;">Task Sent for:</p>
                                    <p><span style="float: left;">Approval</span>&nbsp; | <span style="float: right;">Completion</span></p>
                                </th>
                                <th style="text-align: center; width: 50px;">Approved</th>
                                <th style="text-align: center; width: 50px;">Completed</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if tasks is empty %}
                                <tr>
                                    <tr><td colspan="8"><h4 style="text-align: center; color: gray;">no student tasks have been added to the system yet!</h4></td></tr>
                                </tr>
                            {% else %}
                                {% for ts in tasks %}
                                    <tr>
                                        <td>{{ ts.stFName }} {{ ts.stONames }} {{ ts.stLName }}</td>
                                        <td>{{ ts.task_description }}</td>
                                        <td>{{ ts.scheduled_date|date("d-M-Y") }} <{{ ts.duration|date("H:i") }} hour(s)></td>
                                        <td>
                                            {% if ts.sent_for_approval == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p> 
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if ts.sent_for_completion == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if ts.is_approved == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if ts.is_completed == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
                                        </td>
                                        <td>
                                            <button type='button' class='btn btn-default'><a href="{{ urlFor('supervisor.confirm_task', {id: ts.task_id}) }}" title="Approve Task"><span class="glyphicon glyphicon-ok"></span></a></button>
                                            <button type='button' class='btn btn-success'><a href="{{ urlFor('supervisor.approve_task_completion', {id: ts.task_id}) }}" title="Approve Task for Completion"><span class="glyphicon glyphicon-check"></span></a></button>
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

        <div class="col-sm-1 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing student tasks</p>
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
