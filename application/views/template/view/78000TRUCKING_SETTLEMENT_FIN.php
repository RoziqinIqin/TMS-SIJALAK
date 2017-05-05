<?
foreach($viewdata as $rvdata):
endforeach;
$headerrs = $viewrs;
$header = array_shift($headerrs);
$fld_periode = $header->periode;
?>
<script>
var ovp = new Object();
var covp = null;

function hideParBox() {
	window.document.getElementById("parbox").style.visibility="hidden";
	};
function pgoto(page) {
	var pg = page;
	document.getElementById("currentpage").value= pg;
	document.forms["spar"].submit();
	};
function order(ind,sorting) {
	document.getElementById("order").value= ind;
	document.getElementById("sorting").value= sorting;
	document.forms["spar"].submit();
	};
function showParBox() {
	var lb = window.document.getElementById('parbox');
	var ls = lb;
	if (ls.style) { ls = ls.style; };

	var nx = window.document.body.scrollWidth>=0?window.document.body.scrollWidth:window.pageWidth;
	var ww = lb.scrollWidth>=0?lb.scrollWidth:lb.pageWidth;
	var wx = nx/2 - ww/2;

	var ny = window.document.body.scrollHeight>=0?window.document.body.scrollHeight:window.pageHeight;
	var wh = lb.scrollHeight>=0?lb.scrollHeight:lb.pageHeight;
	var wy = ny/2 - wh/2;

	var noPx = window.document.childNodes ? 'px' : 0;

	ls.left = wx+noPx;


	ls.visibility='visible';
	};
	</script>

<div id=parbox class=parbox>
<table class=parbox cellpadding=4 cellspacing=0>
	<tr class=parbox>
		<td align=left class=parbox>
			<b>Search Parameter</b>
			</td>
		<td align=right class=parbox>
			<a href=javascript:hideParBox()>Hide</a>
			</td>
		</tr>
	<tr>
		<td class=parboxsep colspan=2><?  include ("search_view.php"); ?></td>
		</tr>
	</table>
</div>
<?
echo "<form name='spar' id='spar' method='get' action='" . $rvdata->fld_viewnm . "'>";
if (isset($formfield)) {
foreach($formfield as $rff):
echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" value="' . $this->input->get($rff->fld_formfieldnm) . '">';
endforeach;
}
echo '<input type="hidden" name="currentpage" id="currentpage">';
echo '<input type="hidden" name="order" id="order" value="' . $order . '">';
echo '<input type="hidden" name="sorting" id="sorting" value="' . $sorting . '">';
echo "</form>";
?>

<form method='post' action='<?=base_url();?>index.php/page/truckingSettlement' onsubmit="return confirm('Are you sure want to process this Item(s)?');">
<br>
<input type='submit' value='Process Settlement'>
<br>

<table cellpadding="1" cellspacing="1" width="100%">
  <input type='hidden' name='node' id='node' value='<?=$this->uri->segment(4);?>'>
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>No</td>
    <td nowrap>&nbsp;</td>
    <td nowrap>Settlement Number</td>
    <td nowrap>Settlement Date</td>
    <td nowrap>Vehicle Group</td>
    <td nowrap>Periode</td>
    <td nowrap>Total Amount</td>
    <td nowrap>Posted By</td>
   </tr>
   </tr>
<?
  $number = "Posting Number";
  $date = "Posting Date";
  $vehicle = "Vehicle Group";
  $posted = "Posted By";
  $total = "Total Amount|price";
  foreach ($viewrs as $rviewrs) {
    
    $kpi_obj = ($tat <= $tat_obj) ? 'Achived' : 'Failed'; 


    $no=$no+1;
    if ($no % 2 == 1)
    {
    $bgcolor="#FFFFFF";
}
else
{
    $bgcolor="#F5F5F5";
}

    echo "<tr bgcolor=$bgcolor>";
    echo "<td>" .  $no . "<input type='hidden' name='count' id='count' value='$no'><input type='hidden' name='fld_btid$no' id='fld_btid$no' value='$rviewrs->crud'></td>";
    echo "<td><input type='checkbox' name='rowdata$no' id='rowdata$no'></td>";
    echo "<td>" .  $rviewrs->$number . "<input type='hidden' name='fld_btno$no' id='fld_btno$no' value='" . $rviewrs->$number . "'></td>";
    echo "<td nowrap>" . $rviewrs->$date . "</td>";
    echo "<td>" .  $rviewrs->$vehicle . "<input type='hidden' name='fld_bedivid$no' id='fld_bedivid$no' value='" . $rviewrs->fld_bedivid . "'></td>";
    echo "<td nowrap>$rviewrs->Periode<input type='hidden' name='fld_btdesc$no' id='fld_btdesc$no' value='$rviewrs->Item'></td>";
    echo "<td nowrap align='right'>" .  number_format($rviewrs->$total,0,',','.') . "<input type='hidden' name='fld_btdesc$no' id='fld_btdesc$no' value='$rviewrs->Item'></td>";
    echo "<td nowrap>" . $rviewrs->$posted. "<input type='hidden' name='fld_btdesc$no' id='fld_btdesc$no' value='$rviewrs->Item'></td>";
    echo "</tr>";
    

  }

?>
</table>
<br>
<br>
<br>
</form>
