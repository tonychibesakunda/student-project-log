{% if flash.success %}
	<div class="success alert alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<strong>{{flash.success}}</strong>
	</div>
{% endif %}