{% block content %}
	<p>Hello {% for st in student %}{{ st.stuFName }} {{ st.stuONames }} {{ st.stuLName }}{% endfor %},</p>

	<p>Your supervisor: {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %} has added comments to your project objective: <b>{% for po in project_objective %}{{ po.project_objective }}{% endfor %}</b></p>

	<p>The comments are as follows: </p>
	<p>" {% for po in project_objective %}{{ po.supervisor_comments }}{% endfor %} "</p>

	<p>Please login to your account to make adjustments</p>
{% endblock %}