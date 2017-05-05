<?
foreach($viewdata as $rvdata):
endforeach;
$relfld = "";
$relfldval = "";
if ($rvdata->fld_viewnm=='78000VEHICLE_TRACKING'){
$url=$_SERVER['REQUEST_URI'];
header("Refresh: 60; URL=$url"); 
}
echo '
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
'
?>
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
	ls.left = 0;

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
echo "<html>";
$no = 0;
$no=$no+$offset;
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
#echo '<table cellpadding="1" cellspacing="1" width="100%">';
echo '<table cellpadding="1" cellspacing="1">';
if ($rvdata->fld_viewheader != '') {
echo $rvdata->fld_viewheader;
}
else {
echo '<tr height="10" bgcolor="#CDCBBF" align="center">';
echo '<td nowrap>No</td>';
$ordindex = 0;
foreach ($viewcol as $rviewcol)
     {
	$ordindex = $ordindex + 1;
	$pieces = explode("|", $rviewcol);
	$obj1 = $pieces[0];
	$obj2 = (isset($pieces[1])) ? $pieces[1] : '';
	if ($obj1 == 'crud')
	{
	    if ($rvdata->fld_viewcreate == 1) {	
	      echo '<td nowrap><a href="' . base_url() .  'index.php/page/form/' . $rvdata->fld_viewnm . '/add?' . $relfld . '=' . $relfldval . '"><img src="' . base_url() . 'images/application_add.png" width="14" height="14" border=0 title="Add New Record" ></a></td>';
	    }
	    else {
	      echo '<td nowrap>&nbsp;</td>';
	    }
	}
	else
	{
	    echo '<td align="center" nowrap>' . $obj1 . '  <a href="javascript:order(' . $ordindex . ',\'asc\',this)"><img src="' . base_url() . 'images/arrow_up.gif" width="14" height="14" border=0 title="Sort Ascending"></a><a href="javascript:order(' . $ordindex . ',\'desc\',this)"><img src="' . base_url() . 'images/arrow_down.gif" width="14" height="14" border=0 title="Sort Descending"></a></td>';
	}
    }

echo '</tr>';
}
foreach ($viewrs as $rviewrs)
{
    $no=$no+1;
    if ($no % 2 == 1)
{
    $bgcolor="#FFFFFF";
}
else
{
    $bgcolor="#F5F5F5";
}
echo '<tr bgcolor="' . $bgcolor . '">';
echo '<td width="20">' . $no . '</td>';

foreach ($viewcol as $rviewcol)
     {
	$pieces = explode("|", $rviewcol);
	$obj1 = $pieces[0];
	$obj2 = (isset($pieces[1])) ? $pieces[1] : '';
	if ($obj1 == 'crud')
	{
	    echo '<td align="center" width="30" nowrap>';
	    if ($rvdata->fld_viewupdate == 1) {	
	      echo '<a href="' . base_url() . 'index.php/page/form/' . $rvdata->fld_viewnm . '/edit/' . $rviewrs->$rviewcol .'"><img src="' . base_url() . 'images/application_edit.png" width="14" height="14" border=0 title="Edit Record"></a>';
	    }
	    if ($rvdata->fld_viewdelete == 1) {	
	      echo '<a href="' . base_url() . 'index.php/page/delete_process/' . $rvdata->fld_viewnm . '/' . $rviewrs->$rviewcol .'" onclick= "return confirm(\' Are you sure want to delete this record ? \')"><img src="' . base_url() . 'images/application_delete.png" width="14" height="14" border=0  title="Delete Record"></a>';
	    }
	    echo '</td>';
	}
	else if ($obj2 == 'price' || $obj2 == 'percent' )
	{
	    if ($obj2 == 'percent') 
		{
			echo '<td align="center" nowrap>' . number_format($rviewrs->$rviewcol*100,2,',','.') .'%' . '</td>';
		} else {
			echo '<td align="right" nowrap>' . number_format($rviewrs->$rviewcol,0,',','.') . '</td>';
		}
	}

	else
	{
		echo '<td nowrap align="' . $obj2 . '">' . $rviewrs->$rviewcol . '</td>';
	}
    }

    if ($rvdata->fld_viewfooter != '') {
      if ($rviewcol == $rvdata->fld_viewfooter) {
	$total_amount = $total_amount + $rviewrs->$rviewcol ;
      }
    }
?>
</tr>
<?
}
?>
<?
if ($rvdata->fld_viewfooter != '') {
echo '<tr>';
echo '<td bgcolor="#CDCBBF">&nbsp;</td>';
  foreach ($viewcol as $rviewcol) {
    if ($rviewcol == $rvdata->fld_viewfooter) {
      echo '<td bgcolor="#CDCBBF" align=right nowrap><b>' . number_format($total_amount,2,',','.') . '</b></td>';
    }
    else {
       echo '<td bgcolor="#CDCBBF">&nbsp;</td>';
    }
  }
echo '</tr>';
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
</html>
