{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has updated a task from: <b>{% for t in tasks %}{{ t.task_description }}{% endfor %}</b> to: <b>{% for ts in updated_task %}{{ ts.task_description }}{% endfor %}</b></p>

	<p>Please login to your account to review or approve this task</p>
{% endblock %}