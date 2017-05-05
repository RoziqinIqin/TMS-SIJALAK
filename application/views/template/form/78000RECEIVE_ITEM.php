<br>
<?
$fld_btnoreff = $this->input->get('fld_btnoreff');

?>
<html>
<head>
<script language="javascript">
   function validate(f) {
	var fnm = f.name;
	var sbm = document.getElementById('submit').value;
        var err="";
	if (sbm == 'Save') {
	var cmfadr = window.confirm('Apakah anda akan melanjutkan proses update data ?')
	}
	else if (sbm == 'Copy') {
	var cmfadr = window.confirm('Apakah anda akan melanjutkan proses copy data ?')
	}
	else {
	var cmfadr = window.confirm('Apakah anda akan melanjutkan proses input data ?')
	}
  	if (cmfadr == false) {
           err="error";
           return false;
        }
var x = document.getElementsByTagName('input');
for (i = 0; i < x.length; i++) {
 if (x[i].className == 'mandatory') {
  if (x[i].value == ""){
  alert("Data yang anda masukkan belum lengkap");
  x[i].focus();
  err="error";
  return false;
  }
}
}
        if (err == ""){

           document[fnm].action="<?=base_url();?>/index.php/page/form_process";
           return true;
        }
    }
</script>
</head>
<form name="78000RECEIVE_ITEM" method='post' id="78000RECEIVE_ITEM" onSubmit="return validate(this)">
<input type="hidden" name="fid" value="38" />
<input type="hidden" name="fnm" value="78000RECEIVE_ITEM" />

<table border="0" cellspacing="0" cellpadding="0">
  
 
    <input type="hidden" name="fld_baido" value="3" />  </td>
    
  </tr>
 
      <tr>
    <td style="border-bottom: solid 1px white">ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>
	   <input type="text" name="fld_btid" value="" id="fld_btid" maxlength="100" size="0" class="inputBox1" readonly="1"  />  </td>

    
  </tr>
 
      <tr>
    <td style="border-bottom: solid 1px white">Transaction Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>
	   <select name="fld_btstat">
<option value="0">[--Pilih--]</option>
<option value="1" selected="selected">New</option>

<option value="2">Approve</option>
<option value="3">Cancel</option>
</select>  </td>
    
  </tr>
 
      <tr>
    <td style="border-bottom: solid 1px white">PO Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>

	   <input type="text" name="fld_btnoreff" value="<? echo $fld_btnoreff; ?>" id="fld_btnoreff" maxlength="100" size="0" class="default" readonly="1"  />  </td>
    
  </tr>

      <tr>
    <td style="border-bottom: solid 1px white">Transaction Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>

	   <input type="text" name="fld_btno" value="" id="fld_btno" maxlength="100" size="0" class="default" readonly="1"  />  </td>
    
  </tr>
 
      <tr>
    <td style="border-bottom: solid 1px white"><span style="color: rgb(255, 0, 0);">*</span>Supplier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>
	   <select name="fld_baid1">

<option value="0">[--Pilih--]</option>
<option value="1">PT Jaya Mandiri</option>
<option value="2">CV Andalan Keluarga</option>
</select>  </td>
    
  </tr>
 
      <tr>
    <td style="border-bottom: solid 1px white">Transaction Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->

    <td>
	   <input type="text" name="fld_btdt" value="" id="fld_btdt" maxlength="15" size="7" class="inputBox1"  /><a href="javascript:void(0)"  id="fld_btdt-trigger" ><img src="http://localhost/akuntansi//images/calendar.jpg" width="14" height="14" border="0"></a><script>
		    Calendar.setup({
		    dateFormat : "%Y-%m-%d",
		    trigger    : "fld_btdt-trigger",
		    inputField : "fld_btdt",
		    onSelect   : function() { this.hide() }
		    });
		    </script>  </td>
    
  </tr>
 
    <tr>
    <td style="border-bottom: solid 1px white">Memo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>
	   <input type="text" name="fld_btdesc" value="" id="fld_btdesc" maxlength="100" size="60" class="inputBox1"  />  </td>

    
  </tr>
 
    <input type="hidden" name="fld_bttyid" value="8" />  </td>
    
  </tr>
  
</table>
<br>
<input type="submit" name="submit" class="BtnBlue" value="Add" id='submit'>
<input type="button" name="back" class="BtnGrey" value="Back" id='backback' onclick='javascript: history.go(-1)'>
			    <!-- Sub Form -->
<div id='ddtabs' class='basictab'><ul><li><a href='javascript:void(0)' onClick='expandcontent("Detail Purchase Item", this)'>Detail Purchase Item</a></li></ul></div><div class='ddcolortabsline'>&nbsp;</div><div style='width: 100%; height: 100%; overflow-y: scroll; scrollbar-arrow-color:
blue;'>
<DIV id=''><div id='Detail Purchase Item' class='tabcontent'><table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="39"><tr height="10" bgcolor="#CDCBBF" align="center"><td><a href="javascript:addRow78000RECEIVE_ITEM()"><img src="http://localhost/akuntansi/images/application_add.png" width="14" height="14" border=0 ></a></td><td align="center">ID</td><td align="center">Item</td><td align="center">Unit Amount</td><td align="center">Qty</td><td align="center">Outstanding</td><td align="center">Amount</td></tr>

