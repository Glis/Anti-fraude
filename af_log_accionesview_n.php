<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_log_accionesinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$af_log_acciones_view = NULL; // Initialize page object first

class caf_log_acciones_view extends caf_log_acciones {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_log_acciones';

	// Page object name
	var $PageObjName = 'af_log_acciones_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (af_log_acciones)
		if (!isset($GLOBALS["af_log_acciones"]) || get_class($GLOBALS["af_log_acciones"]) == "caf_log_acciones") {
			$GLOBALS["af_log_acciones"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_log_acciones"];
		}
		$KeyUrl = "";
		if (@$_GET["c_ITransaccion"] <> "") {
			$this->RecKey["c_ITransaccion"] = $_GET["c_ITransaccion"];
			$KeyUrl .= "&amp;c_ITransaccion=" . urlencode($this->RecKey["c_ITransaccion"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_log_acciones', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->c_ITransaccion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["c_ITransaccion"] <> "") {
				$this->c_ITransaccion->setQueryStringValue($_GET["c_ITransaccion"]);
				$this->RecKey["c_ITransaccion"] = $this->c_ITransaccion->QueryStringValue;
			} else {
				$sReturnUrl = "af_log_accioneslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "af_log_accioneslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "af_log_accioneslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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
		$this->st_Accion->setDbValue($rs->fields('st_Accion'));
		$this->x_Obs->setDbValue($rs->fields('x_Obs'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_ITransaccion->DbValue = $row['c_ITransaccion'];
		$this->f_Transaccion->DbValue = $row['f_Transaccion'];
		$this->c_IDestino->DbValue = $row['c_IDestino'];
		$this->cl_Accion->DbValue = $row['cl_Accion'];
		$this->t_Accion->DbValue = $row['t_Accion'];
		$this->nv_Accion->DbValue = $row['nv_Accion'];
		$this->q_Min_Destino->DbValue = $row['q_Min_Destino'];
		$this->c_IChequeo->DbValue = $row['c_IChequeo'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->c_ICClass->DbValue = $row['c_ICClass'];
		$this->c_ICliente->DbValue = $row['c_ICliente'];
		$this->c_ICuenta->DbValue = $row['c_ICuenta'];
		$this->st_Accion->DbValue = $row['st_Accion'];
		$this->x_Obs->DbValue = $row['x_Obs'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// c_ITransaccion
		// f_Transaccion
		// c_IDestino
		// cl_Accion
		// t_Accion
		// nv_Accion
		// q_Min_Destino
		// c_IChequeo
		// c_IReseller
		// c_ICClass
		// c_ICliente
		// c_ICuenta
		// st_Accion
		// x_Obs

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// st_Accion
			if (strval($this->st_Accion->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->st_Accion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_ST_ACCION'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->st_Accion, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->st_Accion->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->st_Accion->ViewValue = $this->st_Accion->CurrentValue;
				}
			} else {
				$this->st_Accion->ViewValue = NULL;
			}
			$this->st_Accion->ViewCustomAttributes = "";

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

			// st_Accion
			$this->st_Accion->LinkCustomAttributes = "";
			$this->st_Accion->HrefValue = "";
			$this->st_Accion->TooltipValue = "";

			// x_Obs
			$this->x_Obs->LinkCustomAttributes = "";
			$this->x_Obs->HrefValue = "";
			$this->x_Obs->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_log_accioneslist.php", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, ew_CurrentUrl());
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($af_log_acciones_view)) $af_log_acciones_view = new caf_log_acciones_view();

// Page init
$af_log_acciones_view->Page_Init();

// Page main
$af_log_acciones_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_log_acciones_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var af_log_acciones_view = new ew_Page("af_log_acciones_view");
af_log_acciones_view.PageID = "view"; // Page ID
var EW_PAGE_ID = af_log_acciones_view.PageID; // For backward compatibility

// Form object
var faf_log_accionesview = new ew_Form("faf_log_accionesview");

// Form_CustomValidate event
faf_log_accionesview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_log_accionesview.ValidateRequired = true;
<?php } else { ?>
faf_log_accionesview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_log_accionesview.Lists["x_cl_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_log_accionesview.Lists["x_t_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_log_accionesview.Lists["x_nv_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_log_accionesview.Lists["x_st_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<div class="ewViewExportOptions">
<?php $af_log_acciones_view->ExportOptions->Render("body") ?>
<?php if (!$af_log_acciones_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($af_log_acciones_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php $af_log_acciones_view->ShowPageHeader(); ?>
<?php
$af_log_acciones_view->ShowMessage();
?>
<form name="faf_log_accionesview" id="faf_log_accionesview" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_log_acciones">
<table class="ewGrid"><tr><td>
<table id="tbl_af_log_accionesview" class="table table-bordered table-striped">
<?php if ($af_log_acciones->c_ITransaccion->Visible) { // c_ITransaccion ?>
	<tr id="r_c_ITransaccion">
		<td><span id="elh_af_log_acciones_c_ITransaccion"><?php echo $af_log_acciones->c_ITransaccion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->c_ITransaccion->CellAttributes() ?>>
<span id="el_af_log_acciones_c_ITransaccion" class="control-group">
<span<?php echo $af_log_acciones->c_ITransaccion->ViewAttributes() ?>>
<?php echo $af_log_acciones->c_ITransaccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->f_Transaccion->Visible) { // f_Transaccion ?>
	<tr id="r_f_Transaccion">
		<td><span id="elh_af_log_acciones_f_Transaccion"><?php echo $af_log_acciones->f_Transaccion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->f_Transaccion->CellAttributes() ?>>
<span id="el_af_log_acciones_f_Transaccion" class="control-group">
<span<?php echo $af_log_acciones->f_Transaccion->ViewAttributes() ?>>
<?php echo $af_log_acciones->f_Transaccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->c_IDestino->Visible) { // c_IDestino ?>
	<tr id="r_c_IDestino">
		<td><span id="elh_af_log_acciones_c_IDestino"><?php echo $af_log_acciones->c_IDestino->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->c_IDestino->CellAttributes() ?>>
<span id="el_af_log_acciones_c_IDestino" class="control-group">
<span<?php echo $af_log_acciones->c_IDestino->ViewAttributes() ?>>
<?php echo $af_log_acciones->c_IDestino->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->cl_Accion->Visible) { // cl_Accion ?>
	<tr id="r_cl_Accion">
		<td><span id="elh_af_log_acciones_cl_Accion"><?php echo $af_log_acciones->cl_Accion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->cl_Accion->CellAttributes() ?>>
<span id="el_af_log_acciones_cl_Accion" class="control-group">
<span<?php echo $af_log_acciones->cl_Accion->ViewAttributes() ?>>
<?php echo $af_log_acciones->cl_Accion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->t_Accion->Visible) { // t_Accion ?>
	<tr id="r_t_Accion">
		<td><span id="elh_af_log_acciones_t_Accion"><?php echo $af_log_acciones->t_Accion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->t_Accion->CellAttributes() ?>>
<span id="el_af_log_acciones_t_Accion" class="control-group">
<span<?php echo $af_log_acciones->t_Accion->ViewAttributes() ?>>
<?php echo $af_log_acciones->t_Accion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->nv_Accion->Visible) { // nv_Accion ?>
	<tr id="r_nv_Accion">
		<td><span id="elh_af_log_acciones_nv_Accion"><?php echo $af_log_acciones->nv_Accion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->nv_Accion->CellAttributes() ?>>
<span id="el_af_log_acciones_nv_Accion" class="control-group">
<span<?php echo $af_log_acciones->nv_Accion->ViewAttributes() ?>>
<?php echo $af_log_acciones->nv_Accion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->q_Min_Destino->Visible) { // q_Min_Destino ?>
	<tr id="r_q_Min_Destino">
		<td><span id="elh_af_log_acciones_q_Min_Destino"><?php echo $af_log_acciones->q_Min_Destino->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->q_Min_Destino->CellAttributes() ?>>
<span id="el_af_log_acciones_q_Min_Destino" class="control-group">
<span<?php echo $af_log_acciones->q_Min_Destino->ViewAttributes() ?>>
<?php echo $af_log_acciones->q_Min_Destino->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->c_IChequeo->Visible) { // c_IChequeo ?>
	<tr id="r_c_IChequeo">
		<td><span id="elh_af_log_acciones_c_IChequeo"><?php echo $af_log_acciones->c_IChequeo->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->c_IChequeo->CellAttributes() ?>>
<span id="el_af_log_acciones_c_IChequeo" class="control-group">
<span<?php echo $af_log_acciones->c_IChequeo->ViewAttributes() ?>>
<?php echo $af_log_acciones->c_IChequeo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->st_Accion->Visible) { // st_Accion ?>
	<tr id="r_st_Accion">
		<td><span id="elh_af_log_acciones_st_Accion"><?php echo $af_log_acciones->st_Accion->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->st_Accion->CellAttributes() ?>>
<span id="el_af_log_acciones_st_Accion" class="control-group">
<span<?php echo $af_log_acciones->st_Accion->ViewAttributes() ?>>
<?php echo $af_log_acciones->st_Accion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_acciones->x_Obs->Visible) { // x_Obs ?>
	<tr id="r_x_Obs">
		<td><span id="elh_af_log_acciones_x_Obs"><?php echo $af_log_acciones->x_Obs->FldCaption() ?></span></td>
		<td<?php echo $af_log_acciones->x_Obs->CellAttributes() ?>>
<span id="el_af_log_acciones_x_Obs" class="control-group">
<span<?php echo $af_log_acciones->x_Obs->ViewAttributes() ?>>
<?php echo $af_log_acciones->x_Obs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
faf_log_accionesview.Init();
</script>
<?php
$af_log_acciones_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_log_acciones_view->Page_Terminate();
?>
