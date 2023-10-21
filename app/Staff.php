<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    protected $table = 'staff';
	protected $fillable = [
        'id',
        'password',
       

    ];
    public static function permission($user_type,$page_id,$id) {
	    if ($user_type == 'A') {
	        return true;
	    } else {
	        $role = DB::table('staff')->where('user_id',$id)->first();
	        if (!empty($role->permission)) {
	            $permission = json_decode($role->permission);
	            if (in_array($page_id, $permission)) {
	                return true;
	            } else {
	                return false;
	            }
	        } else {
	            return false;
	        }
	    }
	}
	public function permissions()
{
    return $this->belongsToMany(Permission::class, 'id','name');
}

}
