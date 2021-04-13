<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserRolesModel extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\UserRoles'; // configure entity to use
}