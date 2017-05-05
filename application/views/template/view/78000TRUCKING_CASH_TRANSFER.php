<html>
<table cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>No</td>
    <td nowrap>Cabang</td>
    <td nowrap>Pembuat SO</td>
    <td nowrap>Nomor SO</td>
     <td nowrap>Tanggal</td>
    <td nowrap>Jenis SO</td>
    <td nowrap width=160px>Pelanggan</td>
    <td nowrap>Deal Tarif</td>
    <td nowrap>UJS Murni</td>
    <td nowrap>% UJS</td>
    <td nowrap>Nomor Kendaraan</td>
    <td nowrap>Supir</td>
    <td nowrap>No.HP</td>
    <td nowrap>Nama Bank</td>
    <td nowrap>Rekening</td>
    <td nowrap>Biaya</td>
    <td nowrap>Jumlah UJS</td>
    <td nowrap>Tabungan</td>
    <td nowrap>Action</td>
    
   </tr>

<?
$cost = 0;
$saving = 0;
foreach ($fvgvrs as $rfvgvrs) {
  $cost = $cost + $rfvgvrs->Amount;
  $pct = $rfvgvrs->UJSmurni /$rfvgvrs->DealTarif *100;
  $saving = $saving +  $rfvgvrs->DriverSaving;
  $no=$no+1;
  if ($no % 2 == 1){
    $bgcolor="#FFFFFF";
  } else{
    $bgcolor="#F5F5F5";
  }

  echo "<tr bgcolor=$bgcolor>";
  echo "<td>" .  $no . "</td>";
  echo "<td>" .  $rfvgvrs->location . "</td>";
  echo "<td>" .  $rfvgvrs->Oleh . "</td>";
  echo "<td>" .  $rfvgvrs->DONumber . "</td>";
   echo "<td>" .  $rfvgvrs->SODate . "</td>";
  echo "<td>" .  $rfvgvrs->jenis . "</td>";
  echo "<td>$rfvgvrs->Customer</td>";
  echo "<td>" . number_format($rfvgvrs->DealTarif,0,',','.') . "</td>";
  echo "<td>" . number_format($rfvgvrs->UJSmurni,0,',','.') . "</td>";
  echo "<td>" . number_format($pct,2,',','.') . "%</td>";
  echo "<td>$rfvgvrs->VehicleNumber</td>";
  echo "<td>$rfvgvrs->Driver</td>";
  echo "<td>$rfvgvrs->fld_btp01</td>";
  echo "<td>$rfvgvrs->fld_btp02</td>";
  echo "<td>$rfvgvrs->fld_btp03</td>";
  echo "<td>" . $rfvgvrs->CostType . "</td>";
  echo "<td align='right'>" . number_format($rfvgvrs->Amount,0,',','.') . "</td>";
  echo "<td align='right'>" . number_format($rfvgvrs->DriverSaving,0,',','.') . "</td>";
   echo "<td>" . $rfvgvrs->Action . "</td>";
  echo "</tr>";
}
echo "<tr bgcolor='grey'>";
echo "<td colspan=16 align='center'><b>Total</td>";
echo "<td align='right'><b>" .  number_format($cost,0,',','.') . "</td>";
echo "<td align='right'><b>" .  number_format($saving,0,',','.') . "</td>";
echo "<td align='right'>&nbsp;</td>";
echo "</tr>";

?>
</table>
</html>
