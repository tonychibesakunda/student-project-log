<?php
/** PROJECT MODEL **/
//namespace the project model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for project model
class Project extends Eloquent{

	protected $table = 'projects';

	protected $fillable = [
		'project_name',
		'project_cat_id',
		'project_type_id'
	];

	public function students(){
		return $this->hasMany('Logbook\User\Student', 'project_id');
	}
}