<html>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/css.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/dropdown-menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menubar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/aqtree3clickable.css" media="screen" />
<script language="JavaScript" src="<?=base_url()?>javascript/main.js"></script>
<head>
<script language="javascript">
	function sendValue(s,k,m,n,p) {
 	var selvalue=s.value;
 	var selvalue1=k.value;
 	var selvalue2=m.value;
		var selvalue3=n.value;
		var selvalue4=p.value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
        window.opener.document.getElementById('fld_baidot').value = selvalue2;
        window.opener.document.getElementById('fld_btidp').value = selvalue3;
        window.opener.document.getElementById('fld_btidp_dsc').value = selvalue4;
//        window.opener.document.getElementById('fld_baidot_dsc').value = selvalue1>;
		window.opener.document.getElementById('fld_btp11').value = '';
		window.opener.document.getElementById('fld_btp11_dsc').value = '';
		window.opener.document.getElementById('fld_btp12').value = '';
		window.opener.document.getElementById('fld_btp12_dsc').value = '';
		window.opener.document.getElementById('fld_btp27').value = '';
		window.opener.document.getElementById('fld_btp27_dsc').value = '';
		window.opener.document.getElementById('fld_btp21').value = '';
		window.opener.document.getElementById('fld_btp21_dsc').value = '';
		window.opener.document.getElementById('fld_btp28').value = '';
		window.opener.document.getElementById('fld_btp28_dsc').value = '';
		window.opener.document.getElementById('fld_btuamt').value = '';
		window.opener.document.getElementById('fld_btuamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp32').value = '';
		window.opener.document.getElementById('fld_btp32_dsc').value = '';
		window.opener.document.getElementById('fld_btamt').value = '';
		window.opener.document.getElementById('fld_btamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp09').value = '';
		window.opener.document.getElementById('fld_btp09_dsc').value = '';
		window.opener.document.getElementById('fld_btp18').value = '';
		window.opener.document.getElementById('fld_btp18_dsc').value = '';
		window.opener.document.getElementById('fld_btp39').value = '';
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
    <td width="370" >Name</td>
    <td width="15" >Type</td>
    <td width="15" >Proyek</td>
    <td width="60" >&nbsp;</td>

  </tr>
<?
if (count($viewrs) == 0) {
?>
<script>
  window.opener.document.getElementById('<?=$ffname?>').value = '';
  window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = '';
  window.opener.document.getElementById('fld_baidot').value = '';
  window.opener.document.getElementById('fld_btflag').value = '';
  window.opener.document.getElementById('fld_btflag_dsc').value = '';
  window.opener.document.getElementById('fld_btp26').value = '';
  window.opener.document.getElementById('fld_btp26_dsc').value = '';
  window.opener.document.getElementById('fld_btp36').value = '0';
  window.opener.document.getElementById('fld_btp36_dsc').value = '0';
  window.opener.document.getElementById('fld_btp37').value = '0';
  window.opener.document.getElementById('fld_btp37_dsc').value = '0';
  window.opener.document.getElementById('fld_btidp').value = '';
  window.opener.document.getElementById('fld_btidp_dsc').value = '';
//  window.opener.document.getElementById('fld_baidot_dsc').value = '';
		window.opener.document.getElementById('fld_btp11').value = '';
		window.opener.document.getElementById('fld_btp11_dsc').value = '';
		window.opener.document.getElementById('fld_btp12').value = '';
		window.opener.document.getElementById('fld_btp12_dsc').value = '';
		window.opener.document.getElementById('fld_btp27').value = '';
		window.opener.document.getElementById('fld_btp27_dsc').value = '';
		window.opener.document.getElementById('fld_btp21').value = '';
		window.opener.document.getElementById('fld_btp21_dsc').value = '';
		window.opener.document.getElementById('fld_btp28').value = '';
		window.opener.document.getElementById('fld_btp28_dsc').value = '';
		window.opener.document.getElementById('fld_btuamt').value = '';
		window.opener.document.getElementById('fld_btuamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp32').value = '';
		window.opener.document.getElementById('fld_btp32_dsc').value = '';
		window.opener.document.getElementById('fld_btamt').value = '';
		window.opener.document.getElementById('fld_btamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp09').value = '';
		window.opener.document.getElementById('fld_btp09_dsc').value = '';
		window.opener.document.getElementById('fld_btp18').value = '';
		window.opener.document.getElementById('fld_btp18_dsc').value = '';
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
<input type="hidden" name="ty<?echo $no;?>" id="ty<?echo $no;?>" value="<? echo $rviewrs->ty; ?>">
<input type="hidden" name="prid<?echo $no;?>" id="prid<?echo $no;?>" value="<? echo $rviewrs->prid; ?>">
<input type="hidden" name="prnm<?echo $no;?>" id="prnm<?echo $no;?>" value="<? echo $rviewrs->prnm; ?>">
    <td class="txt2black"><? echo $no ;?></td>
    <td class="txt2black"><? echo $rviewrs->id; ?></td>
    <td class="txt2black"><? echo $rviewrs->name; ?></td>
    <td class="txt2black"><? echo $rviewrs->ty; ?></td>
    <td class="txt2black"><? echo $rviewrs->prnm; ?></td>
    <td align='center'><a href="javascript:void(1)" onclick="sendValue(id<?echo $no;?>,name<?echo $no;?>,ty<?echo $no;?>,prid<?echo $no;?>,prnm<?echo $no;?>);">>></a></td>
    </tr>
  <?} ?>
<script language="javascript">
  window.opener.document.getElementById('fld_baidot').value = '';
  window.opener.document.getElementById('fld_btflag').value = '';
  window.opener.document.getElementById('fld_btflag_dsc').value = '';
  window.opener.document.getElementById('fld_btp26').value = '';
  window.opener.document.getElementById('fld_btp26_dsc').value = '';
  window.opener.document.getElementById('fld_btp36').value = '0';
  window.opener.document.getElementById('fld_btp36_dsc').value = '0';
  window.opener.document.getElementById('fld_btp37').value = '0';
  window.opener.document.getElementById('fld_btp37_dsc').value = '0';
  window.opener.document.getElementById('fld_btidp').value = '';
  window.opener.document.getElementById('fld_btidp_dsc').value = '';
if (document.getElementById('ckauto').value == "1") {

   	var selvalue=document.getElementById('id1').value;
    	var selvalue1=document.getElementById('name1').value;
    	var selvalue2=document.getElementById('ty1').value;
    	var selvalue3=document.getElementById('prid1').value;
    	var selvalue4=document.getElementById('prnm1').value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
        window.opener.document.getElementById('fld_baidot').value = selvalue2;
		  if (selvalue3 != "") {
			  window.opener.document.getElementById('fld_btidp').value = selvalue3;
			  window.opener.document.getElementById('fld_btidp_dsc').value = selvalue4;
		  }
//        window.opener.document.getElementById('fld_baidot_dsc').value = selvalue1;
		window.opener.document.getElementById('fld_btp11').value = '';
		window.opener.document.getElementById('fld_btp11_dsc').value = '';
		window.opener.document.getElementById('fld_btp12').value = '';
		window.opener.document.getElementById('fld_btp12_dsc').value = '';
		window.opener.document.getElementById('fld_btp27').value = '';
		window.opener.document.getElementById('fld_btp27_dsc').value = '';
		window.opener.document.getElementById('fld_btp21').value = '';
		window.opener.document.getElementById('fld_btp21_dsc').value = '';
		window.opener.document.getElementById('fld_btp28').value = '';
		window.opener.document.getElementById('fld_btp28_dsc').value = '';
		window.opener.document.getElementById('fld_btuamt').value = '';
		window.opener.document.getElementById('fld_btuamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp32').value = '';
		window.opener.document.getElementById('fld_btp32_dsc').value = '';
		window.opener.document.getElementById('fld_btamt').value = '';
		window.opener.document.getElementById('fld_btamt_dsc').value = '';
		window.opener.document.getElementById('fld_btp09').value = '';
		window.opener.document.getElementById('fld_btp09_dsc').value = '';
		window.opener.document.getElementById('fld_btp18').value = '';
		window.opener.document.getElementById('fld_btp18_dsc').value = '';
		window.opener.document.getElementById('fld_btp39').value = '';
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
