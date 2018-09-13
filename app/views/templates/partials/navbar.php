<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
                <a class="navbar-brand" href="#">Student Project Logbook</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    
                    {% if auth %}


                    <!-- HOD NAVBAR LINKS -->
                    {% if auth.isHod() %}
                        <li><a href="{{ urlFor('hod.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ urlFor('hod.view_assigned_students') }}">Students</a></li>
                        <li><a href="{{ urlFor('hod.view_projects') }}">Projects</a></li>
                        <li><a href="{{ urlFor('hod.view_coordinator') }}">Coordinators</a></li>
                    {% endif %}
                    <!-- HOD NAVBAR LINKS -->

                    <!-- PROJECT COORDINATOR NAVBAR LINKS -->
                    {% if auth.isCoordinator() %}
                        <li><a href="{{ urlFor('coordinator.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ urlFor('coordinator.view_student') }}">Students</a></li>
                        <li><a href="{{ urlFor('coordinator.view_projects') }}">Projects</a></li>
                        <li><a href="{{ urlFor('coordinator.add_supervisor') }}">Supervisors</a></li>
                        <!--<li><a href="#">Schedules</a></li>-->
                    {% endif %}
                    <!-- PROJECT COORDINATOR NAVBAR LINKS -->

                    <!-- SUPERVISOR NAVBAR LINKS -->
                    {% if auth.isSupervisor() %}
                        <li><a href="{{ urlFor('supervisor.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ urlFor('supervisor.interests') }}">Profile</a></li>
                        <li><a href="{{ urlFor('supervisor.student_projects') }}">Projects</a></li>
                        <li><a href="{{ urlFor('supervisor.scheduled_meetings') }}">Schedules</a></li>
                        <!--<li><a href="#">Students</a></li>-->
                        <li><a href="{{ urlFor('supervisor.student_tasks') }}">Student Tasks</a></li>
                    {% endif %}
                    <!-- SUPERVISOR NAVBAR LINKS -->

                    <!-- STUDENT NAVBAR LINKS -->
                    {% if auth.isStudent() %}
                        <li><a href="{{ urlFor('student.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ urlFor('student.view_projects') }}">Projects</a></li>
                        <li><a href="{{ urlFor('student.view_supervisors') }}">Supervisors</a></li>
                        <li><a href="{{ urlFor('student.add_project') }}">My Project</a></li>
                        <li><a href="{{ urlFor('student.add_scheduled_meeting') }}">Schedules</a></li>
                        <li><a href="{{ urlFor('student.add_task') }}">Tasks</a></li>
                    {% endif %}
                    <!-- STUDENT NAVBAR LINKS -->


                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown" id="navDrop"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {% if auth %}Welcome {{ auth.getFullNameOrUsername() }}{% endif %}
                        <span class="glyphicon glyphicon-user"></span><span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ urlFor('user.profile', {username: auth.username}) }}"><span class="glyphicon glyphicon-user"> Profile</span></a></li>
                            <li><a href="{{ urlFor('user.all') }}"><span class="glyphicon glyphicon-cog"> Users</span></a></li>
                            <li><a href="{{ urlFor('password.change') }}"><span class="glyphicon glyphicon-lock"> Change Password</span></a></li>

                            <li role="separator" class="divider"></li>
                            <li><a href="{{ urlFor('logout') }}"><span class="glyphicon glyphicon-log-out"> Logout</span></a></li>
                        </ul>
                    </li>
                </ul>
                    {% else %}
                    <ul class="nav navbar-nav">
                        <li class=""><a href="{{ urlFor('home') }}">Home</a></li>
                        <li><a href="{{ urlFor('login') }}">Login</a></li>
                        <li><a href="{{ urlFor('login') }}">Forgot Password</a></li>
                    </ul>
                    {% endif %}     
            </div>
        </div>
    </nav>

