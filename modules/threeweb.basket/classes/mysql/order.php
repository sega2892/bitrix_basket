<?
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/threeweb.basket/classes/general/order.php");

class BasketOrder extends BasketOrderGeneral
{
	function GetList($aSort=Array(), $arFilter=Array())
	{
		global $DB;
		//$this->LAST_ERROR = "";
		$arSqlSearch = Array();
		$arSqlSearch_h = Array();
		$strSqlSearch = "";
		if (is_array($arFilter))
		{
			foreach($arFilter as $key=>$val)
			{
				if (!is_array($val) && (strlen($val)<=0 || $val=="NOT_REF"))
					continue;

				switch(strtoupper($key))
				{
					
				case "ID":
					$arSqlSearch[] = GetFilterQuery("ID",$val,"N");
					break;
				case "NAME":
					$arSqlSearch[] = GetFilterQuery("NAME",$val,"N");
					break;
				case "PHONE":
					$arSqlSearch[] = GetFilterQuery("PHONE",$val,"N");
					break;
				case "EMAIL":
				$arSqlSearch[] = GetFilterQuery("EMAIL",$val,"N");
					break;
				case "DATE":
				$arSqlSearch[] = GetFilterQuery("DATE",$val,"N");
					break;
				case "PRODUCT":
				$arSqlSearch[] = GetFilterQuery("PRODUCT",$val,"N");
					break;
				}
			}
		}

		$arOrder = array();
		foreach($aSort as $key => $ord) //варианты сортировки
		{
			$key = strtoupper($key);
			$ord = (strtoupper($ord) <> "ASC"? "DESC": "ASC");
			switch($key)
			{
				case "ID":	$arOrder[$key] = "ID ".$ord; break;
				case "NAME":	$arOrder[$key] = "NAME".$ord; break;
				case "PHONE":	$arOrder[$key] = "PHONE".$ord; break;
				case "EMAIL":	$arOrder[$key] = "EMAIL".$ord; break;
				case "DATE":	$arOrder[$key] = "DATE".$ord; break;
				case "PRODUCT":	$arOrder[$key] = "PRODUCT".$ord; break;
			}
		}
		if(count($arOrder) <= 0)
		{
			$arOrder["NAME"] = "NAME DESC";
		}
		$strSqlOrder = " ORDER BY ".implode(", ", $arOrder);

		$strSqlSearch = GetFilterSqlSearch($arSqlSearch);
		$strSql = "
			SELECT
				ID
				,NAME
				,PHONE
				,EMAIL
				,DATE,
				,PRODUCT
				FROM bs_order
			".$strSqlSearch."
		";
		if(count($arSqlSearch_h)>0)
		{
			$strSqlSearch_h = GetFilterSqlSearch($arSqlSearch_h);
			$strSql = $strSql." HAVING ".$strSqlSearch_h;
		}
		$strSql.=$strSqlOrder;

		$res = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
		$res->is_filtered = (IsFiltered($strSqlSearch));
		return $res;
	}
}
?>