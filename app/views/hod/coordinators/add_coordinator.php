{% extends 'templates/default.php' %}

{% block title %}Add Coordinator{% endblock %}

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
            <form action="{{ urlFor('hod.add_coordinator.post') }}" method="POST" autocomplete="off">
            
<fieldset>
            <legend class="text-center">Add Coordinator Account</legend>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="user_name">Username</label>
                    <input type="text" class="form-control" id="user_name" aria-describedby="userNameHelp" placeholder="Enter username" name="user_name"{% if request.post('user_name') %} value="{{request.post('user_name')}}" {% endif %} required>
                    {% if errors.has('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email"{% if request.post('email') %} value="{{request.post('email')}}" {% endif %} required>
                    {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                    {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Password" name="password_confirm" required>
                    {% if errors.has('password_confirm')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_confirm')}}</small>{% endif %}
                </div>
                
            </div>

            <div class="col-sm-6">

                <div class="form-group">
                    <label for="selectSchool">School:</label>

                    <select class="form-control" id="selectSchool" name="selectSchool" required>
                        {% if schools is empty %}
                            <option>No school records</option>
                        {% else %}
                            <option value="no">-- select school --</option>
                            {% for school in schools %}
                            <option value="{{ school.school_id }}">{{ school.school_name }}</option>
                            {% endfor %}
                        {% endif %}
                      </select>
                      {% if errors.has('selectSchool')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSchool')}}</small>{% endif %}
                </div>
                   
                <div class="form-group">
                    <label for="accountStatus">Department:</label>
                    <select class="form-control" id="selectDept" name="selectDept" required>
                        {% if departments is empty %}
                            <option>No department records</option>
                        {% else %}
                            <option value="no">-- select department --</option>
                            {% for dept in departments %}
                            <option value="{{ dept.department_id }}">{{ dept.department_name }}</option>
                            {% endfor %}
                        {% endif %}
                      </select>
                      {% if errors.has('selectDept')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectDept')}}</small>{% endif %}
                </div>

            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Add Coordinator</button>
                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
            </div>
            
        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding coordinators to the system</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
