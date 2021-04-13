<?php namespace App\Controllers;
use App\Models\ApplicationModel;
use App\Models\UserModel;
use App\Models\ApplicationStageModel;
use App\Entities\User;
use App\Entities\Userroles;
use App\Entities\ApplicationStage;
use App\Models\CharityModel;

class Application extends BaseController
{
    public function __construct()
    {
        helper("form");                
    }
    public function index() 
    {
        $data = array();
        return view('application/create_application', $data);
    }

    /**
     * To create the application page
     * @param int : $uid
     *
     */
    public function create($uid = null) 
    {      
        $data = array('success' => false, 'message' => '');
        $data['userId'] = $uid;
        // Validate User is allowed to create the application 
        list($success, $error) = $this->validateApplication($uid);

        if ((bool)$success === false) {
          $data['message'] = $error;
        } else {
          $charityOptions = $this->createCharityOptions();
          $data['charity'] = $charityOptions;
        }
       
        return view('application/create_application', $data);
    }

    /**
     * To get the charity options
     * @return : array()
     */
    private function createCharityOptions()
    {
      $charityOptions = array();
      $charityModel = new CharityModel();
      $charities = $charityModel->getCharities();
      $charityOptions = array('' => 'Select');
      foreach ($charities as $charity) {
          $charityOptions[$charity['charity_id']] = $charity['charity_name'];
      }
      return $charityOptions;
    }
    /**
     * This function is used to check User is allowed to create the application 
     * @param int : $userId
     * @return: array
     */
    private function validateApplication($userId) 
    {
      $success = true;
      $message = '';
      $db = db_connect();
      $builder = $db->table('users');
      $builder->join('user_roles', 'user_roles.user_id = users.user_id');
      $criteria = array('users.user_id' => $userId, 'role' => Userroles::ROLE_EMPLOYEE);
      $builder->where($criteria);
      $result = $builder->get();
      
      // getCompiledSelect
      if (empty($result->getResultArray())) {
        $success = 0;
        $message = "You're not authorized to create the Application";
      }
      return array($success, $message);
    }

    /**
     * To save the application information
     */
    public function save() 
    {
        $result = array('success' => false, 'message' => '');
        $input = $this->validate(array(
          'appName' => 'required|min_length[3]',
          'charity' => 'required',
          'app_date' => 'required'
        ));   
        $inputDate = strtotime(date('Y-m-d', strtotime($this->request->getVar('app_date')) ) ).' ';
        $currentDate = strtotime(date('Y-m-d'));
        
        // Application date should be in the past
        if ($inputDate > $currentDate) {
          $this->validator->setError('app_date', 'Date should be in the past');
        }
        
        if (!$input) {
          $data = array('validation' => $this->validator, 'error' => '', 'userId' => $this->request->getVar('userId'));
          $data['appName'] = $this->request->getVar('appName');
          $data['appDate'] = $this->request->getVar('app_date');
          $data['comment'] = $this->request->getVar('comment');
          $data['charitySelected'] = $this->request->getVar('charity');
          $charityOptions = $this->createCharityOptions();
          $data['charity'] = $charityOptions;
          return view('application/create_application', $data);          
        } else {
          $db = db_connect();
          $userModel = new UserModel();
          $charityModel = new CharityModel();
          $AppStageModel = new ApplicationStageModel();

          // Verify the input userId in DB before inserting the data to application table
          $user = $userModel->find($this->request->getVar('userId'));
          // Verify the input charity in DB before inserting the data to application table
          $charity = $charityModel->find($this->request->getVar('charity'));

          // If the charity is approved then select the stage 'Organisation Approval' else 'Allow to Proceed'
          $stage = ((bool)$charity['is_approved'] == true)? ApplicationStage::ORG_APPROVAL : ApplicationStage::ALLOW_PROCEED;
          
          // Get the application stage ID from given name
          $appStage = $AppStageModel->where('name', $stage)->first();
          
          $builder = $db->table('application');
          $data = array(
            'application_name' => $this->request->getVar('appName'),
            'created_date'  => date('Y-m-d G:i:s', strtotime($this->request->getVar('app_date'))),
            'description'  => $this->request->getVar('comment'),
            'charity_id'  => (!empty($charity))? $charity['charity_id'] : null,
            'user_id' => (!empty($user))? $user['user_id'] : null,
            'stage_id' => (!empty($appStage))? $appStage['stage_id'] : null
          );   
          $builder->insert($data);
          $result['success'] = true;
          $result['message'] = 'Application is successfully created';
          return view('application/create_application', $result);
        }
    }
}