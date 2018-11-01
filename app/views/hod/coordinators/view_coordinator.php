{% extends 'templates/default.php' %}

{% block title %}View Coordinators{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('hod.add_coordinator') }}">Add Coordinator</a></p>
            <p><a href="{{ urlFor('hod.view_coordinator') }}">View Coordinators</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            
                <fieldset>

                    <legend class="text-center">View Coordinator Records</legend>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Account Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if coordinators is empty %}
                                    <tr> 
                                        
                                        <td colspan="4"><h4 style="text-align: center; color: gray;">no records have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                    {% for coordinator in coordinators %}
                                    
                                    <tr>
                                        <input type="hidden" name="_METHOD" value="DELETE">
                                        <td>{{ coordinator.username }}</td>
                                        <td>{{ coordinator.email }}</td>
                                        <th>
                                            {% if coordinator.active == true %}<p style="color: green;">Active</p>{% else %}<p style="color: red;">Inactive</p>{% endif %}
                                        </th>
                                        <td><button type='button' class='btn btn-link' name="edit"><a href="{{ urlFor('hod.edit_coordinator', {id: coordinator.id}) }}">Edit</a></button>&nbsp;
                                        {% if coordinator.active == 0 %}
                                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ coordinator.id }}'>Delete</button></td>
                                        {% endif %}
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
                <p>This section is used for viewing coordinators added to the system</p>
            </div>
        </div>
{% for coordinator in coordinators %}
        <div class="modal fade" id="verifyDelete{{ coordinator.id }}" role="dialog">
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
                        <form action="{{ urlFor('hod.view_coordinator.post', {id: coordinator.id}) }}" method="POST" autocomplete="off">
                        <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                        <button type="submit" class="btn btn-primary" name="delete" value="{{ coordinator.id }}">Yes</button>&nbsp;
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
