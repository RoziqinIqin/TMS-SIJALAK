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
  <tr bgcolor="#F5C972" align="center">
    <td><b>Vehicle Number</b></td>
    <td><b>Type</b></td>
    <td><b>Brand</b></td>
    <td><b>Year Of Made</b></td>
    <td><b>Chasis Number</b></td>
    <td><b>Engine Number</b></td>
    </tr>
<?
### Prepare Data
$dtsa = ($_GET['dtsa'] == '') ? '%' : $_GET['dtsa'];
$dtso = ($_GET['dtso'] == '') ? '%' : $_GET['dtso'];
$vehicle = ($_GET['vehicle'] == '') ? '%' : $_GET['vehicle'];
$type = ($_GET['Type'] == '')? '%':$_GET['Type'];

$service = $this->db->query("select t0.fld_btid,t1.fld_bticd,t0.fld_btno,t1.fld_btiid,
		            date_format(t0.fld_btdt,'%Y-%m-%d') 'wo_date',
			    t0.fld_btp05 'driver',
                            t0.fld_btp01 'km',
                            t3.fld_btinm 'job_name',
                            t5.fld_empnm 'mechanic'
                            from 
                            tbl_bth t0 
			    left join tbl_bti t1 on t1.fld_btiid = t0.fld_baidc
                            left join tbl_btd_wo_job t2 on t2.fld_btidp=t0.fld_btid
                            left join tbl_bti t3 on t3.fld_btiid=t2.fld_btiid  
                            left join tbl_btd_wo_mechanic t4 on t4.fld_btiid=t2.fld_btiid and t4.fld_btidp=t0.fld_btid
                            left join hris.tbl_emp t5 on t5.fld_empid=t4.fld_baidc
			    where
                            t0.fld_bttyid IN (4,18)
                            and
                            if('$dtsa' = '%',date_format(t0.fld_btdt,'%Y-%m') = date_format(now(),'%Y-%m'),date_format(t0.fld_btdt,'%Y-%m-%d') 
                            between  date_format('$dtsa','%Y-%m-%d') and date_format('$dtso','%Y-%m-%d') )
                           # and
                           # if ('$vehicle' = '%',1,t1.fld_bticd like '$vehicle')
                            # and
                           # if ('$Type' = '%',1,t1.fld_bticd like '$Type')");
$expense = $this->db->query("select t0.fld_btiid, t2.fld_bticd 'part_code', if(t2.fld_btiid=2742,concat(t2.fld_btinm,' : ',t0.fld_btcmt),
                                                                            if(t2.fld_btiid=1972,concat(t2.fld_btinm,' : ',t0.fld_btcmt),t2.fld_btinm))'part_name',
                             t1.fld_baidc,t0.fld_btqty01 'qty',
                             date_format(t1.fld_btdt,'%Y-%m-%d') 'date', 
			     if(t4.fld_bttyid=10,'WO Part Request',if(t4.fld_bttyid=19,'Direct Part Request','Unknown Part Request')) 'remark'
			     from tbl_btd_wo_part t0
                             left join tbl_bth t1 on t1.fld_btid=t0.fld_btidp
                             left join tbl_bti t2 on t2.fld_btiid=t0.fld_btiid
                             left join tbl_btr t3 on t3.fld_btrdst=t1.fld_btid
			     left join tbl_bth t4 on t4.fld_btid=t3.fld_btrsrc
			     where t1.fld_bttyid=6 
                             and 
                             if('$dtsa' = '%',date_format(t1.fld_btdt,'%Y-%m') = date_format(now(),'%Y-%m'),date_format(t1.fld_btdt,'%Y-%m-%d') 
                             between  date_format('$dtsa','%Y-%m-%d') and date_format('$dtso','%Y-%m-%d') )

                            ");




  foreach ($viewrs as $rviewrs) {
    $no=$no+1;
    $count_job = 0;
    $count_expense = 0;
    if ($no % 2 == 1) {
      $bgcolor="#FFFFFF";
    } else {
      $bgcolor="#F5F5F5";
    }
    foreach ($service->result() as $rservice) {
      if ($rservice->fld_btiid == $rviewrs->fld_btiid) {
        $count_job = $count_job + 1;
      }
    }

   foreach ($expense->result() as $rexpense) {
      if ($rexpense->fld_baidc == $rviewrs->fld_btiid) {
        $count_expense = $count_expense + 1;
      }
    }

    if ($count_job > 0 || $count_expense > 0) {
    echo "<tr bgcolor='#F5C972'>";
    echo "<td><b>" .  $rviewrs->fld_bticd . "</b></td>";
    echo "<td><b>$rviewrs->Type</b></td>";
    echo "<td><b>$rviewrs->Brand</b></td>";
    echo "<td><b>" . $rviewrs->fld_btip03 . "</b></td>";
    echo "<td><b>" . $rviewrs->fld_btinm . "</b></td>";
    echo "<td><b>" . $rviewrs->fld_btip01 . "</b></td>";
    echo "</tr>";
    echo "<tr  bgcolor='E89C84'>";
    echo "<td colspan=6 align='center'><b>Service History</b></td>";
    echo "</tr>";
    echo "<tr bgcolor='E89C84'>";
    echo "<td><b>Wo Number</b></td>";
    echo "<td><b>Wo Date</b></td>";
    echo "<td><b>Km</b></td>";
    echo "<td><b>Driver</b></td>";
    echo "<td><b>Job Name</b></td>";
    echo "<td><b>Mechanic</b></td>";
    echo "<tr bgcolor='#FFFFFF'>";
    foreach ($service->result() as $rservice) {
      if ($rservice->fld_btiid == $rviewrs->fld_btiid) {
        echo "<tr bgcolor='#FFFFFF'>";
        echo "<td>" .  $rservice->fld_btno . "</td>";
        echo "<td>" .  $rservice->wo_date . "</td>";
        echo "<td>" .  $rservice->km . "</td>";
        echo "<td>" .  $rservice->driver . "</td>";
        echo "<td>" .  $rservice->job_name . "</td>";
        echo "<td>" .  $rservice->mechanic . "</td>";
        echo "</tr>";
      }
    }

   ###Expense History
    echo "<tr  bgcolor='EAB06E'>";
    echo "<td colspan=6 align='center'><b>Expense History</b></td>";
    echo "</tr>";
    echo "<tr bgcolor='EAB06E'>";
    echo "<td><b>Spare Part Code</td>";
    echo "<td><b>Spare Part Name</td>";
    echo "<td><b>Qty</td>";
    echo "<td><b>Date</td>";
    echo "<td><b>Price</td>";
    echo "<td><b>Remark</td>";
    echo "<tr bgcolor='#FFFFFF'>";
    foreach ($expense->result() as $rexpense) {
      if ($rexpense->fld_baidc == $rviewrs->fld_btiid) {
        echo "<tr bgcolor='#FFFFFF'>";
        echo "<td>" .  $rexpense->part_code . "</td>";
        echo "<td>" .  $rexpense->part_name . "</td>";
        echo "<td>" .  $rexpense->qty . "</td>";
        echo "<td>" .  $rexpense->date . "</td>";
        echo "<td>" .  $rexpense->price . "</td>";
        echo "<td>" .  $rexpense->remark . "</td>";
        echo "</tr>";
      }
    }
     
     echo "<tr bgcolor='green'>";
     echo "<td colspan=6 >&nbsp;</td>";
     echo "</tr>";


  }
 
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
