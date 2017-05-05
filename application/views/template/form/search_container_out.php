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
<form name="78000RECEIVE_ITEM" method='get' id="78000RECEIVE_ITEM" action="../../view/78000CONTAINER_OST">
<input type="hidden" name="search" value="search" />
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
  
    <td style="border-bottom: solid 1px white">DO Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>

	   <input type="text" name="fld_btnoreff" id="fld_btnoreff" maxlength="100" size="0" class="default" />  </td>
    
  </tr>

      <tr>
    <td style="border-bottom: solid 1px white">Kode Prinsipal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>

	   <input type="text" name="fld_btprincipal" value="" id="fld_btprincipal" maxlength="100" size="0" class="default" />  </td>
    
  </tr>
 
   
  
    <tr>
    <td style="border-bottom: solid 1px white">Container Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <!-- <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>-->
    <td>
	   <input type="text" name="fld_btcontnum" value="" id="fld_btcontnum" maxlength="100" class="inputBox1"  />  </td>

</table>
<br>
<input type="submit" name="submit" class="BtnBlue" value="Search" id='submit'>
<input type="reset" name="back" class="BtnGrey" value="Reset">

</body>
</html>
