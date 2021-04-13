<?php 
namespace App\Models;
use CodeIgniter\Model;

class CharityModel extends Model
{
    protected $table = 'charities';
    protected $primaryKey = 'charity_id';

//    protected $returnType = 'App\Entities\User'; // configure entity to use

    /**
     * To get the charities
     * @return : array()
     */
    public function getCharities()
    {
        $db = db_connect();
        $builder = $db->table('charities');
        $builder->select('charity_id, charity_name');
        return $builder->get()->getResultArray();
    }
}