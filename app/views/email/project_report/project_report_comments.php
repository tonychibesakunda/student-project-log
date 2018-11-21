{% block content %}
	<p>Hello {% for st in student %}{{ st.stuFName }} {{ st.stuONames }} {{ st.stuLName }}{% endfor %},</p>

	<p>Your supervisor: {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %} has added comments concerning your project report: <b>{% for pr in project_report %}{{ pr.final_project_report_file_name }}{% endfor %}</b></p>

	<p>The comments are as follows: </p>
	<p>" {% for pr in project_report %}{{ pr.supervisor_comments }}{% endfor %} "</p>

	<p>Please login to your account to make adjustments</p>
{% endblock %}