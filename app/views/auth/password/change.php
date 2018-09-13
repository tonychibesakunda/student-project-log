{% extends 'templates/default.php' %}

{% block title %}Change password{% endblock %}

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
        	<form action="{{ urlFor('password.change.post') }}" method="POST" autocomplete="off">
        	
<fieldset>
        	<legend class="text-center">Change Password</legend>

        	<div class="col-sm-2"></div>

        	<div class="col-sm-8">
        		<div class="form-group">
                    <label for="password_old">Old Password</label>
                    <input type="password" class="form-control" id="password_old" placeholder="Enter Old Password" name="password_old">
                    {% if errors.has('password_old')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_old')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter New Password" name="password">
                    {% if errors.has('password')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password')}}</small>{% endif %}
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirm new Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Confirm New Password" name="password_confirm">
                    {% if errors.has('password_confirm')%}<small class="form-text text-muted" style="color: red;">{{errors.first('password_confirm')}}</small>{% endif %}
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
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
