<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_configinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$af_config_list = NULL; // Initialize page object first

class caf_config_list extends caf_config {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_config';

	// Page object name
	var $PageObjName = 'af_config_list';

	// Grid form hidden field names
	var $FormName = 'faf_configlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (af_config)
		if (!isset($GLOBALS["af_config"]) || get_class($GLOBALS["af_config"]) == "caf_config") {
			$GLOBALS["af_config"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_config"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "af_configadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "af_configdelete.php";
		$this->MultiUpdateUrl = "af_configupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_config', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->f_Ult_Mod->Visible = !$this->IsAddOrEdit();
		$this->c_Usuario_Ult_Mod->Visible = !$this->IsAddOrEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;

		// Update url if printer friendly for Pdf
		if ($this->PrinterFriendlyForPdf)
			$this->ExportOptions->Items["pdf"]->Body = str_replace($this->ExportPdfUrl, $this->ExportPrintUrl . "&pdf=1", $this->ExportOptions->Items["pdf"]->Body);
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();
		if ($this->Export == "print" && @$_GET["pdf"] == "1") { // Printer friendly version and with pdf=1 in URL parameters
			$pdf = new cExportPdf($GLOBALS["Table"]);
			$pdf->Text = ob_get_contents(); // Set the content as the HTML of current page (printer friendly version)
			ob_end_clean();
			$pdf->Export();
		}

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 15;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 15; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->q_Min_Chequeo, $bCtrl); // q_Min_Chequeo
			$this->UpdateSort($this->q_Min_VentChequeo, $bCtrl); // q_Min_VentChequeo
			$this->UpdateSort($this->f_Ult_Chequeo, $bCtrl); // f_Ult_Chequeo
			$this->UpdateSort($this->x_Usuario_Api, $bCtrl); // x_Usuario_Api
			$this->UpdateSort($this->x_Passw_Api, $bCtrl); // x_Passw_Api
			$this->UpdateSort($this->x_Url_Wsdl, $bCtrl); // x_Url_Wsdl
			$this->UpdateSort($this->f_Ult_Mod, $bCtrl); // f_Ult_Mod
			$this->UpdateSort($this->c_Usuario_Ult_Mod, $bCtrl); // c_Usuario_Ult_Mod
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->q_Min_Chequeo->setSort("");
				$this->q_Min_VentChequeo->setSort("");
				$this->f_Ult_Chequeo->setSort("");
				$this->x_Usuario_Api->setSort("");
				$this->x_Passw_Api->setSort("");
				$this->x_Url_Wsdl->setSort("");
				$this->f_Ult_Mod->setSort("");
				$this->c_Usuario_Ult_Mod->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.faf_configlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->q_Min_Chequeo->setDbValue($rs->fields('q_Min_Chequeo'));
		$this->q_Min_VentChequeo->setDbValue($rs->fields('q_Min_VentChequeo'));
		$this->f_Ult_Chequeo->setDbValue($rs->fields('f_Ult_Chequeo'));
		$this->x_Usuario_Api->setDbValue($rs->fields('x_Usuario_Api'));
		$this->x_Passw_Api->setDbValue($rs->fields('x_Passw_Api'));
		$this->x_Url_Wsdl->setDbValue($rs->fields('x_Url_Wsdl'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->q_Min_Chequeo->DbValue = $row['q_Min_Chequeo'];
		$this->q_Min_VentChequeo->DbValue = $row['q_Min_VentChequeo'];
		$this->f_Ult_Chequeo->DbValue = $row['f_Ult_Chequeo'];
		$this->x_Usuario_Api->DbValue = $row['x_Usuario_Api'];
		$this->x_Passw_Api->DbValue = $row['x_Passw_Api'];
		$this->x_Url_Wsdl->DbValue = $row['x_Url_Wsdl'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// q_Min_Chequeo
		// q_Min_VentChequeo
		// f_Ult_Chequeo
		// x_Usuario_Api
		// x_Passw_Api
		// x_Url_Wsdl
		// f_Ult_Mod
		// c_Usuario_Ult_Mod

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 7);
			$this->f_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
			$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_af_config\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_af_config',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.faf_configlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		$ExportDoc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, $this->TableVar, TRUE);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($af_config_list)) $af_config_list = new caf_config_list();

// Page init
$af_config_list->Page_Init();

// Page main
$af_config_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_config_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($af_config->Export == "") { ?>
<script type="text/javascript">

// Page object
var af_config_list = new ew_Page("af_config_list");
af_config_list.PageID = "list"; // Page ID
var EW_PAGE_ID = af_config_list.PageID; // For backward compatibility

// Form object
var faf_configlist = new ew_Form("faf_configlist");
faf_configlist.FormKeyCountName = '<?php echo $af_config_list->FormKeyCountName ?>';

// Form_CustomValidate event
faf_configlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_configlist.ValidateRequired = true;
<?php } else { ?>
faf_configlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($af_config->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($af_config_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $af_config_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$af_config_list->TotalRecs = $af_config->SelectRecordCount();
	} else {
		if ($af_config_list->Recordset = $af_config_list->LoadRecordset())
			$af_config_list->TotalRecs = $af_config_list->Recordset->RecordCount();
	}
	$af_config_list->StartRec = 1;
	if ($af_config_list->DisplayRecs <= 0 || ($af_config->Export <> "" && $af_config->ExportAll)) // Display all records
		$af_config_list->DisplayRecs = $af_config_list->TotalRecs;
	if (!($af_config->Export <> "" && $af_config->ExportAll))
		$af_config_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$af_config_list->Recordset = $af_config_list->LoadRecordset($af_config_list->StartRec-1, $af_config_list->DisplayRecs);
$af_config_list->RenderOtherOptions();
?>
<?php $af_config_list->ShowPageHeader(); ?>
<?php
$af_config_list->ShowMessage();
?>
<table class="ewGrid"><tr><td class="ewGridContent">
<form name="faf_configlist" id="faf_configlist" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_config">
<div id="gmp_af_config" class="ewGridMiddlePanel">
<?php if ($af_config_list->TotalRecs > 0) { ?>
<table id="tbl_af_configlist" class="ewTable ewTableSeparate">
<?php echo $af_config->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$af_config_list->RenderListOptions();

// Render list options (header, left)
$af_config_list->ListOptions->Render("header", "left");
?>
<?php if ($af_config->q_Min_Chequeo->Visible) { // q_Min_Chequeo ?>
	<?php if ($af_config->SortUrl($af_config->q_Min_Chequeo) == "") { ?>
		<td><div id="elh_af_config_q_Min_Chequeo" class="af_config_q_Min_Chequeo"><div class="ewTableHeaderCaption"><?php echo $af_config->q_Min_Chequeo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->q_Min_Chequeo) ?>',2);"><div id="elh_af_config_q_Min_Chequeo" class="af_config_q_Min_Chequeo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->q_Min_Chequeo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->q_Min_Chequeo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->q_Min_Chequeo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->q_Min_VentChequeo->Visible) { // q_Min_VentChequeo ?>
	<?php if ($af_config->SortUrl($af_config->q_Min_VentChequeo) == "") { ?>
		<td><div id="elh_af_config_q_Min_VentChequeo" class="af_config_q_Min_VentChequeo"><div class="ewTableHeaderCaption"><?php echo $af_config->q_Min_VentChequeo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->q_Min_VentChequeo) ?>',2);"><div id="elh_af_config_q_Min_VentChequeo" class="af_config_q_Min_VentChequeo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->q_Min_VentChequeo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->q_Min_VentChequeo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->q_Min_VentChequeo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->f_Ult_Chequeo->Visible) { // f_Ult_Chequeo ?>
	<?php if ($af_config->SortUrl($af_config->f_Ult_Chequeo) == "") { ?>
		<td><div id="elh_af_config_f_Ult_Chequeo" class="af_config_f_Ult_Chequeo"><div class="ewTableHeaderCaption"><?php echo $af_config->f_Ult_Chequeo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->f_Ult_Chequeo) ?>',2);"><div id="elh_af_config_f_Ult_Chequeo" class="af_config_f_Ult_Chequeo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->f_Ult_Chequeo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->f_Ult_Chequeo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->f_Ult_Chequeo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->x_Usuario_Api->Visible) { // x_Usuario_Api ?>
	<?php if ($af_config->SortUrl($af_config->x_Usuario_Api) == "") { ?>
		<td><div id="elh_af_config_x_Usuario_Api" class="af_config_x_Usuario_Api"><div class="ewTableHeaderCaption"><?php echo $af_config->x_Usuario_Api->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->x_Usuario_Api) ?>',2);"><div id="elh_af_config_x_Usuario_Api" class="af_config_x_Usuario_Api">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->x_Usuario_Api->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->x_Usuario_Api->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->x_Usuario_Api->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->x_Passw_Api->Visible) { // x_Passw_Api ?>
	<?php if ($af_config->SortUrl($af_config->x_Passw_Api) == "") { ?>
		<td><div id="elh_af_config_x_Passw_Api" class="af_config_x_Passw_Api"><div class="ewTableHeaderCaption"><?php echo $af_config->x_Passw_Api->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->x_Passw_Api) ?>',2);"><div id="elh_af_config_x_Passw_Api" class="af_config_x_Passw_Api">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->x_Passw_Api->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->x_Passw_Api->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->x_Passw_Api->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->x_Url_Wsdl->Visible) { // x_Url_Wsdl ?>
	<?php if ($af_config->SortUrl($af_config->x_Url_Wsdl) == "") { ?>
		<td><div id="elh_af_config_x_Url_Wsdl" class="af_config_x_Url_Wsdl"><div class="ewTableHeaderCaption"><?php echo $af_config->x_Url_Wsdl->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->x_Url_Wsdl) ?>',2);"><div id="elh_af_config_x_Url_Wsdl" class="af_config_x_Url_Wsdl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->x_Url_Wsdl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->x_Url_Wsdl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->x_Url_Wsdl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
	<?php if ($af_config->SortUrl($af_config->f_Ult_Mod) == "") { ?>
		<td><div id="elh_af_config_f_Ult_Mod" class="af_config_f_Ult_Mod"><div class="ewTableHeaderCaption"><?php echo $af_config->f_Ult_Mod->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->f_Ult_Mod) ?>',2);"><div id="elh_af_config_f_Ult_Mod" class="af_config_f_Ult_Mod">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->f_Ult_Mod->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->f_Ult_Mod->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->f_Ult_Mod->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_config->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
	<?php if ($af_config->SortUrl($af_config->c_Usuario_Ult_Mod) == "") { ?>
		<td><div id="elh_af_config_c_Usuario_Ult_Mod" class="af_config_c_Usuario_Ult_Mod"><div class="ewTableHeaderCaption"><?php echo $af_config->c_Usuario_Ult_Mod->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_config->SortUrl($af_config->c_Usuario_Ult_Mod) ?>',2);"><div id="elh_af_config_c_Usuario_Ult_Mod" class="af_config_c_Usuario_Ult_Mod">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_config->c_Usuario_Ult_Mod->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_config->c_Usuario_Ult_Mod->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_config->c_Usuario_Ult_Mod->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$af_config_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($af_config->ExportAll && $af_config->Export <> "") {
	$af_config_list->StopRec = $af_config_list->TotalRecs;
} else {

	// Set the last record to display
	if ($af_config_list->TotalRecs > $af_config_list->StartRec + $af_config_list->DisplayRecs - 1)
		$af_config_list->StopRec = $af_config_list->StartRec + $af_config_list->DisplayRecs - 1;
	else
		$af_config_list->StopRec = $af_config_list->TotalRecs;
}
$af_config_list->RecCnt = $af_config_list->StartRec - 1;
if ($af_config_list->Recordset && !$af_config_list->Recordset->EOF) {
	$af_config_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $af_config_list->StartRec > 1)
		$af_config_list->Recordset->Move($af_config_list->StartRec - 1);
} elseif (!$af_config->AllowAddDeleteRow && $af_config_list->StopRec == 0) {
	$af_config_list->StopRec = $af_config->GridAddRowCount;
}

// Initialize aggregate
$af_config->RowType = EW_ROWTYPE_AGGREGATEINIT;
$af_config->ResetAttrs();
$af_config_list->RenderRow();
while ($af_config_list->RecCnt < $af_config_list->StopRec) {
	$af_config_list->RecCnt++;
	if (intval($af_config_list->RecCnt) >= intval($af_config_list->StartRec)) {
		$af_config_list->RowCnt++;

		// Set up key count
		$af_config_list->KeyCount = $af_config_list->RowIndex;

		// Init row class and style
		$af_config->ResetAttrs();
		$af_config->CssClass = "";
		if ($af_config->CurrentAction == "gridadd") {
		} else {
			$af_config_list->LoadRowValues($af_config_list->Recordset); // Load row values
		}
		$af_config->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$af_config->RowAttrs = array_merge($af_config->RowAttrs, array('data-rowindex'=>$af_config_list->RowCnt, 'id'=>'r' . $af_config_list->RowCnt . '_af_config', 'data-rowtype'=>$af_config->RowType));

		// Render row
		$af_config_list->RenderRow();

		// Render list options
		$af_config_list->RenderListOptions();
?>
	<tr<?php echo $af_config->RowAttributes() ?>>
<?php

// Render list options (body, left)
$af_config_list->ListOptions->Render("body", "left", $af_config_list->RowCnt);
?>
	<?php if ($af_config->q_Min_Chequeo->Visible) { // q_Min_Chequeo ?>
		<td<?php echo $af_config->q_Min_Chequeo->CellAttributes() ?>>
<span<?php echo $af_config->q_Min_Chequeo->ViewAttributes() ?>>
<?php echo $af_config->q_Min_Chequeo->ListViewValue() ?></span>
<a id="<?php echo $af_config_list->PageObjName . "_row_" . $af_config_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($af_config->q_Min_VentChequeo->Visible) { // q_Min_VentChequeo ?>
		<td<?php echo $af_config->q_Min_VentChequeo->CellAttributes() ?>>
<span<?php echo $af_config->q_Min_VentChequeo->ViewAttributes() ?>>
<?php echo $af_config->q_Min_VentChequeo->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->f_Ult_Chequeo->Visible) { // f_Ult_Chequeo ?>
		<td<?php echo $af_config->f_Ult_Chequeo->CellAttributes() ?>>
<span<?php echo $af_config->f_Ult_Chequeo->ViewAttributes() ?>>
<?php echo $af_config->f_Ult_Chequeo->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->x_Usuario_Api->Visible) { // x_Usuario_Api ?>
		<td<?php echo $af_config->x_Usuario_Api->CellAttributes() ?>>
<span<?php echo $af_config->x_Usuario_Api->ViewAttributes() ?>>
<?php echo $af_config->x_Usuario_Api->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->x_Passw_Api->Visible) { // x_Passw_Api ?>
		<td<?php echo $af_config->x_Passw_Api->CellAttributes() ?>>
<span<?php echo $af_config->x_Passw_Api->ViewAttributes() ?>>
<?php echo $af_config->x_Passw_Api->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->x_Url_Wsdl->Visible) { // x_Url_Wsdl ?>
		<td<?php echo $af_config->x_Url_Wsdl->CellAttributes() ?>>
<span<?php echo $af_config->x_Url_Wsdl->ViewAttributes() ?>>
<?php echo $af_config->x_Url_Wsdl->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
		<td<?php echo $af_config->f_Ult_Mod->CellAttributes() ?>>
<span<?php echo $af_config->f_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_config->f_Ult_Mod->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_config->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
		<td<?php echo $af_config->c_Usuario_Ult_Mod->CellAttributes() ?>>
<span<?php echo $af_config->c_Usuario_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_config->c_Usuario_Ult_Mod->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$af_config_list->ListOptions->Render("body", "right", $af_config_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($af_config->CurrentAction <> "gridadd")
		$af_config_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($af_config->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($af_config_list->Recordset)
	$af_config_list->Recordset->Close();
?>
<?php if ($af_config->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($af_config->CurrentAction <> "gridadd" && $af_config->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($af_config_list->Pager)) $af_config_list->Pager = new cNumericPager($af_config_list->StartRec, $af_config_list->DisplayRecs, $af_config_list->TotalRecs, $af_config_list->RecRange) ?>
<?php if ($af_config_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($af_config_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $af_config_list->PageUrl() ?>start=<?php echo $af_config_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($af_config_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $af_config_list->PageUrl() ?>start=<?php echo $af_config_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($af_config_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $af_config_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($af_config_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $af_config_list->PageUrl() ?>start=<?php echo $af_config_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($af_config_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $af_config_list->PageUrl() ?>start=<?php echo $af_config_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($af_config_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $af_config_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $af_config_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $af_config_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($af_config_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($af_config_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($af_config->Export == "") { ?>
<script type="text/javascript">
faf_configlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$af_config_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($af_config->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$af_config_list->Page_Terminate();
?>
