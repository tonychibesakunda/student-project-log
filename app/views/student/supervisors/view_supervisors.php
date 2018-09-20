{% extends 'templates/default.php' %}

{% block title %}View Supervisors{% endblock %}

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
            <form action="{{ urlFor('student.view_supervisors.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">View Supervisor Details</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Supervisor Name</th>
                                    <th>Areas of Interest</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mrs Monica Kabemba</td>
                                    <td>Web Apps, Machine Leraning,</td>
                                    <td><button type='button' class='btn btn-link'><a href="{{ urlFor('student.view_supervisor_details') }}">More Details..</a></button>
                                </tr>
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
                <p>This section is used for viewing supervisors</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}