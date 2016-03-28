<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\HumansUser;

class HumansController extends Controller
{
    private $request;

    public function __construct(Request $request){
      $this->request = $request;
    }

    public function getAll()
    {
      $userData = new HumansUser();
      $getData = $this->request->all();

      $sort = !empty($getData['s']) ? $getData['s'] : null;
      $page = !empty($getData['p']) ? $getData['p'] : null;
      $search = !empty($getData['q']) ? $getData['q'] : null;

      return response()->json($userData->getUsers($sort, $page, $search));
    }

    public function get($id=null)
    {
      $userData = new HumansUser();
      return response()->json($userData->getUser($id));
    }

    public function insert()
    {
        $postData = $this->request->all();
        $userData = new HumansUser();
        return response()->json($userData->insertUser($postData));
    }

    public function update($id=null)
    {
      if ($this->request->isMethod('put')) {
          $putData = $this->request->all();
          $userData = new HumansUser();
          return response()->json($userData->updateUser($id, $putData));
      }

      if ($this->request->isMethod('delete')) {
          $userData = new HumansUser();
          return response()->json($userData->deleteUser($id));
      }

      return abort(404);
    }
}
