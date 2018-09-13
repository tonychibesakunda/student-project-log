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
            <form action="{{ urlFor('student.add_project.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Edit Scheduled Meeting</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='date' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.view_scheduled_meetings') }}">&larr; Back</a></button>
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
