{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has sent a task called: <b>{% for ts in updated_task %}{{ ts.task_description }}{% endfor %}</b> for completion</p>

	<p>Please login to your account to review or approve this task for completion</p>
{% endblock %}