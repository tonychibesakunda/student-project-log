{% extends 'templates/default.php' %}

{% block title %}Student Projects{% endblock %}

{% block content %}
    <div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('supervisor.student_projects') }}">Student Projects</a></p>
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}

            {% for pd in project_details %}
            <form action="{{ urlFor('supervisor.student_project_details.post', {id: pd.supervision_id}) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            {% endfor %}
                <fieldset>
                
                    <legend class="text-center">Project Details</legend>

                    <div class="col-sm-12">
                      <button type="button" class="btn btn-link"><a href="{{ urlFor('supervisor.student_projects') }}">&larr; Back</a></button>
                    </div>
                    <div class=" col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                              {% for pd in project_details %}
                              <h3 class="panel-title"><b>{{ pd.stFName }} {{ pd.stONames }} {{ pd.stLName }}</b></h3>
                              {% endfor %}
                            </div>
                            <div class="panel-body">
                                
                                 <div class="table-responsive">
                                  <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <th>Student Name:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.stFName }} {{ pd.stONames }} {{ pd.stLName }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Supervisor Name:</th>
                                            {% for pd in project_details %}
                                            <td>{{ pd.suFName }} {{ pd.suONames }} {{ pd.suLName }}</td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Title:</th>
                                            {% for pd in project_details %}
                                            <td>
                                              {% if pd.project_name is empty %}
                                                <p style="color: grey;"><b>project name not yet added...</b></p>
                                              {% else %}
                                                {{ pd.project_name }}
                                              {% endif %}
                                            </td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Category:</th>
                                            {% for pd in project_details %}
                                            <td>
                                              {% if pd.project_category is empty %}
                                                <p style="color: grey;"><b>project category not yet added...</b></p>
                                              {% else %}
                                                {{ pd.project_category }}
                                              {% endif %}
                                            </td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Type:</th>
                                            {% for pd in project_details %}
                                            <td>
                                              {% if pd.project_type is empty %}
                                                <p style="color: grey;"><b>project type not yet added...</b></p>
                                              {% else %}
                                                {{ pd.project_type }}
                                              {% endif %}
                                            </td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project Start Date:</th>
                                            {% for pd in project_details %}
                                            <td>
                                            {% if pd.project_start_date is empty %}
                                                <p style="color: grey;"><b>project start date not yet added...</b></p>
                                            {% else %}  
                                              {{ pd.project_start_date|date("Y-M-d") }}
                                            {% endif %}  
                                            </td>
                                            {% endfor %}
                                        </tr>
                                        <tr>
                                            <th>Project End Date:</th>
                                            {% for pd in project_details %}
                                            <td>
                                            {% if pd.project_end_date is empty %}
                                                <p style="color: grey;"><b>project end date not yet added...</b></p>
                                            {% else %}  
                                              {{ pd.project_end_date|date("Y-M-d") }}
                                            {% endif %}  
                                            </td>
                                            {% endfor %}
                                        </tr>
                                      
                                    </tbody>
                                  </table>
                                </div><!-- end of table responsive -->
                            </div><!-- end of panel body div -->  
                          </div><!-- end of panel div -->
                          <h4><b>Project Aims:</b></h4>
                          {% for pd in project_details %}
                            {% if pd.project_aims is empty %}
                              <p style="color: grey;"><b>* project aims not yet added...</b></p>
                            {% else %}
                              <p>{{ pd.project_aims }}</p>
                            {% endif %}
                          {% endfor %}
                          <div class="item-page-field-wrapper table word-break">
                            <!--<h5>View/<wbr></wbr>Open</h5>-->
                            <div>
                                <!--<a href="#"><i aria-hidden="true" class="glyphicon  glyphicon-file"></i> Journal artcle. (155.5Kb)</a>-->
                            </div>  
                        </div>
                        </div><!-- end of col-sm-6 div -->

                      <div class="col-sm-6">
                          <h4><b>Project Description:</b></h4>
                          {% for pd in project_details %}
                            {% if pd.project_description is empty %}
                              <p style="color: grey;"><b>* project description has not been added yet...</b></p>
                            {% else %}
                              <p>{{ pd.project_description }}</p>
                            {% endif %}
                          {% endfor %}
                      </div>  

                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}"> 
                    <div class="col-sm-12">
                      <h3 style="text-align: center;"><b>Project Objectives</b></h3>
                      <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Objective</th>
                                    <th>Sent for Approval</th>
                                    <th>Objective Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if project_objectives is empty %}
                                    <tr>
                                        <td colspan="4"><h4 style="text-align: center; color: gray;">no project objectives have been added to the system!</h4></td>
                                    </tr>
                                {% else %}
                                {% for po in project_objectives %}
                                <tr>
                                    <input type="hidden" name="objective" data-target="selectObjective{{ po.po_id }}" value="{{ po.po_id }}">
                                    <td>{{ po.project_objective }}</td>
                                    <td>
                                        {% if po.sent_for_approval == true %}
                                            <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                        {% else %}
                                            <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if po.is_completed == true%}
                                            <p style="color: green;">Approved and Completed</p>
                                        {% else %}
                                            <p style="color: red;">Incomplete</p>
                                        {% endif %}
                                    </td>
                                    <td>

                                        <button type='button' class='btn btn-default'><a href="{{ urlFor('supervisor.project_objective_comments', {id: po.po_id}) }}" title="Add Comments"><span class="glyphicon glyphicon-plus"></span></a></button>
                                        
                                        <button type='submit' class='btn btn-success' value="{{ po.po_id }}" title="Approve Objective" name="approve" data-target="#selectObjective{{ po.po_id }}"><span class="glyphicon glyphicon-check"></span></button>
                                    </td>
                                </tr>
                                {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                      
                    </div>

                    <div class="col-sm-12">
                      <h3 style="text-align: center;"><b>Project Report</b></h3>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-8">
                          
                          <div class="table-responsive">
                          <table id="" class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Project Report</th>
                                      <th>Approved</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                
                                {% for pd in project_details %}
                                {% if pd.final_project_report_file_name is empty %}
                                  <tr>
                                    <td colspan="3"><h4 style="text-align: center; color: gray;">project report has not been added to the system yet!</h4></td>
                                  </tr>
                                {% else %}
                                  <tr>
                                      <input type="hidden" name="report" data-target="selectReport{{ pd.student_id }}" value="{{ pd.student_id }}">
                                      <td>
                                        {{ pd.final_project_report_file_name }}
                                      </td>
                                      <td>
                                          {% if pd.is_final_project_report_approved is empty %}
                                              <p style="text-align: center; color: red;"><span class="glyphicon glyphicon-remove"></span></p>
                                          {% else %}
                                              <p style="text-align: center; color: green;"><span class="glyphicon glyphicon-ok"></span></p>
                                          {% endif %}
                                      </td>
                                      <td>

                                          <button type='button' class='btn btn-default'><a href="{{ urlFor('supervisor.project_report_comments', {id: pd.student_id}) }}" title="Add Comments"><span class="glyphicon glyphicon-plus"></span></a></button>
                                          
                                          <button type='submit' class='btn btn-success' title="Approve Report" name="approve_report" data-target="#selectReport{{ pd.student_id }}"><span class="glyphicon glyphicon-check" value="{{ pd.student_id }}"></span></button>
                                          <button type='submit' class='btn btn-info' title="Download Report" name="download"><span class="glyphicon glyphicon-download"></span></button>
                                      </td>
                                  </tr>
                                  {% endif %}
                                 {% endfor %} 
                                
                              </tbody>
                          </table>
                      
                        </div>
                        </div>

                        <div class="col-sm-2"></div>

                        
                     
                </fieldset>
            </form>

        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing student projects</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
