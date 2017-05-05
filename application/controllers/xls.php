<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xls extends CI_Controller {

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
  function __construct()
  {
	  parent::__construct();
	  $this->load->model('dnxapps_model','dnxapps',TRUE);
	  $this->load->database();
  }

  function print_piv ($id) {
    require_once('application/libraries/PHPExcel.php');
    require_once ('application/libraries/PHPExcel/Writer/Excel2007.php');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
    $default_border = array(
    'style' => PHPExcel_Style_Border::BORDER_THIN,
    'color' => array('argb'=>'000000')
     );
	$style_header = array(
		'borders' => array(
			'bottom' => $default_border,
			'left' => $default_border,
			'top' => $default_border,
			'right' => $default_border,
			'vertical' => $default_border
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			//'color' => array('rgb'=>'E1E0F7'),
		),
		'font' => array(
			#'bold' => true,
		)
	);
	
        $style_body = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        //'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                'font' => array(
                        //'bold' => true,
                )
        );
	
	$center = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)
	);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray( $style_header );
	$header = $objPHPExcel->getActiveSheet();
	$header
			->setCellValue('B1', 'PT DHARMAMULIA PRIMA KARYA')
			->setCellValue('B2', 'Div. Transportasi');
                        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
 $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
 $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
       
	###Merge Cell
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');

        $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setSize(16);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objDrawing->setName('Paid');
        $objDrawing->setDescription('Paid');
        $objDrawing->setPath('images/logo-dpk1.png');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setOffsetX(1);
        $objDrawing->setRotation(25);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Proforma_Invoice'.'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
  }

