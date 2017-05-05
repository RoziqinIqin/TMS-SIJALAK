<?php
class Login_model extends CI_Model
{
  function __construct() {
      parent::__construct();
    }

  function checkAuth($uName,$pass,$company) {
    $enc_pass= ":-)" . md5($pass);
    $query = $this->db->query("select t0.fld_username,t0.fld_userid,t0.fld_usergrpid,t0.fld_usergrpadd,t0.fld_baid, t2.fld_empnm,
    t2.fld_empdiv, t0.fld_userloc,t3.fld_tyvalnm 'location_nm',t0.fld_baido
    from tbl_user t0
    left join tbl_usergrp t1 on t1.fld_usergrpid=t0.fld_usergrpid
    left join tbl_emp t2 on t2.fld_empid=t0.fld_baid
    left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_userloc and t3.fld_tyid=21
    where t0.fld_username='$uName' and t0.fld_userpass='$enc_pass'");
    //echo $this->db->last_query();
    if($query->num_rows()>0 && $company > 0){
      $data = $query->row_array();
      $session_simrs = array( 
      'userid'=>$data['fld_userid'],
      'group'=>$data['fld_usergrpid'],
      'group_add'=>$data['fld_usergrpadd'], 
      'usernm'=>$data['fld_username'],
      'ctid'=>$data['fld_baid'],
      'ctnm'=>$data['fld_empnm'],
      'divid'=>$data['fld_empdiv'],
      'location'=>$data['fld_userloc'],
      'location_nm'=>$data['location_nm'],
      'logged_in'=>TRUE,
      'company'=>$data['fld_baido']
      );
      $this->session->set_userdata($session_simrs);
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  function acclog($uName) {
    $comment = "User $uName start to login";
    $host = $_SERVER['REMOTE_ADDR'];
    $query = $this->db->query("insert into tbl_acclog (fld_acclogtyid,fld_acclogcmt,fld_acclogdt,fld_accloghost) values(1,'$comment',now(),'$host')");
  }

  public function check_session() {
    if ($this->session->userdata('uid') AND $this->session->userdata('logged_in')=='TRUE') {
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  public function logout(){
    $this->session->unset_userdata('id');
    $this->session->unset_userdata('logged_in');
    session_destroy();
    $log=array('user_id'=>$this->session->userdata('uid'),
    'action_type'=>'LOGOUT',
    'item_type'=>'USER',
    'time'=>time());
    $this->log_message($log);
  }

  public function log_message($logArray){
    if(isset($logArray)){
      $this->db->insert('your_log',$logArray);
    }
  }
}
