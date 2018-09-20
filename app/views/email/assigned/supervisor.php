{% block content %}
	<p>Hello {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %},</p>

	<p>You have been assigned to supervise {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} on their final year project </p>

	<p>Please login to your account to confirm this</p>
{% endblock %}