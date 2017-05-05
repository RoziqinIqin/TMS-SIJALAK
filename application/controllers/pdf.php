<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends CI_Controller {

	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -  
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in 
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see http://codeigniter.com/user_guide/general/urls.html
	*/
	 
	function __construct() {
		parent::__construct();
		//$this->load->model('dnxapps_model','dnxapps',TRUE);
		$this->load->database();
	}

	function index() {
		print "asdasd";
	}

	function kwitansi($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,10) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 7,
			'margin-right'  => 0,
			'margin-bottom' => 0,
			'margin-left'   => 7,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintKwitansi/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Kwitansi '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintKwitansi($id) {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/kwitansi', $data);
	}
	
	function langsiraninvoice($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 15,
			'margin-right'  => 10,
			'margin-bottom' => 0,
			'margin-left'   => 15,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Landscape'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintOutlangsiraninvoice/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Proforma Invoice Langsiran - '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintOutlangsiraninvoice($id) {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/proforma_langsiran', $data);
	}
	
	function langsiran($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 15,
			'margin-right'  => 10,
			'margin-bottom' => 0,
			'margin-left'   => 15,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Landscape'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintOutLangsiran/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Rekap Invoice Langsiran '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintOutLangsiran($id)	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/rekap_langsiran', $data);
	}		
	
	function reguler($id) {
		error_reporting(E_ALL);
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 15,
			'margin-right'  => 10,
			'margin-bottom' => 0,
			'margin-left'   => 15,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintOutReguler/".$id."";
        $pdf->addPage($url);
		if(!$pdf->send('Rekap Invoice Reguler '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintOutReguler($id) {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/rekap_reguler', $data);
	}
	
	function proforma($id)	{
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 15,
			'margin-right'  => 10,
			'margin-bottom' => 0,
			'margin-left'   => 15,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintOutProforma/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Proforma Invoice Reguler '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintOutProforma($id)	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/proforma_invoice', $data);
	}
	
	function CreatePdf($modul='', $id='') {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		switch ($modul) {
			case "CetakPC":
				$pdf = new WkHtmlToPdf;
				$url1 = base_url() . "index.php/pdf/PC/".$id."";
				$pdf->addPage($url1);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;
			case "SRT":
				$pdf = new WkHtmlToPdf;
				$url1 = base_url() . "index.php/pdf/CSRT/".$id."";
				$pdf->addPage($url1);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;
			case "CetakNota":
			  $pdf = new WkHtmlToPdf;
			  $url = base_url() . "index.php/printout/CetakNota/".$id."";
			  $pdf->addPage($url);
			  break;
			case "CetakBookingTruck":
			  $pdf = new WkHtmlToPdf;
			  $url = base_url() . "index.php/printout/BookingTruck/".$id."";
			  $pdf->addPage($url);
			  break;
			case "CetakSK":
				$pdf = new WkHtmlToPdf;
				$url1 = base_url() . "index.php/pdf/SK/".$id."";
				$pdf->addPage($url1);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;
			case "CetakCashAdvance1":
				$pdf = new WkHtmlToPdf(array(
				'no-outline',         // Make Chrome not complain
				'margin-top'    => 15,
				'margin-right'  => 2,
				'margin-bottom' => 0,
				'margin-left'   => 2,
				'page-width'	=> 215.00,
				'page-height'	=> 295.00 
				));
				$url = base_url() . "index.php/pdf/CashAdvance1/".$id."";
				$pdf->addPage($url);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;
			case "CetakCashAdvance":
				$pdf = new WkHtmlToPdf(array(
				'no-outline',         // Make Chrome not complain
				'margin-top'    => 15,
				'margin-right'  => 2,
				'margin-bottom' => 0,
				'margin-left'   => 2,
				'page-width'	=> 215.00,
				'page-height'	=> 295.00 
				));
				$url = base_url() . "index.php/pdf/CashAdvance/".$id."";
				$pdf->addPage($url);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;	
			case "CetakCost":
				$pdf = new WkHtmlToPdf(array(
				'no-outline',         // Make Chrome not complain
				'margin-top'    => 0,
				'margin-right'  => 2,
				'margin-bottom' => 0,
				'margin-left'   => 1,
				'page-width'	=> 215.90,
				'page-height'	=> 139.70 	// satuan mm
				));
				$url = base_url() . "index.php/pdf/OperatingCost/".$id."";
				$pdf->addPage($url);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;	
			case "ImpSettlement":
				$pdf = new WkHtmlToPdf();
				$url = base_url() . "index.php/pdf/ImpSettlement/".$id."";
				$pdf->addPage($url);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;		 
			case "SJCA":
				$pdf = new WkHtmlToPdf(array(
				'no-outline',         // Make Chrome not complain
				'margin-top'    => 0,
				'margin-right'  => 2,
				'margin-bottom' => 0,
				'margin-left'   => 1,
				'page-width'	=> 215.90,
				'page-height'	=> 139.70 	// satuan mm
				));
				/*$sql="SELECT A.fld_btid, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
					B.fld_btp05 tujuan
					FROM tbl_btd_container A
					LEFT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
					LEFT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
					where A.fld_btidp='$id'";
				*/
				$id = $this->db->query("SELECT A.fld_btrsrc FROM tbl_btr A WHERE A.fld_btrdst='$id'")->row()->fld_btrsrc;
				$sql="SELECT B.fld_btid JoID, A.fld_btid ConID, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
				B.fld_btp05 tujuan, B.fld_bttax ImporType, B.fld_btp23 JumCon, A.fld_btp06 PartOFF
				FROM tbl_btd_container A
				RIGHT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
				RIGHT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
				where B.fld_btid='$id'";
				$query=$this->db->query($sql);
				if ($query->num_rows() > 0) {
					$no=1;
					foreach ($query->result() as $row) {
						if ($row->ImporType =='1' or $row->ImporType =='2' or $row->ImporType =='5') {
							for( $i= 1 ; $i <= $row->JumCon ; $i++ ) {
								$url = base_url() . "index.php/pdf/SuratJalan/".$row->JoID."/".$i."/".$row->ImporType."";
								
								$pdf->addPage($url);
							}	
						} else {
							if ($row->PartOFF =='0') {
								$url = base_url() . "index.php/pdf/SuratJalan/".$row->ConID."/".$no."/".$row->ImporType."";
								$pdf->addPage($url);
								$no++;	
							}
						}
						//print $url; exit();
					}
				if(!$pdf->send('vsr.pdf')) {
					//throw new Exception('Could not create PDF: '.$pdf->getError()); 
					exit();	
					}
				} else {
					exit();	
				}
				break;
			case "SJ":
				$pdf = new WkHtmlToPdf(array(
				'no-outline',         // Make Chrome not complain
				'margin-top'    => 0,
				'margin-right'  => 2,
				'margin-bottom' => 0,
				'margin-left'   => 1,
				'page-width'	=> 215.90,
				'page-height'	=> 139.70 	// satuan mm
				));
				
				/*$sql="SELECT A.fld_btid, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
					B.fld_btp05 tujuan
					FROM tbl_btd_container A
					LEFT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
					LEFT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
					where A.fld_btidp='$id'";
				*/
				$sql="SELECT B.fld_btid JoID, A.fld_btid ConID, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
				B.fld_btp05 tujuan, B.fld_bttax ImporType, B.fld_btp23 JumCon, A.fld_btp06 PartOFF
				FROM tbl_btd_container A
				RIGHT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
				RIGHT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
				where B.fld_btid='$id'";
				$query=$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					$no=1;
					foreach ($query->result() as $row)
					{
						if ($row->ImporType =='1' or $row->ImporType =='2' or $row->ImporType =='5')
						{
							 for( $i= 1 ; $i <= $row->JumCon ; $i++ )
							 {
								$url = base_url() . "index.php/pdf/SuratJalan/".$row->JoID."/".$i."/".$row->ImporType."";
								
								$pdf->addPage($url);
							 }	
						} else {
							if ($row->PartOFF =='0')
							{
								$url = base_url() . "index.php/pdf/SuratJalan/".$row->ConID."/".$no."/".$row->ImporType."";
								$pdf->addPage($url);
								$no++;	
							}
						}
						//print $url; exit();
					}
					if(!$pdf->send('vsr.pdf')) {
						 //throw new Exception('Could not create PDF: '.$pdf->getError()); 
						 exit();	
					}
				} else {
					exit();	
				}
				break;
			case "CetakST":
				$pdf = new WkHtmlToPdf;
				$url1 = base_url() . "index.php/pdf/ST/".$id."";
				$pdf->addPage($url1);
				if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
				break;
		}
		//print $url;
	}
      
	function ST($id='')	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataSK($id);
		$data['modul']='SKDO';
		$this->load->view('print/st',$data);
	}

	function PC($id='')	{
		//print"asdasd";	
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataSK($id);
		$data['modul']='PC';
		$this->load->view('PrintOut',$data);
	}

	function CSRT($id='') {
		//print"asdasd";    
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataSK($id);
		$data['modul']='SRT';
		$this->load->view('PrintOut',$data);
	}

	function SK($id='')	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataSK($id);
		$data['modul']='SKDO';
		$this->load->view('PrintOut',$data);
	}
  
	function CashAdvance($id='') {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataCashAdvance($id);
		$data['modul']='CashAdvance';
		$this->load->view('PrintOut',$data);
	}
  
	function CashAdvance1($id='') {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataCashAdvance($id);
		$data['modul']='CashAdvance';
		$this->load->view('print/settlement',$data);
	}
  
	function OperatingCost($id='') {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataCashAdvance($id);
		$data['modul']='OperatingCost';
		$this->load->view('PrintOut',$data);
	}

	function ImpSettlement($id='') {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$data['data'] = $this->ffis->GetDataSettlement($id);
		$data['modul']='ImpSettlement';
		$data['id']=$id;
		$this->load->view('print/settlement',$data);
	}

	function tes() {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		$pdf = new wkhtmltopdf;
		// Add a HTML file, a HTML string or a page from URL
		//$pdf->addPage('/home/joe/page.html');
		//$pdf->addPage('<html>....</html>');
		$pdf->addPage('http://google.com');
		// Add a cover (same sources as above are possible)
		//$pdf->addCover('mycover.html');
		// Add a Table of contents
		//$pdf->addToc();
		// Save the PDF
		//$pdf->saveAs('/tmp/new.pdf');
		// ... or send to client for inline display
		//$pdf->send();
		// ... or send to client as file download
		if(!$pdf->send('vsr.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());
		//print "d";	
	}

	function SuratJalan($id='',$no, $ImportType='')	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		//$ImportType = $this->uri->segment(5);
		/*
		$sql="SELECT A.fld_btid, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
				B.fld_btp05 tujuan, B.fld_btp15 shipping, C.fld_beaddr, B.fld_btp19, A.fld_btp01, 
				CASE
					WHEN B.fld_btp07 <>'' THEN B.fld_btp07
					WHEN B.fld_btp08 <>'' THEN B.fld_btp08
					ELSE D.fld_docnum 
				END bl,
				A.fld_btp03 supir, A.fld_btp04 no_mobil, A.fld_btp07 jml_barang, A.fld_btp02 ket,
				A.fld_btp05 comodity
			FROM tbl_btd_container A
				LEFT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
				LEFT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
				LEFT JOIN tbl_btd_document D ON D.fld_btidp=B.fld_btid AND fld_doctype='705'
			where A.fld_btid='$id'";
		*/
		if ($ImportType =='1' or $ImportType =='2' or $ImportType =='5')
		{
			$sql="SELECT B.fld_btid, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
					B.fld_btp05 tujuan, E.fld_benm shipping, C.fld_beaddr, B.fld_btp19, A.fld_btp01, 
					CASE
						WHEN B.fld_btp07 <>'' THEN B.fld_btp07
						WHEN B.fld_btp08 <>'' THEN B.fld_btp08
						ELSE D.fld_docnum 
					END bl,
					A.fld_btp03 supir, A.fld_btp04 no_mobil, A.fld_btp07 jml_barang, A.fld_btp02 ket,
					A.fld_btp05 comodity
				FROM tbl_btd_container A
					RIGHT JOIN tbl_bth B ON A.fld_btidp=B.fld_btid
					LEFT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
					LEFT JOIN tbl_btd_document D ON D.fld_btidp=B.fld_btid AND fld_doctype='705'
					LEFT JOIN tbl_be E ON E.fld_beid=B.fld_btp15 AND E.fld_betyid=8
				WHERE B.fld_btid='$id'";
		} else {
			$sql="SELECT A.fld_btid, A.fld_btidp, A.fld_contnum, A.fld_conttype, A.fld_contsize, B.fld_btno, C.fld_benm customer, B.fld_btp03 vessel,
					B.fld_btp05 tujuan, E.fld_benm shipping, C.fld_beaddr, B.fld_btp19, A.fld_btp01, 
					CASE
						WHEN B.fld_btp07 <>'' THEN B.fld_btp07
						WHEN B.fld_btp08 <>'' THEN B.fld_btp08
						ELSE D.fld_docnum 
					END bl,
					A.fld_btp03 supir, A.fld_btp04 no_mobil, A.fld_btp07 jml_barang, A.fld_btp02 ket,
					A.fld_btp05 comodity
				FROM tbl_btd_container A
					LEFT JOIN tbl_bth B ON B.fld_btid=A.fld_btidp
					LEFT JOIN tbl_be C ON C.fld_beid=B.fld_baidc AND C.fld_betyid=5
					LEFT JOIN tbl_btd_document D ON D.fld_btidp=B.fld_btid AND fld_doctype='705'
					LEFT JOIN tbl_be E ON E.fld_beid=B.fld_btp15 AND E.fld_betyid=8
				where A.fld_btid='$id'";
		}
		$query=$this->db->query($sql)->row();
		$data['sj']=$query;
		$data['no']=$no;
		$this->load->view('print/sj',$data);
	}

	function KwitansiDP($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,10) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 7,
			'margin-right'  => 0,
			'margin-bottom' => 0,
			'margin-left'   => 7,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintKwitansiDP/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('KwitansiDP '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintKwitansiDP($id) {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/KwitansiDP', $data);
	}	

	function KwitansiDP2($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,10) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 7,
			'margin-right'  => 0,
			'margin-bottom' => 0,
			'margin-left'   => 7,
			// 'page-width'	=> 210.00,
			// 'page-height'	=> 297.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintKwitansiDP2/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('KwitansiDP '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintKwitansiDP2($id) {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/KwitansiDP2', $data);
	}	

	function proforma_JO($id)	{
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 15,
			'margin-right'  => 10,
			'margin-bottom' => 0,
			'margin-left'   => 15,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintOutProformaJO/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Proforma Invoice Reguler JO '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintOutProformaJO($id)	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/proforma_invoice_JO', $data);
	}	

	function kwitansiJO($id) {
		$getData1 = $this->db->query("
			select 
				right(t0.fld_btno,5) 'NoInv'
			from tbl_bth t0 
			where 
				t0.fld_btid='$id' ");
		$data1 = $getData1->row();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		require_once('system/shared/wkhtmltopdf.php');
		//$pdf = new WkHtmlToPdf;
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 7,
			'margin-right'  => 0,
			'margin-bottom' => 0,
			'margin-left'   => 7,
			//'page-width'	=> 215.00,
			//'page-height'	=> 295.00 ,
			'page-size'		=> 'A4',
			'orientation'	=> 'Portrait'
			));
        $url = "localhost/TMS-SIJALAK/index.php/pdf/PrintKwitansiJO/".$id."";
        $pdf->addPage($url);
        if(!$pdf->send('Kwitansi '.$data1->NoInv.'.pdf')) throw new Exception('Could not create PDF: '.$pdf->getError());	
	}
	
	function PrintKwitansiJO($id) {
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');  
		$data['fld_btid']=$id;
		$this->load->view('template/report/kwitansi_JO', $data);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
