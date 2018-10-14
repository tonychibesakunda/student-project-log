{% extends 'templates/default.php' %}

{% block title %}Edit Scheduled Meeting{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Schedule Meetings</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_scheduled_meeting') }}">Add Schedule</a></p>
                     <p><a href="{{ urlFor('student.view_scheduled_meetings') }}">View Schedules</a></p>
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}

            {% for sm in scheduled_meeting %}
            <form action="{{ urlFor('student.edit_scheduled_meeting.post', {id: sm.scheduled_meeting_id}) }}" method="POST" autocomplete="off">
            {% endfor %}
            
<fieldset>
            <legend class="text-center">Edit Scheduled Meeting</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <label for="scheduled_date">Scheduled Date:</label>
                            {% for sm in scheduled_meeting %}
                            <input type='date' class="form-control" name="scheduled_date" id="scheduled_date" value="{{ request.post('scheduled_date') ? request.post('scheduled_date') : sm.scheduled_date|date('Y-m-d') }}" />
                            {% endfor %}
                        </div>
                        {% if errors.has('scheduled_date')%}<small class="form-text text-muted" style="color: red;">{{errors.first('scheduled_date')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                        <label for="selectSupervisor">Select Supervisor</label>
                        <select class="form-control" id="selectSupervisor" name="selectSupervisor" style="
                        width: 283px;">  
                            {% for sp in supervisors %}
                            {% for sm in scheduled_meeting%}
                                {% if sp.supervision_id == sm.supervision_id %}
                                    <option value="{{ sp.supervisor_id }}" selected>{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}</option>
                                {% else %}
                                    <option value="{{ sp.supervisor_id }}">{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}</option>
                                {% endif %}
                            {% endfor %}
                            {% endfor %}
                        </select>
                        {% if errors.has('selectSupervisor')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSupervisor')}}</small>{% endif %}
                    </div>
                     <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                    <button type="submit" class="btn btn-link" name="back"><a href="{{ urlFor('student.view_scheduled_meetings') }}">&larr; Back</a></button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">  
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for editing the added scheduled meeting</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>

{% endblock %}
