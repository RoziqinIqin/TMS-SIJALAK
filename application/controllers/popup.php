<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Popup extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->model('login_model','login',TRUE);
    $this->load->model('form_model','form',TRUE);
    $this->load->model('view_model','view',TRUE);
    $this->load->model('query_model','query',TRUE);
  }

  function index() {

  }

  function selector() {
    $val =  $this->input->get('val');
    $qname = $this->input->get('qname');
    $bind_query = $this->db->query("select * from tbl_querybind t0  left join tbl_query t1 on t1.fld_queryid=t0.fld_queryid where t1.fld_querynm='$qname' order by t0.fld_querybindorder");
    $gbind = $bind_query->result();
    $dbind = array();
    #foreach ($gbind as $rbind) {
    #  $bindname = $rbind->fld_querybindnm;
    #  $bindval =  $rbind->fld_querybindval;
    #  if (preg_match('/^!/',$bindval)) {
    #    $bindval = substr($bindval,1);
    #	$bindval =  $this->session->userdata($bindval);
    #  }
    #  $dbind [] =  $bindval;
    #}
    foreach($this->input->get() as $key => $value) {  
      if (substr($key,0,7) == 'bindval' && $value != '999') {
        $dbind [] =  $value;
      }
    }
    $data['ffname'] = $this->input->get('ffname');
    $data['viewrs_all'] = $this->query->query_selector_all($qname,$val,$dbind);
    $data['numrows'] = count($data['viewrs_all']);
    $data['val'] = $val;
    $data['qname'] = $qname;
    $data['totalpages']  = ceil($data['numrows'] / 20);
    $data['dbind'] = $bind;
    $get_currentpage = $this->input->get('currentpage');
    if (isset($get_currentpage) && is_numeric($get_currentpage) ) {
      $data['currentpage']  = (int) $get_currentpage;
    } else {
      $data['currentpage'] = 1;
    }
    if ( $data['currentpage'] > $data['totalpages']) {
      $data['currentpage'] = $data['totalpages'];
    }
    if ( $data['currentpage'] < 1) {
      $data['currentpage'] = 1;
    }
    $data['offset'] = ( $data['currentpage'] - 1) * 20;
    $data['viewrs'] = $this->query->query_selector($qname,$val,$data['offset'],$dbind);
    if($qname == 'list_vehicle_calc') {
      $this->load->view('selector_vehicle', $data);
    } 
    else if($qname == 'list_vehicle_type1') {
      $this->load->view('selector_vehicle_type', $data);
    } 
    else if($qname == 'list_vehicle_type2') {
      $this->load->view('selector_vehicle_type2', $data);
    } 
    else if($qname == 'list_proyek_PRO') {
      $this->load->view('selector_proyek', $data);
    } 
    else if($qname == 'list_customer2') {
		$this->load->view('selector_customer2', $data);
	} 
    else if($qname == 'list_route_table_ujs') {
		$this->load->view('selector_list_route_table_ujs', $data);
	} 
    else if($qname == 'list_route_table_blong') {
		$this->load->view('selector_list_route_table_blong', $data);
	} 
    else if($qname == 'list_user_SO') {
		$this->load->view('selector_list_user_SO', $data);
	} 
    else if($qname == 'list_voucher_1') {
		$this->load->view('selector_list_voucher', $data);
	} 
    else {
      $this->load->view('selector', $data);
    }
  }
}

