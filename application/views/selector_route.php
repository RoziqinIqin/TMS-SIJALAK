<html>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/css.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/dropdown-menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menubar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/aqtree3clickable.css" media="screen" />
<script language="JavaScript" src="<?=base_url()?>javascript/main.js"></script>
<head>
<script language="javascript">
	function sendValue(s,k) {
 	var selvalue=s.value;
 	var selvalue1=k.value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
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
    <td width="100" >From</td>
    <td width="270" >To</td>
    <td width="60" >&nbsp;</td>

  </tr>
<?
if (count($viewrs) == 0) {
?>
<script>
  window.opener.document.getElementById('<?=$ffname?>').value = '';
  window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = '';
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
    <td class="txt2black"><? echo $no ;?></td>
    <td class="txt2black"><? echo $rviewrs->id; ?></td>
    <td class="txt2black"><? echo $rviewrs->name; ?></td>
    <td class="txt2black"><? echo $rviewrs->To; ?></td>
    <td align='center'><a href="javascript:void(1)" onclick="sendValue(id<?echo $no;?>,name<?echo $no;?>);">>></a></td>
    </tr>
  <?} ?>
<script language="javascript">
if (document.getElementById('ckauto').value == "1") {

   	var selvalue=document.getElementById('id1').value;
    	var selvalue1=document.getElementById('name1').value;
	window.opener.document.getElementById('<?=$ffname?>').value = selvalue;
	window.opener.document.getElementById('<?=$ffname?>' + '_dsc').value = selvalue1;
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
