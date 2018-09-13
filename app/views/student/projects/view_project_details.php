{% extends 'templates/default.php' %}

{% block title %}View Project Details{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('student.view_projects') }}">View Completed Projects</a></p>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('student.view_project_details.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">Project Details</legend>

                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-link"><a href="{{ urlFor('student.view_projects') }}">&larr; Back</a></button>
                    </div>
                    <div class=" col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                              <h3 class="panel-title">Student Name</h3>
                            </div>
                            <div class="panel-body">
                                
                                 <div class="table-responsive">
                                  <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>Student Name:</td>
                                            <td>Student Full Names</td>
                                        </tr>
                                        <tr>
                                            <td>Supervisor Name:</td>
                                            <td>Supervisor Full Names</td>
                                        </tr>
                                        <tr>
                                            <td>Project Title:</td>
                                            <td>Project Name</td>
                                        </tr>
                                        <tr>
                                            <td>Project Category:</td>
                                            <td>Web Application</td>
                                        </tr>
                                        <tr>
                                        <td>Project Type:</td>
                                        <td>Taught</td>
                                      </tr>
                                      
                                    </tbody>
                                  </table>
                                </div><!-- end of table responsive -->
                            </div><!-- end of panel body div -->  
                          </div><!-- end of panel div -->
                          <div class="item-page-field-wrapper table word-break">
                            <h5>View/<wbr></wbr>Open</h5>
                            <div>
                                <a href="#"><i aria-hidden="true" class="glyphicon  glyphicon-file"></i> Journal artcle. (155.5Kb)</a>
                            </div>
                        </div>
                        </div><!-- end of col-sm-6 div -->

                      <div class="col-sm-6">
                          <h4>Project Description:</h4>
                          <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.

Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.

Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
                      </div>
                            
                    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">   
                            
                </fieldset>
            </form>
            
        </div>

        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing project details</p>
            </div>
        </div>

    </div>
</div>
{% endblock %}
