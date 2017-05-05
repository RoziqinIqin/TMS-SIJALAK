<br>
<?
?>
<html>
<script language="javascript">
   function validate(f) {
	var err="";
	var cmfadr = window.confirm('Apakah anda akan melanjutkan proses input data ?')
  	if (cmfadr == false) {
           err="error";
           return false;
        }
	if (err == ""){
           document.POS.action="<?=base_url();?>index.php/page/form_process";
           return true;
        }

    }
</script>
<body OnLoad="document.POS.fld_btamt01.focus();">
<form name="POS" method='post' id="POS" onSubmit="return validate(this)">
<fieldset>
<legend><b>Payment</b></legend>
<div>
<table align='left'>
  <tr>
      <input type="hidden" name="fld_bttyid" id="fld_bttyid" value="16">
      <input type="hidden" name="fld_baido" id="fld_baido" value="1">
       <input type="hidden" name="fld_baidp" id="fld_baidp" value="<?=$userid?>">
      <input type="hidden" name="fld_btno" id="fld_btno" value="[AUTO]">
      <input type="hidden" name="fld_btdt" id="fld_btdt" value="<? echo date('Y-m-d h:m:i');?>">
      <input type="hidden" name="fid" value="69" />
      <input type="hidden" name="fnm" value="78000PAYMENT_RETAIL_POS" />
      <td>Date</td>
      <td>:</td>
      <td><? echo date('d-m-Y');?></td>
  </tr>
</table>
</div>
</fieldset>
<br>
<fieldset>
<div>
<table align='right'>
  <tr>
      <td>Cash</td>
      <td>:</td>
      <td align="right"><input type='text' name='fld_btamt01' id='fld_btamt01' class="txtTotal_Price" align="right" onchange="getChange()"></td>
  </tr>
</table>
</div>
<br>
</fieldset>
<div align="left">
<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="tblMobilMasuk">
<tr>
<!-- Sales Detail -->
<td width="50%" height="200" valign="top">
<fieldset>
<legend><b>Detail Penjualan</b></legend>
<table height = "200">
  <tr>
    <input type="hidden" name="fld_btidr" id="fld_btidr" value = "<?=$fld_btidr?>">
     <input type="hidden" name="fld_btstat" id="fld_btstat" value = "2">
    <td>Total Penjualan</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt01a" id="fld_btamt01a" value = "<?=$fld_btamts?>" readonly>
  </tr>
  <tr>
    <td>Pajak Penjualan</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt01a" id="fld_btamt01a" value = "<?=$tax?>" readonly>
  </tr>
 <!-- <tr>
    <td>Round</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt01a" id="fld_btamt01a" >
  </tr>-->
  <tr>
    <td>Total Harga Penjualan</td>
    <td>:</td>
    <td><input type="text" name="fld_btamts" id="fld_btamts" value = "<?=$ttl?>" class="txtTotal_Price" readonly>
  </tr>
</table>
</fieldset>
</td>
<!--  -->
<td>
<!-- Sales Detail -->
<td width="50%" height="200" valign="top">
<fieldset>
<legend><b>Detail Pembayaran</b></legend>
<table height = "200">
  <tr>
    <td>Credit Card Receive</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt02" id="fld_btamt02" value="0" onchange="getChange()">
  </tr>
    <tr>
    <td>Credit Card Number</td>
    <td>:</td>
    <td><input type="text" name="fld_btp01" id="fld_btp01" >
  </tr>
    <tr>
    <td>Cash Receive</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt04" id="fld_btamt04" readonly>
  </tr>
  <tr>
    <td>Cash Change</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt03" id="fld_btamt03" readonly>
  </tr>
  <tr>
    <td>Total Payment</td>
    <td>:</td>
    <td><input type="text" name="fld_btamt" id="fld_btamt" readonly>
  </tr>
  </table>
</fieldset>
</td>
<!--  -->
</td>
</tr>
</table>
</div>
<div align ="right">
<input type="submit" name="submit" value="Add">
</div>
<br>
</form>
</body>
</html>