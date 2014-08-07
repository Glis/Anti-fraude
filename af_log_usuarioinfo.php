<?php

// Global variable for table object
$af_log_usuario = NULL;

//
// Table class for af_log_usuario
//
class caf_log_usuario extends cTable {
	var $c_ITransaccion;
	var $f_Transaccion;
	var $t_Cambio;
	var $t_Tabla;
	var $t_Campo;
	var $x_IdRegistro;
	var $x_Valor_Ant;
	var $x_Valor_Actual;
	var $c_Usuario;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_log_usuario';
		$this->TableName = 'af_log_usuario';
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
		$this->c_ITransaccion = new cField('af_log_usuario', 'af_log_usuario', 'x_c_ITransaccion', 'c_ITransaccion', '`c_ITransaccion`', '`c_ITransaccion`', 3, -1, FALSE, '`c_ITransaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->c_ITransaccion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['c_ITransaccion'] = &$this->c_ITransaccion;

		// f_Transaccion
		$this->f_Transaccion = new cField('af_log_usuario', 'af_log_usuario', 'x_f_Transaccion', 'f_Transaccion', '`f_Transaccion`', '`f_Transaccion`', 200, 10, FALSE, '`f_Transaccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Transaccion'] = &$this->f_Transaccion;

		// t_Cambio
		$this->t_Cambio = new cField('af_log_usuario', 'af_log_usuario', 'x_t_Cambio', 't_Cambio', '`t_Cambio`', '`t_Cambio`', 3, -1, FALSE, '`t_Cambio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->t_Cambio->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['t_Cambio'] = &$this->t_Cambio;

		// t_Tabla
		$this->t_Tabla = new cField('af_log_usuario', 'af_log_usuario', 'x_t_Tabla', 't_Tabla', '`t_Tabla`', '`t_Tabla`', 3, -1, FALSE, '`t_Tabla`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->t_Tabla->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['t_Tabla'] = &$this->t_Tabla;

		// t_Campo
		$this->t_Campo = new cField('af_log_usuario', 'af_log_usuario', 'x_t_Campo', 't_Campo', '`t_Campo`', '`t_Campo`', 3, -1, FALSE, '`t_Campo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->t_Campo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['t_Campo'] = &$this->t_Campo;

		// x_IdRegistro
		$this->x_IdRegistro = new cField('af_log_usuario', 'af_log_usuario', 'x_x_IdRegistro', 'x_IdRegistro', '`x_IdRegistro`', '`x_IdRegistro`', 200, -1, FALSE, '`x_IdRegistro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_IdRegistro'] = &$this->x_IdRegistro;

		// x_Valor_Ant
		$this->x_Valor_Ant = new cField('af_log_usuario', 'af_log_usuario', 'x_x_Valor_Ant', 'x_Valor_Ant', '`x_Valor_Ant`', '`x_Valor_Ant`', 200, -1, FALSE, '`x_Valor_Ant`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Valor_Ant'] = &$this->x_Valor_Ant;

		// x_Valor_Actual
		$this->x_Valor_Actual = new cField('af_log_usuario', 'af_log_usuario', 'x_x_Valor_Actual', 'x_Valor_Actual', '`x_Valor_Actual`', '`x_Valor_Actual`', 200, -1, FALSE, '`x_Valor_Actual`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['x_Valor_Actual'] = &$this->x_Valor_Actual;

		// c_Usuario
		$this->c_Usuario = new cField('af_log_usuario', 'af_log_usuario', 'x_c_Usuario', 'c_Usuario', '`c_Usuario`', '`c_Usuario`', 200, -1, FALSE, '`c_Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_Usuario'] = &$this->c_Usuario;
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
		return "`af_log_usuario`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where

		$where = "";
		if($_SESSION['filtros_log']['desde'] == "" && $_SESSION['filtros_log']['hasta'] == "" && $_SESSION['filtros_log']['tabla'] == "" &&
			$_SESSION['filtros_log']['campo'] == "" && $_SESSION['filtros_log']['cambio'] == "" && $_SESSION['filtros_log']['usuario'] == ""){

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

			if($_SESSION['filtros_log']['tabla'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`t_Tabla`=" . $_SESSION['filtros_log']['tabla'];					
				}else{
					$where = $this->SqlFrom() . ".`t_Tabla`=" . $_SESSION['filtros_log']['tabla'];
				}
			}

			if($_SESSION['filtros_log']['campo'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`t_Campo`=" . $_SESSION['filtros_log']['campo'];					
				}else{
					$where = $this->SqlFrom() . ".`t_Campo`=" . $_SESSION['filtros_log']['campo'];
				}
			}

			if($_SESSION['filtros_log']['cambio'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`t_Cambio`=" . $_SESSION['filtros_log']['cambio'];					
				}else{
					$where = $this->SqlFrom() . ".`t_Cambio`=" . $_SESSION['filtros_log']['cambio'];
				}
			}

			if($_SESSION['filtros_log']['usuario'] != ""){
				if($where != ""){
					$cant = count($_SESSION['filtros_log']['usuario']);
					$k = 1;
					$where = $this->SqlFrom().".`c_Usuario` IN (";
					while($k <= $cant - 1){
						$where .= " AND " . $_SESSION['filtros_log']['usuario'][$k]['c_Usuario']. ", ";
						$k++;
					}

					$where .= $_SESSION['filtros_log']['usuario'][$k]['c_Usuario'] . ")";
				}else{
					$cant = count($_SESSION['filtros_log']['usuario']);
					$k = 1;
					$where = $this->SqlFrom().".`c_Usuario` IN (";
					while($k <= $cant - 1){
						$where .= $_SESSION['filtros_log']['usuario'][$k]['c_Usuario']. ", ";
						$k++;
					}

					$where .= $_SESSION['filtros_log']['usuario'][$k]['c_Usuario'] . ")";
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
	var $UpdateTable = "`af_log_usuario`";

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
			return "af_log_usuariolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_log_usuariolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_log_usuarioview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_log_usuarioview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_log_usuarioadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_log_usuarioedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_log_usuarioadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_log_usuariodelete.php", $this->UrlParm());
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
		$this->t_Cambio->setDbValue($rs->fields('t_Cambio'));
		$this->t_Tabla->setDbValue($rs->fields('t_Tabla'));
		$this->t_Campo->setDbValue($rs->fields('t_Campo'));
		$this->x_IdRegistro->setDbValue($rs->fields('x_IdRegistro'));
		$this->x_Valor_Ant->setDbValue($rs->fields('x_Valor_Ant'));
		$this->x_Valor_Actual->setDbValue($rs->fields('x_Valor_Actual'));
		$this->c_Usuario->setDbValue($rs->fields('c_Usuario'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_ITransaccion
		// f_Transaccion
		// t_Cambio
		// t_Tabla
		// t_Campo
		// x_IdRegistro
		// x_Valor_Ant
		// x_Valor_Actual
		// c_Usuario
		// c_ITransaccion

		$this->c_ITransaccion->ViewValue = $this->c_ITransaccion->CurrentValue;
		$this->c_ITransaccion->ViewCustomAttributes = "";

		// f_Transaccion
		$this->f_Transaccion->ViewValue = $this->f_Transaccion->CurrentValue;
		$this->f_Transaccion->ViewValue = ew_FormatDateTime($this->f_Transaccion->ViewValue, 10);
		$this->f_Transaccion->ViewCustomAttributes = "";

		// t_Cambio
		if (strval($this->t_Cambio->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Cambio->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_CAMBIO'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->t_Cambio, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->t_Cambio->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->t_Cambio->ViewValue = $this->t_Cambio->CurrentValue;
			}
		} else {
			$this->t_Cambio->ViewValue = NULL;
		}
		$this->t_Cambio->ViewCustomAttributes = "";

		// t_Tabla
		if (strval($this->t_Tabla->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Tabla->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_TABLA'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->t_Tabla, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->t_Tabla->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->t_Tabla->ViewValue = $this->t_Tabla->CurrentValue;
			}
		} else {
			$this->t_Tabla->ViewValue = NULL;
		}
		$this->t_Tabla->ViewCustomAttributes = "";

		// t_Campo
		if (strval($this->t_Campo->CurrentValue) <> "") {
			$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Campo->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
		$sWhereWrk = "";
		$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_CAMPO'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->t_Campo, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->t_Campo->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->t_Campo->ViewValue = $this->t_Campo->CurrentValue;
			}
		} else {
			$this->t_Campo->ViewValue = NULL;
		}
		$this->t_Campo->ViewCustomAttributes = "";

		// x_IdRegistro
		$this->x_IdRegistro->ViewValue = $this->x_IdRegistro->CurrentValue;
		$this->x_IdRegistro->ViewCustomAttributes = "";

		// x_Valor_Ant
		$this->x_Valor_Ant->ViewValue = $this->x_Valor_Ant->CurrentValue;
		$this->x_Valor_Ant->ViewCustomAttributes = "";

		// x_Valor_Actual
		$this->x_Valor_Actual->ViewValue = $this->x_Valor_Actual->CurrentValue;
		$this->x_Valor_Actual->ViewCustomAttributes = "";

		// c_Usuario
		$this->c_Usuario->ViewValue = $this->c_Usuario->CurrentValue;
		$this->c_Usuario->ViewCustomAttributes = "";

		// c_ITransaccion
		$this->c_ITransaccion->LinkCustomAttributes = "";
		$this->c_ITransaccion->HrefValue = "";
		$this->c_ITransaccion->TooltipValue = "";

		// f_Transaccion
		$this->f_Transaccion->LinkCustomAttributes = "";
		$this->f_Transaccion->HrefValue = "";
		$this->f_Transaccion->TooltipValue = "";

		// t_Cambio
		$this->t_Cambio->LinkCustomAttributes = "";
		$this->t_Cambio->HrefValue = "";
		$this->t_Cambio->TooltipValue = "";

		// t_Tabla
		$this->t_Tabla->LinkCustomAttributes = "";
		$this->t_Tabla->HrefValue = "";
		$this->t_Tabla->TooltipValue = "";

		// t_Campo
		$this->t_Campo->LinkCustomAttributes = "";
		$this->t_Campo->HrefValue = "";
		$this->t_Campo->TooltipValue = "";

		// x_IdRegistro
		$this->x_IdRegistro->LinkCustomAttributes = "";
		$this->x_IdRegistro->HrefValue = "";
		$this->x_IdRegistro->TooltipValue = "";

		// x_Valor_Ant
		$this->x_Valor_Ant->LinkCustomAttributes = "";
		$this->x_Valor_Ant->HrefValue = "";
		$this->x_Valor_Ant->TooltipValue = "";

		// x_Valor_Actual
		$this->x_Valor_Actual->LinkCustomAttributes = "";
		$this->x_Valor_Actual->HrefValue = "";
		$this->x_Valor_Actual->TooltipValue = "";

		// c_Usuario
		$this->c_Usuario->LinkCustomAttributes = "";
		$this->c_Usuario->HrefValue = "";
		$this->c_Usuario->TooltipValue = "";

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
				if ($this->t_Cambio->Exportable) $Doc->ExportCaption($this->t_Cambio);
				if ($this->t_Tabla->Exportable) $Doc->ExportCaption($this->t_Tabla);
				if ($this->t_Campo->Exportable) $Doc->ExportCaption($this->t_Campo);
				if ($this->x_IdRegistro->Exportable) $Doc->ExportCaption($this->x_IdRegistro);
				if ($this->x_Valor_Ant->Exportable) $Doc->ExportCaption($this->x_Valor_Ant);
				if ($this->x_Valor_Actual->Exportable) $Doc->ExportCaption($this->x_Valor_Actual);
				if ($this->c_Usuario->Exportable) $Doc->ExportCaption($this->c_Usuario);
			} else {
				if ($this->c_ITransaccion->Exportable) $Doc->ExportCaption($this->c_ITransaccion);
				if ($this->f_Transaccion->Exportable) $Doc->ExportCaption($this->f_Transaccion);
				if ($this->t_Cambio->Exportable) $Doc->ExportCaption($this->t_Cambio);
				if ($this->t_Tabla->Exportable) $Doc->ExportCaption($this->t_Tabla);
				if ($this->t_Campo->Exportable) $Doc->ExportCaption($this->t_Campo);
				if ($this->x_IdRegistro->Exportable) $Doc->ExportCaption($this->x_IdRegistro);
				if ($this->x_Valor_Ant->Exportable) $Doc->ExportCaption($this->x_Valor_Ant);
				if ($this->x_Valor_Actual->Exportable) $Doc->ExportCaption($this->x_Valor_Actual);
				if ($this->c_Usuario->Exportable) $Doc->ExportCaption($this->c_Usuario);
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
					if ($this->t_Cambio->Exportable) $Doc->ExportField($this->t_Cambio);
					if ($this->t_Tabla->Exportable) $Doc->ExportField($this->t_Tabla);
					if ($this->t_Campo->Exportable) $Doc->ExportField($this->t_Campo);
					if ($this->x_IdRegistro->Exportable) $Doc->ExportField($this->x_IdRegistro);
					if ($this->x_Valor_Ant->Exportable) $Doc->ExportField($this->x_Valor_Ant);
					if ($this->x_Valor_Actual->Exportable) $Doc->ExportField($this->x_Valor_Actual);
					if ($this->c_Usuario->Exportable) $Doc->ExportField($this->c_Usuario);
				} else {
					if ($this->c_ITransaccion->Exportable) $Doc->ExportField($this->c_ITransaccion);
					if ($this->f_Transaccion->Exportable) $Doc->ExportField($this->f_Transaccion);
					if ($this->t_Cambio->Exportable) $Doc->ExportField($this->t_Cambio);
					if ($this->t_Tabla->Exportable) $Doc->ExportField($this->t_Tabla);
					if ($this->t_Campo->Exportable) $Doc->ExportField($this->t_Campo);
					if ($this->x_IdRegistro->Exportable) $Doc->ExportField($this->x_IdRegistro);
					if ($this->x_Valor_Ant->Exportable) $Doc->ExportField($this->x_Valor_Ant);
					if ($this->x_Valor_Actual->Exportable) $Doc->ExportField($this->x_Valor_Actual);
					if ($this->c_Usuario->Exportable) $Doc->ExportField($this->c_Usuario);
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
