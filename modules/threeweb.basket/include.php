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
    '\Threeweb\basket\OrderTable'=>'/lib/order.php',
     '\Threeweb\basket\PriсeTable'=>'/lib/priсe.php',
     '\Threeweb\basket\TypePriсeTable'=>'/lib/type_priсe.php',
	 'order'=>'classes/mysql/order.php',
	 'prise'=>'classes/mysql/prise.php',
	 'type_prise'=>'classes/mysql/type_prise.php',
 )
 );
 
