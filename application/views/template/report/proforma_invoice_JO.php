<?

function TanggalIndo($tgl1){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($tgl1, 0, 4);
	$bulan = substr($tgl1, 5, 2);
	$tgl   = substr($tgl1, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}

	$getData = $this->db->query("
		select 
			t0.fld_btno,
			t0.fld_btdt 'date1',
			date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
			t0.fld_btdtsa 'date2',
			date_format(t0.fld_btdtsa,'%d-%m-%Y') 'duedate',
			t1.fld_benm,t0.fld_btcmt,
			if(t1.fld_bep10 < 30,'0','1')  'TOP',
			t1.fld_bep10 'TopOri',
			t2.fld_beaddrplc,
			t2.fld_beaddrstr,
			t0.fld_btbalance,
			t0.fld_bttax,
			t0.fld_btp07,
			t0.fld_btamt,
			t0.fld_btuamt,
			t0.fld_btbalance 'amount',
			t3.fld_tyvalnm 'lokasi',
			t3.fld_tyvalcfg 'ttd',
			t3.fld_tyvalcmt 'jabatan'
		from tbl_bth t0 
			left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
			left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
			left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
		where 
			t0.fld_btid='$fld_btid'
		");
	$data = $getData->row();

	if ($data->TOP == '1') {
		$ddate = $data->date2;
		} else {
			$ddate=date('Y-m-d',strtotime($data->date1 . "+30 days"));
		}	
	$TglTempo= TanggalIndo($ddate);
	$TglInvo= TanggalIndo($data->date1);
	
    //$currency = $data->currency;
	$viewrs = $this->db->query("
		select distinct t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
			t1.fld_btp24,
			if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
			t2.fld_tyvalnm 'veh_type',
			t3.fld_empnm 'driver',
			t4.fld_btamt,
			t4.fld_bttax,
			t4.fld_btbalance,
			t0.fld_btno,
			t0.fld_btnoalt,
			t0.fld_btp01 'fld_route',
			t0.fld_vehicle,
			format(t0.fld_btamt01,0) 'amount',
			date_format(tx0.fld_btdt,'%d-%m-%Y')'tx0date',
			format(t0.fld_btamt05,0) 'dp'
		from tbl_trk_billing t0
			left join tbl_bth t1 on t1.fld_btnoalt=t0.fld_btno and t1.fld_bttyid=20
			left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
			left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
			left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
			left join tbl_btd_langsiran tx0 on tx0.fld_btidp=t0.fld_btreffid
		where 
			t0.fld_btidp = $fld_btid
		");
?>
<style>
	table.content{
		width:100% ;
		/*height:13.97 ;*/ 
		font-size: 12px;
		border-collapse:collapse; 
	}
	table.grid{
		width:100% ;
		font-size: 10px;
		border-collapse:collapse;	
	}
	table.grid th{
		padding:5px;
	}
	table.grid th{
		background: #F0F0F0;
		border-top: 0.2mm solid #000;
		border-bottom: 0.2mm solid #000;
		text-align:center;
		border:1px solid #000;
	}
	table.grid tr td{
		padding:2px;
		border-bottom:0.2mm solid #000;
		border:0.5px solid #000;
	}
	table.grid tfoot tr td {
		border:none;
	}
	.pagebreak {
		width:29.7cm ;
		page-break-after: always;
		margin-bottom:10px;
	}
	.akhir {
		width:29.7cm ;
		font-size:13px;
	}
	#footer{
		display:block;
		position:fixed;
		bottom:0;
	}
	.style1 {font-family: Arial, Helvetica, sans-serif}
	.style2 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
</style> 

<div class="">
	<table width="100%" class="content">
		<tr>
			<td width="74" rowspan="2" class="style1"><div align="center" style="font-size:20px"><img src="<?=base_url()?>images/logo-dpk.jpg" style="width:50; height:50" > </div></td>
		    <td width="423" class="style1"><strong>PT DHARMAMULIA PRIMA KARYA</strong></td>
		    <td width="298" rowspan="2" class="style1">&nbsp;</td>
		    <td colspan="2" rowspan="2" class="style1">&nbsp;</td>
		</tr>
		<tr>
		    <td class="style1">Jl. Kaliurang Km 6,5 Pandega Sakti No. 6</td>
		</tr>
		<tr>
		    <td class="style1">&nbsp;</td>
            <td class="style1">Nomor  : <strong><?=$data->fld_btno?></strong></td>
            <td class="style1">&nbsp;</td>
            <td colspan="2" class="style1">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5" class="style1"><div data-canvas-width="194.48531280808655">
				<div align="center"><strong>PROFORMA INVOICE </strong></div>
				</div>
				<div data-canvas-width="307.47506206273977">
				<div align="center"></div>
				</div></td>
		</tr>
		<tr>
		    <td colspan="2" class="style1">Kepada Yth :</td>
		    <td class="style1">&nbsp;</td>
			<td width="213" class="style1"><div align="right">Tanggal Faktur : </div></td>
			<td width="181" class="style1"><div align="right">
				<?=$TglInvo?>
				</div></td>
		</tr>
		<tr>
			<td colspan="2" class="style1"><strong><?=$data->fld_benm?></strong></td>
			<td class="style1">&nbsp;</td>
			<td class="style1"><div align="right">Jatuh Tempo : </div></td>
			<td class="style1"><div align="right"><strong><?=$TglTempo?></strong>
				</div></td>
		</tr>
	</table>	
	<table class="grid" width="95%">
		<tr>
		    <th width="88" class="style1">Tanggal</th>
		    <th width="100" class="style1">No SO </th>
		    <th width="176" class="style1">No DO </th>
		    <th width="210" class="style1">Rute</th>
		    <th width="65" class="style1">Kendaraan</th>
		    <th width="90" class="style1">Jenis</th>
		    <th width="150" class="style1">Supir</th>
		    <th width="130" class="style1">DP</th>
		    <th width="130" class="style1">Tarif</th>
        </tr>
		<? foreach ($viewrs ->result() as $row) { ?>
			<tr>
				<td class="style1"><?=$row->tx0date?></td>
				<td class="style1"><?=$row->fld_btno?></td>
				<td class="style1"><?=str_replace(",",", ",$row->fld_btnoalt)?></td>
				<td class="style1"><?=$row->fld_route?></td>
				<td class="style1"><?=$row->fld_vehicle?></td>
				<td class="style1"><?=$row->veh_type?></td>
				<td class="style1"><?=$row->driver?></td>
				<td class="style1"><div align="right">
					<?=$row->dp?>
					</div></td>
				<td class="style1"><div align="right">
					<?=$row->amount?>
					</div></td>
			</tr>
		<? } ?>		
		<tfoot style="border:none">
			<tr>
				<td colspan="2" class="style1">&nbsp;</td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center">
                    <?=$data->lokasi.", ".$TglInvo?>
                    </div></td>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1"><div align="right"><strong>TotalTarif</strong></div></td>
				<td class="style1"><div align="right"><strong>
                    <?=number_format($data->fld_btamt,0,',','.')?>
                    </strong></div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1"><div align="right"><strong>PPH23</strong></div></td>
				<td class="style2"><div align="right">
					(<?=number_format($data->fld_btp07,0,',','.')?>)
					</div>
					<div align="right"></div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1"><div align="right"><strong>PPN</strong></div></td>
				<td class="style2"><div align="right">
					<?=number_format($data->fld_bttax,0,',','.')?>
					</div>
					<div align="right"></div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1"><div align="right"><strong>Total DP </strong></div></td>
				<td class="style1"><div align="right"><strong>
                    <?=number_format($data->fld_btuamt,0,',','.')?>
                    </strong></div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1"><div align="right"><strong>Total Tagihan </strong></div></td>
				<td class="style1"><div align="right"><strong>
					<?=number_format($data->amount,0,',','.')?>
					</strong></div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center">
					<?=$data->ttd?>
					</div></td>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><div align="center">
					<?=$data->jabatan?>
					</div></td>
				<td colspan="2" class="style1"><div align="center"></div></td>
				<td class="style1">&nbsp;</td>
				<td colspan="2" class="style1">&nbsp;</td>
				<td class="style1">&nbsp;</td>
			</tr>
		</tfoot>
	</table>
		
	<br/>	
	</span>
</div>
