{% extends 'templates/default.php' %}

{% block title %}Add Student{% endblock %}

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
            <form action="{{ urlFor('coordinator.add_student.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Add Student Account</legend>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="first_name" aria-describedby="firstNameHelp" placeholder="Enter first name" name="first_name"{% if request.post('first_name') %} value="{{request.post('first_name')}}" {% endif %}>
                    {% if errors.has('first_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('first_name')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" aria-describedby="lastNameHelp" placeholder="Enter last name" name="last_name"{% if request.post('last_name') %} value="{{request.post('last_name')}}" {% endif %}>
                    {% if errors.has('last_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('last_name')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="other_names">Other Names</label>
                    <input type="text" class="form-control" id="other_names" aria-describedby="otherNamesHelp" placeholder="Enter other names" name="other_names"{% if request.post('other_names') %} value="{{request.post('other_names')}}" {% endif %}>
                    {% if errors.has('other_names')%}<small class="form-text text-muted" style="color: red;">{{errors.first('other_names')}}</small>{% endif %}
                </div>
                
                <div class="form-group">
                    <label for="selectSchool">School:</label>

                    <select class="form-control" id="selectSchool" name="selectSchool">
                        {% if schools is empty %}
                            <option>No school records</option>
                        {% else %}
                            <option>-- select school --</option>
                            {% for school in schools %}
                            <option value="{{ school.school_id }}">{{ school.school_name }}</option>
                            {% endfor %}
                        {% endif %}
                      </select>
                </div>
                   
                <div class="form-group">
                    <label for="accountStatus">Department:</label>
                    <select class="form-control" id="selectSchool" name="selectDept">
                        {% if departments is empty %}
                            <option>No department records</option>
                        {% else %}
                            <option>-- select department --</option>
                            {% for dept in departments %}
                            <option value="{{ dept.department_id }}">{{ dept.department_name }}</option>
                            {% endfor %}
                        {% endif %}
                      </select>
                </div>

            </div>

            <div class="col-sm-6">

                <div class="form-group">
                    <label for="user_name">Username</label>
                    <input type="text" class="form-control" id="user_name" aria-describedby="userNameHelp" placeholder="Enter username" name="user_name"{% if request.post('user_name') %} value="{{request.post('user_name')}}" {% endif %}>
                    {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email"{% if request.post('email') %} value="{{request.post('email')}}" {% endif %}>
                    {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Password" name="password_confirm">
                    {% if errors.has('password_confirm')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_confirm')}}</small>{% endif %}
                </div>

            </div>

            <!--<div class="form-group form-inline">
                <label for="accountStatus">Account status:</label>
                <select class="form-control" id="accountStatus" style="width: 10%;">
                    <option>Active</option>
                    <option>Inactive</option>
                  </select>
            </div>-->
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Add Student</button>
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
