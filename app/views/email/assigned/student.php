{% block content %}
	<p>Hello {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %},</p>

	<p>You have been assigned a supervisor. Your new supervisor is {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %}</p>

	<p>Please login to your account to confirm this</p>
{% endblock %}