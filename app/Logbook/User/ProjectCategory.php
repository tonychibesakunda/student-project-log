<?php
/** Project Category MODEL **/
//namespace the project category model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for project category model
class ProjectCategory extends Eloquent{

	protected $table = 'project_categories';

	protected $fillable = [
		'project_category'
	];

	public function projects(){
		return $this->hasMany('Logbook\User\Project', 'project_cat_id');
	}
}