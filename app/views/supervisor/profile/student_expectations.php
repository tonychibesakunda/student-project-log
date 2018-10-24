{% extends 'templates/default.php' %}

{% block title %}Student Expectations{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.interests') }}">Areas of Interest</a></p>
            <p><a href="{{ urlFor('supervisor.student_expectations') }}">Student Expectations</a></p>    
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('supervisor.student_expectations.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">What do you expect from students?</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    
                    <div class="form-group">
                        <label for="student_expectations">Student Expectations:</label>
                        {% for se in student_expectations %}
                        {% if se.student_expectations is empty %}
                            <textarea class="form-control" rows="5" id="student_expectations" name="student_expectations" placeholder="Example: Report on time, keeps me up to date, etc">{% if request.post('student_expectations') %}{{request.post('student_expectations')}} {% endif %}</textarea>
                        {% else %}
                            <textarea class="form-control" rows="5" id="student_expectations" name="student_expectations" placeholder="Example: Report on time, keeps me up to date, etc">{% if request.post('student_expectations') %}{{request.post('student_expectations')}} {% else %}{{ se.student_expectations }} {% endif %}</textarea>
                        {% endif %}
                        {% endfor %}
                        {% if errors.has('student_expectations')%}<small class="form-text text-muted" style="color: red;">{{errors.first('student_expectations')}}</small>{% endif %}
                    </div>
 
                    <button type="submit" class="btn btn-primary">Add Expectation</button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form>

    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for enriching your supervisor profile</p>
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
