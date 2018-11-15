{% extends 'templates/default.php' %}

{% block title %}Student Dashboard{% endblock %}

{% block content %}
	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/success_messages.php' %}
	{% include 'templates/partials/info_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-12">
				{% if auth %}
					<h1><p style="font-family: Courier New;"><b>Welcome, {{ auth.getFullNameOrUsername() }}</b></p></h1>
				{% endif %}
			</div>
			<div class="col-sm-2 sidenav">
				<div class="panel panel-default">
					<div class="panel-heading"><h4><b>Supervisors</b></h4></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-user-information text-left">
								<tbody>
									{% if activeSupervisors is empty %}
										<tr><td colspan="1"><h4 style="text-align: center; color: gray;">supervisor records are not yet available</h4></td></tr>
									{% else %}
									{% for s in activeSupervisors %}
									<tr>
										<td>{{ s.first_name }}{{ s.other_names }} {{ s.last_name }}</td>
									</tr>	
									{% endfor %}
									{% endif %}
								</tbody>
							</table>
						</div>

					</div>
					<div class="panel-footer">
						<a href="{{ urlFor('student.view_supervisors') }}">More details...</a>	
					</div>
				</div>
			</div>
			<div class="col-sm-8" id="container">
				{% if auth.isAssigned() %}
					<div class="col-sm-12">
						<h4 class="text-center"><b>Project Date Progress</b></h4>
						{% if dates is empty %}
							<p style="color: gray;"><b>* project start and end dates not yet added...</b></p>
						{% else %}
						{% for d in dates %}
						<div class="progress">
							{% if dayPerc <= 70 %}
							    <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" aria-valuenow="0" aria-valuemin="0"  aria-valuemax="100" style="width:{{ dayPerc }}%">
							      {% set difference = date(d.project_end_date).diff(date(currentDate)) %}
	                              {% set leftDays = difference.days %}
	                              {% if leftDays <= 0 or date(d.project_end_date) < date(currentDate) %} 
		                               <p><b>0 Days remaining</b></p> 
		                          {% else %}
		                               <p><b>{{ leftDays }} Days remaining</b></p>
		                          {% endif %}
							    </div>
						    {% elseif dayPerc > 70 and dayPerc <= 90 %}
						    	<div class="progress-bar progress-bar-striped progress-bar-warning active" role="progressbar" aria-valuenow="0" aria-valuemin="0"  aria-valuemax="100" style="width:{{ dayPerc }}%">
							      {% set difference = date(d.project_end_date).diff(date(currentDate)) %}
	                              {% set leftDays = difference.days %}
	                              {% if leftDays <= 0 or date(d.project_end_date) < date(currentDate) %} 
		                               <p><b>0 Days remaining</b></p> 
		                          {% else %}
		                               <p><b>{{ leftDays }} Days remaining</b></p>
		                          {% endif %}
							    </div>
						    {% elseif dayPerc > 90 and dayPerc <= 100 %}
						    	<div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar" aria-valuenow="0" aria-valuemin="0"  aria-valuemax="100" style="width:{{ dayPerc }}%">
							      {% set difference = date(d.project_end_date).diff(date(currentDate)) %}
	                              {% set leftDays = difference.days %}
	                              {% if leftDays <= 0 or date(d.project_end_date) < date(currentDate) %} 
		                               <p><b>0 Days remaining</b></p> 
		                          {% else %}
		                               <p><b>{{ leftDays }} Days remaining</b></p>
		                          {% endif %}
							    </div>
							{% elseif dayPerc > 100 %}
								<div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar" aria-valuenow="0" aria-valuemin="0"  aria-valuemax="100" style="width:{{ dayPerc }}%">
							      {% set difference = date(d.project_end_date).diff(date(currentDate)) %}
	                              {% set leftDays = difference.days %}
	                              {% if leftDays <= 0 or date(d.project_end_date) < date(currentDate) %} 
		                               <p><b>0 Days remaining</b></p> 
		                          {% else %}
		                               <p><b>{{ leftDays }} Days remaining</b></p>
		                          {% endif %}
							    </div>
						    {% endif %}
						</div>
						{% endfor %}
						{% endif %}
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
						  <div class="panel-heading"><h4><b>Project Objectives</b></h4></div>
						  <div class="panel-body">
						  	<div class="table-responsive">
						  		<table class="table table-bordered table-hover text-left">
						  			<thead>
						  				<tr>
						  					<th>Objective</th>
						  					<th>Approved</th>
						  					<th>Supervisor Comments</th>
						  				</tr>
						  			</thead>
						  			<tbody>
						  				{% if project_objectives is empty %}
						  					<tr><td colspan="3"><h4 style="text-align: center; color: gray;">project objectives have not been added yet.</h4></td></tr>
						  				{% else %}
						  				{% for po in project_objectives %}
							  				<tr>
							  					<td>{{ po.project_objective }}</td>
							  					<td>
							  						{% if po.is_completed == true %}
							  							<p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
							  						{% else %}
							  							<p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
							  						{% endif %}
							  					</td>
							  					<td>
							  						{% if po.supervisor_comments is empty %}
							  							<p>No Comments</p>
							  						{% else %}
							  							<p style="color: blue;"><b>Comments have been added</b></p>
							  						{% endif %}
							  					</td>
							  				</tr>
							  			{% endfor %}
						  				{% endif %}
						  			</tbody>
						  		</table>
						  	</div>
						  </div>
						  <div class="panel-footer"><a href="{{ urlFor('student.view_project_objective') }}">More details...</a></div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
						  <div class="panel-heading"><h4><b>Project Tasks</b></h4></div>
						  <div class="panel-body">
						  	<div class="table-responsive">
						  		<table class="table table-bordered table-hover text-left">
						  			<thead>
						  				<tr>
						  					<th>Task</th>
						  					<th>Approved</th>
						  					<th>Completed</th>
						  				</tr>
						  			</thead>
						  			<tbody>
						  				{% if tasks is empty %}
						  					<tr><td colspan="3"><h4 style="text-align: center; color: gray;">project tasks have not been added yet.</h4></td></tr>
						  				{% else %}
						  				{% for ts in tasks %}
						  					<tr>
						  						<td>{{ ts.task_description }}</td>
						  						<td>
						  							{% if ts.is_approved == true %}
						  								<p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
						  							{% else %}
						  								<p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
						  							{% endif %}
						  						</td>
						  						<td>
						  							{% if ts.is_completed == true %}
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
						  <div class="panel-footer"><a href="{{ urlFor('student.view_tasks') }}">More details...</a></div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="panel panel-default">
							  <div class="panel-heading"><h4><b>Project Report</b></h4></div>
							  <div class="panel-body">
							  	<div class="table-responsive">
							  		<table class="table table-bordered text-left">
							  			<thead>
							  				<tr>
							  					<th>Project Report</th>
							  					<th>Approved</th>
							  					<th>Supervisor Comments</th>
							  				</tr>
							  			</thead>
							  			<tbody>
							  				{% for pr in project_report %}
			                                {% if pr.final_project_report_file_name is empty %}
			                                  <tr><td colspan="3"><h4 style="text-align: center; color: gray;">you have not added your project report!</h4></td></tr>
			                                {% else %}
			                                  <tr>
			                                      <td>{{ pr.final_project_report_file_name }}</td>
			                                      <td>
			                                          {% if pr.is_final_project_report_approved is empty %}
			                                              <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
			                                          {% else %}
			                                              <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
			                                          {% endif %}
			                                      </td>
			                                      <td>
			                                        {% if pr.supervisor_comments is empty %}
			                                          <p style="color: gray;"><b>* no supervisor comments...</b></p>
			                                        {% else %}
			                                          <p>{{ pr.supervisor_comments }}</p>
			                                        {% endif %}
			                                      </td>
			                                  </tr>
			                                  {% endif %}
			                                 {% endfor %}
							  			</tbody>
							  		</table>
							  	</div>
							  </div>
							  <div class="panel-footer"><a href="{{ urlFor('student.add_project_report') }}">More details...</a></div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				{% endif %}
			</div>
			<div class="col-sm-2 sidenav">
				<div class="panel panel-default">
					<div class="panel-heading"><h4><b>Completed Projects</b></h4></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-user-information text-left">
								<tbody>
									<tr>
										<th>Number of projects:</th>
										<td>	
										{% for n in num_of_completed_projects %}
											{% if n.numOfCompletedProjects <= 0 %}
												<p style="color: red;"><b>{{ n.numOfCompletedProjects }}</b></p>
											{% else %}
												<p style="color: green;"><b>{{ n.numOfCompletedProjects }}</b></p>
											{% endif %}
										{% endfor %}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="panel-footer">
						<a href="{{ urlFor('student.view_projects') }}">More details...</a>	
					</div>
				</div>
				{% if auth.isAssigned() %}
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Schedules</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive">
				  		<table class="table table-bordered table-hover text-left">
				  			<thead>
				  				<tr>
				  					<th>Scheduled date</th>
				  					<th>Days Remaining</th>
				  				</tr>
				  			</thead>
				  			<tbody>
				  				{% if scheduled_meetings is empty %}
				  					<tr><td colspan="2"><h4 style="text-align: center; color: gray;">you have not added any scheduled meetings yet.</h4></td></tr>
				  				{% else %}
				  				{% for sm in scheduled_meetings %}
				  					<tr>
				  						<td>{{ sm.scheduled_date|date("d-M-Y") }}</td>
				  						{% set difference = date(sm.scheduled_date).diff(date(current_date)) %}
		                                {% set leftDays = difference.days %}
		                                <th>
		                                    {% if leftDays <= 0 or date(sm.scheduled_date) < date(current_date) %} 
		                                        <p style="color: red;"><b>0</b></p> 
		                                    {% else %}
		                                        <p style="color: green;"><b>{{ leftDays }}</b></p>
		                                    {% endif %}
		                                </th>
				  					</tr>
				  				{% endfor %}
				  				{% endif %}
				  			</tbody>
				  		</table>
				  	</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('student.view_scheduled_meetings') }}">More details...</a></div>
				</div>
				{% endif %}
			</div>
		</div>		
	</div>
{% endblock %}
