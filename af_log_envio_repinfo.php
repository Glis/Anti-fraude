<?php

// Global variable for table object
$af_log_envio_rep = NULL;

//
// Table class for af_log_envio_rep
//
class caf_log_envio_rep extends cTable {
	var $c_ITransaccion;
	var $f_Transaccion;
	var $c_IReporte;
	var $c_IConfig;
	var $st_Envio;
	var $x_DirCorreo;
	var $x_Obs;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_log_envio_rep';
		$this->TableName = 'af_log_envio_rep';
		$this->TableType = 'TABLE';
		$this->ExportAll = FALSE;
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

		// c_ITransaccion
		$this->c_ITransaccion = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_c_ITransaccion', 'c_ITransaccion', '`c_ITransaccion`', '`c_ITransaccion`', 3, -1, FALSE, '`c_ITransaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_ITransaccion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_ITransaccion'] = &$this->c_ITransaccion;

		// f_Transaccion
		$this->f_Transaccion = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_f_Transaccion', 'f_Transaccion', '`f_Transaccion`', '`f_Transaccion`', 200, 11, FALSE, '`f_Transaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Transaccion'] = &$this->f_Transaccion;

		// c_IReporte
		$this->c_IReporte = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_c_IReporte', 'c_IReporte', '`c_IReporte`', '`c_IReporte`', 3, -1, FALSE, '`c_IReporte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_IReporte->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_IReporte'] = &$this->c_IReporte;

		// c_IConfig
		$this->c_IConfig = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_c_IConfig', 'c_IConfig', '`c_IConfig`', '`c_IConfig`', 3, -1, FALSE, '`c_IConfig`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_IConfig->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_IConfig'] = &$this->c_IConfig;

		// st_Envio
		$this->st_Envio = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_st_Envio', 'st_Envio', '`st_Envio`', '`st_Envio`', 3, -1, FALSE, '`st_Envio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->st_Envio->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['st_Envio'] = &$this->st_Envio;

