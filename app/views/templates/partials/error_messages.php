{% if flash.error %}
	<div class="error alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<strong>{{flash.error}}</strong>
	</div>
{% endif %}