<?
function TanggalIndo($tgl1){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($tgl1, 0, 4);
	$bulan = substr($tgl1, 5, 2);
	$tgl   = substr($tgl1, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}
	// $this->load->helper("terbilang");
function konversi($x){
	$x = abs($x);
	$angka = array ("","satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
   
	if($x < 12){
	$temp = " ".$angka[$x];
	}else if($x<20){
	$temp = konversi($x - 10)." belas";
	}else if ($x<100){
	$temp = konversi($x/10)." puluh". konversi($x%10);
	}else if($x<200){
	$temp = " seratus".konversi($x-100);
	}else if($x<1000){
	$temp = konversi($x/100)." ratus".konversi($x%100);   
	}else if($x<2000){
	$temp = " seribu".konversi($x-1000);
	}else if($x<1000000){
	$temp = konversi($x/1000)." ribu".konversi($x%1000);   
	}else if($x<1000000000){
	$temp = konversi($x/1000000)." juta".konversi($x%1000000);
	}else if($x<1000000000000){
	$temp = konversi($x/1000000000)." milyar".konversi($x%1000000000);
	}

	return $temp;
}
function tkoma($x){
	$str = stristr($x,".");
	$ex = explode('.',$x);

	if(($ex[1]/10) >= 1){
	$a = abs($ex[1]);
	}
	$string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",   "sembilan","sepuluh", "sebelas");
	$temp = "";

	$a2 = $ex[1]/10;
	$pjg = strlen($str);
	$i =1;
	 
	if($a>=1 && $a< 12){   
	$temp .= " ".$string[$a];
	}else if($a>12 && $a < 20){   
	$temp .= konversi($a - 10)." belas";
	}else if ($a>20 && $a<100){   
	$temp .= konversi($a / 10)." puluh". konversi($a % 10);
	}else{
	if($a2<1){
	 
	while ($i<$pjg){     
	 $char = substr($str,$i,1);     
	 $i++;
	 $temp .= " ".$string[$char];
	}
	}
	}  
	return $temp;
}
function terbilang($x){
	if($x<0){
		$hasil = "minus ".trim(konversi(x));
	}else{
		$poin = trim(tkoma($x));
		$hasil = trim(konversi($x));
	}

	if($poin){
		$hasil = $hasil." koma ".$poin;
	}else{
		$hasil = $hasil;
	}
	return $hasil;  
	}

	$getData = $this->db->query("
		select 
			t0.fld_btno 'NoBIL',
			concat('DPK/KWT/',substring(t0.fld_btno,-10)) 'NoKwi', 
			date_format(t0.fld_btdtsa,'%d-%mm-%y') 'fld_btdtsa',
			t0.fld_btdt 'date1',
			t0.fld_btdtsa 'date2',
			date_format(t0.fld_btdt,'%d-%b-%Y') 'Date3',
			date_format(t0.fld_btdt, '%d %M %Y') 'DateFull',
			t0.fld_btamt 'TarifOri',
			(t0.fld_bttax-t0.fld_btp07) 'TaxOri',
			if(t0.fld_bttax=0,'0','1') 'TX',
			if(t0.fld_btp07=0,'0','1') 'T23',
			format((t0.fld_bttax-t0.fld_btp07),0) 'Tax',
			format(t0.fld_btamt,0) 'Tarif',
			t0.fld_btbalance 'AmOri',
			format(t0.fld_btbalance,0) 'Amount',
			t0.fld_btuamt 'DPori',
			format(t0.fld_btuamt,0) 'DP',
			t2.fld_beaddrp01 'Pelanggan',
			t2.fld_beaddrcity,
			t2.fld_beaddrstr,
			t0.fld_btcmt,
			t3.fld_tyvalnm 'lokasi',
			t3.fld_tyvalcfg 'ttd',
			t3.fld_tyvalcmt 'jabatan',
			t0.fld_baidc 'AA',
			t4.fld_tyvalcfg 'BankAcc', 
			t4.fld_tyvalnm 'BankName',
			t4.fld_tyvalcmt 'Benef', 
			t0.fld_btdesc
		from tbl_bth t0 
			left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
			left join tbl_beaddr t2 on t2.fld_beid=t0.fld_baidc and t2.fld_beaddrid=t0.fld_btp02
			left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
			left join tbl_tyval t4 on t4.fld_tyid=75 and t4.fld_tyvalcd=t0.fld_btp05
		where 
			t0.fld_btid='$fld_btid'");
			
	$data = $getData->row();
	
	$PJK = "Pajak ";
	if ($data->TX == '1' and $data->T23 == '1') {$PJK = "Pajak (PPN & PPH23)";}
	if ($data->TX == '1' and $data->T23 == '0') {$PJK = "Pajak (PPN)";}
	if ($data->TX == '0' and $data->T23 == '1') {$PJK = "Pajak (PPH23)";}
	
	if (round($data->AmOri)==0) {
		$Bilang = round($data->TarifOri) + round($data->TaxOri);
	} else {	
		$Bilang = round($data->AmOri);	
	}
	$terbilang = ucwords(terbilang(round($Bilang)));
	$max_kar = 90;
	$jml_terbilang1=strlen($terbilang);
	$cetak1="# ".$terbilang." Rupiah #";
	$cetak2="";	
  	if ($jml_terbilang1 > $max_kar) {
		$cetak = substr($terbilang,$max_kar,1); 
		if($cetak !=" "){
			while($cetak !=" "){
				$i=1;
				$max_kar=$max_kar+$i;
				$cetak = substr($terbilang,$max_kar,1); 
				}
			$cetak = substr($terbilang,0,$max_kar);
			$jml_terbilang2=strlen($cetak);
			$terbilang2= substr($terbilang,$jml_terbilang2);
			} 
		$cetak1="# ".$cetak." #";
		$cetak2="# ".$terbilang2." Rupiah #";
		};

	$TglInvo=TanggalIndo($data->date1);
	$TglTempo=TanggalIndo($data->date2);
	
?>	

<style>
.ft0{font-style:normal;font-weight:bold;font-size:28px;font-family:Times New Roman;color:#800000;}
.ft1{font-style:normal;font-weight:bold;font-size:14px;font-family:Calibri;color:#000000;}
.ft2{font-style:normal;font-weight:bold;font-size:16px;font-family:Calibri;color:#000000;}
.ft3{font-style:normal;font-weight:normal;font-size:14px;font-family:Calibri;color:#000000;}
.ft4{font-style:normal;font-weight:bold;font-size:20px;font-family:Calibri;color:#000000;}
.ft5{font-style:italic;font-weight:bold;font-size:16px;font-family:Calibri;color:#000000;}
.ft6{font-style:normal;font-weight:bold;font-size:24px;font-family:Calibri;color:#000000;}
.ft7{font-style:normal;font-weight:bold;font-size:11px;font-family:Times New Roman;color:#000000;}
.ft8{font-style:normal;font-weight:bold;font-size:12px;font-family:Calibri;color:#000000;}
.ft9{font-style:normal;font-weight:normal;font-size:7px;font-family:Calibri;color:#000000;}
.ft10{font-style:normal;font-weight:bold;font-size:24px;font-family:Calibri;color:#000000;}
</style> 
	<div style="position:absolute;top:0;left:0">
	<img src="<?=base_url()?>images/Kwit01.jpg" style="width 1000; height:1445" ALT="" > 
	</div>
	<?if (round($data->AmOri)==0) {?>
	<div style="position:absolute;top:235;left:250"><img src="<?=base_url()?>images/Stamp-PAID.png" style="width 150; height:150" ALT="" > </div>
	<div style="position:absolute;top:719;left:250"><img src="<?=base_url()?>images/Stamp-PAID.png" style="width 150; height:150" ALT="" > </div>
	<div style="position:absolute;top:1205;left:250"><img src="<?=base_url()?>images/Stamp-PAID.png" style="width 150; height:150" ALT="" > </div>
	<?}?>

<!-- Header 1 -->
	<div style="position:absolute;top:22;left:130"><span class="ft0">PT. DHARMAMULIA PRIMA KARYA</span></div>
	<div style="position:absolute;top:56;left:130;width:500px; height:14px"><span class="ft1">Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman </span></div>
	<div style="position:absolute;top:76;left:130;width:500px; height:14px"><span class="ft1">Yogyakarta 55571 - INDONESIA</span></div>
	<div style="position:absolute;top:95;left:130;width:500px; height:14px"><span class="ft1">Telp: (0274)2850888  ;  Fax: (0274)497468</span></div>
	<div style="position:absolute;top:36;left:669"><span class="ft10">  K W I T A N S I  </span></div>
	<div style="position:absolute;top:21;left:873;width:130px; height:16px"><span class="ft2">Customer</span></div>
	<div style="position:absolute;top:66;left:680"><span class="ft3">Nomor </span></div>
	<div style="position:absolute;top:66;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:66;left:795"><span class="ft2"><?=$data->NoKwi?></span></div>
	<div style="position:absolute;top:82;left:680"><span class="ft3">Tanggal Inv</span></div>
	<div style="position:absolute;top:82;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:82;left:795"><span class="ft3"><?=$TglInvo?></span></div>
	<div style="position:absolute;top:99;left:680"><span class="ft3">Jatuh Tempo</span></div>
	<div style="position:absolute;top:99;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:99;left:795"><span class="ft3"><?=$TglTempo?></span></div>
	
<!--  Customer details 1 -->
	<div style="position:absolute;top:130;left:30;width:180px; height:14px"><span class="ft2">Sudah terima dari</span></div>
	<div style="position:absolute;top:130;left:190"><span class="ft2">:</span></div>
	<div style="position:absolute;top:126;left:220;width:700px; height:20px"><span class="ft4"><?=$data->Pelanggan?></span></div>
	<div style="position:absolute;top:148;left:220;width:700px; height:14px"><span class="ft3"><?=$data->fld_beaddrstr?></span></div>
	<div style="position:absolute;top:164;left:220;width:500px; height:14px"><span class="ft3"><?=strtoupper($data->fld_beaddrcity)?></span></div>
	<div style="position:absolute;top:190;left:30"><span class="ft2">Uang sebanyak</span></div>
	<div style="position:absolute;top:190;left:150"><span class="ft2">:</span></div>
	<div style="position:absolute;top:190;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak1?></span></div>
	<div style="position:absolute;top:210;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak2?></span></div>
	
<!--  Deskripsi 1 -->
	<div style="position:absolute;top:240;left:30;width:160px; height:14px"><span class="ft2">Untuk pembayaran</span></div>
	<div style="position:absolute;top:240;left:200"><span class="ft2">:</span></div>
	<div style="position:absolute;top:240;left:250"><span class="ft3">Invoice No. </span></div>
	<div style="position:absolute;top:238;left:320"><span class="ft2"><?=$data->NoBIL?></span></div>
	<div style="position:absolute;top:240;left:487"><span class="ft3">........ </span></div>
	<div style="position:absolute;top:240;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:240;right:340"><span class="ft3"><?=$data->Tarif?>.-</span></div>
	<div style="position:absolute;top:260;left:250"><span class="ft3"><?=$PJK?></span></div>
	<div style="position:absolute;top:260;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:260;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:260;right:340"><span class="ft3"><?=$data->Tax?>.-</span></div>
	<div style="position:absolute;top:280;left:250"><span class="ft3">Uang Muka, DP </span></div>
	<div style="position:absolute;top:280;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:280;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:280;right:340"><span class="ft3"><?=$data->DP?>.-</span></div>
	<div style="position:absolute;top:300;left:250"><span class="ft3">Pelunasan </span></div>
	<div style="position:absolute;top:300;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:300;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:300;right:340"><span class="ft3"><?=$data->Amount?>.-</span></div>
	<div style="position:absolute;top:250;right:70"><span class="ft3">Yogyakarta, <?=$data->DateFull?></span></div>
	<div style="position:absolute;top:365;left:820"><span class="ft3">  </span></div>
	<div style="position:absolute;top:414;left:810"><span class="ft3"><?=$data->ttd?></span></div>
	<div style="position:absolute;top:434;left:850"><span class="ft3"><?=$data->jabatan?></span></div>
	<div style="position:absolute;top:290;left:40"><span class="ft6">Rp.</span></div>
	<div style="position:absolute;top:290;left:90"><span class="ft6"><?=number_format($Bilang,0,'.',',')?>.-</span></div>

<!--  Note 1 -->
	<div style="position:absolute;top:330;left:26"><span class="ft10">Note :</span></div>
	<div style="position:absolute;top:326;left:97"><span class="ft3">1.</span></div>
	<div style="position:absolute;top:326;left:112;width:600px"><span class="ft3">Mohon pembayaran dapat ditransfer ke rekening bank berikut ini :</span></div>
	<div style="position:absolute;top:341;left:130"><span class="ft3">Bank Name</span></div>
	<div style="position:absolute;top:341;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:341;left:234;width:600px"><span class="ft1"><?=$data->BankName?></span></div>
	<div style="position:absolute;top:355;left:130"><span class="ft3">Bank Account</span></div>
	<div style="position:absolute;top:355;left:225;"><span class="ft3">:</span></div>
	<div style="position:absolute;top:355;left:234;width:600px"><span class="ft1"><?=$data->BankAcc?></span></div>
	<div style="position:absolute;top:369;left:130"><span class="ft3">Account Name</span></div>
	<div style="position:absolute;top:369;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:369;left:234;width:400px;width:800px"><span class="ft1"><?=$data->Benef?></span></div>
	<div style="position:absolute;top:389;left:97"><span class="ft1">2.</span></div>
	<div style="position:absolute;top:389;left:112;width:600px"><span class="ft1">Mohon pembayaran disertai keterangan nomer invoice yang dibayarkan</span></div>
	<div style="position:absolute;top:409;left:97"><span class="ft3">3.</span></div>
	<div style="position:absolute;top:409;left:112;width:600px"><span class="ft3">Pembayaran adalah sah, jika dana sudah efektif diterima di rekening bank diatas</span></div>
	<div style="position:absolute;top:409;left:465"><span class="ft3"></span></div>
	<div style="position:absolute;top:429;left:97"><span class="ft3">4.</span></div>
	<div style="position:absolute;top:429;left:112;width:600px"><span class="ft3">Contact Person : Cahyo Arseno (Billing - PT. DPK) Telp. : 0274-2850888 Ext. 124</span></div>

	
<!-- Header 2 -->	
	<div style="position:absolute;top:506;left:130"><span class="ft0">PT. DHARMAMULIA PRIMA KARYA</span></div>
	<div style="position:absolute;top:540;left:130;width:500px; height:14px"><span class="ft1">Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman </span></div>
	<div style="position:absolute;top:560;left:130;width:500px; height:14px"><span class="ft1">Yogyakarta 55571 - INDONESIA</span></div>
	<div style="position:absolute;top:579;left:130;width:500px; height:14px"><span class="ft1">Telp: (0274)2850888  ;  Fax: (0274)497468</span></div>
	<div style="position:absolute;top:520;left:669"><span class="ft10">  K W I T A N S I  </span></div>
	<div style="position:absolute;top:505;left:863;width:130px; height:16px"><span class="ft2">Accounting</span></div>
	<div style="position:absolute;top:552;left:680"><span class="ft3">Nomor </span></div>
	<div style="position:absolute;top:552;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:552;left:795"><span class="ft2"><?=$data->NoKwi?></span></div>
	<div style="position:absolute;top:568;left:680"><span class="ft3">Tanggal Inv</span></div>
	<div style="position:absolute;top:568;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:568;left:795"><span class="ft3"><?=$TglInvo?></span></div>
	<div style="position:absolute;top:585;left:680"><span class="ft3">Jatuh Tempo</span></div>
	<div style="position:absolute;top:585;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:585;left:795"><span class="ft3"><?=$TglTempo?></span></div>
	
<!--  Customer details 2 -->	
	<div style="position:absolute;top:614;left:30;width:180px; height:14px"><span class="ft2">Sudah terima dari</span></div>
	<div style="position:absolute;top:614;left:190"><span class="ft2">:</span></div>
	<div style="position:absolute;top:610;left:220;width:700px; height:20px"><span class="ft4"> <?=$data->Pelanggan?></span></div>
	<div style="position:absolute;top:632;left:220;width:700px; height:14px"><span class="ft3"><?=$data->fld_beaddrstr?></span></div>
	<div style="position:absolute;top:648;left:220;width:500px; height:14px"><span class="ft3"><?=strtoupper($data->fld_beaddrcity)?></span></div>
	<div style="position:absolute;top:674;left:30"><span class="ft2">Uang sebanyak</span></div>
	<div style="position:absolute;top:674;left:150"><span class="ft2">:</span></div>
	<div style="position:absolute;top:674;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak1?></span></div>
	<div style="position:absolute;top:694;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak2?></span></div>
	
<!--  Deskripsi 2 -->	
	<div style="position:absolute;top:724;left:30;width:160px; height:14px"><span class="ft2">Untuk pembayaran</span></div>
	<div style="position:absolute;top:724;left:200"><span class="ft2">:</span></div>
	<div style="position:absolute;top:724;left:250"><span class="ft3">Invoice No. </span></div>
	<div style="position:absolute;top:722;left:320"><span class="ft2"><?=$data->NoBIL?></span></div>
	<div style="position:absolute;top:724;left:487"><span class="ft3">........ </span></div>
	<div style="position:absolute;top:724;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:724;right:340"><span class="ft3"><?=$data->Tarif?>.-</span></div>
	<div style="position:absolute;top:744;left:250"><span class="ft3"><?=$PJK?></span></div>
	<div style="position:absolute;top:744;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:744;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:744;right:340"><span class="ft3"><?=$data->Tax?>.-</span></div>
	<div style="position:absolute;top:764;left:250"><span class="ft3">Uang Muka, DP </span></div>
	<div style="position:absolute;top:764;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:764;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:764;right:340"><span class="ft3"><?=$data->DP?>.-</span></div>
	<div style="position:absolute;top:784;left:250"><span class="ft3">Pelunasan </span></div>
	<div style="position:absolute;top:784;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:784;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:784;right:340"><span class="ft3"><?=$data->Amount?>.-</span></div>
	<div style="position:absolute;top:734;right:70"><span class="ft3">Yogyakarta, <?=$data->DateFull?></span></div>
	<div style="position:absolute;top:849;left:820"><span class="ft3">  </span></div>
	<div style="position:absolute;top:899;left:810"><span class="ft3"><?=$data->ttd?></span></div>
	<div style="position:absolute;top:919;left:850"><span class="ft3"><?=$data->jabatan?></span></div>
	<div style="position:absolute;top:774;left:40"><span class="ft6">Rp.</span></div>
	<div style="position:absolute;top:774;left:90"><span class="ft6"><?=number_format($Bilang,0,'.',',')?>.-</span></div>
	
<!--  Note 2 -->	
	<div style="position:absolute;top:814;left:26"><span class="ft10">Note :</span></div>
	<div style="position:absolute;top:811;left:97"><span class="ft3">1.</span></div>
	<div style="position:absolute;top:811;left:112;width:600px"><span class="ft3">Mohon pembayaran dapat ditransfer ke rekening bank berikut ini :</span></div>
	<div style="position:absolute;top:826;left:130"><span class="ft3">Bank Name</span></div>
	<div style="position:absolute;top:826;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:826;left:234;width:600px"><span class="ft1"><?=$data->BankName?></span></div>
	<div style="position:absolute;top:840;left:130"><span class="ft3">Bank Account</span></div>
	<div style="position:absolute;top:840;left:225;"><span class="ft3">:</span></div>
	<div style="position:absolute;top:840;left:234;width:600px"><span class="ft1"><?=$data->BankAcc?></span></div>
	<div style="position:absolute;top:854;left:130"><span class="ft3">Account Name</span></div>
	<div style="position:absolute;top:854;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:854;left:234;width:400px;width:800px"><span class="ft1"><?=$data->Benef?></span></div>
	<div style="position:absolute;top:874;left:97"><span class="ft1">2.</span></div>
	<div style="position:absolute;top:874;left:112;width:600px"><span class="ft1">Mohon pembayaran disertai keterangan nomer invoice yang dibayarkan</span></div>
	<div style="position:absolute;top:895;left:97"><span class="ft3">3.</span></div>
	<div style="position:absolute;top:895;left:112;width:600px"><span class="ft3">Pembayaran adalah sah, jika dana sudah efektif diterima di rekening bank diatas</span></div>
	<div style="position:absolute;top:895;left:465"><span class="ft3"></span></div>
	<div style="position:absolute;top:915;left:97"><span class="ft3">4.</span></div>
	<div style="position:absolute;top:915;left:112;width:600px"><span class="ft3">Contact Person : Cahyo Arseno (Billing - PT. DPK) Telp. : 0274-2850888 Ext. 124</span></div>
	
<!-- Header 3 -->	
	<div style="position:absolute;top:990;left:130"><span class="ft0">PT. DHARMAMULIA PRIMA KARYA</span></div>
	<div style="position:absolute;top:1024;left:130;width:500px; height:14px"><span class="ft1">Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman </span></div>
	<div style="position:absolute;top:1044;left:130;width:500px; height:14px"><span class="ft1">Yogyakarta 55571 - INDONESIA</span></div>
	<div style="position:absolute;top:1063;left:130;width:500px; height:14px"><span class="ft1">Telp: (0274)2850888  ;  Fax: (0274)497468</span></div>
	<div style="position:absolute;top:1004;left:669"><span class="ft10">  K W I T A N S I  </span></div>
	<div style="position:absolute;top:990;left:870;width:130px; height:16px"><span class="ft2">A r s i p</span></div>
	<div style="position:absolute;top:1035;left:680"><span class="ft3">Nomor </span></div>
	<div style="position:absolute;top:1035;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1035;left:795"><span class="ft2"><?=$data->NoKwi?></span></div>
	<div style="position:absolute;top:1051;left:680"><span class="ft3">Tanggal Inv</span></div>
	<div style="position:absolute;top:1051;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1051;left:795"><span class="ft3"><?=$TglInvo?></span></div>
	<div style="position:absolute;top:1068;left:680"><span class="ft3">Jatuh Tempo</span></div>
	<div style="position:absolute;top:1068;left:780"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1068;left:795"><span class="ft3"><?=$TglTempo?></span></div>
	
<!--  Customer details 3 -->	
	<div style="position:absolute;top:1098;left:30;width:180px; height:14px"><span class="ft2">Sudah terima dari</span></div>
	<div style="position:absolute;top:1098;left:190"><span class="ft2">:</span></div>
	<div style="position:absolute;top:1094;left:220;width:700px; height:20px"><span class="ft4"><?=$data->Pelanggan?></span></div>
	<div style="position:absolute;top:1116;left:220;width:700px; height:14px"><span class="ft3"><?=$data->fld_beaddrstr?></span></div>
	<div style="position:absolute;top:1132;left:220;width:500px; height:14px"><span class="ft3"><?=strtoupper($data->fld_beaddrcity)?></span></div>
	<div style="position:absolute;top:1158;left:30"><span class="ft2">Uang sebanyak</span></div>
	<div style="position:absolute;top:1158;left:150"><span class="ft2">:</span></div>
	<div style="position:absolute;top:1158;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak1?></span></div>
	<div style="position:absolute;top:1178;left:170;width:810px; height:16px"><span class="ft5"><?=$cetak2?></span></div>
	
<!--  Deskripsi 3 -->	
	<div style="position:absolute;top:1208;left:30;width:160px; height:14px"><span class="ft2">Untuk pembayaran</span></div>
	<div style="position:absolute;top:1208;left:200"><span class="ft2">:</span></div>
	<div style="position:absolute;top:1208;left:250"><span class="ft3">Invoice No. </span></div>
	<div style="position:absolute;top:1206;left:320"><span class="ft2"><?=$data->NoBIL?></span></div>
	<div style="position:absolute;top:1208;left:487"><span class="ft3">........ </span></div>
	<div style="position:absolute;top:1208;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:1208;right:340"><span class="ft3"><?=$data->Tarif?>.-</span></div>
	<div style="position:absolute;top:1228;left:250"><span class="ft3"><?=$PJK?></span></div>
	<div style="position:absolute;top:1228;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:1228;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:1228;right:340"><span class="ft3"><?=$data->Tax?>.-</span></div>
	<div style="position:absolute;top:1248;left:250"><span class="ft3">Uang Muka, DP </span></div>
	<div style="position:absolute;top:1248;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:1248;left:527"><span class="ft3">sebesar Rp.</span></div>
	<div style="position:absolute;top:1248;right:340"><span class="ft3"><?=$data->DP?>.-</span></div>
	<div style="position:absolute;top:1268;left:250"><span class="ft3">Pelunasan </span></div>
	<div style="position:absolute;top:1268;left:392"><span class="ft3">................................ </span></div>
	<div style="position:absolute;top:1268;left:527"><span class="ft3">sebesar Rp. </span></div>
	<div style="position:absolute;top:1268;right:340"><span class="ft3"><?=$data->Amount?>.-</span></div>
	<div style="position:absolute;top:1218;right:70"><span class="ft3">Yogyakarta, <?=$data->DateFull?></span></div>
	<div style="position:absolute;top:1333;left:820"><span class="ft3">  </span></div>
	<div style="position:absolute;top:1384;left:810"><span class="ft3"><?=$data->ttd?></span></div>
	<div style="position:absolute;top:1404;left:850"><span class="ft3"><?=$data->jabatan?></span></div>
	<div style="position:absolute;top:1258;left:40"><span class="ft6">Rp.</span></div>
	<div style="position:absolute;top:1258;left:90"><span class="ft6"><?=number_format($Bilang,0,'.',',')?>.-</span></div>
		
<!--  Note 3 -->	
	<div style="position:absolute;top:1298;left:26"><span class="ft10">Note :</span></div>
	<div style="position:absolute;top:1296;left:97"><span class="ft3">1.</span></div>
	<div style="position:absolute;top:1296;left:112;width:600px"><span class="ft3">Mohon pembayaran dapat ditransfer ke rekening bank berikut ini :</span></div>
	<div style="position:absolute;top:1311;left:130"><span class="ft3">Bank Name</span></div>
	<div style="position:absolute;top:1311;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1311;left:234;width:600px"><span class="ft1"><?=$data->BankName?></span></div>
	<div style="position:absolute;top:1326;left:130"><span class="ft3">Bank Account</span></div>
	<div style="position:absolute;top:1326;left:225;"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1326;left:234;width:600px"><span class="ft1"><?=$data->BankAcc?></span></div>
	<div style="position:absolute;top:1340;left:130"><span class="ft3">Account Name</span></div>
	<div style="position:absolute;top:1340;left:225"><span class="ft3">:</span></div>
	<div style="position:absolute;top:1340;left:234;width:400px;width:800px"><span class="ft1"><?=$data->Benef?></span></div>
	<div style="position:absolute;top:1361;left:97"><span class="ft1">2.</span></div>
	<div style="position:absolute;top:1361;left:112;width:600px"><span class="ft1">Mohon pembayaran disertai keterangan nomer invoice yang dibayarkan</span></div>
	<div style="position:absolute;top:1380;left:97"><span class="ft3">3.</span></div>
	<div style="position:absolute;top:1380;left:112;width:600px"><span class="ft3">Pembayaran adalah sah, jika dana sudah efektif diterima di rekening bank diatas</span></div>
	<div style="position:absolute;top:1380;left:465"><span class="ft3"></span></div>
	<div style="position:absolute;top:1401;left:97"><span class="ft3">4.</span></div>
	<div style="position:absolute;top:1401;left:112;width:600px"><span class="ft3">Contact Person : Cahyo Arseno (Billing - PT. DPK) Telp. : 0274-2850888 Ext. 124</span></div>
