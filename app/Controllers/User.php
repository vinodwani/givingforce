<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostsModel;


class User extends ResourceController
{
    use ResponseTrait;

    // Get the User details
    public function index() 
    {
      $model = new UserModel();
      $data = $model->orderBy('id', 'DESC')->findAll();
      return $this->respond($data);
    }

    public function getUser($id = null, $arg2)
    {
        $model = new UserModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No user found');
        }
    }
}