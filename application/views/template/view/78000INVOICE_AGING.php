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
    <td rowspan=2 >Invoice Number</td>
    <td rowspan=2 >Customer</td>
    <td rowspan=2 >Invoice Date</td>
    <td rowspan=2 >Delivery Date</td>
    <td rowspan=2 >Currency</td>
    <td colspan=2 >Invoice Amount</td>
    <td colspan=2 >Down Payment</td>
    <td colspan=2 >Payment</td>
    <td colspan=2 >Payment Left</td>
    <td rowspan=2 >Aging (Days)</td>

  </tr>
  <tr bgcolor="#CDCBBF" align="center">
    <td >IDR</td>
    <td >US$</td>
    <td >IDR</td>
    <td >US$</td>
    <td >IDR</td>
    <td >US$</td>
    <td >IDR</td>
    <td >US$</td>
 </tr>
<?
  $no = 0;
  $idr = 0;
  $us = 0;

  $payment = $this->db->query("select t1.fld_btflag,t0.fld_btamt01,t0.fld_btreffid,t0.fld_btuamt01 from tbl_btd_finance t0 
			      left join tbl_bth t1 on t1.fld_btid=t0.fld_btidp
			      where t1.fld_bttyid = 43 and t1.fld_btstat=3");  
 
  foreach ($viewrs as $rviewrs) {
    $tot_payment_idr = 0;
    $tot_dp_idr = 0;
    $tot_payment_usd = 0;
    $tot_dp_usd = 0;

    foreach ($payment->result() as $rpayment) {
      if($rpayment->fld_btreffid == $rviewrs->fld_btid) {
        if($rpayment->fld_btflag == 1) {
          $tot_payment_idr = $tot_payment_idr + $rpayment->fld_btamt01;
          $tot_dp_idr = $tot_dp_idr + $rpayment->fld_btuamt01;
        }
        else if($rpayment->fld_btflag == 2) {
          $tot_payment_usd = $tot_payment_usd + $rpayment->fld_btamt01;
          $tot_dp_usd = $tot_dp_usd + $rpayment->fld_btuamt01;
        }

      }
    }
    if ($rviewrs->fld_btflag == 1) {
      $tot_balance_idr = $rviewrs->fld_btp04 - ($tot_payment_idr + $tot_dp_idr);
    }
    if ($rviewrs->fld_btflag == 2) {
      $tot_balance_usd = $rviewrs->fld_btp04 - ($tot_payment_usd + $tot_dp_usd);
    }
    if ($tot_balance_idr > 0 || $tot_balance_usd > 0) {
      $no=$no+1;
      $idr = $idr + $rviewrs->IDR;
      $us = $us + $rviewrs->USD;
      $idr1 = $idr1 + $tot_dp_idr;
      $us1 = $us1 + $tot_dp_usd;
      $idr2 = $idr2 + $tot_payment_idr;
      $us2 = $us2 + $tot_payment_usd;
      $idr3 = $idr3 + $tot_balance_idr;
      $us3 = $us3 + $tot_balance_usd;

      if ($no % 2 == 1){
        $bgcolor="#FFFFFF";
      } else {
        $bgcolor="#F5F5F5";
      }
      echo "<tr bgcolor=$bgcolor>";
      echo "<td>" .  $rviewrs->fld_btno . "</td>";
      echo "<td>" .  $rviewrs->Customer . "</td>";
      echo "<td>$rviewrs->fld_btdt</td>";
      echo "<td>$rviewrs->fld_btdtsa</td>";
      echo "<td>$rviewrs->Currency</td>";
      echo "<td align='right'>" . number_format($rviewrs->IDR,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($rviewrs->USD,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_dp_idr,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_dp_usd,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_payment_idr,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_payment_usd,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_balance_idr,2,',','.') . "</td>";
      echo "<td align='right'>" . number_format($tot_balance_usd,2,',','.') . "</td>";
      echo "<td align = 'right'>" . $rviewrs->aging . "</td>";
      echo "</tr>";
      }
    }
    echo "<tr bgcolor='green'>";
    echo "<td colspan=4> <b>" .  "Total Invoice" . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $no,0,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $idr,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $us,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $idr1,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $us1,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $idr2,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $us2,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $idr3,2,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( $us3,2,',','.')  . "</b></td>";
    echo "<td align='right' colspan=4>&nbsp;</td>";
    echo "</tr>";
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
