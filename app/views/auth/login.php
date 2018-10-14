{% extends 'templates/login_default.php' %}

{% block title %}Login{% endblock %}

{% block content %}
	 <div class="container">
	 	{% include 'templates/partials/error_messages.php' %}
	 	{% include 'templates/partials/warning_messages.php' %}
        {% include 'templates/partials/success_messages.php' %}
        {% include 'templates/partials/info_messages.php' %}
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" alt="profile_avator" />
            <p id="profile-name" class="profile-name-card">Login</p>
			
            <form class="form-signin" action="{{ urlFor('login.post') }}" method="POST" autocomplete="off">
                <span id="reauth-email" class="reauth-email"></span>
                
                <input type="text" id="username" name="username" class="form-control" placeholder="Username/Computer Number" autofocus>
                {% if errors.first('username') %}<small style="color: red;">{{ errors.first('username') }}</small>{% endif %}<br>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" style="height: 35px;">
                {% if errors.first('password') %}<small style="color: red;">{{ errors.first('password') }}</small>{% endif %}
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me" name="remember" id="remember"> Remember me
                    </label>
                </div>

                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>

                <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
            </form><!-- /form -->
            <a href="{{ urlFor('password.recover') }}" class="forgot-password">
                Forgot the password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
{% endblock %}
