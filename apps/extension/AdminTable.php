<?php

class AdminTable{
	
	public static function Table($header=array(),$data=array(),$pages='0',$select_page='1',$HTML_OBJ=''){
		$url_page  = 'index.php?';
		if(count($_GET)>0){
			$i = 0;
			foreach($_GET as $key => $val){
				if($key!='page'){
					if($i==0){
						$url_page .= $key.'='.$val;
					}else{
						$url_page .= '&'.$key.'='.$val;
					}
					$i++;
				}
			}
		}
		
		if($i==0){
			$url_page = 'index.php?page=';
		}else{
			$url_page .= '&page=';
		}
		$select_page = $_GET['page'];
		$page = $select_page;
		if($page==''){
			$page = 1;
		}
		
		$html = '<table class="table table-bordered table-striped">
					<thead>
        				<tr>
		';
		$attribute = array();
		foreach($header as $key => $val){
			$html .= '<th>'.$val['label'].'</th>';
			$header[$key]['label'] = '';
			if(count($header[$key])>0){
				foreach($header[$key] as $attribute_key => $attribute_val){
					$attribute[$key].= ' '.$attribute_key.'="'.$attribute_val.'"';
				}
			}
		}
		$html .= '</thead></tr>';
		$html .= '<tbody>';
		if(count($data)>0){
			foreach($data as $row_key => $row_val){
				$html .= '<tr>';
				foreach($header as $header_key => $header_val){
					$html .= '<td '.$attribute[$header_key].'>'.$row_val[$header_key].'</td>';
				}
				$html .= '</tr>';
			}
		}else{
			$html .= '<tr><td colspan="'.count($header).'" align="center">-----No Data-----</td></tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';	
		if($pages>1){
			$AllPageN = $page+4;
			if($AllPageN>$pages){
				$AllPageN = $pages;
			}
			
			$AllPageL = $page-4;
			if($AllPageL<=0){
				$AllPageL = 1;
			}
			
			$html .= '<ul class="pagination"><li page="1">';
			$html .= '<a href="javascript:void(0);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
			$html .= '</li>';
			
			if(($page-1)>=1){
				$html.= '<li page="'.($page-1).'"><a href="'.$url_page.($page-1).'"><span aria-hidden="true">&larr;</span> Older</a></li>';
			}
			
			for($i=$AllPageL;$i<$page;$i++){
				$html.= '<li page="'.$i.'"><a href="'.$url_page.$i.'">'.$i.'</a></li>';
			}
			
			for($i=$page;$i<=$AllPageN;$i++){
				$active = '';
				if($page==$i){
					$active = 'class="active"';
				}
				$html.= '<li page="'.$i.'" '.$active.'><a href="'.$url_page.$i.'">'.$i.'</a></li>';
			}
			
			if(($page+1)<=$pages){
				$html.= '<li page="'.($page+1).'"><a href="'.$url_page.($page+1).'">Next <span aria-hidden="true">&rarr;</span></a></li>';
			}
			
			
			$html .= '<li page="'.$pages.'"><a href="'.$url_page.$pages.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			$html .= '</ul>';
		}
		$html .= $HTML_OBJ;
		return $html;				
	}
	
	public static function Action($arr=array()){
		$html = '';
		if(count($arr['edit'])>0){
			$html .= '<a ';
			foreach($arr['edit'] as $key => $val){
				$html .= ' '.$key.'="'.$val.'"';
			}
			$html .= '>';
			$html .= '<img src="'.theme_url('admin').'/resources/icon/edit.png"> ';
			$html .= '</a>';
		}
		
		if(count($arr['delete'])>0){
			$html .= '<a ';
			foreach($arr['delete'] as $key => $val){
				$html .= ' '.$key.'="'.$val.'"';
			}
			$html .= '>';
			$html .= '<img src="'.theme_url('admin').'/resources/icon/delete.png"> ';
			$html .= '</a>';
		}
		
		return $html;
	}
	
}

?>