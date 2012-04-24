<?
function smarty_modifier_ocdate($d1, $d2, $text='All Day')
{

if ( ($d1 == $d2) ) return "Not Valid";
if ( ($d1 - $d2) <=82800 ) return date( "h:i a", $d2) ." - " .date( "h:i a",$d1);

return $text;
}
?>