		// x_DirCorreo
		$this->x_DirCorreo = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_x_DirCorreo', 'x_DirCorreo', '`x_DirCorreo`', '`x_DirCorreo`', 200, -1, FALSE, '`x_DirCorreo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_DirCorreo'] = &$this->x_DirCorreo;

		// x_Obs
		$this->x_Obs = new cField('af_log_envio_rep', 'af_log_envio_rep', 'x_x_Obs', 'x_Obs', '`x_Obs`', '`x_Obs`', 201, -1, FALSE, '`x_Obs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Obs'] = &$this->x_Obs;
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
		return "`af_log_envio_rep`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$where = "";
		if($_SESSION['filtros_log']['desde'] == "" && $_SESSION['filtros_log']['hasta'] == "" &&
			$_SESSION['filtros_log']['reporte'] == "" && $_SESSION['filtros_log']['estatus'] == ""){

			$sWhere = "";
			$this->TableFilter = "";
			ew_AddFilter($sWhere, $this->TableFilter);
			return $sWhere;
		}else{

			if(($_SESSION['filtros_log']['desde'] != "") && ($_SESSION['filtros_log']['hasta'] != "")){
				$where = $this->SqlFrom() . ".`f_Transaccion` BETWEEN '" . $_SESSION['filtros_log']['desde'] . "' AND '" . $_SESSION['filtros_log']['hasta'] . "' ";
			}else{
				if ($_SESSION['filtros_log']['desde'] != ""){
					$where = $this->SqlFrom() . ".`f_Transaccion`='" . $_SESSION['filtros_log']['desde'] . "'";
				}else{
					if ($_SESSION['filtros_log']['hasta'] != "") {
						$where = $this->SqlFrom() . ".`f_Transaccion`='" . $_SESSION['filtros_log']['desde'] . "'";
					}
				}
			}

			if($_SESSION['filtros_log']['reporte'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`c_IReporte`=" . $_SESSION['filtros_log']['reporte'];					
				}else{
					$where = $this->SqlFrom() . ".`c_IReporte`=" . $_SESSION['filtros_log']['reporte'];
				}
			}

			if($_SESSION['filtros_log']['estatus'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`st_Envio`=" . $_SESSION['filtros_log']['estatus'];					
				}else{
					$where = $this->SqlFrom() . ".`st_Envio`=" . $_SESSION['filtros_log']['estatus'];
				}
			}
			return $where;
		}
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`f_Transaccion` DESC";
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
	var $UpdateTable = "`af_log_envio_rep`";

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
			if (array_key_exists('c_ITransaccion', $rs))
				ew_AddFilter($where, ew_QuotedName('c_ITransaccion') . '=' . ew_QuotedValue($rs['c_ITransaccion'], $this->c_ITransaccion->FldDataType));
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
		return "`c_ITransaccion` = @c_ITransaccion@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->c_ITransaccion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@c_ITransaccion@", ew_AdjustSql($this->c_ITransaccion->CurrentValue), $sKeyFilter); // Replace key value
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
			return "af_log_envio_replist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_log_envio_replist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_log_envio_repview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_log_envio_repview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_log_envio_repadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_log_envio_repedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_log_envio_repadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_log_envio_repdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->c_ITransaccion->CurrentValue)) {
			$sUrl .= "c_ITransaccion=" . urlencode($this->c_ITransaccion->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
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
			$arKeys[] = @$_GET["c_ITransaccion"]; // c_ITransaccion

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
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
			$this->c_ITransaccion->CurrentValue = $key;
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
		$this->c_ITransaccion->setDbValue($rs->fields('c_ITransaccion'));
		$this->f_Transaccion->setDbValue($rs->fields('f_Transaccion'));
		$this->c_IReporte->setDbValue($rs->fields('c_IReporte'));
		$this->c_IConfig->setDbValue($rs->fields('c_IConfig'));
		$this->st_Envio->setDbValue($rs->fields('st_Envio'));
		$this->x_DirCorreo->setDbValue($rs->fields('x_DirCorreo'));
		$this->x_Obs->setDbValue($rs->fields('x_Obs'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_ITransaccion
		// f_Transaccion
		// c_IReporte
		// c_IConfig
		// st_Envio
		// x_DirCorreo
		// x_Obs
		// c_ITransaccion

		$this->c_ITransaccion->ViewValue = $this->c_ITransaccion->CurrentValue;
		$this->c_ITransaccion->ViewCustomAttributes = "";

		// f_Transaccion
		$this->f_Transaccion->ViewValue = $this->f_Transaccion->CurrentValue;
		$this->f_Transaccion->ViewValue = ew_FormatDateTime($this->f_Transaccion->ViewValue, 11);
		$this->f_Transaccion->ViewCustomAttributes = "";

		// c_IReporte
		if (strval($this->c_IReporte->CurrentValue) <> "") {
			$sFilterWrk = "`c_IReporte`" . ew_SearchString("=", $this->c_IReporte->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `c_IReporte`, `x_NbReporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_reportes`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->c_IReporte, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->c_IReporte->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->c_IReporte->ViewValue = $this->c_IReporte->CurrentValue;
			}
		} else {
			$this->c_IReporte->ViewValue = NULL;
		}
		$this->c_IReporte->ViewCustomAttributes = "";

		// c_IConfig
		$this->c_IConfig->ViewValue = $this->c_IConfig->CurrentValue;
		$this->c_IConfig->ViewCustomAttributes = "";

		// st_Envio
		if (strval($this->st_Envio->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->st_Envio->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_STATUS_ENVIO'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->st_Envio, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->st_Envio->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->st_Envio->ViewValue = $this->st_Envio->CurrentValue;
			}
		} else {
			$this->st_Envio->ViewValue = NULL;
		}
		$this->st_Envio->ViewCustomAttributes = "";

		// x_DirCorreo
		$this->x_DirCorreo->ViewValue = $this->x_DirCorreo->CurrentValue;
		$this->x_DirCorreo->ViewCustomAttributes = "";

		// x_Obs
		$this->x_Obs->ViewValue = $this->x_Obs->CurrentValue;
		$this->x_Obs->ViewCustomAttributes = "";

		// c_ITransaccion
		$this->c_ITransaccion->LinkCustomAttributes = "";
		$this->c_ITransaccion->HrefValue = "";
		$this->c_ITransaccion->TooltipValue = "";

		// f_Transaccion
		$this->f_Transaccion->LinkCustomAttributes = "";
		$this->f_Transaccion->HrefValue = "";
		$this->f_Transaccion->TooltipValue = "";

		// c_IReporte
		$this->c_IReporte->LinkCustomAttributes = "";
		$this->c_IReporte->HrefValue = "";
		$this->c_IReporte->TooltipValue = "";

		// c_IConfig
		$this->c_IConfig->LinkCustomAttributes = "";
		$this->c_IConfig->HrefValue = "";
		$this->c_IConfig->TooltipValue = "";

		// st_Envio
		$this->st_Envio->LinkCustomAttributes = "";
		$this->st_Envio->HrefValue = "";
		$this->st_Envio->TooltipValue = "";

		// x_DirCorreo
		$this->x_DirCorreo->LinkCustomAttributes = "";
		$this->x_DirCorreo->HrefValue = "";
		$this->x_DirCorreo->TooltipValue = "";

		// x_Obs
		$this->x_Obs->LinkCustomAttributes = "";
		$this->x_Obs->HrefValue = "";
		$this->x_Obs->TooltipValue = "";

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
				if ($this->c_ITransaccion->Exportable) $Doc->ExportCaption($this->c_ITransaccion);
				if ($this->f_Transaccion->Exportable) $Doc->ExportCaption($this->f_Transaccion);
				if ($this->c_IReporte->Exportable) $Doc->ExportCaption($this->c_IReporte);
				if ($this->c_IConfig->Exportable) $Doc->ExportCaption($this->c_IConfig);
				if ($this->st_Envio->Exportable) $Doc->ExportCaption($this->st_Envio);
				if ($this->x_DirCorreo->Exportable) $Doc->ExportCaption($this->x_DirCorreo);
				if ($this->x_Obs->Exportable) $Doc->ExportCaption($this->x_Obs);
			} else {
				if ($this->c_ITransaccion->Exportable) $Doc->ExportCaption($this->c_ITransaccion);
				if ($this->f_Transaccion->Exportable) $Doc->ExportCaption($this->f_Transaccion);
				if ($this->c_IReporte->Exportable) $Doc->ExportCaption($this->c_IReporte);
				if ($this->c_IConfig->Exportable) $Doc->ExportCaption($this->c_IConfig);
				if ($this->st_Envio->Exportable) $Doc->ExportCaption($this->st_Envio);
				if ($this->x_DirCorreo->Exportable) $Doc->ExportCaption($this->x_DirCorreo);
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
					if ($this->c_ITransaccion->Exportable) $Doc->ExportField($this->c_ITransaccion);
					if ($this->f_Transaccion->Exportable) $Doc->ExportField($this->f_Transaccion);
					if ($this->c_IReporte->Exportable) $Doc->ExportField($this->c_IReporte);
					if ($this->c_IConfig->Exportable) $Doc->ExportField($this->c_IConfig);
					if ($this->st_Envio->Exportable) $Doc->ExportField($this->st_Envio);
					if ($this->x_DirCorreo->Exportable) $Doc->ExportField($this->x_DirCorreo);
					if ($this->x_Obs->Exportable) $Doc->ExportField($this->x_Obs);
				} else {
					if ($this->c_ITransaccion->Exportable) $Doc->ExportField($this->c_ITransaccion);
					if ($this->f_Transaccion->Exportable) $Doc->ExportField($this->f_Transaccion);
					if ($this->c_IReporte->Exportable) $Doc->ExportField($this->c_IReporte);
					if ($this->c_IConfig->Exportable) $Doc->ExportField($this->c_IConfig);
					if ($this->st_Envio->Exportable) $Doc->ExportField($this->st_Envio);
					if ($this->x_DirCorreo->Exportable) $Doc->ExportField($this->x_DirCorreo);
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
