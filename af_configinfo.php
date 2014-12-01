<?php

// Global variable for table object
$af_config = NULL;

//
// Table class for af_config
//
class caf_config extends cTable {
	var $q_Min_Chequeo;
	var $q_Min_VentChequeo;
	var $f_Ult_Chequeo;
	var $x_Usuario_Api;
	var $x_Passw_Api;
	var $x_Url_Wsdl;
	var $f_Ult_Mod;
	var $c_Usuario_Ult_Mod;
	var $c_IUltChequeo;
	var $st_Ult_Chequeo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_config';
		$this->TableName = 'af_config';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// q_Min_Chequeo
		$this->q_Min_Chequeo = new cField('af_config', 'af_config', 'x_q_Min_Chequeo', 'q_Min_Chequeo', '`q_Min_Chequeo`', '`q_Min_Chequeo`', 3, -1, FALSE, '`q_Min_Chequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_Min_Chequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_Min_Chequeo'] = &$this->q_Min_Chequeo;

		// q_Min_VentChequeo
		$this->q_Min_VentChequeo = new cField('af_config', 'af_config', 'x_q_Min_VentChequeo', 'q_Min_VentChequeo', '`q_Min_VentChequeo`', '`q_Min_VentChequeo`', 3, -1, FALSE, '`q_Min_VentChequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_Min_VentChequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_Min_VentChequeo'] = &$this->q_Min_VentChequeo;

