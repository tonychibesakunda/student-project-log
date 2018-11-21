{% block content %}
	<p>Hello {% for st in student %}{{ st.stFName }} {{ st.stONames }} {{ st.stLName }}{% endfor %},</p>

	<p>Your supervisor: {% for sp in supervisor %}{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}{% endfor %} has approved your project report: <b>{% for st in student %}{{ st.final_project_report_file_name }}{% endfor %}</b></p>

	<p><b>Approval of your project report marks the end of your project.</b></p>
	<p>Thank you for using the Student Project Logbook</p>
{% endblock %}