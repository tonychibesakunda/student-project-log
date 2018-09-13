<?php
/** PROJECT TYPE MODEL **/
//namespace the project type model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for project type model
class ProjectType extends Eloquent{

	protected $table = 'project_types';

	protected $fillable = [
		'project_type'
	];

	public function projects(){
		return $this->hasMany('Logbook\User\Project', 'project_type_id');
	}
}