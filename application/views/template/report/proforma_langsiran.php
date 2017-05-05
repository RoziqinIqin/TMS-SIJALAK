<?
	$getData = $this->db->query("
		select 
			t0.fld_btno,
			date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
			date_format(t0.fld_btdtsa,'%d-%m-%Y') 'duedate',
			t1.fld_benm,t0.fld_btcmt,
			t2.fld_beaddrplc,
			t2.fld_beaddrstr,
			t0.fld_btbalance,
			t0.fld_bttax,
			if(t0.fld_btp07='',0,t0.fld_btp07) 'PPH23',
			t0.fld_btamt,
			format(t0.fld_btbalance,0) 'amount',
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
    //$currency = $data->currency;

	 $viewrs = $this->db->query("
		select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
			t1.fld_btp24, DATE_FORMAT(tx0.fld_btdt,'%d-%m-%Y')tx0date,
			format(tx0.fld_btp04,0)  'tarif',
			format(tx0.fld_btp06,0) 'lembur',
			tx0.fld_btp05 'jam',
			tx0.fld_btp07 'komoditas',
			tx0.fld_btp02 'beban',
			if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
			t2.fld_tyvalnm 'veh_type',
			t3.fld_empnm 'driver',
			t0.fld_btp01 'fld_route',
			format(t4.fld_btamt,0) 'fld_btamt',
			t4.fld_bttax,
			t4.fld_btbalance,
			format(t0.fld_btamt01,0) 'amount'
		from tbl_trk_billing t0
			left join tbl_btd_langsiran tx0 on tx0.fld_btid=t0.fld_btreffid
			left join tbl_bth t1 on t1.fld_btid = tx0.fld_btidp
			left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btp26 and t2.fld_tyid=19
			left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
			left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
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
		font-size: 9px;
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

</style> 

<div class="">
	<?
	$page=ceil($viewrs->num_rows() / 20);
	//print $page;
	if ($page > 1){
		$offset=1;
		for( $i= 1 ; $i <= $page ; $i++ ) {
			$limit=20;
			$viewrs = $this->db->query("
				select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date', t1.fld_btno,
					t1.fld_btp24, DATE_FORMAT(tx0.fld_btdt,'%d-%m-%Y')tx0date,
					format(tx0.fld_btp04,0)  'tarif',
					format(tx0.fld_btp06,0) 'lembur',
					tx0.fld_btp05 'jam',
					tx0.fld_btp07 'komoditas',
					tx0.fld_btp02 'beban',
					if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
					t2.fld_tyvalnm 'veh_type',
					t3.fld_empnm 'driver',
					t0.fld_btp01 'fld_route',
					format(t4.fld_btamt,0) 'fld_btamt',
					t4.fld_bttax,
					t4.fld_btbalance,
					format(t0.fld_btamt01,0) 'amount'
				from tbl_trk_billing t0
					left join tbl_btd_langsiran tx0 on tx0.fld_btid=t0.fld_btreffid
					left join tbl_bth t1 on t1.fld_btid = tx0.fld_btidp
					left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btp26 and t2.fld_tyid=19
					left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
					left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
				where 
					t0.fld_btidp = $fld_btid LIMIT ".$limit." OFFSET ".$offset."");
			?>
			<table width="100%" class="content">
				<tr>
					<td width="74"  rowspan="3" class="style1"><div align="center" style="font-size:20px"><img src="<?=base_url()?>images/logo-dpk.jpg" style="width:50; height:50" > </div></td>
					<td  width="423"  class="style1"><strong>PT DHARMAMULIA PRIMA KARYA</strong></td>
				</tr>
				<tr>
					<td colspan="5"  class="style1">Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td colspan="2" class="style1">Nomor  : <strong><?=$data->fld_btno?></strong></td>
					<td colspan="2" class="style1">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5" class="style1"><div data-canvas-width="194.48531280808655">
						<div align="center">PROFORMA INVOICE</div>
					</div>
					<div data-canvas-width="307.47506206273977">
					<div align="center"></div>
					</div></td>
				</tr>
				<tr>
					<td colspan="2" class="style1">Kepada Yth : </td>
					<td class="style1"><div align="right">Tanggal Faktur : <?=$data->date?>    </div></td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><?=$data->fld_benm?></td>
					<td class="style1"><div align="right">
						<strong>Jatuh Tempo    : <?=$data->duedate?> <div align="right">
						</strong></td>
				</tr>
			</table>
			<table class="grid" width="100%">
				<tr>
					<th width="65" class="style1">Tanggal</th>
					<th width="119" class="style1">No DO </th>
					<th width="200" class="style1">Rute</th>
					<th width="67" class="style1">Kendaraan</th>
					<th width="74" class="style1">Jenis</th>
					<th width="120" class="style1">Supir</th>
					<th width="93" class="style1">Komoditas</th>
					<th width="41" class="style1">Beban</th>
					<th width="50" class="style1">Jam Lmbr</th>
					<th width="88" class="style1">Tarif Lmbr</th>
					<th width="91" class="style1">Tarif Ritase</th>
					<th width="98" class="style1">Tarif</th>
				</tr>
				<? foreach ($viewrs ->result() as $row) { ?>
					<tr>
						<td class="style1"><?=$row->tx0date?></td>
						<td class="style1"><?=$row->fld_btnoalt?></td>
						<td class="style1"><?=$row->fld_route?></td>
						<td class="style1"><?=$row->fld_vehicle?></td>
						<td class="style1"><?=$row->veh_type?></td>
						<td class="style1"><?=$row->driver?></td>
						<td class="style1"><?=$row->komoditas?></td>
						<td class="style1"><div align="right">
							<?=$row->beban?> </div>
						</td>
						<td class="style1"><div align="center">
							<?=$row->jam?>
						</div></td>
						<td class="style1"><div align="right">
							<?=$row->lembur?>
						</div></td>
						<td class="style1"><div align="right">
							<?=$row->tarif?>
						</div></td>
						<td class="style1"><div align="right">
							<?=$row->amount?>
						</div></td>
					</tr> <? 
				} ?>
				<? if ($i==$page) { ?>
				<tfoot style="border:none">
					<tr>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center">
							<?=$data->lokasi.", ".$data->date?>
							</div></td>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right">Sub Total</div></td>
						<td class="style1"><div align="right">
							<?=number_format($data->fld_btamt,0,',','.')?>
						</div></td>
					</tr>
					<? if (number_format($data->PPH23,0,',','.') > 0) { ?>
						<tr>
							<td colspan="2" class="style1"><div align="center"></div></td>
							<td colspan="2" class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td colspan="2" class="style1">&nbsp;</td>
							<td colspan="2" class="style1"><div align="right"></div></td>
							<td class="style1"><div align="right"></div></td>
							<td class="style1"><div align="right">PPH23</div></td>
							<td class="style1"><div align="right">
								(<?=number_format($data->PPH23,0,',','.')?>)
							</div></td>
						</tr>
					<?}?>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right">PPN</div></td>
						<td class="style1"><div align="right">
							<?=number_format($data->fld_bttax,0,',','.')?>
						</div></td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right">Total Tarif</div></td>
						<td class="style1"><div align="right">
							<?=number_format($data->fld_btbalance,0,',','.')?>
						</div></td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center">
							<?=$data->ttd?>
						</div></td>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="style1"><div align="center">
							<?=$data->jabatan?>
						</div></td>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
					</tr>
					<tr>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="4" class="style1"><div align="right">Page : <?=$i;?> of  <?=$page;?></div></td>
					</tr>
				</tfoot>
				</table>
				<? } else { ?>
					<tfoot style="border:none">
						<tr>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td class="style1">&nbsp;</td>
							<td colspan="4" class="style1"><div align="right">Page : <?=$i;?> of  <?=$page;?></div></td>
						</tr>
					</tfoot>
					<p class="pagebreak"></p> <? 
				} ?>
			<? $offset=$offset+$limit; 
		} ?> <? 
	}  else { ?>
		<table width="100%" class="content">
			<tr>
				<td width="74"  rowspan="3" class="style1"><div align="center" style="font-size:20px"><img src="<?=base_url()?>images/logo-dpk.jpg" style="width:50; height:50" > </div></td>
				<td  width="423"  class="style1"><strong>PT DHARMAMULIA PRIMA KARYA</strong></td>
			</tr>
			<tr>
				<td colspan="5"  class="style1">Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" class="style1">Nomor  : <strong><?=$data->fld_btno?></strong></td>
				<td colspan="2" class="style1">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5" class="style1"><div data-canvas-width="194.48531280808655">
					<div align="center">PROFORMA INVOICE</div>
					</div>
					<div data-canvas-width="307.47506206273977">
					<div align="center"></div>
				</div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1">Kepada Yth : </td>
				<td class="style1"><div align="right">Tanggal Faktur : <?=$data->date?>    </div></td>
			</tr>
			<tr>
				<td colspan="2" class="style1"><?=$data->fld_benm?></td>
				<td class="style1"><div align="right">
					<strong>Jatuh Tempo    : <?=$data->duedate?> <div align="right">
					</strong></td>
			</tr>
		</table>
		<table class="grid" width="95%">
			<tr>
				<th width="65" class="style1">Tanggal</th>
				<th width="119" class="style1">No DO </th>
				<th width="200" class="style1">Rute</th>
				<th width="67" class="style1">Kendaraan</th>
				<th width="74" class="style1">Jenis</th>
				<th width="120" class="style1">Supir</th>
				<th width="93" class="style1">Komoditas</th>
				<th width="41" class="style1">Beban</th>
				<th width="50" class="style1">Jam Lmbr</th>
				<th width="88" class="style1">Tarif Lmbr</th>
				<th width="91" class="style1">Tarif Ritase</th>
				<th width="98" class="style1">Tarif</th>
			</tr>
			<? foreach ($viewrs ->result() as $row) { ?>
				<tr>
					<td class="style1"><?=$row->tx0date?></td>
					<td class="style1"><?=$row->fld_btnoalt?></td>
					<td class="style1"><?=$row->fld_route?></td>
					<td class="style1"><?=$row->fld_vehicle?></td>
					<td class="style1"><?=$row->veh_type?></td>
					<td class="style1"><?=$row->driver?></td>
					<td class="style1"><?=$row->komoditas?></td>
					<td class="style1"><?=$row->beban?></td>
					<td class="style1"><?=$row->jam?></td>
					<td class="style1"><div align="right">
						<?=$row->lembur?>
					</div></td>
					<td class="style1"><div align="right">
						<?=$row->tarif?>
					</div></td>
					<td class="style1"><div align="right">
						<?=$row->amount?>
					</div></td>
				</tr> <? 
			} ?>
			<tfoot style="border:none">
				<tr>
					<td colspan="2" class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><div align="center">
						<?=$data->lokasi.", ".$data->date?>
					</div></td>
					<td colspan="2" class="style1"><div align="center"></div></td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td colspan="2" class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right">Sub Total</div></td>
					<td class="style1"><div align="right">
						<?=number_format($data->fld_btamt,0,',','.')?>
					</div></td>
				</tr>
				<? if (number_format($data->PPH23,0,',','.') > 0) { ?>
					<tr>
						<td colspan="2" class="style1"><div align="center"></div></td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td class="style1">&nbsp;</td>
						<td colspan="2" class="style1">&nbsp;</td>
						<td colspan="2" class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right"></div></td>
						<td class="style1"><div align="right">PPH23</div></td>
						<td class="style1"><div align="right">
							(<?=number_format($data->PPH23,0,',','.')?>)
							</div>
						<div align="right"></div></td>
					</tr>
				<?}?>
				<tr>
					<td colspan="2" class="style1"><div align="center">Dibuat,</div></td>
					<td colspan="2" class="style1"><div align="center">Menyetujui</div></td>
					<td colspan="2" class="style1"><div align="center">Mengetahui</div></td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right">PPN</div></td>
					<td class="style1"><div align="right">
						<?=number_format($data->fld_bttax,0,',','.')?>
						</div>
					<div align="right"></div></td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><div align="center"></div></td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td colspan="2" class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right"></div></td>
					<td class="style1"><div align="right">Total Tarif</div></td>
					<td class="style1"><div align="right">
						<?=number_format($data->fld_btbalance,0,',','.')?>
					</div></td>
				</tr>
				<tr>
					 <td colspan="2" class="style1"><div align="center"></div></td>
					 <td colspan="2" class="style1"><div align="center"></div></td>
					 <td class="style1">&nbsp;</td>
					 <td colspan="2" class="style1">&nbsp;</td>
					 <td colspan="2" class="style1">&nbsp;</td>
					 <td class="style1">&nbsp;</td>
					 <td colspan="2" class="style1">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><div align="center"></div></td>
					<td colspan="2" class="style1"><div align="center"></div></td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><div align="center">
						<?=$data->ttd?>
					</div></td>
					<td colspan="2" class="style1"><div align="center">Aris Sriyono</div></td>
					<td colspan="2" class="style1"><div align="center">Felys Ratna Dewi</div></td>
					<td class="style1">&nbsp;</td>
					<!-- <td colspan="2" class="style1">&nbsp;</td> -->
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="style1"><div align="center">
						<?=$data->jabatan?>
					</div></td>
					<td colspan="2" class="style1"><div align="center">Div. Head Transportation</div></td>
					<td colspan="2" class="style1"><div align="center">Treasury Manager</div></td>
					<td class="style1">&nbsp;</td>
					<!-- <td colspan="2" class="style1">&nbsp;</td> -->
					<td colspan="2" class="style1">&nbsp;</td>
					<td class="style1">&nbsp;</td>
					<td colspan="2" class="style1">&nbsp;</td>
				</tr>
			</tfoot>
		</table>
	<br/>	

	</span>

	<? } ?>

</div>

