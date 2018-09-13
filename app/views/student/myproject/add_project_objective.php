{% extends 'templates/default.php' %}

{% block title %}Add Project Objective{% endblock %}

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
            <form action="{{ urlFor('student.add_project.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Add Project Objective</legend>

                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="project_objective">Project Objective</label>
                        <input type="text" class="form-control" id="project_objective" aria-describedby="projectObjectiveHelp" placeholder="Enter project objective" name="project_objective"{% if request.post('project_name') %} value="{{request.post('project_name')}}" {% endif %}>
                        {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                    </div>
                    <button type="submit" class="btn btn-primary">Add Objective</button>
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                </div>

                <div class="col-sm-3"></div>  
        </fieldset><br><br><br><br>
    </form>

    <fieldset>
        <legend style="text-align: center;">Added Project Objectives</legend>
        <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Objective</th>
                                    <th>Objective Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gather Requirements</td>
                                    <td>Completed</td>
                                    <td>
                                        <button type='button' class='btn btn-warning'><a href="{{ urlFor('student.view_project_details') }}" title="Edit Objective"><span class="glyphicon glyphicon-edit"></span></a></button>
                                        <button type='button' class='btn btn-success' title="Mark as Completed"><span class="glyphicon glyphicon-check"></span></button>
                                        &nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete' title="Remove Objective"><span class="glyphicon glyphicon-trash text-center"></span></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Develop System</td>
                                    <td>Incomplete</td>
                                    <td>
                                        <button type='button' class='btn btn-warning'><a href="{{ urlFor('student.view_project_details') }}" title="Edit Objective"><span class="glyphicon glyphicon-edit"></span></a></button>
                                        <button type='button' class='btn btn-success' title="Mark as Completed"><span class="glyphicon glyphicon-check"></span></button>
                                        &nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete' title="Remove Objective"><span class="glyphicon glyphicon-trash text-center"></span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
    </fieldset>

    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding your project to the system</p>
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
