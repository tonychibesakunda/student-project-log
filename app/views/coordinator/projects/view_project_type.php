{% extends 'templates/default.php' %}

{% block title %}View Project Types{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project Categories</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('coordinator.add_project_category') }}">Add</a></p> 
                     <p><a href="{{ urlFor('coordinator.view_project_category') }}">View</a></p> 
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Project Types</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.add_project_type') }}">Add</a></p>
                      <p><a href="{{ urlFor('coordinator.view_project_type') }}">View</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Supervision</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.assign_supervisors') }}">Assign Supvervisors</a></p>
                      <p><a href="{{ urlFor('coordinator.view_assigned_supervisors') }}">View Assigned Supvervisors</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Student Projects</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.view_projects') }}">View Projects</a></p>
                  </div>
                </div>
          </div>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            
            
                <fieldset>

                    <legend class="text-center">View Project Types</legend>

                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                      <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Type</th>
                                    <th style="width: 300px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              {% if project_types is empty %}
                                <tr>
                                  <td colspan="2"><h4 style="text-align: center; color: gray;">no records have been added to the system!</h4></td>
                                </tr>
                              {% else %}
                              {% for project_type in project_types %}
                                <tr>
                                    <td>{{ project_type.project_type }}</td>
                                    <td><button type='button' class='btn btn-link'><a href="{{ urlFor('coordinator.edit_project_type', {id: project_type.project_type_id}) }}">Edit</a></button>&nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ project_type.project_type_id }}'>Delete</button></td>
                                </tr>
                              {% endfor %}
                              {% endif %}
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-sm-1"></div>
                    
                            
                     
                            
                </fieldset>
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing project types</p>
            </div>
        </div>
{% for project_type in project_types %}
        <div class="modal fade" id="verifyDelete{{ project_type.project_type_id }}" role="dialog">
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
                      <form action="{{ urlFor('coordinator.view_project_type.post', {id: project_type.project_type_id}) }}" method="POST" autocomplete="off">
                        <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">  
                        <button type="submit" class="btn btn-primary" name="delete" value="{{ project_type.project_type_id }}">Yes</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
{% endfor %}
    </div>
</div>
{% endblock %}
