<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class BasketOrderGeneral 
{

    var $LAST_ERROR="";
	
	
			//check fields before writing
    function CheckFields($arFields, $ID)
	{
		/** @global CDatabase $DB */
		global $DB;
		/** @global  CMain $APPLICATION */
		global $APPLICATION;

		$this->LAST_ERROR = "";
		$aOrder = array();

	    if(array_key_exists("ID", $arFields))
		{
			if(strlen($arFields["ID"])<=0)
				$aOrder[] = array("id"=>"ID", "text"=>GetMessage("class_post_err_ID"));
		}

		if(!array_key_exists("NAME", $arFields) || $arFields["NAME"]==NULL)
		{
		if(strlen($arFields["NAME"])<=0)
				$aOrder[] = array("id"=>"NAME", "text"=>GetMessage("class_post_err_NAME"));
		}

		if(array_key_exists("PHONE", $arFields))
		{
			if(strlen($arFields["PHONE"])<=0)
				$aOrder[] = array("id"=>"PHONE", "text"=>GetMessage("class_post_err_PHONE"));
		}

		if(array_key_exists("ORDER", $arFields))
		{
						if(strlen($arFields["ORDER"])<=0)
				$aOrder[] = array("id"=>"ORDER", "text"=>GetMessage("class_post_err_ORDER"));
		}
		
		if(array_key_exists("EMAIL", $arFields))
		{
						if(strlen($arFields["EMAIL"])<=0)
				$aOrder[] = array("id"=>"EMAIL", "text"=>GetMessage("class_post_err_EMAIL"));
		}
		
		if(array_key_exists("DATE", $arFields))
		{
						if(strlen($arFields["DATE"])<=0)
				$aOrder[] = array("id"=>"DATE", "text"=>GetMessage("class_post_err_DATE"));
		}
		
		if(array_key_exists("PRODUCT", $arFields))
		{
						if(strlen($arFields["PRODUCT"])<=0)
				$aOrder[] = array("id"=>"PRODUCT", "text"=>GetMessage("class_post_err_PRODUCT"));
		}
	
		if(!empty($aOrder))
		{
			$e = new CAdminException($aOrder);
			$APPLICATION->ThrowException($e);
			$this->LAST_ERROR = $e->GetString();
			return false;
		}

		return true;
	}
		
	function Add($arFields)
	{
        global $DB; 
		
		$order= new BasketOrder();
		
		if(!$order->CheckFields($arFields, 0))
		{	
			return false;
		}
      
	}
	//Update
	function Update($ID, $arFields)
	{
		global $DB;
		
		$order= new BasketOrder();
		
		$ID = intval($ID);

		if(!$order->CheckFields($arFields, $ID))
			return false;

		$strUpdate = $DB->PrepareUpdate("bs_order", $arFields);
		if($strUpdate!="")
		{
			$strSql = "UPDATE bs_order SET ".$strUpdate." WHERE ID=".$ID;
			$arBinds = array(
				"NAME" => $arFields["NAME"],
				"PHONE" => $arFields["PHONE"],
				"EMAIL" => $arFields["EMAIL"],
				"DATE" => $arFields["DATE"],
				"PRODUCT" => $arFields["PRODUCT"],
			);
			if(!$DB->QueryBind($strSql, $arBinds))
				return false;
		}
		
		return true;
	}	
	function GetById($ID)
	{
		global $DB;
		$ID = intval($ID);

		$strSql = "
			SELECT *
			FROM basket
			WHERE ID=".$ID."
		";
		return $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
	}
	public static function Delete($ID)
	{
		global $DB;
		$ID = intval($ID);

		$res = $DB->Query("DELETE FROM bs_order WHERE ID='".$ID."'", false, "File: ".__FILE__."<br>Line: ".__LINE__);
		
		return $res;
	}	
		
}
	
	
?>