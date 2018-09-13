{% extends 'templates/default.php' %}

{% block title %}Supervisor Dashboard{% endblock %}

{% block content %}
	Supervisor Dashboard
	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/success_messages.php' %}
	{% include 'templates/partials/info_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}
{% endblock %}
