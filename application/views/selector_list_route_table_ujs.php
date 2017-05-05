<html>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/css.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/dropdown-menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menubar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/aqtree3clickable.css" media="screen" />
<script language="JavaScript" src="<?=base_url()?>javascript/main.js"></script>
<head>
<script language="javascript">
	function sendValue(s,k,h,m,n,mx,nx,orn,ur,cr,uc,cc) {
 	var selvalue=s.value;
 	var selvalue1=k.value;
		var selvalue1A=h.value;
		var selvalue2=m.value;
		var selvalue3=n.value;
		var selvalue2A=mx.value;
		var selvalue3A=nx.value;
		var selvalue4=orn.value;
		var selvalue5=ur.value;
		var selvalue6=cr.value;
		var selvalue7=uc.value;
		var selvalue8=cc.value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
        window.opener.document.getElementById('fld_btp27').value = selvalue2A;
        window.opener.document.getElementById('fld_btp27_dsc').value = selvalue2;
        window.opener.document.getElementById('fld_btp21').value = selvalue3A;
        window.opener.document.getElementById('fld_btp21_dsc').value = selvalue3;
        window.opener.document.getElementById('fld_btp39').value = selvalue4+"         /"+selvalue5+"/"+selvalue6; //+"/"+selvalue7+"/"+selvalue8;
	window.close();
	}

	function pgoto(page) {
	var pg = page;
	document.getElementById("currentpage").value= pg;
	var ind = document.getElementById("order").value;
	document.forms["spar"].submit();
	};
</script>
</head>
<form name="filter" action='selector'>
<?
  foreach($this->input->get() as $key => $value) {  
    if (substr($key,0,7) == 'bindval' && $value != '999') {
      echo "<input type='hidden' name='$key' id='$key' value='$value'>";
    }
  }
?>
<fieldset>
<legend><b>Filter</b></legend>
<table>
  <tr>
      <td><input type="text" name="val" id="val" value="<?=$val?>"></td>
      <input type="hidden" name="ffname" id="ffname" value="<?=$ffname?>">
      <input type="hidden" name="qname" id="qname" value="<?=$qname?>">
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><input type="submit" value="Search"></td>
  </tr>
</table>
</fieldset>
</form>

<form name='spar' id='spar' action='selector'>
<?
  foreach($this->input->get() as $key => $value) {  
    if (substr($key,0,7) == 'bindval' && $value != '999') {
      echo "<input type='hidden' name='$key' id='$key' value='$value'>";
    }
  }
?>
<input type="hidden" name="order" id="order">
<input type="hidden" name="sorting" id="sorting">
<input type="hidden" name="currentpage" id="currentpage">
<input type="hidden" name="val" id="val" value="<?=$val?>">
<input type="hidden" name="ffname" id="ffname" value="<?=$ffname?>">
<input type="hidden" name="qname" id="qname" value="<?=$qname?>">
<table cellpadding="1" cellspacing="1" width="100%">
<?
if (count($viewrs) == 1) {
?>
<input type="hidden" name="ckauto" id="ckauto" value="1">
<?
}
?>
<tr height="10" bgcolor="#CDCBBF" align="center">
    <td width="20" >No</td>
    <td nowrap >ID</td>
    <td width="200" >Name</td>
    <td width="100" >Armada</td>
    <td width="50" >U B H</td>
    <td width="50" >U M</td>
    <td width="50" >Origin</td>
    <td width="50" >UJSM</td>
    <td width="50" >UJSA</td>
    <td width="50" >TRK</td>
    <td width="50" >CLUS</td>
    <td width="60" >&nbsp;</td>

  </tr>
<?
if (count($viewrs) == 0) {
?>
<script>
  window.opener.document.getElementById('<?=$ffname?>').value = '';
  window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = '';
	window.opener.document.getElementById('fld_btp27').value = '';
	window.opener.document.getElementById('fld_btp27_dsc').value = '';
	window.opener.document.getElementById('fld_btp21').value = '';
	window.opener.document.getElementById('fld_btp21_dsc').value = '';
        window.opener.document.getElementById('fld_btp39').value = '';
</script>
<tr >
<td class="txt2Bold" colspan=3>No Search Found </td>
</tr>
<?
}
?>
 <?
$no = '';
$no=$no+$offset;

