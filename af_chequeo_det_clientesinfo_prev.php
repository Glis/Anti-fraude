<?php

// Global variable for table object
$af_chequeo_det_clientes = NULL;

//
// Table class for af_chequeo_det_clientes
//
class caf_chequeo_det_clientes extends cTable {
	var $c_ICliente;
	var $c_IDestino;
	var $c_IChequeo;
	var $f_Bloqueo;
	var $c_ICClass;
	var $i_Bloqueo;
	var $c_IReseller;
	var $q_Min_Cliente;
	var $f_Desbloqueo;
	var $i_Alerta;
	var $i_Cuarentena;
	var $c_Usuario_Desbloqueo;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_chequeo_det_clientes';
		$this->TableName = 'af_chequeo_det_clientes';
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

		// c_ICliente
		$this->c_ICliente = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_ICliente', 'c_ICliente', '`c_ICliente`', '`c_ICliente`', 200, -1, FALSE, '`c_ICliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_ICliente'] = &$this->c_ICliente;

		// c_IDestino
		$this->c_IDestino = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_IDestino', 'c_IDestino', '`c_IDestino`', '`c_IDestino`', 200, -1, FALSE, '`c_IDestino`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IDestino'] = &$this->c_IDestino;

		// c_IChequeo
		$this->c_IChequeo = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_IChequeo', 'c_IChequeo', '`c_IChequeo`', '`c_IChequeo`', 3, -1, FALSE, '`c_IChequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_IChequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_IChequeo'] = &$this->c_IChequeo;

		// f_Bloqueo
		$this->f_Bloqueo = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_f_Bloqueo', 'f_Bloqueo', '`f_Bloqueo`', '`f_Bloqueo`', 200, 9, FALSE, '`f_Bloqueo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Bloqueo'] = &$this->f_Bloqueo;

		// c_ICClass
		$this->c_ICClass = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_ICClass', 'c_ICClass', '`c_ICClass`', '`c_ICClass`', 200, -1, FALSE, '`c_ICClass`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_ICClass'] = &$this->c_ICClass;

		// i_Bloqueo
		$this->i_Bloqueo = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_i_Bloqueo', 'i_Bloqueo', '`i_Bloqueo`', '`i_Bloqueo`', 3, -1, FALSE, '`i_Bloqueo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->i_Bloqueo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['i_Bloqueo'] = &$this->i_Bloqueo;

		// c_IReseller
		$this->c_IReseller = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_IReseller', 'c_IReseller', '`c_IReseller`', '`c_IReseller`', 200, -1, FALSE, '`c_IReseller`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IReseller'] = &$this->c_IReseller;

		// q_Min_Cliente
		$this->q_Min_Cliente = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_q_Min_Cliente', 'q_Min_Cliente', '`q_Min_Cliente`', '`q_Min_Cliente`', 3, -1, FALSE, '`q_Min_Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_Min_Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_Min_Cliente'] = &$this->q_Min_Cliente;

		// f_Desbloqueo
		$this->f_Desbloqueo = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_f_Desbloqueo', 'f_Desbloqueo', '`f_Desbloqueo`', '`f_Desbloqueo`', 200, -1, FALSE, '`f_Desbloqueo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Desbloqueo'] = &$this->f_Desbloqueo;

