{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has edited your scheduled meeting date to: <b>{{ scheduled_date|date("d-M-Y") }}</b></p>

	<p>Please login to your account to view the scheduled dates</p>
{% endblock %}