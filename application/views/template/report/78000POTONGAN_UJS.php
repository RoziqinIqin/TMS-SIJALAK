<?
header("Content-type: application/octet-stream");
       header("Content-Disposition: attachment; filename=driver_saving.xls");
       header("Pragma: no-cache");
       header("Expires: 0");
foreach($viewdata as $rvdata):
endforeach;
$headerrs = $viewrs;
$header = array_shift($headerrs);
$fld_periode = $header->periode;
?>
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
<table cellpadding="1" cellspacing="1" width="100%" border=1>
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>Tanggal SO</td>
    <td nowrap>Nomor SO</td>
    <td nowrap>Supir</td>
    <td nowrap>Nomor Kendaraan</td>
    <td nowrap>Rute</td>
    <td nowrap>Potongan UJS</td>
  </tr>
  </tr>
<?

  foreach ($viewrs as $rviewrs) {
    $no=$no+1;
    
   $total =$commission + $standby ;


    echo "<tr bgcolor=$bgcolor>";
    echo "<td>" .  $rviewrs->date . "</td>";
    echo "<td>$rviewrs->fld_btno</td>";
    echo "<td>$rviewrs->fld_driver</td>";
    echo "<td>$rviewrs->fld_vehicle</td>";
    echo "<td>$rviewrs->rute</td>";
    echo "<td align='right'> <b>" .  $rviewrs->fld_saving . "</b></td>";
    echo "</tr>";
    $total_saving =  $total_saving + $rviewrs->fld_saving;
  }

    $sub_kpi = ( ${"kpi_ok" . $rdriver} / ${"count" . $rdriver}) * 100;
    echo "<tr bgcolor='green'>";
    echo "<td colspan=5> <b>" .  "Total " . "</b></td>";
    echo "<td align='right'> <b>" .  $total_saving  . "</b></td>";
    echo "</tr>";


?>
</table>

<br>
</form>
