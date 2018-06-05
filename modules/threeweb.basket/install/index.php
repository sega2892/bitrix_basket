<?php
/**
 * Created by PhpStorm.
 * User: s.atapin
 * Date: 26.02.2018
 * Time: 12:50
 */

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config as Conf;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

Class threeweb_basket extends CModule
{
    var $exclusionAdminFiles;

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");

        $this->exclusionAdminFiles=array(
            '..',
            '.',
            'menu.php',
            'operation_description.php',
            'task_description.php'
        );

        $this->MODULE_ID = 'threeweb.basket';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("threeweb_basket_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("threeweb_basket_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("threeweb_basket_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("threeweb_basket_PARTNER_URI");

        $this->MODULE_SORT = 1;
       // $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS='Y';
       // $this->MODULE_GROUP_RIGHTS = "Y";
    }
    //Определяем место размещения модуля

    /**
     * @param bool $notDocumentRoot
     * @return mixed|string
     */
    public function GetPath($notDocumentRoot=false)
    {
        if($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    //Проверяем что система поддерживает D7

    /**
     * @return mixed
     */
    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }

    /**
     *
     */
    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        if(!Application::getConnection(\Threeweb\basket\OrderTable::getConnectionName())->isTableExists(
            Base::getInstance('\Threeweb\basket\OrderTable')->getDBTableName()
        )
        )
        {
            Base::getInstance('\Threeweb\basket\OrderTable')->createDbTable();
        }

        if(!Application::getConnection(\Threeweb\basket\PriсeTable::getConnectionName())->isTableExists(
            Base::getInstance('\Threeweb\basket\PriсeTable')->getDBTableName()
        )
        )
        {
            Base::getInstance('\Threeweb\basket\PriсeTable')->createDbTable();
        }

        if(!Application::getConnection(\Threeweb\basket\TypePriсeTable::getConnectionName())->isTableExists(
            Base::getInstance('\basket\Telegramchat\TypePriсeTable')->getDBTableName()
        )
        )
        {
            Base::getInstance('\basket\Telegramchat\TypePriсeTable')->createDbTable();
        }

    }

    /**
     *
     */
    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        Application::getConnection(\Threeweb\basket\OrderTable::getConnectionName())->
        queryExecute('drop table if exists '.Base::getInstance('\Threeweb\basket\OrderTable')->getDBTableName());

        Application::getConnection(\Threeweb\basket\PriseTable::getConnectionName())->
        queryExecute('drop table if exists '.Base::getInstance('\Threeweb\basket\PriсeTable')->getDBTableName());

        Application::getConnection(\Threeweb\basket\TypePriseTable::getConnectionName())->
        queryExecute('drop table if exists '.Base::getInstance('\Threeweb\basket\TypePriсeTable')->getDBTableName());

        Option::delete($this->MODULE_ID);
    }

    /**
     *
     */
    function InstallEvents()
    {
       // \Bitrix\Main\EventManager::getInstance()->registerEventHandler($this->MODULE_ID, 'TestEventD7', $this->MODULE_ID, '\Academy\D7\Event', 'eventHandler');
    }

    /**
     *
     */
    function UnInstallEvents()
    {
      //  \Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler($this->MODULE_ID, 'TestEventD7', $this->MODULE_ID, '\Academy\D7\Event', 'eventHandler');
    }

    /**
     * @param array $arParams
     * @return bool
     */
    function InstallFiles($arParams = array())
    {
       /* $path=$this->GetPath()."/install/components";

        if(\Bitrix\Main\IO\Directory::isDirectoryExists($path))
            CopyDirFiles($path, $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
        else
            throw new \Bitrix\Main\IO\InvalidPathException($path);
*/
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin'))
        {
            CopyDirFiles($this->GetPath() . "/install/admin/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin"); //если есть файлы для копирования
            CopyDirFiles($this->GetPath() . "/install/themes/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", false, true);

            if ($dir = opendir($path))
            {
                while (false !== $item = readdir($dir))
                {
                    if (in_array($item,$this->exclusionAdminFiles))
                        continue;
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$item,
                        '<'.'? require($_SERVER["DOCUMENT_ROOT"]."'.$this->GetPath(true).'/admin/'.$item.'");?'.'>');
                }
                closedir($dir);
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    function UnInstallFiles()
    {
       /* \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/academy/');*/
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . "/install/themes/.default/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes/.default");
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . '/install/admin/', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/admin');
            if ($dir = opendir($path)) {
                while (false !== $item = readdir($dir)) {
                    if (in_array($item, $this->exclusionAdminFiles))
                        continue;
                    \Bitrix\Main\IO\File::deleteFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
                }
                closedir($dir);
            }
        }
        return true;
    }

    /**
     *
     */
    function DoInstall()
    {
        global $APPLICATION;
        if($this->isVersionD7())
        {
            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();
            //$this->InstallEvents();
            $this->InstallFiles();


        }
        else
        {
            $APPLICATION->ThrowException(Loc::getMessage("threeweb_basket_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("threeweb_basket_INSTALL_TITLE"), $this->GetPath()."/install/step.php");
    }

    /**
     *
     */
    function DoUninstall()
    {
        global $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if($request["step"]<2)
        {
            $APPLICATION->IncludeAdminFile(Loc::getMessage("threeweb_basket_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep1.php");
        }
        elseif($request["step"]==2)
        {
            $this->UnInstallFiles();
           // $this->UnInstallEvents();

            if($request["savedata"] != "Y") {
                $this->UnInstallDB();
            }

            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);



            $APPLICATION->IncludeAdminFile(Loc::getMessage("threeweb_basket_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep2.php");
        }
    }
}
