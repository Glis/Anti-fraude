<?php

// Global variable for table object
$af_umb_destinos = NULL;

//
// Table class for af_umb_destinos
//
class caf_umb_destinos extends cTable {
	var $c_IDestino;
	var $q_MinAl_Plataf;
	var $q_MinCu_Plataf;
	var $q_MinAl_Res;
	var $q_MinCu_Res;
	var $q_MinAl_CClas;
	var $q_MinCu_CClas;
	var $q_MinAl_Cli;
	var $q_MinCu_Cli;
	var $q_MinAl_Cta;
	var $q_MinCu_Cta;
	var $f_Ult_Mod;
	var $c_Usuario_Ult_Mod;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_umb_destinos';
		$this->TableName = 'af_umb_destinos';
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

		// c_IDestino
		$this->c_IDestino = new cField('af_umb_destinos', 'af_umb_destinos', 'x_c_IDestino', 'c_IDestino', '`c_IDestino`', '`c_IDestino`', 200, -1, FALSE, '`c_IDestino`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IDestino'] = &$this->c_IDestino;

		// q_MinAl_Plataf
		$this->q_MinAl_Plataf = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinAl_Plataf', 'q_MinAl_Plataf', '`q_MinAl_Plataf`', '`q_MinAl_Plataf`', 3, -1, FALSE, '`q_MinAl_Plataf`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinAl_Plataf->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinAl_Plataf'] = &$this->q_MinAl_Plataf;

		// q_MinCu_Plataf
		$this->q_MinCu_Plataf = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinCu_Plataf', 'q_MinCu_Plataf', '`q_MinCu_Plataf`', '`q_MinCu_Plataf`', 3, -1, FALSE, '`q_MinCu_Plataf`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinCu_Plataf->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinCu_Plataf'] = &$this->q_MinCu_Plataf;

		// q_MinAl_Res
		$this->q_MinAl_Res = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinAl_Res', 'q_MinAl_Res', '`q_MinAl_Res`', '`q_MinAl_Res`', 3, -1, FALSE, '`q_MinAl_Res`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinAl_Res->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinAl_Res'] = &$this->q_MinAl_Res;

		// q_MinCu_Res
		$this->q_MinCu_Res = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinCu_Res', 'q_MinCu_Res', '`q_MinCu_Res`', '`q_MinCu_Res`', 3, -1, FALSE, '`q_MinCu_Res`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinCu_Res->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinCu_Res'] = &$this->q_MinCu_Res;

		// q_MinAl_CClas
		$this->q_MinAl_CClas = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinAl_CClas', 'q_MinAl_CClas', '`q_MinAl_CClas`', '`q_MinAl_CClas`', 3, -1, FALSE, '`q_MinAl_CClas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinAl_CClas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinAl_CClas'] = &$this->q_MinAl_CClas;

		// q_MinCu_CClas
		$this->q_MinCu_CClas = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinCu_CClas', 'q_MinCu_CClas', '`q_MinCu_CClas`', '`q_MinCu_CClas`', 3, -1, FALSE, '`q_MinCu_CClas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinCu_CClas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinCu_CClas'] = &$this->q_MinCu_CClas;

		// q_MinAl_Cli
		$this->q_MinAl_Cli = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinAl_Cli', 'q_MinAl_Cli', '`q_MinAl_Cli`', '`q_MinAl_Cli`', 3, -1, FALSE, '`q_MinAl_Cli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinAl_Cli->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinAl_Cli'] = &$this->q_MinAl_Cli;

		// q_MinCu_Cli
		$this->q_MinCu_Cli = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinCu_Cli', 'q_MinCu_Cli', '`q_MinCu_Cli`', '`q_MinCu_Cli`', 3, -1, FALSE, '`q_MinCu_Cli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinCu_Cli->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinCu_Cli'] = &$this->q_MinCu_Cli;

