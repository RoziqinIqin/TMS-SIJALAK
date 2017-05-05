<?
 $rffval = array();
 if ($mode == 'edit')
      {
	foreach($formfieldval as $rffval):
	endforeach;
	    if (isset($rffval->fld_btstat) && $rffval->fld_btstat == 2)
	    {
		$ro = 1;
	    }
	
	$pieces = explode(" ", $rffval->fld_btcontnum);
	$fld_btcontnum1 = $pieces[0];
	$fld_btcontnum2 = $pieces[1];
      }
?>
<br>
<html>
<body OnLoad="document.this.fld_btcontnum1.focus();">
<form name="<? echo $fld_formnm; ?>" method='post' id="<? echo $fld_formnm; ?>" action="<?=base_url();?>index.php/page/form_process">
<fieldset>
<legend><b>Data Container Masuk</b></legend>
<div>
<table align='left'>
 <tr colspan=10>
      <td>Container Number</td>
      <td>:</td>
      <td><input type="text" size="3" name="fld_btcontnum1" id="fld_btcontnum1" maxlength=4 value="<?=$fld_btcontnum1?>"> <input type="text" size="20" name="fld_btcontnum2" id="fld_btcontnum2" value="<?=$fld_btcontnum2?>"></td>

      <td>Size Type</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btsize" id="fld_btsize" value="<?=$rffval->fld_btsize?>"></td>
  </tr>
 <tr colspan=10>
      <input type="hidden" name="fld_bttyid" id="fld_bttyid" value="17">
       <input type="hidden" name="act" id="act" value="<?=$mode?>">
      <input type="hidden" name="fld_baido" id="fld_baido" value="<? if ($mode == 'add') {echo "1";} else { echo $rffval->fld_baido ;}?>">
      <input type="hidden" name="fld_btno" id="fld_btno" value="<? if ($mode == 'add') {echo "[AUTO]";} else { echo $rffval->fld_btno ;}?>">
      <input type="hidden" name="fid" value="111" />
      <input type="hidden" name="fnm" value="78000CONTAINER_IN" />
      <input type="hidden" name="fld_btid" id="fld_btid" value="<?=$rffval->fld_btid?>">
      <td>Principal</td>
      <td>:</td>
      <td><input type="text" name="fld_btprincipal" id="fld_btprincipal" value="<?=$rffval->fld_btprincipal?>"></td>
      <td>Date In</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdt" id="fld_btdt" value="<? if ($mode == 'add') {echo date('d-m-Y');} else { echo $rffval->fld_btdt ;}?>" readonly></td>
  </tr>
 <tr colspan=10>
      <td>Consignee</td>
      <td>:</td>
      <td><input type="text" size="30" name="fld_btconsigne" id="fld_btconsigne" value="<?=$rffval->fld_btconsigne?>"></td>

      <td>BL - NO</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btblno" id="fld_btblno" value="<?=$rffval->fld_btblno?>"></td>
  </tr>
 <tr colspan=10>
      <td>Voyage</td>
      <td>:</td>
      <td><input type="text" size="30" name="fld_btvoyage" id="fld_btvoyage" value="<?=$rffval->fld_btvoyage?>"></td>

      <td>Voyage Number</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btvoyagenum" id="fld_btvoyagenum" value="<?=$rffval->fld_btvoyagenum?>"></td>

      <td>LOC</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btloc" id="fld_btloc" value="<?=$rffval->fld_btloc?>"></td>
  </tr>
  <tr colspan=10>
      <td>Damage ?</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_btdamage" id="fld_btdamage" value='1' <? if ($rffval->fld_btdamage == 1) {echo 'checked' ;} ?>></td>

      <td>VIP ?</td>
      <td>:</td>
     <td><input type="checkbox" size="30" name="fld_btvip" id="fld_btvip" value='1' <? if ($rffval->fld_btvip == 1) {echo 'checked' ;} ?>></td>

      <td>Sweep ?</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_btsweep" id="fld_btsweep" value='1' <? if ($rffval->fld_btsweep == 1) {echo 'checked' ;} ?>></td>

      <td>Approved</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btapprove" id="fld_btapprove" value="<?=$rffval->fld_btapprove?>"></td>
  </tr>
