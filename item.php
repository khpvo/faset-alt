<?
if ($fbrand == $item_brand_code && $fcolor == $item_color || $fbrand == '' && $fcolor == $item_color || $fbrand == $item_brand_code && $fcolor == '' || $fbrand == '' && $fcolor == '') {
	$arSkuProps['size'][] = $item_size;
}
if ($fbrand == $item_brand_code && $fsize == $item_size || $fbrand == '' && $fsize == $item_size || $fbrand == $item_brand_code && $fsize == '' || $fbrand == '' && $fsize == '') {
	$arSkuProps['color'][] = $item_color;
}
if ($fcolor == $item_color && $fsize == $item_size || $fcolor == '' && $fsize == $item_size || $fcolor == $item_color && $fsize == '' || $fcolor == '' && $fsize == '') {
	$arSkuProps['brand'][$item_brand_code]['id'] = $item_brand_id;
	$arSkuProps['brand'][$item_brand_code]['code'] = $item_brand_code;
	$arSkuProps['brand'][$item_brand_code]['name'] = $item_brand_name;
}