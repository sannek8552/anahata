<?php
require_once('classes/CMS/Product_Tops_Holder.php');
require_once('classes/ProductHolder.php');
class Page_Product_Tops_Runmode extends Runmode
{
	function Page_Product_Tops_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		//$entry = $_REQUEST['entry'];
		$top_holder = new Product_Tops_Holder();
		$tops = $top_holder->get_All_Tops();
                
                //pp($tops);
                //pp($_REQUEST);
                foreach($tops as $key=>$top)
                    $top_string[] = $key;

                $top_string = join(',',$top_string);
                //pp($top_string);
		$ph = new ProductHolder();
		$products = $ph->get_Tops($top_string);
                //pp($products);

                foreach($products as $key=>$product)
                {
                    $products[$key]['quantity'] = $tops[$product['id']];
                }

                /*Sorting*/
                for($i=0; $i<count($products)-1; $i++)
                {
                    for($j=$i; $j<count($products)-1; $j++)
                    {
                        if($products[$i]['quantity']<$products[$j+1]['quantity'])
                        {
                            $temp = $products[$j+1];
                            $products[$j+1] = $products[$i];
                            $products[$i] = $temp;
                        }
                    }
                }
                //pp($products);
                $count = 0;
                if(isset($_REQUEST['entry']))
                {
                    $top_holder = new Product_Tops_Holder($_REQUEST['entry']);
                    $count = $top_holder->get_data('count');
                }
                    //pp($count);
                $products = array_slice($products,0, $count);
                
		$GLOBALS['core.smarty']->assign('products',$products);

		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/product_tops_module.tpl');
	}
}
?>