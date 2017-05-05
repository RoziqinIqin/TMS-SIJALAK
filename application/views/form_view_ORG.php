<div id='message' style="padding-top:5px;padding-bottom:5px;background-color: red; height='300px'; border:1px solid #000; visibility: hidden;" ></div>
<?
if ($mode == 'edit') {
  foreach($formfieldval as $rffval):
  endforeach;
  if (isset($rffval->fld_btstat) && $rffval->fld_btstat == 3) {
    $ro = 1;
  }
}
?>
<html>
<form name="<? echo $fld_formnm; ?>" method='post' id="<? echo $fld_formnm;?>" action="<?=base_url();?>index.php/page/form_process">
<input type="hidden" name="fid" id="fid" value="<? echo $fld_formid; ?>" />
<input type="hidden" name="fnm" id="fnm" value="<? echo $fld_formnm; ?>" />
<input type="hidden" name="act" value="<? echo $mode; ?>" id="act"/>
<input type="hidden" name="sf" value="<? echo $sf; ?>" id="act"/>
<?
if ($mode == 'edit' && $fld_tblid == 16 && $aprvdata->fld_bttyrule == 1){
?>
<div align='center'>
<?
if ($ro !=1 && ($rffval->fld_btstat == 2 || $rffval->fld_btstat == 6) && $aprv_act == 3) {
?>
<a href="<?=base_url()?>index.php/page/setApproval/<?=$rffval->fld_btid?>/aprv"  onclick= "cekMandatory() ; return confirm('Are you sure want to set Approve this record ?')"><img src="<?=base_url()?>images/application_approval.gif" width="14" height="14" border=0 title="Approve">Approve</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
}
?>


<?
//print $rffval->fld_btstat;
if (($ro !=1 && $rffval->fld_btstat == 2 && $aprv_act == 2 )) {
?>
<a href="<?=base_url()?>index.php/page/setApproval/<?=$rffval->fld_btid?>/very"  onclick= "cekMandatory() ;return confirm('Are you sure want to set Verified this record ?')"><img src="<?=base_url()?>images/application_approval.gif" width="14" height="14" border=0 title="Verify">Verify</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
}
?>

<?
if ($ro !=1 && $rffval->fld_btstat == 1 && $aprv_req == 1)
{
?>
<a href="<?=base_url()?>index.php/page/setApproval/<?=$rffval->fld_btid?>/req"  onclick= "cekMandatory() ; return confirm('Are you sure want to Request Approval this record ?')"><img src="<?=base_url()?>images/application_approval.gif" width="14" height="14" border=0 title="Request Approval"> Request Approval</a>
<?
}
?>
<?
if ($rffval->fld_btstat == 3 && $aprv_act == 3 )
{
?>
<a href="<?=base_url()?>index.php/page/setApproval/<?=$rffval->fld_btid?>/rev"  onclick= "cekMandatory() ; return confirm('Are you sure want to Revise this record ?')"><img src="<?=base_url()?>images/application_approval.gif" width="14" height="14" border=0 title="Revise"> Revise</a>
<?
}
?>

</div>
<?
}
?>
<br>
<table border="0" cellspacing="0" cellpadding="0" width=100%>
    <tr>
    <td style="border-right: solid 1px black" width='85%'>
