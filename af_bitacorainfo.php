<?php

// Global variable for table object
$af_bitacora = NULL;

//
// Table class for af_bitacora
//
class caf_bitacora extends cTable {
	var $c_IEjecucion;
	var $t_proc;
	var $st_Bitacora;
	var $f_Inicio;
	var $f_Fin;
	var $c_Usuario;
	var $x_Obs;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'af_bitacora';
		$this->TableName = 'af_bitacora';
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

		// c_IEjecucion
		$this->c_IEjecucion = new cField('af_bitacora', 'af_bitacora', 'x_c_IEjecucion', 'c_IEjecucion', '`c_IEjecucion`', '`c_IEjecucion`', 200, -1, FALSE, '`c_IEjecucion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_IEjecucion'] = &$this->c_IEjecucion;

		// t_proc
		$this->t_proc = new cField('af_bitacora', 'af_bitacora', 'x_t_proc', 't_proc', '`t_proc`', '`t_proc`', 3, -1, FALSE, '`t_proc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->t_proc->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['t_proc'] = &$this->t_proc;

		// st_Bitacora
		$this->st_Bitacora = new cField('af_bitacora', 'af_bitacora', 'x_st_Bitacora', 'st_Bitacora', '`st_Bitacora`', '`st_Bitacora`', 3, -1, FALSE, '`st_Bitacora`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->st_Bitacora->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['st_Bitacora'] = &$this->st_Bitacora;

		// f_Inicio
		$this->f_Inicio = new cField('af_bitacora', 'af_bitacora', 'x_f_Inicio', 'f_Inicio', '`f_Inicio`', '`f_Inicio`', 200, -1, FALSE, '`f_Inicio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Inicio'] = &$this->f_Inicio;

		// f_Fin
		$this->f_Fin = new cField('af_bitacora', 'af_bitacora', 'x_f_Fin', 'f_Fin', '`f_Fin`', '`f_Fin`', 200, -1, FALSE, '`f_Fin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['f_Fin'] = &$this->f_Fin;

		// c_Usuario
		$this->c_Usuario = new cField('af_bitacora', 'af_bitacora', 'x_c_Usuario', 'c_Usuario', '`c_Usuario`', '`c_Usuario`', 200, -1, FALSE, '`c_Usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['c_Usuario'] = &$this->c_Usuario;

		// x_Obs
		$this->x_Obs = new cField('af_bitacora', 'af_bitacora', 'x_x_Obs', 'x_Obs', '`x_Obs`', '`x_Obs`', 201, -1, FALSE, '`x_Obs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		return "`af_bitacora`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		
		if(!isset($_SESSION['preserve_filter']) && !isset($_GET['start'])){
			// echo "Los Filtros fueron VACIADOS\n";
			$_SESSION['filtros_bit']['desde']=""; 
			$_SESSION['filtros_bit']['hasta']=""; 
  			$_SESSION['filtros_bit']['proceso']=""; 
  			$_SESSION['filtros_bit']['status']=""; 
  			$_SESSION['filtros_bit']['cheq']=""; 

		}else{
				// echo "Los Filtros fueron PRESERVADOS\n";
				$_SESSION['preserve_filter'] = false;
		}


		$where = "";
		if($_SESSION['filtros_bit']['desde'] == "" && $_SESSION['filtros_bit']['hasta'] == "" && $_SESSION['filtros_bit']['proceso'] == "" &&
			$_SESSION['filtros_bit']['status'] == "" && $_SESSION['filtros_bit']['cheq'] == ""){

			$sWhere = "";
			$this->TableFilter = "";
			ew_AddFilter($sWhere, $this->TableFilter);
			return $sWhere;
		}else{

			if(($_SESSION['filtros_bit']['desde'] != "") && ($_SESSION['filtros_bit']['hasta'] != "")){
				$where = $this->SqlFrom() . ".`f_Inicio` BETWEEN '" . $_SESSION['filtros_bit']['desde'] . "' AND '" . $_SESSION['filtros_bit']['hasta'] . "' AND " . $this->SqlFrom() . ".`f_Fin` BETWEEN '" . $_SESSION['filtros_bit']['desde'] . "' AND '". $_SESSION['filtros_bit']['hasta'] . "'";
			}else{
				if ($_SESSION['filtros_bit']['desde'] != ""){
					$where = $this->SqlFrom() . ".`f_Inicio` = '" . $_SESSION['filtros_bit']['desde'] . "'";
				}else{
					if ($_SESSION['filtros_bit']['hasta'] != "") {
						$where = $this->SqlFrom() . ".`f_Fin` = '" . $_SESSION['filtros_bit']['desde'] . "'";
					}
				}
			}

			if($_SESSION['filtros_bit']['proceso'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`t_proc`=" . $_SESSION['filtros_bit']['proceso'];					
				}else{
					$where = $this->SqlFrom() . ".`t_proc`=" . $_SESSION['filtros_bit']['proceso'];
				}
			}

			if($_SESSION['filtros_bit']['status'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`st_Bitacora`=" . $_SESSION['filtros_bit']['status'];					
				}else{
					$where = $this->SqlFrom() . ".`st_Bitacora`=" . $_SESSION['filtros_bit']['status'];
				}
			}


			if($_SESSION['filtros_bit']['cheq'] != ""){
				if($where != ""){
					$where .= " AND " . $this->SqlFrom() . ".`c_IEjecucion`=" . $_SESSION['filtros_bit']['cheq'];					
				}else{
					$where = $this->SqlFrom() . ".`c_IEjecucion`=" . $_SESSION['filtros_bit']['cheq'];
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
	var $UpdateTable = "`af_bitacora`";

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
			if (array_key_exists('c_IEjecucion', $rs))
				ew_AddFilter($where, ew_QuotedName('c_IEjecucion') . '=' . ew_QuotedValue($rs['c_IEjecucion'], $this->c_IEjecucion->FldDataType));
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
		return "`c_IEjecucion` = '@c_IEjecucion@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@c_IEjecucion@", ew_AdjustSql($this->c_IEjecucion->CurrentValue), $sKeyFilter); // Replace key value
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
			return "af_bitacoralist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "af_bitacoralist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("af_bitacoraview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("af_bitacoraview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "af_bitacoraadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("af_bitacoraedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("af_bitacoraadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("af_bitacoradelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->c_IEjecucion->CurrentValue)) {
			$sUrl .= "c_IEjecucion=" . urlencode($this->c_IEjecucion->CurrentValue);
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
			$arKeys[] = @$_GET["c_IEjecucion"]; // c_IEjecucion

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
			$this->c_IEjecucion->CurrentValue = $key;
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
		$this->c_IEjecucion->setDbValue($rs->fields('c_IEjecucion'));
		$this->t_proc->setDbValue($rs->fields('t_proc'));
		$this->st_Bitacora->setDbValue($rs->fields('st_Bitacora'));
		$this->f_Inicio->setDbValue($rs->fields('f_Inicio'));
		$this->f_Fin->setDbValue($rs->fields('f_Fin'));
		$this->c_Usuario->setDbValue($rs->fields('c_Usuario'));
		$this->x_Obs->setDbValue($rs->fields('x_Obs'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// c_IEjecucion
		// t_proc
		// st_Bitacora
		// f_Inicio
		// f_Fin
		// c_Usuario
		// x_Obs
		// c_IEjecucion

		$this->c_IEjecucion->ViewValue = $this->c_IEjecucion->CurrentValue;
		$this->c_IEjecucion->ViewCustomAttributes = "";

		// t_proc
		$this->t_proc->ViewValue = $this->t_proc->CurrentValue;
		$this->t_proc->ViewCustomAttributes = "";

		// st_Bitacora
		$this->st_Bitacora->ViewValue = $this->st_Bitacora->CurrentValue;
		$this->st_Bitacora->ViewCustomAttributes = "";

		// f_Inicio
		$this->f_Inicio->ViewValue = $this->f_Inicio->CurrentValue;
		$this->f_Inicio->ViewCustomAttributes = "";

		// f_Fin
		$this->f_Fin->ViewValue = $this->f_Fin->CurrentValue;
		$this->f_Fin->ViewCustomAttributes = "";

		// c_Usuario
		$this->c_Usuario->ViewValue = $this->c_Usuario->CurrentValue;
		$this->c_Usuario->ViewCustomAttributes = "";

		// x_Obs
		$this->x_Obs->ViewValue = $this->x_Obs->CurrentValue;
		$this->x_Obs->ViewCustomAttributes = "";

		// c_IEjecucion
		$this->c_IEjecucion->LinkCustomAttributes = "";
		$this->c_IEjecucion->HrefValue = "";
		$this->c_IEjecucion->TooltipValue = "";

		// t_proc
		$this->t_proc->LinkCustomAttributes = "";
		$this->t_proc->HrefValue = "";
		$this->t_proc->TooltipValue = "";

		// st_Bitacora
		$this->st_Bitacora->LinkCustomAttributes = "";
		$this->st_Bitacora->HrefValue = "";
		$this->st_Bitacora->TooltipValue = "";

		// f_Inicio
		$this->f_Inicio->LinkCustomAttributes = "";
		$this->f_Inicio->HrefValue = "";
		$this->f_Inicio->TooltipValue = "";

		// f_Fin
		$this->f_Fin->LinkCustomAttributes = "";
		$this->f_Fin->HrefValue = "";
		$this->f_Fin->TooltipValue = "";

		// c_Usuario
		$this->c_Usuario->LinkCustomAttributes = "";
		$this->c_Usuario->HrefValue = "";
		$this->c_Usuario->TooltipValue = "";

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
			} else {
				if ($this->c_IEjecucion->Exportable) $Doc->ExportCaption($this->c_IEjecucion);
				if ($this->t_proc->Exportable) $Doc->ExportCaption($this->t_proc);
				if ($this->st_Bitacora->Exportable) $Doc->ExportCaption($this->st_Bitacora);
				if ($this->f_Inicio->Exportable) $Doc->ExportCaption($this->f_Inicio);
				if ($this->f_Fin->Exportable) $Doc->ExportCaption($this->f_Fin);
				if ($this->c_Usuario->Exportable) $Doc->ExportCaption($this->c_Usuario);
				if ($this->x_Obs->Exportable) $Doc->ExportCaption($this->x_Obs);
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
				} else {
					if ($this->c_IEjecucion->Exportable) $Doc->ExportField($this->c_IEjecucion);
					if ($this->t_proc->Exportable) $Doc->ExportField($this->t_proc);
					if ($this->st_Bitacora->Exportable) $Doc->ExportField($this->st_Bitacora);
					if ($this->f_Inicio->Exportable) $Doc->ExportField($this->f_Inicio);
					if ($this->f_Fin->Exportable) $Doc->ExportField($this->f_Fin);
					if ($this->c_Usuario->Exportable) $Doc->ExportField($this->c_Usuario);
					if ($this->x_Obs->Exportable) $Doc->ExportField($this->x_Obs);
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
