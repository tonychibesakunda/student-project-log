{% extends 'templates/default.php' %}

{% block title %}View Project Objectives{% endblock %}

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
                     <p><a href="{{ urlFor('student.view_project_objective') }}">View</a></p> 
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Project Report</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('student.add_project_report') }}">Add</a></p>  
                  </div>
                </div>
          </div>
            
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}

            {% for po in project_objectives %}
            <form action="{{ urlFor('student.view_project_objective.post') }}" method="POST" autocomplete="off">  
            {% endfor %}   
                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
    <fieldset>
        <legend style="text-align: center;">Added Project Objectives</legend>
        <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Project Objective</th>
                                    <th style="width: 20%;">Request Approval</th>
                                    <th style="width: 20%;">Objective Status</th>
                                    <th style="width: 20%;">Supervisor Comments</th>
                                    <th style="width: 20%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if project_objectives is empty %}
                                    <tr>
                                        <td colspan="3"><h4 style="text-align: center; color: gray;">no project objectives have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                {% for po in project_objectives %}
                                <tr>
                                    <input type="hidden" data-target="selectObjective{{ po.po_id }}" value="{{ po.po_id }}">
                                    <td>{{ po.project_objective }}</td>
                                    <td>
                                        {% if po.sent_for_approval == true %}
                                            <p style="color: orange;">Objective Sent for Approval</p>
                                        {% else %}
                                            <p style="color: red;">Objective Not Yet Sent</p>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if po.is_completed == true%}
                                            <p style="color: green;">Approved / Completed</p>
                                        {% else %}
                                            <p style="color: red;">Incomplete</p>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if po.supervisor_comments is empty %}
                                            <p style="color: grey;"><b>* Comments not added...</b></p>
                                        {% else %}
                                            <p>{{ po.supervisor_comments }}</p>
                                        {% endif %}
                                    </td>
                                    <td>

                                        <button type='button' class='btn btn-warning'><a href="{{ urlFor('student.edit_project_objective', {id: po.po_id}) }}" title="Edit Objective"><span class="glyphicon glyphicon-edit"></span></a></button>
                                        
                                        <button type='submit' class='btn btn-success' value="{{ po.po_id }}" title="Mark as Completed" name="complete" data-target="#selectObjective{{ po.po_id }}"><span class="glyphicon glyphicon-check"></span></button>
                                        
                                        &nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ po.po_id }}' title="Remove Objective"><span class="glyphicon glyphicon-trash text-center"></span></button>
                                    </td>
                                </tr>
                                {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>    
    </fieldset>
    </form>

    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing your project objectives added to the system</p>
            </div>
        </div>
{% for po in project_objectives %}
        <div class="modal fade" id="verifyDelete{{ po.po_id }}" role="dialog">
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
                            <form action="{{ urlFor('student.view_project_objective.posts', {id: po.po_id}) }}" method="POST" autocomplete="off">
                            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                            <button type="submit" class="btn btn-primary" name="delete" value="{{ po.po_id }}">Yes</button>&nbsp;
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
