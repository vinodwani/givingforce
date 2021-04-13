<?php namespace App\Controllers;
use App\Models\CharityModel;

class Charity extends BaseController
{
    public function __construct()
    {
        helper("form");                
    }
    
    /**
     * To display the charities
     * @param int : $uid
     *
     */
    public function display($uid = null) 
    {      
        $db = db_connect();
        $builder = $db->table('charities');
        $builder->join('countries', 'countries.country_id = charities.country_id');
        $result = $builder->get();
        $data['result'] = $result->getResult();
        return view('charity/display', $data);
    }

    /**
     * To update the charity status
     */
    public function update() 
    {
        $id = $this->request->getPost('charityId');
        $status = $this->request->getPost('status');
        $data = array('is_approved' => ((int)$status == 0)? 1 : 0);
        $db = db_connect();
        $builder = $db->table('charities');
        $builder->where('charity_id', $id);
        $builder->update($data);
        echo json_encode(array("status" => (int)$data['is_approved']));
    }
}