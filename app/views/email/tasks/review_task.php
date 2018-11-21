{% block content %}
	<p>Hello {% for st in student %}{{ st.stFName }} {{ st.stONames }} {{ st.stLName }}{% endfor %},</p>

	<p>Your supervisor: {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %} has added comments to your project task: <b>{% for st in student %}{{ st.task_description }}{% endfor %}</b></p>

	<p>The Comments are as follows:</p>
	<p>" {% for st in student %}{{ st.supervisor_approval_comments }}{% endfor %} "</p>

	<p>Please login to your account to make adjustments</p>
{% endblock %}