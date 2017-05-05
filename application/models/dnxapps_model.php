<?php
class Dnxapps_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
  
	function message($message) {
		echo "<br><div align='center'><font size='5' color='red'>";
		$display_string = $message;
		echo $display_string;
		echo "</font></div>";
		echo "<div align='center'>Click <a href='javascript:history.go(-1)'>here</a> to continue to process</div>";
		exit();
	}  
	function message2($msg1, $msg2, $msg3) {
		echo "<br><div align='center'><font size='5' color='red'>";
		echo "<br>";
		$display_string = $msg1;
		echo $display_string;
		echo "<br>";
		$display_string = $msg2;
		echo $display_string;
		echo "<br>";
		$display_string = $msg3;
		echo $display_string;
		echo "</font></div>";
		echo "<div align='center'>Click <a href='javascript:history.go(-1)'>here</a> to continue to process</div>";
		exit();
	}  
	
	function setVehicleCode($type,$num,$loc) {
		#$location = $this->db->query("select * from tbl_lokasi where lokcd='$loc' ");
		#$location = $location->row();
		#$num =  substr($num,strpos($num,' ')+1,4);
		#$asset_code = $location->truckcd . $type . $num;
		#return $asset_code;
		echo "NOT USED";
	}

	### Cetak Pengantar
	function printINV($fld_btid) {
		#$this->db->query("update tbl_bth set fld_btdt=now() , fld_btdesc='$data->fld_btdesc',fld_btflag=2 where fld_btid = '$fld_btid'");
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				t0.fld_btcmt,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				format(t0.fld_btbalance,0) 'amount',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcmt 'jabatan',
				case
					when t0.fld_btp02='' then (select fld_beaddrp01 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrp01 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_benm,
				case
					when t0.fld_btp02='' then (select fld_beaddrp05 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrp05 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_beaddrplc,
				t9.fld_tyvalnm 'JenisInv',
				t4.fld_tyvalcfg norek, t4.fld_tyvalnm bank, t4.fld_tyvalcmt an
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t4 on t4.fld_tyid=75 and t4.fld_tyvalcd=t0.fld_btp05
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
		");
		$data = $getData->row();
		$currency = $data->currency;
		
		$this->load->library('cezpdf');
		$this->cezpdf->ezSetMargins(60,5,10,15);
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');

		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,753,28);
		$this->cezpdf->ezText('                         PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
		//$this->cezpdf->ezText('                         Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left'));
		//$this->cezpdf->ezText('                         Telp: (0274) 880170 Fax: (0274) 885585', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('                         Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('                         Telp. (0274)2850888 Fax. (0274)497468', 10, array('justification' => 'left')); 

		$this->cezpdf->line(30, 735, 580, 735);
		$this->cezpdf->line(30, 732, 580, 732);
		$this->cezpdf->addText(30,700,10,"Nomor Invoice");
		$this->cezpdf->addText(100,700,10," : ");
		$this->cezpdf->addText(110,700,10,$data->fld_btno);
		$this->cezpdf->addText(30,685,10,"Lampiran");
		$this->cezpdf->addText(100,685,10," : ");
		$this->cezpdf->addText(110,685,10,"1 Bendel");
		$this->cezpdf->addText(30,670,10,"Hal");
		$this->cezpdf->addText(100,670,10," : ");
		$this->cezpdf->addText(110,670,10,"Tagihan Biaya Angkutan");
		
		$this->cezpdf->addText(30,640,10,"Kepada Yth :");
		$this->cezpdf->addText(30,625,10,$data->fld_benm);
		$this->cezpdf->addText(30,610,10,"Up. : ".$data->fld_beaddrplc);
		$this->cezpdf->addText(30,595,10,$data->fld_beaddrstr);
		
		$this->cezpdf->addText(30,550,10,"Dengan Hormat,");
	
	### Change by Cenot 22 Okt 2015    
		### $this->cezpdf->addText(30,530,10,"Dengan ini kami sampaikan tagihan biaya angkutan sebesar,");

		// Change by iqin 02 Jan 2016
		$totalinvoice = round($data->fld_btbalance);
		$this->cezpdf->addText(30,530,10,"Dengan ini kami sampaikan tagihan biaya angkutan sebesar, Rp. " .number_format($totalinvoice,0,',',','));

		### $this->cezpdf->addText(30,515,10,"Rp. " . $data->amount);
		$this->load->helper("terbilang");
		//$terbilang = ucwords(number_to_words($data->fld_btbalance));
		//Change by iqin 02 Jan 2016
		$terbilang = str_replace("  "," ",ucwords(number_to_words(round($data->fld_btbalance))));
		$terbilang3 = "";
		$max_kar = 85;
		$jml_terbilang=strlen($terbilang);
		if ($jml_terbilang <= $max_kar) {
			$this->cezpdf->addText(30,515,10,"Terbilang : # ".$terbilang."Rupiah #"); 
			
		}
		else {
			$cetak = substr($terbilang,$max_kar,1); 
			if($cetak !=" "){
			while($cetak !=" "){
				$i=1;
				$max_kar=$max_kar+$i;
				$cetak = substr($terbilang,$max_kar,1); }
			$cetak = substr($terbilang,0,$max_kar);
			$jml_terbilang2=strlen($cetak);
			$terbilang3= substr($terbilang,$jml_terbilang2);
			$this->cezpdf->addText(30,515,10,"Terbilang : # ".$cetak." #");
			$this->cezpdf->addText(30,500,10,ltrim($terbilang3)."Rupiah #"); } }
	### Change by Cenot 22 Okt 2015    

		//$this->cezpdf->addText(30,530,10,"Dengan ini kami sampaikan tagihan biaya angkutan sebesar,");
		//$this->cezpdf->addText(30,515,10,"Rp. " . $data->amount);
		
		$this->cezpdf->addText(30,480,10,"Jumlah tersebut diatas mohon di transfer ke Rekening  No. ".$data->norek."");
		$this->cezpdf->addText(30,465,10, $data->bank." atas nama ".$data->an);
		$this->cezpdf->addText(30,450,10,"Mohon pembayaran disertai deskripsi nomor invoice");
		 
		$this->cezpdf->addText(30,410,10,"Demikian kami sampaikan, atas perhatian dan kerja sama yang baik di ucapkan terima kasih.");
		
		$this->cezpdf->addTextWrap(400,380,200,10,$data->lokasi . ", " . $data->date,'center');
		$this->cezpdf->addTextWrap(400,300,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,285,200,10,"( " . $data->jabatan . " )",'center' );
		 
		###$lbl = "Surat_Pengantar " .$data->JenisInv ." - " .$data->NoInv .".pdf";
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment;  filename = Surat_Pengantar " .$data->JenisInv ." - " .$data->NoInv .".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		  
		$output = $this->cezpdf->ezOutput();
		echo $output;  
	}

	### Cetak Rekap Reguler (Not Used)
	function printINV2($fld_btid) {
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				t1.fld_benm,t0.fld_btcmt,
				t2.fld_beaddrplc,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				t0.fld_bttax,
				t0.fld_btamt,
				format(t0.fld_btbalance,0) 'amount',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalcmt 'jabatan',
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
		");
		$data = $getData->row();
		$currency = $data->currency;

		$viewrs = $this->db->query("
		select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
		t1.fld_btp24,
		if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
		t2.fld_tyvalnm 'veh_type',
		t3.fld_empnm 'driver',
		t4.fld_btamt,
		t4.fld_bttax,
		t4.fld_btbalance,
		t0.fld_btnoalt,
		t0.fld_btp01 'fld_route',
		t0.fld_vehicle,
		format(t0.fld_btamt01,0) 'amount',
		date_format(tx0.fld_btdt,'%d-%m-%Y')'tx0date'
		from tbl_trk_billing t0
		left join tbl_bth t1 on t1.fld_btnoalt=t0.fld_btno and t1.fld_bttyid=20
		left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
		left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
		left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
		left join tbl_btd_langsiran tx0 on tx0.fld_btidp=t0.fld_btreffid
		where 
		t0.fld_btidp = $fld_btid
		");
		$viewrs = $viewrs->result_array();

		$this->load->library('cezpdf');
		$this->cezpdf->Cezpdf('a4','landscape');
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		$this->cezpdf->ezSetMargins(30,5,10,15);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,536,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left'));
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 
		$this->cezpdf->ezSetDy(-10);
		$this->cezpdf->ezText('<b>REKAPITULASI ANGKUTAN</b>', 10, array('justification' => 'center'));
		$this->cezpdf->ezText('<b>' . $data->fld_benm . '</b>', 10, array('justification' => 'center'));
		$this->cezpdf->ezSetY(500);
		$this->cezpdf->ezTable($viewrs,array('tx0date'=>'Tanggal','fld_btnoalt'=>'No. DO','fld_route'=>'Rute','fld_vehicle'=>'Kendaraan','veh_type'=>'Jenis','driver'=>'Supir','amount'=>'Tarif'),'',
		array('rowGap'=>'4','showLines'=>'1','xPos'=>15,'xOrientation'=>'right','width'=>760,'shaded'=>0,'fontSize'=>'8',
	   'cols'=>array('date'=>array('width'=>60),
	   'fld_btnoalt'=>array('width'=>100,'justification'=>'center'),
	   'fld_route'=>array('width'=>220,'justification'=>'center'),
	   'fld_vehicle'=>array('width'=>100,'justification'=>'center'),
	   'driver'=>array('width'=>100,'justification'=>'center'),
	   'veh_type'=>array('width'=>100,'justification'=>'center'),
	   'amount'=>array('width'=>80,'justification'=>'right'),
		)));
		$this->cezpdf->ezSetDY(-10);
		$data_sum = array(
						   array('row1'=>'Sub Total  :','row2'=>number_format($data->fld_btamt,0,',','.')),
						   array('row1'=>'PPN  :','row2'=>number_format($data->fld_bttax,0,',','.')),
							array('row1'=>'Total Tarif  :','row2'=>number_format($data->fld_btbalance,0,',','.'))
							  );
		$this->cezpdf->ezTable($data_sum,array('row1'=>'','row2'=>'','row3'=>''),'',
		array('rowGap'=>'4','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>15,'xOrientation'=>'right','width'=>760,'fontSize'=>'8',
		'cols'=>array('row1'=>array('width'=>680,'justification'=>'right'),'row2'=>array('width'=>80,'justification'=>'right'))));     

		$this->cezpdf->addTextWrap(600,180,200,10,$data->lokasi.  ", " . $data->date,'center');
		$this->cezpdf->addTextWrap(600,130,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(600,115,200,10,"( " . $data->jabatan . " )",'center');

		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Rekap Angkutan " . $data->JenisInv. " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");

		$output = $this->cezpdf->ezOutput();
		echo $output;
	}  

	### Cetak Rekap Langsiran (Not Used)
	function printINV2A($fld_btid) {
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				t1.fld_benm,t0.fld_btcmt,
				t2.fld_beaddrplc,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				t0.fld_bttax,
				t0.fld_btamt,
				format(t0.fld_btbalance,0) 'amount',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalcmt 'jabatan',  
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
		");
		$data = $getData->row();
		$currency = $data->currency;

		$viewrs = $this->db->query("
			select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
				t1.fld_btp24,
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
		$viewrs = $viewrs->result_array();

		$this->load->library('cezpdf');
		$this->cezpdf->Cezpdf('a4','landscape');
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		$this->cezpdf->ezSetMargins(30,5,10,15);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,536,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left'));
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 
		$this->cezpdf->ezSetDy(-10);
		$this->cezpdf->ezText('<b>REKAPITULASI ANGKUTAN</b>', 10, array('justification' => 'center'));
		$this->cezpdf->ezText('<b>' . $data->fld_benm . '</b>', 10, array('justification' => 'center'));
		$this->cezpdf->ezSetY(500);
		$this->cezpdf->ezTable($viewrs,array('date'=>'Tanggal','fld_btnoalt'=>'No. DO','fld_route'=>'Rute' ,'fld_vehicle'=>'Kendaraan','veh_type'=>'Jenis','driver'=>'Supir' , 'komoditas'=>'Komoditas' ,'beban'=>'Beban' ,
			'jam'=>'Jam Lmbr. ' ,'lembur'=>'Tarif Lmbr. ' ,   'tarif'=>'Tarif Ritase ','amount'=>'Tarif'),'',
			array('rowGap'=>'3','colGap'=>'3','showLines'=>'1','xPos'=>15,'xOrientation'=>'right','width'=>760,'shaded'=>0,'fontSize'=>'8',
			   'cols'=>array('date'=>array('width'=>60),
			   'date'=>array('width'=>50,'justification'=>'center'),
			   'fld_btnoalt'=>array('width'=>90,'justification'=>'center'),
			   'fld_route'=>array('width'=>140,'justification'=>'center'),
			   'komoditas'=>array('width'=>90,'justification'=>'center'),
			   'beban'=>array('width'=>40,'justification'=>'center'),
				'jam'=>array('width'=>50,'justification'=>'center'),
				'lembur'=>array('width'=>60,'justification'=>'right'),
				'tarif'=>array('width'=>60,'justification'=>'right'),
			   'veh_type'=>array('width'=>80,'justification'=>'center'),
			   'fld_vehicle'=>array('width'=>50,'justification'=>'center'),
			   'driver'=>array('width'=>80,'justification'=>'center'),
			   'veh_type'=>array('width'=>50,'justification'=>'center'),
			   'amount'=>array('width'=>50,'justification'=>'right'),
			)));
		$this->cezpdf->ezSetDY(-10);
		$data_sum = array(
			array('row1'=>'Sub Total  :','row2'=>number_format($data->fld_btamt,0,',','.')),
			array('row1'=>'PPN  :','row2'=>number_format($data->fld_bttax,0,',','.')),
			array('row1'=>'Total Tarif  :','row2'=>number_format($data->fld_btbalance,0,',','.'))
			);
		$this->cezpdf->ezTable($data_sum,array('row1'=>'','row2'=>'','row3'=>''),'',
			array('rowGap'=>'4','colGap'=>'3','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>15,'xOrientation'=>'right','width'=>760,'fontSize'=>'8',
				'cols'=>array('row1'=>array('width'=>760,'justification'=>'right'),'row2'=>array('width'=>50,'justification'=>'right'))));     
		$this->cezpdf->ezSetDY(-10);
			$data_sum = array(
						array('row1'=>'','row2'=>$data->lokasi.", ".$data->date),
						array('row1'=>'','row2'=>''),
						array('row1'=>'','row2'=>''),
						array('row1'=>'','row2'=>''),
						array('row1'=>'','row2'=>$data->ttd),
						array('row1'=>'','row2'=>'( ' . $data->jabatan . ' )')
			);
		$this->cezpdf->ezTable($data_sum,array('row1'=>'','row2'=>'','row3'=>''),'',
			array('rowGap'=>'4','colGap'=>'3','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>15,'xOrientation'=>'right','width'=>760,'fontSize'=>'10',
				'cols'=>array('row1'=>array('width'=>600,'justification'=>'center'),'row2'=>array('width'=>200,'justification'=>'right'))));   
		
		//$this->cezpdf->addText(650,-10,10,$data->lokasi.  ", " . $data->date,'center');
		//$this->cezpdf->addTextWrap(650,130,200,10,$data->ttd,'center');
		//$this->cezpdf->addTextWrap(650,115,200,10,"( " . $data->jabatan . " )",'center');

		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Rekap Angkutan " . $data->JenisInv . " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");

		$output = $this->cezpdf->ezOutput();
		echo $output;
  } 

	### Cetak Kwitansi
	function printINV3($fld_btid) {
		$getData = $this->db->query("
			select 
				concat('DPK/KWT/',substring(t0.fld_btno,-10)) 'fld_btno',
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				t1.fld_benm,t0.fld_btcmt,
				t2.fld_beaddrplc,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				format(t0.fld_btbalance,2) 'amount',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalcmt 'jabatan',
				t0.fld_btdesc,
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
			");
		$data = $getData->row();
		$currency = $data->currency;
		
		$this->load->library('cezpdf');
		$this->cezpdf->ezSetMargins(30,5,10,15);
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,760,50);
		$this->cezpdf->addTextWrap(90,795,200,14,"<b>KWITANSI</b>");
		$this->cezpdf->addTextWrap(90,780,200,11,"PT. DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addTextWrap(90,765,200,11, $data->lokasi);

		### Lines
		$this->cezpdf->line(30, 752, 580, 752);
		$this->cezpdf->line(30, 700, 580, 700);
		$this->cezpdf->line(30, 550, 580, 550);
		$this->cezpdf->line(30, 752, 30, 550);
		$this->cezpdf->line(580, 752, 580, 550);
	   
		
		//$this->load->helper("terbilang");
		//$terbilang = ucwords(number_to_words($data->fld_btbalance));
		$this->cezpdf->addText(400,780,10,"Nomor");
		$this->cezpdf->addText(450,780,10,": " . $data->fld_btno);
		$this->cezpdf->addText(400,765,10,"Tanggal");
		$this->cezpdf->addText(450,765,10,": " . $data->date);

		$this->cezpdf->addText(50,735,10,"Sudah terima dari ");
		$this->cezpdf->addText(150,735,10, $data->fld_benm);
		$this->cezpdf->addText(50,720,10,"Uang Sebanyak ");

	###1. Change by Cenot 22 Okt 2015    
	###1. Change by Iqin 10 Des 2015  penambahan $jml_terbilang <= $max_kar
		// Change by iqin round 
		$this->load->helper("terbilang");
		$terbilang = str_replace("  "," ",ucwords(number_to_words(round($data->fld_btbalance))));
		$terbilang3 = "";
		// Change by iqin 74
		$max_kar = 76;
		$jml_terbilang=strlen($terbilang);
		if ($jml_terbilang = $max_kar) {

			$cetak=$terbilang; 
		}
		else {
			$cetak = substr($terbilang,$max_kar,1); 
			if($cetak !=" "){
			while($cetak !=" "){
				$i=1;
				$max_kar=$max_kar+$i;
				$cetak = substr($terbilang,$max_kar,1); }
			$cetak = substr($terbilang,0,$max_kar);
			$jml_terbilang2=strlen($cetak);
			$terbilang3= substr($terbilang,$jml_terbilang2);
		} }
		if ($jml_terbilang = $max_kar) {

			$this->cezpdf->addText(150,720,10,"# ".$terbilang."Rupiah #");
		}
		else {
			$this->cezpdf->addText(150,720,10,"# ".$cetak." #");
			$this->cezpdf->addText(150,705,10,"# ".ltrim($terbilang3)."Rupiah #");
			}
	###1. Change by Cenot 22 Okt 2015  
	  

		$this->cezpdf->addText(50,670,10,$data->fld_btdesc);

		// Change by iqin 02 Jan 2016 ganti amount dengan fld_btbalance 
		$totalinvoice = round($data->fld_btbalance);

		$this->cezpdf->addText(480,670,10,"Rp. " . number_format($totalinvoice,0,',',',') );

		$this->cezpdf->addTextWrap(400,590,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,580,200,10,"( " .  $data->jabatan . " )",'center');
		$this->cezpdf->addText(70,555,10,"Kwitansi ini baru dianggap sah, setelah pembayaran dengan bilyet Giro/Cheque tsb. dapat di uangkan");

		$this->cezpdf->addText(50,620,10,"Bank" );
		$this->cezpdf->addText(50,605,10,"No." );
		$this->cezpdf->addText(50,590,10,"Tgl." ); 
		
		$this->cezpdf->addText(80,620,10,": ..............................................................................." );
		$this->cezpdf->addText(80,605,10,": ..............................................................................." );
		$this->cezpdf->addText(80,590,10,": ..............................................................................." );

		### Baris ke 2
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,495,50);
		$this->cezpdf->addTextWrap(90,530,200,14,"<b>KWITANSI</b>");
		$this->cezpdf->addTextWrap(90,515,200,11,"PT. DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addTextWrap(90,500,200,11, $data->lokasi);

		### Lines
		$this->cezpdf->line(30, 487, 580, 487);
		$this->cezpdf->line(30, 435, 580, 435);
		$this->cezpdf->line(30, 285, 580, 285);
		$this->cezpdf->line(30, 487, 30, 285);
		$this->cezpdf->line(580, 487, 580, 285);

		//$this->load->helper("terbilang");
		//$terbilang = ucwords(number_to_words($data->fld_btbalance));
		$this->cezpdf->addText(400,515,10,"Nomor");
		$this->cezpdf->addText(450,515,10,": " . $data->fld_btno);
		$this->cezpdf->addText(400,500,10,"Tanggal");
		$this->cezpdf->addText(450,500,10,": " . $data->date);

		$this->cezpdf->addText(50,470,10,"Sudah terima dari ");
		$this->cezpdf->addText(150,470,10, $data->fld_benm);
		$this->cezpdf->addText(50,455,10,"Uang Sebanyak ");

	###2. Change by Cenot 22 Okt 2015
	###2. Change by Iqin 10 Des 2015  penambahan $jml_terbilang <= $max_kar
		if ($jml_terbilang = $max_kar) 
			$this->cezpdf->addText(150,455,10,"# ".$cetak."Rupiah #");
		else {
			$this->cezpdf->addText(150,455,10,"# ".$cetak." #");
			$this->cezpdf->addText(150,440,10,"# ".ltrim($terbilang3)."Rupiah #");
			}
	###2. Change by Cenot 22 Okt 2015

		$this->cezpdf->addText(50,405,10,$data->fld_btdesc);

		// Change by iqin 02 Jan 2016 ganti amount dengan fld_btbalance 
		$totalinvoice = round($data->fld_btbalance);


		$this->cezpdf->addText(480,405,10,"Rp. " . number_format($totalinvoice,0,',',',') );

		$this->cezpdf->addTextWrap(400,325,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,315,200,10,"( " .  $data->jabatan . " )",'center');
		$this->cezpdf->addText(70,290,10,"Kwitansi ini baru dianggap sah, setelah pembayaran dengan bilyet Giro/Cheque tsb. dapat di uangkan");

		$this->cezpdf->addText(50,355,10,"Bank" );
		$this->cezpdf->addText(50,340,10,"No." );
		$this->cezpdf->addText(50,325,10,"Tgl." ); 
		
		$this->cezpdf->addText(80,355,10,": ..............................................................................." );
		$this->cezpdf->addText(80,340,10,": ..............................................................................." );
		$this->cezpdf->addText(80,325,10,": ..............................................................................." );

	   ### Baris ke 3
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,230,50);
		$this->cezpdf->addTextWrap(90,265,200,14,"<b>KWITANSI</b>");
		$this->cezpdf->addTextWrap(90,250,200,11,"PT. DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addTextWrap(90,235,200,11, $data->lokasi);

	   ### Lines
		$this->cezpdf->line(30, 222, 580, 222);
		$this->cezpdf->line(30, 170, 580, 170);
		$this->cezpdf->line(30, 20, 580, 20);
		$this->cezpdf->line(30, 222, 30, 20);
		$this->cezpdf->line(580, 222, 580, 20);

		##$this->load->helper("terbilang");
		##$terbilang = ucwords(number_to_words($data->fld_btbalance));
		$this->cezpdf->addText(400,250,10,"Nomor");
		$this->cezpdf->addText(450,250,10,": " . $data->fld_btno);
		$this->cezpdf->addText(400,235,10,"Tanggal");
		$this->cezpdf->addText(450,235,10,": " . $data->date);
		
		$this->cezpdf->addText(50,205,10,"Sudah terima dari ");
		$this->cezpdf->addText(150,205,10, $data->fld_benm);
		$this->cezpdf->addText(50,190,10,"Uang Sebanyak ");

	###3. Change by Cenot 22 Okt 2015
	###3. Change by Iqin 10 Des 2015  penambahan $jml_terbilang <= $max_kar
		if ($jml_terbilang = $max_kar) 
			$this->cezpdf->addText(150,190,10,"# ".$cetak."Rupiah #");
		else {
			$this->cezpdf->addText(150,190,10,"# ".$cetak." #");
			$this->cezpdf->addText(150,175,10,"# ".ltrim($terbilang3)."Rupiah #");
			}
	###3. Change by Cenot 22 Okt 2015
		
		$this->cezpdf->addText(50,140,10,$data->fld_btdesc);

		// Change by iqin 02 Jan 2016 ganti amount dengan fld_btbalance 
		$totalinvoice = round($data->fld_btbalance);

		$this->cezpdf->addText(480,140,10,"Rp. " . number_format($totalinvoice,0,',',',') );

		$this->cezpdf->addTextWrap(400,60,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,50,200,10,"( " .  $data->jabatan . " )",'center');
		$this->cezpdf->addText(70,25,10,"Kwitansi ini baru dianggap sah, setelah pembayaran dengan bilyet Giro/Cheque tsb. dapat di uangkan");

		$this->cezpdf->addText(50,90,10,"Bank" );
		$this->cezpdf->addText(50,75,10,"No." );
		$this->cezpdf->addText(50,60,10,"Tgl." ); 
		
		$this->cezpdf->addText(80,90,10,": ..............................................................................." );
		$this->cezpdf->addText(80,75,10,": ..............................................................................." );
		$this->cezpdf->addText(80,60,10,": ..............................................................................." );
		 
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Kwitansi " . $data->JenisInv . " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		  
		$output = $this->cezpdf->ezOutput();
		echo $output;
	  
	}
 
	function printINV4($fld_btid) {
		/*
		$getData = $this->db->query("
		select 
		t0.fld_btno,
		right(t0.fld_btno,5) 'NoInv',
		date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
		 date_format(t0.fld_btdtsa,'%d-%m-%Y') 'datesa',
		t1.fld_benm,t0.fld_btcmt,
		t2.fld_beaddrplc,
		t2.fld_beaddrstr,
		t1.fld_benpwp,
		format(t0.fld_btamt,2) 'amount',
		format(t0.fld_bttax,2) 'tax',
		format(t0.fld_btbalance,2) 'total',
		format(t0.fld_btuamt,2) 'dp',
		t3.fld_tyvalcfg 'ttd',
		t3.fld_tyvalnm 'lokasi',
		t3.fld_tyvalcmt 'jabatan',
		t0.fld_btdesc,
		t0.fld_btnoreff,
		t0.fld_btnoalt  
		from tbl_bth t0 
		left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
		left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
		left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
		where 
		t0.fld_btid='$fld_btid'
		");
		   
		$getData = $this->db->query("
		select 
		t0.fld_btno,
		date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
		 date_format(t0.fld_btdtsa,'%d-%m-%Y') 'datesa',
		t1.fld_benm,t0.fld_btcmt,
		t2.fld_beaddrplc,
		t2.fld_beaddrstr,
		t1.fld_benpwp,
		format(t0.fld_btamt,2) 'amount',
		format(t0.fld_bttax,2) 'tax',
		format(t0.fld_btbalance,2) 'total',
		format(t0.fld_btuamt,2) 'dp',
		t3.fld_tyvalcfg 'ttd',
		t3.fld_tyvalnm 'lokasi',
		t3.fld_tyvalcmt 'jabatan',
		t0.fld_btdesc,
		t0.fld_btnoreff,
		t0.fld_btnoalt  
		from tbl_bth t0 
		left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
		left join tbl_beaddr t2 on t2.fld_beid=t1.fld_beid
		left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
		where 
		t0.fld_btid='$fld_btid'
		");
		*/
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				date_format(t0.fld_btdtsa,'%d-%m-%Y') 'datesa',
				t0.fld_btcmt,
				case
					when t0.fld_btp02='' then (select fld_beaddrp01 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrp01 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_benm,
				case
					when t0.fld_btp02='' then (select fld_beaddrp05 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrp05 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_beaddrplc,
				case
					when t0.fld_btp02='' then (select fld_beaddrstr from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrstr from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_beaddrstr,
				case
					when t0.fld_btp02='' then (select fld_beaddrp02 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrtyid=2)
					else (select fld_beaddrp02 from tbl_beaddr where fld_beid=t1.fld_beid and fld_beaddrid=t0.fld_btp02)
				end fld_benpwp,
				format(t0.fld_btamt,2) 'amount',
				format(t0.fld_bttax,2) 'tax',
				format(t0.fld_btbalance,2) 'total',
				format(t0.fld_btuamt,2) 'dp',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcmt 'jabatan',
				t0.fld_btdesc,
				t0.fld_btnoreff,
				t0.fld_btnoalt,  
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beid=t1.fld_beid
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
			");
		
		$data = $getData->row();
		$currency = $data->currency;
		
		$this->load->library('cezpdf');
		$this->cezpdf->ezSetMargins(50,5,10,15);
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		  
		### Set Lines

		$this->cezpdf->line(15, 790, 580, 790);
		$this->cezpdf->line(15, 50, 580, 50);
		$this->cezpdf->line(580, 790, 580, 50);
		$this->cezpdf->line(15, 790, 15, 50);
	   
		$this->cezpdf->line(328, 778, 580, 778);
		$this->cezpdf->line(328, 767, 580, 767);
		$this->cezpdf->line(328, 715, 580, 715);
		$this->cezpdf->line(328, 790, 328, 715);

		$this->cezpdf->line(15, 600, 580, 600);
		$this->cezpdf->line(15, 575, 580, 575);
		$this->cezpdf->line(15, 360, 580, 360);

		$this->cezpdf->addText(17,780,10,"PT DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addText(17,770,10,"Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani");
		$this->cezpdf->addText(17,760,10,"Sleman Yogyakarta 55571");
		$this->cezpdf->addText(17,750,10,"Phone");
		$this->cezpdf->addText(70,750,10,": (0274)2850888");
		$this->cezpdf->addText(17,740,10,"Fax");
		$this->cezpdf->addText(70,740,10,": (0274)497468");
		$this->cezpdf->addText(17,730,10,"NPWP");
		$this->cezpdf->addText(70,730,10,": 01 852.157.5-542.000");

		$this->cezpdf->addText(400,780,10,"FAKTUR PENJUALAN");
		$this->cezpdf->addText(415,769,10,"FAKTUR PAJAK");
		$this->cezpdf->addText(330,758,10,"No. Faktur Penjualan");
		$this->cezpdf->addText(450,758,10,": $data->fld_btno");

		$this->cezpdf->addText(330,748,10,"Tanggal");
		$this->cezpdf->addText(450,748,10,": " .  $data->date);

		$this->cezpdf->addText(330,738,10,"No. Seri Faktur");
		$this->cezpdf->addText(450,738,10,": " . $data->fld_btnoreff);

		$this->cezpdf->addText(330,738,10,"No. Seri Faktur");
		$this->cezpdf->addText(450,738,10,": " . $data->fld_btnoreff);

		$this->cezpdf->addText(330,728,10,"Tanggal Jatuh Tempo");
		$this->cezpdf->addText(450,728,10,": $data->datesa");


		$this->cezpdf->addText(330,718,10,"PO/SO No");
		$this->cezpdf->addText(450,718,10,": " . $data->fld_btnoalt);
		
		$this->cezpdf->addText(17,680,10,"Kepada Yth :");
		$this->cezpdf->addText(17,665,10,$data->fld_benm);
		$this->cezpdf->addText(17,655,10,""/*$data->fld_beaddrplc*/);
		$this->cezpdf->ezSetY(657);
		$str = array(
			array('row1'=>$data->fld_beaddrstr));
		$this->cezpdf->ezTable($str,array('row1'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>1,'showLines'=>0,'xPos'=>17,'xOrientation'=>'right','width'=>200,'fontSize'=>'10','cols'=>array('row1'=>array('width'=>200))));
		$this->cezpdf->setStrokeColor(0,0,0);
		
		$this->cezpdf->addText(17,605,10,"NPWP : " . $data->fld_benpwp);

		$this->cezpdf->addText(17,590,10,"No.");
		$this->cezpdf->addText(17,580,10,"Urut");
		$this->cezpdf->addText(55,590,10,"Nama Barang / Jasa kena pajak");
		$this->cezpdf->addText(305,590,10,"Kuantitas");
		$this->cezpdf->addText(355,590,10,"Harga");
		$this->cezpdf->addText(405,590,10,"Harga Jual/Penngantian/Uang Muka");
		$this->cezpdf->addText(405,580,10,"Termin (Rp)");

		$this->cezpdf->addText(25,560,10,"01");
		$this->cezpdf->ezSetY(572);
		$desc = array(
			array('row1'=>$data->fld_btdesc));
		$this->cezpdf->ezTable($desc,array('row1'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>60,'xOrientation'=>'right','width'=>200,'fontSize'=>'10','cols'=>array('row1'=>array('width'=>200))));
		$this->cezpdf->setStrokeColor(0,0,0);
		$this->cezpdf->addTextWrap(450,560,100,10, $data->amount,'right');

		$this->cezpdf->line(50, 600, 50, 360);
		$this->cezpdf->line(300, 600, 300, 360);
		$this->cezpdf->line(350, 600, 350, 360);
		$this->cezpdf->line(400, 600, 400, 285);

		$this->cezpdf->addText(17,350,10,"Harga Jual/Penggantian/Uang Muka/Termin *)");
		$this->cezpdf->addTextWrap(450,350,100,10,$data->amount,'right');
		$this->cezpdf->addText(17,335,10,"Dikurangi Potongan Harga");
		$this->cezpdf->addTextWrap(450,335,100,10,$data->dp,'right');
		$this->cezpdf->addText(17,320,10,"Dasar Pengenaan Pajak");
		$this->cezpdf->addTextWrap(450,320,100,10,$data->amount,'right');
		$this->cezpdf->addText(17,305,10,"PPN = 10% x Dasar Pengenaan Pajak");
		$this->cezpdf->addTextWrap(450,305,100,10,$data->tax,'right');
		$this->cezpdf->addText(17,290,10,"Total yang harus dibayar");
		$this->cezpdf->addTextWrap(450,290,100,10,$data->total,'right');
		$this->cezpdf->line(70, 353, 225, 353);
		$this->cezpdf->line(15, 346, 580, 346);
		$this->cezpdf->line(15, 330, 580, 330);
		$this->cezpdf->line(15, 315, 580, 315);
		$this->cezpdf->line(15, 300, 580, 300);
		$this->cezpdf->line(15, 285, 580, 285);

		$this->cezpdf->addText(17,250,10,"Pajak Penjualan Atas Barang Mewah");
		$this->cezpdf->addText(35,235,10,"Tarif");
		$this->cezpdf->addText(120,235,10,"DPP");
		$this->cezpdf->addText(210,235,10,"PPn BM");
		$this->cezpdf->addText(50,160,10,"Jumlah");
		$this->cezpdf->addText(20,220,10,"................%");
		$this->cezpdf->addText(20,205,10,"................%");
		$this->cezpdf->addText(20,190,10,"................%");
		$this->cezpdf->addText(20,175,10,"................%");

		$this->cezpdf->addText(90,220,10,"Rp  ..................");
		$this->cezpdf->addText(90,205,10,"Rp  ..................");
		$this->cezpdf->addText(90,190,10,"Rp  ..................");
		$this->cezpdf->addText(90,175,10,"Rp  ..................");

		$this->cezpdf->addText(190,220,10,"Rp  ..................");
		$this->cezpdf->addText(190,205,10,"Rp  ..................");
		$this->cezpdf->addText(190,190,10,"Rp  ..................");
		$this->cezpdf->addText(190,175,10,"Rp  ..................");
		$this->cezpdf->addText(190,160,10,"Rp  ..................");

		$this->cezpdf->line(17, 246, 280, 246);
		$this->cezpdf->line(17, 230, 280, 230);
		$this->cezpdf->line(17, 246, 17, 155);
		$this->cezpdf->line(17, 170, 280, 170);
		$this->cezpdf->line(17, 155, 280, 155);
		$this->cezpdf->line(80, 246, 80, 170);
		$this->cezpdf->line(180, 246, 180, 155);
		$this->cezpdf->line(280, 246, 280, 155);

		$this->cezpdf->addText(17,120,10,"*) Coret yang tidak perlu");
		$this->cezpdf->addTextWrap(400,170,200,10,$data->lokasi . ", " . $data->date,'center');
		$this->cezpdf->addTextWrap(400,120,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,105,200,10,$data->jabatan,'center');
		
		if($data->fld_btnoreff != "") {
			$this->cezpdf->addText(30,90,10,"Catatan : ");
			$this->cezpdf->addText(90,90,10," Berdasarkan PMK Nomor 38/PMK.03/2010 Faktur");
			$this->cezpdf->addText(90,75,10," Penjualan ini dipersamakan dengan Faktur Pajak");
			$this->cezpdf->line(90, 100, 320, 100);
			$this->cezpdf->line(90, 65, 320, 65);
			$this->cezpdf->line(90, 100, 90, 65);
		$this->cezpdf->line(320, 100, 320, 65);
		}    

		$this->cezpdf->addText(400,55,10,"Pengganti No :");
		 
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Faktur Pajak " . $data->JenisInv . " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		  
		$output = $this->cezpdf->ezOutput();
		echo $output; 
	}
  
	### Cetak Faktur
	function printINV5($fld_btid) {
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				date_format(t0.fld_btdtsa,'%d-%m-%Y') 'datesa',
				t1.fld_benm,t0.fld_btcmt,
				t2.fld_beaddrplc,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				t0.fld_bttax,
				t0.fld_btamt,
				format(t0.fld_btbalance,0) 'amount',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalcmt 'jabatan',
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
			");
		$data = $getData->row();
		$currency = $data->currency;

		$viewrs = $this->db->query("
		select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
		t1.fld_btp24,
		if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
		t2.fld_tyvalnm 'veh_type',
		t3.fld_empnm 'driver',
		t4.fld_btamt,
		t4.fld_bttax,
		t4.fld_btbalance,
		t0.fld_btnoalt,
		t0.fld_btp01 'fld_route',
		t0.fld_vehicle,
		format(t0.fld_btamt01,0) 'amount'
		from tbl_trk_billing t0
		left join tbl_bth t1 on t1.fld_btnoalt=t0.fld_btno and t1.fld_bttyid=20
		left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
		left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
		left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
		where 
		t0.fld_btidp = $fld_btid
		");
		$viewrs = $viewrs->result_array();
		$this->load->library('cezpdf');
		$this->cezpdf->ezSetMargins(30,5,10,15);
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,760,35);
		$this->cezpdf->addTextWrap(70,780,200,11,"PT. DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addTextWrap(70,765,200,11, $data->lokasi);
		$this->cezpdf->addTextWrap(380,690,200,11, "Tanggal Faktur");
		$this->cezpdf->addTextWrap(460,690,200,11, ": $data->date");
		$this->cezpdf->addTextWrap(380,675,200,11, "Jatuh Tempo");
		$this->cezpdf->addTextWrap(460,675,200,11, ": $data->datesa");
		$this->cezpdf->addTextWrap(30,730,200,11,"No : " . $data->fld_btno);
		$this->cezpdf->ezSetY(730); 
		$this->cezpdf->ezText('<b>PROFORMA INVOICE</b>', 14, array('justification' => 'center')); 

		$this->cezpdf->addText(30,670,10,"Kepada Yth :");
		$this->cezpdf->addText(30,655,10,$data->fld_benm);
		$this->cezpdf->addText(30,640,10,$data->fld_beaddrplc);
		$this->cezpdf->addText(30,625,10,$data->fld_beaddrstr);
		$this->cezpdf->addText(30,600,10,"Berikut kami sampaikan rincian kegiatan yang akan di tagihkan :");

		$this->cezpdf->ezSetY(590); 
		$this->cezpdf->ezTable($viewrs,array('date'=>'Tanggal','fld_btnoalt'=>'No. DO','fld_route'=>'Rute','fld_vehicle'=>'Kendaraan','veh_type'=>'Jenis','driver'=>'Supir','amount'=>'Tarif'),'',
			array('rowGap'=>'4','showLines'=>'1','xPos'=>30,'xOrientation'=>'right','width'=>760,'shaded'=>0,'fontSize'=>'8',
			   'cols'=>array('date'=>array('width'=>60),
			   'fld_btnoalt'=>array('width'=>100,'justification'=>'center'),
			   'fld_route'=>array('width'=>170,'justification'=>'center'),
			   'fld_vehicle'=>array('width'=>60,'justification'=>'center'),
			   'driver'=>array('width'=>60,'justification'=>'center'),
			   'veh_type'=>array('width'=>50,'justification'=>'center'),
			   'amount'=>array('width'=>50,'justification'=>'right'),
			)));
		$this->cezpdf->ezSetDY(-10);
		$data_sum = array(
						array('row1'=>'Sub Total  :','row2'=>number_format($data->fld_btamt,0,',','.')),
						array('row1'=>'PPN  :','row2'=>number_format($data->fld_bttax,0,',','.')),
						array('row1'=>'Total Tarif  :','row2'=>number_format($data->fld_btbalance,0,',','.'))
			);
		$this->cezpdf->ezTable($data_sum,array('row1'=>'','row2'=>'','row3'=>''),'',
			array('rowGap'=>'4','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>30,'xOrientation'=>'right','width'=>760,'fontSize'=>'8',
			'cols'=>array('row1'=>array('width'=>500,'justification'=>'right'),'row2'=>array('width'=>50,'justification'=>'right'))));     

		$this->cezpdf->addTextWrap(400,180,200,10,$data->lokasi.  ", " . $data->date,'center');
		$this->cezpdf->addTextWrap(400,130,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,115,200,10,"( " . $data->jabatan . " )",'center');
		 
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Proforma Invoice " . $data->JenisInv . " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		  
		$output = $this->cezpdf->ezOutput();
		echo $output;
	}  

	function printINV5A($fld_btid) {
		$getData = $this->db->query("
			select 
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoInv',
				date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
				date_format(t0.fld_btdtsa,'%d-%m-%Y') 'datesa',
				t1.fld_benm,t0.fld_btcmt,
				t2.fld_beaddrplc,
				t2.fld_beaddrstr,
				t0.fld_btbalance,
				t0.fld_bttax,
				t0.fld_btamt,
				format(t0.fld_btbalance,0) 'amount',
				t3.fld_tyvalnm 'lokasi',
				t3.fld_tyvalcfg 'ttd',
				t3.fld_tyvalcmt 'jabatan',
				t9.fld_tyvalnm 'JenisInv'
			from tbl_bth t0 
				left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
				left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
				left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
				left join tbl_tyval t9 on t9.fld_tyvalcd=t0.fld_btflag and t9.fld_tyid=78
			where 
				t0.fld_btid='$fld_btid'
			");
		$data = $getData->row();
		$currency = $data->currency;

		$viewrs = $this->db->query("
			select t0.*, date_format(t1.fld_btdt,'%d-%m-%Y')'date',
				t1.fld_btp24,
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
		$viewrs = $viewrs->result_array();
		$this->load->library('cezpdf');
		$this->cezpdf->ezSetMargins(30,5,10,15);
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',30,760,35);
		$this->cezpdf->addTextWrap(70,780,200,11,"PT. DHARMAMULIA PRIMA KARYA");
		$this->cezpdf->addTextWrap(70,765,200,11, $data->lokasi);
		$this->cezpdf->addTextWrap(400,690,200,10, "Tanggal Faktur");
		$this->cezpdf->addTextWrap(480,690,200,10, ": $data->date");
		$this->cezpdf->addTextWrap(400,675,200,10, "Jatuh Tempo");
		$this->cezpdf->addTextWrap(480,675,200,10, ": $data->datesa");
		$this->cezpdf->addTextWrap(30,730,200,10,"No : " . $data->fld_btno);
		$this->cezpdf->ezSetY(730); 
		$this->cezpdf->ezText('<b>PROFORMA INVOICE</b>', 14, array('justification' => 'center')); 

		$this->cezpdf->addText(30,670,10,"Kepada Yth :");
		$this->cezpdf->addText(30,655,10,$data->fld_benm);
		$this->cezpdf->addText(30,640,10,$data->fld_beaddrplc);
		$this->cezpdf->addText(30,625,10,$data->fld_beaddrstr);
		$this->cezpdf->addText(30,600,10,"Berikut kami sampaikan rincian kegiatan yang akan di tagihkan :");

		$this->cezpdf->ezSetY(590); 
		$this->cezpdf->ezTable($viewrs,array('date'=>'Tanggal','fld_btnoalt'=>'No. DO','fld_route'=>'Rute','fld_vehicle'=>'Kendaraan','veh_type'=>'Jenis','driver'=>'Supir','lembur'=>'Tarif Lmbr.',
			'tarif'=>'Tarif Rit','amount'=>'Total'),'',
			array('rowGap'=>'4','colGap'=>'2','showLines'=>'1','xPos'=>30,'xOrientation'=>'right','width'=>760,'shaded'=>0,'fontSize'=>'7',
			   'cols'=>array('date'=>array('width'=>40),
			   'fld_btnoalt'=>array('width'=>80,'justification'=>'center'),
			   'fld_route'=>array('width'=>130,'justification'=>'center'),
			   'fld_vehicle'=>array('width'=>60,'justification'=>'center'),
			   'driver'=>array('width'=>60,'justification'=>'center'),
			   'veh_type'=>array('width'=>50,'justification'=>'center'),
			   'lembur'=>array('width'=>40,'justification'=>'right'),
			   'tarif'=>array('width'=>40,'justification'=>'right'),
			   'amount'=>array('width'=>40,'justification'=>'right'),
			)));
		$this->cezpdf->ezSetDY(-10);
		$data_sum = array(
				array('row1'=>'Sub Total  :','row2'=>number_format($data->fld_btamt,0,',','.')),
				array('row1'=>'PPN  :','row2'=>number_format($data->fld_bttax,0,',','.')),
				array('row1'=>'Total Tarif  :','row2'=>number_format($data->fld_btbalance,0,',','.'))
			);
		$this->cezpdf->ezTable($data_sum,array('row1'=>'','row2'=>'','row3'=>''),'',
			array('rowGap'=>'4','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>30,'xOrientation'=>'right','width'=>760,'fontSize'=>'7',
			'cols'=>array('row1'=>array('width'=>480,'justification'=>'right'),'row2'=>array('width'=>60,'justification'=>'right'))));     

		$this->cezpdf->addTextWrap(400,180,200,10,$data->lokasi.  ", " . $data->date,'center');
		$this->cezpdf->addTextWrap(400,130,200,10,$data->ttd,'center');
		$this->cezpdf->addTextWrap(400,115,200,10,"( " . $data->jabatan . " )",'center');
		 
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=Proforma Invoice " . $data->JenisInv . " - " . $data->NoInv .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		  
		$output = $this->cezpdf->ezOutput();
		echo $output;
	}  

	function printDOTruck($fld_btid) {
		$fld_btid =  $this->uri->segment(3);
		$getData =$this->db->query("
			select
				t0.fld_btid,
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoDO',
				t0.fld_btstat,
				date_format(t0.fld_btdt,'%d-%m-%Y %H:%i') 'date',
				date_format(t0.fld_btdtso,'%d-%m-%Y %H:%i') 'bongkar',
				date_format(t0.fld_btdt,'%H:%i') 'time',
				t0.fld_btp01 'purchase_by',
				t8.fld_empnm 'posted_by', 
				t2.fld_benm 'customer',
				t0.fld_btp02 'destination1',
				t12.fld_areanm 'destination',
				if(t0.fld_btp02=1,t0.fld_btp05,t3.fld_bticd) 'v_number',
				t4.fld_tyvalnm 'v_type',
				if(t0.fld_btp02=1,t0.fld_btp06,t10.fld_empnm) 'driver',    
				t0.fld_btdesc 'desc',
				t1.fld_empnm 'chasier',
				format(t0.fld_btp01,2) 'delivery_cash',
				t0.fld_btloc 'location',
				t13.fld_empnm 'asst_driver',
				t10.fld_empmobile,
				substring(t0.fld_btp10,1,34) 'albongkar',
				substring(t0.fld_btp13,1,34) 'almuat',
				t0.fld_btp08,
				t0.fld_btqty,
				t14.fld_unitnm,
				t0.fld_btp19,
				t0.fld_btp20,
				concat(t15.fld_userp03, ' ' , t15.fld_userp04) 'fld_username'
			from tbl_bth t0 
				left join tbl_emp t1 on t1.fld_empid=t0.fld_baidv
				left join tbl_be t2 on t2.fld_beid = t0.fld_baidc
				left join tbl_bti t3 on t3.fld_btiid = t0.fld_btp12
				left join tbl_tyval t4 on t4.fld_tyvalcd = t0.fld_btflag and t4.fld_tyid=19
				left join tbl_emp t8 on t8.fld_empid=t0.fld_baidp
				left join tbl_emp t10 on t10.fld_empid=t0.fld_btp11
				left join tbl_emp t13 on t13.fld_empid=t0.fld_btp03
				left join tbl_route t11 on t11.fld_routeid=t0.fld_btp09
				left join tbl_area t12 on t12.fld_areaid=t11.fld_routeto
				left join tbl_unit t14 on t14.fld_unitid=t0.fld_btp14
				left join tbl_user t15 on t15.fld_userid=t0.fld_baidp
			where 
				t0.fld_btid='$fld_btid'
			");
		$data = $getData->row();
		if($data->fld_btstat == 1) {
			$this->db->query("update tbl_bth set fld_btstat=2 where fld_btid=$fld_btid limit 1");
			}
		
		$this->load->library('cezpdf');
	//     $this->cezpdf->Cezpdf(array(21.5,14),$orientation='portrait');
		$this->cezpdf->ezSetMargins(0,5,10,5);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,783,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
			);
	//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,755,15,'SURAT PERINTAH PENGANGKUTAN');
		$this->cezpdf->line(10, 780, 585, 780);
		$this->cezpdf->line(10, 740, 585, 740);
		$this->cezpdf->line(10, 570, 585, 570);
		$this->cezpdf->line(10, 780, 10, 570);
		$this->cezpdf->line(350, 780, 350, 740);
		$this->cezpdf->line(585, 780, 585, 570);
		$this->cezpdf->line(30, 600, 130, 600);
		$this->cezpdf->line(170, 600, 270, 600);
		$this->cezpdf->line(320, 600, 420, 600);
		$this->cezpdf->line(460, 600, 560, 600);
		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
			);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
		  ##Print Detail
	   $this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
				'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
		#main left
		$this->cezpdf->addText(30,725,9,'Pelanggan      ');
		$this->cezpdf->addText(30,715,9,'Tujuan   ');
		$this->cezpdf->addText(30,705,9,'Nomor Mobil');
		$this->cezpdf->addText(30,695,9,'Armada     ');
		$this->cezpdf->addText(30,685,9,'Supir      ');
	 
		$this->cezpdf->addText(120,725,9,': ' . $data->customer);
		$this->cezpdf->addText(120,715,9,': ' . $data->destination);
		$this->cezpdf->addText(120,705,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,695,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,685,9,': ' . $data->driver);

	#main right
		$this->cezpdf->addText(305,725,9,'Komoditas ');
		$this->cezpdf->addText(405,725,9,': ' . $data->fld_btp08);
		$this->cezpdf->addText(305,715,9,'Jumlah ');
		$this->cezpdf->addText(405,715,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,705,9,'Alamat Muat ');
		$this->cezpdf->addText(405,705,9,': ' . $data->almuat);
		$this->cezpdf->addText(305,695,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,695,9,': ' . $data->albongkar);
		$this->cezpdf->addText(305,685,9,'Nomor HP. ');
		$this->cezpdf->addText(405,685,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,675,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,675,9,': ' . $data->bongkar);
	  
		$this->cezpdf->addTextWrap(60,585,200,9,'Pengirim');
		$this->cezpdf->addText(200,585,9,'Supir');
		$this->cezpdf->addTextWrap(340,585,200,9,'Penerima');
		$this->cezpdf->addText(480,585,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,603,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,603,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');
		
	## Copy ke dua
	   $this->cezpdf->ezSetDy(-200);
	   $this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,518,28);
	   $this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
	   //$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
	   $this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
				);
	//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,490,15,'SURAT PERINTAH PENGANGKUTAN');
		$this->cezpdf->setStrokeColor(0,0,0);
		$this->cezpdf->line(10, 515, 585, 515);
		$this->cezpdf->line(10, 475, 585, 475);
		$this->cezpdf->line(10, 305, 585, 305);
		$this->cezpdf->line(10, 515, 10, 305);
		$this->cezpdf->line(350, 515,350, 475);
		$this->cezpdf->line(585, 515, 585, 305); 
		$this->cezpdf->line(30, 335, 130, 335);
		$this->cezpdf->line(170, 335, 270, 335);
		$this->cezpdf->line(320, 335, 420, 335);
		$this->cezpdf->line(460, 335, 560, 335);
			
		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
		);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
	##Print Detail
		$this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
			'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
	#main left
		$this->cezpdf->addText(30,460,9,'Pelanggan      ');
		$this->cezpdf->addText(30,450,9,'Tujuan   ');
		$this->cezpdf->addText(30,440,9,'Nomor Mobil');
		$this->cezpdf->addText(30,430,9,'Armada     ');
		$this->cezpdf->addText(30,420,9,'Supir      ');
		 
		$this->cezpdf->addText(120,460,9,': ' . $data->customer);
		$this->cezpdf->addText(120,450,9,': ' . $data->destination);
		$this->cezpdf->addText(120,440,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,430,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,420,9,': ' . $data->driver);

	#main right
		$this->cezpdf->addText(305,460,9,'Komoditas ');
		$this->cezpdf->addText(405,460,9,': ' . $data->fld_btp08);
		$this->cezpdf->addText(305,450,9,'Jumlah ');
		$this->cezpdf->addText(405,450,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,440,9,'Alamat Muat ');
		$this->cezpdf->addText(405,440,9,': ' . $data->almuat);
		$this->cezpdf->addText(305,430,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,430,9,': ' . $data->albongkar);
		$this->cezpdf->addText(305,420,9,'Nomor HP. ');
		$this->cezpdf->addText(405,420,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,410,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,410,9,': ' . $data->bongkar);
			   
		$this->cezpdf->addTextWrap(60,320,200,9,'Pengirim');
		$this->cezpdf->addText(200,320,9,'Supir');
		$this->cezpdf->addTextWrap(340,320,200,9,'Penerima');
		$this->cezpdf->addText(480,320,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,338,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,338,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');
		
	### Copy Ke tiga
		$this->cezpdf->ezSetDy(-200);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,253,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
				);
		//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,225,15,'SURAT PERINTAH PENGANGKUTAN');
		$this->cezpdf->setStrokeColor(0,0,0);
		$this->cezpdf->line(10, 250, 585, 250);
		$this->cezpdf->line(10, 210, 585, 210);
		$this->cezpdf->line(10, 40, 585, 40);
		$this->cezpdf->line(10, 250, 10, 40);
		$this->cezpdf->line(350, 250, 350, 210);
		$this->cezpdf->line(585, 250, 585, 40);

		$this->cezpdf->line(30, 70, 130, 70);
		$this->cezpdf->line(170, 70, 270, 70);
		$this->cezpdf->line(320, 70, 420, 70);
		$this->cezpdf->line(460, 70, 560, 70);

		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
		);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
	##Print Detail
		$this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
			'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
	#main left
		$this->cezpdf->addText(30,195,9,'Pelanggan      ');
		$this->cezpdf->addText(30,185,9,'Tujuan   ');
		$this->cezpdf->addText(30,175,9,'Nomor Mobil');
		$this->cezpdf->addText(30,165,9,'Armada     ');
		$this->cezpdf->addText(30,155,9,'Supir      ');
	 
		$this->cezpdf->addText(120,195,9,': ' . $data->customer);
		$this->cezpdf->addText(120,185,9,': ' . $data->destination);
		$this->cezpdf->addText(120,175,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,165,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,155,9,': ' . $data->driver);

	#main right
		$this->cezpdf->addText(305,195,9,'Komoditas ');
		$this->cezpdf->addText(405,195,9,': ' . $data->fld_btp08);
		$this->cezpdf->addText(305,185,9,'Jumlah ');
		$this->cezpdf->addText(405,185,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,175,9,'Alamat Muat ');
		$this->cezpdf->addText(405,175,9,': ' . $data->almuat);
		$this->cezpdf->addText(305,165,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,165,9,': ' . $data->albongkar);
		$this->cezpdf->addText(305,155,9,'Nomor HP. ');
		$this->cezpdf->addText(405,155,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,145,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,145,9,': ' . $data->bongkar);
	  
		$this->cezpdf->addTextWrap(60,55,200,9,'Pengirim');
		$this->cezpdf->addText(200,55,9,'Supir');
		$this->cezpdf->addTextWrap(340,55,200,9,'Penerima');
		$this->cezpdf->addText(480,55,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,78,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,78,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');

		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=do_trucking.pdf");
		header("Content-Disposition: attachment; filename=Surat Jalan - " . $data->NoDO .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		$output = $this->cezpdf->ezOutput();
		echo $output;
	}

	function cekDateComplete($fld_btid) {
		$gsf = $this->db->query("select * from ffis.tbl_btd_bc23_container t0  where t0.fld_btidp = $fld_btid ");
		$complete_status = 0;
		if ($gsf->num_rows() > 0) {
			foreach ($gsf->result() as $row) {
			if(($row->fld_baidc > 0 && $row->fld_btp02 != "") || ($row->fld_btp03 != "")) {
				$complete_status = $complete_status + 1;
				}
			}
		}
		if ($complete_status  < $gsf->num_rows()) {
			$this->db->query("update ffis.tbl_bth set fld_btp06 = '' where fld_btid = $fld_btid limit 1");
			}
	}

	function setCashAdvance($fld_btid,$fld_baidc,$route,$vehicle,$custom,$location,$fld_btflag,$route2) {
		$data = $this->db->query("select *  from tbl_bti t0 
		    where 
				t0.fld_bticid=10 
				and t0.fld_btiflag='$vehicle'
				and t0.fld_btip02='$route' 
				limit 1");
		$data = $data->row();
		$data2 = $this->db->query("select *  from tbl_bti t0 
			where 
				t0.fld_bticid=10 
			    and t0.fld_btiflag='$vehicle'
			    and t0.fld_btip02='$route2' 
				limit 1");
		$data2 = $data2->row();
		if($data->fld_btip08 > 0 ) {
			$cash_advance = $data->fld_btip08;
			$this->db->query("update tbl_bth set fld_btp21 = '$cash_advance', fld_btp27 = $data->fld_btival where fld_btid = $fld_btid and fld_bttaxno != 1 and fld_btp02 != 1 limit 1");
		}
		if($route2 > 0 && $data2->fld_btip09 > 0 ) {
			$cash_blong = $data2->fld_btip09;
			$this->db->query("update tbl_bth set fld_btuamt = '$cash_blong' where fld_btid = $fld_btid limit 1");
		} 
		$this->db->query("update tbl_bth set 
				fld_btp27 = if(fld_btp09 = '',0,fld_btp27),
				fld_btuamt = if(fld_btp18 = '',0,fld_btuamt),
				fld_btp03 = (select sum(tx1.fld_btamt01) from tbl_btd_route tx0 
				left join tbl_dropdistance tx1 on tx1.fld_btflag = tx0.fld_btiid and tx1.fld_btiid = $fld_btflag
			where tx0.fld_btidp = $fld_btid),
				fld_btp21 = fld_btp27 * (select fld_tyvalcfg from tbl_tyval where fld_tyid=68 and fld_tyvalcd=6),
				fld_btdtso = DATE_ADD(fld_btdt, INTERVAL (select ifnull(fld_routeltime,0)  from tbl_route tz0 where tz0.fld_routeid='$route' limit 1) HOUR)
				where fld_btid = $fld_btid limit 1");
		$this->db->query("update tbl_bth set fld_btamt = ifnull(fld_btuamt,0) + ifnull(fld_btp21,0) + ifnull(fld_btp03,0) + ifnull(fld_btp28,0) where fld_btid = $fld_btid limit 1"); 
		#### Subcon or Own
		$this->db->query("update tbl_bth set 
				fld_btp12 = if(fld_btp02 = 1,0,fld_btp12),
				fld_btp11 = if(fld_btp02 = 1,0,fld_btp11),
				fld_btp27 = if(fld_btp02 = 1,0,fld_btp27),
				fld_btp21 = if(fld_btp02 = 1,0,fld_btp21),
				fld_btuamt = if(fld_btp02 = 1,0,fld_btuamt),
				fld_btp28 = if(fld_btp02 = 1,0,fld_btp28),
				fld_btp03 = if(fld_btp02 = 1,0,fld_btp03),
				fld_btamt = if(fld_btp02 = 1,0,fld_btamt),
				fld_btp31 = if(fld_btp02 = 1,0,fld_btp31),
				fld_btp04 = if(fld_btp02 = 1,fld_btp04,0),
				fld_btp07 = if(fld_btp02 = 1,fld_btp07,''),
				fld_btp05 = if(fld_btp02 = 1,fld_btp05,''),
				fld_btp01 = if(fld_btp02 = 1,fld_btp01,0),
				fld_btp06 = if(fld_btp02 = 1,fld_btp06,''),
				fld_btp16 = if(fld_btp02 = 1,fld_btp16,0)
			where fld_btid = $fld_btid limit 1");
		}
  
	function TruckCashSettlement($fld_btid,$dtsa,$dtso) {
		$location = $this->session->userdata('location');
		$data = $this->db->query("select
				tx0.fld_btid 'reffid', 
				tx0.fld_btno 'do_number',
				tx7.fld_empnm,
				tx6.fld_benm,
				tx2.fld_bticd,tx0.fld_btp23 'amount',concat('Kegiatan Operasional truck') 'cost_type'
			from
				tbl_bth tx0
				left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
				left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
				left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
				left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
				left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
				left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
				left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
			where
				tx0.fld_bttyid=20
				and
				tx0.fld_btstat=3
				and
				date_format(tx0.fld_btdt,'%d-%m-%Y') between '$dtsa' and '$dtso'
				");
                              
		foreach ($data->result() as $rdata) {
			$this->db->query("insert ignore into tbl_trk_settlement (fld_btidp,fld_btreffid,fld_btno,fld_driver,fld_customer,fld_vehicle,fld_trk_settlementamt,fld_trk_settlementtype,fld_account,fld_btflag,fld_saving) values ('$fld_btid','$rdata->reffid','$rdata->do_number','$rdata->fld_empnm','$rdata->fld_benm','$rdata->fld_bticd','$rdata->amount','$rdata->cost_type','$rdata->account','$rdata->type','$rdata->saving')");
		}
	}
  
	/*function TruckCashTransfer($fld_btid,$dtsa,$dtso) {
		$location = $this->session->userdata('location');
		$data = $this->db->query("select
				tx0.fld_btid 'reffid', 
				if(tx0.fld_bttyid=20,tx0.fld_btnoalt,tx0.fld_btno) 'do_number',
				if(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm',
				tx7.fld_empid,
				if(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank',
				if(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek',
				if(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile',
				tx7.fld_emploan,
				tx6.fld_benm,
				if(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd',
				case 
					when tx0.fld_bttyid = 13 then 
						if(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt)
						when tx0.fld_bttyid=20 and tx0.fld_btp02 !=1 then
						if(tx0.fld_btp22 < 0,abs(tx0.fld_btp22),0)  + if(tx0.fld_btbalance < 0,abs(tx0.fld_btbalance),0) 
					when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then
						tx0.fld_btp01 - tx0.fld_btp16)
				end 'amount',
				case
					when tx0.fld_bttyid=13 and tx0.fld_btp02 = 1 then concat('Uang DP Subkon')
					when tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 then concat('Uang Jalan')
					when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then concat('Sisa Sewa Subkon')
					when tx0.fld_bttyid=20 and tx0.fld_btp02 != 1 then concat('Kekurangan POD')
				end 'cost_type',
				1 'type',
				if(tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 ,round(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving'
			from
				tbl_bth tx0
				left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
				left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
				left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
				left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
				left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
				left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
				left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
				left join tbl_tyval tx8 on tx8.fld_tyvalcd=tx0.fld_btiid and tx8.fld_tyid=40
				left join tbl_bti tx9 on tx9.fld_btiid=4559
				left join tbl_tyval tx10 on tx10.fld_tyvalcd=6 and tx10.fld_tyid=68
				left join tbl_be tx11 on tx11.fld_beid=tx0.fld_btp04
			where
				tx0.fld_bttyid in (13,20)
				and
				if(tx0.fld_bttyid=20,tx0.fld_btstat = 3,tx0.fld_btstat=2)
				and
				tx0.fld_btiid=1
				and
				date_format(tx0.fld_btdt,'%d-%m-%Y') between '$dtsa' and '$dtso'
				having amount > 0
			");
		foreach ($data->result() as $rdata) {
			$amount = $rdata->amount;
			$deduction = 0;
			if($rdata->fld_emploan > 0) {
				if($rdata->fld_emploan <= $rdata->amount) {
					$amount = $rdata->amount - $rdata->fld_emploan;
					$this->db->query("update tbl_emp set fld_emploan=0 where fld_empid = '$rdata->fld_empid'");
					$deduction = $rdata->fld_emploan;
				}
				if($rdata->fld_emploan > $rdata->amount) {
					$amount = 0;
					$this->db->query("update tbl_emp set fld_emploan=$rdata->fld_emploan - $rdata->amount where fld_empid = '$rdata->fld_empid'");
					$deduction = $rdata->amount;
				}
			}
			$this->db->query("insert ignore into tbl_trk_transfer
				(fld_btidp,fld_btreffid,fld_btno,fld_driver,fld_customer,fld_vehicle,fld_trk_settlementamt,fld_trk_settlementtype,fld_account,fld_btflag,fld_saving,fld_btp01,fld_btp02,fld_btp03,fld_deduction) 
				values 
				('$fld_btid','$rdata->reffid','$rdata->do_number','$rdata->fld_empnm','$rdata->fld_benm','$rdata->fld_bticd','$amount','$rdata->cost_type','$rdata->account','$rdata->type','$rdata->saving','$rdata->fld_empmobile','$rdata->fld_empbank','$rdata->fld_empnorek','$deduction')");
       
		}
	}
  */
  
	function TruckCashTransfer($fld_btid,$dtsa,$dtso) {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$location = $this->session->userdata('location');
		$cod=$this->input->post('fld_btp01');
		$this->db->query("delete from tbl_trk_transfer where fld_btidp='$fld_btid'");
		/*
		$data = $this->db->query("select
				tx0.fld_btid 'reffid', 
				if(tx0.fld_bttyid=20,tx0.fld_btnoalt,tx0.fld_btno) 'do_number',
				if(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm',
				tx7.fld_empid,
				if(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank',
				if(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek',
				if(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile',
				tx7.fld_emploan,
				tx6.fld_benm,
				if(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd',
				case 
					when tx0.fld_bttyid = 13 then 
						if(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt)
					when tx0.fld_bttyid=20 and tx0.fld_btp02 !=1 then
						if(tx0.fld_btp22 < 0,abs(tx0.fld_btp22),0)  + if(tx0.fld_btbalance < 0,abs(tx0.fld_btbalance),0) 
					when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then
						tx0.fld_btp01 - tx0.fld_btp16)
				end 'amount',
				case
					when tx0.fld_bttyid=13 and tx0.fld_btp02 = 1 then concat('Uang DP Subkon')
					when tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 then concat('Uang Jalan')
					when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then concat('Sisa Sewa Subkon')
					when tx0.fld_bttyid=20 and tx0.fld_btp02 != 1 then concat('Kekurangan POD')
				end 'cost_type',
				1 'type',
				if(tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 ,round(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving'
			from
				tbl_bth tx0
				left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
				left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
				left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
				left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
				left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
				left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
				left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
				left join tbl_tyval tx8 on tx8.fld_tyvalcd=tx0.fld_btiid and tx8.fld_tyid=40
				left join tbl_bti tx9 on tx9.fld_btiid=4559
				left join tbl_tyval tx10 on tx10.fld_tyvalcd=6 and tx10.fld_tyid=68
				left join tbl_be tx11 on tx11.fld_beid=tx0.fld_btp04
			where
				tx0.fld_bttyid in (13,20)
				and
				if(tx0.fld_bttyid=20,tx0.fld_btstat = 3,tx0.fld_btstat=2)
				and
				tx0.fld_btiid=1
				and
				date_format(tx0.fld_btdt,'%d-%m-%Y') between '$dtsa' and '$dtso'
				having amount > 0
				");			
	*/
		if ($cod==1)
		{
			$dtsa = date_create($dtsa);
			$dtsa=date_format($dtsa, 'Y-m-d');
			$dtso = date_create($dtso);
			$dtso=date_format($dtso, 'Y-m-d');
			$sql="			
				select
					tx0.fld_btid 'reffid', 
					tx0.fld_btno 'do_number',
					if(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm',
					tx7.fld_empid,
					if(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank',
					if(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek',
					if(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile',
					tx7.fld_emploan,
					tx6.fld_benm,
					if(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd',
					case 
						when tx0.fld_bttyid = 13 then 
							if(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt)
					end 'amount',
					case
						when tx0.fld_bttyid=13 and tx0.fld_btp02 = 1 then concat('Uang DP Subkon')
						when tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 then concat('Uang Jalan')
					end 'cost_type',
					1 'type',
					if(tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 ,round(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving',
					concat(tx4.fld_areanm , ' ke ' , tx5.fld_areanm) 'rute'		
				from
					tbl_bth tx0
					left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
					left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
					left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
					left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
					left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
					left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
					left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
					left join tbl_tyval tx8 on tx8.fld_tyvalcd=tx0.fld_btiid and tx8.fld_tyid=40
					left join tbl_bti tx9 on tx9.fld_btiid=4559
					left join tbl_tyval tx10 on tx10.fld_tyvalcd=6 and tx10.fld_tyid=68
					left join tbl_be tx11 on tx11.fld_beid=tx0.fld_btp04
				where
					tx0.fld_bttyid=13 
					and tx0.fld_btstat=2
					and tx0.fld_btiid=1 and tx6.fld_bep11 ='1' AND tx0.fld_btp31 > 0
					AND tx0.fld_btdt >='$dtsa 00:00:00' 
					and tx0.fld_btdt <= '$dtso 23:59:59'
					having amount > 0";
		} else {
			$dtsa = date_create($dtsa);
			$dtsa=date_format($dtsa, 'Y-m-d');
			$dtso = date_create($dtso);
			$dtso=date_format($dtso, 'Y-m-d');
			$tgl1=$this->input->post('fld_btdtsa');
			$tgl2=$this->input->post('fld_btdtso');
			$sql="SELECT tx0.fld_btdt, tx0.fld_btid 'reffid', tx0.fld_btno 'do_number', IF(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm', tx7.fld_empid, IF(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank', IF(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek', IF(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile', tx7.fld_emploan, tx6.fld_benm, IF(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd', CASE WHEN tx0.fld_bttyid = 13 THEN IF(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt) END 'amount', CASE WHEN tx0.fld_bttyid=13 AND tx0.fld_btp02 = 1 THEN CONCAT('Uang DP Subkon') WHEN tx0.fld_bttyid=13 AND tx0.fld_btp02 != 1 THEN CONCAT('Uang Jalan') END 'cost_type', 1 'type', IF(tx0.fld_bttyid=13 AND tx0.fld_btp02 != 1, ROUND(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving', CONCAT(tx4.fld_areanm, ' ke ', tx5.fld_areanm) 'rute'
				FROM tbl_bth tx0
					LEFT JOIN tbl_tyval tx1 ON tx1.fld_tyvalcd=tx0.fld_btflag AND tx1.fld_tyid=19
					LEFT JOIN tbl_bti tx2 ON tx2.fld_btiid=tx0.fld_btp12
					LEFT JOIN tbl_route tx3 ON tx3.fld_routeid =tx0.fld_btp09
					LEFT JOIN tbl_area tx4 ON tx4.fld_areaid=tx3.fld_routefrom
					LEFT JOIN tbl_area tx5 ON tx5.fld_areaid=tx3.fld_routeto
					LEFT JOIN tbl_be tx6 ON tx6.fld_beid=tx0.fld_baidc
					LEFT JOIN tbl_emp tx7 ON tx7.fld_empid=tx0.fld_btp11
					LEFT JOIN tbl_tyval tx8 ON tx8.fld_tyvalcd=tx0.fld_btiid AND tx8.fld_tyid=40
					LEFT JOIN tbl_bti tx9 ON tx9.fld_btiid=4559
					LEFT JOIN tbl_tyval tx10 ON tx10.fld_tyvalcd=6 AND tx10.fld_tyid=68
					LEFT JOIN tbl_be tx11 ON tx11.fld_beid=tx0.fld_btp04
				WHERE tx0.fld_bttyid=13 and tx0.fld_btiid=1 
					and if(tx0.fld_bttyid=20,tx0.fld_btstat = 3,tx0.fld_btstat=2)
					and if(tx6.fld_bep11 =1,tx0.fld_btp02 =1, tx0.fld_btp31 >= 0)
					AND tx0.fld_btdt >='$dtsa 00:00:00' 
					and tx0.fld_btdt <= '$dtso 23:59:59'
					HAVING amount >= 0
			union ALL
				select tx0.fld_btdt,
					tx0.fld_btid 'reffid', 
					if(tx0.fld_bttyid=20,tx0.fld_btnoalt,tx0.fld_btno) 'do_number',
					if(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm',
					tx7.fld_empid,
					if(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank',
					if(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek',
					if(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile',
					tx7.fld_emploan,
					tx6.fld_benm,
					if(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd',
					case 
						when tx0.fld_bttyid = 13 then 
							if(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt)
						when tx0.fld_bttyid=20 and tx0.fld_btp02 !=1 then
							if(tx0.fld_btp22 < 0,abs(tx0.fld_btp22),0)  + if(tx0.fld_btbalance < 0,abs(tx0.fld_btbalance),0) 
						when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then
							(tx0.fld_btp01 - tx0.fld_btp16)
					end 'amount',
					case
						when tx0.fld_bttyid=13 and tx0.fld_btp02 = 1 then concat('Uang DP Subkon')
						when tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 then concat('Uang Jalan')
						when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then concat('Sisa Sewa Subkon')
						when tx0.fld_bttyid=20 and tx0.fld_btp02 != 1 then concat('Kekurangan POD')
					end 'cost_type',
					1 'type',
					if(tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 ,round(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving',
						concat(tx4.fld_areanm , ' ke ' , tx5.fld_areanm) 'rute'	            
				from
					tbl_bth tx0
					left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
					left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
					left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
					left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
					left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
					left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
					left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
					left join tbl_tyval tx8 on tx8.fld_tyvalcd=tx0.fld_btiid and tx8.fld_tyid=40
					left join tbl_bti tx9 on tx9.fld_btiid=4559
					left join tbl_tyval tx10 on tx10.fld_tyvalcd=6 and tx10.fld_tyid=68
					left join tbl_be tx11 on tx11.fld_beid=tx0.fld_btp04
				where
					tx0.fld_bttyid =20
					and
					if(tx0.fld_bttyid=20,tx0.fld_btstat = 3,tx0.fld_btstat=2)
					and
					tx0.fld_btiid=1
					AND tx0.fld_btdt >='".$dtsa." 00:00:00' 
					and tx0.fld_btdt <= '".$dtso." 23:59:59'
					having amount > 0";
		}	
		$data=$this->db->query($sql);
		//print $sql;
		//exit();
		foreach ($data->result() as $rdata) {
			$amount = $rdata->amount;
			$deduction = 0;
			$account='';
			if($rdata->fld_emploan > 0) {
				if($rdata->fld_emploan <= $rdata->amount) {
				$amount = $rdata->amount - $rdata->fld_emploan;
				$this->db->query("update tbl_emp set fld_emploan=0 where fld_empid = '$rdata->fld_empid'");
				$deduction = $rdata->fld_emploan;
				}
				if($rdata->fld_emploan > $rdata->amount) {
				$amount = 0;
				$this->db->query("update tbl_emp set fld_emploan=$rdata->fld_emploan - $rdata->amount where fld_empid = '$rdata->fld_empid'");
				$deduction = $rdata->amount;
				}
			}
			$this->db->query("insert ignore into tbl_trk_transfer
				(fld_btidp,fld_btreffid,fld_btno,fld_driver,fld_customer,fld_vehicle,fld_trk_settlementamt,fld_trk_settlementtype,fld_account,fld_btflag,fld_saving,fld_btp01,fld_btp02,fld_btp03,fld_deduction,fld_btp04) 
				values 
				('$fld_btid','$rdata->reffid','$rdata->do_number','$rdata->fld_empnm','$rdata->fld_benm','$rdata->fld_bticd','$amount','$rdata->cost_type','$account','$rdata->type','$rdata->saving','$rdata->fld_empmobile','$rdata->fld_empbank','$rdata->fld_empnorek','$deduction','$rdata->rute')");
		}
		//exit();
	}
  
	function UpdateTruckCashTransfer($btno) {
		//print $btno;
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1'); 
		$fldbtid=$this->db->query("select fld_btidp from tbl_trk_transfer where fld_btno='$btno'")->row()->fld_btidp;
		if (!empty($fldbtid))
		{
			$location = $this->session->userdata('location');
			$sql="select
					tx0.fld_btid 'reffid', 
					if(tx0.fld_bttyid=20,tx0.fld_btnoalt,tx0.fld_btno) 'do_number',
					if(tx0.fld_btp02=1,tx0.fld_btp06,tx7.fld_empnm) 'fld_empnm',
					tx7.fld_empid,
					if(tx0.fld_btp02 = 1, tx11.fld_bep08,tx7.fld_empbank) 'fld_empbank',
					if(tx0.fld_btp02 = 1, tx11.fld_bep09,tx7.fld_empnorek) 'fld_empnorek',
					if(tx0.fld_btp02 = 1, tx0.fld_btp07,tx7.fld_empmobile) 'fld_empmobile',
					tx7.fld_emploan,
					tx6.fld_benm,
					if(tx0.fld_btp02=1,tx0.fld_btp05,tx2.fld_bticd) 'fld_bticd',
					case 
						when tx0.fld_bttyid = 13 then 
							if(tx0.fld_btp02=1,tx0.fld_btp16,tx0.fld_btamt)
						when tx0.fld_bttyid=20 and tx0.fld_btp02 !=1 then
							if(tx0.fld_btp22 < 0,abs(tx0.fld_btp22),0)  + if(tx0.fld_btbalance < 0,abs(tx0.fld_btbalance),0) 
						when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then
							(tx0.fld_btp01 - tx0.fld_btp16)
					end 'amount',
					case
						when tx0.fld_bttyid=13 and tx0.fld_btp02 = 1 then concat('Uang DP Subkon')
						when tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 then concat('Uang Jalan')
						when tx0.fld_bttyid=20 and tx0.fld_btp02 = 1 then concat('Sisa Sewa Subkon')
						when tx0.fld_bttyid=20 and tx0.fld_btp02 != 1 then concat('Kekurangan POD')
					end 'cost_type',
					1 'type',
					if(tx0.fld_bttyid=13 and tx0.fld_btp02 != 1 ,round(tx0.fld_btp27 * (1 - tx10.fld_tyvalcfg),0),0) 'saving'
				from
					tbl_bth tx0
					left join tbl_tyval tx1 on tx1.fld_tyvalcd=tx0.fld_btflag and tx1.fld_tyid=19
					left join tbl_bti tx2 on tx2.fld_btiid=tx0.fld_btp12
					left join tbl_route tx3 on tx3.fld_routeid =tx0.fld_btp09
					left join tbl_area tx4 on tx4.fld_areaid=tx3.fld_routefrom
					left join tbl_area tx5 on tx5.fld_areaid=tx3.fld_routeto
					left join tbl_be tx6 on tx6.fld_beid=tx0.fld_baidc
					left join tbl_emp tx7 on tx7.fld_empid=tx0.fld_btp11
					left join tbl_tyval tx8 on tx8.fld_tyvalcd=tx0.fld_btiid and tx8.fld_tyid=40
					left join tbl_bti tx9 on tx9.fld_btiid=4559
					left join tbl_tyval tx10 on tx10.fld_tyvalcd=6 and tx10.fld_tyid=68
					left join tbl_be tx11 on tx11.fld_beid=tx0.fld_btp04
				where
					tx0.fld_bttyid in (13,20)
					and
					if(tx0.fld_bttyid=20,tx0.fld_btstat = 3,tx0.fld_btstat=2)
					and
					tx0.fld_btiid=1
					and
					tx0.fld_btno='$btno'
					having amount > 0";
			//print $sql;
			$data=$this->db->query($sql);
			foreach ($data->result() as $rdata) {
				$amount = $rdata->amount;
				$deduction = 0;
				if($rdata->fld_emploan > 0) {
					if($rdata->fld_emploan <= $rdata->amount) {
						$amount = $rdata->amount - $rdata->fld_emploan;
						$this->db->query("update tbl_emp set fld_emploan=0 where fld_empid = '$rdata->fld_empid'");
						$deduction = $rdata->fld_emploan;
						}
					if($rdata->fld_emploan > $rdata->amount) {
						$amount = 0;
						$this->db->query("update tbl_emp set fld_emploan=$rdata->fld_emploan - $rdata->amount where fld_empid = '$rdata->fld_empid'");
						$deduction = $rdata->amount;
						}
				}
				$this->db->query("replace into tbl_trk_transfer
					(fld_btidp,fld_btreffid,fld_btno,fld_driver,fld_customer,fld_vehicle,fld_trk_settlementamt,fld_trk_settlementtype,fld_account,fld_btflag,fld_saving,fld_btp01,fld_btp02,fld_btp03,fld_deduction) 
					values 
					('$fldbtid','$rdata->reffid','$rdata->do_number','$rdata->fld_empnm','$rdata->fld_benm','$rdata->fld_bticd','$amount','$rdata->cost_type','$rdata->account','$rdata->type','$rdata->saving','$rdata->fld_empmobile','$rdata->fld_empbank','$rdata->fld_empnorek','$deduction')");
		   
			}
		}
	}
    
	function exportSettlement($fld_btid) {
		$filename = 'Trucking-Settlement-Summarry-'.date('Ymd') . '.csv';
		header("Content-type: text/plain");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		$data = $this->db->query("select
				t2.fld_tyvalnm 'FleetType',
				t0.fld_vehicle 'VehicleNumber',
				t0.fld_btno 'DONumber',
				t1.fld_btno 'EONumber',
				t0.fld_driver 'Driver',
				t0.fld_trk_settlementamt 'Cash',
				t0.fld_saving 'Saving'
			from tbl_trk_settlement t0
				left join tbl_bth t1 on t1.fld_btno=t0.fld_btno
				left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
				left join tbl_emp t3 on t3.fld_empid=t1.fld_btp11
				left join tbl_bti t4 on t4.fld_btiid=t1.fld_btp12
			where
				t0.fld_btidp=$fld_btid
			");   
		echo "Armada,Nomor Kendaraan,Nomor POD,Nomor Eksekusi,Driver,Cash \n";
		$cash = 0;
		$save = 0;
		foreach($data->result() as $rdata) {
			echo "\"$rdata->FleetType\",\"$rdata->VehicleNumber\",\"$rdata->DONumber\",\"$rdata->EONumber\",\"$rdata->Driver\",\"" . number_format($rdata->Cash,2,',','.')  . "\"\n";
			$cash = $cash + $rdata->Cash;
			$save = $save + $rdata->Saving;
			}
		echo "\"\",\"\",\"\",\"\",\"Total\",\"" . number_format($cash,2,',','.') . "\"\n";
	}
  
	function exportTransfer($fld_btid) {
		$filename = 'Trucking-Transfer-Summarry-'.date('Ymd') . '.csv';
		header("Content-type: text/plain");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		$data = $this->db->query("select
				t2.fld_tyvalnm 'FleetType',
				t0.fld_vehicle 'VehicleNumber',
				t0.fld_btno 'DONumber',
				date_format(t1.fld_btdt,'%d-%m-%Y')'SODate',
				t0.fld_driver 'Driver',
				 t3.fld_empext 'AtasNamaRekening',
				t0.fld_customer 'Customer',
				t1.fld_btp32 'DealTarif',
				t1.fld_btp27 'UJSMurni',
				(t1.fld_btp27/t1.fld_btp32) 'Pct',
				round(t0.fld_trk_settlementamt) 'Cash',
				t0.fld_saving 'Saving',
				concat('No. Telp: ',t0.fld_btp01) fld_btp01,
				t0.fld_btp02,
				concat('No. Rek: ',t0.fld_btp03) fld_btp03,
				t0.fld_btp04,
				t5.fld_tyvalnm 'location',
				if(t1.fld_bttaxno=1,'Langsiran','Reguler') 'jenis',
				t0.fld_trk_settlementtype,
				t6.fld_userp03 'Oleh',
				t6.fld_username
			from tbl_trk_transfer t0
				left join tbl_bth t1 on t1.fld_btno=t0.fld_btno
				left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
				left join tbl_emp t3 on t3.fld_empid=t1.fld_btp11
				left join tbl_bti t4 on t4.fld_btiid=t1.fld_btp12
				left join tbl_tyval t5 on t5.fld_tyvalcd=t1.fld_btloc and t5.fld_tyid=21
				left join tbl_user t6 on t6.fld_userid=t1.fld_baidp
			where
				t0.fld_btidp=$fld_btid
			");
		echo "Cabang;Pembuat SO;Armada;Nomor Kendaraan;Customer;Deal Tarif;UJS Murni; % Pct;Nomor SO;Tanggal;Jenis SO;Rute;Jenis Biaya;Supir;No. HP;Nama Bank;No. Rekening;Atas Nama Rekening;Jumlah \n";
		$cash = 0;
		$save = 0;
		foreach($data->result() as $rdata) {
			echo "$rdata->location;$rdata->Oleh;$rdata->FleetType;$rdata->VehicleNumber;$rdata->Customer;" . number_format($rdata->DealTarif,0,',','.') . ";" . number_format($rdata->UJSMurni,0,',','.') . ";" . number_format($rdata->Pct,2,',','.') . ";$rdata->DONumber;$rdata->SODate;$rdata->jenis;$rdata->fld_btp04;$rdata->fld_trk_settlementtype ;$rdata->Driver;$rdata->fld_btp01;$rdata->fld_btp02;$rdata->fld_btp03;$rdata->AtasNamaRekening;" . number_format($rdata->Cash,0,',','.') . ";" . "\n";
			$cash = $cash + $rdata->Cash;
		}
//		echo "\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"Total\";\"" . number_format($cash,2,',','.') . "\";\"" .  number_format($save,2,',','.') . "\"\n";
		echo "\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"\";\"Total\";\"" . number_format($cash,0,',','.') . "\";" . "\n";
	}

	function exportSettlement2($fld_btid) {
		$filename = 'Trucking-Settlement-'.date('Ymd') . '.csv';
		header("Content-type: text/plain"); 
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		$data = $this->db->query("select
				@s:=@s+1 number,
				t0.fld_account 'fld_account',
				concat('100.000') 'account_kas',
				t0.fld_trk_settlementamt 'Amount',
				0 'wht',
				t0.fld_btno 'DO',
				t0.fld_vehicle 'VehicleNumber',
				t0.fld_customer,
				t0.fld_driver 'Driver',
				fld_trk_settlementtype 'type'
			from 
				tbl_trk_settlement t0, (SELECT @s:= 0) AS s
			where
				t0.fld_btidp=$fld_btid
			");
		foreach ($data->result() as $rdata) {
			echo "$rdata->number,$rdata->fld_account,$rdata->account_kas,$rdata->Amount,$rdata->wht,$rdata->DO,$rdata->VehicleNumber,$rdata->fld_customer,$rdata->Driver,$rdata->type" . "\n";
		}
	}
  
	function setDriverBalance($fld_btid,$case) {
		$data = $this->db->query("select fld_btp11,fld_btp22 + fld_btbalance 'amount' from tbl_bth  where fld_btid = $fld_btid and fld_btstat = 3 having amount > 0");
		$data = $data->row();
		$fld_empid = $data->fld_btp11;
		$amount = $data->amount;
		if($case == 'add' && $amount > 0) {
		$this->db->query("update tbl_emp set fld_emploan = fld_emploan + ifnull($amount,0) where fld_empid = '$fld_empid' ");
		}
		if($case == 'delete' && $amount > 0) {
		$this->db->query("update tbl_emp set fld_emploan = fld_emploan - ifnull($amount,0) where fld_empid = '$fld_empid' ");
		}
	}

	function setTotalAmount ($fld_btid,$fld_bttyid) {
		### Trucking Billing
		if($fld_bttyid == 26) {
		   $dtl = $this->db->query("select sum(ifnull(fld_btamt01,0))'price',sum(ifnull(fld_btamt05,0))'dp',sum(ifnull(fld_btamt02,0))'vat',sum(ifnull(fld_btamt03,0))'total' from tbl_trk_billing where fld_btidp = $fld_btid");
		   $dtl = $dtl->row();
		   $this->db->query("update tbl_bth set fld_btamt = '$dtl->price',
					fld_btuamt = '$dtl->dp',
					fld_bttax = if(fld_btp01 =1,0.1 * fld_btamt,0),
					fld_btp07 = if(fld_btp06 =1,0.02 * fld_btamt,0),
					fld_btbalance = fld_btamt + fld_bttax +fld_btp07 - fld_btuamt
				where fld_btid = '$fld_btid'");
		}
	}

	function printTruckBilling ($fld_btid) {
		$filename = 'Trucking-Billing-Summarry-'.date('Ymd') . '.xls';
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		$data = $this->db->query("select
				t4.fld_btno, date_format(t1.fld_btdt,'%Y-%m-%d') 'date',t2.fld_benm,t0.fld_btamt01,t0.fld_btp01,t5.fld_bticd 'vehicle',
				concat(t7.fld_areanm, ' ---> ',t8.fld_areanm) 'fld_route'
			from tbl_trk_billing t0
				left join tbl_bth t1 on t1.fld_btid=t0.fld_btreffid
				left join tbl_be t2 on t2.fld_beid=t1.fld_baidc
				left join tbl_btr t3 on t3.fld_btrdst=t1.fld_btid
				left join tbl_bth t4 on t4.fld_btid=t3.fld_btrsrc
				left join tbl_bti t5 on t5.fld_btiid=t1.fld_btp12
				left join tbl_route t6 on t6.fld_routeid=t1.fld_btp09
				left join tbl_area t7 on t7.fld_areaid=t6.fld_routefrom
				left join tbl_area t8 on t8.fld_areaid=t6.fld_routeto
			where
				t0.fld_btidp=$fld_btid
			");   
		echo "<table border=1 width='1800px'>
		<tr>
			<td nowrap>No</td>
			<td nowrap>Delivery Number</td>
			<td nowrap>Date</td>
			<td nowrap>Customer</td>
			<td nowrap>Route</td>
			<td nowrap>Container No.</td>
			<td nowrap>Vehicle No.</td>
			<td nowrap>Type Of Cont.</td>
			<td nowrap>Selling Price</td>
			<td nowrap>B/L number</td>
			<td nowrap>Invoice No.</td>
		</tr>";
		$no = 0;
		$total = 0;
		foreach($data->result() as $rdata) {
			$no = $no + 1;
			echo "<tr>";
			echo "<td nowrap>" . $no . "</td>";
			echo "<td nowrap>" . $rdata->fld_btno . "</td>";
			echo "<td nowrap>" . $rdata->date . "</td>";
			echo "<td nowrap>" . $rdata->fld_benm . "</td>";
			echo "<td nowrap>" . $rdata->fld_route . "</td>";
			echo "<td nowrap>" . $rdata->fld_container . "</td>";
			echo "<td nowrap>" . $rdata->vehicle . "</td>";
			echo "<td nowrap>" . $rdata->size . "</td>";
			echo "<td nowrap>" . $rdata->fld_btamt01 . "</td>";
			echo "<td nowrap>" . $rdata->fld_btp01 . "</td>";
			echo "<td nowrap>" . $rdata->invoice . "</td>";
			echo "</tr>";
			$total = $total + $rdata->fld_btamt01;
		}
		echo "<tr>";
		echo "<td colspan=8 align='center'>Total</td>";
		echo "<td>" . $total . "</td>";
		echo "</tr>";
		echo "</table>";
	}

	function setVehicle ($fld_btiid) {
		$this->db->query("update tbl_bti set fld_btip07=
			(select sum(if(tx1.fld_btflag=3,tx1.fld_btamt01 * -1,tx1.fld_btamt01)) 
			from tbl_truck_fixed_cost tx1 where tx1.fld_btiid='$fld_btiid') / fld_btip08 
			where fld_btiid='$fld_btiid'");
		$this->db->query("update tbl_bti set fld_btip15=fld_btip07 / fld_btip14   where fld_btiid='$fld_btiid'");
	}

	function printDOTruckSKO($fld_btid) {
		$fld_btid =  $this->uri->segment(3);
		$getData =$this->db->query("
			select
				t0.fld_btid,
				t0.fld_btno,
				right(t0.fld_btno,5) 'NoDO',
				t0.fld_btstat,
				date_format(t0.fld_btdt,'%d-%m-%Y %H:%i') 'date',
				date_format(t0.fld_btdtso,'%d-%m-%Y %H:%i') 'bongkar',
				date_format(t0.fld_btdt,'%H:%i') 'time',
				t0.fld_btp01 'purchase_by',
				t8.fld_empnm 'posted_by', 
				t2.fld_benm 'customer',
				t0.fld_btp02 'destination1',
				t12.fld_areanm 'destination',
				t16.fld_areanm 'origin',
				if(t0.fld_btp02=1,t0.fld_btp05,t3.fld_bticd) 'v_number',
				t4.fld_tyvalnm 'v_type',
				if(t0.fld_btp02=1,t0.fld_btp06,t10.fld_empnm) 'driver',    
				t0.fld_btdesc 'desc',
				t1.fld_empnm 'chasier',
				format(t0.fld_btp01,2) 'delivery_cash',
				t0.fld_btloc 'location',
				t13.fld_empnm 'asst_driver',
				t10.fld_empmobile,
				substring(t0.fld_btp10,1,34) 'albongkar',
				substring(t0.fld_btp13,1,34) 'almuat',
				t0.fld_btp08,
				t0.fld_btqty,
				t14.fld_unitnm,
				t0.fld_btp19,
				t0.fld_btp20,
				format(t0.fld_btp32,0) 'deal_tarif',
				concat(t15.fld_userp03, ' ' , t15.fld_userp04) 'fld_username'
			from tbl_bth t0 
				left join tbl_emp t1 on t1.fld_empid=t0.fld_baidv
				left join tbl_be t2 on t2.fld_beid = t0.fld_baidc
				left join tbl_bti t3 on t3.fld_btiid = t0.fld_btp12
				left join tbl_tyval t4 on t4.fld_tyvalcd = t0.fld_btflag and t4.fld_tyid=19
				left join tbl_emp t8 on t8.fld_empid=t0.fld_baidp
				left join tbl_emp t10 on t10.fld_empid=t0.fld_btp11
				left join tbl_emp t13 on t13.fld_empid=t0.fld_btp03
				left join tbl_route t11 on t11.fld_routeid=t0.fld_btp09
				left join tbl_area t12 on t12.fld_areaid=t11.fld_routeto
				left join tbl_area t16 on t16.fld_areaid=t11.fld_routefrom
				left join tbl_unit t14 on t14.fld_unitid=t0.fld_btp14
				left join tbl_user t15 on t15.fld_userid=t0.fld_baidp
			where 
				t0.fld_btid='$fld_btid'
			");
		$data = $getData->row();
		if($data->fld_btstat == 1) {
			$this->db->query("update tbl_bth set fld_btstat=2 where fld_btid=$fld_btid limit 1");
			}
		
		$this->load->library('cezpdf');
	//     $this->cezpdf->Cezpdf(array(21.5,14),$orientation='portrait');
		$this->cezpdf->ezSetMargins(0,5,10,5);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,783,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
			);
	//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,755,15,'SURAT KONFIRMASI ORDER (SKO)');
		$this->cezpdf->line(10, 780, 585, 780);
		$this->cezpdf->line(10, 740, 585, 740);
		$this->cezpdf->line(10, 570, 585, 570);
		$this->cezpdf->line(10, 780, 10, 570);
		$this->cezpdf->line(350, 780, 350, 740);
		$this->cezpdf->line(585, 780, 585, 570);
		$this->cezpdf->line(30, 600, 130, 600);
		$this->cezpdf->line(170, 600, 270, 600);
		$this->cezpdf->line(320, 600, 420, 600);
		$this->cezpdf->line(460, 600, 560, 600);
		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
			);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
		  ##Print Detail
	   $this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
				'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
		#main left
		$this->cezpdf->addText(30,725,9,'Pelanggan      ');
		$this->cezpdf->addText(30,715,9,'Rute   ');
		$this->cezpdf->addText(30,705,9,'Nomor Mobil');
		$this->cezpdf->addText(30,695,9,'Armada     ');
		$this->cezpdf->addText(30,685,9,'Supir      ');
		$this->cezpdf->addText(30,675,9,'Tarif      ');
	 
		$this->cezpdf->addText(120,725,9,': ' . $data->customer);
		$this->cezpdf->addText(120,715,9,': ' . $data->origin ." ke ". $data->destination);
		$this->cezpdf->addText(120,705,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,695,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,685,9,': ' . ucwords(strtolower($data->driver)));
		$this->cezpdf->addText(120,675,9,': ' . $data->deal_tarif);

	#main right
		$this->cezpdf->addText(305,725,9,'Komoditas ');
		$this->cezpdf->addText(405,725,9,': ' . ucwords(strtolower($data->fld_btp08)));
		$this->cezpdf->addText(305,715,9,'Jumlah ');
		$this->cezpdf->addText(405,715,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,705,9,'Alamat Muat ');
		$this->cezpdf->addText(405,705,9,': ' . ucwords(strtolower($data->almuat)));
		$this->cezpdf->addText(305,695,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,695,9,': ' . ucwords(strtolower($data->albongkar)));
		$this->cezpdf->addText(305,685,9,'Nomor HP. ');
		$this->cezpdf->addText(405,685,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,675,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,675,9,': ' . $data->bongkar);
	  
		$this->cezpdf->addTextWrap(60,585,200,9,'Pengirim');
		$this->cezpdf->addText(200,585,9,'Supir');
		$this->cezpdf->addTextWrap(340,585,200,9,'Pelanggan');
		$this->cezpdf->addText(480,585,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,603,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,603,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');
		
	## Copy ke dua
	   $this->cezpdf->ezSetDy(-200);
	   $this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,518,28);
	   $this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
	   //$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
	   $this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
				);
	//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,490,15,'SURAT KONFIRMASI ORDER (SKO)');
		$this->cezpdf->setStrokeColor(0,0,0);
		$this->cezpdf->line(10, 515, 585, 515);
		$this->cezpdf->line(10, 475, 585, 475);
		$this->cezpdf->line(10, 305, 585, 305);
		$this->cezpdf->line(10, 515, 10, 305);
		$this->cezpdf->line(350, 515,350, 475);
		$this->cezpdf->line(585, 515, 585, 305); 
		$this->cezpdf->line(30, 335, 130, 335);
		$this->cezpdf->line(170, 335, 270, 335);
		$this->cezpdf->line(320, 335, 420, 335);
		$this->cezpdf->line(460, 335, 560, 335);
			
		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
		);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
	##Print Detail
		$this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
			'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
	#main left
		$this->cezpdf->addText(30,460,9,'Pelanggan      ');
		$this->cezpdf->addText(30,450,9,'Rute   ');
		$this->cezpdf->addText(30,440,9,'Nomor Mobil');
		$this->cezpdf->addText(30,430,9,'Armada     ');
		$this->cezpdf->addText(30,420,9,'Supir      ');
		$this->cezpdf->addText(30,410,9,'Tarif      ');
		 
		$this->cezpdf->addText(120,460,9,': ' . $data->customer);
		$this->cezpdf->addText(120,450,9,': ' . $data->origin ." ke ". $data->destination);
		$this->cezpdf->addText(120,440,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,430,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,420,9,': ' . ucwords(strtolower($data->driver)));
		$this->cezpdf->addText(120,410,9,': ' . $data->deal_tarif);

	#main right
		$this->cezpdf->addText(305,460,9,'Komoditas ');
		$this->cezpdf->addText(405,460,9,': ' . ucwords(strtolower($data->fld_btp08)));
		$this->cezpdf->addText(305,450,9,'Jumlah ');
		$this->cezpdf->addText(405,450,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,440,9,'Alamat Muat ');
		$this->cezpdf->addText(405,440,9,': ' . ucwords(strtolower($data->almuat)));
		$this->cezpdf->addText(305,430,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,430,9,': ' . ucwords(strtolower($data->albongkar)));
		$this->cezpdf->addText(305,420,9,'Nomor HP. ');
		$this->cezpdf->addText(405,420,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,410,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,410,9,': ' . $data->bongkar);
			   
		$this->cezpdf->addTextWrap(60,320,200,9,'Pengirim');
		$this->cezpdf->addText(200,320,9,'Supir');
		$this->cezpdf->addTextWrap(340,320,200,9,'Pelanggan');
		$this->cezpdf->addText(480,320,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,338,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,338,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');
		
	### Copy Ke tiga
		$this->cezpdf->ezSetDy(-200);
		$this->cezpdf->addJpegFromFile('images/logo-dpk.jpg',10,253,28);
		$this->cezpdf->ezText('           PT DHARMAMULIA PRIMA KARYA',10, array('justification' => 'left'));  
		//$this->cezpdf->ezText('           Jl. Kaliurang Km 6,5 Pandega Sakti No. 6', 10, array('justification' => 'left')); 
		$this->cezpdf->ezText('           Jl. Jogja-Solo Km 12,5 Padukuhan Karang Kalasan Tirtomartani Sleman Yogyakarta 55571', 10, array('justification' => 'left')); 

		$header = array(array('row1'=>'Nomor SO','row2'=>$data->fld_btno),
				  array('row1'=>'Tanggal','row2'=>$data->date),
				  array('row1'=>'Aktivitas','row2'=>$data->fld_bedivnm)
				);
		//  $this->cezpdf->addText(85,80,11,$data->posted_by);

		$this->cezpdf->addText(50,225,15,'SURAT KONFIRMASI ORDER (SKO)');
		$this->cezpdf->setStrokeColor(0,0,0);
		$this->cezpdf->line(10, 250, 585, 250);
		$this->cezpdf->line(10, 210, 585, 210);
		$this->cezpdf->line(10, 40, 585, 40);
		$this->cezpdf->line(10, 250, 10, 40);
		$this->cezpdf->line(350, 250, 350, 210);
		$this->cezpdf->line(585, 250, 585, 40);

		$this->cezpdf->line(30, 70, 130, 70);
		$this->cezpdf->line(170, 70, 270, 70);
		$this->cezpdf->line(320, 70, 420, 70);
		$this->cezpdf->line(460, 70, 560, 70);

		$this->cezpdf->ezSetDy(-10);

		$header = array(array('row1'=>'Nomor SO','row2'=>" : " . $data->fld_btno),
			array('row1'=>'Tanggal','row2'=>" : " . $data->date),
			array('row1'=>'Pembuat','row2'=>" : " . $data->fld_username)
		);
		$this->cezpdf->ezTable($header,array('row1'=>'','row2'=>''),'',
			array('rowGap'=>'0.1','showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>355,'xOrientation'=>'right','width'=>250,'fontSize'=>'9','cols'=>array('row1'=>array('width'=>60),'row2'=>array('width'=>170))));	
	 
	##Print Detail
		$this->cezpdf->ezTable($datadtl,array('item'=>'','fld_btqty01'=>'','fld_unitnm'=>''),'',
			array('rowGap'=>'0','showLines'=>'0','xPos'=>60,'xOrientation'=>'right','width'=>580,'shaded'=>0,'fontSize'=>'9',
			'cols'=>array('fld_btqty01'=>array('width'=>75),'fld_unitnm'=>array('width'=>75),'item'=>array('width'=>250), 'justification'=>'right')));
	#main left
		$this->cezpdf->addText(30,195,9,'Pelanggan      ');
		$this->cezpdf->addText(30,185,9,'Rute   ');
		$this->cezpdf->addText(30,175,9,'Nomor Mobil');
		$this->cezpdf->addText(30,165,9,'Armada     ');
		$this->cezpdf->addText(30,155,9,'Supir      ');
		$this->cezpdf->addText(30,145,9,'Tarif      ');
	 
		$this->cezpdf->addText(120,195,9,': ' . $data->customer);
		$this->cezpdf->addText(120,185,9,': ' . $data->origin ." ke ". $data->destination);
		$this->cezpdf->addText(120,175,9,': ' . $data->v_number);
		$this->cezpdf->addText(120,165,9,': ' . $data->v_type);
		$this->cezpdf->addText(120,155,9,': ' . ucwords(strtolower($data->driver)));
		$this->cezpdf->addText(120,145,9,': ' . $data->deal_tarif);

	#main right
		$this->cezpdf->addText(305,195,9,'Komoditas ');
		$this->cezpdf->addText(405,195,9,': ' . ucwords(strtolower($data->fld_btp08)));
		$this->cezpdf->addText(305,185,9,'Jumlah ');
		$this->cezpdf->addText(405,185,9,': ' . $data->fld_btqty . " " . $data->fld_unitnm);
		$this->cezpdf->addText(305,175,9,'Alamat Muat ');
		$this->cezpdf->addText(405,175,9,': ' . ucwords(strtolower($data->almuat)));
		$this->cezpdf->addText(305,165,9,'Alamat Bongkar ');
		$this->cezpdf->addText(405,165,9,': ' . ucwords(strtolower($data->albongkar)));
		$this->cezpdf->addText(305,155,9,'Nomor HP. ');
		$this->cezpdf->addText(405,155,9,': ' . $data->fld_empmobile);
		$this->cezpdf->addText(305,145,9,'Est. Selesai Bongkar ');
		$this->cezpdf->addText(405,145,9,': ' . $data->bongkar);
	  
		$this->cezpdf->addTextWrap(60,55,200,9,'Pengirim');
		$this->cezpdf->addText(200,55,9,'Supir');
		$this->cezpdf->addTextWrap(340,55,200,9,'Pelanggan');
		$this->cezpdf->addText(480,55,9,'Mengetahui');

		$this->cezpdf->addTextWrap(60,78,200,9,$data->fld_btp19);
		# $this->cezpdf->addText(200,603,11,'Supir');
		$this->cezpdf->addTextWrap(340,78,200,9,$data->fld_btp20);
		# $this->cezpdf->addText(480,603,11,'Mengetahui');

		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=do_trucking.pdf");
		header("Content-Disposition: attachment; filename=Surat Konfirmasi Order - " . $data->NoDO .  ".pdf");
		header("Pragma: no-cache");
		header("Expires: 0");
		$output = $this->cezpdf->ezOutput();
		echo $output;
	}
	
	function setCustomerFee($fld_beid) {
		$user_id = $this->session->userdata('userid');
		$user_date = now();
		$data = $this->db->query("select *  from tbl_becomm t0 where t0.fld_beid='$fld_beid'");
		$data = $data->row();
		foreach ($data->result() as $rdata) {
			if ($rdata->fld_becommcht != $user_date) {
				$this->db->query("update tbl_becomm set 
					fld_becommcht = now(),
					fld_becommchn = $user_id,
					fld_becommfup = now()
				where t0.fld_beid='$fld_beid'");
			}
			if ($rdata->fld_becommcrt == '' ) {
				$this->db->query("update tbl_becomm set 
					fld_becommflag = '1',
					fld_becommcrt = $user_date,
					fld_becommcnm = $user_id,
					fld_becommcht = $user_date,
					fld_becommchn = $user_id,
					fld_becommfup = now()
				where t0.fld_beid='$fld_beid'");
			}
		}
	}

	
}



