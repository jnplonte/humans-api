<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class HumansUser extends Model
{
    protected $table = 'user';

    protected $fillable = ['first_name', 'last_name'];

    protected $page = 10;

    protected $type = 'id';

    protected $sort = 'asc';

    protected $search = '';

    public function __construct(){

    }

    public function getUsers($sort = null, $page = null, $search = null){
      if(!empty($sort)){ $this->sort = $sort; }
      if(!empty($page)){ $this->$page = $page; }
      if(!empty($search)){ $this->search = $search; }
      $users = DB::table($this->table)
          ->select('first_name', 'last_name')
          ->where('first_name', 'like', '%'.$search.'%')
          ->orWhere('last_name', 'like', '%'.$search.'%')
          ->orderBy($this->type, $this->sort)
          ->paginate($this->page);
      return $users;
    }

    public function getUser($id = null){
      if(!empty($id)){
        $users = DB::table($this->table)
            ->select('first_name', 'last_name')
            ->where('id', $id)
            ->first();
        return array('success' => true, 'data' => $users);
      }else{
        return array('success' => false, 'data' => null);
      }
    }

    public function updateUser($id = null, $arr = array()){
      if(!empty($id) && !empty($arr)){
        $arr['updated_at'] =  date('Y-m-d G:i:s');
        $users = DB::table($this->table)
            ->where('id', $id)
            ->update($arr);
        if(!empty($users)){
          return array('success' => true, 'id' => $users);
        }else{
          return array('success' => false, 'id' => null);
        }
      }else{
        return array('success' => false, 'id' => null);
      }
    }

    public function deleteUser($id = null){
      if(!empty($id)){
        $users = DB::table($this->table)
        ->where('id', $id)
        ->delete();
        if(!empty($users)){
          return array('success' => true, 'id' => $users);
        }else{
          return array('success' => false, 'id' => null);
        }
      }else{
        return array('success' => false, 'id' => null);
      }
    }

    public function insertUser($arr = array()){
      if(!empty($arr)){
        $arr['updated_at'] =  date('Y-m-d G:i:s');
        $arr['created_at'] =  date('Y-m-d G:i:s');
        $users = DB::table($this->table)
        ->insert($arr);
        if(!empty($users)){
          return array('success' => true, 'id' => $users);
        }else{
          return array('success' => false, 'id' => null);
        }
      }else{
        return array('success' => false, 'id' => null);
      }
    }
}
