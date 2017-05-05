<?
if ($mode == 'edit' || $mode == 'add') {
  echo "<div id='ddtabs' class='basictab'>";
  echo "<ul>";
  foreach ($subform as $rsubform) {
    if ($rsubform->fld_subformshow == 1) {
      echo "<li><a href='javascript:void(0)' onClick='expandcontent(\"" . $rsubform->fld_formlbl . "\", this)'>" . $rsubform->fld_formlbl ."</a></li>";
    }
  }
  foreach ($formview as $rformview) {
    echo "<li><a href='javascript:void(0)' onClick='expandcontent(\"" . $rformview->fld_formviewnm . "\", this)'>" . $rformview->fld_formviewnm ."</a></li>";
  }
  echo "</ul>";
  echo "</div>";
  echo "<div class='ddcolortabsline'>&nbsp;</div>";
  echo "<div style='height:400px; width:100%; overflow-x:scroll ; overflow-y: scroll; padding-bottom:10px;'>
  ";
  echo "<div>";
  foreach ($subform as $rsubform) {
    if ($rsubform->fld_subformty == 1) {
      $js = "
      <script>
      function delRow" . $rsubform->fld_formnm . "(r,obj) {
        delTotal(obj,'" . $rsubform->fld_formnm . "');
        document.getElementById('" . $rsubform->fld_formid . "').deleteRow(r);
        var count = document.getElementById('" . $rsubform->fld_formid . "Count').value;
        document.getElementById('" . $rsubform->fld_formid . "Count').value = count - 1;
      }
    
      function addRow" . $rsubform->fld_formnm . "(){
        var tbl = document.getElementById('" . $rsubform->fld_formid . "');
        var lastRow = tbl.rows.length;
        lastRow = lastRow;
        var iteration = lastRow - 1 ;
        var row = tbl.insertRow(lastRow);
        document.getElementById('" . $rsubform->fld_formid . "Count').value = iteration;
		document.getElementById('" . $rsubform->fld_formid . "Count-ori').value = iteration;
        var cellLeft = row.insertCell(0);
        var textNode = document.createTextNode(iteration);
        var img = document.createElement('IMG');
        img.setAttribute('src', '" . base_url() ."images/application_delete.png');
        img.setAttribute('height', '14px');
        img.setAttribute('border', 0);
        img.className = 'selectorButton';
        newlink = document.createElement('a');
        newlink.setAttribute('href', 'javascript:void(0)');
        newlink.setAttribute('onClick', 'delRow" . $rsubform->fld_formnm . "(this.parentNode.parentNode.rowIndex,this.parentNode.parentNode)');
        newlink.appendChild(img);
        cellLeft" . ".appendChild(newlink);
        ";

        $relfldp = $rsubform->fld_formrelp;
        $relfldc = $rsubform->fld_formrelc;
        $sftblnm = $rsubform->fld_tblnm;
        $relfldval = (isset($rffval->$relfldp)) ? $rffval->$relfldp : '' ;
        if ($rsubform->fld_subformshow == 0) {
        echo "<div style='display:none'>";
      } else {
        echo "<div id='" . $rsubform->fld_formlbl . "' class='tabcontent'>";
      } 
      ### Ambil data yang sudah diinput
      $sfgvrs = $this->db->query("select * from $sftblnm t0 where t0.$relfldc = '$relfldval'");
      $sfformfield= $this->form->getformfield($rsubform->fld_formid);
      echo '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="' . $rsubform->fld_formid . '">';
      echo '<tr height="10" bgcolor="#CDCBBF" align="center">';
      if($rsubform->fld_formcreate == 1) {
      echo '<td width="20"><a href="javascript:addRow' . $rsubform->fld_formnm . '()' . '"><img src="' . base_url() . 'images/application_add.png" width="14" height="14" border=0 ></a></td>';
      } else {
         echo '<td width="20"><img src="' . base_url() . 'images/application_add.png" width="14" height="14" border=0 ></td>';
      }
      foreach ($sfformfield as $rsfformfield) {
        if ($rsfformfield->fld_formfieldshow == 1) {
          echo '<td align="center" nowrap>' . $rsfformfield->fld_formfieldlbl . '</td>';
        }
      }
?>
</tr>
<tr>
<?
      ###Display current data
      $pkey = $rsubform->fld_tblpkey;
      ${$rsubform->fld_formid . 'ctval'} = 0;
      foreach ($sfgvrs->result() as $rviewrs) {
      $node = $rviewrs->$pkey;
      $sfffval = $this->form->getformfieldval($rsubform->fld_tblnm,$rsubform->fld_tblpkey,$node);
      foreach($sfffval as $rsfffval):
      endforeach;
      ${$rsubform->fld_formid . 'ctval'} = ${$rsubform->fld_formid . 'ctval'} + 1;
      echo "<tr>";
      echo "<td width='25'><a href='javascript:void(0)' onClick='delRow" . $rsubform->fld_formnm . "(this.parentNode.parentNode.rowIndex,this.parentNode.parentNode); alert(\"This Record will be deleted, Press F5 to Undo\")'><img src='" . base_url() . "images/application_delete.png' width='14' height='14' border=0 ></a></td>";
      foreach ($sfformfield as $rsfformfield) {
        $ffname = $rsfformfield->fld_formfieldnm;
        $valuesf = $rsfffval->$ffname;
        if ($rsfformfield->fld_formfieldmdtr == 1) {
          $classsf = 'mandatory';
        } else {
          $classsf = '';
        }
        if ($rsfformfield->fld_formfieldshow != 1) {
        echo '<input type="hidden" name="' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '" value="' . $valuesf . '" />';
        }
        if ($rsfformfield->fld_formfieldshow == 1) {
          echo "<td nowrap>";
          switch($rsfformfield->fld_formfieldtag) {
          case "text":
          $input_tag = array (
            'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
            'id'          => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
            'value'       => $valuesf,
            'maxlength'   => '100',
            'size'        => $rsfformfield->fld_formfieldwidth,
            'class'       => $classsf,
          );
		    if ($rsfformfield->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $jsku = "onchange='change(\"" . $rsubform->fld_formlbl . "\"," .  ${$rsubform->fld_formid . 'ctval'} . ",\"" .  $rsubform->fld_formnm . "\",\"" . $rsubform->fld_formid . "Count" . "\")'";
		    if ($fld_formtyid != 1) {
                      echo form_input($input_tag,'',"$jsku onkeyup=convertToUpper(this)");
                    } else {
                      echo form_input($input_tag,'',"$jsku"); 
                    }
		    break;

                    case "money":
		     $value_dsc = '';
		    if ($valuesf > 0) {
		      $value_dsc = number_format($valuesf,0,'.',',');
		    }
          $input_tag = array (
            'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . "_dsc",
		    'id'          => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . "_dsc",
		    'value'       => $value_dsc,
		    'maxlength'   => '100',
		    'size'        => $rsfformfield->fld_formfieldwidth,
		    'class'       => $classsf,
                    'style'       => 'text-align:right',
          );
		    if ($rsfformfield->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $jsku = "onchange='change(\"" . $rsubform->fld_formlbl . "\"," .  ${$rsubform->fld_formid . 'ctval'} . ",\"" .  $rsubform->fld_formnm . "\",\"" . $rsubform->fld_formid . "Count" . "\")'";
		    echo form_input($input_tag,'',"$jsku . onkeyup=formatNumber(this)");
		     echo '<input type="hidden" name="' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'}  . '" id="' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '" value="' . $valuesf . '" />';
		    break;


		    case "lookup":

		    $fld_querysql = $rsfformfield->fld_querysql . " having id = '$valuesf'";
		    $gbind = $this->view->getbind($rsfformfield->fld_queryid);
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
			  $ctbind = $ctbind +1;
			  ${'bindfield' . $ctbind} = $bindname;
			  $bindval = $rffval->$bindval;
			}

			if ($this->input->get($bindname)) {
			  $bindval =  $this->input->get($bindname);
			}
		      $dbind [] =  $bindval;
		    
		      }

		    }

		    $query = $this->db->query($fld_querysql,$dbind);
		    $lquery = $query->row();
		    $value_dsc = $lquery->name;
		    $input_tag = array
		    (
		    'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . "_dsc",
		    'id'          => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . "_dsc",
		    'value'       => $value_dsc,
		    'maxlength'   => '100',
		    'size'        => $rsfformfield->fld_formfieldwidth,
		    'class'       => $classsf,
		    );
		    if ($rsfformfield->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }

		    echo '<input type="hidden" name="' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'}  . '" id="' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '" value="' . $valuesf . '" />';

		    $js_lookup = 'onChange="popup_selector(document.getElementById(\'' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '_dsc\').value,\'' . base_url() . '\',\'' . $rsfformfield->fld_querynm .  '\',\'' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '\',' . '\'' . $bindfield1 . '\',\'' . $bindfield2 . '\',\'' .$bindfield3 . '\',\'' . $bindfield4 . '\',\'' . $bindfield5 . '\')"';
		    echo form_input($input_tag,'',$js_lookup);
		    echo '<a href="javascript:void(1)" onclick= "popup_selector(document.getElementById(\'' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '_dsc\').value,\'' . base_url() . '\',\'' . $rsfformfield->fld_querynm .  '\',\'' . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '\',' . '\'' . $bindfield1 . '\',\'' . $bindfield2 . '\',\'' .$bindfield3 . '\',\'' . $bindfield4 . '\',\'' . $bindfield5 . '\')"><img src="' . base_url() .'/images/filefind.png" width="14" height="14" border="0"></a>';
		    break;

		    case "textarea":
		    $input_tag = array
		    (
		    'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'id'          => $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'value'       => $valuesf,
		    'maxlength'   => '100',
		    'size'        => $rsfformfield->fld_formfieldwidth,
		    'class'       => $classsf,
		    );
		    if ($rsfformfield->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $jsku = "onchange='change(\"" . $rsubform->fld_formlbl . "\"," .  ${$rsubform->fld_formid . 'ctval'} . ",\"" .  $rsubform->fld_formnm . "\")'";
		    echo form_input($input_tag,'',"$jsku");
		    break;

		    case "date":
                     if ($valuesf == "" || $valuesf == "0000-00-00" || $valuesf == "0000-00-00 00:00:00") {
		      $valuesf = "00-00-0000";
		    } else {
                     $valuesf = date('d-m-Y',strtotime($valuesf));
                    }
		     $input_tag = array
		    (
		    'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'id'          => $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'value'       => $valuesf,
		    'maxlength'   => '15',
		    'size'        => '7',
		    'class'       => $classsf,
		    );
		    if ($rsfformfield->fld_formfieldronly == 1) {
		    $input_tag['readonly'] = 1;
		    }
		    $jskudt = $rff->fld_formfieldjs;
		    echo form_input($input_tag,'',$jskudt);

		    echo '<a href="javascript:void(0)"  id="'. $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} .'-trigger" ><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';
		    echo '<script>
		    Calendar.setup({
		    dateFormat : "%d-%m-%Y",
                    trigger    : "' . $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} .'-trigger",
		    inputField : "' . $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '",
		    onSelect   : function() { this.hide() }
		    });
		    </script>';
		    break;


                    case "datetime":
                     $input_tag = array
                    (
                    'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
                    'id'          => $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
                    'value'       => $valuesf,
                    'maxlength'   => '15',
                    'size'        => '13',
                    'class'       => $classsf,
                    );
                    if ($rsfformfield->fld_formfieldronly == 1) {
                    $input_tag['readonly'] = 1;
                    }
                    $jskudt = $rff->fld_formfieldjs;
                    echo form_input($input_tag,'',$jskudt);

                    echo '<a href="javascript:void(0)"  id="'. $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} .'-trigger" ><img src="' . base_url() .'/images/calendar.jpg" width="14" height="14" border="0"></a>';
                    echo '<script>
                    Calendar.setup({
                    dateFormat : "%Y-%m-%d %H:%M",
                    showTime   : "True",
                    trigger    : "' . $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} .'-trigger",
                    inputField : "' . $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'} . '",
                    onSelect   : function() { this.hide() }
                    });
                    </script>';
                    break;

                     case "checkbox":
		    $input_tag = array
		    (
		    'name'        => $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'id'          => $rsubform->fld_formnm . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'},
		    'value'       => 1,
		    'checked'     => ($valuesf == 1 ) ? TRUE : FALSE,
		     );
		    echo form_checkbox($input_tag);
		    break;


		    case "dropdown":
		    $fld_querysql = $rsfformfield->fld_querysql;
		    $gopt = $this->db->query("$fld_querysql");
		    if ($gopt->num_rows() > 0)
		    {
		      $lopt = $gopt->result();
		    }
		    $options = array();
// 		     if ($value == '' || $value == '0')
// 		    {
		      $options[0]= '[--Pilih--]';
// 		    }
		    foreach ($lopt as $ropt)
		    {
				$options[$ropt->id]= $ropt->name;
		    }

		    echo form_dropdown($rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'}, $options, $valuesf);
		    break;

		    case "bolean":
		    $options = array(
		      '1'  => 'Yes',
		      '0'    => 'No',
                      );

		    echo form_dropdown($rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . ${$rsubform->fld_formid . 'ctval'}, $options, $valuesf);
		    break;

	      }
	      echo "</td>";
	  }
    }
    echo "</tr>";
}
?>
<input type="hidden" name="<? echo $rsubform->fld_formid . "Count" ; ?>" id="<? echo $rsubform->fld_formid . "Count" ; ?>" value="<? echo ${$rsubform->fld_formid . 'ctval'};?>">
<input type="hidden" name="<? echo $rsubform->fld_formid . "Count-ori" ; ?>" id="<? echo $rsubform->fld_formid . "Count-ori" ; ?>" value="<? echo ${$rsubform->fld_formid . 'ctval'};?>">
<?
$no = 0;
###### Javascript

foreach ($sfformfield as $rsfformfield)
// $no = $no+1;
    {
	if (!isset($rsfformfield->fld_formfieldval))
	   {
	      $rsfformfield->fld_formfieldval = '';
	   }
	

	      $value = $rsfformfield->fld_formfielddval;
		  if (preg_match('/^!/',$value)) {
		    $rvalue = substr($value,1);
		    $value = $this->session->userdata($rvalue);
		  }
		  if ($value == 'now!') {
		    $value = date ("d-m-Y H:i:s");
		  }
	   

	if ($rsfformfield->fld_formfieldshow != 1)
		      {
			  $js .="
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'hidden';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm .$rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".size = 15;

		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfieldval . "';
		   cellLeft.appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		      }
	else
	{

	$no = $no+1;
	
	switch($rsfformfield->fld_formfieldtag) {
          case "text":
            if($rsubform->fld_formid == 171 ||  
		$rsubform->fld_formid == 208 ||  
                $rsubform->fld_formid == 61 ||  
                $rsubform->fld_formid == 119 ||  
                $rsubform->fld_formid == 163 ||  
                $rsubform->fld_formid == 53 ||
                $rsubform->fld_formid == 308 ||
                $rsubform->fld_formid == 321
                ) {
	      if($rsfformfield->fld_formfieldnm == 'fld_btqty01' || 
                 $rsfformfield->fld_formfieldnm == 'fld_btuamt01'  || 
                 $rsfformfield->fld_formfieldnm == 'fld_btamt01' ||
                 $rsfformfield->fld_formfieldnm == 'fld_period') {
		 $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onchange','javascript:change(\'" . $rsubform->fld_formlbl . "\',' + iteration + ',\'" . $rsubform->fld_formnm .  "\',\'" . $rsubform->fld_formid . "Count" . "\')');";
	      } else {
                $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onkeyup','javascript:convertToUpper(this)');";
              }
		      }
		      elseif ($rsfformfield->fld_formfieldnm == 'fld_btqty01' || $rsfformfield->fld_formfieldnm == 'fld_btamt01') {
			  $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onchange','javascript:setTotal(document.getElementById(\'" . $rsubform->fld_formid . "Count\').value,\'" . $rsubform->fld_formnm .  "\')');";
		      } else {
                        if ($fld_formtyid != 1) {
 		          $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onkeyup','javascript:convertToUpper(this)');";
                        } else {
                          $onchange = "";
                        }                             
 		      }

                   if ($rsfformfield->fld_formfieldronly == 1) {
                      $readonly = ".setAttribute('readOnly','true')";
                    }
	           else {
                      $readonly = ".readonly = 'true'";

                   }

		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'text';
		    el" . $rsfformfield->fld_formfieldnm . $readonly . ";
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".setAttribute('size'," . $rsfformfield->fld_formfieldwidth . ");
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $value . "';
		    el" . $rsfformfield->fld_formfieldnm . ".className = '" . $classsf . "';
		   " . $onchange . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		    break;

                    case "money":
		    
		     if($rsubform->fld_formid == 171 ||  
		$rsubform->fld_formid == 208 ||  
                $rsubform->fld_formid == 61 ||  
                $rsubform->fld_formid == 119 ||  
                $rsubform->fld_formid == 163 ||  
                $rsubform->fld_formid == 53 ||
                $rsubform->fld_formid == 308 ||
                $rsubform->fld_formid == 321
                ) {
	      if($rsfformfield->fld_formfieldnm == 'fld_btqty01' || 
                 $rsfformfield->fld_formfieldnm == 'fld_btuamt01'  || 
                 $rsfformfield->fld_formfieldnm == 'fld_btamt01' ||
                 $rsfformfield->fld_formfieldnm == 'fld_period') {
		 $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onchange','javascript:change(\'" . $rsubform->fld_formlbl . "\',' + iteration + ',\'" . $rsubform->fld_formnm .  "\',\'" . $rsubform->fld_formid . "Count" . "\')');";
	      } 
		      }
		      elseif ($rsfformfield->fld_formfieldnm == 'fld_btqty01' || $rsfformfield->fld_formfieldnm == 'fld_btamt01') {
			  $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onchange','javascript:setTotal(document.getElementById(\'" . $rsubform->fld_formid . "Count\').value,\'" . $rsubform->fld_formnm .  "\')');";
		      }
		      else {
 		      $onchange = '';
 		      }

                   if ($rsfformfield->fld_formfieldronly == 1) {
                      $readonly = ".setAttribute('readOnly','true')";
                    }
	           else {
                      $readonly = ".readonly = 'true'";

                   }
		    $value_dsc = '';
		    if ($valuesf > 0) {
		      $value_dsc = number_format($valuesf,0,'.',',');
		    }
		   $onchange_num = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onkeyup','javascript:formatNumber(this)');";
		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'text';
		    el" . $rsfformfield->fld_formfieldnm . ".readonly = 'true';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '_dsc';
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '_dsc';
		   el" . $rsfformfield->fld_formfieldnm . ".setAttribute('size'," . $rsfformfield->fld_formfieldwidth . "-7);
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfielddval . "';
		   el" . $rsfformfield->fld_formfieldnm . ".className = '" . $classsf . "';
		   " . $onchange . $onchange_num . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'hidden';
		    el" . $rsfformfield->fld_formfieldnm . ".readonly = 'true';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfielddval . "';
		   " . $onchange . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		    break;



		    case "date":
		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'text';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".size = 8;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $value . "';
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		  var img = document.createElement('IMG');
		  img.setAttribute('src', '" . base_url() ."images/calendar.jpg');
		  img.setAttribute('height', '14px');
		  img.setAttribute('border', 0);
		  img.className = 'selectorButton';
		  newlink = document.createElement('a');
		  newlink.id = id= '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "-trigger'+ iteration;
		  newlink.setAttribute('href', 'javascript:void(0)');
		  newlink.appendChild(img);
		  cell" . $rsfformfield->fld_formfieldnm . ".appendChild(newlink);
		  Calendar.setup({
		  dateFormat : '%d-%m-%Y',
                  showTime   : 'True',
		  trigger    : '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "-trigger'+ iteration,
		  inputField : '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm ."'+ iteration ,
		  onSelect   : function() { this.hide() }
		  });
		   ";
		    break;


                 case "datetime":
                   $js .="
                   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
                   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
                   el" . $rsfformfield->fld_formfieldnm . ".type = 'text';
                   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
                   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
                   el" . $rsfformfield->fld_formfieldnm . ".size = 13;
                   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $value . "';
                   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

                  var img = document.createElement('IMG');
                  img.setAttribute('src', '" . base_url() ."images/calendar.jpg');
                  img.setAttribute('height', '14px');
                  img.setAttribute('border', 0);
                  img.className = 'selectorButton';
                  newlink = document.createElement('a');
                  newlink.id = id= '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "-trigger'+ iteration;
                  newlink.setAttribute('href', 'javascript:void(0)');
                  newlink.appendChild(img);
                  cell" . $rsfformfield->fld_formfieldnm . ".appendChild(newlink);
                  Calendar.setup({
                  dateFormat : '%Y-%m-%d %H:%M',
                  showTime   : 'True',
                  trigger    : '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "-trigger'+ iteration,
                  inputField : '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm ."'+ iteration ,
                  onSelect   : function() { this.hide() }
                  });
                   ";
                    break;


		case "dropdown":
		$opt = '';
		$queryid = $rsfformfield->fld_queryid;
		$gbind = $this->view->getbind($queryid);
		$dbind = array();
		if (isset($gbind)) {
		  foreach ($gbind as $rbind) {
		     $bindname = $rbind->fld_querybindnm;
		     $bindval =  $rbind->fld_querybindval;
		      if (eregi('^!',$bindval))
		      {

			$bindval = substr($bindval,1);
			$bindval =  $this->session->userdata($bindval);
		      }
		      if ($this->input->get($bindname))
		      {
		    $bindval =  $this->input->get($bindname);
		      }
		     $dbind [] =  $bindval;
		  }
		}

		    $fld_querysql = $rsfformfield->fld_querysql;
		    $gopt = $this->db->query($fld_querysql,$dbind);
		    if ($gopt->num_rows() > 0)
		    {
		      $lopt = $gopt->result();
		    }
		      foreach ($lopt as $ropt)
		    {
		      $opt .= "var objOption = document.createElement('OPTION');
		   objOption.text='" . $ropt->name . "';
		   objOption.value='" . $ropt->id . "';
		   el" . $rsfformfield->fld_formfieldnm . " .options.add(objOption);";

		    }
		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('SELECT');
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfieldval . "';
		   el" . $rsfformfield->fld_formfieldnm . ".width = '" . $rsfformfield->fld_formfieldwidth . "';
		   var objOption = document.createElement('OPTION');
		   objOption.text='[--Pilih--]';
		   objOption.value= '';
		   el" . $rsfformfield->fld_formfieldnm . " .options.add(objOption);
		   " . $opt . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		    break;

		   case "bolean":
		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('SELECT');
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfieldval . "';
		   var objOption = document.createElement('OPTION');
		   objOption.text='Yes';
		   objOption.value= '1';
		   el" . $rsfformfield->fld_formfieldnm . " .options.add(objOption);
		   var objOption = document.createElement('OPTION');
		   objOption.text='No';
		   objOption.value= '0';
		   el" . $rsfformfield->fld_formfieldnm . " .options.add(objOption);
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		    break;

		   case "checkbox";
		     $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'checkbox';
		    el" . $rsfformfield->fld_formfieldnm . $readonly . ";
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . 1 . "';
		    el" . $rsfformfield->fld_formfieldnm . ".className = '" . $classsf . "';
		   " . $onchange . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   ";
		    break;

		    case "lookup":
		    $fld_querysql = $rsfformfield->fld_querysql . " having id = '$valuesf'";
		    $gbind = $this->view->getbind($rsfformfield->fld_queryid);
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
			  $bindval = "%";
			  $ctbind = $ctbind +1;
			  ${'bindfield' . $ctbind} = $bindname;
			
			}

			if ($this->input->get($bindname)) {
			  $bindval =  $this->input->get($bindname);
			}
		      $dbind [] =  $bindval;
		    
		      }

		    }

		    $query = $this->db->query($fld_querysql,$dbind);
		    $lquery = $query->row();
		    $value_dsc = $lquery->name;

		   $onchange = "el" . $rsfformfield->fld_formfieldnm . ".setAttribute('onchange','popup_selector" . "(document.getElementById(\'" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm  . "' + iteration + '_dsc" . "\').value,\'" . base_url() . "\',\'" . $rsfformfield->fld_querynm . "\',\'" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '\',\'$bindfield1\',\'$bindfield2\',\'$bindfield3\',\'$bindfield4\',\'$bindfield5\')')";

		   $js .="
		   var cell" . $rsfformfield->fld_formfieldnm . " = row.insertCell($no);
		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'text';
		    el" . $rsfformfield->fld_formfieldnm . ".readonly = 'true';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '_dsc';
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '_dsc';
		   el" . $rsfformfield->fld_formfieldnm . ".setAttribute('size'," . $rsfformfield->fld_formfieldwidth . "-7);
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfielddval . "';
		   el" . $rsfformfield->fld_formfieldnm . ".className = '" . $classsf . "';
		   " . $onchange . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		   var el" . $rsfformfield->fld_formfieldnm . " = document.createElement('input');
		   el" . $rsfformfield->fld_formfieldnm . ".type = 'hidden';
		    el" . $rsfformfield->fld_formfieldnm . ".readonly = 'true';
		   el" . $rsfformfield->fld_formfieldnm . ".name = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".id = '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration;
		   el" . $rsfformfield->fld_formfieldnm . ".value = '" . $rsfformfield->fld_formfielddval . "';
		   " . $onchange . "
		   cell" . $rsfformfield->fld_formfieldnm . ".appendChild(el" . $rsfformfield->fld_formfieldnm . ");

		    var img = document.createElement('IMG');
		  img.setAttribute('src', '" . base_url() ."images/filefind.png');
		  img.setAttribute('height', '14px');
		  img.setAttribute('border', 0);
		  newlink = document.createElement('a');
		  newlink.id = id= '" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "-trigger';
		  newlink.setAttribute('href', 'javascript:void(0)');
		  newlink.setAttribute('onClick', 'popup_selector" . "(document.getElementById(\'" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm  . "' + iteration + '_dsc" . "\').value,\'" . base_url() . "\',\'" . $rsfformfield->fld_querynm . "\',\'" . $rsubform->fld_formnm . $rsfformfield->fld_formfieldnm . "' + iteration + '\',\'$bindfield1\',\'$bindfield2\',\'$bindfield3\',\'$bindfield4\',\'$bindfield5\')');
		  newlink.appendChild(img);
		  cell" . $rsfformfield->fld_formfieldnm . ".appendChild(newlink);

		   ";
		    break;


	      }
	}
    }

$js .="}
	  </script>
      ";
echo $js;
}
### Subfrom Mode HTML
else {
  $relfldp = $rsubform->fld_formrelp;
  $relfldc = $rsubform->fld_formrelc;
  $pkey = $rsubform->fld_fld_tblpkey;
  $sftblnm = $rsubform->fld_tblnm;
  echo "<div id='" . $rsubform->fld_formlbl . "' class='tabcontent'>";

  ### Ambil data yang sudah diinput
  $gbind = $this->view->getbind($rsubform->fld_queryid);
    $dbind = array();
    if (count($gbind) > 0) {
      foreach ($gbind as $rbind) {
        $bindname = $rbind->fld_querybindnm;
        $bindval =  $rbind->fld_querybindval;
        if (preg_match('/^!/',$bindval)) {
          $bindval = substr($bindval,1);
          $bindval =  $this->session->userdata($bindval);
        }
        if (substr($bindval,0,4) == 'fld_') {
          $bindval =  $rffval->$bindval;
        }
        $dbind [] =  $bindval;
      }
    }
  $sfgvcol = $this->view->getviewcol($rsubform->fld_querysql,$dbind);
  $sffvquery = $rsubform->fld_querysql;
  $sfgvrs =  $this->view->getviewrs($sffvquery,0,100,$dbind,'','','');
  echo '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="' . $rsubform->fld_formid . '">';
  echo '<tr height="10" bgcolor="#CDCBBF" align="center">';
  echo '<td align="center" nowrap>No</td>';
  $ordindex = 0;
  foreach ($sfgvcol as $rsfgvcol) {
    $ordindex = $ordindex + 1;
    $pieces = explode("|", $rsfgvcol);
    $obj1 = $pieces[0];
    $obj2 = (isset($pieces[1])) ? $pieces[1] : '';
    if ($obj1 == 'crud') {
      echo '<td width="20"><a href="' . base_url() . 'index.php/page/form/' . $rsubform->fld_formnm . '/add/?' . $relfldc . '=' . $rffval->$relfldp . '&sf=1' . '"><img src="' . base_url() . 'images/application_add.png" width="14" height="14" border=0 ></a></td>';
    } else {
      echo '<td align="center" nowrap>' . $obj1 . ' </td>';
    }
  }
  echo '</tr>';  

  foreach ($sfgvrs as $rsfgvrs) {
    $no=$no+1;
    if ($no % 2 == 1) {
      $bgcolor="#FFFFFF";
    } else {
      $bgcolor="#F5F5F5";
    }
    echo '<tr bgcolor="' . $bgcolor . '">';
    echo '<td width="20">' . $no . '</td>';    
    foreach ($sfgvcol as $rsfgvcol) {
      $pieces = explode("|", $rsfgvcol);
      $obj1 = $pieces[0];
      $obj2 = (isset($pieces[1])) ? $pieces[1] : '';
      if ($obj1 == 'crud') {
        echo '<td align="center" width="30" nowrap>';
        echo '<a href="' . base_url() . 'index.php/page/form/' . $rsubform->fld_viewnm . '/edit/' . $rsfgvrs->$rsfgvcol . '?sf=1' . '"><img src="' . base_url() . 'images/application_edit.png" width="14" height="14" border=0 title="Edit Record"></a>';
    echo '<a href="' . base_url() . 'index.php/page/delete_process/' . $rsubform->fld_viewnm . '/' . $rsfgvrs->$rsfgvcol .'" onclick= "return confirm(\' Are you sure want to delete this record ? \')"><img src="' . base_url() . 'images/application_delete.png" width="14" height="14" border=0  title="Delete Record"></a>';

	echo '</td>';
      } 
      else if ($obj2 == 'price') {
        echo '<td align="right" nowrap>' . number_format($rsfgvrs->$rsfgvcol,2,',','.') . '</td>';
      } else {
        echo '<td nowrap align="' . $obj2 . '">' . $rsfgvrs->$rsfgvcol . '</td>';
      }
    }
  }
  echo "</div>";
}
?>