function PrintBookingTruckExp($id)
  {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        require_once('application/libraries/PHPExcel.php');
        require_once ('application/libraries/PHPExcel/Writer/Excel2007.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $default_border = array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb'=>'000000')
        );

        $style_header = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                'font' => array(
                        'bold' => true,
                )
        );

        $style_body = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        //'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                 'font' => array(
                        //'bold' => true,
                )
        );

        $center = array(
                'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
        );
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A4:W4')->applyFromArray( $style_header );
        $header = $objPHPExcel->getActiveSheet();
        $header
                        ->setCellValue('B1', 'Booking No')
                        ->setCellValue('B2', 'Booking Date')
                        ->setCellValue('A4', 'No')
                        ->setCellValue('B4', 'Job Reference')
                        ->setCellValue('C4', 'Exportir')
                        ->setCellValue('D4', 'SI')
                        ->setCellValue('E4', 'Krani Depo')
                        ->setCellValue('F4', 'Krani Kartu')
                        ->setCellValue('G4', 'Destination')
                        ->setCellValue('H4', 'Vessel')
                        ->setCellValue('I4', 'ETD')
                        ->setCellValue('J4', 'Shipping Line')
                        ->setCellValue('K4', 'LCL/Unit')
                        ->setCellValue('L4', '20"')
                        ->setCellValue('M4', '40DC"')
                        ->setCellValue('N4', '40HC"')
                        ->setCellValue('O4', '45"')
                        ->setCellValue('P4', 'Depo')
                        ->setCellValue('Q4', 'Location')
                        ->setCellValue('R4', 'Notes')
                        ->setCellValue('S4', 'Truck No')
                        ->setCellValue('T4', 'Driver')
                        ->setCellValue('U4', 'Priority')
                        ->setCellValue('V4', 'Closing')
                        ->setCellValue('W4', 'CS')                              ;

        // Fetching the table data
        $this->load->database();
                $sql="select c.fld_btid id,a.fld_bt06 'tujuan',
                      g.fld_btp01 'si',
                      c.fld_btno, g.fld_btno 'jonum', a.fld_bt02 aju, e.fld_benm,a.fld_bt04 c20,a.fld_bt05 c40, 0 c45,d.fld_empnm cs,h.fld_btinm dest,
                      f.fld_benm ship,a.fld_bt09 lcl,a.fld_bt04 c20,a.fld_bt10 c40dc,a.fld_bt05 c40hc,a.fld_bt11 c45,i.fld_benm depo,g.fld_btdtso close,
                      j.fld_tyvalnm priority,
                      date_format(c.fld_btdtsa,'%Y-%m-%d') 'book_date'
                from tbl_btd_truck a
                left join tbl_bth b on b.fld_btid=a.fld_btp01
                left join tbl_bth c on c.fld_btid=a.fld_btidp
                left join tbl_bth g on g.fld_btid=a.fld_bt01 and g.fld_bttyid=6
                join dnxapps.tbl_be e on a.fld_baidc=e.fld_beid
                left join tbl_be f on f.fld_beid = g.fld_btp15 and f.fld_betyid=8
                left join hris.tbl_emp d on d.fld_empid= g.fld_baidp
                left join tbl_bti h on h.fld_bticd = g.fld_btp05 and h.fld_bticid =2
                left join tbl_be i on i.fld_beid = g.fld_btp17 and i.fld_betyid=4
                left join tbl_tyval j on j.fld_tyvalcd = g.fld_btflag and j.fld_tyid=71
                where c.fld_btid='$id'";
                $query=$this->db->query($sql);
                $BoNO='';

       
        $rowID = 5;
        $i=1;
        

        foreach($query->result() as $row)
        {
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowID.':W'.$rowID.'')->applyFromArray( $style_body);

                $header->setCellValue( "A" . $rowID, $i);
                $header->setCellValue( "B" . $rowID, $row->jonum);
                $header->setCellValue( "C" . $rowID, $row->fld_benm);
                $header->setCellValue( "D" . $rowID, $row->si);
                $header->setCellValue( "G" . $rowID, $row->dest);
                $header->setCellValue( "J" . $rowID, $row->ship);
                $header->setCellValue( "K" . $rowID, $row->lcl);
                $header->setCellValue( "L" . $rowID, $row->c20);
                $header->setCellValue( "M" . $rowID, $row->c40dc);
                $header->setCellValue( "N" . $rowID, $row->c40hc);
                $header->setCellValue( "O" . $rowID, $row->c45);
                $header->setCellValue( "P" . $rowID, $row->depo);
                $header->setCellValue( "Q" . $rowID, $row->tujuan);
                $header->setCellValue( "U" . $rowID, $row->priority);
                $header->setCellValue( "V" . $rowID, $row->close);
                $header->setCellValue( "W" . $rowID, $row->cs);

                                $count = $row->c20 + $row->c40dc + $row->c40hc +$row->c45;
                                for ($i=0; $i<$count; ++$i) {
                                $rowID++;
                                $header->setCellValue( "F" . $rowID, "");
                                $header->setCellValue( "H" . $rowID, "");
                                $header->setCellValue( "I" . $rowID, ""); 
                                $header->setCellValue( "R" . $rowID, "");
                                $header->setCellValue( "S" . $rowID, "");
                                $header->setCellValue( "T" . $rowID, "");
                               
                              }
                $i++;
                $rowID++;
        }
         $header->setCellValue( "C1", $row->fld_btno);
         $header->setCellValue( "C2", $row->book_date);
        
        $header->getColumnDimension("A")->setAutoSize(true);
        $header->getColumnDimension("B")->setAutoSize(true);
        $header->getColumnDimension("C")->setAutoSize(true);
        $header->getColumnDimension("D")->setAutoSize(true);
        $header->getColumnDimension("E")->setAutoSize(true);
        $header->getColumnDimension("F")->setAutoSize(true);
        $header->getColumnDimension("G")->setAutoSize(true);
        $header->getColumnDimension("H")->setAutoSize(true);
        $header->getColumnDimension("I")->setAutoSize(true);
        $header->getColumnDimension("J")->setAutoSize(true);
        $header->getColumnDimension("K")->setAutoSize(true);
        $header->getColumnDimension("L")->setAutoSize(true);
        $header->getColumnDimension("M")->setAutoSize(true);
        $header->getColumnDimension("N")->setAutoSize(true);
        $header->getColumnDimension("O")->setAutoSize(true);
        $header->getColumnDimension("P")->setAutoSize(true);
        $header->getColumnDimension("Q")->setAutoSize(true);
        $header->getColumnDimension("R")->setAutoSize(true);
        $header->getColumnDimension("S")->setAutoSize(true);
        $header->getColumnDimension("T")->setAutoSize(true);
        $header->getColumnDimension("U")->setAutoSize(true);
        $header->getColumnDimension("V")->setAutoSize(true);
        $header->getColumnDimension("W")->setAutoSize(true);
        

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="BookingTruckExport'.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
  }



   function PrintDetailContainer($id)
  {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');  
	require_once('application/libraries/PHPExcel.php');
	require_once ('application/libraries/PHPExcel/Writer/Excel2007.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb'=>'000000')
	);

	$style_header = array(
		'borders' => array(
			'bottom' => $default_border,
			'left' => $default_border,
			'top' => $default_border,
			'right' => $default_border,
			'vertical' => $default_border
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			//'color' => array('rgb'=>'E1E0F7'),
		),
		'font' => array(
			'bold' => true,
		)
	);
	
        $style_body = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        //'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                'font' => array(
                        //'bold' => true,
                )
        );
	
	$center = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)
	);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray( $style_header );
	//$objPHPExcel->getDefaultStyle()->applyFromArray( $style_header );
        // Field names in the first row
        //$fields = $query->list_fields();
        $header = $objPHPExcel->getActiveSheet();
		//$header->getStyle('A1:O1')->applyFromArray( $style_header );
		//add column headers, set the title and make the text bold
		
	/*	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:I1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:A2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:B2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:C2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:D2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:E2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:F2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:G2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:J2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:K2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:L2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:M2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N1:N2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:O2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:P2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q1:Q2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('R1:R2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:S2');
	*/
		$header
			->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Booking No')
			->setCellValue('C1', 'Job Order')
			->setCellValue('D1', 'Container')
			->setCellValue('E1', 'Size');
			//->setTitle('Report SLA Pivot');
 
        // Fetching the table data
        
		$sql="select b.fld_btno bookno, c.fld_btno jobno, d.fld_contnum contno, d.fld_contsize size
		from tbl_btd_truck a
		left join tbl_bth b on b.fld_btid=a.fld_btidp and b.fld_bttyid = 5
		left join tbl_bth c on c.fld_btid=a.fld_bt01 and c.fld_bttyid = 1
		left join tbl_btd_container d on d.fld_btidp = a.fld_bt01
		where b.fld_btid='$id'";
		$query=$this->db->query($sql);
		$BoNO='';
        $rowID = 2;
        $i=1;
        $noreff='';
        
        foreach($query->result() as $row)
        {
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowID.':E'.$rowID.'')->applyFromArray( $style_body);

			$header->setCellValue( "A" . $rowID, $i);
			$header->setCellValue( "B" . $rowID, $row->bookno);
			$header->setCellValue( "C" . $rowID, $row->jobno);
			$header->setCellValue( "D" . $rowID, $row->contno);
			$header->setCellValue( "E" . $rowID, $row->size);
		
			
			//$header->setCellValue( "F" . $rowID, $row->fld_benm);
			//$header->setCellValue( "G" . $rowID, $row->tujuan);
			$i++;
			$rowID++;
        }
        
	$header->getColumnDimension("A")->setAutoSize(true);
	$header->getColumnDimension("B")->setAutoSize(true);
	$header->getColumnDimension("C")->setAutoSize(true);
	$header->getColumnDimension("D")->setAutoSize(true);
	$header->getColumnDimension("E")->setAutoSize(true);


        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Booking_'.$row->bookno.'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
  }