<table border="0" cellspacing="0" cellpadding="0" align='center'>
<?  
foreach($formfield as $rff):
$ro_Auth = $rff->fld_formfieldroauth;
if(preg_match('/\b' . $groupid . '\b/', $rff->fld_formfieldroauth)) { 
  $rff->fld_formfieldronly = 1;
}
?>
  <? if ($rff->fld_formfieldmdtr == 1)
     {
	$class = 'mandatory';
     }	else
     {
	  if ($rff->fld_formfieldtag == "text" || $rff->fld_formfieldtag == "date" ) {
	  $class = 'inputBox1';
	  }
	  else
	  {
	$class = 'default';
	  }
     }
     $ffname = $rff->fld_formfieldnm;
	      if ($mode == 'edit')
	      {
		$value = $rffval->$ffname;
	      } else
	      {
		$value =  $ffgval[$ffname];
	      }
	      if ($value == '') {

	      $value = $rff->fld_formfielddval;
		  if (preg_match('/^!/',$value)) {
		    $rvalue = substr($value,1);
		    $value = $this->session->userdata($rvalue);
		  }
		  if ($value == 'now!') {
		    $value = date ("d-m-Y H:i:s");
		  }
	      }

  ?>
  <?
    if ($rff->fld_formfieldhdr != '') {
  ?>
  <tr height='31' valign='bottom' cellspacing="2" cellpadding="2">
    <td colspan = "3" style="border-bottom-style:solid ; border-bottom-width:2px ;"><? echo $rff->fld_formfieldhdr; ?></td>
  <tr>
  <?
    }

    if ($rff->fld_formfieldshow != 1)
		      {
echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
		      }
	      else
	      {
  ?>
<? if ($rff->fld_formfieldrbreak == 1) {
?>
<?
}
if($rff->fld_formfieldlbl != "") {
?>
    <td style="border-bottom: solid 1px black" nowrap><? if ($rff->fld_formfieldmdtr == 1) {?><span style="color: rgb(255, 0, 0);">*</span><?}?><?=$rff->fld_formfieldlbl?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<?
}
?>
     <td nowrap>
	   <?
	      switch($rff->fld_formfieldtag)
	      {
		  case "text":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => $class,
		    );
		    if ($rff->fld_formfieldronly == 1) {
		      $input_tag['readonly'] = 1;
		    }
		   
		      if ($fld_formtyid != 1) {
		      $js = $rff->fld_formfieldjs . ' onkeyup=convertToUpper(this) ';
		    }
		    else {
		      $js = $rff->fld_formfieldjs;
		    }
		    if ($rff->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    
		    echo form_input($input_tag,'',$js);
		    break;
  
                    case "money":
                    $value_dsc = '';
                      $value_dsc = number_format($value,0,'.',',');
                    $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm . "_dsc",
                    'id'          => $rff->fld_formfieldnm . "_dsc",
                    'value'       => $value_dsc,
                    'maxlength'   => '100',
                    'size'        => $rff->fld_formfieldwidth,
                    'class'       => $class,
		    'style'       => 'text-align:right',
                    );
                    if ($rff->fld_formfieldronly == 1) {
                      $input_tag['readonly'] = 1;
                    }
                    if ($fld_formtyid != 1) {
                      $js = $rff->fld_formfieldjs . ' onkeyup=formatNumber(this) ';
                    }
                    else {
                      $js = $rff->fld_formfieldjs;
                    }

                    echo form_input($input_tag,'',$js);
                    echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
                    break;

		    case "password":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => $class,
		    );
		    if ($rff->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $js = $rff->fld_formfieldjs;
		    echo form_password($input_tag,'',$js);
		    break;

                    case "name":
                    $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm,
                    'id'          => $rff->fld_formfieldnm,
                    'value'       => $value,
                    'maxlength'   => '100',
                    'size'        => $rff->fld_formfieldwidth,
                    'class'       => $class,
                    );
                    if ($rff->fld_formfieldronly == 1) {
                    $input_tag['readonly'] = 1;
                    }
                    $js = $rff->fld_formfieldjs;
 		    echo '<select name="fld_betitle1" id="fld_betitle1">
		          <option value="PT">PT</option>
 		          <option value="CV">CV</option>
		          <option value="MR">MR</option>
                          <option value="MRS">MRS</option>
                          </select>';
                    echo form_input($input_tag,'',$js);
