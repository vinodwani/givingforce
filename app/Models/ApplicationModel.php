<?php 
namespace App\Models;
use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'application';
    protected $primaryKey = 'application_id';
    protected $allowedFields = ['user_id', 'stage_id', 'charity_id', 'application_name', 'created_date', 'description'];
}