<tr colspan=10>
      <td>Wash ?</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_btwash" id="fld_btwash" value='1' <? if ($rffval->fld_btwash == 1) {echo 'checked' ;} ?>></td>

      <td>Hold</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_bthold" id="fld_bthold" value='1' <? if ($rffval->fld_bthold == 1) {echo 'checked' ;} ?>></td>

      <td>Chemical</td>
      <td>:</td>
      <td><input type="radio" size="10" name="fld_btchemical" id="fld_btchemical" value='2' <? if ($rffval->fld_btchemical == '2') {echo 'checked' ;} else { echo 'uncheked';}  ?> >Water <input type="radio" size="10" name="fld_btchemical" id="fld_btchemical" value='3'  <? if ($rffval->fld_btchemical == '3') {echo 'checked' ;} else { echo 'uncheked';}  ?>>Deterjen</td>
  </tr>
<tr colspan=10>
      <td>Date Lift Off</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btdtlistoff" id="fld_btdtlistoff" value="<? if ($mode == 'add') {echo date('d-m-Y');} else { echo $rffval->fld_btdtlistoff ;}?>" readonly></td>

      <td>Protech</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_btprotech" id="fld_btprotech" value='1' <? if ($rffval->fld_btprotech == 1) {echo 'checked' ;} ?>></td>

      <td>Date Protech</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btdtprotech" id="fld_btdtprotech" value="<? if ($mode == 'add') {echo date('d-m-Y');} else { echo $rffval->fld_btdtprotech ;}?>" readonly></td>
    
      <td>SP2-DT</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btsp2dt" id="fld_btsp2dt" value="<?=$rffval->fld_btsp2dt?>"></td>

  </tr>
<tr colspan=10>
      <td>Cause Protect</td>
      <td>:</td>
      <td><input type="text" size="50" name="fld_btcause" id="fld_btcause" value="<?=$rffval->fld_btcause?>"></td>

      <td>SSS Damage</td>
      <td>:</td>
      <td><input type="checkbox" size="30" name="fld_btsssdamage" id="fld_btsssdamage" value='1' <? if ($rffval->fld_btsssdamage == 1) {echo 'checked' ;} ?>></td>

      <td>Survey In</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btsurveyin" id="fld_btsurveyin" value="<?=$rffval->fld_btsurveyin?>"></td>
      
      <td>Block</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btblock" id="fld_btblock" value="<?=$rffval->fld_btblock?>"></td>
  </tr>
  <tr colspan=10>
      <td>REM / Action </td>
      <td>:</td>
      <td><input type="text" size="30" name="fld_btrem" id="fld_btrem" value="<?=$rffval->fld_btrem?>"></td>

      <td>User</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btuser" id="fld_btuser" value="<?=$rffval->fld_btuser?>"></td>

  </tr>
  <tr colspan=10>
      <td>OnHir / XRepo</td>
      <td>:</td>
      <td><input type="text" size="30" name="fld_btonhire" id="fld_btonhire" value="<?=$rffval->fld_btonhire?>"></td>

      <td>Repo / Offhire O/R/N</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn" id="fld_btorn" value="<?=$rffval->fld_btorn?>"></td>

      <td>Date</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdtp" id="fld_btdtp" value="<? if ($mode == 'add') {echo date('d-m-Y');} else { echo $rffval->fld_btdtp ;}?>" readonly></td>
  </tr>
</table>
</div>
</fieldset>
<br>
<fieldset>
<legend><b>Data Container keluar</b></legend>
<div>
<table align='left'>
  <tr colspan=10>
      <td>Date Out</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Shipper</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

      <td>Out</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdt" id="fld_btdt" value="<? echo date('d-m-Y');?>" readonly></td>
  </tr>
  <tr colspan=10>
      <td>Do - No</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Vessel</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

  </tr>
 <tr colspan=10>
      <td>Seal - No</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>D.Lift On</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

      <td>Survey Out</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdt" id="fld_btdt" value="<? echo date('d-m-Y');?>" readonly></td>
  </tr>
 <tr colspan=10>
      <td>Kade</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Remark Out</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

  </tr>
 <tr colspan=10>
      <td>Port</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Cetak</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

      <td>No. Truck</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdt" id="fld_btdt" value="<? echo date('d-m-Y');?>" readonly></td>
  </tr>
<tr colspan=10>
      <td>Fumigasi</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Temp</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>

      <td>Vent</td>
      <td>:</td>
      <td><input size='8' type="text" name="fld_btdt" id="fld_btdt" value="<? echo date('d-m-Y');?>" readonly></td>

      <td>User</td>
      <td>:</td>
      <td><input type="text" size="8" name="fld_btonhire12" id="fld_btonhire12" readonly></td>

      <td>Time</td>
      <td>:</td>
      <td><input type="text" size="10" name="fld_btorn12" id="fld_btorn12" readonly></td>
  </tr>
</table>
</div>
</fieldset>
<br>
</div>
</form>
</body>
</html>