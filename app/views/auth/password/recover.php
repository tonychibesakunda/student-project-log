{% extends 'templates/login_default.php' %}

{% block title %}Recover password{% endblock %}

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
        	<form action="{{ urlFor('password.recover.post') }}" method="POST" autocomplete="off">
        	
<fieldset>
        	<legend class="text-center">Recover Password</legend>

        	<div class="col-sm-2"></div>

        	<div class="col-sm-8">
        		<p><b>NOTE: </b>Enter your email address to start your password recovery.</p>
        		<div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email"{% if request.post('email') %} value="{{request.post('email')}}" {% endif %}>
                    {% if errors.has('email')%}<small class="form-text text-muted" style="color: red;">{{errors.first('email')}}</small>{% endif %}
                </div>
                <button type="submit" class="btn btn-primary">Request reset</button>
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
