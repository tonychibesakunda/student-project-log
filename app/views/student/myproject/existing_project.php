{% extends 'templates/default.php' %}

{% block title %}Add Project{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_project') }}">Add Project</a></p>
                     <p><a href="{{ urlFor('student.view_project_detail') }}">View Project Details</a></p>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Project Objectives</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('student.add_project_objective') }}">Add</a></p>  
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.existing_project.post') }}" method="POST" autocomplete="off">
            
<fieldset>

                    <legend class="text-center">Existing Projects</legend>

                    <button type='button' class='btn btn-link'><a href="{{ urlFor('student.add_project') }}">&larr; Back</a></button>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Student Name</th>
                                    <th>Supervisor Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Student Project Logbook</td>
                                    <td>Tony Mulenga Chibesakunda</td>
                                    <td>Mrs Monica Kabemba</td>
                                    <td><button type='button' class='btn btn-link'><a href="{{ urlFor('student.add_on_existing_project') }}">Select</a></button></td>
                                </tr>
                                <tr>
                                    <td>OCSAMS</td>
                                    <td>Mukuka Chilangwe</td>
                                    <td>Mrs Monica Kabemba</td>
                                    <td><button type='button' class='btn btn-link'><a href="#">Select</a></button></td>
                                </tr>
                                <tr>
                                    <td>Web</td>
                                    <td>John</td>
                                    <td>Peter</td>
                                    <td><button type='button' class='btn btn-link'><a href="#">Select</a></button></td>
                                </tr>
                                <tr>
                                    <td>Student Project Logbook</td>
                                    <td>Tony Mulenga Chibesakunda</td>
                                    <td>Mrs Monica Kabemba</td>
                                    <td><button type='button' class='btn btn-link'><a href="#">Select</a></button></td>
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
                <p>This section is used for adding your project to the system</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
