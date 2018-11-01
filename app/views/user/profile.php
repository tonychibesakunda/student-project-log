{% extends 'templates/default.php' %}

{% block title %}{{ user.getFullNameOrUsername() }}{% endblock %}

{% block content %}
	<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <p><a href="{{ urlFor('account.profile') }}">Update Profile</a></p>
            <p><a href="{{ urlFor('user.profile', {username: auth.username}) }}">View Profile</a></p>
        </div>
        <div class="col-sm-8  text-left" id="container">
        	<br>
            <!--<h2 style="text-align:center;"><span class="label label-default">Admin Profile</span></h2>-->

<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{ user.getFullNameOrUsername() }}</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
                  <img alt="User Pic" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" class="img-circle img-responsive"> 
                </div>
                
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      {% for u in users %}
                    	<tr>
                    		<td>Username:</td>
                    		<td>{{ u.username }}</td>
                    	</tr>
                    	<tr>
                    		<td>First Name:</td>
                    		<td>{{ u.first_name }}</td>
                    	</tr>
                    	<tr>
                    		<td>Last Name:</td>
                    		<td>{{ u.last_name }}</td>
                    	</tr>
                    	<tr>
                    		<td>Other Names:</td>
                    		<td>{{ u.other_names }}</td>
                    	</tr>
                    	<tr>
                        <td>Email:</td>
                        <td>{{ u.email }}</td>
                      </tr>
                      <tr>
                    		<td>School:</td>
                    		<td>{{ u.school_name }}</td>
                    	</tr>
                      <tr>
                        <td>Department:</td>
                        <td>{{ u.department_name }}</td>
                      </tr>
                      <tr>
                        <td>Account created at:</td>
                        <td>{{ u.created_at|date("d-M-Y H:i") }}</td>
                      </tr>
                      {% endfor %}
                      <!--<tr>
                        <td>Date of Birth</td>
                        <td>01/24/1988</td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td>Gender</td>
                        <td>Female</td>
                      </tr>
                        <tr>
                        <td>Home Address</td>
                        <td>Kathmandu,Nepal</td>
                      </tr>
                      
                        <td>Phone Number</td>
                        <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)
                        </td>-->
                           
                      </tr>
                     
                    </tbody>
                  </table>
                  
                  <!--<a href="#" class="btn btn-primary">My Sales Performance</a>
                  <a href="#" class="btn btn-primary">Team Sales Performance</a>-->
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                 	<a href="{{ urlFor('account.profile') }}" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning" title="Edit Profile"><i class="glyphicon glyphicon-edit"></i></a>
                        <!--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>-->
                        <!--<span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>-->
                    </div>
            
          </div>
        </div>
        <div class="col-sm-2 sidenav">
            <div class="well">
                <label style="font-size: 20px;">Tip <span class="glyphicon glyphicon-info-sign"></span></label>
                <p>This section is used for viewing your profile</p>
            </div>
        </div>
    </div>
</div>

{% endblock %}