echo "<input type='text' id='fld_betitle2 name='fld_betitle2' size=10 value = '$value_title2'>";
                    break;


		    case "lookup":
		    $fld_querysql = $rff->fld_querysql . " having id = '$value'";
		    $gbind = $this->view->getbind($rff->fld_queryid);
		    $dbind = array();
		    if (count($gbind) > 0) {
		      $ctbind = 0;
		      foreach ($gbind as $rbind) {
			$bindname = $rbind->fld_querybindnm;
			$bindval =  $rbind->fld_querybindval;
			if (preg_match('/^!/',$bindval)) {
			  $bindval = substr($bindval,1);
			  $bindval =  $this->session->userdata($bindval);
			}
			if (substr($bindval,0,4) == 'fld_') {
			  #$bindval = '%';
                          if ($rffval->$bindval != "") {
			    $bindval = $rffval->$bindval;
			  }
			  else {
			    $bindval = '%';
			  }
			  $ctbind = $ctbind +1;
			  ${'bindfield' . $ctbind} = $bindname;
			}

			if ($this->input->get($bindname)) {
			  $bindval =  $this->input->get($bindname);
			}
		      $dbind [] =  $bindval;
		    
		      }

		    }

		    $value_dsc = '';
		    $query = $this->db->query($fld_querysql,$dbind);
		    $lquery = $query->row();
		    if (count($lquery) > 0) {
		      $value_dsc = $lquery->name;
		    }
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm . "_dsc",
		    'id'          => $rff->fld_formfieldnm . "_dsc",
		    'value'       => $value_dsc,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => $class,
		    );
		    if ($rff->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    echo form_input($input_tag,'',$js_lookup);
		    }
		    else {
		    $js_lookup = 'onChange="popup_selector(document.getElementById(\'' . $rff->fld_formfieldnm . '_dsc\').value,\'' . base_url() . '\',\'' . $rff->fld_querynm .  '\',\'' . $rff->fld_formfieldnm . '\',' . '\'' . $bindfield1 . '\',\'' . $bindfield2 . '\',\'' .$bindfield3 . '\',\'' . $bindfield4 . '\',\'' . $bindfield5 . '\')"';
		    echo form_input($input_tag,'',$js_lookup);
		    echo '<a href="javascript:void(1)" onclick= "popup_selector(document.getElementById(\'' . $rff->fld_formfieldnm . '_dsc\').value,\'' . base_url() . '\',\'' . $rff->fld_querynm .  '\',\'' . $rff->fld_formfieldnm . '\',' . '\'' . $bindfield1 . '\',\'' . $bindfield2 . '\',\'' .$bindfield3 . '\',\'' . $bindfield4 . '\',\'' . $bindfield5 . '\')"><img src="' . base_url() .'/images/filefind.png" width="14" height="14" border="0"></a>';
		    }

		    echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
		    
		    break;

		    case "query":
  ##Change Node to primary key
		    if ($mode == 'edit') {
		      $node = $rffval->fld_btid;
		    }
		    else {
		      $node = 0;
		    }
		    $fld_querysql = str_replace("!node",$node,$rff->fld_querysql);
		    $value_dsc = '';
		    $query = $this->db->query("$fld_querysql");
		    $lquery = $query->row();
		    if (count($lquery) > 0) {
		      $value_dsc = $lquery->result;
		    }
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm . "_dsc",
		    'id'          => $rff->fld_formfieldnm . "_dsc",
		    'value'       => $value_dsc,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => 'lookup',
		    );
		  
		    $input_tag['readonly'] = 1;
		    echo form_input($input_tag,'',$js_lookup);
		   
		    break;

		    case "info":
		    $fld_querysql = $rff->fld_querysql;
		    $query = $this->db->query("$fld_querysql");
		    $lquery = $query->row();

		    echo $lquery->info ;
		    break;

		    case "autono":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => $class,
		    );
		    if ($rff->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $js = $rff->fld_formfieldjs;
		    echo form_input($input_tag,'',$js);
		    break;

		     case "file":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '100',
		    'size'        => $rff->fld_formfieldwidth,
		    'class'       => $class,
		    );
		    $input_tag['readonly'] = 1;
		    $js = $rff->fld_formfieldjs;
		    echo form_input($input_tag,'',$js);
		    $atts = array(
		    'width'      => '400',
		    'height'     => '300',
		    'scrollbars' => 'no',
		    'status'     => 'no',
		    'resizable'  => 'no',
		    'screenx'    => '0',
		    'screeny'    => '0'
		    );

		    echo anchor_popup("upload?val=$rff->fld_formfieldnm", "Upload", $atts);
		    break;

                    case "photo":
                    $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm,
                    'id'          => $rff->fld_formfieldnm,
                    'value'       => $value,
                    'maxlength'   => '100',
                    'size'        => $rff->fld_formfieldwidth,
                    'class'       => $class,
                    );
                    $input_tag['readonly'] = 1;
                    $js = $rff->fld_formfieldjs;
                    if ( $value == "") {
						$value = "no_photo.jpg";
					}
                    echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
                    echo anchor_popup("upload?type=photo&val=$rff->fld_formfieldnm", "<img src='" . base_url() . "/upload/photo/$value' width='110' height='140' border='0'>", $atts);
                    break;

		    case "date":
		    if ($value == "" || $value == "0000-00-00" || $value == "0000-00-00 00:00:00") {
		      $value = "00-00-0000";
		    } else {
                     $value = date('d-m-Y',strtotime($value));
                    }
                     
		     $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '15',
		    'size'        => '9',
		    'class'       => $class,
		    );
		    if ($rff->fld_formfieldronly == 1) {
		      $input_tag['readonly'] = 1;
		      echo form_input($input_tag,'',$js);
		    }
		    else {
		      $js = $rff->fld_formfieldjs;
		      echo form_input($input_tag,'',$js);
		      echo '<a href="javascript:void(0)"  id="'. $rff->fld_formfieldnm .'-trigger" ><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';
		      echo '<script>
		      Calendar.setup({
		      dateFormat : "%d-%m-%Y",
                      trigger    : "' . $rff->fld_formfieldnm . '-trigger",
		      inputField : "' . $rff->fld_formfieldnm .'",
		      onSelect   : function() { this.hide() }
		      });
		      </script>';
		    }
		    break;

                    case "datetime":
                     if ($value == "" || $value == "0000-00-00" || $value == "0000-00-00 00:00:00") {
		      $value = "00-00-0000 00:00:00";
		    } else {
                     $value = date('d-m-Y H:i:s',strtotime($value));
                    }
                     $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm,
                    'id'          => $rff->fld_formfieldnm,
                    'value'       => $value,
                    'maxlength'   => '15',
                    'size'        => '15',
                    'class'       => $class,
                    );
                    if ($rff->fld_formfieldronly == 1) {
                      $input_tag['readonly'] = 1;
                      echo form_input($input_tag,'',$js);
                    }
                    else {
                      $js = $rff->fld_formfieldjs;
                      echo form_input($input_tag,'',$js);
                      echo '<a href="javascript:void(0)"  id="'. $rff->fld_formfieldnm .'-trigger" ><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';
                      echo '<script>
                      Calendar.setup({
                      dateFormat : "%Y-%m-%d %H:%M:%S",
                      showTime   : "True",
                      trigger    : "' . $rff->fld_formfieldnm . '-trigger",
                      inputField : "' . $rff->fld_formfieldnm .'",
                      onSelect   : function() { this.hide() }
                      });
                      </script>';
                    }
                    break;

		     case "getnow":
                     $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm,
                    'id'          => $rff->fld_formfieldnm,
                    'value'       => $value,
                    'maxlength'   => '15',
                    'size'        => '15',
                    'class'       => $class,
                    );
                    if ($rff->fld_formfieldronly == 1) {
                      $input_tag['readonly'] = 1;
                      echo form_input($input_tag,'',$js);
                      echo '<a href="javascript:getnow(\'' . $rff->fld_formfieldnm . '\')"><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';
                    }
                    else {
                      $js = $rff->fld_formfieldjs;
                      echo form_input($input_tag,'',$js);
                      echo '<a href="javascript:getnow(\'' . $rff->fld_formfieldnm . '\')"><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';	   }
                      echo "<script>
                      function getnow(field) {
                      var d = new Date,
                      dformat = [       
		      d.getFullYear(),
		      d.getMonth()+1,
		      d.getDate()].join('-')+
		      ' ' +
		      [d.getHours(),
		      d.getMinutes(),
		      d.getSeconds()].join(':');
                      document.getElementById(field).value = dformat;
                      }
                      </script>";
                    
                    break;
			
		    case "time":
                    echo "<select>";
		    for($i=0; $i<60; $i++) {
                      $selected = '';
                      if ($birthdayYear == $i) $selected = ' selected="selected"';
                      echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n" ;
                    }
                    echo "</select>";



                    break;

		    case "textarea":
                    $input_tag = array
                    (
                    'name'        => $rff->fld_formfieldnm,
                    'id'          => $rff->fld_formfieldnm,
                    'value'       => $value,
                    'cols'        => $rff->fld_formfieldwidth,
                    'rows'        => 5,
                    'class'       => $class,
                    );
                     if ($fld_formtyid != 1) {
                      $js = $rff->fld_formfieldjs . ' onkeyup=convertToUpper(this) ';
                    }
                    else {
                      $js = $rff->fld_formfieldjs;
                    }
                    if ($rff->fld_formfieldronly == 1) {
                    $input_tag['readonly'] = 1;
                    }
                    echo "<textarea name='$rff->fld_formfieldnm' cols='$rff->fld_formfieldwidth' rows='5' id='$rff->fld_formfieldnm' class='$class' $js>$value</textarea>";
                    break;

		    case "texteditor":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'cols'        => $rff->fld_formfieldwidth,
		    'class'       => 'mceEditor',
		    );
		    echo form_textarea($input_tag);
		    break;

		    case "dropdown":
		    if ($rff->fld_formfieldronly == 1) {
		      $fld_querysql = $rff->fld_querysql;
		      $value_dsc = '';
		      $query = $this->db->query("$fld_querysql having id = '$value'");
		      $lquery = $query->row();
		      if (count($lquery) > 0) {
			$value_dsc = $lquery->name;
		      }
		      $input_tag = array
		      (
		      'name'        => $rff->fld_formfieldnm . "_dsc",
		      'id'          => $rff->fld_formfieldnm . "_dsc",
		      'value'       => $value_dsc,
		      'maxlength'   => '100',
		      'size'        => $rff->fld_formfieldwidth,
		      'class'       => 'lookup',
		      );
		      $input_tag['readonly'] = 1;
		      echo form_input($input_tag,'',$js_lookup);
                      echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
                
		    }
		    else {
		      $fld_querysql = $rff->fld_querysql;
		      $gbind = $this->view->getbind($rff->fld_queryid);
		    $dbind = array();
		    if (count($gbind) > 0) {
		      $ctbind = 0;
		      foreach ($gbind as $rbind) {
			$bindname = $rbind->fld_querybindnm;
			$bindval =  $rbind->fld_querybindval;
			if (preg_match('/^!/',$bindval)) {
			  $bindval = substr($bindval,1);
			  $bindval =  $this->session->userdata($bindval);
			}
			if (substr($bindval,0,4) == 'fld_') {
			  #$bindval = '%';
                          if ($rffval->$bindval != "") {
			    $bindval = $rffval->$bindval;
			  }
			  else {
			    $bindval = '%';
			  }
			  $ctbind = $ctbind +1;
			  ${'bindfield' . $ctbind} = $bindname;
			}

			if ($this->input->get($bindname)) {
			  $bindval =  $this->input->get($bindname);
			}
		      $dbind [] =  $bindval;
		    
		      }

		    }
		      $gopt = $this->db->query($fld_querysql,$dbind);
		      $ddsize = $rff->fld_formfieldwidth;
		      if ($gopt->num_rows() > 0)
		      {
			$lopt = $gopt->result();
		      }
		      $options = array();
		      $options[0]= '[--Select--]';
		      foreach ($lopt as $ropt)
		      {
				  $options[$ropt->id]= $ropt->name;
		      }

		      echo form_dropdown($rff->fld_formfieldnm, $options, $value,"id='$rff->fld_formfieldnm' class='$class'");
		      }

		      break;
		      case "bolean":
			
		       if ($rff->fld_formfieldronly == 1) {
	
			if ($value == 1) {
                        echo '<input type="radio"' . $rff->fld_formfieldjs . 'name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="1"' . 'checked' .'> Yes';
                        }
                        else {
                        echo '<input type="radio" '. $rff->fld_formfieldjs . 'name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="0"' . 'checked' . '> No';
                      }


			}
			else { 
			if ($value == 1) {
		      	echo '<input type="radio"' . $rff->fld_formfieldjs . 'name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="1"' . 'checked' .'> Yes <input type="radio" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="0"' . $rff->fld_formfieldjs . '> No';
		      	}
		      	else {
		      	echo '<input type="radio" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="1"'  . $rff->fld_formfieldjs . '> Yes <input type="radio" '. $rff->fld_formfieldjs . 'name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="0"' . 'checked' . '> No';
		      }
		}
		    break;

		    case "custom":
		    echo "";
		    break;

		     case "checkbox":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => 1,
		    'checked'     => ($value == 1 ) ? TRUE : FALSE,
		     );
                    $js = $rff->fld_formfieldjs;
		    echo form_checkbox($input_tag,'','',$js);
		    break;

		    case "radio":
		    $fld_querysql = $rff->fld_querysql;
		    $gradio = $this->db->query("$fld_querysql");
		    $ddsize = $rff->fld_formfieldwidth;
		    if ($gradio->num_rows() > 0)
		    {
		      $lradio = $gradio->result();
		    }
		    $radioions = array();
		    foreach ($lradio as $rradio)
		    {
		      if ($rradio->id == $value) {
			$status = 'checked';
		      }
		      else {
			$status = 'unchecked';
		      }
		      echo "<input type='radio' name='$rff->fld_formfieldnm' value='$rradio->id'" .  $status . "> $rradio->name ";
		    }

		    break;

		    case "periode":
                    $startDate = strtotime(date('Y-m-d')  . '-15 month');
		    $currentDate   = strtotime(date('Y-m-d'));
		    if ($rff->fld_formfieldronly == 1) {
			$value_dsc = $value;
		      $input_tag = array
		      (
		      'name'        => $rff->fld_formfieldnm . "_dsc",
		      'id'          => $rff->fld_formfieldnm . "_dsc",
		      'value'       => $value_dsc,
		      'maxlength'   => '100',
		      'size'        => $rff->fld_formfieldwidth,
		      'class'       => 'lookup',
		      );
		      $input_tag['readonly'] = 1;
		      echo form_input($input_tag,'',$js_lookup);
                      echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" id="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';
                
		    }
		    else {
		      #$fld_querysql = $rff->fld_querysql;
		      #$gopt = $this->db->query($fld_querysql,$dbind);
		      $ddsize = $rff->fld_formfieldwidth;
		      $options = array();
		      $options[0]= '[--Select--]';
		      while ($currentDate >= $startDate) {
                        $options[date('Y-m',$currentDate)]= date('Y-m',$currentDate);
                        $currentDate = strtotime( date('Y/m/01/',$currentDate).' -1 month');
                      }
		      echo form_dropdown($rff->fld_formfieldnm, $options, $value,"id='$rff->fld_formfieldnm' class='$class'");
		      }

		      break;
	      }
	      }
