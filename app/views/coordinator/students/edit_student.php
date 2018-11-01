{% extends 'templates/default.php' %}

{% block title %}Edit Student{% endblock %}

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

            {% for row in userInfo %}
            <form action="{{ urlFor('coordinator.edit_student.post', {id: row.id}) }}" method="POST" autocomplete="off">
            {% endfor %}
<fieldset>
            <legend class="text-center">Edit Student Account</legend>
            <div class="col-sm-6">


            <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Current Information</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-12 col-lg-12 table-responsive"> 
                      <table class="table table-user-information">
                        <tbody>
                            <tr>
                                <td><label for="firstName">First Name:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.first_name }}</p>
                                    {% endfor %}
                                    <input type="hidden" name="first_name" id="firstName" value="{{ request.post('first_name') ? request.post('first_name') : user.first_name }}">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="last_name">Last Name:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.last_name }}</p>
                                    {% endfor %}
                                    <input type="hidden" name="last_name" id="last_name" value="{{ request.post('last_name') ? request.post('last_name') : user.last_name }}"> 
                                </td>
                            </tr>
                            <tr>
                                <td><label for="other_names">Other Names:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{% if row.other_names is empty %} {% else %}{{ row.other_names }}{% endif %}</p>
                                    {% endfor %}
                                    <input type="hidden" name="other_names" id="other_names" value="{{ request.post('other_names') ? request.post('other_names') : user.other_names }}"> 
                                </td>
                            </tr>
                            <tr>
                                <td><label for="user_name">Username:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.username }}</p>
                                    {% endfor %}
                                    <input type="hidden" name="user_name" id="user_name" value="{{ request.post('user_name') ? request.post('user_name') : user.username }}">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="email">Email address:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.email }}</p>
                                    {% endfor %}
                                    <input type="hidden" name="email" id="email" value="{{ request.post('email') ? request.post('email') : user.email }}">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="School">School:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.school_name }}</p>
                                    {% endfor %}
                                </td>
                            </tr>
                            <tr>
                                <td><label for="Department">Department:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.department_name }}</p>
                                    {% endfor %}
                                </td>
                            </tr>
                            <tr>
                                <td><label for="Account">Account Created at:</label></td>
                                <td>
                                    {% for row in userInfo %}
                                    <p>{{ row.created_at }}</p>
                                    {% endfor %}
                                </td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>

            </div>

            <div class="col-sm-6">

                <div class="form-group">
                    <label for="selectSchool">School:</label>

                    <select class="form-control" id="selectSchool" name="selectSchool">
                        {% if schools is empty %}
                            <option>No school records</option>
                        {% else %}
                            <option>-- select school --</option>
                            {% for row in userInfo %}
                                {% for school in schools %}
                                    {% if row.school_id == school.school_id %}
                                        <option value="{{ school.school_id }}" selected>{{ school.school_name }}</option>    
                                    {% else %}
                                        <option value="{{ school.school_id }}">{{ school.school_name }}</option>
                                    {% endif %}
                                {% endfor %}
                            {% endfor %}
                        {% endif %}
                    </select>
                    {% if errors.has('selectSchool')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSchool')}}</small>{% endif %}
                </div>
                   
                <div class="form-group">
                    <label for="selectDept">Department:</label>
                    <select class="form-control" id="selectDept" name="selectDept">
                        {% if departments is empty %}
                            <option>No department records</option>
                        {% else %}
                            <option>-- select department --</option>
                            {% for row in userInfo %}
                                {% for dept in departments %}
                                    {% if row.department_id == dept.department_id %}
                                        <option value="{{ dept.department_id }}" selected>{{ dept.department_name }}</option>    
                                    {% else %}
                                        <option value="{{ dept.department_id }}">{{ dept.department_name }}</option>
                                    {% endif %}
                                {% endfor %}
                            {% endfor %}
                        {% endif %}
                      </select>
                      {% if errors.has('selectDept')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectDept')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="accountStatus">Account Status:</label>
                    <select class="form-control" id="accountStatus" name="accountStatus">
                        {% for row in userInfo %}
                            {% if row.active == 1 %}
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            {% else %}
                                <option value="1" >Active</option>
                                <option value="0" selected>Inactive</option>
                            {% endif %}
                        {% endfor %}
                  </select>
                  {% if errors.has('accountStatus')%}<small class="form-text text-muted" style="color: red;">{{errors.first('accountStatus')}}</small>{% endif %}
                </div>

            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                <button type="submit" class="btn btn-link" name="back"><a href="{{ urlFor('coordinator.view_student') }}">&larr;Back</a></button>
                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
            </div>
            
        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding students to the system</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
