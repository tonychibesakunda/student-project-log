{% extends 'templates/default.php' %}

{% block title %}All Users{% endblock %}

{% block content %}
	
	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}
	<h2>All users</h2>

	{% if users is empty %}
		<p>No registered users.</p>
	{% else %}
		{% for user in users %}
			<div class="user">
				<a href="{{ urlFor('user.profile', {username: user.username}) }}">{{ user.username }}</a>
				{% if user.getFullName() %}
					({{ user.getFullName() }})
				{% endif %}
				
			</div>
		{% endfor %}
	{% endif %}
{% endblock %}
