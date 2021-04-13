<?php 
namespace App\Models;
use CodeIgniter\Model;

class ApplicationStageModel extends Model
{
    protected $table = 'application_stage';
    protected $primaryKey = 'stage_id';
    protected $allowedFields = ['stage_id', 'name'];
}