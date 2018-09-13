{% extends 'templates/home_default.php' %}

{% block title %}Home{% endblock %}

{% block content %}
	Home
	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}
{% endblock %}
