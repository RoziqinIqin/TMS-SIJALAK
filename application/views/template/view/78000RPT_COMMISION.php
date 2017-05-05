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

<form>
<table cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>Driver</td>
    <td nowrap>Status</td>
    <td nowrap>Vehicle Type</td>
    <td nowrap>Vehicle Number</td>
    <td nowrap>DO Return Date </td>
    <td nowrap>DO Number</td>
    <td nowrap>Customer</td>
    <td nowrap>Origin</td>
    <td nowrap>Destination</td>
    <td nowrap>Commission</td>
    <td nowrap>Stand By Allowance</td>
    <td nowrap>Total</td>
    </tr>
   </tr>
<?
 ### Get total holiday in salary periode
    $gholiday = $this->db->query("select fld_holidaydt from hris.tbl_holiday where date_format(fld_holidaydt,'%Y-%m') = '$fld_periode'"); 
    $gholiday = $gholiday->result();
    $holidayList = array();
    foreach ($gholiday as $rholiday) {
      $holidayList [] = $rholiday->fld_holidaydt;
    }
    ####

    $days_in_month = date('t',strtotime($fld_periode));
    $firstday = $fld_periode . '-' . '1' ;
    $lastday = $fld_periode . '-' . $days_in_month ;
    $fld_btdtsa = strtotime($fld_btdtsap);
    $fld_btdtso = strtotime($fld_btdtsop);
    $firstday = strtotime($firstday);
    $lastday = strtotime($lastday);
    $days = abs(($lastday -  $firstday) / 86400) + 1;

foreach ($viewrs as $rviewrs) {
  $driver_group[] = $rviewrs->Driver;
}
$driver = array_unique($driver_group);
foreach ($driver as $rdriver) {
  ${"count" . $rdriver} = 0;
echo "<tr bgcolor='#CDCBBF'>";
echo "<td colspan=13<b>$rdriver</b></td>";
echo "</tr>";

  foreach ($viewrs as $rviewrs) {
    if ($rviewrs->Driver == $rdriver) {
    $commission = 0;
    $standby = 0;
    $kpi = 0;
    ### Komisi untuk Car Carrier
    if($rviewrs->VehicleGroup ==  2) {
      if($rviewrs->DriverStatus == 'Partner'){
        $commission = $rviewrs->load_qty * $rviewrs->commission1 ;
      }
      if($rviewrs->DriverStatus == 'Employee'){
        $commission = $rviewrs->load_qty * $rviewrs->commission1 ;
      }
    }
   
   ### Uang standy
  if ($commission == 0) {
    if($rviewrs->VehicleGroup ==  2) { ## Car Carrier
      if($rviewrs->DriverStatus == 'Partner'){
        $standby = $rviewrs->standby2 ;
      }
     if($rviewrs->DriverStatus == 'Employee'){
       $standby = $rviewrs->standby1 ;
      }
    }

   }
   

    $no=$no+1;
    if ($no % 2 == 1)
    {
    $bgcolor="#FFFFFF";
     }
   else
    {
    $bgcolor="#F5F5F5";
     }
   $total =$commission + $standby ;


    echo "<tr bgcolor=$bgcolor>";
    echo "<td>" .  $rviewrs->Driver . "</td>";
    echo "<td>$rviewrs->DriverStatus</td>";
    echo "<td>$rviewrs->Vehicle</td>";
    echo "<td>$rviewrs->TruckNumber</td>";
    echo "<td>$rviewrs->Date</td>";
    echo "<td>" . $rviewrs->fld_btno . "</td>";
    echo "<td>" . $rviewrs->Customer . "</td>";
    echo "<td>" . $rviewrs->Origin . "</td>";
    echo "<td>" . $rviewrs->Destination . "</td>";
    echo "<td>" . number_format($commission,2,',','.') . "</td>";
    echo "<td>" . number_format($standby,2,',','.') . "</td>";
    echo "<td>" . number_format($total,2,',','.') . "</td>";
    echo "<td>" . $rviewrs->swh_time . "</td>";
    echo "</tr>";
    ${"count" . $rdriver} = ${"count" . $rdriver} + 1;
    ${"swh_time" . $rdriver} = ${"swh_time" . $rdriver} + $commission;
   ${"breakdown" . $rdriver} = ${"breakdown" . $rdriver} +$meal_allowence;
    ${"tat" . $rdriver} = ${"tat" . $rdriver} + $total;
  }
    

  }
    $sub_kpi = ( ${"kpi_ok" . $rdriver} / ${"count" . $rdriver}) * 100;
    echo "<tr bgcolor='green'>";
    echo "<td colspan=5> <b>" .  "Total " . "</b></td>";
    echo "<td align='right'> <b>" .   ${"count" . $rdriver} . "</b></td>";
    echo "<td colspan=3> </td>";
    echo "<td align='right'> <b>" .  number_format( ${"swh_time" . $rdriver},0,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"breakdown" . $rdriver},0,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"tat" . $rdriver},0,',','.')  . "</b></td>";
  #  echo "<td align='right'> <b>" .  number_format( ${"tat" . $rdriver} / ${"swh_time" . $rdriver}  * 100 ,0,',','.')  . " %</b></td>";
    echo "</tr>";

}

?>
</table>
<div  style="color:#000000">
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
</form>
