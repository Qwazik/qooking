<?php
$GLOBALS['default_img'] = CFile::GetByID(DEFAULT_IMAGE_ID)->arResult[0];

function test($var){
	echo '<pre class="dump">';
	var_dump($var);
	echo '</pre>';
}

function getElements($filter, $select = [], $col=99999, $order = ["SORT"=>"ASC"]){
	$result = [];
	$cnt = 0;
	if(CModule::IncludeModule('iblock')){
		$res = CIBlockElement::GetList(
			$order,
			$filter,
			false,
			false,
			$select
		);
		while ($ar_res = $res->Fetch()){
			if($cnt===$col) break;
			array_push($result, $ar_res);
			$cnt++;
		}
	}
	return $result;
}

function proportionalResize($picture, $max_width, $max_height){
	$propotionals = $max_height / $max_width;
	$need_width = intval((intval($picture['WIDTH']) > $max_width)?$max_width:$picture['WIDTH']);
	$need_height = $need_width * $propotionals;
	return CFile::ResizeImageGet($picture,['width'=>$need_width,'height'=>$need_height], BX_RESIZE_IMAGE_EXACT);
}

function phoneFormat($phone, $format){
    $phone = str_split($phone);
    $cntPhone = count($phone);
    $result = [];
    foreach(str_split($format) as $symbol){
        if(preg_match('/\d/', $symbol) && $cntPhone > 0){
            array_push($result, array_shift($phone));
        }else{
            array_push($result, $symbol);
        }
    }
    $result = preg_replace('/^\+8/','+7', implode($result));
    return $result;
}