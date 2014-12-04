<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_log_envio_repinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$af_log_envio_rep_view = NULL; // Initialize page object first

class caf_log_envio_rep_view extends caf_log_envio_rep {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_log_envio_rep';

	// Page object name
	var $PageObjName = 'af_log_envio_rep_view';

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

		// Table object (af_log_envio_rep)
		if (!isset($GLOBALS["af_log_envio_rep"]) || get_class($GLOBALS["af_log_envio_rep"]) == "caf_log_envio_rep") {
			$GLOBALS["af_log_envio_rep"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_log_envio_rep"];
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
			define("EW_TABLE_NAME", 'af_log_envio_rep', TRUE);

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
				$sReturnUrl = "af_log_envio_replist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "af_log_envio_replist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "af_log_envio_replist.php"; // Not page request, return to list
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
		$this->c_IReporte->setDbValue($rs->fields('c_IReporte'));
		$this->c_IConfig->setDbValue($rs->fields('c_IConfig'));
		$this->st_Envio->setDbValue($rs->fields('st_Envio'));
		$this->x_DirCorreo->setDbValue($rs->fields('x_DirCorreo'));
		$this->x_Obs->setDbValue($rs->fields('x_Obs'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_ITransaccion->DbValue = $row['c_ITransaccion'];
		$this->f_Transaccion->DbValue = $row['f_Transaccion'];
		$this->c_IReporte->DbValue = $row['c_IReporte'];
		$this->c_IConfig->DbValue = $row['c_IConfig'];
		$this->st_Envio->DbValue = $row['st_Envio'];
		$this->x_DirCorreo->DbValue = $row['x_DirCorreo'];
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
		// c_IReporte
		// c_IConfig
		// st_Envio
		// x_DirCorreo
		// x_Obs

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_log_envio_replist.php", $this->TableVar, TRUE);
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
if (!isset($af_log_envio_rep_view)) $af_log_envio_rep_view = new caf_log_envio_rep_view();

// Page init
$af_log_envio_rep_view->Page_Init();

// Page main
$af_log_envio_rep_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_log_envio_rep_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var af_log_envio_rep_view = new ew_Page("af_log_envio_rep_view");
af_log_envio_rep_view.PageID = "view"; // Page ID
var EW_PAGE_ID = af_log_envio_rep_view.PageID; // For backward compatibility

// Form object
var faf_log_envio_repview = new ew_Form("faf_log_envio_repview");

// Form_CustomValidate event
faf_log_envio_repview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_log_envio_repview.ValidateRequired = true;
<?php } else { ?>
faf_log_envio_repview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_log_envio_repview.Lists["x_c_IReporte"] = {"LinkField":"x_c_IReporte","Ajax":null,"AutoFill":false,"DisplayFields":["x_x_NbReporte","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_log_envio_repview.Lists["x_st_Envio"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<div class="ewViewExportOptions">
<?php $af_log_envio_rep_view->ExportOptions->Render("body") ?>
<?php if (!$af_log_envio_rep_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($af_log_envio_rep_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php $af_log_envio_rep_view->ShowPageHeader(); ?>
<?php
$af_log_envio_rep_view->ShowMessage();
?>
<form name="faf_log_envio_repview" id="faf_log_envio_repview" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_log_envio_rep">
<table class="ewGrid"><tr><td>
<table id="tbl_af_log_envio_repview" class="table table-bordered table-striped">
<?php if ($af_log_envio_rep->c_ITransaccion->Visible) { // c_ITransaccion ?>
	<tr id="r_c_ITransaccion">
		<td><span id="elh_af_log_envio_rep_c_ITransaccion"><?php echo $af_log_envio_rep->c_ITransaccion->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->c_ITransaccion->CellAttributes() ?>>
<span id="el_af_log_envio_rep_c_ITransaccion" class="control-group">
<span<?php echo $af_log_envio_rep->c_ITransaccion->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->c_ITransaccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->f_Transaccion->Visible) { // f_Transaccion ?>
	<tr id="r_f_Transaccion">
		<td><span id="elh_af_log_envio_rep_f_Transaccion"><?php echo $af_log_envio_rep->f_Transaccion->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->f_Transaccion->CellAttributes() ?>>
<span id="el_af_log_envio_rep_f_Transaccion" class="control-group">
<span<?php echo $af_log_envio_rep->f_Transaccion->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->f_Transaccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->c_IReporte->Visible) { // c_IReporte ?>
	<tr id="r_c_IReporte">
		<td><span id="elh_af_log_envio_rep_c_IReporte"><?php echo $af_log_envio_rep->c_IReporte->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->c_IReporte->CellAttributes() ?>>
<span id="el_af_log_envio_rep_c_IReporte" class="control-group">
<span<?php echo $af_log_envio_rep->c_IReporte->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->c_IReporte->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->c_IConfig->Visible) { // c_IConfig ?>
	<tr id="r_c_IConfig">
		<td><span id="elh_af_log_envio_rep_c_IConfig"><?php echo $af_log_envio_rep->c_IConfig->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->c_IConfig->CellAttributes() ?>>
<span id="el_af_log_envio_rep_c_IConfig" class="control-group">
<span<?php echo $af_log_envio_rep->c_IConfig->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->c_IConfig->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->st_Envio->Visible) { // st_Envio ?>
	<tr id="r_st_Envio">
		<td><span id="elh_af_log_envio_rep_st_Envio"><?php echo $af_log_envio_rep->st_Envio->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->st_Envio->CellAttributes() ?>>
<span id="el_af_log_envio_rep_st_Envio" class="control-group">
<span<?php echo $af_log_envio_rep->st_Envio->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->st_Envio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->x_DirCorreo->Visible) { // x_DirCorreo ?>
	<tr id="r_x_DirCorreo">
		<td><span id="elh_af_log_envio_rep_x_DirCorreo"><?php echo $af_log_envio_rep->x_DirCorreo->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->x_DirCorreo->CellAttributes() ?>>
<span id="el_af_log_envio_rep_x_DirCorreo" class="control-group">
<span<?php echo $af_log_envio_rep->x_DirCorreo->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->x_DirCorreo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_log_envio_rep->x_Obs->Visible) { // x_Obs ?>
	<tr id="r_x_Obs">
		<td><span id="elh_af_log_envio_rep_x_Obs"><?php echo $af_log_envio_rep->x_Obs->FldCaption() ?></span></td>
		<td<?php echo $af_log_envio_rep->x_Obs->CellAttributes() ?>>
<span id="el_af_log_envio_rep_x_Obs" class="control-group">
<span<?php echo $af_log_envio_rep->x_Obs->ViewAttributes() ?>>
<?php echo $af_log_envio_rep->x_Obs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
faf_log_envio_repview.Init();
</script>
<?php
$af_log_envio_rep_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_log_envio_rep_view->Page_Terminate();
?>