</tr>
</table>

<?
echo "</div>";
}

### FORM VIEW
foreach ($formview as $rformview) {
$relform = $rformview->fld_formrelid;
$relview = $rformview->fld_viewrelid;
$node = (isset($rffval->$relform)) ? $rffval->$relform : '' ;
$relformval = (isset($rffval->$relform)) ? $rffval->$relform : '' ;
echo "<div id='" . $rformview->fld_formviewnm . "' class='tabcontent'>";
### Ambil data yang sudah diinput
      $gbind = $this->view->getbind($rformview->fld_queryid);
      $dbind = array();
      if (count($gbind) > 0) {
	foreach ($gbind as $rbind) {
	  $bindname = $rbind->fld_querybindnm;
	  $bindval =  $rbind->fld_querybindval;
	  if (preg_match('/^!/',$bindval)) {
	    $bindval = substr($bindval,1);
	    $bindval =  $this->session->userdata($bindval);
	  }
	  if (substr($bindval,0,4) == 'fld_') {
	    $bindval =  $rffval->$bindval;
	  }
	  $dbind [] =  $bindval;
	}
}
$fvgvcol = $this->view->getviewcol($rformview->fld_querysql,$dbind);
$url =  base_url();
$vquery = str_replace("base_url/",$url,$rformview->fld_querysql);
$fvquery = $vquery;
$fvgvrs =  $this->view->getviewrs($fvquery,0,10000,$dbind,'','','');
if($rformview->fld_viewtmpl == "") {
  echo '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="' . $rsubform->fld_formid . '">';
  echo '<tr height="10" bgcolor="#CDCBBF" align="center">';
  echo '<td nowrap width="30">No</td>';
  $ordindex = 0;
  foreach ($fvgvcol as $rfvgvcol) {
    $ordindex = $ordindex + 1;
    $pieces = explode("|", $rfvgvcol);
    $obj1 = $pieces[0];
    $obj2 = (isset($pieces[1])) ? $pieces[1] : '';
    if ($obj1 == 'crud'){
      if ($rformview->fld_viewcreate == 1) {	
        echo '<td nowrap><a href="' . base_url() .  'index.php/page/form/' . $rformview->fld_viewnm . '/add?' . $relview . '=' . $node . '&sf=1"><img src="' . base_url() . 'images/application_add.png" width="14" height="14" border=0 title="Add New Record" ></a></td>';
      } else {
        echo '<td nowrap>&nbsp;</td>';
      }
    } else {
      echo '<td align="center" nowrap>' . $obj1 . ' </td>';
    }
  }
  echo '</tr>';
  $nox=0;
  foreach ($fvgvrs as $rfvgvrs) {
    $nox=$nox+1;
    if ($no % 2 == 1) {
      $bgcolor="#FFFFFF";
    } else {
      $bgcolor="#F5F5F5";
    }
    echo '<tr bgcolor="' . $bgcolor . '">';
    echo '<td width="20">' . $nox . '</td>';

    foreach ($fvgvcol as $rfvgvcol){
      $pieces = explode("|", $rfvgvcol);
      $obj1 = $pieces[0];
      $obj2 = (isset($pieces[1])) ? $pieces[1] : '';
	if ($obj2 == 'price')
	{
	    echo '<td align="right" nowrap>' . number_format($rfvgvrs->$rfvgvcol,2,',','.') . '</td>';
	}
	else
	{
	    echo '<td nowrap align="' . $obj2 . '">' . $rfvgvrs->$rfvgvcol . '</td>';
	}
    }

  }

?>
</tr>
<tr>

</tr>
</table>
<?
}
else {
include ("template/view/" . $rformview->fld_viewtmpl . ".php");
}
echo "</div>";
}
### End Of Form View
echo "</div>";
echo "</div>";
}

?>
