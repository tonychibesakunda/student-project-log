{% extends 'email/templates/default.php' %}

{% block content %}
	<p>You have been registered for the Student Project Log System</p>

	<p>Activate your account using this link: {{ baseUrl }}{{ urlFor('activate') }}?email={{ user.email }}&identifier={{ identifier|url_encode }}</p>
{% endblock %}