function PrintDepositReceipt($id)
  {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');  
	require_once('application/libraries/PHPExcel.php');
	require_once ('application/libraries/PHPExcel/Writer/Excel2007.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb'=>'000000')
	);

	$style_header = array(
		'borders' => array(
			'bottom' => $default_border,
			'left' => $default_border,
			'top' => $default_border,
			'right' => $default_border,
			'vertical' => $default_border
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			//'color' => array('rgb'=>'E1E0F7'),
		),
		'font' => array(
			'bold' => true,
		)
	);
	
        $style_body = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        //'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                'font' => array(
                        //'bold' => true,
                )
        );
	
	$center = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)
	);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->applyFromArray( $style_header );
	//$objPHPExcel->getDefaultStyle()->applyFromArray( $style_header );
        // Field names in the first row
        //$fields = $query->list_fields();
        $header = $objPHPExcel->getActiveSheet();
		//$header->getStyle('A1:O1')->applyFromArray( $style_header );
		//add column headers, set the title and make the text bold
		
	/*	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:I1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:A2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:B2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:C2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:D2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:E2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:F2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:G2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:J2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:K2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:L2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:M2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N1:N2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:O2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:P2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q1:Q2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('R1:R2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:S2');
	*/
		$header
                        ->setCellValue('B1', 'Receipt No')
                        ->setCellValue('B2', 'Receipt Date')
		       	->setCellValue('A4', 'No')
                        ->setCellValue('B4', 'Job Number')
                        ->setCellValue('C4', 'Customer')
			->setCellValue('D4', 'Shipping Line')
			->setCellValue('E4', 'BL No')
			->setCellValue('F4', 'J.Container(USD)')
                        ->setCellValue('G4', 'J.Container(IDR)')
                        ->setCellValue('H4', 'J.Demmurage(USD)')
                        ->setCellValue('I4', 'J.Demmurage(IDR)')
                        ->setCellValue('J4', 'Keterangan')
                        ->setCellValue('K4', 'B.Cleaning/ADM(USD)')
                        ->setCellValue('L4', 'B.Cleaning/ADM(IDR)')
                        ->setCellValue('M4', 'B.Demmurage(USD)')
                        ->setCellValue('N4', 'B.Demmurage(IDR)')
                        ->setCellValue('O4', 'B.Repair(USD)')
                        ->setCellValue('P4', 'B.Repair(IDR)') 
                        ->setCellValue('Q4', 'Proses Pencairan');
			//->setTitle('Report SLA Pivot');
 
        // Fetching the table data
        
		$sql="select b.fld_btno receiptno,b.fld_btdt receiptdate ,c.fld_btno jobno, d.fld_benm cust, e.fld_benm shipping,
                a.fld_blno,a.fld_btcost01,a.fld_btcost02,a.fld_btcost03,a.fld_btcost04,a.fld_btcost05,a.fld_btcost06,a.fld_btcost07,a.fld_btcost08,
                a.fld_btcost09,a.fld_btcost10,a.fld_btdesc,a.fld_btp02,h.fld_empnm ops,i.fld_empnm cs,j.fld_tyvalnm refund
		from tbl_btd_deposit a
		left join tbl_bth b on b.fld_btid=a.fld_btidp and b.fld_bttyid = 50
		left join tbl_bth c on c.fld_btid=a.fld_btp01 and c.fld_bttyid = 1
                left join dnxapps.tbl_be d on d.fld_beid=a.fld_customer and d.fld_betyid=5
                left join tbl_be e on e.fld_beid=a.fld_sline and e.fld_betyid=8
                left join tbl_bth f on f.fld_btp26=a.fld_btp01 and f.fld_bttyid = 11
                left join tbl_user g on g.fld_baid = f.fld_btp12 and g.fld_usergrpid in (8,43)
                left join hris.tbl_emp h on h.fld_empid = g.fld_baid
                left join hris.tbl_emp i on i.fld_empid = b.fld_baidp 
                left join tbl_tyval j on j.fld_tyvalcd = f.fld_btp01 and j.fld_tyid = 79
		where b.fld_btid='$id'";
		$query=$this->db->query($sql);
		$BoNO='';
        $rowID = 5;
        $i=1;
        $noreff='';
        
        foreach($query->result() as $row)
        {
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowID.':Q'.$rowID.'')->applyFromArray( $style_body);

			$header->setCellValue( "A" . $rowID, $i);
			$header->setCellValue( "B" . $rowID, $row->jobno);
			$header->setCellValue( "C" . $rowID, $row->cust);
			$header->setCellValue( "D" . $rowID, $row->shipping);
			$header->setCellValue( "E" . $rowID, $row->fld_blno);
		        $header->setCellValue( "F" . $rowID, $row->fld_btcost01);
                        $header->setCellValue( "G" . $rowID, $row->fld_btcost02);
                        $header->setCellValue( "H" . $rowID, $row->fld_btcost03);
                        $header->setCellValue( "I" . $rowID, $row->fld_btcost04);
                        $header->setCellValue( "J" . $rowID, $row->fld_btdesc);
			$header->setCellValue( "K" . $rowID, $row->fld_btcost05);
                        $header->setCellValue( "L" . $rowID, $row->fld_btcost06);
                        $header->setCellValue( "M" . $rowID, $row->fld_btcost07);
                        $header->setCellValue( "N" . $rowID, $row->fld_btcost08);
                        $header->setCellValue( "O" . $rowID, $row->fld_btcost09);
                        $header->setCellValue( "P" . $rowID, $row->fld_btcost10);
                        $header->setCellValue( "Q" . $rowID, $row->refund);
                       
			
			$i++;
			$rowID++;
        }
        $rowx = $rowID+2;
        $rowy = $rowID+6;
        
        $header->setCellValue( "B" .$rowx, 'Ops.Staff');
        $header->setCellValue( "D" .$rowx, 'Import CS');       
        $header->setCellValue( "F" .$rowx, 'Import Manager');
        $header->setCellValue( "H" .$rowx, 'Finance Cashier');
        
        $header->setCellValue( "B" .$rowy, $row->ops);
        $header->setCellValue( "D" .$rowy, $row->cs);        


        $header->setCellValue( "C1", $row->receiptno);
        $header->setCellValue( "C2", $row->receiptdate);

	$header->getColumnDimension("A")->setAutoSize(true);
	$header->getColumnDimension("B")->setAutoSize(true);
	$header->getColumnDimension("C")->setAutoSize(true);
	$header->getColumnDimension("D")->setAutoSize(true);
	$header->getColumnDimension("E")->setAutoSize(true);
        $header->getColumnDimension("F")->setAutoSize(true);
        $header->getColumnDimension("G")->setAutoSize(true);
        $header->getColumnDimension("H")->setAutoSize(true);
        $header->getColumnDimension("I")->setAutoSize(true);
        $header->getColumnDimension("J")->setAutoSize(true);
        $header->getColumnDimension("K")->setAutoSize(true);
        $header->getColumnDimension("L")->setAutoSize(true);
        $header->getColumnDimension("M")->setAutoSize(true);
        $header->getColumnDimension("N")->setAutoSize(true);
        $header->getColumnDimension("O")->setAutoSize(true);
        $header->getColumnDimension("P")->setAutoSize(true);
        $header->getColumnDimension("Q")->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Receipt_'.$row->receiptno.'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
  }





  function PrintDetailContainer1($id)
  {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');  
	require_once('application/libraries/PHPExcel.php');
	require_once ('application/libraries/PHPExcel/Writer/Excel2007.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb'=>'000000')
	);

	$style_header = array(
		'borders' => array(
			'bottom' => $default_border,
			'left' => $default_border,
			'top' => $default_border,
			'right' => $default_border,
			'vertical' => $default_border
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			//'color' => array('rgb'=>'E1E0F7'),
		),
		'font' => array(
			'bold' => true,
		)
	);
	
        $style_body = array(
                'borders' => array(
                        'bottom' => $default_border,
                        'left' => $default_border,
                        'top' => $default_border,
                        'right' => $default_border,
                        'vertical' => $default_border
                ),
                'fill' => array(
                        //'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //'color' => array('rgb'=>'E1E0F7'),
                ),
                'font' => array(
                        //'bold' => true,
                )
        );
	
	$center = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)
	);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A1:R1')->applyFromArray( $style_header );
	$header = $objPHPExcel->getActiveSheet();
	$header
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Booking Number')
			->setCellValue('C1', 'Job Reference')
			->setCellValue('D1', 'SI')
			->setCellValue('E1', 'Destination')
			->setCellValue('F1', 'Vessel')
			->setCellValue('G1', 'ETD')
			->setCellValue('H1', 'Booking')
			->setCellValue('I1', 'LCL/Unit')
			->setCellValue('J1', '20"')
			->setCellValue('K1', '40"')
			->setCellValue('L1', '45"')	
			->setCellValue('M1', 'Depo')
			->setCellValue('N1', 'Stufing')
			->setCellValue('O1', 'Catatan')
			->setCellValue('P1', 'No Polisi')
			->setCellValue('Q1', 'Supir')
			->setCellValue('R1', 'Closing');
			//->setTitle('Report SLA Pivot');
 
        // Fetching the table data
        
		$sql="select c.fld_btid id, c.fld_btno, g.fld_btno noreff, g.fld_btp01 si, e.fld_benm,a.fld_bt04 c20,a.fld_bt05 c40, 0 c45, h.fld_btinm tujuan,
		g.fld_btp03 vessel, g.fld_btp18 etd
		from tbl_btd_truck a
		left join tbl_bth b on b.fld_btid=a.fld_btp01
		left join tbl_bth c on c.fld_btid=a.fld_btidp
		left join tbl_bth g on g.fld_btid=a.fld_bt01
		left join tbl_be e on a.fld_baidc=e.fld_beid and e.fld_betyid=5
		left join tbl_bti h on h.fld_bticd=g.fld_btp05 and h.fld_bticid=3
		where c.fld_btid='$id'";
		$query=$this->db->query($sql);
		$BoNO='';
        $rowID = 2;
        $i=1;
        $noreff='';
        
        foreach($query->result() as $row)
        {
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowID.':R'.$rowID.'')->applyFromArray( $style_body);

			$header->setCellValue( "A" . $rowID, $i);
			$header->setCellValue( "B" . $rowID, $row->fld_btno);
			$header->setCellValue( "C" . $rowID, $row->noreff);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowID, $row->si, PHPExcel_Cell_DataType::TYPE_STRING);
			$header->setCellValue( "E" . $rowID, $row->tujuan);
			$header->setCellValue( "F" . $rowID, $row->vessel);
			$header->setCellValue( "G" . $rowID, $row->etd);
			$header->setCellValue( "J" . $rowID, $row->c20);
			$header->setCellValue( "K" . $rowID, $row->c40);
			$header->setCellValue( "L" . $rowID, $row->c45);
			
			$sql="select c.fld_btid, c.fld_btno, g.fld_btno noreff, null cs, null fld_benm, a.fld_btp01 stufing,
			h.fld_btinm tujuan, 
			case 
				when f.fld_tyvalnm=20 then a.fld_btqty01 else 0
			end c20,
			case 
				when f.fld_tyvalnm=40 then a.fld_btqty01 else 0
			end c40,
			case 
				when f.fld_tyvalnm=45 then a.fld_btqty01 else 0
			end c45,null sp2,
			null lcl, g.fld_btp01 terminal, null depo, g.fld_btdtso, g.fld_btp15 pelayaran,
			null nopol, null supir, null krani
			from tbl_btd_stuffing a
			left join tbl_bth c on c.fld_btid=a.fld_btidp
			left join tbl_btd_truck d on d.fld_bt01=c.fld_btid
			left join tbl_tyval f on f.fld_tyvalcd=a.fld_con_size and f.fld_tyid=28
			left join tbl_bth g on g.fld_btid=d.fld_bt01 
			left join tbl_bti h on h.fld_bticd=g.fld_btp05 and h.fld_bticid=3
			left join tbl_bth i on i.fld_btid=d.fld_btidp
			where i.fld_btid='$id' and i.fld_btno='$row->fld_btno' and c.fld_btno='$row->noreff'";
			$query=$this->db->query($sql);
			if ($query->num_rows > 0)
			{
				foreach ($query->result() as $detail)
				{
					$rowID++;
					$header->setCellValue( "J" . $rowID, $detail->c20);
					$header->setCellValue( "K" . $rowID, $detail->c40);
					$header->setCellValue( "L" . $rowID, $detail->c45);
					$header->setCellValue( "M" . $rowID, '');
					$header->setCellValue( "N" . $rowID, $detail->stufing);
					$header->setCellValue( "O" . $rowID, '');
					$header->setCellValue( "P" . $rowID, '');
					$header->setCellValue( "Q" . $rowID, '');
					$header->setCellValue( "R" . $rowID, '');
				}	
			}
			
		
			$i++;
			$rowID++;
        }
        
	$header->getColumnDimension("A")->setAutoSize(true);
	$header->getColumnDimension("B")->setAutoSize(true);
	$header->getColumnDimension("C")->setAutoSize(true);
	$header->getColumnDimension("D")->setAutoSize(true);
	$header->getColumnDimension("E")->setAutoSize(true);
	$header->getColumnDimension("F")->setAutoSize(true);
	$header->getColumnDimension("G")->setAutoSize(true);
	$header->getColumnDimension("H")->setAutoSize(true);
	$header->getColumnDimension("I")->setAutoSize(true);
	$header->getColumnDimension("J")->setAutoSize(true);
	$header->getColumnDimension("K")->setAutoSize(true);
	$header->getColumnDimension("L")->setAutoSize(true);
	$header->getColumnDimension("M")->setAutoSize(true);
	$header->getColumnDimension("N")->setAutoSize(true);
	$header->getColumnDimension("O")->setAutoSize(true);
	$header->getColumnDimension("P")->setAutoSize(true);
	$header->getColumnDimension("Q")->setAutoSize(true);
	$header->getColumnDimension("R")->setAutoSize(true);
	$header->getColumnDimension("S")->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
  }
  
	function billing_langsiran($id)
	{
		error_reporting(E_ALL);
		ini_set('memory_limit','256M');
		require_once('system/shared/php-export-data.class.php');
		$excel = new ExportDataExcel('browser');
		$excel->filename = "Rekap Langsiran.xls";
		$excel->initialize();
		
		$getData = $this->db->query("select t0.fld_btno, date_format(t0.fld_btdt,'%d-%m-%Y') 'date',
		t1.fld_benm,t0.fld_btcmt, t2.fld_beaddrplc, t2.fld_beaddrstr, t0.fld_btbalance,
		t0.fld_bttax, t0.fld_btamt, format(t0.fld_btbalance,0) 'amount',
		t3.fld_tyvalnm 'lokasi', t3.fld_tyvalcfg 'ttd', t3.fld_tyvalcmt 'jabatan'  
		from tbl_bth t0 
		left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
		left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
		left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
		where t0.fld_btid='$id'");
		$data = $getData->row();
		$row = array("PT DHARMAMULIA PRIMA KARYA");
		$excel->addRow($row);
		$row = array("Pelanggan", $data->fld_benm);
		$excel->addRow($row);
		$row = array("No Tagihan", $data->fld_btno);
		$excel->addRow($row);
		$row = array("");
		$excel->addRow($row);
		
		$sql="select t0.*, date_format(t1.fld_btdt,'%Y-%m-%d')'date',
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
		t4.fld_btamt 'fld_btamt',
		t4.fld_bttax,
		t4.fld_btbalance,
		t0.fld_btamt01 'amount'
		from tbl_trk_billing t0
		left join tbl_btd_langsiran tx0 on tx0.fld_btid=t0.fld_btreffid
		left join tbl_bth t1 on t1.fld_btid = tx0.fld_btidp
		left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btp26 and t2.fld_tyid=19
		left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
		left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
		where t0.fld_btidp = $id order by tx0.fld_btdt, fld_btnoalt desc";
		$query=$this->db->query($sql);
		$i=1;
		$row = array("Tanggal", "No DO", "Rute", "Kendaraan", "Jenis", "Supir", "Komoditas", "Beban",
					"Jam Lembur", "Tarif Lembur", "Tarif Ritase", "Tarif");		
		$excel->addRow($row);
		foreach($query->result() as $k) {
			$row = array( 
				$k->tx0date, 
				$k->fld_btnoalt,
				$k->fld_route,
				$k->fld_vehicle,
				$k->veh_type,
				$k->driver, 
				$k->komoditas,
				$k->beban,
				$k->jam,
				$k->lembur,
				$k->tarif,
				$k->amount
			);
			$excel->addRow($row);
			$i++;
		}
		$row = array("");
		$excel->addRow($row);
		$row = array("", "", "", "", "", "", "", "","", "", "Sub Total", $data->fld_btamt);		
		$excel->addRow($row);
		$row = array("", "", "", "", "", "", "", "","", "", "PPN", $data->fld_bttax);		
		$excel->addRow($row);
		$row = array("", "", "", "", "", "", "", "","", "", "Total Tarif", $data->fld_btbalance);		
		$excel->addRow($row);
		$excel->finalize();
	}
    
    function billing_reguler($id)
	{
		error_reporting(E_ALL);
		ini_set('memory_limit','256M');
		require_once('system/shared/php-export-data.class.php');
		$excel = new ExportDataExcel('browser');
		$excel->filename = "Rekap Reguler.xls";
		$excel->initialize();
		
		$getData = $this->db->query("select t0.fld_btno, date_format(t0.fld_btdt,'%Y-%m-%d') 'date',
		t1.fld_benm,t0.fld_btcmt, t2.fld_beaddrplc, t2.fld_beaddrstr, t0.fld_btbalance, t0.fld_bttax,
		t0.fld_btamt,t0.fld_btuamt,t0.fld_btbalance 'amount',t3.fld_tyvalnm 'lokasi',
		t3.fld_tyvalcfg 'ttd',t3.fld_tyvalcmt 'jabatan'
		from tbl_bth t0 
		left join tbl_be t1 on t1.fld_beid=t0.fld_baidc
		left join tbl_beaddr t2 on t2.fld_beaddrid=t0.fld_btp01
		left join tbl_tyval t3 on t3.fld_tyvalcd=t0.fld_btloc and fld_tyid=21
		where t0.fld_btid='$id'");
		$data = $getData->row();
		$row = array("PT DHARMAMULIA PRIMA KARYA");
		$excel->addRow($row);
		$row = array("Pelanggan", $data->fld_benm);
		$excel->addRow($row);
		$row = array("No Tagihan", $data->fld_btno);
		$excel->addRow($row);
		$row = array("");
		$excel->addRow($row);
		
		$sql="select distinct t0.*, date_format(t1.fld_btdt,'%Y-%m-%d')'date',
		t1.fld_btp24, if(t1.fld_baidv=1,t1.fld_btp25,0) 'fld_btp25',
		t2.fld_tyvalnm 'veh_type',t3.fld_empnm 'driver',t4.fld_btamt,
		t4.fld_bttax,t4.fld_btbalance,t0.fld_btnoalt,t0.fld_btp01 'fld_route',
		t0.fld_vehicle,t0.fld_btamt01 'amount',date_format(tx0.fld_btdt,'%d-%m-%Y')'tx0date',
		format(t0.fld_btamt05,0) 'dp'
		from tbl_trk_billing t0
		left join tbl_bth t1 on t1.fld_btnoalt=t0.fld_btno and t1.fld_bttyid=20
		left join tbl_tyval t2 on t2.fld_tyvalcd=t1.fld_btflag and t2.fld_tyid=19
		left join tbl_emp t3 on t3.fld_empid = t1.fld_btp11
		left join tbl_bth t4 on t4.fld_btid = t0.fld_btidp
		left join tbl_btd_langsiran tx0 on tx0.fld_btidp=t0.fld_btreffid
		where t0.fld_btidp = $id order by tx0.fld_btdt";
		$query=$this->db->query($sql);
		$i=1;
		$row = array("Tanggal", "No DO", "Rute", "Kendaraan", "Jenis", "Supir", "DP","Tarif");		
		$excel->addRow($row);
		foreach($query->result() as $k) {
			$row = array( 
				$k->tx0date, 
				$k->fld_btnoalt,
				$k->fld_route,
				$k->fld_vehicle,
				$k->veh_type,
				$k->driver, 
				$k->dp,
				$k->amount
			);
			$excel->addRow($row);
			$i++;
		}
		$row = array("");
		$excel->addRow($row);
		$row = array("", "", "", "","", "", "Sub Total", $data->fld_btamt);		
		$excel->addRow($row);
		$row = array("", "", "", "","", "", "PPN", $data->fld_bttax);		
		$excel->addRow($row);
		$row = array("", "", "", "", "", "","Total Tarif", $data->fld_btbalance);		
		$excel->addRow($row);
		$excel->finalize();
	}
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