		// q_MinAl_Cta
		$this->q_MinAl_Cta = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinAl_Cta', 'q_MinAl_Cta', '`q_MinAl_Cta`', '`q_MinAl_Cta`', 3, -1, FALSE, '`q_MinAl_Cta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinAl_Cta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinAl_Cta'] = &$this->q_MinAl_Cta;

		// q_MinCu_Cta
		$this->q_MinCu_Cta = new cField('af_umb_destinos', 'af_umb_destinos', 'x_q_MinCu_Cta', 'q_MinCu_Cta', '`q_MinCu_Cta`', '`q_MinCu_Cta`', 3, -1, FALSE, '`q_MinCu_Cta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_MinCu_Cta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_MinCu_Cta'] = &$this->q_MinCu_Cta;

		// f_Ult_Mod
		$this->f_Ult_Mod = new cField('af_umb_destinos', 'af_umb_destinos', 'x_f_Ult_Mod', 'f_Ult_Mod', '`f_Ult_Mod`', 'DATE_FORMAT(`f_Ult_Mod`, \'%d/%m/%Y\')', 135, 7, FALSE, '`f_Ult_Mod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->f_Ult_Mod->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['f_Ult_Mod'] = &$this->f_Ult_Mod;

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod = new cField('af_umb_destinos', 'af_umb_destinos', 'x_c_Usuario_Ult_Mod', 'c_Usuario_Ult_Mod', '`c_Usuario_Ult_Mod`', '`c_Usuario_Ult_Mod`', 200, -1, FALSE, '`c_Usuario_Ult_Mod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_Usuario_Ult_Mod'] = &$this->c_Usuario_Ult_Mod;
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
		return "`af_umb_destinos`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		if($_SESSION['filtros_umb'] != ""){
				$cant = count($_SESSION['filtros_umb']);
				$k = 1;
				$where = $this->SqlFrom().".`c_IDestino` IN (";
				while($k <= $cant - 1){
					$where .= $_SESSION['filtros_umb'][$k]['i_dest']. ", ";
					$k++;
				}

				$where .= $_SESSION['filtros_umb'][$k]['i_dest'] . ")";
				$sWhere = $where; //var_dump($where);
				return $sWhere;
			
		}else{
			$sWhere = "";
			$this->TableFilter = "";
			ew_AddFilter($sWhere, $this->TableFilter);
			return $sWhere;
		}
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
	var $UpdateTable = "`af_umb_destinos`";

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
			if (array_key_exists('c_IDestino', $rs))
				ew_AddFilter($where, ew_QuotedName('c_IDestino') . '=' . ew_QuotedValue($rs['c_IDestino'], $this->c_IDestino->FldDataType));
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
		return "`c_IDestino` = '@c_IDestino@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@c_IDestino@", ew_AdjustSql($this->c_IDestino->CurrentValue), $sKeyFilter); // Replace key value
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
			return "af_umb_destinoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_umb_destinoslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_umb_destinosview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_umb_destinosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_umb_destinosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_umb_destinosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_umb_destinosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_umb_destinosdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->c_IDestino->CurrentValue)) {
			$sUrl .= "c_IDestino=" . urlencode($this->c_IDestino->CurrentValue);
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
			$arKeys[] = @$_GET["c_IDestino"]; // c_IDestino

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
			$this->c_IDestino->CurrentValue = $key;
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
		$this->c_IDestino->setDbValue($rs->fields('c_IDestino'));
		$this->q_MinAl_Plataf->setDbValue($rs->fields('q_MinAl_Plataf'));
		$this->q_MinCu_Plataf->setDbValue($rs->fields('q_MinCu_Plataf'));
		$this->q_MinAl_Res->setDbValue($rs->fields('q_MinAl_Res'));
		$this->q_MinCu_Res->setDbValue($rs->fields('q_MinCu_Res'));
		$this->q_MinAl_CClas->setDbValue($rs->fields('q_MinAl_CClas'));
		$this->q_MinCu_CClas->setDbValue($rs->fields('q_MinCu_CClas'));
		$this->q_MinAl_Cli->setDbValue($rs->fields('q_MinAl_Cli'));
		$this->q_MinCu_Cli->setDbValue($rs->fields('q_MinCu_Cli'));
		$this->q_MinAl_Cta->setDbValue($rs->fields('q_MinAl_Cta'));
		$this->q_MinCu_Cta->setDbValue($rs->fields('q_MinCu_Cta'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_IDestino
		// q_MinAl_Plataf
		// q_MinCu_Plataf
		// q_MinAl_Res
		// q_MinCu_Res
		// q_MinAl_CClas
		// q_MinCu_CClas
		// q_MinAl_Cli
		// q_MinCu_Cli
		// q_MinAl_Cta
		// q_MinCu_Cta
		// f_Ult_Mod
		// c_Usuario_Ult_Mod
		// c_IDestino

		if (strval($this->c_IDestino->CurrentValue) <> "") {
			$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->c_IDestino->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->c_IDestino, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->c_IDestino->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->c_IDestino->ViewValue = $this->c_IDestino->CurrentValue;
			}
		} else {
			$this->c_IDestino->ViewValue = NULL;
		}
		$this->c_IDestino->ViewCustomAttributes = "";

		// q_MinAl_Plataf
		$this->q_MinAl_Plataf->ViewValue = $this->q_MinAl_Plataf->CurrentValue;
		$this->q_MinAl_Plataf->ViewCustomAttributes = "";

		// q_MinCu_Plataf
		$this->q_MinCu_Plataf->ViewValue = $this->q_MinCu_Plataf->CurrentValue;
		$this->q_MinCu_Plataf->ViewCustomAttributes = "";

		// q_MinAl_Res
		$this->q_MinAl_Res->ViewValue = $this->q_MinAl_Res->CurrentValue;
		$this->q_MinAl_Res->ViewCustomAttributes = "";

		// q_MinCu_Res
		$this->q_MinCu_Res->ViewValue = $this->q_MinCu_Res->CurrentValue;
		$this->q_MinCu_Res->ViewCustomAttributes = "";

		// q_MinAl_CClas
		$this->q_MinAl_CClas->ViewValue = $this->q_MinAl_CClas->CurrentValue;
		$this->q_MinAl_CClas->ViewCustomAttributes = "";

		// q_MinCu_CClas
		$this->q_MinCu_CClas->ViewValue = $this->q_MinCu_CClas->CurrentValue;
		$this->q_MinCu_CClas->ViewCustomAttributes = "";

		// q_MinAl_Cli
		$this->q_MinAl_Cli->ViewValue = $this->q_MinAl_Cli->CurrentValue;
		$this->q_MinAl_Cli->ViewCustomAttributes = "";

		// q_MinCu_Cli
		$this->q_MinCu_Cli->ViewValue = $this->q_MinCu_Cli->CurrentValue;
		$this->q_MinCu_Cli->ViewCustomAttributes = "";

		// q_MinAl_Cta
		$this->q_MinAl_Cta->ViewValue = $this->q_MinAl_Cta->CurrentValue;
		$this->q_MinAl_Cta->ViewCustomAttributes = "";

		// q_MinCu_Cta
		$this->q_MinCu_Cta->ViewValue = $this->q_MinCu_Cta->CurrentValue;
		$this->q_MinCu_Cta->ViewCustomAttributes = "";

		// f_Ult_Mod
		$this->f_Ult_Mod->ViewValue = $this->f_Ult_Mod->CurrentValue;
		$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 7);
		$this->f_Ult_Mod->ViewCustomAttributes = "";

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
		$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

		// c_IDestino
		$this->c_IDestino->LinkCustomAttributes = "";
		$this->c_IDestino->HrefValue = "";
		$this->c_IDestino->TooltipValue = "";

		// q_MinAl_Plataf
		$this->q_MinAl_Plataf->LinkCustomAttributes = "";
		$this->q_MinAl_Plataf->HrefValue = "";
		$this->q_MinAl_Plataf->TooltipValue = "";

		// q_MinCu_Plataf
		$this->q_MinCu_Plataf->LinkCustomAttributes = "";
		$this->q_MinCu_Plataf->HrefValue = "";
		$this->q_MinCu_Plataf->TooltipValue = "";

		// q_MinAl_Res
		$this->q_MinAl_Res->LinkCustomAttributes = "";
		$this->q_MinAl_Res->HrefValue = "";
		$this->q_MinAl_Res->TooltipValue = "";

		// q_MinCu_Res
		$this->q_MinCu_Res->LinkCustomAttributes = "";
		$this->q_MinCu_Res->HrefValue = "";
		$this->q_MinCu_Res->TooltipValue = "";

		// q_MinAl_CClas
		$this->q_MinAl_CClas->LinkCustomAttributes = "";
		$this->q_MinAl_CClas->HrefValue = "";
		$this->q_MinAl_CClas->TooltipValue = "";

		// q_MinCu_CClas
		$this->q_MinCu_CClas->LinkCustomAttributes = "";
		$this->q_MinCu_CClas->HrefValue = "";
		$this->q_MinCu_CClas->TooltipValue = "";

		// q_MinAl_Cli
		$this->q_MinAl_Cli->LinkCustomAttributes = "";
		$this->q_MinAl_Cli->HrefValue = "";
		$this->q_MinAl_Cli->TooltipValue = "";

		// q_MinCu_Cli
		$this->q_MinCu_Cli->LinkCustomAttributes = "";
		$this->q_MinCu_Cli->HrefValue = "";
		$this->q_MinCu_Cli->TooltipValue = "";

		// q_MinAl_Cta
		$this->q_MinAl_Cta->LinkCustomAttributes = "";
		$this->q_MinAl_Cta->HrefValue = "";
		$this->q_MinAl_Cta->TooltipValue = "";

		// q_MinCu_Cta
		$this->q_MinCu_Cta->LinkCustomAttributes = "";
		$this->q_MinCu_Cta->HrefValue = "";
		$this->q_MinCu_Cta->TooltipValue = "";

		// f_Ult_Mod
		$this->f_Ult_Mod->LinkCustomAttributes = "";
		$this->f_Ult_Mod->HrefValue = "";
		$this->f_Ult_Mod->TooltipValue = "";

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->LinkCustomAttributes = "";
		$this->c_Usuario_Ult_Mod->HrefValue = "";
		$this->c_Usuario_Ult_Mod->TooltipValue = "";

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
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->q_MinAl_Plataf->Exportable) $Doc->ExportCaption($this->q_MinAl_Plataf);
				if ($this->q_MinCu_Plataf->Exportable) $Doc->ExportCaption($this->q_MinCu_Plataf);
				if ($this->q_MinAl_Res->Exportable) $Doc->ExportCaption($this->q_MinAl_Res);
				if ($this->q_MinCu_Res->Exportable) $Doc->ExportCaption($this->q_MinCu_Res);
				if ($this->q_MinAl_CClas->Exportable) $Doc->ExportCaption($this->q_MinAl_CClas);
				if ($this->q_MinCu_CClas->Exportable) $Doc->ExportCaption($this->q_MinCu_CClas);
				if ($this->q_MinAl_Cli->Exportable) $Doc->ExportCaption($this->q_MinAl_Cli);
				if ($this->q_MinCu_Cli->Exportable) $Doc->ExportCaption($this->q_MinCu_Cli);
				if ($this->q_MinAl_Cta->Exportable) $Doc->ExportCaption($this->q_MinAl_Cta);
				if ($this->q_MinCu_Cta->Exportable) $Doc->ExportCaption($this->q_MinCu_Cta);
				if ($this->f_Ult_Mod->Exportable) $Doc->ExportCaption($this->f_Ult_Mod);
				if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportCaption($this->c_Usuario_Ult_Mod);
			} else {
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->q_MinAl_Plataf->Exportable) $Doc->ExportCaption($this->q_MinAl_Plataf);
				if ($this->q_MinCu_Plataf->Exportable) $Doc->ExportCaption($this->q_MinCu_Plataf);
				if ($this->q_MinAl_Res->Exportable) $Doc->ExportCaption($this->q_MinAl_Res);
				if ($this->q_MinCu_Res->Exportable) $Doc->ExportCaption($this->q_MinCu_Res);
				if ($this->q_MinAl_CClas->Exportable) $Doc->ExportCaption($this->q_MinAl_CClas);
				if ($this->q_MinCu_CClas->Exportable) $Doc->ExportCaption($this->q_MinCu_CClas);
				if ($this->q_MinAl_Cli->Exportable) $Doc->ExportCaption($this->q_MinAl_Cli);
				if ($this->q_MinCu_Cli->Exportable) $Doc->ExportCaption($this->q_MinCu_Cli);
				if ($this->q_MinAl_Cta->Exportable) $Doc->ExportCaption($this->q_MinAl_Cta);
				if ($this->q_MinCu_Cta->Exportable) $Doc->ExportCaption($this->q_MinCu_Cta);
				if ($this->f_Ult_Mod->Exportable) $Doc->ExportCaption($this->f_Ult_Mod);
				if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportCaption($this->c_Usuario_Ult_Mod);
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
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->q_MinAl_Plataf->Exportable) $Doc->ExportField($this->q_MinAl_Plataf);
					if ($this->q_MinCu_Plataf->Exportable) $Doc->ExportField($this->q_MinCu_Plataf);
					if ($this->q_MinAl_Res->Exportable) $Doc->ExportField($this->q_MinAl_Res);
					if ($this->q_MinCu_Res->Exportable) $Doc->ExportField($this->q_MinCu_Res);
					if ($this->q_MinAl_CClas->Exportable) $Doc->ExportField($this->q_MinAl_CClas);
					if ($this->q_MinCu_CClas->Exportable) $Doc->ExportField($this->q_MinCu_CClas);
					if ($this->q_MinAl_Cli->Exportable) $Doc->ExportField($this->q_MinAl_Cli);
					if ($this->q_MinCu_Cli->Exportable) $Doc->ExportField($this->q_MinCu_Cli);
					if ($this->q_MinAl_Cta->Exportable) $Doc->ExportField($this->q_MinAl_Cta);
					if ($this->q_MinCu_Cta->Exportable) $Doc->ExportField($this->q_MinCu_Cta);
					if ($this->f_Ult_Mod->Exportable) $Doc->ExportField($this->f_Ult_Mod);
					if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportField($this->c_Usuario_Ult_Mod);
				} else {
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->q_MinAl_Plataf->Exportable) $Doc->ExportField($this->q_MinAl_Plataf);
					if ($this->q_MinCu_Plataf->Exportable) $Doc->ExportField($this->q_MinCu_Plataf);
					if ($this->q_MinAl_Res->Exportable) $Doc->ExportField($this->q_MinAl_Res);
					if ($this->q_MinCu_Res->Exportable) $Doc->ExportField($this->q_MinCu_Res);
					if ($this->q_MinAl_CClas->Exportable) $Doc->ExportField($this->q_MinAl_CClas);
					if ($this->q_MinCu_CClas->Exportable) $Doc->ExportField($this->q_MinCu_CClas);
					if ($this->q_MinAl_Cli->Exportable) $Doc->ExportField($this->q_MinAl_Cli);
					if ($this->q_MinCu_Cli->Exportable) $Doc->ExportField($this->q_MinCu_Cli);
					if ($this->q_MinAl_Cta->Exportable) $Doc->ExportField($this->q_MinAl_Cta);
					if ($this->q_MinCu_Cta->Exportable) $Doc->ExportField($this->q_MinCu_Cta);
					if ($this->f_Ult_Mod->Exportable) $Doc->ExportField($this->f_Ult_Mod);
					if ($this->c_Usuario_Ult_Mod->Exportable) $Doc->ExportField($this->c_Usuario_Ult_Mod);
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
