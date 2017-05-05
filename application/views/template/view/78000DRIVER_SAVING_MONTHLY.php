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
<table cellpadding="1" cellspacing="1" width="2000">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap rowspan=2>No</td>
    <td nowrap rowspan=2>Supir</td>
   
  <?
  $startDate = strtotime(date('Y-m-d')  . '-12 month');
  $currentDate   = strtotime(date('Y-m-d'));
  $dtsa = date('Y-m-d',$startDate);
  $dtso = date('Y-m-d',$currentDate);
  while ($currentDate >= $startDate) {
    echo "<td nowrap colspan=2>" . date('Y-m',$startDate) . "</td>";
    $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
  }

  ?>
   <td nowrap rowspan=2>Saldo Akhir</td>
   </tr>
   <tr bgcolor="#CDCBBF" align="center">
   
<?
 $startDate = strtotime(date('Y-m-d')  . '-12 month');
 while ($currentDate >= $startDate) {
    echo "<td nowrap>Tabungan</td>";
    echo "<td nowrap>Potongan</td>";
    $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
  }
 echo "</tr>";
### Data Prepare
   $saving = $this->db->query("select t0.fld_btnoalt,
                               tx0.fld_saving,t0.fld_btp11,date_format(t0.fld_btdt,'%Y-%m-%d') 'date',date_format(t0.fld_btdt,'%Y-%m') 'periode',
			        0 'balance'
                               from 
				tbl_trk_transfer tx0				
				left join tbl_bth t0 on t0.fld_btid=tx0.fld_btreffid 
                              	where
				t0.fld_bttyid=13
                              
			        ");  
   $saving = $saving->result();
   $deduction = $this->db->query(" select t0.fld_empid,t0.fld_amount 'fld_btamt01',date_format(t0.fld_empdebetdt,'%Y-%m') 'periode'
				   from
				   tbl_empdebet t0
				   
                                  ");
   $deduction = $deduction->result();


  foreach ($viewrs as $rviewrs) {
    #$amt = 0;
    $startDate = strtotime(date('Y-m-d')  . '-12 month');
    while ($currentDate >= $startDate) {
     ${"deposit" . $startDate} = 0;
     ${"deduction" . $startDate} = 0;
     $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
    }

    foreach($saving as $rsaving) {
      if($rsaving->fld_btp11 == $rviewrs->fld_empid) {
         $startDate = strtotime(date('Y-m-d')  . '-12 month');
         while ($currentDate >= $startDate) {
           if($rsaving->periode == date('Y-m',$startDate)) {
             ${"deposit" . $startDate} = ${"deposit" . $startDate} + $rsaving->fld_saving;
           }
           $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
         }
      $balance = $rsaving->balance;
      }
    }

    foreach($deduction as $rdeduction) {
      if($rdeduction->fld_empid == $rviewrs->fld_empid) {
         $startDate = strtotime(date('Y-m-d')  . '-12 month');
         while ($currentDate >= $startDate) {
           if($rdeduction->periode == date('Y-m',$startDate)) {
             ${"deduction" . $startDate} = ${"deduction" . $startDate} + $rdeduction->fld_btamt01;
           }
           $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
         }
      #$balance = $rsaving->balance;
      }
    }

    $no=$no+1;
    if ($no % 2 == 1){
      $bgcolor="#FFFFFF";
    } else {
     $bgcolor="#F5F5F5";
    }
    echo "<tr bgcolor=$bgcolor>";
    echo "<td>" .  $no . "</td>";
    echo "<td>$rviewrs->Name</td>";
    $startDate = strtotime(date('Y-m-d')  . '-12 month');
    while ($currentDate >= $startDate) {
      echo "<td align='right'>" . number_format(${"deposit" . $startDate},2,',','.') . "</td>";
      echo "<td align='right'>" . number_format(${"deduction" . $startDate},2,',','.') . "</td>";
      ${"deposit" . $rviewrs->Name} = ${"deposit" . $rviewrs->Name} + ${"deposit" . $startDate};
      ${"subdeposit" . $startDate} =  ${"subdeposit" . $startDate} + ${"deposit" . $startDate};
      ${"deduction" . $rviewrs->Name} = ${"deduction" . $rviewrs->Name} + ${"deduction" . $startDate};
      ${"subdeduction" . $startDate} =  ${"subdeduction" . $startDate} + ${"deduction" . $startDate};
      $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
    }
    ${"subtotal" . $rviewrs->Name} = $balance + ${"deposit" . $rviewrs->Name} - ${"deduction" . $rviewrs->Name};
    echo "<td align='right'><b>" . number_format(${"subtotal" . $rviewrs->Name},2,',','.') . "</b></td>";
    echo "</tr>";
    $grand_total =  $grand_total +  ${"subtotal" . $rviewrs->Name};
    $grand_balance = $grand_balance + $balance;
  }
      
    echo "<tr bgcolor='green'>";
    echo "<td colspan=2> <b>" .  "Sub Total" . "</b></td>";
    $startDate = strtotime(date('Y-m-d')  . '-12 month');
    while ($currentDate >= $startDate) {
      echo "<td align='right'>" . number_format(${"subdeposit" . $startDate},2,',','.') . "</td>";
      echo "<td align='right'>" . number_format(${"subdeduction" . $startDate},2,',','.') . "</td>";
      $startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');
      
    }
    echo "<td align='right'><b>" . number_format($grand_total,2,',','.') . "</b></td>";
    echo "</tr>";

?>
</table>
<br>
</form>
