{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has updated their project objective to: <b>{% for po in project_objectives %}{{ po.project_objective }}{% endfor %}</b></p>

	<p>Please login to your account to review the project objective</p>
{% endblock %}