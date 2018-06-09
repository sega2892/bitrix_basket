<?php
/**
 * Created by PhpStorm.
 * User: s.atapin
 * Date: 27.02.2018
 * Time: 11:54
 */
\Bitrix\Main\Loader::registerAutoLoadClasses(
    "threeweb.basket",
 array(
    '\Threeweb\Basket\OrderTable'=>'/lib/order.php',
     '\Threeweb\Basket\PriceTable'=>'/lib/price.php',
     '\Threeweb\Basket\TypePriceTable'=>'/lib/type.php',
	 'order'=>'classes/mysql/order.php',
	 'price'=>'classes/mysql/price.php',
	 'type_price'=>'classes/mysql/type_price.php',
 )
 );
 
