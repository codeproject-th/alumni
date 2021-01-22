<?php

class pdf_module{
	public $pdf;
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		ini_set('memory_limit', '128M');
		include_once("./apps/extension/html2pdf/tcpdf.php");
		$this->pdf = new TCPDF();
		$this->pdf->SetPrintHeader(false);
		$this->pdf->SetPrintFooter(true);
		$this->pdf->SetAutoPageBreak(TRUE, 0);
		$this->pdf->AddPage();
		$this->pdf->SetFont('angsanaupc', '', 14);
		
		$id = $_GET['id'];
		$admin_type = $_SESSION['admin_id'];
		
		if($admin_type==''){
			$where = 'AND order_data.order_status="1"';
		}
		
		$sql = "SELECT order_data.* , party_table.* , order_detail.* FROM order_data 
				LEFT JOIN order_detail ON order_data.order_data_id = order_detail.order_data_id 
				LEFT JOIN party_table ON order_detail.party_table_id = party_table.party_table_id 
				WHERE order_data.order_data_id='".$id."' ".$where."
			";
		$data = db::fetch($sql);
		$html_table = "";
		$n = 0;
		
		$style = array(
    				'position' => '',
    				'align' => 'C',
    				'stretch' => false,
    				'fitwidth' => true,
    				'cellfitalign' => '',
    				'border' => false,
    				'hpadding' => 'auto',
    				'vpadding' => 'auto',
    				'fgcolor' => array(0,0,0),
   					'bgcolor' => false, //array(255,255,255),
    				'text' => true,
    				'font' => 'helvetica',
    				'fontsize' => 8,
    				'stretchtext' => 4
		);

		
		if(count($data)>0){
			foreach($data as $val){
			//for($i=1;$i<=20;$i++){
				$n++;
				if($n>=6){
					$this->pdf->AddPage();
					$n = 1;
				}
				
				if($val['order_type']=='2'){
					$val['PartyTableCode'] = '0000';
				}
				
				$html_table = '
					<table border="1" cellspacing="0" cellpadding="3">
							<tr>
								<td width="540" align="left">
									<table border="0" cellspacing="0" cellpadding="0" width="530" >
										<tr>
											<td width="200">
												<img src="./apps/themes/default/resources/images/logo.jpg"/>
											</td>
											<td>
												<font size="60">'.$val['PartyTableCode'].'</font>
												<br/>
												<b>INV.</b>'.str_pad($val['order_data_id'],7,'0',STR_PAD_LEFT).'
												<br/>
												<b>CODE.</b>'.$val['order_code'].'
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<br/>
						';
				$this->pdf->writeHTML($html_table, true, false, true, false, '');
				$style['position'] = 'R';
				//$this->pdf->write1DBarcode($val['order_code'], 'C128A', '',$this->pdf->getX()+30, '187', 13, 0.3, $style, 'N');
				$this->pdf->write1DBarcode($val['order_code'], 'C128A', '',$this->pdf->getY()-27, '185', 13, 0.3, $style, 'N');
				$this->pdf->setY($this->pdf->getY()+10);
			}
		}
		ob_end_clean();
		$this->pdf->Output();
	}
	
		
}

?>