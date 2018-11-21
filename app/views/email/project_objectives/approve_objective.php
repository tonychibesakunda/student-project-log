{% block content %}
	<p>Hello {% for st in student %}{{ st.stFName }} {{ st.stONames }} {{ st.stLName }}{% endfor %},</p>

	<p>Your supervisor: {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %} has approved your project objective: <b>{% for po in project_objective %}{{ po.project_objective }}{% endfor %}</b></p>

	<p>Please login to your account to continue with your project</p>
{% endblock %}