?>
  </td>
<? if ($rff->fld_formfieldrbreak == 1) {
?>
  </tr>
  <tr>
<?
}
else 
{
?>
<td>&nbsp;&nbsp;&nbsp;</td>
<? } ?>
<?php endforeach;?>
</table>
</td>
<td valign='top' >
      <table>
<?  if ($mode == 'edit' && isset($printout)) { ?>
	<tr>
	  <td>&nbsp;&nbsp;&nbsp;<b>Links :</b></td>
	</tr>
	<tr>
	  <td>
	<?
	    foreach ($printout as $rprintout)
	    {
              if($rprintout->fld_formprintsts == 1) {
	        echo "- " . "<a href=" . base_url() . "$rprintout->fld_formprinturl/$rffval->fld_btid  target='_blank'>" . $rprintout->fld_formprintnm  . "</a><br>";
              } else {
               $prn_url = str_replace('$node',$rffval->fld_btid,"$rprintout->fld_formprinturl");
               echo "- " . "<a href='" . base_url() . "$prn_url'>" . $rprintout->fld_formprintnm  . "</a><br>";
              }
 
	    }
	?>

	  </td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	</tr>
<? } ?>
<?  if ($mode == 'edit' && isset($futrans)) { ?>
	<tr>
	  <td>&nbsp;&nbsp;&nbsp;<b>Follow Up Transaction :</b></td>
        <input type='hidden' id='btid' name='btid'>
        <input type='hidden' id='tynextid' name='tynextid'>
        <input type='hidden' id='tynextform' name='tynextform'> 
        <input type='hidden' id='nextformid' name='nextformid'>
	</tr>
	<tr>
	  <td>
	<?
	    foreach ($futrans as $rfutrans)
	    {
	      if ($rfutrans->fld_count < $rfutrans->fld_workflowmax) {
		    echo "- " . "<a href='javascript:fup_action($rfutrans->fld_btid,$rfutrans->fld_bttyid,\"$rfutrans->fld_bttyform\",$rfutrans->nextformid,\"$fld_formnm\",\"fup\");' onclick= \" return confirm('Are you sure want to make follow up Transaction ?')\" " . ">" . $rfutrans->fld_bttynm . "</a>" . " (" . $rfutrans->fld_count . ")<br>";        
	      }
	      else {
		    echo "- " .  $rfutrans->fld_bttynm . " (" . $rfutrans->fld_count . ")<br>";
	      }
	    }
	?>

	  </td>
	</tr>
	<? } ?>
         <? if (count($trans_map) > 0) { ?>
         <tr>
          <td>&nbsp;&nbsp;&nbsp;<b>Transaction Map :</b></td>
        </tr>
        <tr> 
          <td>
		 <?
            foreach ($trans_map as $rtrans_map)
            {
             if($rtrans_map->level == 'up') {
             echo "  - " . "<a href='" . base_url() . "index.php/page/form/" . $rtrans_map->fld_bttyform . "/edit/" . $rtrans_map->fld_btid . "'>" . $rtrans_map->fld_btno . "</a><br>";
        
            }
            }
        ?>
          </td>
        <tr> 
	<td>- <?=$rffval->fld_btno;?></td>
	</tr>
        <tr>
	<td>
                 <?
            foreach ($trans_map as $rtrans_map)
            {
             if($rtrans_map->level == 'down') {
             echo "  - " . "<a href='" . base_url() . "index.php/page/form/" . $rtrans_map->fld_bttyform . "/edit/" . $rtrans_map->fld_btid . "'>" . $rtrans_map->fld_btno . "</a><br>";
        
            }
            }
        ?>
          </td>



       </tr>
<? 
} ### End Of Trans. Map
?> 

      </table>
</td>
</tr>
</table>
<br>

<!--<input type="button" name="back" class="BtnGrey" value="Back" id='backback' onclick='javascript: history.go(-1)'>-->
<?
if ((isset($issubform) &&  $issubform == 1) || (isset($isformview) &&  $isformview == 1)) {
  include ("subform_view.php");
}
?>
</form>
<br>
<br>
</html>

