<?
function smarty_modifier_money($number, $format='%n')
{
	if ($number == 0) return "";
	return(str_replace(',', ' ', number_format($number,2)));

}
?>
