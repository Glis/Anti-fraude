<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_chequeo_det_clientesinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD.php" ?>
<?php include_once "lib/libreriaBD_portaone.php" ?>

<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
} 

function is_On($value){
  return (intval($value) < 2);
}

if($_SESSION['filtro_clientes_bloq'] == ""){ 
  $customers=select_custom_sql("*","af_chequeo_det_clientes","i_Bloqueo=1","f_Bloqueo DESC", ""/*"LIMIT 10"*/);
  $customerCount = count($customers);
}else{ 
  $customers=select_custom_sql("*","af_chequeo_det_clientes","i_Bloqueo=1 AND c_IReseller=" . $_SESSION['filtro_clientes_bloq'],"f_Bloqueo DESC", ""/*"LIMIT 10"*/);
  $customerCount = count($customers);
}

//
// Page class
//

$af_chequeo_det_clientes_list = NULL; // Initialize page object first

class caf_chequeo_det_clientes_list extends caf_chequeo_det_clientes {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_chequeo_det_clientes';

	// Page object name
	var $PageObjName = 'af_chequeo_det_clientes_list';

	// Grid form hidden field names
	var $FormName = 'faf_chequeo_det_clienteslist';
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

		// Table object (af_chequeo_det_clientes)
		if (!isset($GLOBALS["af_chequeo_det_clientes"]) || get_class($GLOBALS["af_chequeo_det_clientes"]) == "caf_chequeo_det_clientes") {
			$GLOBALS["af_chequeo_det_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_chequeo_det_clientes"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "af_chequeo_det_clientesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "af_chequeo_det_clientesdelete.php";
		$this->MultiUpdateUrl = "af_chequeo_det_clientesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_chequeo_det_clientes', TRUE);

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
		if (count($arrKeyFlds) >= 5) {
			$this->c_ICliente->setFormValue($arrKeyFlds[0]);
			$this->c_IDestino->setFormValue($arrKeyFlds[1]);
			$this->c_IChequeo->setFormValue($arrKeyFlds[2]);
			if (!is_numeric($this->c_IChequeo->FormValue))
				return FALSE;
			$this->c_ICClass->setFormValue($arrKeyFlds[3]);
			$this->c_IReseller->setFormValue($arrKeyFlds[4]);
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
			$this->UpdateSort($this->c_ICliente, $bCtrl); // c_ICliente
			$this->UpdateSort($this->c_IDestino, $bCtrl); // c_IDestino
			$this->UpdateSort($this->c_IChequeo, $bCtrl); // c_IChequeo
			$this->UpdateSort($this->f_Bloqueo, $bCtrl); // f_Bloqueo
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
				$this->c_ICliente->setSort("");
				$this->c_IDestino->setSort("");
				$this->c_IChequeo->setSort("");
				$this->f_Bloqueo->setSort("");
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
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->c_ICliente->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->c_IDestino->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->c_IChequeo->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->c_ICClass->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->c_IReseller->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.faf_chequeo_det_clienteslist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_ICliente->DbValue = $row['c_ICliente'];
		$this->c_IDestino->DbValue = $row['c_IDestino'];
		$this->c_IChequeo->DbValue = $row['c_IChequeo'];
		$this->f_Bloqueo->DbValue = $row['f_Bloqueo'];
		$this->c_ICClass->DbValue = $row['c_ICClass'];
		$this->i_Bloqueo->DbValue = $row['i_Bloqueo'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->q_Min_Cliente->DbValue = $row['q_Min_Cliente'];
		$this->f_Desbloqueo->DbValue = $row['f_Desbloqueo'];
		$this->i_Alerta->DbValue = $row['i_Alerta'];
		$this->i_Cuarentena->DbValue = $row['i_Cuarentena'];
		$this->c_Usuario_Desbloqueo->DbValue = $row['c_Usuario_Desbloqueo'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("c_ICliente")) <> "")
			$this->c_ICliente->CurrentValue = $this->getKey("c_ICliente"); // c_ICliente
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_IDestino")) <> "")
			$this->c_IDestino->CurrentValue = $this->getKey("c_IDestino"); // c_IDestino
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_IChequeo")) <> "")
			$this->c_IChequeo->CurrentValue = $this->getKey("c_IChequeo"); // c_IChequeo
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_ICClass")) <> "")
			$this->c_ICClass->CurrentValue = $this->getKey("c_ICClass"); // c_ICClass
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_IReseller")) <> "")
			$this->c_IReseller->CurrentValue = $this->getKey("c_IReseller"); // c_IReseller
		else
			$bValidKey = FALSE;

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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row
			$cusColor = is_On($this->i_Alerta->CurrentValue) ? 'warning' : "";
			$cusColor = is_On( $this->i_Cuarentena->CurrentValue) ? 'danger' : $cusColor;

			// c_ICliente
			$result = select_sql_PO("select_porta_customers_where_class", array($this->c_ICliente->CurrentValue));
			$this->c_ICliente->ViewValue = $result[1]['name'];
			$this->c_ICliente->ViewCustomAttributes = "";
			$this->c_ICliente->CellCssClass = $cusColor;

			// c_IDestino
			$result = select_sql_PO("select_destino_where", array($this->c_IDestino->CurrentValue));
			$this->c_IDestino->ViewValue = $result[1]['destination'];
			$this->c_IDestino->ViewCustomAttributes = "";
			$this->c_IDestino->CellCssClass = $cusColor;

			// c_IChequeo
			$this->c_IChequeo->ViewValue = $this->c_IChequeo->CurrentValue;
			$this->c_IChequeo->ViewCustomAttributes = "";
			$this->c_IChequeo->CellCssClass = $cusColor;

			// f_Bloqueo
			$this->f_Bloqueo->ViewValue = $this->f_Bloqueo->CurrentValue;
			$this->f_Bloqueo->ViewValue = ew_FormatDateTime($this->f_Bloqueo->ViewValue, 9);
			$this->f_Bloqueo->ViewCustomAttributes = "";
			$this->f_Bloqueo->CellCssClass = $cusColor;

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
		$item->Body = "<a id=\"emf_af_chequeo_det_clientes\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_af_chequeo_det_clientes',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.faf_chequeo_det_clienteslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

		$opt = &$this->ListOptions->Add("opciones");
		$opt->Header = "Opciones";
		$opt->CssClass = "col-sm-1";
		// $opt->OnLeft = TRUE; // Link on left
		// $opt->MoveTo(1); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";
		$this->ListOptions->Items["opciones"]->Body = "<span id='desbloqueo_cli' class=".$this->c_ICliente->CurrentValue. "><i title='Desbloquear' class='glyphicon icon-unlock'></i></span>";

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
if (!isset($af_chequeo_det_clientes_list)) $af_chequeo_det_clientes_list = new caf_chequeo_det_clientes_list();

// Page init
$af_chequeo_det_clientes_list->Page_Init();

// Page main
$af_chequeo_det_clientes_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_chequeo_det_clientes_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($af_chequeo_det_clientes->Export == "") { ?>
<script type="text/javascript">

// Page object
var af_chequeo_det_clientes_list = new ew_Page("af_chequeo_det_clientes_list");
af_chequeo_det_clientes_list.PageID = "list"; // Page ID
var EW_PAGE_ID = af_chequeo_det_clientes_list.PageID; // For backward compatibility

// Form object
var faf_chequeo_det_clienteslist = new ew_Form("faf_chequeo_det_clienteslist");
faf_chequeo_det_clienteslist.FormKeyCountName = '<?php echo $af_chequeo_det_clientes_list->FormKeyCountName ?>';

// Form_CustomValidate event
faf_chequeo_det_clienteslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_chequeo_det_clienteslist.ValidateRequired = true;
<?php } else { ?>
faf_chequeo_det_clienteslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($af_chequeo_det_clientes->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($af_chequeo_det_clientes_list->ExportOptions->Visible()) { ?>
<div id="page_title" class="ewListExportOptions"><?php $af_chequeo_det_clientes_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$af_chequeo_det_clientes_list->TotalRecs = $af_chequeo_det_clientes->SelectRecordCount();
	} else {
		if ($af_chequeo_det_clientes_list->Recordset = $af_chequeo_det_clientes_list->LoadRecordset())
			$af_chequeo_det_clientes_list->TotalRecs = $af_chequeo_det_clientes_list->Recordset->RecordCount();
	}
	$af_chequeo_det_clientes_list->StartRec = 1;
	if ($af_chequeo_det_clientes_list->DisplayRecs <= 0 || ($af_chequeo_det_clientes->Export <> "" && $af_chequeo_det_clientes->ExportAll)) // Display all records
		$af_chequeo_det_clientes_list->DisplayRecs = $af_chequeo_det_clientes_list->TotalRecs;
	if (!($af_chequeo_det_clientes->Export <> "" && $af_chequeo_det_clientes->ExportAll))
		$af_chequeo_det_clientes_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$af_chequeo_det_clientes_list->Recordset = $af_chequeo_det_clientes_list->LoadRecordset($af_chequeo_det_clientes_list->StartRec-1, $af_chequeo_det_clientes_list->DisplayRecs);
$af_chequeo_det_clientes_list->RenderOtherOptions();
?>
<?php $af_chequeo_det_clientes_list->ShowPageHeader(); ?>
<?php
$af_chequeo_det_clientes_list->ShowMessage();
?>

							<?/******************************************************
							************************FILTROS**************************
							*********************************************************/?>
<script>
$(document).on('click','#submit_filtros',function(){

      var reseller = $('#resellerName').find("option:selected").val();


      var dataString = "pag=monitor_clientes&filtro=x";
      if (reseller == "vacio"){
        dataString = dataString + "&reseller=vacio";
      }else{
        dataString = dataString + "&reseller=" + reseller;
      }
     
      // alert(dataString);
      $.ajax({  
        type: "POST",  
        url: "lib/functions.php",  
        data: dataString,  
        success: function(html) {  
          // alert(html);
          // location.reload();
          window.location="af_chequeo_det_clienteslist.php?start=1";
        }
      });
});

$(document).on('click','#reset_fil',function(){
		dataString= "pag=clear_filters";
		$.ajax({  
		  type: "POST",  
		  url: "lib/functions.php",  
		  data: dataString,  
		  success: function(html) { 
			window.location="af_chequeo_det_clienteslist.php";
		  }
		});
	});

$(document).ready(function() {

		var resellerv= "<?php echo $_SESSION['filtro_clientes_bloq'];?>";
		
		$('#resellerName option[value=' + resellerv +']').attr("selected",true);
	
});

</script>

<div class="row">
  <div class="col-sm-4 col-sm-offset-2">
    <div class="form-group">
      <label for="resellerName">Resellers</label>
      <select id= "resellerName" class= "form-control">
        <option value="vacio">Todo</option>
        <?
        
          $res = select_sql_PO('select_porta_customers');
          $cant = count($res);
          $k = 1;

          while ($k <= $cant) {
            echo ('<option value='.$res[$k]['i_customer'].'>'. $res[$k]['name'] . '</option>');
            $k++;
          }

        ?>
      </select>
    </div>
  </div>
  <div class="col-sm-2">
    <button type="submit" class="btn btn-primary" id="submit_filtros">Buscar</button>
  </div>
  <div class="col-sm-2">
	<button type="button" class="btn btn-primary submit_filtros" id="reset_fil">Resetear Filtro</button>
  </div>
</div>


							<?/******************************************************
							************************END FILTROS**************************
							*********************************************************/?>


<table class="ewGrid"><tr><td class="ewGridContent">
<form name="faf_chequeo_det_clienteslist" id="faf_chequeo_det_clienteslist" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_chequeo_det_clientes">
<div id="gmp_af_chequeo_det_clientes" class="ewGridMiddlePanel">
<?php if ($af_chequeo_det_clientes_list->TotalRecs > 0) { ?>
<table id="tbl_af_chequeo_det_clienteslist" class="ewTable ewTableSeparate">
<?php echo $af_chequeo_det_clientes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$af_chequeo_det_clientes_list->RenderListOptions();

// Render list options (header, left)
$af_chequeo_det_clientes_list->ListOptions->Render("header", "left");
?>
<?php if ($af_chequeo_det_clientes->c_ICliente->Visible) { // c_ICliente ?>
	<?php if ($af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_ICliente) == "") { ?>
		<td class="col-sm-6"><div id="elh_af_chequeo_det_clientes_c_ICliente" class="af_chequeo_det_clientes_c_ICliente"><div class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_ICliente->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td class="col-sm-6"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_ICliente) ?>',2);"><div id="elh_af_chequeo_det_clientes_c_ICliente" class="af_chequeo_det_clientes_c_ICliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_ICliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo_det_clientes->c_ICliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo_det_clientes->c_ICliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_chequeo_det_clientes->c_IDestino->Visible) { // c_IDestino ?>
	<?php if ($af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_IDestino) == "") { ?>
		<td><div id="elh_af_chequeo_det_clientes_c_IDestino" class="af_chequeo_det_clientes_c_IDestino"><div class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_IDestino->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_IDestino) ?>',2);"><div id="elh_af_chequeo_det_clientes_c_IDestino" class="af_chequeo_det_clientes_c_IDestino">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_IDestino->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo_det_clientes->c_IDestino->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo_det_clientes->c_IDestino->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_chequeo_det_clientes->c_IChequeo->Visible) { // c_IChequeo ?>
	<?php if ($af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_IChequeo) == "") { ?>
		<td><div id="elh_af_chequeo_det_clientes_c_IChequeo" class="af_chequeo_det_clientes_c_IChequeo"><div class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_IChequeo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->c_IChequeo) ?>',2);"><div id="elh_af_chequeo_det_clientes_c_IChequeo" class="af_chequeo_det_clientes_c_IChequeo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->c_IChequeo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo_det_clientes->c_IChequeo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo_det_clientes->c_IChequeo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_chequeo_det_clientes->f_Bloqueo->Visible) { // f_Bloqueo ?>
	<?php if ($af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->f_Bloqueo) == "") { ?>
		<td><div id="elh_af_chequeo_det_clientes_f_Bloqueo" class="af_chequeo_det_clientes_f_Bloqueo"><div class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->f_Bloqueo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo_det_clientes->SortUrl($af_chequeo_det_clientes->f_Bloqueo) ?>',2);"><div id="elh_af_chequeo_det_clientes_f_Bloqueo" class="af_chequeo_det_clientes_f_Bloqueo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo_det_clientes->f_Bloqueo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo_det_clientes->f_Bloqueo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo_det_clientes->f_Bloqueo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$af_chequeo_det_clientes_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($af_chequeo_det_clientes->ExportAll && $af_chequeo_det_clientes->Export <> "") {
	$af_chequeo_det_clientes_list->StopRec = $af_chequeo_det_clientes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($af_chequeo_det_clientes_list->TotalRecs > $af_chequeo_det_clientes_list->StartRec + $af_chequeo_det_clientes_list->DisplayRecs - 1)
		$af_chequeo_det_clientes_list->StopRec = $af_chequeo_det_clientes_list->StartRec + $af_chequeo_det_clientes_list->DisplayRecs - 1;
	else
		$af_chequeo_det_clientes_list->StopRec = $af_chequeo_det_clientes_list->TotalRecs;
}
$af_chequeo_det_clientes_list->RecCnt = $af_chequeo_det_clientes_list->StartRec - 1;
if ($af_chequeo_det_clientes_list->Recordset && !$af_chequeo_det_clientes_list->Recordset->EOF) {
	$af_chequeo_det_clientes_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $af_chequeo_det_clientes_list->StartRec > 1)
		$af_chequeo_det_clientes_list->Recordset->Move($af_chequeo_det_clientes_list->StartRec - 1);
} elseif (!$af_chequeo_det_clientes->AllowAddDeleteRow && $af_chequeo_det_clientes_list->StopRec == 0) {
	$af_chequeo_det_clientes_list->StopRec = $af_chequeo_det_clientes->GridAddRowCount;
}

// Initialize aggregate
$af_chequeo_det_clientes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$af_chequeo_det_clientes->ResetAttrs();
$af_chequeo_det_clientes_list->RenderRow();
while ($af_chequeo_det_clientes_list->RecCnt < $af_chequeo_det_clientes_list->StopRec) {
	$af_chequeo_det_clientes_list->RecCnt++;
	if (intval($af_chequeo_det_clientes_list->RecCnt) >= intval($af_chequeo_det_clientes_list->StartRec)) {
		$af_chequeo_det_clientes_list->RowCnt++;

		// Set up key count
		$af_chequeo_det_clientes_list->KeyCount = $af_chequeo_det_clientes_list->RowIndex;

		// Init row class and style
		$af_chequeo_det_clientes->ResetAttrs();
		$af_chequeo_det_clientes->CssClass = "";
		if ($af_chequeo_det_clientes->CurrentAction == "gridadd") {
		} else {
			$af_chequeo_det_clientes_list->LoadRowValues($af_chequeo_det_clientes_list->Recordset); // Load row values
		}
		$af_chequeo_det_clientes->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$af_chequeo_det_clientes->RowAttrs = array_merge($af_chequeo_det_clientes->RowAttrs, array('data-rowindex'=>$af_chequeo_det_clientes_list->RowCnt, 'id'=>'r' . $af_chequeo_det_clientes_list->RowCnt . '_af_chequeo_det_clientes', 'data-rowtype'=>$af_chequeo_det_clientes->RowType));

		// Render row
		$af_chequeo_det_clientes_list->RenderRow();

		// Render list options
		$af_chequeo_det_clientes_list->RenderListOptions();
?>
	<tr<?php echo $af_chequeo_det_clientes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$af_chequeo_det_clientes_list->ListOptions->Render("body", "left", $af_chequeo_det_clientes_list->RowCnt);
?>
	<?php if ($af_chequeo_det_clientes->c_ICliente->Visible) { // c_ICliente ?>
		<td<?php echo $af_chequeo_det_clientes->c_ICliente->CellAttributes() ?>>
<span<?php echo $af_chequeo_det_clientes->c_ICliente->ViewAttributes() ?>>
<?php echo $af_chequeo_det_clientes->c_ICliente->ListViewValue() ?></span>
<a id="<?php echo $af_chequeo_det_clientes_list->PageObjName . "_row_" . $af_chequeo_det_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes->c_IDestino->Visible) { // c_IDestino ?>
		<td<?php echo $af_chequeo_det_clientes->c_IDestino->CellAttributes() ?>>
<span<?php echo $af_chequeo_det_clientes->c_IDestino->ViewAttributes() ?>>
<?php echo $af_chequeo_det_clientes->c_IDestino->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes->c_IChequeo->Visible) { // c_IChequeo ?>
		<td<?php echo $af_chequeo_det_clientes->c_IChequeo->CellAttributes() ?>>
<span<?php echo $af_chequeo_det_clientes->c_IChequeo->ViewAttributes() ?>>
<?php echo $af_chequeo_det_clientes->c_IChequeo->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes->f_Bloqueo->Visible) { // f_Bloqueo ?>
		<td<?php echo $af_chequeo_det_clientes->f_Bloqueo->CellAttributes() ?>>
<span<?php echo $af_chequeo_det_clientes->f_Bloqueo->ViewAttributes() ?>>
<?php echo $af_chequeo_det_clientes->f_Bloqueo->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$af_chequeo_det_clientes_list->ListOptions->Render("body", "right", $af_chequeo_det_clientes_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($af_chequeo_det_clientes->CurrentAction <> "gridadd")
		$af_chequeo_det_clientes_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($af_chequeo_det_clientes->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($af_chequeo_det_clientes_list->Recordset)
	$af_chequeo_det_clientes_list->Recordset->Close();
?>
<?php if ($af_chequeo_det_clientes->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($af_chequeo_det_clientes->CurrentAction <> "gridadd" && $af_chequeo_det_clientes->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($af_chequeo_det_clientes_list->Pager)) $af_chequeo_det_clientes_list->Pager = new cNumericPager($af_chequeo_det_clientes_list->StartRec, $af_chequeo_det_clientes_list->DisplayRecs, $af_chequeo_det_clientes_list->TotalRecs, $af_chequeo_det_clientes_list->RecRange) ?>
<?php if ($af_chequeo_det_clientes_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($af_chequeo_det_clientes_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_det_clientes_list->PageUrl() ?>start=<?php echo $af_chequeo_det_clientes_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_det_clientes_list->PageUrl() ?>start=<?php echo $af_chequeo_det_clientes_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($af_chequeo_det_clientes_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $af_chequeo_det_clientes_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_det_clientes_list->PageUrl() ?>start=<?php echo $af_chequeo_det_clientes_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_det_clientes_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_det_clientes_list->PageUrl() ?>start=<?php echo $af_chequeo_det_clientes_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($af_chequeo_det_clientes_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $af_chequeo_det_clientes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $af_chequeo_det_clientes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $af_chequeo_det_clientes_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($af_chequeo_det_clientes_list->SearchWhere == "0=101") { ?>
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
	foreach ($af_chequeo_det_clientes_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>

<!-- Modal para el bloqueo/desbloqueo de lientes -->
<div class="modal fade" id="unlock_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Desbloqueando, espere por favor...</h4>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<span id="logged_user" hidden><?php echo $_SESSION["USUARIO"]; ?></span>

<?php if ($af_chequeo_det_clientes->Export == "") { ?>
<script type="text/javascript">
faf_chequeo_det_clienteslist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$af_chequeo_det_clientes_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($af_chequeo_det_clientes->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>

<script>
  $(document).on('click','#desbloqueo_cli',function(){
      $('#unlock_modal').find('.modal-title').text('Desbloqueando el cliente seleccionado, espere por favor...');
      $('#unlock_modal').modal('show'); 

      var element= $(this);
                                                
      //$(location).attr('href',"DesbloqueoCliente.php?i_customer=" + $(this).attr('class'));
   
    var dataString = "i_customer=" + $(this).attr('class') + "&usuario=" + $("#logged_user").html();
    alert(dataString);
    $.ajax({  
      type: "POST",  
      url: "DesbloqueoCliente.php",  
      data: dataString,  
      success: function(response) {
        element.hide();
      // alert ("termino: "+response);
        $('#unlock_modal').find('.modal-title').text('Cliente desbloqueado satisfactoriamente' + response);
      	setTimeout(function(){
	      	$('#unlock_modal').modal('hide');
        	window.location="af_chequeo_det_clienteslist.php";
      	}, 1500);
      },
      error: function(response){
        // alert ("termino: "+response);
        $('#unlock_modal').find('.modal-title').text('Hubo un error en el desbloqueo del cliente.');
      	setTimeout(function(){
	      	$('#unlock_modal').modal('hide'); 
      	}, 1500);
      }
    });

  });
</script>

<?php include_once "footer.php" ?>
<?php
$af_chequeo_det_clientes_list->Page_Terminate();
?>
