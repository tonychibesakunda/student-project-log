{% extends 'templates/default.php' %}

{% block title %}View Supervisor{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('coordinator.add_supervisor') }}">Add Supervisor</a></p>
            <p><a href="{{ urlFor('coordinator.view_supervisor') }}">View Supervisors</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            
            
                <fieldset>

                    <legend class="text-center">View Supervisor Records</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Account Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if supervisors is empty %}
                                    <tr> 
                                        
                                        <td colspan="5"><h4 style="text-align: center; color: gray;">no records have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                    {% for supervisor in supervisors %}
                                        <tr>
                                            <td>{{ supervisor.first_name }} {{ supervisor.other_names }} {{ supervisor.last_name }}</td>
                                            <td>{{ supervisor.username }}</td>
                                            <td>{{ supervisor.email }}</td>
                                            <th>
                                                {% if supervisor.active == true %}<p style="color: green;">Active</p>{% else %}<p style="color: red;">Inactive</p>{% endif %}
                                            </th>
                                            <td><button type='button' class='btn btn-link'><a href="{{ urlFor('coordinator.edit_supervisor', {id: supervisor.id}) }}">Edit</a></button>&nbsp;
                                            {% if supervisor.active == 0 %}
                                            <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ supervisor.id }}'>Delete</button>
                                            {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                            
                       
                            
                </fieldset>
            
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing supervisors added to the system</p>
            </div>
        </div>
{% for supervisor in supervisors %}
        <div class="modal fade" id="verifyDelete{{ supervisor.id }}" role="dialog">
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
                        <form action="{{ urlFor('coordinator.view_supervisor.post', {id: supervisor.id}) }}" method="POST" autocomplete="off">
                            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                            <button type="submit" class="btn btn-primary" name="delete" value="{{ supervisor.id }}">Yes</button>&nbsp;
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
