<?php

// Include path
//ini_set('include_path', ini_get('include_path').';../libs/PHPExcel/');

// PHPExcel
include __DIR__.'/../libs/PHPExcel/PHPExcel.php';
// PHPExcel_Writer_Excel2007
include __DIR__.'/../libs/PHPExcel/PHPExcel/Writer/Excel2007.php';

class ExcelGenerator
{
	private $objPHPExcel = null;
	private $row = 1;
	private $documentName = 'Documento';
	
	private $rowLimiter = '@';
	private $colLimiter = '|';
	
	private $borderStyleArray = null;
	private $headerStyleArray = null;
	
	public function __construct()
	{
		// Create new PHPExcel object
		$this->objPHPExcel = new PHPExcel();
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		
		$this->borderStyleArray = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '00000000'),
					 ),
			   ),
		);
		
		$this->headerStyleArray = array(
					'font' => array(
						'bold' => true
					)
				);
		
	}
	
	public function setDocumentProperties($documentName, $title)
	{
		$this->documentName = $documentName;
		
		// Setting properties
		$this->objPHPExcel->getProperties()->setCreator("Sistema de administracion");
		$this->objPHPExcel->getProperties()->setTitle($title);
		
		// Renaming sheet
		$this->objPHPExcel->getActiveSheet()->setTitle($title);
	}
	
	public function mainHeaderTable($headerTable, $headerColspan)
	{
		$currentRow = $this->row;
		$cols = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		
		$headerTable = str_replace("<br>", "\n", $headerTable);
		
		$this->objPHPExcel->getActiveSheet()->mergeCells("A$currentRow:". $cols[$headerColspan - 1]. "$currentRow");
		$this->objPHPExcel->getActiveSheet()->getRowDimension(''.$currentRow)->setRowHeight(75);
		$this->addRow(array($headerTable), true, false);
	}
	
	public function parseColumnHeadersTable($headersTable)
	{
		// Adding data row
		$this->addRow( explode($this->colLimiter, $headersTable), true, false );
	}
	
	public function parseTable($table)
	{
		$matrixData = explode($this->rowLimiter, $table);
		
		foreach($matrixData as $row)
		{
			if( !empty($row) )
				$this->addRow( explode($this->colLimiter, $row), false, false );
		}
	}
	
	public function parseFooterTable($footerTable)
	{
		$this->addRow( explode($this->colLimiter, $footerTable), false, true );
	}
	
	public function addRow($arrayData, $isHeader, $idFooter)
	{
		$i = 0;
		
		foreach($arrayData as $value)
		{
			$this->objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow(''.$i, ''.$this->row, $value);
			
			if( !$idFooter )
			{
				// Border color	
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->applyFromArray($this->borderStyleArray);
			}
			
			if( $isHeader )
			{
				// Adding header settings
				// Setting autosize for each column
				$this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(''.$i)->setAutoSize(true);
				
				// To allow multiline cells
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->getAlignment()->setWrapText(true);
				
				// Setting the backgroud color
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCDFFCC'); 
				
				// Setting font
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->applyFromArray($this->headerStyleArray);
				
				// Setting center align
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if( $idFooter )
			{
				if( !empty($value) )
				{
					$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->applyFromArray($this->borderStyleArray);
					// Setting the backgroud color
					$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCDFFCC');
				}
			}
			
			$i ++;
		}
		
		$this->row ++;
	}
	
	public function saveDocument()
	{
		// Save Excel 2007 file
		//$this->objWriter = new PHPExcel_Writer_Excel2007($this->objPHPExcel);
		//$this->objWriter->save($this->documentName . '.xlsx');
		
		//header('Content-Disposition: attachment; filename="'. $this->documentName .'.xlsx"');
		
		
		//$this->objPHPExcel->getActiveSheet()->getStyle('A1:B5')->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED));
		
		
		
		
		
		$this->objPHPExcel->getActiveSheet()->setShowRowColHeaders(true);
		$this->objPHPExcel->getActiveSheet()->getHeaderFooter()->setFirstHeader(true);
		//$this->objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('exito');
		//$this->objPHPExcel->getActiveSheet()->setPrintGridlines(TRUE);
		
		
		// Save Excel 2007 file and redirect output to client browser
		header('Content-Type: application/vnd.ms-excel');
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'. $this->documentName .'.xlsx"');
		header('Cache-Control: max-age=0');
		
		$this->objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$this->objWriter->save('php://output');
		
		
	}


}

$name = $_GET['name'];
$header = $_GET['header'];
$headerColspan = $_GET['headerColspan'];
$colHeaders = $_GET['colHeaders'];
$table = $_GET['table'];
$footer = $_GET['footer'];

$eg = new ExcelGenerator();
$eg->setDocumentProperties($name, $name);

$eg->mainHeaderTable($header, $headerColspan);
$eg->parseColumnHeadersTable($colHeaders);
$eg->parseTable($table);
$eg->parseFooterTable($footer);

$eg->saveDocument()

?>