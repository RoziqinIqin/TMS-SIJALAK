<html>
<table cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>No</td>
    <td nowrap>Nomor POD</td>
    <td nowrap>Nomor Eksekusi</td>
    <td nowrap>Pelanggan</td>
    <td nowrap>Nomor Mobil</td>
    <td nowrap>Sopir</td>
    <td nowrap>Jenis Biaya</td>
    <td nowrap>Jumlah</td>
    <td nowrap>Action</td>
   </tr>
   </tr>
<?
$cost = 0;
$saving = 0;
foreach ($fvgvrs as $rfvgvrs) {
  $cost = $cost + $rfvgvrs->Amount;
  $saving = $saving +  $rfvgvrs->DriverSaving;
  $no=$no+1;
  if ($no % 2 == 1){
    $bgcolor="#FFFFFF";
  } else{
    $bgcolor="#F5F5F5";
  }

  echo "<tr bgcolor=$bgcolor>";
  echo "<td>" .  $no . "</td>";
  echo "<td>" .  $rfvgvrs->DONumber . "</td>";
  echo "<td>" .  $rfvgvrs->EONumber . "</td>";
  echo "<td>$rfvgvrs->Customer</td>";
  echo "<td>$rfvgvrs->VehicleNumber</td>";
  echo "<td>$rfvgvrs->Driver</td>";
  echo "<td>" . $rfvgvrs->CostType . "</td>";
  echo "<td align='right'>" . number_format($rfvgvrs->Amount,2,',','.') . "</td>";
  echo "<td>$rfvgvrs->Action</td>";
  echo "</tr>";
}
echo "<tr bgcolor=$bgcolor>";
echo "<td colspan=7 align='center'><b>Total</td>";
echo "<td align='right'><b>" .  number_format($cost,2,',','.') . "</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";

?>
</table>
</html>
