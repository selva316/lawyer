<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PdfNotation extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		
	}
	
	public function index()
	{
		
		$this->load->library('Pdf');
		
		$hashnid = $_GET['nid'];
		$this->load->model('notationmodel');
		$data = $this->notationmodel->fetchHashNotation();
		
		//$this->load->view('admin/pdfquotation',$data);
		
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		ob_clean();
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// set document information
		$pdf->SetCreator('Vineet');

		$pdf->SetTitle("Notation");
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		
		//$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		//$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or helvetica to reduce file size.
		$pdf->SetFont('droidsans', '', 14, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		
		$pdf->SetXY(15, 8);
		$pdf->SetFont('droidsans', 'B', 12);
		$pdf->SetTextColor(0, 0, 0, 100);
		$pdf->Cell(0, 0,'Notation', 0, 1, 'C', 0, '', 0);
		$pdf->SetXY(5, 5);
	
		$pdf->SetXY(0, 28);
		
		$pdf->SetFont('droidsans', 'B', 12);
		$pdf->Cell(65, 5,'Case Information', 0, 1, 'C', 0, '', 0);

		$pdf->SetXY(15, 35);
		$pdf->Cell(25, 5, 'Case Name: ', 0, 1, 'L', 0, '', 0);
		$pdf->Cell(25, 5, 'Citation: ', 0, 1, 'L', 0, '', 0);
		$pdf->Cell(25, 5, 'Court assigned case number: ', 0, 1, 'L', 0, '', 0);
			
		$pdf->Output($hashnid.'.pdf', 'I');
		
	}
	
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */