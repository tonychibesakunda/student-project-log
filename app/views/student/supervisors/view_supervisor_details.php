{% extends 'templates/default.php' %}

{% block title %}View Supervisor Details{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('student.view_supervisors') }}">View Supervisors</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.view_supervisor_details.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">Supervisor Details</legend>

                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.view_supervisors') }}">&larr; Back</a></button>
                    </div>
                    <div class=" col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                {% for sd in supervisor_details %}
                                    <h3 class="panel-title"><b>{{ sd.first_name }} {{ sd.other_names }} {{ sd.last_name }}</b></h3>
                                {% endfor %}
                            </div>
                            <div class="panel-body">
                                
                                 <div class="table-responsive">
                                  <table class="table table-user-information">
                                    <tbody>
                                       {% for sd in supervisor_details %} 
                                        <tr>
                                            <th>Areas of Interest:</th>
                                        
                                            <td>
                                                {% if sd.interests is empty %}
                                                    <p style="color: gray;"><b>* Interests not yet added...</b></p>
                                                {% else %}
                                                    {{ sd.interests }}
                                                {% endif %}
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <th>Projects Supervised:</th>
                                            
                                            <td>{{ sd.numOfStudents }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <th>Students Supervised:</th>
                                            
                                            <td>{{ sd.numOfStudents }}</td>

                                        </tr>
                                        {% endfor %}
                                    </tbody>
                                  </table>
                                </div><!-- end of table responsive -->
                            </div><!-- end of panel body div -->  
                          </div><!-- end of panel div -->
                          
                        </div><!-- end of col-sm-6 div -->

                      <div class="col-sm-6">
                          <h4><b>Student Expectations:</b></h4>
                          {% for sd in supervisor_details %}
                            {% if sd.student_expectations is empty %}
                                <p style="color: gray;"><b>* Student Expectations not yet added...</b></p>
                            {% else %}
                                <p>{{ sd.student_expectations }}</p>
                            {% endif %}
                          {% endfor %}
                      </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                            
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing supervisor details</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
