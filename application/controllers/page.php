<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->library('PHPExcel');
    $this->load->model('login_model','login',TRUE);
    $this->load->model('form_model','form',TRUE);
    $this->load->model('view_model','view',TRUE);
    $this->load->model('query_model','query',TRUE);
    $this->load->model('dnxapps_model','dnxapps',TRUE);
    if(!$this->session->userdata('logged_in')) {
      redirect('/login/login_form');
    }
  }

  public function index() {
    $data_page['usernm'] = $this->session->userdata('usernm');
    $data_page['ctnm'] = $this->session->userdata('ctnm');
    $data_page['groupid'] = $this->session->userdata('group');
    $data_page['location'] = $this->session->userdata('location');
    $data_page['location_nm'] = $this->session->userdata('location_nm');
    $data_page['content'] = 'home_view';
  
    $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  
    $this->load->view('page_view',$data_page);
  }

  function form() {
    $fname =  $this->uri->segment(3);
    $mode =  $this->uri->segment(4);
    $node =  $this->uri->segment(5);
    $lform = $this->form->getform($fname);
    $data_form['mode'] =  $mode;
    $data_form['act'] = $this->input->get('act');
    $data_form['sf'] = $this->input->get('sf');
    $data_form['fld_formlbl'] =  $lform->fld_formlbl;
    $data_form['fld_formnm'] =  $lform->fld_formnm;
    $data_form['fld_formid'] =  $lform->fld_formid;
    $data_form['fld_formcreate'] =  $lform->fld_formcreate;
    $data_form['fld_formupdate'] =  $lform->fld_formupdate;
    $data_form['fld_formdelete'] =  $lform->fld_formdelete;
    $data_form['fld_formlist'] =  $lform->fld_formlist;
    $data_form['fld_formcopy'] =  $lform->fld_formcopy;
    $data_form['fld_tblid'] =  $lform->fld_tblid;
    $data_form['fld_formtyid'] =  $lform->fld_formtyid;
    $fld_formid = $lform->fld_formid;
    $fld_tblnm = $lform->fld_tblnm;
    $fld_tblpkey = $lform->fld_tblpkey;
    $data_form['formfield'] =  $this->form->getformfield($fld_formid);
    $data_form['subform'] =  $this->form->getsubform($fld_formid);
    $data_form['defsubform'] =  $this->form->getdefsubform($fld_formid);
    $data_form['formview'] =  $this->form->getformview($fld_formid);
    $data_form['defsubform'] =  $this->form->getdefsubform($fld_formid);
    $data_form['userid'] = $this->session->userdata('userid');
    $data_form['usernm'] = $this->session->userdata('usernm');
    $data_form['ctnm'] = $this->session->userdata('ctnm');
    $data_form['groupid'] = $this->session->userdata('group');
     $data_form['group_add'] = $this->session->userdata('group_add');
    $data_form['location'] = $this->session->userdata('location');
    $data_form['location_nm'] = $this->session->userdata('location_nm');
    if (count($data_form['subform']) > 0) {
      $data_form['issubform'] = 1;
      $lsubform = $data_form['subform'];
      $sfinfo = array();
    }

	if (count($data_form['formview']) > 0) {
      $data_form['isformview'] = 1;
      $lformview = $data_form['formview'];
      $sfinfo = array();
    }

    ###Check Value from Query String
    $ffgval = array();
    foreach ($data_form['formfield']  as $gvalue) {
      $gvaluenm = $gvalue->fld_formfieldnm;
      $ffgval [$gvaluenm] =  $this->input->get($gvaluenm);
    }
    $data_form['ffgval'] = $ffgval;
    $data_form['formfieldval'] =  $this->form->getformfieldval($fld_tblnm,$fld_tblpkey,$node);
    if ($lform->fld_formtmpl != '') {
      $data_form['content'] = "template/form/$lform->fld_formtmpl";
    }
    else {
      $data_form['content'] = 'form_view';
    }
    if ($mode == 'edit') {
      if (substr($fld_tblnm,0,7) == 'tbl_bth') {
	$data_form['futrans'] =  $this->form->getfollowup($node,$this->session->userdata('group'));
	$data_form['printout'] =  $this->form->getPrintLink($lform->fld_formid);
        $data_form['trans_map'] =  $this->form->getTransMap($node);
	$data_form['aprvdata'] =  $this->form->getApprovalRule($node);
	### Cek Approval Status
	$data_form['aprvstatus'] =  $this->form->getApprovalStatus($node);
        $data_form['aprv_act'] =  $this->form->getApprovalRole($node,$this->session->userdata('group'));
        $data_form['aprv_req'] =  $this->form->getApprovalInisiator($node,$this->session->userdata('group'));
      }
    }
    $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  
    $this->load->view('page_view', $data_form);
  }

  function view() {
    $vname =  $this->uri->segment(3);
    $lview = $this->view->getview($vname);
    foreach ($lview as $rview)
    ### Base Url in Query
    $url =  base_url();
    $vquery = str_replace("base_url/",$url,$rview->fld_querysql); 
    $orderval = $this->input->get('order');
    $sortingval = $this->input->get('sorting');
    $vformsearch = $rview->fld_formsearch;
    $lform = $this->form->getformbyID($vformsearch);
    $vorder = $rview->fld_vieworder;
    $data_view['footer'] = $rview->fld_viewfooter;
    $data_view['header'] = $rview->fld_viewheader;
    $data_view['usernm'] = $this->session->userdata('usernm');
    $data_view['ctnm'] = $this->session->userdata('ctnm');
    $data_view['location'] = $this->session->userdata('location');
    $data_view['location_nm'] = $this->session->userdata('location_nm');
		
    ### Form Search
    if ($vformsearch > 0) {
      $data_view['fld_formlbl'] =  $lform->fld_formlbl;
      $data_view['fld_formnm'] =  $lform->fld_formnm;
      $data_view['fld_formid'] =  $lform->fld_formid;
      $fld_formid = $lform->fld_formid;
      $fld_tblnm = $lform->fld_tblnm;
      $fld_tblpkey = $lform->fld_tblpkey;
      $data_view['formfield'] =  $this->form->getformfield($fld_formid);
    }
    $data_view['fld_viewnm'] =  $rview->fld_viewnm;
    $data_view['fld_formsearch'] =  $rview->fld_formsearch;
    if ($rview->fld_viewauth > 0) {
      $data_view['auth'] =  $this->view->getauth($rview->fld_viewauth);
    }
    $vtmpl = $rview->fld_viewtmpl;
    $data_view['fld_viewlbl'] = $rview->fld_viewlbl;
    if ($vquery != '') {
      $queryid = $rview->fld_queryid;
      $gbind = $this->view->getbind($queryid);
      $dbind = array();
      if (count($gbind) > 0) {
	foreach ($gbind as $rbind) {
	  $bindname = $rbind->fld_querybindnm;
	  $bindval =  $rbind->fld_querybindval;
	  if (preg_match('/^!/',$bindval)) {
	    $bindval = substr($bindval,1);
	    $bindval =  $this->session->userdata($bindval);
	  }
	  if ($this->input->get($bindname)) {
	    $bindval =  $this->input->get($bindname);
	  }
	  $dbind [] =  $bindval;
	}
      }  
      ### Pagination
      $data_view['numrows'] = $this->view->getviewnrow($vquery,$dbind,$dbind);
      $data_view['rowsperpage'] = $rview->fld_viewrpp;
      $data_view['totalpages']  = ceil($data_view['numrows'] / $data_view['rowsperpage']);
      $get_currentpage = $this->input->get('currentpage');
      $data_view['order']  = $this->input->get('order');
      $data_view['sorting'] = $this->input->get('sorting');
      if (isset($get_currentpage) && is_numeric($get_currentpage) ) {
	$data_view['currentpage']  = (int) $get_currentpage;
      }
      else {
	$data_view['currentpage'] = 1;
      }
      if ( $data_view['currentpage'] > $data_view['totalpages']) {
	$data_view['currentpage'] = $data_view['totalpages'];
      }
      if ( $data_view['currentpage'] < 1) {
	$data_view['currentpage'] = 1;
      }
      $data_view['offset'] = ( $data_view['currentpage'] - 1) * $data_view['rowsperpage'];
      $data_view['viewdata'] =  $lview;
      $data_view['viewcol'] =  $this->view->getviewcol($vquery,$dbind);
      $data_view['viewrs'] =  $this->view->getviewrs($vquery,$data_view['offset'],$data_view['rowsperpage'],$dbind,$orderval,$sortingval,$vorder);
    }
    if ($vtmpl != '') {
      $data_view['content'] = "template/view/$vtmpl";
    }
    else {
      $data_view['content'] = 'view_view';
    }
    $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  
    $this->load->view('page_view', $data_view);
  }

  function printout() {
    $vname =  $this->uri->segment(3);
    $lview = $this->view->getview($vname);
    foreach ($lview as $rview) 
    ### Base Url in Query
    $url =  base_url();
    $vquery = str_replace("base_url/",$url,$rview->fld_querysql); 
    $orderval = $this->input->get('order');
    $sortingval = $this->input->get('sorting');
    $print_all = $this->input->get('all');
    $print_page = $this->input->get('page');
    $vformsearch = $rview->fld_formsearch;
    $lform = $this->form->getformbyID($vformsearch);
    $vorder = $rview->fld_vieworder;
    $data_view['usernm'] = $this->session->userdata('usernm');
    $data_view['ctnm'] = $this->session->userdata('ctnm');
    ## Form Search
    $data_view['fld_viewnm'] =  $rview->fld_viewnm;
    $data_view['fld_formsearch'] =  $rview->fld_formsearch;
    $rtmpl = $rview->fld_viewreporttmpl;
    $data_view['fld_viewlbl'] = $rview->fld_viewlbl;
    if ($vquery != '') {
      $queryid = $rview->fld_queryid;
      $gbind = $this->view->getbind($queryid);
      $dbind = array();
      if (count($gbind) > 0) {
	foreach ($gbind as $rbind) {
	  $bindname = $rbind->fld_querybindnm;
	  $bindval =  $rbind->fld_querybindval;
	  if (preg_match('/^!/',$bindval)) {
	    $bindval = substr($bindval,1);
	    $bindval =  $this->session->userdata($bindval);
	  }
	  if ($this->input->get($bindname)) {
	    $bindval =  $this->input->get($bindname);
	  }
	  $dbind [] =  $bindval;
	}
      }
      ### Pagination
      $data_view['numrows'] = $this->view->getviewnrow($vquery,$dbind,$dbind);
      $data_view['rowsperpage'] = $rview->fld_viewrpp;
      $data_view['totalpages']  = ceil($data_view['numrows'] / $data_view['rowsperpage']);
      $get_currentpage = $this->input->get('currentpage');
      $data_view['order']  = $this->input->get('order');
      $data_view['sorting'] = $this->input->get('sorting');
      if (isset($get_currentpage) && is_numeric($get_currentpage) ) {
	$data_view['currentpage']  = (int) $get_currentpage;
      }
      else {
	$data_view['currentpage'] = 1;
      }
      if ( $data_view['currentpage'] > $data_view['totalpages']) {
		     $data_view['currentpage'] = $data_view['totalpages'];
      }
      if ( $data_view['currentpage'] < 1) {
	$data_view['currentpage'] = 1;
      }
		
		$data_view['offset'] = ( $data_view['currentpage'] - 1) * $data_view['rowsperpage'];
		$data_view['viewdata'] =  $lview;

		if ($print_all == 1) {
		$rpp = 100000000000;
		$data_view['offset'] = 0;
		}
		if ($print_page == 1) {
		$rpp = $rview->fld_viewrpp;
		}

		$data_view['viewcol'] =  $this->view->getviewcol($vquery,$dbind);
		$data_view['viewrs'] =  $this->view->getviewrs($vquery,$data_view['offset'],$rpp,$dbind,$orderval,$sortingval,$vorder);
		}

		if ($rtmpl != '') {
		  $this->load->view("template/report/$rtmpl", $data_view);
		}
		else {
		  $this->load->view('printout_view', $data_view);
		}

  }
	
  function form_process() {
    $fld_formid = $this->input->post('fid');
    $fld_formnm = $this->input->post('fnm');
    $lform2 = $this->form->getform($fld_formnm);
    $formfield = $this->form->getformfield($fld_formid);
    $fld_tblnm = $lform2->fld_tblnm;
    $fld_tblpkey = $lform2->fld_tblpkey;
    $pkeyval = $this->input->post($fld_tblpkey);
    $subform =  $this->form->getsubform($fld_formid);
    $mode = $this->input->post('act');
    $post_data = array();
    foreach ($formfield as $rpost) {
      $ffname = $rpost->fld_formfieldnm;
      $fftag = $rpost->fld_formfieldtag;
      $ffval = $this->input->post($ffname);
      if ($fftag == 'password') {
        if ($mode == 'add') {
          $ffval = ":-)" . MD5($ffval);
        } elseif ($mode == 'edit') {
          if (substr($ffval,0,3) == ":-)") {
            $ffval =  $ffval;
          } else {
            $ffval = ":-)" . MD5($ffval);
          }
        }
      }
      
      if ($fftag == 'datetime') {
        $ffval = date('Y-m-d H:i:s',strtotime($ffval));
      }
      if ($ffval == '[AUTO]' && $mode == 'add') {
        $ffval = $this->mkautono($this->input->post('fld_baido'),$this->input->post('fld_bttyid'));
      }
      if(preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $ffval)) {
        $ffvalq = explode("-",$ffval);
        $ffval = date('Y-m-d',mktime(0, 0, 0, $ffvalq[1], $ffvalq[0], $ffvalq[2]));
      }
      $post_data[$ffname] = $ffval;
    }
 
    if ($mode == 'add'){
      if($fld_formnm == '78000VEHICLE') {
        $this->dnxapps->setVehicleCode($post_data['fld_btflag'],$post_data['fld_bticd'],$post_data['fld_btip05']);
      }
    }

    if ($mode == 'add' || $mode == 'edit'){

 	  if($fld_formnm == '78000DELIVERY_ORDER_BOX') {
        $fld_baidc = $post_data['fld_baidc'];
        $fld_baidp = $post_data['fld_baidp'];
        $fld_btp38 = $post_data['fld_btp38'];
		//$msg='Pelangan ' . $fld_baidc . ' User ' . $fld_baidp . 'Voucher ' . $fld_btp38;
		//$this->dnxapps->message($msg); fld_btid=$pkeyval
		if($fld_btp38 != '') {
			$this->db->query("update tbl_btd_voucher set fld_btstat = '1', fld_btnoid='' where fld_btnoid=$pkeyval"); 
			$this->db->query("update tbl_btd_voucher set fld_btstat = '2', fld_btnoid=$pkeyval where fld_btid=$fld_btp38"); 
			}
//							where fld_btstat='1' and fld_btiid='$fld_baidp' and 
//							fld_baidp='$fld_baidc' and fld_btid='$fld_btp38' limit 1");
	  }

      if($fld_formnm == '78000CALCULATOR') {
        $post_data['fld_calcvar05'] = $post_data['fld_calcvar14'] / $post_data['fld_calcvar03'];
        $post_data['fld_calcvar06'] = $post_data['fld_calcvar05'] * $post_data['fld_calcvar04'];
        $post_data['fld_calcvar01'] = $post_data['fld_calcvar06'] + $post_data['fld_calcvar07'] + $post_data['fld_calcvar08'] + $post_data['fld_calcvar09'] 
                                      + $post_data['fld_calcvar10'] + $post_data['fld_calcvar11'] + $post_data['fld_calcvar12'];
        $post_data['fld_calcvar15'] = $post_data['fld_calcvar01'] + ($post_data['fld_calcvar20'] * $post_data['fld_calcvar02']);
        $post_data['fld_calcvar17'] = $post_data['fld_calcvar15'] * $post_data['fld_calcvar18'] / 100;
        $post_data['fld_calcvar16'] = $post_data['fld_calcvar17'] + $post_data['fld_calcvar15']; 
      }

      if($fld_formnm == '78000TRUCKING_BILLING' || $fld_formnm == '78000TRUCKING_BILLING2') {
        $fld_baidc = $post_data['fld_baidc'];
        if ($post_data['fld_btdtp01']!='00-00-0000')
        {
			$duedate=$post_data['fld_btdtp01'];
		} 
		elseif ($post_data['fld_btdtp']!='00-00-0000') {
			$duedate=$post_data['fld_btdtp'];	
		} else {
			$duedate=$post_data['fld_btdt'];
		}
        
        $top = $this->db->query("select fld_bep10 from tbl_be where fld_beid=$fld_baidc");
        $top = $top->row();
        $top = $top->fld_bep10;
        $top_date = date('Y-m-d',strtotime($duedate . "+$top days"));
        if ($top_date == '1970-01-01') {
          $top_date = "000-00-00";
        }
        $post_data['fld_btdtsa'] = $top_date;
      }
   
      if($fld_formnm == '78000DRIVERCASH_ADVANCES') {
        $data = $this->db->query("select * from tbl_tyval t0 where t0.fld_tyid=68");
		$data = $data->result();
        foreach($data as $rdata) {
          switch($rdata->fld_tyvalcd){
            case "1";
            $restribusi = $rdata->fld_tyvalcfg;
            break;
            case "2";
            $solar = $rdata->fld_tyvalcfg;
            break;
            case "3";
            $makan = $rdata->fld_tyvalcfg;
            break;
            case "4";
            $bongkar = $rdata->fld_tyvalcfg;
            break;
            case "5";
            $honor = $rdata->fld_tyvalcfg;
            break;
            case "6";
            $muka = $rdata->fld_tyvalcfg;
            break;

          }
		}
		$post_data['fld_btip03'] = $solar * $post_data['fld_btival'];
		$post_data['fld_btip04'] = $makan * $post_data['fld_btival'];
		$post_data['fld_btip05'] = $bongkar * $post_data['fld_btival'];
		$post_data['fld_btip06'] = $restribusi * $post_data['fld_btival'];
		$post_data['fld_btip07'] = $honor * $post_data['fld_btival'];
        $post_data['fld_btip08'] = $post_data['fld_btival'] * $muka;
      }
	
	}  
  
    if ($mode == 'edit') {
      if ($fld_formnm == '78000CHANGE_PASSWORD') {
        $this->changePassword($post_data['fld_userid'],$post_data['fld_userp01'],$post_data['fld_userp02']);
      }

      if ($fld_formnm == '78000POSTING_TRANSFER') {
        $this->dnxapps->TruckCashTransfer($pkeyval,$this->input->post(fld_btdtsa),$this->input->post(fld_btdtso));
      }

      if ($fld_formnm == '78000TRUCKING_SETTLEMENT') {
        $this->dnxapps->TruckCashSettlement($pkeyval,$this->input->post(fld_btdtsa),$this->input->post(fld_btdtso));
      }

      if ($fld_formnm == '78000POSTING_COMMISSION') {
        $this->dnxapps->PostingCommission($pkeyval,$this->session->userdata('location'));
      }

      if ($fld_formnm == '78000DELIVERY_ORDER_BOX' && $this->session->userdata('userid') != $this->input->post(fld_baidp)) {
        $this->dnxapps->message("You don't have permission to edit this transaction .....");
      }
	  if ($fld_formnm == '78000DELIVERY_ORDER_BOX' && $this->input->post(fld_btstat)=='4') {
        $this->dnxapps->message("You don't have permission to edit this transaction .....");
      }	
	  if ($fld_formnm == '78000VOUCHER' && $this->input->post(fld_btstat)=='2') {
		$this->dnxapps->message("This Voucher have been used.    You cannot edit tis transaction.");
      }
	  
      $update = $this->form->getformupdate($fld_tblnm,$fld_tblpkey,$post_data,$pkeyval);
      ### Update Record Log
      $data_log = array(
      'fld_acclogtyid' => '3' ,
      'fld_accloghost' => $_SERVER['REMOTE_ADDR'] ,
      'fld_acclogdt' => date('Y-m-d H:i:s'),
      'fld_acclogcmt' => 'User ' . $this->session->userdata('usernm') . ' Update record number ' . $pkeyval . ' on table ' . $fld_tblnm
      );
      $this->db->insert('tbl_acclog', $data_log);

      if (count($subform) > 0) {
        foreach ($subform as $rsubform) {
          if  ($rsubform->fld_subformty == 1) {
            $sffnm =  $rsubform->fld_formnm;
	    $sffid =  $rsubform->fld_formid;
	    $count = $rsubform->fld_formid . "Count";
            $countori = $rsubform->fld_formid . "Count-ori";
	    $sfform = $this->form->getform($sffnm);
	    $ffsf = $this->form->getformfield($sffid);
	    $sffld_tblnm = $sfform->fld_tblnm;
	    $sffld_tblpkey = $sfform->fld_tblpkey;
	    $sfpkeyval = $this->input->post($sffld_tblpkey);
	    $txtCount = $this->input->post($count);
	    $txtCountori = $this->input->post($countori);
            ### Delete Record
    	    $lval =  $this->form->getdatafupsub($rsubform->fld_formrelc,0,$pkeyval,$sffld_tblnm);
 	    $count = count($lval);
 	    for ($a=0; $a<$count; ++$a) {
 	    ### Check Data
  	      $daval =  $lval[$a][$sffld_tblpkey];
	      $del = 'yes';
	      for ($u=1;$u<=$count; $u++) {
 	        foreach ($ffsf as $sfrpost) {
                  $sfffnamefield = $sfrpost->fld_formfieldnm;
 	          $sfffname = $sffnm . $sfrpost->fld_formfieldnm . $u;
	          $sfffval = $this->input->post($sfffname);
                  if ($sfffnamefield == $sffld_tblpkey) {
	            if ($daval == $sfffval) {
 	              $del = 'no';
		    }
 	          }
                }
 	      }
### Block by Cenot 11/11/2016
### Due to autodelete form
              if ($del == 'yes') {
	        $delsf = $this->db->query("delete from $sffld_tblnm where $sffld_tblpkey='$daval' limit 1");
              }
            }
            ## Update Record	
            for ($i=1;$i<=$txtCountori; $i++) {
              $sfpost_data = array();
              $dataexist = 0;
              foreach ($ffsf as $sfrpost) {
	        $sfffnamefield = $sfrpost->fld_formfieldnm;
	        $sfffname = $sffnm . $sfrpost->fld_formfieldnm . $i;
	        $sfffval = $this->input->post($sfffname);
               
                if ($sfffnamefield == $rsubform->fld_formrelc) {
	          $sfffval = $this->input->post($rsubform->fld_formrelp);
	        }
	        if ($sfffnamefield != $rsubform->fld_formrelc && $sfffval != '') {
	          $dataexist = $dataexist + 1;
	        }
                if ($sfrpost->fld_formfieldtag == 'date') {
                  $sfffval = date('Y-m-d',strtotime($sfffval));
                }
	        $sfpost_data[$sfffnamefield] = $sfffval;
              }
              if ($dataexist != 0) {
                $sfreplace = $this->form->getformreplace($sffld_tblnm,$sfpost_data);
              }
	    }
          }
        }
      }
      
      if ($fld_formnm == '78000ADD_UJS') {
        $fld_btno = $post_data['fld_btnoreff'];
        $add = $this->db->query("select sum(fld_btamt) 'amt' from tbl_bth  where fld_btnoreff = '$fld_btno' and fld_bttyid=8");
        $add = $add->row();
        $add = $add->amt;
        $this->db->query("update tbl_bth set fld_btp30 = '$add' where fld_btno = '$fld_btno'");
        
      }
       
      if ($fld_formnm == '78000RETURN_DO') {
        $fld_btp09 = $post_data['fld_btp09'];
        $fld_baidc = $post_data['fld_baidc'];
        $fld_btp26 = $post_data['fld_btp26'];
        $langsir = $post_data['fld_bttaxno'];
        $tarif = $this->db->query("select fld_trfamt from tbl_trf where fld_btiid='$fld_btp09' and fld_beid='$fld_baidc' and fld_trfp01='$fld_btp26' limit 1");
        $tarif = $tarif->row();
        if ($tarif->fld_trfamt > 0 && $langsir != 1) {
          echo "Tariff ambil sari master Dinon aktifkan dulu sementara";
        //  $this->db->query("update tbl_bth 
        //                  set 
        //                  fld_btp24 = (select tz0.fld_trfamt from tbl_trf tz0 where tz0.fld_btiid=fld_btp09 and tz0.fld_beid=fld_baidc and tz0.fld_trfp01=fld_btp26 )
        //                  where fld_btid=$pkeyval");
        }
        if ($langsir == 1) {
          $this->db->query("update tbl_bth 
                          set 
                          fld_btp24 = (select sum(ifnull(tz0.fld_btp04,0) + ifnull(tz0.fld_btp06,0))  from tbl_btd_langsiran tz0 where tz0.fld_btidp=$pkeyval )
                          where fld_btid=$pkeyval");
        }
        $this->db->query("update tbl_bth 
                          set 
                          fld_btp25 = ifnull((select sum(ifnull(tx0.fld_btamt02,0)) from tbl_btd_truck_cost tx0 where tx0.fld_btidp=$pkeyval),0),
                          fld_btp22 = fld_btp28 - ifnull((select sum(ifnull(tx0.fld_btamt01,0)) from tbl_btd_truck_cost tx0 where tx0.fld_btidp=$pkeyval),0),
						  fld_btp29 = (select sum(ifnull(tx0.fld_btamt01,0) + ifnull(tx0.fld_btp03,0)) from tbl_btd_langsiran tx0 where tx0.fld_btidp=$pkeyval),
                          fld_btp23 = fld_btp22 + fld_btp16 +  fld_btamt + fld_btp30 - (fld_btamt + fld_btp30 - fld_btp29),
                          fld_btbalance = if(fld_bttaxno=1,(ifnull(fld_btp27,0) + ifnull(fld_btuamt,0) ) - fld_btp29,0)
                          where fld_btid=$pkeyval");
        
      }
      ### Set PPN value for Custom Billing Warehouse
      if ($fld_formnm == '78000WAREHOUSE_CUSTOM_BILLING') {
        $this->dnxapps->setCustomBillingValue($pkeyval,$post_data['fld_btamt'],$post_data['fld_btp07']);
      }
   
      if ($fld_formnm == '78000PLANNING_TRUCKING' && $post_data['fld_btp06'] != '') {
        $this->dnxapps->cekDateComplete($pkeyval);
      }

      if ($fld_formnm == '78000DELIVERY_ORDER_BOX'&& $post_data['fld_btp34'] !='' ) {
        $this->dnxapps->setCashAdvance($pkeyval,$post_data['fld_baidc'],$post_data['fld_btp09'],$post_data['fld_btflag'],$post_data['fld_baidv'],$post_data['fld_btloc'],$post_data['fld_btflag'],$post_data['fld_btp18']);
      }

      ### Auto Insert TAX Amount for Customer's Invoice Form
      if($fld_formnm == '78000INVOICE') {
        $this->dnxapps->setInvoiceTax($pkeyval,$post_data['fld_btflag'],$post_data['fld_btp02']);
      }

      if($fld_formnm == '78000VEHICLE') {
         $this->dnxapps->setVehicle($pkeyval);
      }  

      if($fld_formnm == '78000TRUCKING_BILLING' || $fld_formnm == '78000TRUCKING_BILLING2') {
        $this->dnxapps->setTotalAmount($pkeyval,$post_data['fld_bttyid']);
      }

      $url = base_url() . "index.php/page/form/$fld_formnm/edit/$pkeyval?act=edit";
      if ( $this->input->post('sf') == 1) {
        echo '<script>history.go(-2)</script>';
      } else {
        redirect($url);
      }

    }
    ## Copy Record
    elseif ($mode == 'copy') {
      $post_data = array();
      foreach ($formfield as $rpost) {
        if (($rpost->fld_formfieldnm != $fld_tblpkey) || ($rpost->fld_formfieldnm == 'fld_btstat')) {
          $ffname = $rpost->fld_formfieldnm;
          if ($rpost->fld_formfieldnm == 'fld_btno') {
            $post_data[$ffname] = $this->mkautono($this->input->post('fld_baido'),$this->input->post(fld_bttyid));
          } elseif ($rpost->fld_formfieldnm == 'fld_btstat') {
            $post_data[$ffname] = 1;
          } elseif ($rpost->fld_formfieldnm == 'fld_btdt') {
            $post_data[$ffname] = date('Y-m-d H:i:s');
          } else {
  	    $post_data[$ffname]= $this->input->post($ffname);
          }
        }
      }
      $insert = $this->form->getforminsert($fld_tblnm,$post_data);
      $lid = $this->db->insert_id();
      ### Copy Record Log
      $data_log = array(
      'fld_acclogtyid' => '4' ,
      'fld_accloghost' => $_SERVER['REMOTE_ADDR'] ,
      'fld_acclogdt' => date('Y-m-d H:i:s'),
      'fld_acclogcmt' => 'User ' . $this->session->userdata('usernm') . ' Copy record number from ' . $pkeyval . ' to ' . $lid . ' on table ' . $fld_tblnm
      );
      $this->db->insert('tbl_acclog', $data_log);
      if (count($subform) > 0) {
        foreach ($subform as $rsubform) {
          $sffnm =  $rsubform->fld_formnm;
          $sffid =  $rsubform->fld_formid;
          $sfform = $this->form->getform($sffnm);
          $ffsf = $this->form->getformfield($sffid);
          $sffld_tblnm = $sfform->fld_tblnm;
          $sffld_tblpkey = $sfform->fld_tblpkey;
          $count = $rsubform->fld_formid . "Count";
          $txtCount = $this->input->post($count);
          for ($i=1;$i<=$txtCount; $i++) {
            $sfpost_data = array();
            foreach ($ffsf as $sfrpost) {
	      $sfffnamefield = $sfrpost->fld_formfieldnm;
	      $sfffname = $sffnm . $sfrpost->fld_formfieldnm . $i;
	      $sfffval = $this->input->post($sfffname);
	      if ($sfrpost->fld_formfieldnm != $sffld_tblpkey) {
	        if ($sfffnamefield == $rsubform->fld_formrelc) {
		  $sfffval = $lid;
		}
		$sfpost_data[$sfffnamefield] = $sfffval;
	      }
	    }
	    $insert = $this->form->getforminsert($sffld_tblnm,$sfpost_data);
	  }
	}
      }
      $url = base_url() . "index.php/page/form/$fld_formnm/edit/$lid?act=copy";
      redirect($url);
      }	elseif ($mode == 'add') {
        ### Adding Record
        $insert = $this->form->getforminsert($fld_tblnm,$post_data);
	$last_insert_id = $this->db->insert_id();
	if ($fld_formnm == '78000POSTING_COMMISSION') {
	  $this->dnxapps->PostingCommission($last_insert_id,$this->session->userdata('location'));
	}
	if ($fld_formnm == '78000POSTING_TRANSFER') {
        $this->dnxapps->TruckCashTransfer($last_insert_id,$this->input->post(fld_btdtsa),$this->input->post(fld_btdtso));
        }
	if ($fld_formnm == '78000TRUCKING_SETTLEMENT') {
	  $this->dnxapps->TruckCashSettlement($last_insert_id,$this->input->post(fld_btdtsa),$this->input->post(fld_btdtso));
	}
	
        if($fld_formnm == '78000VEHICLE') {
         $this->dnxapps->setVehicle($last_insert_id);
        }

         ### Add Record Log
	$data_log = array(
	'fld_acclogtyid' => '2' ,
	'fld_accloghost' => $_SERVER['REMOTE_ADDR'] ,
	'fld_acclogdt' => date('Y-m-d H:i:s'),
	'fld_acclogcmt' => 'User ' . $this->session->userdata('usernm') . ' Add record number ' . $last_insert_id . ' on table ' . $fld_tblnm
	);
	$this->db->insert('tbl_acclog', $data_log); 
	if (count($subform) > 0) {
	  foreach ($subform as $rsubform) {
	    $sffnm =  $rsubform->fld_formnm;
	    $sffid =  $rsubform->fld_formid;
	    $count = $rsubform->fld_formid . "Count";
	    $sfform = $this->form->getform($sffnm);
	    $ffsf = $this->form->getformfield($sffid);
	    $sffld_tblnm = $sfform->fld_tblnm;
	    $sffld_tblpkey = $sfform->fld_tblpkey;
	    $sfpkeyval = $this->input->post($sffld_tblpkey);
	    $txtCount = $this->input->post($count);
	    for ($i=1;$i<=$txtCount; $i++) {
	      $check = 0;
	      #### Cek Grid yangg kosong
	      foreach ($ffsf as $lffsf) {
	        $ffval = $sffnm . $lffsf->fld_formfieldnm . $i;
		$val = $this->input->post($ffval);
 		if ($this->input->post($ffval)) {
	          $check = 1;
		}
	      }
	      if ($check == 1) {
	        $sfpost_data = array();
		foreach ($ffsf as $sfrpost) {
		  $sfffnamefield = $sfrpost->fld_formfieldnm;
		  $sfffname = $sffnm . $sfrpost->fld_formfieldnm . $i;
		  $sfffval = $this->input->post($sfffname);
                  if (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $sfffval)) {
		    $sfffvalq = explode("-",$sfffval);
		    $sfffval = date('Y-m-d',mktime(0, 0, 0, $sfffvalq[1], $sfffvalq[0], $ffvalq[2]));
		  }
		  ## Get Relation key Value form Parent Form
		  if ($sfffnamefield == $rsubform->fld_formrelc) {
		    $sfffval = $last_insert_id;
		  }
		  ##
		  $sfpost_data[$sfffnamefield] = $sfffval;
		}
		$sfinsert = $this->form->getforminsert($sffld_tblnm,$sfpost_data);
	      }
	    }
	  }
        }
        
        if ($fld_formnm == '78000TINJAUAN_ORDER') {
          $this->dnxapps->setTOMargin($last_insert_id); 
        }

        ### Auto Insert TAX Amount for Customer's Invoice Form
        if($fld_formnm == '78000INVOICE') {
          $this->dnxapps->setInvoiceTax($last_insert_id,$post_data['fld_btflag'],$post_data['fld_btp02']);
        }
        if($fld_formnm == '78000CUSTOMER_PAYMENT') {
          $this->dnxapps->setPaymentTax($last_insert_id);
        }
        if ($fld_formnm == '78000DELIVERY_ORDER_BOX') {
	  $this->dnxapps->setCashAdvance($last_insert_id,$post_data['fld_baidc'],$post_data['fld_btp09'],$post_data['fld_btflag'],$post_data['fld_baidv'],$post_data['fld_btloc'],$post_data['fld_btflag'],$post_data['fld_btp18']);
	}
        if($fld_formnm == '78000TRUCKING_BILLING' || $fld_formnm == '78000TRUCKING_BILLING2') {
          $this->dnxapps->setTotalAmount($last_insert_id,$this->input->post(fld_bttyid));
        }
        $url = base_url() . "index.php/page/form/$fld_formnm/edit/$last_insert_id?act=add";
        if ( $this->input->post('sf') == 1) {
          echo '<script>history.go(-2)</script>';
        } else {
          redirect($url);
        }
      }

      if ($mode == 'fup') {
      $btid = $this->input->post(btid);
      $tynextid = $this->input->post(tynextid);
      $tynextform = $this->input->post(tynextform);
      $nextformid = $this->input->post(nextformid);
      $formfield = $this->form->getformfieldbyName($tynextform);
      $nextsubform =  $this->form->getsubform($nextformid);
      ###Prepare Data
      $data =  $this->form->getdatafup($btid);
      foreach ($formfield as $rformfield) {
        if ($rformfield->fld_formfieldcopyval != "") {
          if (substr($rformfield->fld_formfieldcopyval,0,4) == "fld_") {
            $data[0][$rformfield->fld_formfieldnm] = $data[0][$rformfield->fld_formfieldcopyval];
          } else {
            $data[0][$rformfield->fld_formfieldnm] = $rformfield->fld_formfieldcopyval;
          }
        }
        if ($rformfield->fld_formfieldcopy == 1) {
          $data[0][$rformfield->fld_formfieldnm] = '';
        }
      } 
      $data[0]['fld_btid'] = '';
      $data[0]['fld_btstat'] = '1';
      $data[0]['fld_bttyid'] = $tynextid;
      $data[0]['fld_btno'] = $this->mkautono($data[0]['fld_baido'],$tynextid);
      $data[0]['fld_baidp'] =  $this->session->userdata('userid');
      $data[0]['fld_btloc'] =  $this->session->userdata('location');
      $data[0]['fld_btdt'] = date('Y-m-d H:i:s');
      ###Insert Data
      $sfinsert = $this->form->getforminsert('tbl_bth', $data[0]);
      $fup_lid = $this->db->insert_id();
      ###Preare Data Subform
      if (count($subform) > 0 && $tynextform != '78000WORK_ORDER_ADDITIONAL') {
        $sf_count = 0;
        foreach ($subform as $rsubform) {
          $sf_count = $sf_count + 1;
          $sffnm =  $rsubform->fld_formnm;
          $sffid =  $rsubform->fld_formid;
          $sfform = $this->form->getform($sffnm);
          $ffsf = $this->form->getformfield($sffid);
          $sffld_tblnm = $sfform->fld_tblnm;
          $sffld_tblpkey = $sfform->fld_tblpkey;
          $count = $rsubform->fld_formid . "Count";
          $txtCount = $this->input->post($count);
          ${"recordsf" . $sf_count} = array();
          if($rsubform->fld_subformfu == 1) {
            for ($i=1;$i<=$txtCount; $i++) {
              $sfpost_data = array();
              foreach ($ffsf as $sfrpost) {
                $sfffnamefield = $sfrpost->fld_formfieldnm;
                $sfffname = $sffnm . $sfrpost->fld_formfieldnm . $i;
                $sfffval = $this->input->post($sfffname);
                if ($sfrpost->fld_formfieldnm != $sffld_tblpkey) {
	          if ($sfffnamefield == $rsubform->fld_formrelc) {
	            $sfffval = $fup_lid;
	          }
	          $sfpost_data[$sfffnamefield] = $sfffval;
                }
                if ($sffnm == '78000BOOK_DETAIL' || 
	            $sffnm == '78000PURCHASE_ORDER_DETAIL' || 
                    $sffnm == '78000PURCHASE_RECEIVE_DETAIL' || 
                    $sffnm == '78000WO_PART') {
	            $sfpost_data['fld_btreffid'] = $this->input->post($sffnm . 'fld_btid' . $i);
                }  
              }
              if ($sffnm == '78000PURCHASE_REQUEST_DETAIL' || $sffnm == '78000PURCHASE_ORDER_DETAIL' || $sffnm == '78000PURCHASE_RECEIVE_DETAIL') {
                $cekqty = $this->dnxapps->cekPRQty($this->input->post($sffnm . 'fld_btid' . $i));
                if ($cekqty < $sfpost_data['fld_btqty01']) {
	          $sfpost_data['fld_btqty01'] = $sfpost_data['fld_btqty01'] - $cekqty;
	          ${"recordsf" . $sf_count}[] = $sfpost_data;
                }
              } else if( $sffnm == '78000WO_PART' ) {
	        $cekqty = $this->dnxapps->cekWOPartQty($this->input->post($sffnm . 'fld_btid' . $i));
	        if($cekqty < $sfpost_data['fld_btqty01']) {
	          $sfpost_data['fld_btqty01'] = $sfpost_data['fld_btqty01'] - $cekqty;
	          ${"recordsf" . $sf_count}[] = $sfpost_data;
                }
              } else {
                ${"recordsf" . $sf_count}[] = $sfpost_data;
              }
            }
          }
        } 
      }
      ###   
      ### Insert Data Subform
      if (count($nextsubform) > 0) {
      $nxsf_count = 0;
      foreach ($nextsubform as $rnextrsubform) {
        $nxsf_count = $nxsf_count + 1;
        $nxsfform = $this->form->getform($rnextrsubform->fld_formnm);
        $nxffsf = $this->form->getformfield($rnextrsubform->fld_formid);
        $nxsffld_tblnm = $nxsfform->fld_tblnm;
        $nxsffld_tblpkey = $nxsfform->fld_tblpkey;
        if (count(${"recordsf" . $nxsf_count}) > 0) {
          for ($ix=0;$ix<count(${"recordsf" . $nxsf_count}); $ix++) {
          $data = array();
          $data = ${"recordsf" . $nxsf_count}[$ix];
            foreach ($nxffsf as $rnxffsf) {
              if ($rnxffsf->fld_formfieldcopy == 1) {
                $data[$rnxffsf->fld_formfieldnm] = '';
	      }
	      if ($rnxffsf->fld_formfieldcopyval != "") {
	        if (substr($rnxffsf->fld_formfieldcopyval,0,4) == "fld_") {
	          $data[$rnxffsf->fld_formfieldnm] = $data[$rnxffsf->fld_formfieldcopyval];
	        } else {
	          $data[$rnxffsf->fld_formfieldnm] = $rnxffsf->fld_formfieldcopyval;
	        }
	      }
            }
            $insert = $this->form->getforminsert($nxsffld_tblnm, $data);
          }
        }
      }
    }
    ### 
    ### Follow Up Record Log
    $data_log = array(
          'fld_acclogtyid' => '5' ,
          'fld_accloghost' => $_SERVER['REMOTE_ADDR'] ,
          'fld_acclogdt' => date('Y-m-d H:i:s'),
          'fld_acclogcmt' => 'User ' . $this->session->userdata('usernm') . ' Follow Up record number from ' . $btid . ' to ' . $fup_lid . ' on table ' . $fld_tblnm
          );
    $this->db->insert('tbl_acclog', $data_log);

    ###Insert BTR
    $query = $this->db->query("insert into tbl_btr (fld_btrsrc,fld_btrdst,fld_btrdsttyid) values($btid,$fup_lid,$tynextid)");
    $fup_subform = $this->form->getsubform($formid);
    foreach ($fup_subform as $rfup_subform) {
      $datasf =  $this->form->getdatafupsub($rfup_subform->fld_formrelc,$rfup_subform->fld_formrelp,$btid,$rfup_subform->fld_tblnm);
      $count = count($datasf);
      for ($i=0; $i<$count; ++$i) {
        ###Prepare Data
        $datasf[$i]['fld_btid'] = '';
        $datasf[$i][$rfup_subform->fld_formrelc] = $fup_lid;
        $datasf[$i]['fld_bttyid'] = $tynextid;
        ###Insert Data
        $sfinsert = $this->form->getforminsert($rfup_subform->fld_tblnm, $datasf[$i]);
      }
    }
    
    if ($tynextform == '78000DELIVERY_ORDER_BOX') {
      $this->dnxapps->setCashAdvance($fup_lid,
									 $this->input->post(fld_baidc),
									 $this->input->post(fld_btp09),
									 $this->input->post(fld_btflag),
									 $this->input->post(fld_baidv),
									 $this->input->post(fld_btloc),
									 $this->input->post(fld_btflag),
									 $this->input->post(fld_btp18));
    }
    
    if ($tynextform == '78000RETURN_DO') {
        $this->db->query("update tbl_bth t0 
						set t0.fld_btp24=(select fld_trfamt from tbl_trf where fld_btiid=t0.fld_btp09 and fld_trfp01=t0.fld_btp26 and fld_beid=t0.fld_baidc)
                        where t0.fld_btid=$fup_lid");
        $this->db->query("insert into tbl_btd_langsiran (fld_btidp,fld_btdt) values ($fup_lid,now())");

      }	  
      
    if($tynextform =='78000INVOICE') {
      $data = $this->db->query("select t0.fld_btamt,fld_btno from tbl_bth t0 where t0.fld_btid = '$btid'");
      $data = $data->row();
      $query = $this->db->query("insert into tbl_btd_finance (fld_btidp,fld_btreffid,fld_btnoreff,fld_btuamt01,fld_btqty01,fld_btamt01,fld_btdesc) 
                                 values ($fup_lid,$btid,'$data->fld_btno','$data->fld_btamt','1','$data->fld_btamt','ONGKOS ANGKUT TRUCK')");
    }
    $fup_url = base_url() . "index.php/page/form/$tynextform/edit/$fup_lid";
    redirect($fup_url);
    }
  }

  function delete_process() {
    $fld_formnm =  $this->uri->segment(3);
    $node = $this->uri->segment(4);
    $lform = $this->form->getform($fld_formnm);
    $fld_tblnm = $lform->fld_tblnm;
    $fld_tblpkey = $lform->fld_tblpkey;
    $subform = $this->form->getsubform($lform->fld_formid);

    foreach ($subform as $rsubform) {
      $sffld_tblnm = $sfform->fld_tblnm;
      $sffld_tblpkey = $sfform->fld_tblpkey;
      $delsfrecord = $this->db->query("delete from $rsubform->fld_tblnm where $rsubform->fld_formrelc='$node'");
    }
    $gffval = $this->db->query("delete from $fld_tblnm where $fld_tblpkey='$node' limit 1");
    ### Add By Sudarman 2014-07-23 13:30
    if($fld_tblnm == 'tbl_bth'){
      $this->db->query("delete from tbl_btr where fld_btrsrc ='$node' or fld_btrdst = '$node'");
    }
    ### Delete Record Log
    $data_log = array(
    'fld_acclogtyid' => '6' ,
    'fld_accloghost' => $_SERVER['REMOTE_ADDR'] ,
    'fld_acclogdt' => date('Y-m-d H:i:s'),
    'fld_acclogcmt' => 'User ' . $this->session->userdata('usernm') . ' Delete record number' . $node . ' on table ' . $fld_tblnm
    );
    $this->db->insert('tbl_acclog', $data_log);
    ###
    $url = base_url() . "index.php/page/view/$fld_formnm/";
    redirect($url);
  }

  function searchbox() {
    $fvalid = $this->input->GET(fid);
    $lform = $this->form->getformbyID($fvalid);
    $data_form['fld_formlbl'] =  $lform->fld_formlbl;
    $data_form['fld_formnm'] =  $lform->fld_formnm;
    $data_form['fld_formid'] =  $lform->fld_formid;
    $fld_formid = $lform->fld_formid;
    $fld_tblnm = $lform->fld_tblnm;
    $fld_tblpkey = $lform->fld_tblpkey;
    $data_form['formfield'] =  $this->form->getformfield($fld_formid);
    $this->load->view('search_view', $data_form);
  }

  function mkautono ($baido,$bttyid) {
    $date_trans = date("ym");
    $year_trans = date("y");
    $bacd = $this->db->query("select fld_bacd from tbl_ba where fld_baid='$baido'");
    $lbacd = $bacd->row();
    $bttycd = $this->db->query("select fld_bttycd from tbl_btty where fld_bttyid='$bttyid'");
    $lbttycd = $bttycd->row();
    $query = $this->db->query("select t0.fld_btno  from tbl_bth t0  
    where t0.fld_bttyid='$bttyid' and t0.fld_baido = '$baido' and MID(t0.fld_btno , 9, 2 )=$year_trans order by t0.fld_btid desc limit 1");
    foreach ($query->result() as $row) {
    }
    $get_seq_number = (substr($row->fld_btno,13,5)+1);
    $seq_number = str_pad($get_seq_number, 5, "0", STR_PAD_LEFT);
    $vno = $lbacd->fld_bacd . "/" . $lbttycd->fld_bttycd . "/" . $date_trans . "/" . $seq_number;
    return $vno;
  }

  function setApproval ($btid) {
    $groupid = $this->session->userdata('group');
    $userid = $this->session->userdata('userid');
    $group_add = $this->session->userdata('group_add');
    $grule = $this->db->query("select t3.fld_aprvrulenm,t3.fld_aprvruleid,t0.fld_bttyid,t3.fld_usergrpid
		       from tbl_bth t0 
		       left join tbl_btty t1 on t1.fld_bttyid=t0.fld_bttyid
		       left join tbl_transaprv t2 on t2.fld_bttyid=t1.fld_bttyid
		       left join tbl_aprvrule t3 on t3.fld_aprvruleid=t2.fld_aprvruleid
		       where t0.fld_btid=$btid and t3.fld_usergrpid  in ($groupid,$group_add)  limit 1");
    $grule = $grule->row();
    $aprv_act = $this->uri->segment(4);
    $fld_aprvtktno = date('YmdHis');
    $transty = $this->db->query("select t0.fld_bttyid from tbl_bth t0
			 where t0.fld_btid=$btid");
    $transty = $transty->row();
    $bttyid = $grule->fld_bttyid; 

    ### Is All Addional Work Order Completed ?
    $gadd_wo = $this->db->query("select count(1) 'add_wo' from tbl_btr t0
			  left join tbl_bth t1 on t1.fld_btid=t0.fld_btrdst and t1.fld_bttyid=18
			  where t0.fld_btrsrc=$btid and t1.fld_btstat!=3");
    $gadd_wo =  $gadd_wo->row();
    if($gadd_wo->add_wo > 0) {
      echo '<script>alert("You have to complete all Additional WO !!! "); history.go(-1)</script>';
      exit();
    }
    ###
    if ($aprv_act == 'req') {
       ### Update Tinjauan Order Status
      if ($transty->fld_bttyid == 4) {
        $posting = $this->dnxapps->setTOStatus($btid,'sukses');
      }
     
      if ($transty->fld_bttyid == 2) {
        $posting = $this->dnxapps->setTOStatus($btid,'batal');
      }

      if ($transty->fld_bttyid == 5) {
        $posting = $this->dnxapps->setTOStatus($btid,'revisi');
      }



      ## DO Cancel
      if ($bttyid == 14) {
        $cekSettlement = $this->db->query("select * 
			   from tbl_trk_settlement t0 where t0.fld_btno = (select tx0.fld_btnoalt from tbl_bth tx0 where tx0.fld_btid='$btid') "); 
        if ($cekSettlement->num_rows() > 0) {
          echo "<div align='center'>
          Please remove all settlement cost before canceling this DO , click <a href='javascript:history.back();'>here</a> to go back </div>";
          exit();
        } else {
          $doid = $this->db->query("select tx1.fld_btid 
          from tbl_btr tx0 left join tbl_bth tx1 on tx1.fld_btid= tx0.fld_btrsrc where tx0.fld_btrdst = '$btid' and tx1.fld_bttyid=13 ");
          $doid = $doid->row();
          $this->db->query("update tbl_bth set fld_btstat = 5 where fld_btid = '$doid->fld_btid' limit 1 ");
        }
      }

        
      $grole = $this->db->query("select t0.fld_aprvroleid,t0.fld_usergrpid,t0.fld_aprvruleroleord
			 from tbl_aprvrulerole t0 
			 where t0.fld_aprvruleid=$grule->fld_aprvruleid and t0.fld_usergrpid != $grule->fld_usergrpid order by t0.fld_aprvruleroleord");
      $countRole =  count($grole->result());
      if ($countRole < 1 ) {
        $query = $this->db->query("update tbl_bth set fld_btstat=3 where fld_btid=$btid");
      } else {
        foreach ($grole->result() as $rgrole) {
          ### Create Approval Ticket
          $this->db->query("insert into tbl_aprvtkt (fld_aprvtktno,fld_usergrpid,fld_aprvroleid,fld_aprvruleroleord,fld_btid,fld_aprvtktstat,fld_aprvtktdt) 
          value ($fld_aprvtktno,$rgrole->fld_usergrpid,$rgrole->fld_aprvroleid,$rgrole->fld_aprvruleroleord,$btid,1,now()) ");
        }
        $query = $this->db->query("update tbl_bth set fld_btstat=2 where fld_btid=$btid");
      }
      
       if ($transty->fld_bttyid == 20) {
        $this->dnxapps->setDriverBalance($btid,'add');
      }
     
    }
    
    if ($aprv_act == 'aprv') {
      $query = $this->db->query("update tbl_bth set fld_btstat=3 where fld_btid=$btid");
      $query1 = $this->db->query("update tbl_aprvtkt set fld_aprvtktstat=2 ,fld_aprvtktmoddt = now(),fld_userid='$userid'
                                where fld_btid=$btid and fld_aprvroleid=3 and fld_usergrpid in (ifnull('$groupid',0),ifnull('$group_add',0))");
      if ($transty->fld_bttyid == 20) {
        $this->dnxapps->setDriverBalance($btid,'add');
      }
    }

    if ($aprv_act == 'very') {
      $query = $this->db->query("update tbl_bth set fld_btstat=6 where fld_btid=$btid");
      $query1 = $this->db->query("update tbl_aprvtkt set fld_aprvtktstat=2 , fld_userid='$userid' ,fld_aprvtktmoddt = now() where fld_btid=$btid and fld_aprvroleid=2 and fld_usergrpid in (ifnull('$groupid',0),ifnull('$group_add',0))");

    }


    if ($aprv_act == 'rev') {
      ### Revise Authority
      if ($transty->fld_bttyid == 47 || $transty->fld_bttyid == 48) {
        $str = "$groupid,$group_add";
        $pos = strpos($str, '40');
        if ($pos === false){
          $this->dnxapps->message("You don't have permission to revise this transaction .....");
        }  
      }
      ### Driver Balance
       if ($transty->fld_bttyid == 20) {
        $this->dnxapps->setDriverBalance($btid,'delete');
      }


      $query = $this->db->query("update tbl_bth set fld_btstat=2 where fld_btid=$btid");
    }

    echo '<script>history.go(-1)</script>';
  }

  function changePassword($userid,$password1,$password2) {
    $cek_user = $this->db->query("select * from tbl_user where fld_userid = '$userid'");
    $data = $cek_user->row();
    if ($password1 == $data->fld_userpass) {
      $this->db->query("update tbl_user set fld_userpass = '$password2' where fld_userid = '$userid' ");
    } else {
      $this->db->query("update tbl_user set fld_userpass = '$data->fld_userpass' where fld_userid = '$userid' ");
    }  
  }    

  function closeOrder() {
    $node =  $this->uri->segment(3);
    $fld_baidp  =$this->session->userdata('userid');
    $cek = $this->db->query("select * from tbl_trk_transfer where fld_btreffid = '$node'");
    if ($cek->num_rows() > 0)
    {
		$this->db->query("update tbl_bth set fld_btstat = 3 where fld_btid=$node and fld_baidp = $fld_baidp limit 1");
		redirect('page/form/78000DELIVERY_ORDER_BOX/edit/'.$node.'', 'refresh');
	} else {
		$this->dnxapps->message("So belum bisa di close, UJS belum terdaftar di transfer ...");
	}
  }

  function print_spmp() {
    $fld_btid =  $this->uri->segment(3);
    $print_quo = $this->dnxapps->printSPMP($fld_btid);
  }

  function print_pr() { 
    $fld_btid =  $this->uri->segment(3);
    $print_pr = $this->dnxapps->printPR($fld_btid);
  } 

  function print_inv() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV($fld_btid);
  }

  function print_inv2() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV2($fld_btid);
  }

  function print_inv2A() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV2A($fld_btid);
  }

  function print_inv3() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV3($fld_btid);
  }

  function print_inv4() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV4($fld_btid);
  } 

  function print_inv5() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV5($fld_btid);
  } 

  function print_inv5A() {
    $fld_btid =  $this->uri->segment(3);
    $print_inv = $this->dnxapps->printINV5A($fld_btid);
  } 
  
  function exportTransfer() {
    $fld_btid =  $this->uri->segment(3);
    //$cek = $this->db->query("select * from tbl_bth where fld_btid = '$fld_btid' and fld_btstat=3");
    // if ($cek->num_rows() > 0)
    // {
		$this->dnxapps->exportTransfer($fld_btid);
//	} else {
//		$this->dnxapps->message("Transfer Belum di Approve...");
//	}
    
  }

  function printDOTruck() {
		$fld_btid =  $this->uri->segment(3);
		$fld_btp34 = $this->input->post("fld_btp34");
		$fld_btnoxx = $this->input->post("fld_bano");		
		$printDOTruck = $this->dnxapps->printDOTruck($fld_btid, $fld_btp34, $fld_btno);
  }

  function printDOTruckSKO() {
    $fld_btid =  $this->uri->segment(3);
    $printDOTruckSKO = $this->dnxapps->printDOTruckSKO($fld_btid);
  }

  function inv_tambah() {
    $node =  $this->uri->segment(3);
    $data = $this->db->query("select * from tbl_bth t0 where t0.fld_btid = $node");
    $data = $data->row();
    $fld_btno = $ffval = $this->mkautono(1,26);
    $this->db->query("insert into tbl_bth (fld_baido,fld_baidp,fld_btidp,fld_btstat,fld_bttyid,fld_btdt,fld_btno,fld_baidc,fld_btp01,fld_btdtsa,fld_btflag) values
                      (1,$data->fld_baidp,$node,1,26,now(),'$fld_btno',$data->fld_baidc,$data->fld_btp01,'$data->fld_btdtsa',$data->fld_btflag)");
    $last_insert_id = $this->db->insert_id();
    $url = base_url() . "index.php/page/form/78000TRUCKING_BILLING/edit/$last_insert_id?act=edit";
    redirect($url);
  }

  function cancelOrder() {
    $node =  $this->uri->segment(3);
    $fld_baidp  =$this->session->userdata('userid');
    $this->db->query("update tbl_bth set fld_btstat = 5 where fld_bttyid=13 and fld_btid=$node and fld_baidp = $fld_baidp limit 1");
    echo '<script>history.go(-1)</script>';
  }
 
  function deleteSettlement() {
    $node =  $this->uri->segment(3);
    $node2 = $this->uri->segment(4);
    $this->db->query("delete from tbl_trk_settlement where fld_trk_settlementid = '$node' limit 1");
    echo '<script>history.go(-1)</script>';
  }

  function deleteTransfer() {
    $node =  $this->uri->segment(3);
    $node2 = $this->uri->segment(4);
    $node3 = $this->uri->segment(5);
    $data = $this->db->query("select * from tbl_trk_transfer where fld_trk_settlementid = '$node'");
    $data = $data->row();
    $this->db->query("update tbl_emp set fld_emploan = fld_emploan - ifnull($data->fld_deduction,0) where fld_empnm ='$data->driver'");
    $this->db->query("update tbl_bth set fld_btstat = 1 where fld_bttyid=13 and fld_btid=$node3");
    $this->db->query("delete from tbl_trk_transfer where fld_trk_settlementid = '$node' limit 1");
    echo '<script>history.go(-1)</script>';
}


  function truckingSetBilling(){
    $node =  $_POST["node"];
    $count = $_POST["count"];
    $langsir = $_POST["langsir"];
    $a = 0;
    $b = 0;
    $c = 0;
    for ($x=1; $x<=$count; $x++){
       if($_POST["rowdata$x"] == "on") {
        $fld_btid = $_POST["fld_btid$x"];
        $fld_vehicle = $_POST["vehicle_no$x"];
        $route = $_POST["route$x"];
        $fld_btno = $_POST["fld_btno$x"];
        $price = $_POST["price$x"];
        $dokumen = $_POST["dokumen$x"];
        $type = $_POST["type$x"];
        $vat = $_POST["vat$x"] * 1;
        $dp = $_POST["dp$x"] * 1;
        $tarif = $_POST["tarif$x"];
        $lokasi = $_POST["lokasi$x"];
        
        if($vat == 1) {
          $vat_amt = round($price * 0.1);
        } else {
           $vat_amt = 0;
        }
          $this->db->query("insert ignore into tbl_trk_billing
              (fld_btidp,fld_btreffid,fld_btno,fld_btamt01,fld_btamt02,fld_btamt03,fld_btamt04,fld_btamt05,fld_vehicle,fld_btp01,fld_btnoalt,fld_btflag)
              values
              ('$node' ,'$fld_btid','$fld_btno',$price + $vat_amt,'$vat_amt',$price + $vat_amt - $dp,'$price','$dp','$fld_vehicle','$route','$dokumen','$type')");
          $a = $a + $price;
          $b = $b + $vat_amt;
          $c = $c + $dp;
         
      }
    }
     $this->db->query("update tbl_bth set 
                       fld_btamt=$a,
                       fld_btuamt=$c,
                       fld_bttax = if(fld_btp01 = 1 , round(fld_btamt * 0.1),0),
                       fld_btbalance = fld_btamt + fld_bttax - fld_btuamt,
                       fld_btloc = '$lokasi'
		       where fld_btid=$node limit 1");
     if($langsir == 1) {
       $url = base_url() . "index.php/page/form/78000TRUCKING_BILLING2/edit/$node?act=edit";
     } else {
        $url = base_url() . "index.php/page/form/78000TRUCKING_BILLING/edit/$node?act=edit";
     }
     redirect($url);

  }

  function orderPlan(){
    $fld_btdt =  $_POST["fld_btdt"];
    $fld_btp11 =  $_POST["fld_btp11"];
    $fld_btp12 =  $_POST["fld_btp12"];
    $fld_btp09 =  $_POST["fld_btp09"];
    $fld_baidp =  $_POST["fld_baidp"];
    $fld_btloc=  $_POST["fld_btloc"];
    $fld_btno = $ffval = $this->mkautono(1,13);
   
    $this->db->query("insert into tbl_bth (fld_baido,fld_baidp,fld_btstat,fld_bttyid,fld_btdt,fld_btno,fld_btloc,fld_btp09,fld_btp11,fld_btp12) values
                      (1,$fld_baidp,1,13,'$fld_btdt','$fld_btno',$fld_btloc,'$fld_btp09',$fld_btp11,$fld_btp12)");
    echo '<script>history.go(-1)</script>';

  }
  
  function CloseTRF($btid)
  {
	  if ($this->session->userdata('group')=='7')
	  {
		 $this->db->query("update tbl_bth set fld_btstat = 4 where fld_bttyid=13 and fld_btid in (select fld_btreffid from tbl_trk_transfer where fld_btidp='$btid')"); 
		 $this->db->query("update tbl_bth set fld_btstat = 3 where fld_bttyid=3 and fld_btid='$btid'"); 
		  $url = base_url() . "index.php/page/form/78000POSTING_TRANSFER/edit/$btid?act=edit";
		  redirect($url);
	  } else {
		  $this->dnxapps->message("You don't have permission to approve this transaction .....");
	  }
  }


  
}