		// f_Ult_Chequeo
		$this->f_Ult_Chequeo = new cField('af_config', 'af_config', 'x_f_Ult_Chequeo', 'f_Ult_Chequeo', '`f_Ult_Chequeo`', '`f_Ult_Chequeo`', 200, 7, FALSE, '`f_Ult_Chequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->f_Ult_Chequeo->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['f_Ult_Chequeo'] = &$this->f_Ult_Chequeo;

		// x_Usuario_Api
		$this->x_Usuario_Api = new cField('af_config', 'af_config', 'x_x_Usuario_Api', 'x_Usuario_Api', '`x_Usuario_Api`', '`x_Usuario_Api`', 200, -1, FALSE, '`x_Usuario_Api`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Usuario_Api'] = &$this->x_Usuario_Api;

		// x_Passw_Api
		$this->x_Passw_Api = new cField('af_config', 'af_config', 'x_x_Passw_Api', 'x_Passw_Api', '`x_Passw_Api`', '`x_Passw_Api`', 200, -1, FALSE, '`x_Passw_Api`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Passw_Api'] = &$this->x_Passw_Api;

		// x_Url_Wsdl
		$this->x_Url_Wsdl = new cField('af_config', 'af_config', 'x_x_Url_Wsdl', 'x_Url_Wsdl', '`x_Url_Wsdl`', '`x_Url_Wsdl`', 200, -1, FALSE, '`x_Url_Wsdl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Url_Wsdl'] = &$this->x_Url_Wsdl;

		// f_Ult_Mod
		$this->f_Ult_Mod = new cField('af_config', 'af_config', 'x_f_Ult_Mod', 'f_Ult_Mod', '`f_Ult_Mod`', 'DATE_FORMAT(`f_Ult_Mod`, \'%d/%m/%Y\')', 135, 9, FALSE, '`f_Ult_Mod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->f_Ult_Mod->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['f_Ult_Mod'] = &$this->f_Ult_Mod;

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod = new cField('af_config', 'af_config', 'x_c_Usuario_Ult_Mod', 'c_Usuario_Ult_Mod', '`c_Usuario_Ult_Mod`', '`c_Usuario_Ult_Mod`', 200, -1, FALSE, '`c_Usuario_Ult_Mod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_Usuario_Ult_Mod'] = &$this->c_Usuario_Ult_Mod;

		// c_IUltChequeo
		$this->c_IUltChequeo = new cField('af_config', 'af_config', 'x_c_IUltChequeo', 'c_IUltChequeo', '`c_IUltChequeo`', '`c_IUltChequeo`', 3, -1, FALSE, '`c_IUltChequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_IUltChequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_IUltChequeo'] = &$this->c_IUltChequeo;

		// st_Ult_Chequeo
		$this->st_Ult_Chequeo = new cField('af_config', 'af_config', 'x_st_Ult_Chequeo', 'st_Ult_Chequeo', '`st_Ult_Chequeo`', '`st_Ult_Chequeo`', 3, -1, FALSE, '`st_Ult_Chequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->st_Ult_Chequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['st_Ult_Chequeo'] = &$this->st_Ult_Chequeo;
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`af_config`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`af_config`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "af_configlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_configlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_configview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_configview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_configadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_configedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_configadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_configdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->q_Min_Chequeo->setDbValue($rs->fields('q_Min_Chequeo'));
		$this->q_Min_VentChequeo->setDbValue($rs->fields('q_Min_VentChequeo'));
		$this->f_Ult_Chequeo->setDbValue($rs->fields('f_Ult_Chequeo'));
		$this->x_Usuario_Api->setDbValue($rs->fields('x_Usuario_Api'));
		$this->x_Passw_Api->setDbValue($rs->fields('x_Passw_Api'));
		$this->x_Url_Wsdl->setDbValue($rs->fields('x_Url_Wsdl'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
		$this->c_IUltChequeo->setDbValue($rs->fields('c_IUltChequeo'));
		$this->st_Ult_Chequeo->setDbValue($rs->fields('st_Ult_Chequeo'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// q_Min_Chequeo
		// q_Min_VentChequeo
		// f_Ult_Chequeo
		// x_Usuario_Api
		// x_Passw_Api
		// x_Url_Wsdl
		// f_Ult_Mod
		// c_Usuario_Ult_Mod
		// c_IUltChequeo
		// st_Ult_Chequeo
		// q_Min_Chequeo

		$this->q_Min_Chequeo->ViewValue = $this->q_Min_Chequeo->CurrentValue;
		$this->q_Min_Chequeo->ViewCustomAttributes = "";

		// q_Min_VentChequeo
		$this->q_Min_VentChequeo->ViewValue = $this->q_Min_VentChequeo->CurrentValue;
		$this->q_Min_VentChequeo->ViewCustomAttributes = "";

		// f_Ult_Chequeo
		$this->f_Ult_Chequeo->ViewValue = $this->f_Ult_Chequeo->CurrentValue;
		$this->f_Ult_Chequeo->ViewValue = ew_FormatDateTime($this->f_Ult_Chequeo->ViewValue, 7);
		$this->f_Ult_Chequeo->ViewCustomAttributes = "";

		// x_Usuario_Api
		$this->x_Usuario_Api->ViewValue = $this->x_Usuario_Api->CurrentValue;
		$this->x_Usuario_Api->ViewCustomAttributes = "";

		// x_Passw_Api
		$this->x_Passw_Api->ViewValue = $this->x_Passw_Api->CurrentValue;
		$this->x_Passw_Api->ViewCustomAttributes = "";

		// x_Url_Wsdl
		$this->x_Url_Wsdl->ViewValue = $this->x_Url_Wsdl->CurrentValue;
		$this->x_Url_Wsdl->ViewCustomAttributes = "";

		// f_Ult_Mod
		$this->f_Ult_Mod->ViewValue = $this->f_Ult_Mod->CurrentValue;
		$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 9);
		$this->f_Ult_Mod->ViewCustomAttributes = "";

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
		$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

		// c_IUltChequeo
		$this->c_IUltChequeo->ViewValue = $this->c_IUltChequeo->CurrentValue;
		$this->c_IUltChequeo->ViewCustomAttributes = "";

		// st_Ult_Chequeo
		if (strval($this->st_Ult_Chequeo->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->st_Ult_Chequeo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_ST_CHEQUEO'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->st_Ult_Chequeo, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->st_Ult_Chequeo->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->st_Ult_Chequeo->ViewValue = $this->st_Ult_Chequeo->CurrentValue;
			}
		} else {
			$this->st_Ult_Chequeo->ViewValue = NULL;
		}
		$this->st_Ult_Chequeo->ViewCustomAttributes = "";

		// q_Min_Chequeo
		$this->q_Min_Chequeo->LinkCustomAttributes = "";
		$this->q_Min_Chequeo->HrefValue = "";
		$this->q_Min_Chequeo->TooltipValue = "";

		// q_Min_VentChequeo
		$this->q_Min_VentChequeo->LinkCustomAttributes = "";
		$this->q_Min_VentChequeo->HrefValue = "";
		$this->q_Min_VentChequeo->TooltipValue = "";

		// f_Ult_Chequeo
		$this->f_Ult_Chequeo->LinkCustomAttributes = "";
		$this->f_Ult_Chequeo->HrefValue = "";
		$this->f_Ult_Chequeo->TooltipValue = "";

		// x_Usuario_Api
		$this->x_Usuario_Api->LinkCustomAttributes = "";
		$this->x_Usuario_Api->HrefValue = "";
		$this->x_Usuario_Api->TooltipValue = "";

		// x_Passw_Api
		$this->x_Passw_Api->LinkCustomAttributes = "";
		$this->x_Passw_Api->HrefValue = "";
		$this->x_Passw_Api->TooltipValue = "";

		// x_Url_Wsdl
		$this->x_Url_Wsdl->LinkCustomAttributes = "";
		$this->x_Url_Wsdl->HrefValue = "";
		$this->x_Url_Wsdl->TooltipValue = "";

		// f_Ult_Mod
		$this->f_Ult_Mod->LinkCustomAttributes = "";
		$this->f_Ult_Mod->HrefValue = "";
		$this->f_Ult_Mod->TooltipValue = "";

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->LinkCustomAttributes = "";
		$this->c_Usuario_Ult_Mod->HrefValue = "";
		$this->c_Usuario_Ult_Mod->TooltipValue = "";

		// c_IUltChequeo
		$this->c_IUltChequeo->LinkCustomAttributes = "";
		$this->c_IUltChequeo->HrefValue = "";
		$this->c_IUltChequeo->TooltipValue = "";

		// st_Ult_Chequeo
		$this->st_Ult_Chequeo->LinkCustomAttributes = "";
		$this->st_Ult_Chequeo->HrefValue = "";
		$this->st_Ult_Chequeo->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->q_Min_Chequeo->Exportable) $Doc->ExportCaption($this->q_Min_Chequeo);
				if ($this->q_Min_VentChequeo->Exportable) $Doc->ExportCaption($this->q_Min_VentChequeo);
				if ($this->f_Ult_Chequeo->Exportable) $Doc->ExportCaption($this->f_Ult_Chequeo);
				if ($this->x_Usuario_Api->Exportable) $Doc->ExportCaption($this->x_Usuario_Api);
				if ($this->x_Passw_Api->Exportable) $Doc->ExportCaption($this->x_Passw_Api);
				if ($this->x_Url_Wsdl->Exportable) $Doc->ExportCaption($this->x_Url_Wsdl);
				if ($this->f_Ult_Mod->Exportable) $Doc->ExportCaption($this->f_Ult_Mod);
				if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportCaption($this->c_Usuario_Ult_Mod);
				if ($this->c_IUltChequeo->Exportable) $Doc->ExportCaption($this->c_IUltChequeo);
				if ($this->st_Ult_Chequeo->Exportable) $Doc->ExportCaption($this->st_Ult_Chequeo);
			} else {
				if ($this->q_Min_Chequeo->Exportable) $Doc->ExportCaption($this->q_Min_Chequeo);
				if ($this->q_Min_VentChequeo->Exportable) $Doc->ExportCaption($this->q_Min_VentChequeo);
				if ($this->f_Ult_Chequeo->Exportable) $Doc->ExportCaption($this->f_Ult_Chequeo);
				if ($this->x_Usuario_Api->Exportable) $Doc->ExportCaption($this->x_Usuario_Api);
				if ($this->x_Passw_Api->Exportable) $Doc->ExportCaption($this->x_Passw_Api);
				if ($this->x_Url_Wsdl->Exportable) $Doc->ExportCaption($this->x_Url_Wsdl);
				if ($this->f_Ult_Mod->Exportable) $Doc->ExportCaption($this->f_Ult_Mod);
				if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportCaption($this->c_Usuario_Ult_Mod);
				if ($this->c_IUltChequeo->Exportable) $Doc->ExportCaption($this->c_IUltChequeo);
				if ($this->st_Ult_Chequeo->Exportable) $Doc->ExportCaption($this->st_Ult_Chequeo);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->q_Min_Chequeo->Exportable) $Doc->ExportField($this->q_Min_Chequeo);
					if ($this->q_Min_VentChequeo->Exportable) $Doc->ExportField($this->q_Min_VentChequeo);
					if ($this->f_Ult_Chequeo->Exportable) $Doc->ExportField($this->f_Ult_Chequeo);
					if ($this->x_Usuario_Api->Exportable) $Doc->ExportField($this->x_Usuario_Api);
					if ($this->x_Passw_Api->Exportable) $Doc->ExportField($this->x_Passw_Api);
					if ($this->x_Url_Wsdl->Exportable) $Doc->ExportField($this->x_Url_Wsdl);
					if ($this->f_Ult_Mod->Exportable) $Doc->ExportField($this->f_Ult_Mod);
					if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportField($this->c_Usuario_Ult_Mod);
					if ($this->c_IUltChequeo->Exportable) $Doc->ExportField($this->c_IUltChequeo);
					if ($this->st_Ult_Chequeo->Exportable) $Doc->ExportField($this->st_Ult_Chequeo);
				} else {
					if ($this->q_Min_Chequeo->Exportable) $Doc->ExportField($this->q_Min_Chequeo);
					if ($this->q_Min_VentChequeo->Exportable) $Doc->ExportField($this->q_Min_VentChequeo);
					if ($this->f_Ult_Chequeo->Exportable) $Doc->ExportField($this->f_Ult_Chequeo);
					if ($this->x_Usuario_Api->Exportable) $Doc->ExportField($this->x_Usuario_Api);
					if ($this->x_Passw_Api->Exportable) $Doc->ExportField($this->x_Passw_Api);
					if ($this->x_Url_Wsdl->Exportable) $Doc->ExportField($this->x_Url_Wsdl);
					if ($this->f_Ult_Mod->Exportable) $Doc->ExportField($this->f_Ult_Mod);
					if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportField($this->c_Usuario_Ult_Mod);
					if ($this->c_IUltChequeo->Exportable) $Doc->ExportField($this->c_IUltChequeo);
					if ($this->st_Ult_Chequeo->Exportable) $Doc->ExportField($this->st_Ult_Chequeo);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
