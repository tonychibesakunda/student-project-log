{% extends 'templates/default.php' %}

{% block title %}404{% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="error-template text-center">
                <h1>Oops!</h1>
                <h2>404 Not Found</h2>
                <div class="error-details">
                	
                    Sorry, an error has occured, Requested page not found!
                </div>
            </div>
        </div>
    </div>
</div>

{% endblock %}
