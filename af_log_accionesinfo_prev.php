<?php

// Global variable for table object
$af_log_acciones = NULL;

//
// Table class for af_log_acciones
//
class caf_log_acciones extends cTable {
	var $c_ITransaccion;
	var $f_Transaccion;
	var $c_IDestino;
	var $cl_Accion;
	var $t_Accion;
	var $nv_Accion;
	var $q_Min_Destino;
	var $c_IChequeo;
	var $c_IReseller;
	var $c_ICClass;
	var $c_ICliente;
	var $c_ICuenta;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_log_acciones';
		$this->TableName = 'af_log_acciones';
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

		// c_ITransaccion
		$this->c_ITransaccion = new cField('af_log_acciones', 'af_log_acciones', 'x_c_ITransaccion', 'c_ITransaccion', '`c_ITransaccion`', '`c_ITransaccion`', 3, -1, FALSE, '`c_ITransaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_ITransaccion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_ITransaccion'] = &$this->c_ITransaccion;

		// f_Transaccion
		$this->f_Transaccion = new cField('af_log_acciones', 'af_log_acciones', 'x_f_Transaccion', 'f_Transaccion', '`f_Transaccion`', '`f_Transaccion`', 200, 11, FALSE, '`f_Transaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Transaccion'] = &$this->f_Transaccion;

		// c_IDestino
		$this->c_IDestino = new cField('af_log_acciones', 'af_log_acciones', 'x_c_IDestino', 'c_IDestino', '`c_IDestino`', '`c_IDestino`', 200, -1, FALSE, '`c_IDestino`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IDestino'] = &$this->c_IDestino;

		// cl_Accion
		$this->cl_Accion = new cField('af_log_acciones', 'af_log_acciones', 'x_cl_Accion', 'cl_Accion', '`cl_Accion`', '`cl_Accion`', 3, -1, FALSE, '`cl_Accion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->cl_Accion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cl_Accion'] = &$this->cl_Accion;

