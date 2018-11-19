{% block content %}
	<p>Hello {% for sp in supervisors %}{{ sp.suFName }} {{ sp.suONames }} {{ sp.suLName }}{% endfor %},</p>

	<p>Your student: {% for st in student %}{{ st.first_name }} {{ st.other_names }} {{ st.last_name }}{% endfor %} has uploaded their project report (thesis): <b>{% for pr in project_report %}{{ pr.final_project_report_file_name }}{% endfor %}</b></p>

	<p>Please login to your account to review and approve the project report</p>
{% endblock %}