foreach ($viewrs as $rviewrs)
{
$no=$no+1;
?>
  <tr bgcolor="#D4DCE8">
<input type="hidden" name="id<?echo $no;?>" id="id<?echo $no;?>" value="<? echo $rviewrs->id; ?>">
<input type="hidden" name="name<?echo $no;?>" id="name<?echo $no;?>" value="<? echo $rviewrs->name; ?>">
<input type="hidden" name="armada<?echo $no;?>" id="armada<?echo $no;?>" value="<? echo $rviewrs->armada; ?>">
<input type="hidden" name="UBH<?echo $no;?>" id="UBH<?echo $no;?>" value="<? echo $rviewrs->UBH; ?>">
<input type="hidden" name="UM<?echo $no;?>" id="UM<?echo $no;?>" value="<? echo $rviewrs->UM; ?>">
<input type="hidden" name="UBHA<?echo $no;?>" id="UBHA<?echo $no;?>" value="<? echo $rviewrs->UBHA; ?>">
<input type="hidden" name="UMA<?echo $no;?>" id="UMA<?echo $no;?>" value="<? echo $rviewrs->UMA; ?>">
<input type="hidden" name="origin<?echo $no;?>" id="origin<?echo $no;?>" value="<? echo $rviewrs->origin; ?>">
<input type="hidden" name="UJSM<?echo $no;?>" id="UJSM<?echo $no;?>" value="<? echo $rviewrs->UJSM; ?>">
<input type="hidden" name="UJSA<?echo $no;?>" id="UJSA<?echo $no;?>" value="<? echo $rviewrs->UJSA; ?>">
<input type="hidden" name="TRK<?echo $no;?>" id="TRK<?echo $no;?>" value="<? echo $rviewrs->TRK; ?>">
<input type="hidden" name="CLUS<?echo $no;?>" id="CLUS<?echo $no;?>" value="<? echo $rviewrs->CLUS; ?>">
    <td class="txt2black"><? echo $no ;?></td>
    <td class="txt2black"><? echo $rviewrs->id; ?></td>
    <td class="txt2black"><? echo $rviewrs->name; ?></td>
    <td align='center'class="txt2black"><? echo $rviewrs->armada; ?></td>
    <td align='right' class="txt2black"><? echo $rviewrs->UBH; ?></td>
    <td align='right' class="txt2black"><? echo $rviewrs->UM; ?></td>
    <td align='center'class="txt2black"><? echo $rviewrs->origin; ?></td>
    <td align='right' class="txt2black"><? echo number_format($rviewrs->UJSM*100,'2',',','.') . "%"; ?></td>
    <td align='right' class="txt2black"><? echo number_format($rviewrs->UJSA*100,'2',',','.') . "%"; ?></td>
    <td align='right' class="txt2black"><? echo $rviewrs->TRK; ?></td>
    <td align='right' class="txt2black"><? echo $rviewrs->CLUS; ?></td>
    <td align='center'><a href="javascript:void(1)" 
	onclick="sendValue(id<?echo $no;?>,name<?echo $no;?>,armada<?echo $no;?>,UBH<?echo $no;?>,UM<?echo $no;?>,UBHA<?echo $no;?>,UMA<?echo $no;?>,origin<?echo $no;?>,UJSM<?echo $no;?>,UJSA<?echo $no;?>,TRK<?echo $no;?>,CLUS<?echo $no;?>);">>></a></td>
    </tr>
<?} ?>
<script language="javascript">
  window.opener.document.getElementById('<?=$ffname?>').value = '';
  window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = '';
	window.opener.document.getElementById('fld_btp27').value = '0';
	window.opener.document.getElementById('fld_btp27_dsc').value = '0';
	window.opener.document.getElementById('fld_btp21').value = '0';
	window.opener.document.getElementById('fld_btp21_dsc').value = '0';
        window.opener.document.getElementById('fld_btp39').value = '';
if (document.getElementById('ckauto').value == "1") {

   	var selvalue=document.getElementById('id1').value;
    	var selvalue1=document.getElementById('name1').value;
		var selvalue2=document.getElementById('UBH1').value;
		var selvalue3=document.getElementById('UM1').value;
		var selvalue2A=document.getElementById('UBHA1').value;
		var selvalue3A=document.getElementById('UMA1').value;
		var selvalue4=document.getElementById('origin1').value;
		var selvalue5=document.getElementById('UJSM1').value;
		var selvalue6=document.getElementById('UJSA1').value;
		var selvalue7=document.getElementById('TRK1').value;
		var selvalue8=document.getElementById('CLUS1').value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
        window.opener.document.getElementById('fld_btp27').value = selvalue2A;
        window.opener.document.getElementById('fld_btp27_dsc').value = selvalue2;
        window.opener.document.getElementById('fld_btp21').value = selvalue3A;
        window.opener.document.getElementById('fld_btp21_dsc').value = selvalue3;
        window.opener.document.getElementById('fld_btp39').value = selvalue4+"         /"+selvalue5+"/"+selvalue6; //+"/"+selvalue7+"/"+selvalue8;
 	window.close();

	}
</script>
</table>
</form>
<div align=center>
<?
echo "Total Record = " . $numrows . "<br>";
/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show shck links
if ($currentpage > 1) {
   // show << link to go shck to page 1
   echo "  <a href=javascript:pgoto(1)><<</a>";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go shck to 1 page
   echo " <a href=javascript:pgoto($prevpage)><</a> ";
} // end if

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
         echo " <a href=javascript:pgoto($x)>$x</a>";
      } // end else
   } // end if
} // end for

// if not on last page, show forward and last page links
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page
   echo " <a href=javascript:pgoto($nextpage)>></a> ";
   // echo forward link for lastpage
    echo " <a href=javascript:pgoto($totalpages)>>></a> ";
} // end if
?>
</div>
<br>
</html>
