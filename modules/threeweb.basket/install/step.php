<?php
/**
 * Created by PhpStorm.
 * User: s.atapin
 * Date: 26.02.2018
 * Time: 13:34
 */
use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid())
    return;

#работа с .settings.php
//$install_count=\Bitrix\Main\Config\Configuration::getInstance()->get('academy_module_d7');

//$cache_type=\Bitrix\Main\Config\Configuration::getInstance()->get('cache');
#работа с .settings.php

if ($ex = $APPLICATION->GetException())
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => Loc::getMessage("MOD_INST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
else
    echo CAdminMessage::ShowNote(Loc::getMessage("MOD_INST_OK"));


?>
<form action="<?echo $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?echo LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?echo Loc::getMessage("MOD_BACK"); ?>">
    <form>