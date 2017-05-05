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
    <td nowrap rowspan=2>Driver Name</td>
    <td nowrap rowspan=2>Periode</td>
    <td nowrap rowspan=2>Opening Balance</td>
    <td nowrap colspan=31>Deposit Amount</td>
    <td nowrap rowspan=2>Total Balance</td>
  </tr>
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>1</td>
    <td nowrap>2</td>
    <td nowrap>3</td>
    <td nowrap>4</td>
    <td nowrap>5</td>
    <td nowrap>6</td>
    <td nowrap>6</td>
    <td nowrap>8</td>
    <td nowrap>9</td>
    <td nowrap>10</td>
    <td nowrap>11</td>
    <td nowrap>12</td>
    <td nowrap>13</td>
    <td nowrap>14</td>
    <td nowrap>15</td>
    <td nowrap>16</td>
    <td nowrap>17</td>
    <td nowrap>18</td>
    <td nowrap>19</td>
    <td nowrap>20</td>
    <td nowrap>21</td>
    <td nowrap>22</td>
    <td nowrap>23</td>
    <td nowrap>24</td>
    <td nowrap>25</td>
    <td nowrap>26</td>
    <td nowrap>27</td>
    <td nowrap>28</td>
    <td nowrap>29</td>
    <td nowrap>30</td>
    <td nowrap>31</td>
   </tr>
   </tr>
<?
### Data Prepare
   $saving = $this->db->query("select t0.fld_saving,t1.fld_btp11,date_format(t2.fld_btdt,'%Y-%m-%d') 'date',date_format(t2.fld_btdt,'%e') 'day',
			       ifnull(t3.fld_btamt01,0) 'balance'
                                   from tbl_trk_settlement t0 
				   left join tbl_bth t1 on t1.fld_btid=t0.fld_btreffid
                                   left join tbl_bth t2 on t2.fld_btid=t0.fld_btidp
				   left join tbl_driver_saving t3 on t3.fld_empid=t1.fld_btp11
                                   where
				   t1.fld_bttyid=13
                                   and
				   date_format(t2.fld_btdt,'%Y-%m') = '$fld_periode'
			          ");  
   $saving = $saving->result();

  foreach ($viewrs as $rviewrs) {
    #$amt = 0;
    $balance = 0;
    for($x=1;$x<=31;$x++) {
      ${"deposit" . $x} = 0;
    }
    foreach($saving as $rsaving) {
      if($rsaving->fld_btp11 == $rviewrs->fld_empid) {
         $balance = $rsaving->balance;  
         #$amt = $amt + $rsaving->fld_saving;
         for($x=1;$x<=31;$x++) {
           if($rsaving->day == $x) {
             ${"deposit" . $x} = ${"deposit" . $x} + $rsaving->fld_saving;
           }
         }
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
    echo "<td>$rviewrs->periode</td>";
    echo "<td align='right'>" . number_format($balance,2,',','.') . "</td>";
    for($x=1;$x<=31;$x++) {
      echo "<td align='right'>" . number_format(${"deposit" . $x},2,',','.') . "</td>";
       ${"subdeposit" . $x} =  ${"subdeposit" . $x} + ${"deposit" . $x};
       ${"deposit" . $rviewrs->Name} = ${"deposit" . $rviewrs->Name} + ${"deposit" . $x};
    }
    echo "<td align='right'><b>" . number_format(${"deposit" . $rviewrs->Name},2,',','.') . "</b></td>";
    echo "</tr>";
    $grand_deposit =  $grand_deposit +  ${"deposit" . $rviewrs->Name};
  }
      
    echo "<tr bgcolor='green'>";
    echo "<td colspan=4> <b>" .  "Sub Total" . "</b></td>";
    for($z=1;$z<=31;$z++) {
      echo "<td align='right'><b>" . number_format(${"subdeposit" . $z},2,',','.') . "</b></td>";
    }
    echo "<td align='right'><b>" . number_format($grand_deposit,2,',','.') . "</b></td>";
    echo "</tr>";

?>
</table>
<br>
</form>
