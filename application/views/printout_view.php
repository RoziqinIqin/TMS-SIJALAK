<?
foreach($viewdata as $rvdata):
endforeach;
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=$rvdata->fld_viewnm.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
?>
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

echo '<table cellpadding="1" cellspacing="1" width="100%" border=1">';
echo '<tr bgcolor="#CDCBBF" align="center">';
echo '<td>No</td>';
$ordindex = 0;
foreach ($viewcol as $rviewcol)
     {
	$ordindex = $ordindex + 1;
	$pieces = explode("|", $rviewcol);
	$obj1 = $pieces[0];
	$obj2 = (isset($pieces[1])) ? $pieces[1] : '';
	if ($obj1 != 'crud')
	{
	    echo '<td align="center">' . $obj1 . '</td>';
	}
    }

echo '</tr>';
foreach ($viewrs as $rviewrs)
{
    $no=$no+1;
 
echo '<tr>';
echo '<td width="120">' . $no . '</td>';

foreach ($viewcol as $rviewcol)
     {
	$pieces = explode("|", $rviewcol);
	$obj1 = $pieces[0];
	$obj2 = (isset($pieces[1])) ? $pieces[1] : '';
	if ($obj1 != 'crud')
	{
	    echo '<td align="' . $obj2 . '">' . $rviewrs->$rviewcol . '</td>';
	}
    }

    if ($rvdata->fld_viewnm == "78000RPT_BILLING_WEEKLY_CLEANING" || $rvdata->fld_viewnm == "78000RPT_BILLING_WEEKLY_STORAGE") {
      if ($rviewcol == 'Total Amount|price') {
	$total_amount = $total_amount + $rviewrs->$rviewcol ;
// 	echo $rvdata->fld_viewnm . "###### " . $rviewrs->$rviewcol . "<br>";
      }
    }
?>
</tr>
<?
}
 if ($rvdata->fld_viewnm == "78000RPT_BILLING_WEEKLY_CLEANING") {
?>
<tr>
  <td bgcolor="#CDCBBF" colspan=10>Total</td>
  <td bgcolor="#CDCBBF"><? echo $total_amount ;?></td>
</tr>
<?
}
?>
<?
if ($rvdata->fld_viewnm == "78000RPT_BILLING_WEEKLY_STORAGE") {
?>
<tr>
  <td bgcolor="#CDCBBF" colspan=11>Total</td>
  <td bgcolor="#CDCBBF"><? echo $total_amount ;?></td>
</tr>
<?
}
?>
</table>

</html>
