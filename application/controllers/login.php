<?
// session_start();
error_reporting(0);
class Login extends CI_Controller {

function __construct() {
  parent::__construct();
  $this->load->library('session');
  $this->load->helper('url');
  $this->load->model('login_model','login',TRUE);
}

function login_form() {
  $this->load->view('/login_view');
}

function index() {
/* if the form is submitted – check whether the user is already logged in or not */
if($this->login->check_session()){
redirect('/page');
}
$userName = $this->input->post('username');
$password = $this->input->post('password');
$company = $this->input->post('company');
echo "## $userName $password";

$chkAuth = $this->login->checkAuth($userName,$password,$company);
if($chkAuth){
$acclog = $this->login->acclog($userName);
redirect('/page'); //load cpanel file – authentication successful
}else{
redirect('login/login_form'); //failed auth – return to the login form
}
echo "BISA";
}
public function logout(){

$this->session->unset_userdata('id');
$this->session->unset_userdata('logged_in');
session_destroy();
$log=array('user_id'=>$this->session->userdata('uid'),
'action_type'=>'LOGOUT',
'item_type'=>'USER',
'time'=>time());
redirect('/page');
}

}

