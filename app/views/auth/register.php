{% extends 'templates/default.php' %}

{% block title %}Register{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('register') }}">Add</a></p>
            <p><a href="#">View</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
        	{% include 'templates/partials/error_messages.php' %}
        	{% include 'templates/partials/success_messages.php' %}
        	{% include 'templates/partials/info_messages.php' %}
        	{% include 'templates/partials/warning_messages.php' %}
        	<form action="{{ urlFor('register.post') }}" method="POST" autocomplete="off">
        	
<fieldset>
        	<legend class="text-center">Add Student Account</legend>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="first_name" aria-describedby="firstNameHelp" placeholder="Enter first name" name="first_name"{% if request.post('first_name') %} value="{{request.post('first_name')}}" {% endif %}>
                    {% if errors.first('first_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('first_name')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" aria-describedby="lastNameHelp" placeholder="Enter last name" name="last_name"{% if request.post('last_name') %} value="{{request.post('last_name')}}" {% endif %}>
                    {% if errors.first('last_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('last_name')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="other_names">Other Names</label>
                    <input type="text" class="form-control" id="other_names" aria-describedby="otherNamesHelp" placeholder="Enter other names" name="other_names"{% if request.post('other_names') %} value="{{request.post('other_names')}}" {% endif %}>
                    {% if errors.first('other_names')%}<small class="form-text text-muted" style="color: red;">{{errors.first('other_names')}}</small>{% endif %}
                </div>
            </div>

            <div class="col-sm-6">

                <div class="form-group">
                    <label for="user_name">Username</label>
                    <input type="text" class="form-control" id="user_name" aria-describedby="userNameHelp" placeholder="Enter username" name="user_name"{% if request.post('user_name') %} value="{{request.post('user_name')}}" {% endif %}>
                    {% if errors.first('username')%}<small class="form-text text-muted" style="color: red;">{{errors.first('username')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email"{% if request.post('email') %} value="{{request.post('email')}}" {% endif %}>
                    {% if errors.first('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    {% if errors.first('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Password" name="password_confirm">
                    {% if errors.first('password_confirm')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_confirm')}}</small>{% endif %}
                </div>

            </div>

            <div class="form-group form-inline">
                <label for="accountStatus">Account status:</label>
                <select class="form-control" id="accountStatus" style="width: 10%;">
			        <option>Active</option>
			        <option>Inactive</option>
			      </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for adding pupils to the system</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
