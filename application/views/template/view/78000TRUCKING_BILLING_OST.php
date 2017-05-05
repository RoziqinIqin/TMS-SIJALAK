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

<form method='post' action='<?=base_url();?>index.php/page/truckBilling' onsubmit="return confirm('Do you really want to submit the form?');">
<br>
<input type='submit' value='Create Billing'>
<br>

<table cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>No</td>
    <td nowrap>&nbsp;</td>
    <td nowrap>DO Number</td>
    <td nowrap>DO Date</td>
    <td nowrap>Customer</td>
    <td nowrap>Route</td>
    <td nowrap>Fleet Type</td>
    <td nowrap>Vehicle Number</td>
    <td nowrap>Driver</td>
    <td nowrap>Container Number</td>
    <td nowrap>Selling Price</td>
    <td nowrap>B/L Number</td>
   </tr>
   </tr>
<?
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
    echo "<td>" .  $no . "<input type='hidden' name='count' id='count' value='$no'></td>";
    echo "<td><input type='checkbox' name='rowdata$no' id='rowdata$no'></td>";
    echo "<td>" .  $rviewrs->fld_btno . "<input type='hidden' name='fld_btno$no' id='fld_btno$no' value='$rviewrs->fld_btno'></td>";
    echo "<td>$rviewrs->fld_btdt</td>";
    echo "<td>$rviewrs->Customer<input type='hidden' name='fld_btp02$no' id='fld_btp02$no' value='$rviewrs->Customer'></td>";
    echo "<td>$rviewrs->route</td>";
    echo "<td>" . 'Trailer' . "</td>";
    echo "<td>" . $rviewrs->VehicleNo . "</td>";
    echo "<td>" . $rviewrs->Driver . "</td>";
    echo "<td>$rviewrs->ContainerNo<input type='hidden' name='fld_container$no' id='fld_container$no' value='$rviewrs->ContainerNo'></td>";
    echo "<td><input type='text' name='fld_btamt$no' id='fld_btamt$no'></td>";
    echo "<td><input type='text' name='fld_btp01$no' id='fld_btp01$no'></td>";
    echo "</tr>";
    

  }

?>
</table>
<br>
<br>
<br>
</form>
