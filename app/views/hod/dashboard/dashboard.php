{% extends 'templates/default.php' %}

{% block title %}HOD Dashboard{% endblock %}

{% block content %}
	Head of Department Dashboard
	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/success_messages.php' %}
	{% include 'templates/partials/info_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}
{% endblock %}
