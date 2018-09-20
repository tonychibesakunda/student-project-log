{% extends 'templates/default.php' %}

{% block title %}Edit Assigned Supervisors{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">Project Categories</div>
                  <div class="panel-body">
                     <p><a href="{{ urlFor('coordinator.add_project_category') }}">Add</a></p> 
                     <p><a href="{{ urlFor('coordinator.view_project_category') }}">View</a></p> 
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Project Types</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.add_project_type') }}">Add</a></p>
                      <p><a href="{{ urlFor('coordinator.view_project_type') }}">View</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Supervision</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.assign_supervisors') }}">Assign Supvervisors</a></p>
                      <p><a href="{{ urlFor('coordinator.view_assigned_supervisors') }}">View Assigned Supvervisors</a></p>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Student Projects</div>
                  <div class="panel-body">
                      <p><a href="{{ urlFor('coordinator.view_projects') }}">View Projects</a></p>
                  </div>
                </div>
          </div>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
          {% include 'templates/partials/error_messages.php' %}
          {% include 'templates/partials/success_messages.php' %}
          {% include 'templates/partials/info_messages.php' %}
          {% include 'templates/partials/warning_messages.php' %}
          {% for sp in supervision %}
          <form action="{{ urlFor('coordinator.edit_assigned_supervisors.post', {id: sp.supervision_id}) }}" method="POST" autocomplete="off">
          {% endfor %}
<fieldset>
          <legend class="text-center">Edit Assigned Supervisors</legend>

          <div class="col-sm-2"></div>

          <div class="col-sm-8">
            
            <div class="form-group">
              <label for="selectStudent">Student:</label>
              <select class="form-control" id="selectStudent" name="selectStudent">
                {% if supervision is empty %}
                  <option> No student records</option>
                {% else %}
                  <option>-- select student --</option>
                {% for sp in supervision %}
                {% for student in students %}
                    {% if sp.student_id == student.student_id %}
                      <option value="{{ student.student_id }}" selected>{{ student.first_name }} {{ student.other_names }} {{ student.last_name }}</option>
                    {% else %}
                      <option value="{{ student.student_id }}">{{ student.first_name }} {{ student.other_names }} {{ student.last_name }}</option>
                    {% endif %}
                {% endfor %} 
                {% endfor %}
                {% endif %}
              </select>
              {% if errors.has('selectStudent')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectStudent')}}</small>{% endif %}
            </div>

            <div class="form-group">
              <label for="selectSupervisor">Supervisor:</label>
              <select class="form-control" id="selectSupervisor" name="selectSupervisor">
                {% if supervision is empty %}
                  <option> No student records</option>
                {% else %}
                  <option>-- select student --</option>
                {% for sp in supervision %}
                {% for supervisor in supervisors %}
                    {% if sp.supervisor_id == supervisor.supervisor_id %}
                      <option value="{{ supervisor.supervisor_id }}" selected>{{ supervisor.first_name }} {{ supervisor.other_names }} {{ supervisor.last_name }}</option>
                    {% else %}
                      <option value="{{ supervisor.supervisor_id }}">{{ supervisor.first_name }} {{ supervisor.other_names }} {{ supervisor.last_name }}</option>
                    {% endif %}
                {% endfor %} 
                {% endfor %}
                {% endif %}  
              </select>
              {% if errors.has('selectSupervisor')%}<small class="form-text text-muted" style="color: red;">{{errors.first('selectSupervisor')}}</small>{% endif %}
            </div>
            
            <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
            <button type="submit" class="btn btn-link" name="back"><a href="{{ urlFor('coordinator.view_assigned_supervisors') }}">&larr; Back</a></button>
          </div>
          <div class="col-sm-2"></div>
         
            <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">

        </fieldset>
    </form>
    </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for editing assigned supervisors to students</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