		// i_Alerta
		$this->i_Alerta = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_i_Alerta', 'i_Alerta', '`i_Alerta`', '`i_Alerta`', 3, -1, FALSE, '`i_Alerta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->i_Alerta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['i_Alerta'] = &$this->i_Alerta;

		// i_Cuarentena
		$this->i_Cuarentena = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_i_Cuarentena', 'i_Cuarentena', '`i_Cuarentena`', '`i_Cuarentena`', 3, -1, FALSE, '`i_Cuarentena`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->i_Cuarentena->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['i_Cuarentena'] = &$this->i_Cuarentena;

		// c_Usuario_Desbloqueo
		$this->c_Usuario_Desbloqueo = new cField('af_chequeo_det_clientes', 'af_chequeo_det_clientes', 'x_c_Usuario_Desbloqueo', 'c_Usuario_Desbloqueo', '`c_Usuario_Desbloqueo`', '`c_Usuario_Desbloqueo`', 200, -1, FALSE, '`c_Usuario_Desbloqueo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_Usuario_Desbloqueo'] = &$this->c_Usuario_Desbloqueo;
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
		return "`af_chequeo_det_clientes`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "`i_Bloqueo` = 1";
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
	var $UpdateTable = "`af_chequeo_det_clientes`";

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
			if (array_key_exists('c_ICliente', $rs))
				ew_AddFilter($where, ew_QuotedName('c_ICliente') . '=' . ew_QuotedValue($rs['c_ICliente'], $this->c_ICliente->FldDataType));
			if (array_key_exists('c_IDestino', $rs))
				ew_AddFilter($where, ew_QuotedName('c_IDestino') . '=' . ew_QuotedValue($rs['c_IDestino'], $this->c_IDestino->FldDataType));
			if (array_key_exists('c_IChequeo', $rs))
				ew_AddFilter($where, ew_QuotedName('c_IChequeo') . '=' . ew_QuotedValue($rs['c_IChequeo'], $this->c_IChequeo->FldDataType));
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
		return "`c_ICliente` = '@c_ICliente@' AND `c_IDestino` = '@c_IDestino@' AND `c_IChequeo` = @c_IChequeo@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@c_ICliente@", ew_AdjustSql($this->c_ICliente->CurrentValue), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@c_IDestino@", ew_AdjustSql($this->c_IDestino->CurrentValue), $sKeyFilter); // Replace key value
		if (!is_numeric($this->c_IChequeo->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@c_IChequeo@", ew_AdjustSql($this->c_IChequeo->CurrentValue), $sKeyFilter); // Replace key value
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
			return "af_chequeo_det_clienteslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_chequeo_det_clienteslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_chequeo_det_clientesview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_chequeo_det_clientesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_chequeo_det_clientesadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_chequeo_det_clientesedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_chequeo_det_clientesadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_chequeo_det_clientesdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->c_ICliente->CurrentValue)) {
			$sUrl .= "c_ICliente=" . urlencode($this->c_ICliente->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->c_IDestino->CurrentValue)) {
			$sUrl .= "&c_IDestino=" . urlencode($this->c_IDestino->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->c_IChequeo->CurrentValue)) {
			$sUrl .= "&c_IChequeo=" . urlencode($this->c_IChequeo->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET)) {
			$arKey[] = @$_GET["c_ICliente"]; // c_ICliente
			$arKey[] = @$_GET["c_IDestino"]; // c_IDestino
			$arKey[] = @$_GET["c_IChequeo"]; // c_IChequeo
			$arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_array($key) || count($key) <> 3)
				continue; // Just skip so other keys will still work
			if (!is_numeric($key[2])) // c_IChequeo
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
			$this->c_ICliente->CurrentValue = $key[0];
			$this->c_IDestino->CurrentValue = $key[1];
			$this->c_IChequeo->CurrentValue = $key[2];
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
		$this->c_ICliente->setDbValue($rs->fields('c_ICliente'));
		$this->c_IDestino->setDbValue($rs->fields('c_IDestino'));
		$this->c_IChequeo->setDbValue($rs->fields('c_IChequeo'));
		$this->f_Bloqueo->setDbValue($rs->fields('f_Bloqueo'));
		$this->c_ICClass->setDbValue($rs->fields('c_ICClass'));
		$this->i_Bloqueo->setDbValue($rs->fields('i_Bloqueo'));
		$this->c_IReseller->setDbValue($rs->fields('c_IReseller'));
		$this->q_Min_Cliente->setDbValue($rs->fields('q_Min_Cliente'));
		$this->f_Desbloqueo->setDbValue($rs->fields('f_Desbloqueo'));
		$this->i_Alerta->setDbValue($rs->fields('i_Alerta'));
		$this->i_Cuarentena->setDbValue($rs->fields('i_Cuarentena'));
		$this->c_Usuario_Desbloqueo->setDbValue($rs->fields('c_Usuario_Desbloqueo'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_ICliente
		// c_IDestino
		// c_IChequeo
		// f_Bloqueo
		// c_ICClass
		// i_Bloqueo
		// c_IReseller
		// q_Min_Cliente
		// f_Desbloqueo
		// i_Alerta
		// i_Cuarentena
		// c_Usuario_Desbloqueo
		// c_ICliente

		$this->c_ICliente->ViewValue = $this->c_ICliente->CurrentValue;
		$this->c_ICliente->ViewCustomAttributes = "";

		// c_IDestino
		$this->c_IDestino->ViewValue = $this->c_IDestino->CurrentValue;
		$this->c_IDestino->ViewCustomAttributes = "";

		// c_IChequeo
		$this->c_IChequeo->ViewValue = $this->c_IChequeo->CurrentValue;
		$this->c_IChequeo->ViewCustomAttributes = "";

		// f_Bloqueo
		$this->f_Bloqueo->ViewValue = $this->f_Bloqueo->CurrentValue;
		$this->f_Bloqueo->ViewValue = ew_FormatDateTime($this->f_Bloqueo->ViewValue, 9);
		$this->f_Bloqueo->ViewCustomAttributes = "";

		// c_ICClass
		$this->c_ICClass->ViewValue = $this->c_ICClass->CurrentValue;
		$this->c_ICClass->ViewCustomAttributes = "";

		// i_Bloqueo
		$this->i_Bloqueo->ViewValue = $this->i_Bloqueo->CurrentValue;
		$this->i_Bloqueo->ViewCustomAttributes = "";

		// c_IReseller
		$this->c_IReseller->ViewValue = $this->c_IReseller->CurrentValue;
		$this->c_IReseller->ViewCustomAttributes = "";

		// q_Min_Cliente
		$this->q_Min_Cliente->ViewValue = $this->q_Min_Cliente->CurrentValue;
		$this->q_Min_Cliente->ViewCustomAttributes = "";

		// f_Desbloqueo
		$this->f_Desbloqueo->ViewValue = $this->f_Desbloqueo->CurrentValue;
		$this->f_Desbloqueo->ViewCustomAttributes = "";

		// i_Alerta
		$this->i_Alerta->ViewValue = $this->i_Alerta->CurrentValue;
		$this->i_Alerta->ViewCustomAttributes = "";

		// i_Cuarentena
		$this->i_Cuarentena->ViewValue = $this->i_Cuarentena->CurrentValue;
		$this->i_Cuarentena->ViewCustomAttributes = "";

		// c_Usuario_Desbloqueo
		$this->c_Usuario_Desbloqueo->ViewValue = $this->c_Usuario_Desbloqueo->CurrentValue;
		$this->c_Usuario_Desbloqueo->ViewCustomAttributes = "";

		// c_ICliente
		$this->c_ICliente->LinkCustomAttributes = "";
		$this->c_ICliente->HrefValue = "";
		$this->c_ICliente->TooltipValue = "";

		// c_IDestino
		$this->c_IDestino->LinkCustomAttributes = "";
		$this->c_IDestino->HrefValue = "";
		$this->c_IDestino->TooltipValue = "";

		// c_IChequeo
		$this->c_IChequeo->LinkCustomAttributes = "";
		$this->c_IChequeo->HrefValue = "";
		$this->c_IChequeo->TooltipValue = "";

		// f_Bloqueo
		$this->f_Bloqueo->LinkCustomAttributes = "";
		$this->f_Bloqueo->HrefValue = "";
		$this->f_Bloqueo->TooltipValue = "";

		// c_ICClass
		$this->c_ICClass->LinkCustomAttributes = "";
		$this->c_ICClass->HrefValue = "";
		$this->c_ICClass->TooltipValue = "";

		// i_Bloqueo
		$this->i_Bloqueo->LinkCustomAttributes = "";
		$this->i_Bloqueo->HrefValue = "";
		$this->i_Bloqueo->TooltipValue = "";

		// c_IReseller
		$this->c_IReseller->LinkCustomAttributes = "";
		$this->c_IReseller->HrefValue = "";
		$this->c_IReseller->TooltipValue = "";

		// q_Min_Cliente
		$this->q_Min_Cliente->LinkCustomAttributes = "";
		$this->q_Min_Cliente->HrefValue = "";
		$this->q_Min_Cliente->TooltipValue = "";

		// f_Desbloqueo
		$this->f_Desbloqueo->LinkCustomAttributes = "";
		$this->f_Desbloqueo->HrefValue = "";
		$this->f_Desbloqueo->TooltipValue = "";

		// i_Alerta
		$this->i_Alerta->LinkCustomAttributes = "";
		$this->i_Alerta->HrefValue = "";
		$this->i_Alerta->TooltipValue = "";

		// i_Cuarentena
		$this->i_Cuarentena->LinkCustomAttributes = "";
		$this->i_Cuarentena->HrefValue = "";
		$this->i_Cuarentena->TooltipValue = "";

		// c_Usuario_Desbloqueo
		$this->c_Usuario_Desbloqueo->LinkCustomAttributes = "";
		$this->c_Usuario_Desbloqueo->HrefValue = "";
		$this->c_Usuario_Desbloqueo->TooltipValue = "";

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
				if ($this->c_ICliente->Exportable) $Doc->ExportCaption($this->c_ICliente);
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->c_IChequeo->Exportable) $Doc->ExportCaption($this->c_IChequeo);
				if ($this->f_Bloqueo->Exportable) $Doc->ExportCaption($this->f_Bloqueo);
				if ($this->c_ICClass->Exportable) $Doc->ExportCaption($this->c_ICClass);
				if ($this->i_Bloqueo->Exportable) $Doc->ExportCaption($this->i_Bloqueo);
				if ($this->c_IReseller->Exportable) $Doc->ExportCaption($this->c_IReseller);
				if ($this->q_Min_Cliente->Exportable) $Doc->ExportCaption($this->q_Min_Cliente);
				if ($this->f_Desbloqueo->Exportable) $Doc->ExportCaption($this->f_Desbloqueo);
				if ($this->i_Alerta->Exportable) $Doc->ExportCaption($this->i_Alerta);
				if ($this->i_Cuarentena->Exportable) $Doc->ExportCaption($this->i_Cuarentena);
				if ($this->c_Usuario_Desbloqueo->Exportable) $Doc->ExportCaption($this->c_Usuario_Desbloqueo);
			} else {
				if ($this->c_ICliente->Exportable) $Doc->ExportCaption($this->c_ICliente);
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->c_IChequeo->Exportable) $Doc->ExportCaption($this->c_IChequeo);
				if ($this->f_Bloqueo->Exportable) $Doc->ExportCaption($this->f_Bloqueo);
				if ($this->c_ICClass->Exportable) $Doc->ExportCaption($this->c_ICClass);
				if ($this->i_Bloqueo->Exportable) $Doc->ExportCaption($this->i_Bloqueo);
				if ($this->c_IReseller->Exportable) $Doc->ExportCaption($this->c_IReseller);
				if ($this->q_Min_Cliente->Exportable) $Doc->ExportCaption($this->q_Min_Cliente);
				if ($this->f_Desbloqueo->Exportable) $Doc->ExportCaption($this->f_Desbloqueo);
				if ($this->i_Alerta->Exportable) $Doc->ExportCaption($this->i_Alerta);
				if ($this->i_Cuarentena->Exportable) $Doc->ExportCaption($this->i_Cuarentena);
				if ($this->c_Usuario_Desbloqueo->Exportable) $Doc->ExportCaption($this->c_Usuario_Desbloqueo);
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
					if ($this->c_ICliente->Exportable) $Doc->ExportField($this->c_ICliente);
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->c_IChequeo->Exportable) $Doc->ExportField($this->c_IChequeo);
					if ($this->f_Bloqueo->Exportable) $Doc->ExportField($this->f_Bloqueo);
					if ($this->c_ICClass->Exportable) $Doc->ExportField($this->c_ICClass);
					if ($this->i_Bloqueo->Exportable) $Doc->ExportField($this->i_Bloqueo);
					if ($this->c_IReseller->Exportable) $Doc->ExportField($this->c_IReseller);
					if ($this->q_Min_Cliente->Exportable) $Doc->ExportField($this->q_Min_Cliente);
					if ($this->f_Desbloqueo->Exportable) $Doc->ExportField($this->f_Desbloqueo);
					if ($this->i_Alerta->Exportable) $Doc->ExportField($this->i_Alerta);
					if ($this->i_Cuarentena->Exportable) $Doc->ExportField($this->i_Cuarentena);
					if ($this->c_Usuario_Desbloqueo->Exportable) $Doc->ExportField($this->c_Usuario_Desbloqueo);
				} else {
					if ($this->c_ICliente->Exportable) $Doc->ExportField($this->c_ICliente);
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->c_IChequeo->Exportable) $Doc->ExportField($this->c_IChequeo);
					if ($this->f_Bloqueo->Exportable) $Doc->ExportField($this->f_Bloqueo);
					if ($this->c_ICClass->Exportable) $Doc->ExportField($this->c_ICClass);
					if ($this->i_Bloqueo->Exportable) $Doc->ExportField($this->i_Bloqueo);
					if ($this->c_IReseller->Exportable) $Doc->ExportField($this->c_IReseller);
					if ($this->q_Min_Cliente->Exportable) $Doc->ExportField($this->q_Min_Cliente);
					if ($this->f_Desbloqueo->Exportable) $Doc->ExportField($this->f_Desbloqueo);
					if ($this->i_Alerta->Exportable) $Doc->ExportField($this->i_Alerta);
					if ($this->i_Cuarentena->Exportable) $Doc->ExportField($this->i_Cuarentena);
					if ($this->c_Usuario_Desbloqueo->Exportable) $Doc->ExportField($this->c_Usuario_Desbloqueo);
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
