<?
echo '<html>';
echo '<head>';
echo '<script language="javascript">';
echo 'function validate(f) {
      var fnm = f.name;
      var x = document.getElementsByTagName("input");
	  for (i = 0; i < x.length; i++) {
	      if (x[i].className == "mandatory") {
		  if (x[i].value == ""){
		      alert("Data yang anda masukkan belum lengkap");
		      x[i].focus();
		      err="error";
		      return false;
		  }
	      }
      }
     document[fnm].action="' .  base_url() . 'index.php/page/view/' . $rvdata->fld_viewnm . '";
}
</script>
</head>';
?>
<form name="<? echo $fld_formnm; ?>" method='get' id="<? echo $fld_formnm;?>" onSubmit="return validate(this)">
<table border="0" cellspacing="0" cellpadding="0">
<?php foreach($formfield as $rff):?>
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
     $value =  $this->input->get($ffname);
	      if ($value == '') {

	     # $value = $this->input->get($ffname);
		  if (preg_match('/^!/',$value)) {
		    $rvalue = substr($value,1);
		    $value = $this->session->userdata($rvalue);
		  }
		  if ($value == 'now!') {
		    $value = date ("Y-m-d H:i:s");
		  }
	      }

  ?>
  <?
    if ($rff->fld_formfieldhdr != '') {
  ?>
  <tr height='31' valign='bottom' cellspacing="2" cellpadding="2">
    <td colspan = "3" style="border-bottom-style:solid; border-bottom-width:2px;"><? echo $rff->fld_formfieldhdr; ?></td>
  <tr>
  <?
    }

    if ($rff->fld_formfieldshow != 1)
		      {
			 echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" value="' . $value . '" />';

		      }
	      else
	      {
  ?>
<? if ($rff->fld_formfieldrbreak == 1) {
?>
<?
}
?>
    <td style="border-bottom: solid 1px white" nowrap><? if ($rff->fld_formfieldmdtr == 1) {?><span style="color: rgb(255, 0, 0);">*</span><?}?><?=$rff->fld_formfieldlbl?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
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
		    echo form_input($input_tag,'',$js);
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

		    case "lookup":
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
		    if ($rff->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    echo form_input($input_tag,'',$js_lookup);
		    }
		    else {
		    $js_lookup = 'onChange="popup_selector(document.getElementById(\'' . $rff->fld_formfieldnm . '_dsc\').value,\'' . base_url() . '\',\'' . $rff->fld_querynm .  '\',\'' . $rff->fld_formfieldnm . '\')"';
		    echo form_input($input_tag,'',$js_lookup);
		    echo '<a href="javascript:void(1)" onclick= "popup_selector(document.getElementById(\'' . $rff->fld_formfieldnm . '_dsc\').value,\'' . base_url() . '\',\'' . $rff->fld_querynm .  '\',\'' . $rff->fld_formfieldnm . '\')"><img src="' . base_url() .'/images/filefind.png" width="14" height="14" border="0"></a>';
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

		    case "date":
		     $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'maxlength'   => '15',
		    'size'        => '8',
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
		      dateFormat : "%Y-%m-%d",
		      trigger    : "' . $rff->fld_formfieldnm . '-trigger",
		      inputField : "' . $rff->fld_formfieldnm .'",
		      onSelect   : function() { this.hide() }
		      });
		      </script>';
		    }
		    break;

                     case "datetime":
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
                      dateFormat : "%Y-%m-%d %H:%M",
                      showTime   : "True",
                      trigger    : "' . $rff->fld_formfieldnm . '-trigger",
                      inputField : "' . $rff->fld_formfieldnm .'",
                      onSelect   : function() { this.hide() }
                      });
                      </script>';
                    }
                    break;



		    case "textarea":
		    $input_tag = array
		    (
		    'name'        => $rff->fld_formfieldnm,
		    'id'          => $rff->fld_formfieldnm,
		    'value'       => $value,
		    'cols'        => $rff->fld_formfieldwidth,
		    'rows'	  => 5,
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
		    echo form_textarea($input_tag,$js);
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
		    }
		    else {
		      $fld_querysql = $rff->fld_querysql;
		      $gopt = $this->db->query("$fld_querysql");
		      $ddsize = $rff->fld_formfieldwidth;
		      if ($gopt->num_rows() > 0)
		      {
			$lopt = $gopt->result();
		      }
		      $options = array();
		      $options[0]= '[--Pilih--]';
		      foreach ($lopt as $ropt)
		      {
				  $options[$ropt->id]= $ropt->name;
		      }

		      echo form_dropdown($rff->fld_formfieldnm, $options, $value,"style='width:$ddsize px'");
		      }
		      break;

		      case "bolean":

		      if ($value == 1) {
		      echo '<input type="radio" name="' . $rff->fld_formfieldnm . '" value="1"' . 'checked' . '> Yes <input type="radio" name="' . $rff->fld_formfieldnm .'" value="0"' . '> No';
		      }
		      else {
		      echo '<input type="radio" name="' . $rff->fld_formfieldnm . '" value="1"'  . '> Yes <input type="radio" name="' . $rff->fld_formfieldnm .'" value="0"' . 'checked' . '> No';
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
		    echo form_checkbox($input_tag);
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
                      $fld_querysql = $rff->fld_querysql;
                      $gopt = $this->db->query($fld_querysql,$dbind);
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
<br>
<input type="submit" name="search" class="BtnBlue" value="Search" id='submit'>
</form>
<br>
<br>
<br>
<br>
</html>

