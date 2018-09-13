{% extends 'templates/login_default.php' %}

{% block title %}Reset password{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            
        </div>

        <div class="col-sm-8  text-left" id="container">
        	{% include 'templates/partials/error_messages.php' %}
        	{% include 'templates/partials/success_messages.php' %}
        	{% include 'templates/partials/info_messages.php' %}
        	{% include 'templates/partials/warning_messages.php' %}
        	<form action="{{ urlFor('password.reset.post') }}?email={{ email }}&identifier={{ identifier|url_encode }}" method="POST" autocomplete="off">
        	
<fieldset>
        	<legend class="text-center">Reset Password</legend>

        	<div class="col-sm-2"></div>

        	<div class="col-sm-8">
        		<div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                    {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Confirm Password" name="password_confirm">
                    {% if errors.has('password_confirm')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_confirm')}}</small>{% endif %}
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
        	</div>
        	<div class="col-sm-2"></div>
         
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            
        </div>

    </div>
</div>
{% endblock %}