<input type="hidden" name="39Count" id="39Count">
<tr>

	 <script>
	    function addRow78000RECEIVE_ITEM(){
	    var tbl = document.getElementById('39');
	    var lastRow = tbl.rows.length;
	    lastRow = lastRow - 1;
	    var iteration = lastRow;
	    var row = tbl.insertRow(lastRow);
	    document.getElementById('39Count').value = iteration;
	    var cellLeft = row.insertCell(0);
	    var textNode = document.createTextNode(iteration);
	    cellLeft.appendChild(textNode);
	   
       
		   var cellfld_btid = row.insertCell(1);
		   var elfld_btid = document.createElement('input');
		   elfld_btid.type = 'text';
		    elfld_btid.readonly = 'true';
		   elfld_btid.name = 'fld_btid' + iteration;
		   elfld_btid.id = '78000RECEIVE_ITEMfld_btid' + iteration;
		   elfld_btid.size = 15;
		   elfld_btid.value = '';
		   elfld_btid.setAttribute('onchange','javascript:change(\'Detail Purchase Item\',' + iteration + ',\'78000RECEIVE_ITEM\')');
		   cellfld_btid.appendChild(elfld_btid);	
		   
		    
		   var cellfld_btiid = row.insertCell(2);
		   var elfld_btiid = document.createElement('SELECT');
		   elfld_btiid.name = 'fld_btiid' + iteration;
		   elfld_btiid.id = '78000RECEIVE_ITEMfld_btiid' + iteration;
		   elfld_btiid.value = '';
		   var objOption = document.createElement('OPTION');
		   objOption.text='Pilih';
		   objOption.value= '';
		   elfld_btiid .options.add(objOption);
		   var objOption = document.createElement('OPTION');
		   objOption.text='Rak Buku Olympic M300';
		   objOption.value='1';
		   elfld_btiid .options.add(objOption);var objOption = document.createElement('OPTION');
		   objOption.text='Buku tulis AA 1 Pak 30 lembar';
		   objOption.value='2';
		   elfld_btiid .options.add(objOption);var objOption = document.createElement('OPTION');
		   objOption.text='Harry Potter V The Golden Stone';
		   objOption.value='3';
		   elfld_btiid .options.add(objOption); 
		   cellfld_btiid.appendChild(elfld_btiid);	
		   
		    
		   var cellfld_btuamt = row.insertCell(3);
		   var elfld_btuamt = document.createElement('input');
		   elfld_btuamt.type = 'text';
		    elfld_btuamt.readonly = 'true';
		   elfld_btuamt.name = 'fld_btuamt' + iteration;
		   elfld_btuamt.id = '78000RECEIVE_ITEMfld_btuamt' + iteration;
		   elfld_btuamt.size = 15;
		   elfld_btuamt.value = '';
		   elfld_btuamt.setAttribute('onchange','javascript:change(\'Detail Purchase Item\',' + iteration + ',\'78000RECEIVE_ITEM\')');
		   cellfld_btuamt.appendChild(elfld_btuamt);	
		   
		    
		   var cellfld_btqty1 = row.insertCell(4);
		   var elfld_btqty1 = document.createElement('input');
		   elfld_btqty1.type = 'text';
		    elfld_btqty1.readonly = 'true';
		   elfld_btqty1.name = 'fld_btqty1' + iteration;
		   elfld_btqty1.id = '78000RECEIVE_ITEMfld_btqty1' + iteration;
		   elfld_btqty1.size = 15;
		   elfld_btqty1.value = '';
		   elfld_btqty1.setAttribute('onchange','javascript:change(\'Detail Purchase Item\',' + iteration + ',\'78000RECEIVE_ITEM\')');
		   cellfld_btqty1.appendChild(elfld_btqty1);	
		   
		    
		   var cellfld_btqty2 = row.insertCell(5);
		   var elfld_btqty2 = document.createElement('input');
		   elfld_btqty2.type = 'text';
		    elfld_btqty2.readonly = 'true';
		   elfld_btqty2.name = 'fld_btqty2' + iteration;
		   elfld_btqty2.id = '78000RECEIVE_ITEMfld_btqty2' + iteration;
		   elfld_btqty2.size = 15;
		   elfld_btqty2.value = '';
		   elfld_btqty2.setAttribute('onchange','javascript:change(\'Detail Purchase Item\',' + iteration + ',\'78000RECEIVE_ITEM\')');
		   cellfld_btqty2.appendChild(elfld_btqty2);	
		   
		    
		   var cellfld_btamt1 = row.insertCell(6);
		   var elfld_btamt1 = document.createElement('input');
		   elfld_btamt1.type = 'text';
		    elfld_btamt1.readonly = 'true';
		   elfld_btamt1.name = 'fld_btamt1' + iteration;
		   elfld_btamt1.id = '78000RECEIVE_ITEMfld_btamt1' + iteration;
		   elfld_btamt1.size = 15;
		   elfld_btamt1.value = '';
		   elfld_btamt1.setAttribute('onchange','javascript:setTotal(document.getElementById(\'39Count\').value,this)');
		   cellfld_btamt1.appendChild(elfld_btamt1);	
		   
		    
		   var elfld_btidp = document.createElement('input');
		   elfld_btidp.type = 'hidden';
		   elfld_btidp.name = 'fld_btidp' + iteration;
		   elfld_btidp.id = '78000RECEIVE_ITEMfld_btidp' + iteration;
		   elfld_btidp.size = 15;
		   
		   elfld_btidp.value = '';
		   cellLeft.appendChild(elfld_btidp);
		   
		   }
	  </script>
      
</tr>
</table>

</div></div></div></form>
<br>
<br>
</html>

</div>
<div id="footerbar" align='center'>copyright 2010</div>

</div>
</body>
</html>
