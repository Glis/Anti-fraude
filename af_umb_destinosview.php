<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_umb_destinosinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD_portaone.php" ?>
<?php include_once "lib/libreriaBD.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
}
//
// Page class
//

$af_umb_destinos_view = NULL; // Initialize page object first

class caf_umb_destinos_view extends caf_umb_destinos {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_umb_destinos';

	// Page object name
	var $PageObjName = 'af_umb_destinos_view';

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

		// Table object (af_umb_destinos)
		if (!isset($GLOBALS["af_umb_destinos"]) || get_class($GLOBALS["af_umb_destinos"]) == "caf_umb_destinos") {
			$GLOBALS["af_umb_destinos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_umb_destinos"];
		}
		$KeyUrl = "";
		if (@$_GET["c_IDestino"] <> "") {
			$this->RecKey["c_IDestino"] = $_GET["c_IDestino"];
			$KeyUrl .= "&amp;c_IDestino=" . urlencode($this->RecKey["c_IDestino"]);
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
			define("EW_TABLE_NAME", 'af_umb_destinos', TRUE);

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
			if (@$_GET["c_IDestino"] <> "") {
				$this->c_IDestino->setQueryStringValue($_GET["c_IDestino"]);
				$this->RecKey["c_IDestino"] = $this->c_IDestino->QueryStringValue;
			} else {
				$sReturnUrl = "af_umb_destinoslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "af_umb_destinoslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "af_umb_destinoslist.php"; // Not page request, return to list
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

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"btn-primary ewAction ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"btn-primary ewAction ewEdit\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"btn-primary ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");

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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_IDestino->DbValue = $row['c_IDestino'];
		$this->q_MinAl_Plataf->DbValue = $row['q_MinAl_Plataf'];
		$this->q_MinCu_Plataf->DbValue = $row['q_MinCu_Plataf'];
		$this->q_MinAl_Res->DbValue = $row['q_MinAl_Res'];
		$this->q_MinCu_Res->DbValue = $row['q_MinCu_Res'];
		$this->q_MinAl_CClas->DbValue = $row['q_MinAl_CClas'];
		$this->q_MinCu_CClas->DbValue = $row['q_MinCu_CClas'];
		$this->q_MinAl_Cli->DbValue = $row['q_MinAl_Cli'];
		$this->q_MinCu_Cli->DbValue = $row['q_MinCu_Cli'];
		$this->q_MinAl_Cta->DbValue = $row['q_MinAl_Cta'];
		$this->q_MinCu_Cta->DbValue = $row['q_MinCu_Cta'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
					$result = select_sql_PO("select_destino_where", array($this->c_IDestino->CurrentValue));
					$this->c_IDestino->ViewValue = $result[1]['destination'];
				} else {
					$this->c_IDestino->ViewValue = $this->c_IDestino->CurrentValue;
					$result = select_sql_PO("select_destino_where", array($this->c_IDestino->CurrentValue));
					$this->c_IDestino->ViewValue = $result[1]['destination'];
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
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 9);
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_umb_destinoslist.php", $this->TableVar, TRUE);
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
if (!isset($af_umb_destinos_view)) $af_umb_destinos_view = new caf_umb_destinos_view();

// Page init
$af_umb_destinos_view->Page_Init();

// Page main
$af_umb_destinos_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_umb_destinos_view->Page_Render();
?>
<?php include_once "header.php" ?>

<?          /**********************SI NO ES USUARIO CONFIG**********************/

if($_SESSION['USUARIO_TYPE']['config']==0){
	echo ("<div class='jumbotron' style='background-color:#fff'>
	<h1>Contenido no disponible...</h1>
	<h3>Disculpe ". $_SESSION['USUARIO'].", no posee los permisos necesarios para ver esta página</h3>	
	</div>"); exit;
}?>


<script type="text/javascript">

// Page object
var af_umb_destinos_view = new ew_Page("af_umb_destinos_view");
af_umb_destinos_view.PageID = "view"; // Page ID
var EW_PAGE_ID = af_umb_destinos_view.PageID; // For backward compatibility

// Form object
var faf_umb_destinosview = new ew_Form("faf_umb_destinosview");

// Form_CustomValidate event
faf_umb_destinosview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_umb_destinosview.ValidateRequired = true;
<?php } else { ?>
faf_umb_destinosview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_umb_destinosview.Lists["x_c_IDestino"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<div id="page_title" style="text-align:center; width:100%" class="ewViewExportOptions"> - Ver
<?php $af_umb_destinos_view->ExportOptions->Render("body") ?>
<?php if (!$af_umb_destinos_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($af_umb_destinos_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php $af_umb_destinos_view->ShowPageHeader(); ?>
<?php
$af_umb_destinos_view->ShowMessage();
?>
<form name="faf_umb_destinosview" id="faf_umb_destinosview" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_umb_destinos">
<table class="ewGrid"><tr><td>
<table id="tbl_af_umb_destinosview" class="table table-bordered table-striped">
<?php if ($af_umb_destinos->c_IDestino->Visible) { // c_IDestino ?>
	<tr id="r_c_IDestino">
		<td><span id="elh_af_umb_destinos_c_IDestino"><?php echo $af_umb_destinos->c_IDestino->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->c_IDestino->CellAttributes() ?>>
<span id="el_af_umb_destinos_c_IDestino" class="control-group">
<span<?php echo $af_umb_destinos->c_IDestino->ViewAttributes() ?>>
<?php echo $af_umb_destinos->c_IDestino->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinAl_Plataf->Visible) { // q_MinAl_Plataf ?>
	<tr id="r_q_MinAl_Plataf">
		<td><span id="elh_af_umb_destinos_q_MinAl_Plataf"><?php echo $af_umb_destinos->q_MinAl_Plataf->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinAl_Plataf->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinAl_Plataf" class="control-group">
<span<?php echo $af_umb_destinos->q_MinAl_Plataf->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinAl_Plataf->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinCu_Plataf->Visible) { // q_MinCu_Plataf ?>
	<tr id="r_q_MinCu_Plataf">
		<td><span id="elh_af_umb_destinos_q_MinCu_Plataf"><?php echo $af_umb_destinos->q_MinCu_Plataf->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinCu_Plataf->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinCu_Plataf" class="control-group">
<span<?php echo $af_umb_destinos->q_MinCu_Plataf->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinCu_Plataf->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinAl_Res->Visible) { // q_MinAl_Res ?>
	<tr id="r_q_MinAl_Res">
		<td><span id="elh_af_umb_destinos_q_MinAl_Res"><?php echo $af_umb_destinos->q_MinAl_Res->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinAl_Res->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinAl_Res" class="control-group">
<span<?php echo $af_umb_destinos->q_MinAl_Res->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinAl_Res->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinCu_Res->Visible) { // q_MinCu_Res ?>
	<tr id="r_q_MinCu_Res">
		<td><span id="elh_af_umb_destinos_q_MinCu_Res"><?php echo $af_umb_destinos->q_MinCu_Res->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinCu_Res->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinCu_Res" class="control-group">
<span<?php echo $af_umb_destinos->q_MinCu_Res->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinCu_Res->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinAl_CClas->Visible) { // q_MinAl_CClas ?>
	<tr id="r_q_MinAl_CClas">
		<td><span id="elh_af_umb_destinos_q_MinAl_CClas"><?php echo $af_umb_destinos->q_MinAl_CClas->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinAl_CClas->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinAl_CClas" class="control-group">
<span<?php echo $af_umb_destinos->q_MinAl_CClas->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinAl_CClas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinCu_CClas->Visible) { // q_MinCu_CClas ?>
	<tr id="r_q_MinCu_CClas">
		<td><span id="elh_af_umb_destinos_q_MinCu_CClas"><?php echo $af_umb_destinos->q_MinCu_CClas->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinCu_CClas->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinCu_CClas" class="control-group">
<span<?php echo $af_umb_destinos->q_MinCu_CClas->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinCu_CClas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinAl_Cli->Visible) { // q_MinAl_Cli ?>
	<tr id="r_q_MinAl_Cli">
		<td><span id="elh_af_umb_destinos_q_MinAl_Cli"><?php echo $af_umb_destinos->q_MinAl_Cli->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinAl_Cli->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinAl_Cli" class="control-group">
<span<?php echo $af_umb_destinos->q_MinAl_Cli->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinAl_Cli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinCu_Cli->Visible) { // q_MinCu_Cli ?>
	<tr id="r_q_MinCu_Cli">
		<td><span id="elh_af_umb_destinos_q_MinCu_Cli"><?php echo $af_umb_destinos->q_MinCu_Cli->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinCu_Cli->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinCu_Cli" class="control-group">
<span<?php echo $af_umb_destinos->q_MinCu_Cli->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinCu_Cli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinAl_Cta->Visible) { // q_MinAl_Cta ?>
	<tr id="r_q_MinAl_Cta">
		<td><span id="elh_af_umb_destinos_q_MinAl_Cta"><?php echo $af_umb_destinos->q_MinAl_Cta->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinAl_Cta->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinAl_Cta" class="control-group">
<span<?php echo $af_umb_destinos->q_MinAl_Cta->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinAl_Cta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->q_MinCu_Cta->Visible) { // q_MinCu_Cta ?>
	<tr id="r_q_MinCu_Cta">
		<td><span id="elh_af_umb_destinos_q_MinCu_Cta"><?php echo $af_umb_destinos->q_MinCu_Cta->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->q_MinCu_Cta->CellAttributes() ?>>
<span id="el_af_umb_destinos_q_MinCu_Cta" class="control-group">
<span<?php echo $af_umb_destinos->q_MinCu_Cta->ViewAttributes() ?>>
<?php echo $af_umb_destinos->q_MinCu_Cta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
	<tr id="r_f_Ult_Mod">
		<td><span id="elh_af_umb_destinos_f_Ult_Mod"><?php echo $af_umb_destinos->f_Ult_Mod->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->f_Ult_Mod->CellAttributes() ?>>
<span id="el_af_umb_destinos_f_Ult_Mod" class="control-group">
<span<?php echo $af_umb_destinos->f_Ult_Mod->ViewAttributes() ?>>

<!-- Mostrar Fecha! -->
<?php $f = select_sql('select_fecha_umb', array('af_umb_destinos', $af_umb_destinos->c_IDestino->CurrentValue))?>
<?php /*echo $af_umb_destinos->f_Ult_Mod->ViewValue */ echo $f[1]['f_Ult_Mod'] ?></span>
<!-- Mostrar Fecha! -->
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_umb_destinos->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
	<tr id="r_c_Usuario_Ult_Mod">
		<td><span id="elh_af_umb_destinos_c_Usuario_Ult_Mod"><?php echo $af_umb_destinos->c_Usuario_Ult_Mod->FldCaption() ?></span></td>
		<td<?php echo $af_umb_destinos->c_Usuario_Ult_Mod->CellAttributes() ?>>
<span id="el_af_umb_destinos_c_Usuario_Ult_Mod" class="control-group">
<span<?php echo $af_umb_destinos->c_Usuario_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_umb_destinos->c_Usuario_Ult_Mod->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
faf_umb_destinosview.Init();
</script>
<?php
$af_umb_destinos_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_umb_destinos_view->Page_Terminate();
?>
