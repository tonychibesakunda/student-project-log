{% if flash.warning %}
	<div class="warning alert alert-warning">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<strong>{{flash.warning}}</strong>
	</div>
{% endif %}