{% extends 'templates/default.php' %}

{% block title %}View Student{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('coordinator.add_student') }}">Add Student</a></p>
            <p><a href="{{ urlFor('coordinator.view_student') }}">View Students</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            
            
                <fieldset>

                    <legend class="text-center">View Student Records</legend>

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
                                {% if students is empty %}
                                    <tr> 
                                        
                                        <td colspan="5"><h4 style="text-align: center; color: gray;">no records have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                    {% for student in students %}
                                <tr>
                                    <td>{{ student.first_name }} {{ student.other_names }} {{ student.last_name }}</td>
                                    <td>{{ student.username }}</td>
                                    <td>{{ student.email }}</td>
                                    <th>
                                        {% if student.active == true %}<p style="color: green;">Active</p>{% else %}<p style="color: red;">Inactive</p>{% endif %}
                                    </th>
                                    <td><button type='button' class='btn btn-link'><a href="{{ urlFor('coordinator.edit_student', {id: student.id}) }}">Edit</a></button>&nbsp;<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#verifyDelete{{ student.id }}'>Delete</button></td>
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
                <p>This section is used for viewing students added to the system</p>
            </div>
        </div>
{% for student in students %}
        <div class="modal fade" id="verifyDelete{{ student.id }}" role="dialog">
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
                        <form action="{{ urlFor('coordinator.view_student.post', {id: student.id}) }}" method="POST" autocomplete="off">
                        <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
                        <button type="submit" class="btn btn-primary" name="delete" value="{{ student.id }}">Yes</button>&nbsp;
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
