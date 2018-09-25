{% extends 'templates/default.php' %}

{% block title %}Add Scheduled Meeting{% endblock %}

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
            <form action="{{ urlFor('student.add_scheduled_meeting.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Add Scheduled Meeting</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <label for="scheduled_date">Scheduled Date:</label>
                            <input type='date' class="form-control" name="scheduled_date" id="scheduled_date" />
                        </div>
                        {% if errors.has('scheduled_date')%}<small class="form-text text-muted" style="color: red;">{{errors.first('scheduled_date')}}</small>{% endif %}
                    </div>
                    <div class="form-group">
                        <label for="selectSupervisor">Select Supervisor</label>
                        <select class="form-control" id="selectSupervisor" name="selectSupervisor" style="
                        width: 283px;">
                            <option value="0">-- select supervisor --</option>
                            {% for sp in supervisors %}
                                <option value="{{ sp.supervisor_id }}">{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}</option>
                            {% endfor %}
                        </select>
                        {% if errors.has('selectSupervisor')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSupervisor')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary" name="add">Add Schedule</button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form> 
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding a scheduled meeting to your project log</p>
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
