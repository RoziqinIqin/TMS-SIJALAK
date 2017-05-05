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

<form method='post' action='<?=base_url();?>index.php/page/truckingSetBilling' onsubmit="return confirm('Are you sure want to process this Item(s)?');">
<br>
<input type='submit' value='Update Invoice'>
<br>

<table cellpadding="1" cellspacing="1" width="100%">
  <input type='hidden' name='node' id='node' value='<?=$_GET["node"]?>'>
  <input type='hidden' name='langsir' id='langsir' value='0'>
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>No</td>
    <td nowrap>&nbsp;</td>
    <td nowrap>Nomor SO</td>
    <td nowrap>Nomor POD</td>
    <td nowrap>Nomor Dokumen</td>
    <td nowrap>Tanggal SO</td>
    <td nowrap>Pelanggan</td>
    <td nowrap>Armada</td>
    <td nowrap>Nomor Kendaraan</td>
    <td nowrap>Rute</td>
    <td nowrap>Uang DP</td>
    <td nowrap>Tarif</td>
   </tr>
 <?
  $fld_btid=$_GET["node"];
  $data = $this->db->query("select fld_baidc from tbl_bth where fld_btid = $fld_btid");
  $data = $data->row();
  $fld_baidc = $data->fld_baidc;
  $viewrs = $this->db->query("select 
                              t0.fld_btid 'id',
                              t0.fld_btnoalt 'number',
                              t0.fld_btno 'pod_number',
			      date_format(t0.fld_btdt,'%Y-%m-%d') 'date',t1.fld_benm 'customer',t2.fld_tyvalnm 'vehicle',
			      concat(t4.fld_areanm,' ----> ',t5.fld_areanm) 'route',t0.fld_btp06 'container',
			      t0.fld_btp07 'qty',
			      t7.fld_btiid 'vehicle_id',t7.fld_bticd 'vehicle_no',fld_btbalance, 
			      (t0.fld_btp24 + t0.fld_btp25) 'tarif',
                              (select group_concat(tx0.fld_btp01) from tbl_btd_langsiran tx0 where tx0.fld_btidp=t0.fld_btid) 'dokumen',
                              (select group_concat(DISTINCT(tx1.fld_btdesc)) from tbl_btd_langsiran tx1 where tx1.fld_btidp=t0.fld_btid) 'tujuan',
                              ifnull(t0.fld_btp31,0) 'dp',
                              if(t0.fld_baidv=2,t0.fld_btp24,t0.fld_btp24 + t0.fld_btp25) 'price',
                              t0.fld_btloc
			      from tbl_bth t0
			      left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
			      left join tbl_tyval t2 on t2.fld_tyvalcd=t0.fld_btp26 and t2.fld_tyid=19
                              left join tbl_route t3 on t3.fld_routeid =t0.fld_btp09
			      left join tbl_area t4 on t4.fld_areaid=t3.fld_routefrom
                              left join tbl_area t5 on t5.fld_areaid=t3.fld_routeto
                              left join tbl_trk_billing t6 on t6.fld_btreffid=t0.fld_btid and t6.fld_btflag=1
			      left join tbl_bti t7 on t7.fld_btiid=t0.fld_btp12
			      where 
			      t0.fld_bttyid = 20
			      and
			      t0.fld_btstat = 3
                              and
			      t0.fld_btdt > '2014-07-01 00:00:00'
			      and
			      t0.fld_baidc = $fld_baidc
			      and
                              t0.fld_bttaxno !=1
								and
			      ifnull(t6.fld_btreffid,1) = 1
			      order by t0.fld_btno
			      ");
  $viewrs = $viewrs->result();
  

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
    echo "<td>" .  $no . "<input type='hidden' name='count' id='count' value='$no'><input type='hidden' name='fld_btid$no' id='fld_btid$no' value='$rviewrs->id'></td>";
    echo "<td><input type='checkbox' name='rowdata$no' id='rowdata$no'></td>";
    echo "<td>" .  $rviewrs->number . "<input type='hidden' name='fld_btno$no' id='fld_btno$no' value='" . $rviewrs->number . "'></td>";
    echo "<td>" .  $rviewrs->pod_number . "</td>";
    echo "<td>" .  $rviewrs->dokumen . "<input type='hidden' name='dokumen$no' id='dokumen$no' value='" . $rviewrs->dokumen . "'></td>";
    echo "<td nowrap>" . $rviewrs->date . "</td>";
    echo "<td>" .  $rviewrs->customer . "<input type='hidden' name='route$no' id='route$no' value='" . $rviewrs->route . "'></td>";
    echo "<td nowrap>$rviewrs->vehicle</td>";
    echo "<td nowrap>$rviewrs->vehicle_no <input type='hidden' name='vehicle_no$no' id='vehicle_no$no' value='$rviewrs->vehicle_no' size='10'</td>";
    echo "<td>$rviewrs->route</td>";
    echo "<td>" .  number_format($rviewrs->dp,0,',','.') . "<input type='hidden' name='dp$no' id='dp$no' value='" . $rviewrs->dp . "'></td>";
    echo "<td>" .  number_format($rviewrs->price,0,',','.') . "<input type='hidden' name='price$no' id='price$no' value='" . $rviewrs->price . "'></td>";
    echo "<input type='hidden' name='type$no' id='type$no' value='1'>";
    echo "<input type='hidden' name='lokasi$no' id='lokasi$no' value=" . $rviewrs->fld_btloc . ">";
    echo "</tr>";
    

  }

?>
</table>
<br>
<br>
<br>
</form>
