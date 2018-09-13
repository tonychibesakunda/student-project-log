{% extends 'templates/default.php' %}

{% block title %}Update profile{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('account.profile') }}">Update Profile</a></p>
            <p><a href="{{ urlFor('user.profile', {username: auth.username}) }}">View Profile</a></p>
        </div>
        <div class="col-sm-8  text-left" id="container">
        	{% include 'templates/partials/error_messages.php' %}
        	{% include 'templates/partials/success_messages.php' %}
        	{% include 'templates/partials/info_messages.php' %}
        	{% include 'templates/partials/warning_messages.php' %}
        	<form action="{{ urlFor('account.profile.post') }}" method="POST" autocomplete="off">
        	
<fieldset>
        	<legend class="text-center">Update Profile</legend>

        	<div class="col-sm-2"></div>

        	<div class="col-sm-8">
        		
        		<div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ request.post('email') ? request.post('email') : auth.email }}">
                    {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
        	</div>
        	<div class="col-sm-2"></div>
         
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

        </fieldset>
    </form>
        </div>
        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for updating your profile</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
