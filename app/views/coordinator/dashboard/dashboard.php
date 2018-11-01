{% extends 'templates/default.php' %}

{% block title %}Coordinator Dashboard{% endblock %}

{% block content %}

	{% include 'templates/partials/error_messages.php' %}
	{% include 'templates/partials/success_messages.php' %}
	{% include 'templates/partials/info_messages.php' %}
	{% include 'templates/partials/warning_messages.php' %}

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-12">
				<h1><p style="font-family: Courier New;"><b>Welcome, Project Coordinator</b></p></h1>
			</div>
			<div class="col-sm-3">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Students</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive"> 
	                	<table class="table table-user-information">
		                    <tbody>
		                    	<tr>
		                    		<th>Number of Assigned Students:</th>
		                    		{% for n in num_of_assigned_students %}
		                    		<td>
		                    			{% if n.numOfAssignedStudents > 0 %}
		                    				<p style="color: green;"><b>{{ n.numOfAssignedStudents }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ n.numOfAssignedStudents }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    		{% endfor %}
		                    	</tr>
		                    	<tr>
		                    		<th>Number of Unassigned Students:</th>
		                    		<td>
		                    			{% if unassignedStudents == 0 %}
		                    				<p style="color: green;"><b>{{ unassignedStudents }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ unassignedStudents }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    	</tr>
					  		</tbody>
					  	</table>
					</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('coordinator.assign_supervisors') }}">View More...</a></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Student Accounts</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive"> 
	                	<table class="table table-user-information">
		                    <tbody>
		                    	<tr>
		                    		<th>Number of Active Students:</th>
		                    		<td>
		                    			{% if activeStudents > 0 %}
		                    				<p style="color: green;"><b>{{ activeStudents }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ activeStudents }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    	</tr>
		                    	<tr>
		                    		<th>Number of Inactive Students:</th>
		                    		<td>
		                    			{% if inactiveStudents == 0 %}
		                    				<p style="color: green;"><b>{{ inactiveStudents }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ inactiveStudents }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    	</tr>
					  		</tbody>
					  	</table>
					</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('coordinator.view_student') }}">View More...</a></div>
				</div>	
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Projects in progress</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive">
                        <table id="" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Student Name</th>
                                    <th>Supervisor Name</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                {% if projects is empty %}
                                    <tr><td colspan="7"><h4 style="text-align: center; color: gray;">no projects have been added to the system yet!</h4></td></tr>
                                {% else %}
                                {% for pr in projects %}
                                    <tr>
                                        <td>
                                          {% if pr.projectName is empty %}
                                            <p style="color: red;"><b>project has not yet been added.</b></p>
                                          {% else %}
                                            {{ pr.projectName }}
                                          {% endif %}
                                        </td>
                                        <td>{{ pr.stFName }} {{ pr.stONames }} {{ pr.stLName }}</td>
                                        <td>{{ pr.suFName }} {{ pr.suONames }} {{ pr.suLName }}</td>
                                    </tr>
                                {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>	
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('coordinator.view_projects') }}">View More...</a></div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Projects</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive"> 
	                	<table class="table table-user-information">
		                    <tbody>
		                    	<tr>
		                    		<th>Number of Projects in progress:</th>
		                    		{% for n in num_of_projects_in_progress %}
		                    		<td>
		                    			{% if n.numOfProjectsInProgress > 0 %}
		                    				<p style="color: green;"><b>{{ n.numOfProjectsInProgress }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ n.numOfProjectsInProgress }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    		{% endfor %}
		                    	</tr>
		                    	<tr>
		                    		<th>Number of Completed Projects:</th>
		                    		{% for n in num_of_completed_projects %}
		                    		<td>
		                    			{% if n.numOfCompletedProjects > 0 %}
		                    				<p style="color: green;"><b>{{ n.numOfCompletedProjects }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ n.numOfCompletedProjects }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    		{% endfor %}
		                    	</tr>
					  		</tbody>
					  	</table>
					</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('coordinator.view_projects') }}">View More...</a></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><h4><b>Supervisor Accounts</b></h4></div>
				  <div class="panel-body">
				  	<div class="table-responsive"> 
	                	<table class="table table-user-information">
		                    <tbody>
		                    	<tr>
		                    		<th>Number of Active Supervisors:</th>
		                    		<td>
		                    			{% if activeSupervisors > 0 %}
		                    				<p style="color: green;"><b>{{ activeSupervisors }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ activeSupervisors }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    	</tr>
		                    	<tr>
		                    		<th>Number of Inactive Supervisors:</th>
		                    		<td>
		                    			{% if inactiveSupervisors == 0 %}
		                    				<p style="color: green;"><b>{{ inactiveSupervisors }}</b></p>
		                    			{% else %}
		                    				<p style="color: red;"><b>{{ inactiveSupervisors }}</b></p>
		                    			{% endif %}
		                    		</td>
		                    	</tr>
					  		</tbody>
					  	</table>
					</div>
				  </div>
				  <div class="panel-footer"><a href="{{ urlFor('coordinator.view_supervisor') }}">View More...</a></div>
				</div>	
			</div>		
		</div>
	</div>
{% endblock %}
