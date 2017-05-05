<br>
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
<body OnLoad="document.POS.fld_btiid1_dsc.focus();">
<form name="POS" method='post' id="POS" onSubmit="return validate(this)">
<fieldset>
<legend><b>Sales Detail</b></legend>
<div>
<table align='left'>
  <tr>
      <input type="hidden" name="fld_bttyid" id="fld_bttyid" value="15">
      <input type="hidden" name="fld_baido" id="fld_baido" value="1">
      <input type="hidden" name="fld_btstat" id="fld_btstat" value = "2">
      <input type="hidden" name="fld_baidp" id="fld_baidp" value="<?=$userid?>">
      <input type="hidden" name="fld_btno" id="fld_btno" value="[AUTO]">
      <input type="hidden" name="fld_btdt" id="fld_btdt" value="<? echo date('Y-m-d h:m:i');?>">
      <input type="hidden" name="fid" value="65" />
      <input type="hidden" name="fnm" value="78000SALES_RETAIL" />
      <td>Date</td>
      <td>:</td>
      <td><? echo date('d-m-Y');?></td>
  </tr>
</table>
</div>
</fieldset>
<br>
<fieldset>
<legend><b>Sales Item</b>
<div>
<table align='right'>
  <tr>
      <td>Total Harga</td>
      <td>:</td>
      <td align="right"><input type='text' name='fld_btamt01_dsc' id='fld_btamt01_dsc' class="txtTotal_Price" align="right"><input type='hidden' name='fld_btamt01' id='fld_btamt01' class="txtTotal_Price" align="right"><input type='hidden' name='fld_btamt02' id='fld_btamt02' class="txtTotal_Price" align="right"><input type='hidden' name='fld_btamt' id='fld_btamt' class="txtTotal_Price" align="right"></td>
  </tr>
</table>
</div>
<br>
</fieldset>
<div align="left">
<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="1" width="100%" id="tblMobilMasuk">
<tr height="10" bgcolor="#CDCBBF" align="center">
<td width="10" class="txt2Bold">No</td>
<td width="100" class="txt2Bold">Product</td>
<td width="250" class="txt2Bold">Description</td>
<td width="30" class="txt2Bold">Qty</td>
<td width="70" class="txt2Bold">Price</td>
<td width="70" class="txt2Bold" align="center">Sub Total</td>
</tr>
<?
for ($i=1;$i<=15; $i++)
	{
?>
<tr>
    <td><? echo $i; ?></td>
    <input type="hidden" name='67Count' id='67Count' value='15'>
    <td><input type="text" name='fld_btiid<? echo $i; ?>_dsc' id='fld_btiid<? echo $i; ?>_dsc' size="30" onChange="popup_selector_pos(document.getElementById('fld_btiid<? echo $i; ?>_dsc').value,'<?echo  base_url();?>','list_item_pos','fld_btiid<?echo  $i;?>',<?echo  $i;?>)"><a href="javascript:void(1)" onclick= "popup_selector_pos(document.getElementById('fld_btiid<? echo $i; ?>_dsc').value,'<?echo  base_url();?>','list_item_pos','fld_btiid<?echo  $i;?>',<?echo  $i;?>)"><img src="<?=base_url()?>/images/filefind.png" width="14" height="14" border="0"></a><input type="hidden" name='fld_btiid<? echo $i; ?>' id='fld_btiid<? echo $i; ?>'></td>
    <td><input type="text" name='description<? echo $i; ?>' id='description<? echo $i; ?>' size="57" readonly></td>
    <td><input type="text" name='fld_btqty01<? echo $i; ?>' id='fld_btqty01<? echo $i; ?>' size="5" onChange="pos_sub_total(<? echo $i; ?>)"></td>
    <td><input type="text" name='fld_btuamt<? echo $i; ?>' id='fld_btuamt<? echo $i; ?>' size="10" readonly></td>
    <td><input type="text" name='fld_btamt01<? echo $i; ?>' id='fld_btamt01<? echo $i; ?>' size="10"   readonly></td>
</tr>
<?
}
?>
</table>
</div>
<div align ="right">
<input type="submit" name="submit" value="Add">
</div>
<br>
</form>
</body>
</html>