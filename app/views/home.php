{% extends 'templates/home_default.php' %}

{% block title %}Home{% endblock %}

{% block content %}
	
	<br>

	    <!-- Page Content -->
    <div class="container-fluid">

        <div class="row content">

            <!-- Blog Entries Column -->
            <div class="col-sm-8">

                <h1 class="page-header">
                    Projects
                    <small>Department of Computer Studies</small>
                </h1>

                <!-- First Blog Post -->
                {% if student_projects is empty %}
                	<h4 class="text-center" style="color: grey;"><b>No matching records found</b></h4>
                {% else %}
                {% for sp in student_projects%}
                <h2>
                    <a href="{{ urlFor('project_details',{id: sp.supervision_id}) }}">{{ sp.project_name }}</a>
                </h2>
                <p class="lead">
                    by <a href="#">{{ sp.first_name }} {{ sp.other_names }} {{ sp.last_name }}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Completed on {{ sp.project_end_date|date("d M, Y") }}</p>
                <hr>
                <img class="img-responsive" src="../uploads/home_page_image/student-projetcs.jpg" alt="student-project-image">
                <hr>
                <p>{{ sp.project_description }}</p>
                <a class="btn btn-primary" href="{{ urlFor('project_details',{id: sp.supervision_id}) }}">More Details <span class="glyphicon glyphicon-chevron-right"></span></a>
                {% endfor %}
                {% endif %}
                <hr>

                

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <form action="{{ urlFor('home.post') }}" method="POST" autocomplete="off">
            	<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-sm-4">
            	{% include 'templates/partials/error_messages.php' %}
				{% include 'templates/partials/warning_messages.php' %}
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Search Projects</h4>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_project_name" {% if request.post('search_project_name') %} value="{{request.post('search_project_name')}}" {% endif %} placeholder="Enter project name, student name or year">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="search">
                                <span class="glyphicon glyphicon-search"></span>
                        	</button>
                        </span>
                        
                    </div>
                    {% if errors.has('search_project_name')%}<small class="form-text text-muted" style="color: red;">{{errors.first('search_project_name')}}</small>{% endif %}
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Project Categories</h4>
                    
                        <div class="input-group">
	                        <select class="form-control" id="project_category" name="search_project_category">
	                            {% if project_categories is empty %}
	                                <option>No project category records</option>
	                            {% else %}
	                                <option>-- select project category --</option>
	                                {% for pc in project_categories %}
	                                    <option value="{{ pc.project_cat_id }}">{{ pc.project_category }}</option>
	                                {% endfor %}
	                            {% endif %}
	                        </select>
	                        <span class="input-group-btn">
	                            <button class="btn btn-default" type="submit" name="search_category">
	                                <span class="glyphicon glyphicon-search"></span>
	                        	</button>
	                        </span>
	                        
	                    </div>
	                    {% if errors.has('search_project_category')%}<small class="form-text text-muted" style="color: red;">{{errors.first('search_project_category')}}</small>{% endif %}

            </form>
                       
                </div>

                <!-- Side Widget Well -->
                <!--<div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>-->

            </div>

        </div>
        <!-- /.row -->

        <hr>

    </div>
    <!-- /.container -->
{% endblock %}
