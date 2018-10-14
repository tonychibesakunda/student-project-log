{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has added: <b>{{ scheduled_date|date("d-M-Y") }}</b> as a date for your next supervisory meeting</p>

	<p>Please login to your account to view the scheduled dates</p>
{% endblock %}