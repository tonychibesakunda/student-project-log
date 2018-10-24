{% extends 'templates/default.php' %}

{% block title %}Scheduled Meetings{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.scheduled_meetings') }}">View Schedules</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('supervisor.scheduled_meetings.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Scheduled Meetings</legend>

                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Scheduled Date</th>
                                <th>Days Remaining</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if supervisions is empty %}
                                <tr>
                                    <tr><td colspan="3"><h4 style="text-align: center; color: gray;">no scheduled meetings have been added to the system yet!</h4></td></tr>
                                </tr>
                            {% else %}
                            {% for sp in supervisions %}
                                <tr>
                                    <td>{{ sp.scheduled_date|date("d-M-Y")}}</td>
                                    {% set difference = date(sp.scheduled_date).diff(date(current_date)) %}
                                    {% set leftDays = difference.days %}
                                        <th>
                                            {% if leftDays <= 0 or date(sp.scheduled_date) < date(current_date) %} 
                                                <p style="color: red;"><b>0</b></p> 
                                            {% else %}
                                                <p style="color: green;"><b>{{ leftDays }}</b></p>
                                            {% endif %}
                                        </th>
                                    <td>{{ sp.stFName }} {{ sp.stONames }} {{ sp.stLName }}</td>
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
                <p>This section is used for viewing scheduled meetings</p>
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
