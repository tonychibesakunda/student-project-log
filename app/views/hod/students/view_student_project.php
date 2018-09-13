{% extends 'templates/default.php' %}

{% block title %}View Student Project{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content"><br>

        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('hod.view_assigned_students') }}">View Assigned Students</a></p>
             
        </div>

        <div class="col-sm-8  text-left" id="container">
            {% include 'templates/partials/error_messages.php' %}
            {% include 'templates/partials/success_messages.php' %}
            {% include 'templates/partials/info_messages.php' %}
            {% include 'templates/partials/warning_messages.php' %}
            <form action="{{ urlFor('hod.view_assigned_students.post') }}" method="POST" autocomplete="off">
            
                <fieldset>

                    <legend class="text-center">View Student Project</legend>
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-link"><a href="{{ urlFor('hod.view_assigned_students') }}">&larr; Back</a></button>
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
                      </div><!-- end of col-md-9 div -->

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
                <p>This section is used for viewing student projects</p>
            </div>
        </div>

        <div class="modal fade" id="verifyDelete" role="dialog">
            <div class="modal-dialog">
                <!-- Modal Content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title"><span class="label label-danger">Are You Sure?</span></h1>
                    </div>
                    <div class="modal-body">
                        <p>This record will permanently be deleted / removed from the system. Do you wish to continue?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{% endblock %}