		// t_Accion
		$this->t_Accion = new cField('af_log_acciones', 'af_log_acciones', 'x_t_Accion', 't_Accion', '`t_Accion`', '`t_Accion`', 3, -1, FALSE, '`t_Accion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->t_Accion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['t_Accion'] = &$this->t_Accion;

		// nv_Accion
		$this->nv_Accion = new cField('af_log_acciones', 'af_log_acciones', 'x_nv_Accion', 'nv_Accion', '`nv_Accion`', '`nv_Accion`', 3, -1, FALSE, '`nv_Accion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nv_Accion'] = &$this->nv_Accion;

		// q_Min_Destino
		$this->q_Min_Destino = new cField('af_log_acciones', 'af_log_acciones', 'x_q_Min_Destino', 'q_Min_Destino', '`q_Min_Destino`', '`q_Min_Destino`', 3, -1, FALSE, '`q_Min_Destino`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->q_Min_Destino->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['q_Min_Destino'] = &$this->q_Min_Destino;

		// c_IChequeo
		$this->c_IChequeo = new cField('af_log_acciones', 'af_log_acciones', 'x_c_IChequeo', 'c_IChequeo', '`c_IChequeo`', '`c_IChequeo`', 3, -1, FALSE, '`c_IChequeo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_IChequeo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_IChequeo'] = &$this->c_IChequeo;

		// c_IReseller
		$this->c_IReseller = new cField('af_log_acciones', 'af_log_acciones', 'x_c_IReseller', 'c_IReseller', '`c_IReseller`', '`c_IReseller`', 200, -1, FALSE, '`c_IReseller`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IReseller'] = &$this->c_IReseller;

		// c_ICClass
		$this->c_ICClass = new cField('af_log_acciones', 'af_log_acciones', 'x_c_ICClass', 'c_ICClass', '`c_ICClass`', '`c_ICClass`', 200, -1, FALSE, '`c_ICClass`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_ICClass'] = &$this->c_ICClass;

		// c_ICliente
		$this->c_ICliente = new cField('af_log_acciones', 'af_log_acciones', 'x_c_ICliente', 'c_ICliente', '`c_ICliente`', '`c_ICliente`', 200, -1, FALSE, '`c_ICliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_ICliente'] = &$this->c_ICliente;

		// c_ICuenta
		$this->c_ICuenta = new cField('af_log_acciones', 'af_log_acciones', 'x_c_ICuenta', 'c_ICuenta', '`c_ICuenta`', '`c_ICuenta`', 200, -1, FALSE, '`c_ICuenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_ICuenta'] = &$this->c_ICuenta;
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
		return "`af_log_acciones`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$where = "";
		if($_SESSION['filtros_log']['desde'] == "" && $_SESSION['filtros_log']['hasta'] == "" && $_SESSION['filtros_log']['destino'] == "" &&
			$_SESSION['filtros_log']['clase'] == "" && $_SESSION['filtros_log']['nivel'] == ""){

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

			if($_SESSION['filtros_log']['clase'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`cl_Accion`=" . $_SESSION['filtros_log']['clase'];					
				}else{
					$where = $this->SqlFrom() . ".`cl_Accion`=" . $_SESSION['filtros_log']['clase'];
				}
			}

			if($_SESSION['filtros_log']['nivel'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`nv_Accion`=" . $_SESSION['filtros_log']['nivel'];					
				}else{
					$where = $this->SqlFrom() . ".`nv_Accion`=" . $_SESSION['filtros_log']['nivel'];
				}
			}

			if($_SESSION['filtros_log']['destino'] != ""){
				if($where != ""){
					$cant = count($_SESSION['filtros_log']['destino']);
					$k = 1;
					$where = " AND " . $this->SqlFrom().".`c_IDestino` IN (";
					while($k <= $cant - 1){
						$where .=  $_SESSION['filtros_log']['destino'][$k]['i_dest']. ", ";
						$k++;
					}

					$where .= $_SESSION['filtros_log']['destino'][$k]['i_dest'] . ")";
				}else{
					$cant = count($_SESSION['filtros_log']['destino']);
					$k = 1;
					$where = $this->SqlFrom().".`c_IDestino` IN (";
					while($k <= $cant - 1){
						$where .= $_SESSION['filtros_log']['destino'][$k]['i_dest']. ", ";
						$k++;
					}

					$where .= $_SESSION['filtros_log']['destino'][$k]['i_dest'] . ")";
				}

			}
			print_r($where);
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
	var $UpdateTable = "`af_log_acciones`";

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
			return "af_log_accioneslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_log_accioneslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_log_accionesview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_log_accionesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_log_accionesadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_log_accionesedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_log_accionesadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_log_accionesdelete.php", $this->UrlParm());
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
		$this->c_IDestino->setDbValue($rs->fields('c_IDestino'));
		$this->cl_Accion->setDbValue($rs->fields('cl_Accion'));
		$this->t_Accion->setDbValue($rs->fields('t_Accion'));
		$this->nv_Accion->setDbValue($rs->fields('nv_Accion'));
		$this->q_Min_Destino->setDbValue($rs->fields('q_Min_Destino'));
		$this->c_IChequeo->setDbValue($rs->fields('c_IChequeo'));
		$this->c_IReseller->setDbValue($rs->fields('c_IReseller'));
		$this->c_ICClass->setDbValue($rs->fields('c_ICClass'));
		$this->c_ICliente->setDbValue($rs->fields('c_ICliente'));
		$this->c_ICuenta->setDbValue($rs->fields('c_ICuenta'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_ITransaccion
		// f_Transaccion
		// c_IDestino
		// cl_Accion
		// t_Accion
		// nv_Accion
		// q_Min_Destino
		// c_IChequeo
		// c_IReseller

		$this->c_IReseller->CellCssStyle = "white-space: nowrap;";

		// c_ICClass
		$this->c_ICClass->CellCssStyle = "white-space: nowrap;";

		// c_ICliente
		$this->c_ICliente->CellCssStyle = "white-space: nowrap;";

		// c_ICuenta
		$this->c_ICuenta->CellCssStyle = "white-space: nowrap;";

		// c_ITransaccion
		$this->c_ITransaccion->ViewValue = $this->c_ITransaccion->CurrentValue;
		$this->c_ITransaccion->ViewCustomAttributes = "";

		// f_Transaccion
		$this->f_Transaccion->ViewValue = $this->f_Transaccion->CurrentValue;
		$this->f_Transaccion->ViewValue = ew_FormatDateTime($this->f_Transaccion->ViewValue, 11);
		$this->f_Transaccion->ViewCustomAttributes = "";

		// c_IDestino
		$this->c_IDestino->ViewValue = $this->c_IDestino->CurrentValue;
		$this->c_IDestino->ViewCustomAttributes = "";

		// cl_Accion
		if (strval($this->cl_Accion->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->cl_Accion->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_CLASE_ACCION'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->cl_Accion, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->cl_Accion->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->cl_Accion->ViewValue = $this->cl_Accion->CurrentValue;
			}
		} else {
			$this->cl_Accion->ViewValue = NULL;
		}
		$this->cl_Accion->ViewCustomAttributes = "";

		// t_Accion
		if (strval($this->t_Accion->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Accion->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_ACCION_PLAT'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->t_Accion, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->t_Accion->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->t_Accion->ViewValue = $this->t_Accion->CurrentValue;
			}
		} else {
			$this->t_Accion->ViewValue = NULL;
		}
		$this->t_Accion->ViewCustomAttributes = "";

		// nv_Accion
		if (strval($this->nv_Accion->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->nv_Accion->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_NIVEL_ACCION'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->nv_Accion, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->nv_Accion->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->nv_Accion->ViewValue = $this->nv_Accion->CurrentValue;
			}
		} else {
			$this->nv_Accion->ViewValue = NULL;
		}
		$this->nv_Accion->ViewCustomAttributes = "";

		// q_Min_Destino
		$this->q_Min_Destino->ViewValue = $this->q_Min_Destino->CurrentValue;
		$this->q_Min_Destino->ViewCustomAttributes = "";

		// c_IChequeo
		$this->c_IChequeo->ViewValue = $this->c_IChequeo->CurrentValue;
		$this->c_IChequeo->ViewCustomAttributes = "";

		// c_IReseller
		$this->c_IReseller->ViewValue = $this->c_IReseller->CurrentValue;
		$this->c_IReseller->ViewCustomAttributes = "";

		// c_ICClass
		$this->c_ICClass->ViewValue = $this->c_ICClass->CurrentValue;
		$this->c_ICClass->ViewCustomAttributes = "";

		// c_ICliente
		$this->c_ICliente->ViewValue = $this->c_ICliente->CurrentValue;
		$this->c_ICliente->ViewCustomAttributes = "";

		// c_ICuenta
		$this->c_ICuenta->ViewValue = $this->c_ICuenta->CurrentValue;
		$this->c_ICuenta->ViewCustomAttributes = "";

		// c_ITransaccion
		$this->c_ITransaccion->LinkCustomAttributes = "";
		$this->c_ITransaccion->HrefValue = "";
		$this->c_ITransaccion->TooltipValue = "";

		// f_Transaccion
		$this->f_Transaccion->LinkCustomAttributes = "";
		$this->f_Transaccion->HrefValue = "";
		$this->f_Transaccion->TooltipValue = "";

		// c_IDestino
		$this->c_IDestino->LinkCustomAttributes = "";
		$this->c_IDestino->HrefValue = "";
		$this->c_IDestino->TooltipValue = "";

		// cl_Accion
		$this->cl_Accion->LinkCustomAttributes = "";
		$this->cl_Accion->HrefValue = "";
		$this->cl_Accion->TooltipValue = "";

		// t_Accion
		$this->t_Accion->LinkCustomAttributes = "";
		$this->t_Accion->HrefValue = "";
		$this->t_Accion->TooltipValue = "";

		// nv_Accion
		$this->nv_Accion->LinkCustomAttributes = "";
		$this->nv_Accion->HrefValue = "";
		$this->nv_Accion->TooltipValue = "";

		// q_Min_Destino
		$this->q_Min_Destino->LinkCustomAttributes = "";
		$this->q_Min_Destino->HrefValue = "";
		$this->q_Min_Destino->TooltipValue = "";

		// c_IChequeo
		$this->c_IChequeo->LinkCustomAttributes = "";
		$this->c_IChequeo->HrefValue = "";
		$this->c_IChequeo->TooltipValue = "";

		// c_IReseller
		$this->c_IReseller->LinkCustomAttributes = "";
		$this->c_IReseller->HrefValue = "";
		$this->c_IReseller->TooltipValue = "";

		// c_ICClass
		$this->c_ICClass->LinkCustomAttributes = "";
		$this->c_ICClass->HrefValue = "";
		$this->c_ICClass->TooltipValue = "";

		// c_ICliente
		$this->c_ICliente->LinkCustomAttributes = "";
		$this->c_ICliente->HrefValue = "";
		$this->c_ICliente->TooltipValue = "";

		// c_ICuenta
		$this->c_ICuenta->LinkCustomAttributes = "";
		$this->c_ICuenta->HrefValue = "";
		$this->c_ICuenta->TooltipValue = "";

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
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->cl_Accion->Exportable) $Doc->ExportCaption($this->cl_Accion);
				if ($this->t_Accion->Exportable) $Doc->ExportCaption($this->t_Accion);
				if ($this->nv_Accion->Exportable) $Doc->ExportCaption($this->nv_Accion);
				if ($this->q_Min_Destino->Exportable) $Doc->ExportCaption($this->q_Min_Destino);
				if ($this->c_IChequeo->Exportable) $Doc->ExportCaption($this->c_IChequeo);
			} else {
				if ($this->c_ITransaccion->Exportable) $Doc->ExportCaption($this->c_ITransaccion);
				if ($this->f_Transaccion->Exportable) $Doc->ExportCaption($this->f_Transaccion);
				if ($this->c_IDestino->Exportable) $Doc->ExportCaption($this->c_IDestino);
				if ($this->cl_Accion->Exportable) $Doc->ExportCaption($this->cl_Accion);
				if ($this->t_Accion->Exportable) $Doc->ExportCaption($this->t_Accion);
				if ($this->nv_Accion->Exportable) $Doc->ExportCaption($this->nv_Accion);
				if ($this->q_Min_Destino->Exportable) $Doc->ExportCaption($this->q_Min_Destino);
				if ($this->c_IChequeo->Exportable) $Doc->ExportCaption($this->c_IChequeo);
				if ($this->c_IReseller->Exportable) $Doc->ExportCaption($this->c_IReseller);
				if ($this->c_ICClass->Exportable) $Doc->ExportCaption($this->c_ICClass);
				if ($this->c_ICliente->Exportable) $Doc->ExportCaption($this->c_ICliente);
				if ($this->c_ICuenta->Exportable) $Doc->ExportCaption($this->c_ICuenta);
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
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->cl_Accion->Exportable) $Doc->ExportField($this->cl_Accion);
					if ($this->t_Accion->Exportable) $Doc->ExportField($this->t_Accion);
					if ($this->nv_Accion->Exportable) $Doc->ExportField($this->nv_Accion);
					if ($this->q_Min_Destino->Exportable) $Doc->ExportField($this->q_Min_Destino);
					if ($this->c_IChequeo->Exportable) $Doc->ExportField($this->c_IChequeo);
				} else {
					if ($this->c_ITransaccion->Exportable) $Doc->ExportField($this->c_ITransaccion);
					if ($this->f_Transaccion->Exportable) $Doc->ExportField($this->f_Transaccion);
					if ($this->c_IDestino->Exportable) $Doc->ExportField($this->c_IDestino);
					if ($this->cl_Accion->Exportable) $Doc->ExportField($this->cl_Accion);
					if ($this->t_Accion->Exportable) $Doc->ExportField($this->t_Accion);
					if ($this->nv_Accion->Exportable) $Doc->ExportField($this->nv_Accion);
					if ($this->q_Min_Destino->Exportable) $Doc->ExportField($this->q_Min_Destino);
					if ($this->c_IChequeo->Exportable) $Doc->ExportField($this->c_IChequeo);
					if ($this->c_IReseller->Exportable) $Doc->ExportField($this->c_IReseller);
					if ($this->c_ICClass->Exportable) $Doc->ExportField($this->c_ICClass);
					if ($this->c_ICliente->Exportable) $Doc->ExportField($this->c_ICliente);
					if ($this->c_ICuenta->Exportable) $Doc->ExportField($this->c_ICuenta);
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
