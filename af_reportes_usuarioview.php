<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_reportes_usuarioinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
}
//
// Page class
//

$af_reportes_usuario_view = NULL; // Initialize page object first

class caf_reportes_usuario_view extends caf_reportes_usuario {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_reportes_usuario';

	// Page object name
	var $PageObjName = 'af_reportes_usuario_view';

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

		// Table object (af_reportes_usuario)
		if (!isset($GLOBALS["af_reportes_usuario"]) || get_class($GLOBALS["af_reportes_usuario"]) == "caf_reportes_usuario") {
			$GLOBALS["af_reportes_usuario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_reportes_usuario"];
		}
		$KeyUrl = "";
		if (@$_GET["c_Usuario"] <> "") {
			$this->RecKey["c_Usuario"] = $_GET["c_Usuario"];
			$KeyUrl .= "&amp;c_Usuario=" . urlencode($this->RecKey["c_Usuario"]);
		}
		if (@$_GET["c_IReporte"] <> "") {
			$this->RecKey["c_IReporte"] = $_GET["c_IReporte"];
			$KeyUrl .= "&amp;c_IReporte=" . urlencode($this->RecKey["c_IReporte"]);
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
			define("EW_TABLE_NAME", 'af_reportes_usuario', TRUE);

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
			if (@$_GET["c_Usuario"] <> "") {
				$this->c_Usuario->setQueryStringValue($_GET["c_Usuario"]);
				$this->RecKey["c_Usuario"] = $this->c_Usuario->QueryStringValue;
			} else {
				$sReturnUrl = "af_reportes_usuariolist.php"; // Return to list
			}
			if (@$_GET["c_IReporte"] <> "") {
				$this->c_IReporte->setQueryStringValue($_GET["c_IReporte"]);
				$this->RecKey["c_IReporte"] = $this->c_IReporte->QueryStringValue;
			} else {
				$sReturnUrl = "af_reportes_usuariolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "af_reportes_usuariolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "af_reportes_usuariolist.php"; // Not page request, return to list
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
		$this->c_Usuario->setDbValue($rs->fields('c_Usuario'));
		if (array_key_exists('EV__c_Usuario', $rs->fields)) {
			$this->c_Usuario->VirtualValue = $rs->fields('EV__c_Usuario'); // Set up virtual field value
		} else {
			$this->c_Usuario->VirtualValue = ""; // Clear value
		}
		$this->c_IReporte->setDbValue($rs->fields('c_IReporte'));
		if (array_key_exists('EV__c_IReporte', $rs->fields)) {
			$this->c_IReporte->VirtualValue = $rs->fields('EV__c_IReporte'); // Set up virtual field value
		} else {
			$this->c_IReporte->VirtualValue = ""; // Clear value
		}
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_Usuario->DbValue = $row['c_Usuario'];
		$this->c_IReporte->DbValue = $row['c_IReporte'];
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
		// c_Usuario
		// c_IReporte
		// f_Ult_Mod
		// c_Usuario_Ult_Mod

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// c_Usuario
			if ($this->c_Usuario->VirtualValue <> "") {
				$this->c_Usuario->ViewValue = $this->c_Usuario->VirtualValue;
			} else {
			if (strval($this->c_Usuario->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->c_Usuario->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_Usuario, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->c_Usuario->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->c_Usuario->ViewValue = $this->c_Usuario->CurrentValue;
				}
			} else {
				$this->c_Usuario->ViewValue = NULL;
			}
			}
			$this->c_Usuario->ViewCustomAttributes = "";

			// c_IReporte
			if ($this->c_IReporte->VirtualValue <> "") {
				$this->c_IReporte->ViewValue = $this->c_IReporte->VirtualValue;
			} else {
			if (strval($this->c_IReporte->CurrentValue) <> "") {
				$sFilterWrk = "`c_IReporte`" . ew_SearchString("=", $this->c_IReporte->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `c_IReporte`, `c_IReporte` AS `DispFld`, `x_NbReporte` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_reportes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IReporte, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					//$this->c_IReporte->ViewValue = $rswrk->fields('DispFld');
					$this->c_IReporte->ViewValue =/*.= ew_ValueSeparator(1,$this->c_IReporte) . */$rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->c_IReporte->ViewValue = $this->c_IReporte->CurrentValue;
				}
			} else {
				$this->c_IReporte->ViewValue = NULL;
			}
			}
			$this->c_IReporte->ViewCustomAttributes = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->ViewValue = $this->f_Ult_Mod->CurrentValue;
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 9);
			$this->f_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
			$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario
			$this->c_Usuario->LinkCustomAttributes = "";
			$this->c_Usuario->HrefValue = "";
			$this->c_Usuario->TooltipValue = "";

			// c_IReporte
			$this->c_IReporte->LinkCustomAttributes = "";
			$this->c_IReporte->HrefValue = "";
			$this->c_IReporte->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, "af_reportes_usuariolist.php", $this->TableVar, TRUE);
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
if (!isset($af_reportes_usuario_view)) $af_reportes_usuario_view = new caf_reportes_usuario_view();

// Page init
$af_reportes_usuario_view->Page_Init();

// Page main
$af_reportes_usuario_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_reportes_usuario_view->Page_Render();
?>
<?php include_once "header.php" ?>

<?          /**********************SI NO ES USUARIO ADMIN**********************/

if($_SESSION['USUARIO_TYPE']['admin']==0){
	echo ("<div class='jumbotron' style='background-color:#fff'>
	<h1>Contenido no disponible...</h1>
	<h3>Disculpe ". $_SESSION['USUARIO'].", no posee los permisos necesarios para ver esta página</h3>	
	</div>"); exit;
}?>


<script type="text/javascript">

// Page object
var af_reportes_usuario_view = new ew_Page("af_reportes_usuario_view");
af_reportes_usuario_view.PageID = "view"; // Page ID
var EW_PAGE_ID = af_reportes_usuario_view.PageID; // For backward compatibility

// Form object
var faf_reportes_usuarioview = new ew_Form("faf_reportes_usuarioview");

// Form_CustomValidate event
faf_reportes_usuarioview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_reportes_usuarioview.ValidateRequired = true;
<?php } else { ?>
faf_reportes_usuarioview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_reportes_usuarioview.Lists["x_c_Usuario"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_reportes_usuarioview.Lists["x_c_IReporte"] = {"LinkField":"x_c_IReporte","Ajax":null,"AutoFill":false,"DisplayFields":["x_x_NbReporte","x_x_NbReporte","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<div id="page_title" style="text-align:center; width:100%" class="ewViewExportOptions"> - Ver
<?php $af_reportes_usuario_view->ExportOptions->Render("body") ?>
<?php if (!$af_reportes_usuario_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($af_reportes_usuario_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php $af_reportes_usuario_view->ShowPageHeader(); ?>
<?php
$af_reportes_usuario_view->ShowMessage();
?>
<form name="faf_reportes_usuarioview" id="faf_reportes_usuarioview" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_reportes_usuario">
<table class="ewGrid"><tr><td>
<table id="tbl_af_reportes_usuarioview" class="table table-bordered table-striped">
<?php if ($af_reportes_usuario->c_Usuario->Visible) { // c_Usuario ?>
	<tr id="r_c_Usuario">
		<td><span id="elh_af_reportes_usuario_c_Usuario"><?php echo $af_reportes_usuario->c_Usuario->FldCaption() ?></span></td>
		<td<?php echo $af_reportes_usuario->c_Usuario->CellAttributes() ?>>
<span id="el_af_reportes_usuario_c_Usuario" class="control-group">
<span<?php echo $af_reportes_usuario->c_Usuario->ViewAttributes() ?>>
<?php echo $af_reportes_usuario->c_Usuario->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_reportes_usuario->c_IReporte->Visible) { // c_IReporte ?>
	<tr id="r_c_IReporte">
		<td><span id="elh_af_reportes_usuario_c_IReporte"><?php echo $af_reportes_usuario->c_IReporte->FldCaption() ?></span></td>
		<td<?php echo $af_reportes_usuario->c_IReporte->CellAttributes() ?>>
<span id="el_af_reportes_usuario_c_IReporte" class="control-group">
<span<?php echo $af_reportes_usuario->c_IReporte->ViewAttributes() ?>>
<?php echo $af_reportes_usuario->c_IReporte->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_reportes_usuario->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
	<tr id="r_f_Ult_Mod">
		<td><span id="elh_af_reportes_usuario_f_Ult_Mod"><?php echo $af_reportes_usuario->f_Ult_Mod->FldCaption() ?></span></td>
		<td<?php echo $af_reportes_usuario->f_Ult_Mod->CellAttributes() ?>>
<span id="el_af_reportes_usuario_f_Ult_Mod" class="control-group">
<span<?php echo $af_reportes_usuario->f_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_reportes_usuario->f_Ult_Mod->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($af_reportes_usuario->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
	<tr id="r_c_Usuario_Ult_Mod">
		<td><span id="elh_af_reportes_usuario_c_Usuario_Ult_Mod"><?php echo $af_reportes_usuario->c_Usuario_Ult_Mod->FldCaption() ?></span></td>
		<td<?php echo $af_reportes_usuario->c_Usuario_Ult_Mod->CellAttributes() ?>>
<span id="el_af_reportes_usuario_c_Usuario_Ult_Mod" class="control-group">
<span<?php echo $af_reportes_usuario->c_Usuario_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_reportes_usuario->c_Usuario_Ult_Mod->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
faf_reportes_usuarioview.Init();
</script>
<?php
$af_reportes_usuario_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_reportes_usuario_view->Page_Terminate();
?>
