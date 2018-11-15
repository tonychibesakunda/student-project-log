{% extends 'templates/default.php' %}

{% block title %}Supervisor Dashboard{% endblock %}

{% block content %}

	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/success_messages.php' %}
	{% include 'templates/partials/info_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-12">
				{% if auth %}
					<h1><p style="font-family: Courier New;"><b>Welcome, {{ auth.getFullNameOrUsername() }}</b></p></h1><br>
				{% endif %}
			</div>
			<div class="col-sm-3">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Students</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive">
				  		<table class="table table-bordered table-hover text-left">
				  			<thead>
				  				<tr>
				  					<th>Project</th>
				  					<th>Student</th>
				  				</tr>
				  			</thead>
				  			<tbody>
				  				{% if student_projects is empty %}
				  					<tr><td colspan="2"><h4 style="text-align: center; color: gray;">you are not currently supervising any projects.</h4></td></tr>
				  				{% else %}
				  				{% for sp in student_projects %}
				  					<tr>
				  						<td>
				  							{% if sp.project_name is empty %}
				  								<p style="color: red;"><b>not yet added</b></p>
				  							{% else %}
				  								{{ sp.project_name }}
				  							{% endif %}
				  						</td>
				  						<td>{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}</td>
				  					</tr>
				  				{% endfor %}
				  				{% endif %}
				  			</tbody>
				  		</table>
				  	</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('supervisor.student_projects') }}">More details...</a></div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Student Tasks</b></div>
				  <div class="panel-body">
				  	<div class="table-responsive">
				  		<table class="table table-bordered table-hover text-left">
				  			<thead>
				  				<tr>
				  					<th>Student</th>
				  					<th>Task</th>
				  					<th>Sent for Approval</th>
				  					<th>Sent for Completion</th>
				  				</tr>
				  			</thead>
				  			<tbody>
				  				{% if tasks is empty %}
				  					<tr><td colspan="4"><h4 style="text-align: center; color: gray;">tasks have not been added.</h4></td></tr>
				  				{% else %}
				  				{% for ts in tasks %}
				  					<tr>
				  						<td>{{ ts.stFName }} {{ ts.stONames }} {{ ts.stLName }}</td>
				  						<td>{{ ts.task_description }}</td>
				  						<td>
				  							{% if ts.sent_for_approval == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p> 
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
				  						</td>
				  						<td>
				  							{% if ts.sent_for_completion == true %}
                                                <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                            {% else %}
                                                <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                            {% endif %}
				  						</td>
				  					</tr>
				  				{% endfor %}
				  				{% endif %}
				  			</tbody>
				  		</table>
				  	</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('supervisor.student_tasks') }}">More details...</a></div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Scheduled Meetings</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive">
				  		<table class="table table-bordered table-hover text-left">
				  			<thead>
				  				<tr>
				  					<th>Date</th>
				  					<th>Days Remaining</th>
				  					<th>Student</th>
				  				</tr>
				  			</thead>
				  			<tbody>
				  				{% if supervisions is empty %}
				  					<tr><td colspan="3"><h4 style="text-align: center; color: gray;">dates have not been added.</h4></td></tr>
				  				{% else %}
				  				{% for s in supervisions %}
	                                <tr>
	                                    <td>{{ s.scheduled_date|date("d-M-Y")}}</td>
	                                    {% set difference = date(s.scheduled_date).diff(date(current_date)) %}
	                                    {% set leftDays = difference.days %}
	                                        <th style="text-align: center;">
	                                            {% if leftDays <= 0 or date(s.scheduled_date) < date(current_date) %} 
	                                                <p style="color: red;"><b>0</b></p> 
	                                            {% else %}
	                                                <p style="color: green;"><b>{{ leftDays }}</b></p>
	                                            {% endif %}
	                                        </th>
	                                    <td>{{ s.stFName }} {{ s.stONames }} {{ s.stLName }}</td>
	                                </tr>
	                            {% endfor %}	
				  				{% endif %}
				  			</tbody>
				  		</table>
				  	</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('supervisor.scheduled_meetings') }}">view more dates...</a></div>
				</div>
			</div>
		</div>
	</div>
{% endblock %}
