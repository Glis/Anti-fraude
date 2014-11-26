<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_chequeoinfo.php" ?>
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

function changeDate($date){
  $newdate = "";
  // YYYY-MM-DD
  $parts = explode("-",$date);
  $newdate = $parts[2]."/".$parts[1]."/".$parts[0];
  return $newdate;
}

//COLOCA UN BULLET ROJO O AMARILLO DEPENDIENDO EL CASO
function bulletCellContents($type, $ch, $d){
  if($type == "R"){
    $rCuarent=select_custom_sql("c_IReseller","af_chequeo_det_resellers","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_IReseller","af_chequeo_det_resellers","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "CC"){
    $rCuarent=select_custom_sql("c_ICClass","af_chequeo_Det_CClass","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICClass","af_chequeo_Det_CClass","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "C"){
    $rCuarent=select_custom_sql("c_ICliente","af_chequeo_Det_Clientes","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICliente","af_chequeo_Det_Clientes","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "A"){
    $rCuarent=select_custom_sql("c_ICuenta","af_chequeo_Det_Cuentas","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICuenta","af_chequeo_Det_Cuentas","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else {
    return "ERROR";
  }

}

//INICIALIZACIÓN DEL QUERY
$where = "";
if (isset($_POST['initialDateFil']) || isset($_POST['endDateFil'])) {
  

  if(isset($_POST['initialDateFil'])){
    $where .= "STR_TO_DATE(f_Inicio,'%d/%m/%Y') >= STR_TO_DATE('".changeDate($_POST['initialDateFil'])."','%d/%m/%Y')"; 
  }
  if(isset($_POST['endDateFil'])){
    $where .= " and STR_TO_DATE(f_Fin,'%d/%m/%Y') <= STR_TO_DATE('".changeDate($_POST['endDateFil'])."','%d/%m/%Y')";
  }
  
  /*echo "<h2>POST: initialDateFil:".$_POST['initialDateFil']." endDateFil:".$_POST['endDateFil']."</h2>";
  echo "<h2>".print_custom_sql("*","af_chequeo",$where,"", "")."</h2>";*/
}

/*
* SELECTS DE PORTAWAN
*/
/*
abrirConexion_PO();

//DESTINOS
$destinosPorta = select_sql_PO_manual('select_destinos_all');
$destinosList = array();

foreach ($destinosPorta as $key => $dest) {
  $destinosList[$dest['i_dest']] = array( "destination" => $dest["destination"], "description" => $dest["description"]);
}

//RESELLERS
$resellersPorta = select_sql_PO_manual('select_porta_customers');
$resellersList = array();
foreach ($resellersPorta as $key => $res) {
  $resellersList[$res['i_customer']] = array( "name" => $res["name"]);
}

//CUSTOMER CLASS
$ccPorta = select_sql_PO_manual('select_customer_class_all');
$ccList = array();
foreach ($ccPorta as $key => $cclass) {
  $ccList[$cclass['i_customer_class']] = array( "name" => $cclass["name"]);
}

//CLIENTES
$customersPorta = select_sql_PO_manual('select_clientes_all');
$customersList = array();
foreach ($customersPorta as $key => $cus) {
  $customersList[$cus['i_customer']] = array( "name" => $cus["name"]);
}

//CUENTAS 
$accountsPorta = select_sql_PO_manual('select_accounts_really_all');
$accountsList = array();
foreach ($accountsPorta as $key => $acc) {
  $accountsList[$acc['i_account']] = array( "id" => $acc["id"]);
}

cerrarConexion_PO();
*/

//
// Page class
//

$af_chequeo_list = NULL; // Initialize page object first

class caf_chequeo_list extends caf_chequeo {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_chequeo';

	// Page object name
	var $PageObjName = 'af_chequeo_list';

	// Grid form hidden field names
	var $FormName = 'faf_chequeolist';
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

		// Table object (af_chequeo)
		if (!isset($GLOBALS["af_chequeo"]) || get_class($GLOBALS["af_chequeo"]) == "caf_chequeo") {
			$GLOBALS["af_chequeo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_chequeo"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "af_chequeoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "af_chequeodelete.php";
		$this->MultiUpdateUrl = "af_chequeoupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_chequeo', TRUE);

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
	var $DisplayRecs = 10;
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
			$this->DisplayRecs = 10; // Load default
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
		if (count($arrKeyFlds) >= 1) {
			$this->c_IChequeo->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->c_IChequeo->FormValue))
				return FALSE;
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
			$this->UpdateSort($this->c_IChequeo, $bCtrl); // c_IChequeo
			$this->UpdateSort($this->f_Inicio, $bCtrl); // f_Inicio
			$this->UpdateSort($this->f_Fin, $bCtrl); // f_Fin
			$this->UpdateSort($this->f_Inicio_Vent, $bCtrl); // f_Inicio_Vent
			$this->UpdateSort($this->f_Fin_Vent, $bCtrl); // f_Fin_Vent
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
				$this->c_IChequeo->setSort("");
				$this->f_Inicio->setSort("");
				$this->f_Fin->setSort("");
				$this->f_Inicio_Vent->setSort("");
				$this->f_Fin_Vent->setSort("");
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
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->c_IChequeo->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.faf_chequeolist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->c_IChequeo->setDbValue($rs->fields('c_IChequeo'));
		$this->f_Inicio->setDbValue($rs->fields('f_Inicio'));
		$this->f_Fin->setDbValue($rs->fields('f_Fin'));
		$this->f_Inicio_Vent->setDbValue($rs->fields('f_Inicio_Vent'));
		$this->f_Fin_Vent->setDbValue($rs->fields('f_Fin_Vent'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_IChequeo->DbValue = $row['c_IChequeo'];
		$this->f_Inicio->DbValue = $row['f_Inicio'];
		$this->f_Fin->DbValue = $row['f_Fin'];
		$this->f_Inicio_Vent->DbValue = $row['f_Inicio_Vent'];
		$this->f_Fin_Vent->DbValue = $row['f_Fin_Vent'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("c_IChequeo")) <> "")
			$this->c_IChequeo->CurrentValue = $this->getKey("c_IChequeo"); // c_IChequeo
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
		// c_IChequeo
		// f_Inicio
		// f_Fin
		// f_Inicio_Vent
		// f_Fin_Vent

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// c_IChequeo
			$this->c_IChequeo->ViewValue = $this->c_IChequeo->CurrentValue;
			$this->c_IChequeo->ViewCustomAttributes = "";

			// f_Inicio
			$this->f_Inicio->ViewValue = $this->f_Inicio->CurrentValue;
			$this->f_Inicio->ViewValue = ew_FormatDateTime($this->f_Inicio->ViewValue, 9);
			$this->f_Inicio->ViewCustomAttributes = "";

			// f_Fin
			$this->f_Fin->ViewValue = $this->f_Fin->CurrentValue;
			$this->f_Fin->ViewValue = ew_FormatDateTime($this->f_Fin->ViewValue, 9);
			$this->f_Fin->ViewCustomAttributes = "";

			// f_Inicio_Vent
			$this->f_Inicio_Vent->ViewValue = $this->f_Inicio_Vent->CurrentValue;
			$this->f_Inicio_Vent->ViewValue = ew_FormatDateTime($this->f_Inicio_Vent->ViewValue, 9);
			$this->f_Inicio_Vent->ViewCustomAttributes = "";

			// f_Fin_Vent
			$this->f_Fin_Vent->ViewValue = $this->f_Fin_Vent->CurrentValue;
			$this->f_Fin_Vent->ViewValue = ew_FormatDateTime($this->f_Fin_Vent->ViewValue, 9);
			$this->f_Fin_Vent->ViewCustomAttributes = "";

			// c_IChequeo
			$this->c_IChequeo->LinkCustomAttributes = "";
			$this->c_IChequeo->HrefValue = "";
			$this->c_IChequeo->TooltipValue = "";

			// f_Inicio
			$this->f_Inicio->LinkCustomAttributes = "";
			$this->f_Inicio->HrefValue = "";
			$this->f_Inicio->TooltipValue = "";

			// f_Fin
			$this->f_Fin->LinkCustomAttributes = "";
			$this->f_Fin->HrefValue = "";
			$this->f_Fin->TooltipValue = "";

			// f_Inicio_Vent
			$this->f_Inicio_Vent->LinkCustomAttributes = "";
			$this->f_Inicio_Vent->HrefValue = "";
			$this->f_Inicio_Vent->TooltipValue = "";

			// f_Fin_Vent
			$this->f_Fin_Vent->LinkCustomAttributes = "";
			$this->f_Fin_Vent->HrefValue = "";
			$this->f_Fin_Vent->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_af_chequeo\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_af_chequeo',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.faf_chequeolist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($af_chequeo_list)) $af_chequeo_list = new caf_chequeo_list();

// Page init
$af_chequeo_list->Page_Init();

// Page main
$af_chequeo_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_chequeo_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($af_chequeo->Export == "") { ?>
<script type="text/javascript">

// Page object
var af_chequeo_list = new ew_Page("af_chequeo_list");
af_chequeo_list.PageID = "list"; // Page ID
var EW_PAGE_ID = af_chequeo_list.PageID; // For backward compatibility

// Form object
var faf_chequeolist = new ew_Form("faf_chequeolist");
faf_chequeolist.FormKeyCountName = '<?php echo $af_chequeo_list->FormKeyCountName ?>';

// Form_CustomValidate event
faf_chequeolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_chequeolist.ValidateRequired = true;
<?php } else { ?>
faf_chequeolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($af_chequeo->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($af_chequeo_list->ExportOptions->Visible()) { ?>
<div id="page_title" class="ewListExportOptions"><?php $af_chequeo_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$af_chequeo_list->TotalRecs = $af_chequeo->SelectRecordCount();
	} else {
		if ($af_chequeo_list->Recordset = $af_chequeo_list->LoadRecordset())
			$af_chequeo_list->TotalRecs = $af_chequeo_list->Recordset->RecordCount();
	}
	$af_chequeo_list->StartRec = 1;
	if ($af_chequeo_list->DisplayRecs <= 0 || ($af_chequeo->Export <> "" && $af_chequeo->ExportAll)) // Display all records
		$af_chequeo_list->DisplayRecs = $af_chequeo_list->TotalRecs;
	if (!($af_chequeo->Export <> "" && $af_chequeo->ExportAll))
		$af_chequeo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$af_chequeo_list->Recordset = $af_chequeo_list->LoadRecordset($af_chequeo_list->StartRec-1, $af_chequeo_list->DisplayRecs);
$af_chequeo_list->RenderOtherOptions();
?>
<?php $af_chequeo_list->ShowPageHeader(); ?>
<?php
$af_chequeo_list->ShowMessage();
?>

<!-- <div class="debug">
<code>
	<pre><?php var_dump("algo"); ?></pre>
</code>
</div> -->

							<?/******************************************************
							************************FILTROS**************************
							*********************************************************/?>

<script>
$(document).on('click','#submit_filtros',function(){

			var desde = $('#initialDateFil').val();
			var hasta = $('#endDateFil').val();


			var dataString = "pag=monitor&filtro=x";
			if (desde == "vacio"){
				dataString = dataString + "&desde=vacio";
			}else{
				dataString = dataString + "&desde=" + desde;
			}

			if (hasta == "vacio"){
				dataString = dataString + "&hasta=vacio";
			}else{
				dataString = dataString + "&hasta=" + hasta;
			}

			alert(dataString);
			$.ajax({  
			  type: "POST",  
			  url: "lib/functions.php",  
			  data: dataString,  
			  success: function(html) {  
				alert("html");location.reload();
			  }
			});
});

</script>

<div class="filterContainer">

    <div class="row">
      <div class="col-sm-5">
        <div class="form-group">
          <label for="initialDateFil">Desde</label>
          <input type="date" class="form-control" id="initialDateFil" name="initialDateFil" required>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <label for="endDateFil">Hasta</label>
          <input type="date" class="form-control" id="endDateFil" name="endDateFil">
        </div>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Buscar</button>
      </div>
    </div>


  <?$_SESSION['filtros_m']['desde']=""; $_SESSION['filtros_m']['hasta']=""; 
?>
</div>

							<?/******************************************************
							************************ENDFILTROS***********************
							*********************************************************/?>



<table class="ewGrid"><tr><td class="ewGridContent">
<form name="faf_chequeolist" id="faf_chequeolist" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_chequeo">
<div id="gmp_af_chequeo" class="ewGridMiddlePanel">
<?php if ($af_chequeo_list->TotalRecs > 0) { ?>
<table id="tbl_af_chequeolist" class="ewTable ewTableSeparate">
<?php echo $af_chequeo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$af_chequeo_list->RenderListOptions();

// Render list options (header, left)
$af_chequeo_list->ListOptions->Render("header", "left");
?>
<?php if ($af_chequeo->c_IChequeo->Visible) { // c_IChequeo ?>
	<?php if ($af_chequeo->SortUrl($af_chequeo->c_IChequeo) == "") { ?>
		<td><div id="elh_af_chequeo_c_IChequeo" class="af_chequeo_c_IChequeo"><div class="ewTableHeaderCaption"><?php echo $af_chequeo->c_IChequeo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo->SortUrl($af_chequeo->c_IChequeo) ?>',2);"><div id="elh_af_chequeo_c_IChequeo" class="af_chequeo_c_IChequeo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo->c_IChequeo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo->c_IChequeo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo->c_IChequeo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if (false) { // f_Inicio ?>
	<?php if ($af_chequeo->SortUrl($af_chequeo->f_Inicio) == "") { ?>
		<td><div id="elh_af_chequeo_f_Inicio" class="af_chequeo_f_Inicio"><div class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Inicio->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo->SortUrl($af_chequeo->f_Inicio) ?>',2);"><div id="elh_af_chequeo_f_Inicio" class="af_chequeo_f_Inicio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Inicio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo->f_Inicio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo->f_Inicio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if (false) { // f_Fin ?>
	<?php if ($af_chequeo->SortUrl($af_chequeo->f_Fin) == "") { ?>
		<td><div id="elh_af_chequeo_f_Fin" class="af_chequeo_f_Fin"><div class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Fin->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo->SortUrl($af_chequeo->f_Fin) ?>',2);"><div id="elh_af_chequeo_f_Fin" class="af_chequeo_f_Fin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Fin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo->f_Fin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo->f_Fin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_chequeo->f_Inicio_Vent->Visible) { // f_Inicio_Vent ?>
	<?php if ($af_chequeo->SortUrl($af_chequeo->f_Inicio_Vent) == "") { ?>
		<td><div id="elh_af_chequeo_f_Inicio_Vent" class="af_chequeo_f_Inicio_Vent"><div class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Inicio_Vent->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo->SortUrl($af_chequeo->f_Inicio_Vent) ?>',2);"><div id="elh_af_chequeo_f_Inicio_Vent" class="af_chequeo_f_Inicio_Vent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Inicio_Vent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo->f_Inicio_Vent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo->f_Inicio_Vent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($af_chequeo->f_Fin_Vent->Visible) { // f_Fin_Vent ?>
	<?php if ($af_chequeo->SortUrl($af_chequeo->f_Fin_Vent) == "") { ?>
		<td><div id="elh_af_chequeo_f_Fin_Vent" class="af_chequeo_f_Fin_Vent"><div class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Fin_Vent->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $af_chequeo->SortUrl($af_chequeo->f_Fin_Vent) ?>',2);"><div id="elh_af_chequeo_f_Fin_Vent" class="af_chequeo_f_Fin_Vent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $af_chequeo->f_Fin_Vent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($af_chequeo->f_Fin_Vent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($af_chequeo->f_Fin_Vent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$af_chequeo_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($af_chequeo->ExportAll && $af_chequeo->Export <> "") {
	$af_chequeo_list->StopRec = $af_chequeo_list->TotalRecs;
} else {

	// Set the last record to display
	if ($af_chequeo_list->TotalRecs > $af_chequeo_list->StartRec + $af_chequeo_list->DisplayRecs - 1)
		$af_chequeo_list->StopRec = $af_chequeo_list->StartRec + $af_chequeo_list->DisplayRecs - 1;
	else
		$af_chequeo_list->StopRec = $af_chequeo_list->TotalRecs;
}
$af_chequeo_list->RecCnt = $af_chequeo_list->StartRec - 1;
if ($af_chequeo_list->Recordset && !$af_chequeo_list->Recordset->EOF) {
	$af_chequeo_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $af_chequeo_list->StartRec > 1)
		$af_chequeo_list->Recordset->Move($af_chequeo_list->StartRec - 1);
} elseif (!$af_chequeo->AllowAddDeleteRow && $af_chequeo_list->StopRec == 0) {
	$af_chequeo_list->StopRec = $af_chequeo->GridAddRowCount;
}

// Initialize aggregate
$af_chequeo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$af_chequeo->ResetAttrs();
$af_chequeo_list->RenderRow();
while ($af_chequeo_list->RecCnt < $af_chequeo_list->StopRec) {
	$af_chequeo_list->RecCnt++;
	if (intval($af_chequeo_list->RecCnt) >= intval($af_chequeo_list->StartRec)) {
		$af_chequeo_list->RowCnt++;

		// Set up key count
		$af_chequeo_list->KeyCount = $af_chequeo_list->RowIndex;

		// Init row class and style
		$af_chequeo->ResetAttrs();
		$af_chequeo->CssClass = "";
		if ($af_chequeo->CurrentAction == "gridadd") {
		} else {
			$af_chequeo_list->LoadRowValues($af_chequeo_list->Recordset); // Load row values
		}
		$af_chequeo->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$af_chequeo->RowAttrs = array_merge($af_chequeo->RowAttrs, array('data-rowindex'=>$af_chequeo_list->RowCnt, 'id'=>'r' . $af_chequeo_list->RowCnt . '_af_chequeo', 'data-rowtype'=>$af_chequeo->RowType));

		// Render row
		$af_chequeo_list->RenderRow();

		// Render list options
		$af_chequeo_list->RenderListOptions();
?>
	<tr<?php echo $af_chequeo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$af_chequeo_list->ListOptions->Render("body", "left", $af_chequeo_list->RowCnt);
?>
	<?php if ($af_chequeo->c_IChequeo->Visible) { // c_IChequeo ?>
		<td<?php echo $af_chequeo->c_IChequeo->CellAttributes() ?>>
<span<?php echo $af_chequeo->c_IChequeo->ViewAttributes() ?>><a href="link">
<?php echo $af_chequeo->c_IChequeo->ListViewValue() ?></a></span>
<a id="<?php echo $af_chequeo_list->PageObjName . "_row_" . $af_chequeo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if (false) { // f_Inicio ?>
		<td<?php echo $af_chequeo->f_Inicio->CellAttributes() ?>>
<span<?php echo $af_chequeo->f_Inicio->ViewAttributes() ?>>
<?php echo $af_chequeo->f_Inicio->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if (false) { // f_Fin ?>
		<td<?php echo $af_chequeo->f_Fin->CellAttributes() ?>>
<span<?php echo $af_chequeo->f_Fin->ViewAttributes() ?>>
<?php echo $af_chequeo->f_Fin->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_chequeo->f_Inicio_Vent->Visible) { // f_Inicio_Vent ?>
		<td<?php echo $af_chequeo->f_Inicio_Vent->CellAttributes() ?>>
<span<?php echo $af_chequeo->f_Inicio_Vent->ViewAttributes() ?>>
<?php echo $af_chequeo->f_Inicio_Vent->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($af_chequeo->f_Fin_Vent->Visible) { // f_Fin_Vent ?>
		<td<?php echo $af_chequeo->f_Fin_Vent->CellAttributes() ?>>
<span<?php echo $af_chequeo->f_Fin_Vent->ViewAttributes() ?>>
<?php echo $af_chequeo->f_Fin_Vent->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$af_chequeo_list->ListOptions->Render("body", "right", $af_chequeo_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($af_chequeo->CurrentAction <> "gridadd")
		$af_chequeo_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($af_chequeo->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($af_chequeo_list->Recordset)
	$af_chequeo_list->Recordset->Close();
?>
<?php if ($af_chequeo->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($af_chequeo->CurrentAction <> "gridadd" && $af_chequeo->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($af_chequeo_list->Pager)) $af_chequeo_list->Pager = new cNumericPager($af_chequeo_list->StartRec, $af_chequeo_list->DisplayRecs, $af_chequeo_list->TotalRecs, $af_chequeo_list->RecRange) ?>
<?php if ($af_chequeo_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($af_chequeo_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_list->PageUrl() ?>start=<?php echo $af_chequeo_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_list->PageUrl() ?>start=<?php echo $af_chequeo_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($af_chequeo_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $af_chequeo_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_list->PageUrl() ?>start=<?php echo $af_chequeo_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($af_chequeo_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $af_chequeo_list->PageUrl() ?>start=<?php echo $af_chequeo_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($af_chequeo_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $af_chequeo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $af_chequeo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $af_chequeo_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($af_chequeo_list->SearchWhere == "0=101") { ?>
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
	foreach ($af_chequeo_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($af_chequeo->Export == "") { ?>
<script type="text/javascript">
faf_chequeolist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>

<?php
$af_chequeo_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($af_chequeo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>

<script>
	$("a[href='link']").each(function(index){
		var id = $.trim($(this).text());
		$(this).addClass("chequeo_link");
		$(this).attr("href","#dTree"+id);
		$(this).attr("data-toggle","collapse");
		$(this).attr("data-parent","#treeContainer");

		// console.log(index+"-"+id);
	});
</script>

<!-- Tablas explicativas del monitor: 5 niveles -->
<div id="treeContainer" class="col-sm-12">
  
  <div class="row">
  <?php 
  	$offset = 1;
  	if(isset($_GET["start"]))
	  	$offset = $_GET["start"];
	$offset--;

	$chequeos=select_custom_sql("*","af_chequeo",$where,"", "LIMIT 10 OFFSET ".$offset);
	$chequeosCount = count($chequeos);

    if ($chequeosCount > 0) {
    foreach ($chequeos as $check) {
      $destinos=select_custom_sql("*","af_chequeo_det","c_IChequeo='".$check['c_IChequeo']."'","","");
      $destinosCount = count($destinos);
  ?>
      <div id="dTree<? echo $check['c_IChequeo'];?>" class="col-sm-12 collapse">
        <h3>Detalles del chequeo <? echo $check['c_IChequeo'];?></h3>
        <table class="table table-striped table-condensed table-bordered">
          <tbody id="tbDestinos">
            <tr>
              <th class="iconCol"></th>
              <th >ID Destino</th>
              <th class="col-sm-6">Nombre Destino</th>
              <th >Minutos</th>
              <th class="iconCol">R</th>
              <th class="iconCol">CC</th>
              <th class="iconCol">C</th>
              <th class="iconCol">A</th>
              <th class="col-sm-1">Opciones</th>
            </tr>
            <?php 
              if ($destinosCount > 0) {
                foreach ($destinos as $dest) {
                  $resellers=select_custom_sql("*","af_chequeo_det_resellers","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."'","","");
                  $resellersCount = count($resellers);

                  //ARREGLO
                  //$destinoName = $destinosList[$dest['c_IDestino'].""]['destination'];
                  $destinoName = $_SESSION['destinosList'][$dest['c_IDestino'].""]['destination'];
                  //$destinoDescription = $destinosList[$dest['c_IDestino'].""]['description'];
                  $destinoDescription = $_SESSION['destinosList'][$dest['c_IDestino'].""]['description'];
                  $destinoColor = is_On($dest['i_Alerta']) ? 'warning' : "";
                  $destinoColor = is_On($dest['i_Cuarentena']) ? 'danger' : $destinoColor;
            ?>
            <tr>
              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" data-toggle="collapse" data-parent="#tbDestinos"><span class="glyphicon glyphicon-plus"></span></a></td>
              <td class="<? echo $destinoColor; ?>"><?php echo $destinoName; ?></td>
              <td class="<? echo $destinoColor; ?>"><?php echo $destinoDescription; ?></td> <!-- Traer de PortaOne -->
              <td class="<? echo $destinoColor; ?>"><?php echo $dest['q_Min_Plataf']; ?></td>
              <td class="icon-cell white-back"><?php echo bulletCellContents("R",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon-cell white-back"><?php echo bulletCellContents("CC",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon-cell white-back"><?php echo bulletCellContents("C",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon-cell white-back"><?php echo bulletCellContents("A",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon-cell white-back"><span id="CDR_destinos" class="download.php?type=CDR_destinos&c_dest=<?php echo $dest['c_IDestino'];?>&c_chequeo=<?php echo $check['c_IChequeo'];?>"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></span></span> </button></td>
            </tr>
            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" class="collapse">
              <td></td>
              <td colspan="8">
                <table class="table table-striped table-condensed table-bordered">
                  <tbody id="tbResellers">
                    <tr>
                      <th class="iconCol"></th>
                      <th class="col-sm-8">Nombre Reseller</th>
                      <th >Minutos</th>
                      <th class="col-sm-1">Opciones</th>
                    </tr>
                    <?php 
                      if ($resellersCount > 0) {
                        foreach ($resellers as $res) {
                          $cClass=select_custom_sql("*","af_chequeo_det_cclass","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."'","","");
                          $cClassCount = count($cClass);

                           //ARREGLO
                          //$resName = $resellersList[$res['c_IReseller']]['name'];
                          $resName = $_SESSION['resellersList'][$res['c_IReseller']]['name'];
                          $resColor = is_On($res['i_Alerta']) ? 'warning' : "";
                          $resColor = is_On($res['i_Cuarentena']) ? 'danger' : $resColor;
                    ?>
                    <tr>
                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>" data-toggle="collapse" data-parent="#tbResellers"><span class="glyphicon glyphicon-plus"></span></a></td>
                      <td class="<? echo $resColor; ?>"><?php echo $resName; ?></td> <!-- Traer de PortaOne -->
                      <td class="<? echo $resColor; ?>"><? echo $res['q_Min_Reseller']; ?></td>
                      <td class="icon-cell"><span id="CDR_resellers" class="download.php?type=CDR_resellers&c_dest=<?php echo $dest['c_IDestino'];?>&c_chequeo=<?php echo $check['c_IChequeo'];?>&c_reseller=<?php echo $res['c_IReseller'];?>"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></span></td>
                    </tr>
                    <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>" class="collapse">
                      <td></td>
                      <td colspan="4">
                        <table class="table table-striped table-condensed table-bordered">
                          <tbody id="tbCClass">
                            <tr>
                              <th class="iconCol"></th>
                              <th class="col-sm-8">Nombre Customer Class</th>
                              <th >Minutos</th>
                              <th class="col-sm-1">Opciones</th>
                            </tr>
                            <?php 
                              if ($cClassCount > 0) {
                                foreach ($cClass as $cc) {
                                  $customers=select_custom_sql("*","af_chequeo_det_clientes","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."' AND c_ICClass='".$cc['c_ICClass']."' AND (i_Alerta=1 OR i_Cuarentena=1 OR i_Bloqueo=1)","","");
                                  $customersCount = count($customers);

                                  //ARREGLO
                                  //$ccName = $ccList[$cc['c_ICClass']]['name'];
                                  $ccName = $_SESSION['ccList'][$cc['c_ICClass']]['name'];
                                  $ccColor = is_On($cc['i_Alerta']) ? 'warning' : "";
                                  $ccColor = is_On($cc['i_Cuarentena']) ? 'danger' : $ccColor;
                            ?>
                            <tr>
                              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" data-toggle="collapse" data-parent="#tbCClass"><span class="glyphicon glyphicon-plus"></span></a></td>
                              <td class="<? echo $ccColor; ?>"><?php echo $ccName; ?></td> <!-- Traer de PortaOne -->
                              <td class="<? echo $ccColor; ?>"><? echo $cc['q_Min_CClass']; ?></td>
                              <td class="icon-cell">
                              	<span id="CDR_cclass" class="download.php?type=CDR_cclass&c_dest=<?php echo $dest['c_IDestino'];?>&c_chequeo=<?php echo $check['c_IChequeo'];?>&c_reseller=<?php echo $res['c_IReseller'];?>&c_cclass=<?php echo $cc['c_ICClass'];?>">
                              		<?php echo "<span  title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?>
                              	</span>
                              </td>
                            </tr>
                            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" class="collapse">
                              <td></td>
                              <td colspan="4">
                                <table class="table table-striped table-condensed table-bordered">
                                  <tbody id="tbCustomer">
                                    <tr>
                                      <th class="iconCol"></th>
                                      <th class="col-sm-4">Nombre Cliente</th>
                                      <th >Minutos</th>
                                      <th >Bloqueado?</th>
                                      <th >F. Bloqueo</th>
                                      <th >F. Desbloqueo</th>
                                      <th >Usuario Desblq.</th>
                                      <th class="col-sm-1">Opciones</th>
                                    </tr>
                                    <?php 
                                      if ($customersCount > 0) {
                                        foreach ($customers as $cus) {
                                          $accounts=select_custom_sql("*","af_chequeo_det_cuentas","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."' AND c_ICClass='".$cc['c_ICClass']."' AND c_ICliente='".$cus['c_ICliente']."' AND (i_Alerta=1 OR i_Cuarentena=1 OR i_Bloqueo=1)","","");
                                          $accountsCount = count($accounts);

                                          //ARREGLO
                                          //$cusName = $customersList[$cus['c_ICliente']]['name'];
                                          $cusName = $_SESSION['customersList'][$cus['c_ICliente']]['name'];
                                          $cusColor = is_On($cus['i_Alerta']) ? 'warning' : "";
                                          $cusColor = is_On($cus['i_Cuarentena']) ? 'danger' : $cusColor;
                                    ?>
                                    <tr>
                                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" data-toggle="collapse" data-parent="#tbCustomer"><span class="glyphicon glyphicon-plus"></span></a></td>
                                      <td class="<? echo $cusColor; ?>"><?php echo $cusName; ?></td> <!-- Traer de PortaOne -->
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['q_Min_Cliente']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? if(is_On($cus['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['f_Bloqueo']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['f_Desbloqueo']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['c_Usuario_Desbloqueo']; ?></td>
                                      <td class="icon-cell">
                                      	<span id="CDR_clientes" class="download.php?type=CDR_clientes&c_dest=<?php echo $dest['c_IDestino'];?>&c_chequeo=<?php echo $check['c_IChequeo'];?>&c_reseller=<?php echo $res['c_IReseller'];?>&c_cclass=<?php echo $cc['c_ICClass'];?>&c_cliente=<?php echo $cus['c_ICliente'];?>">
                                      	<?php echo "</span><span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?>
                                      	<? if(is_On($cus['i_Bloqueo'])) echo "<span id='desbloqueo_cli' class=". $cus['c_ICliente']. "><span title='Desbloquear' class='glyphicon glyphicon-lock'></span></span>"; ?>
                                      	
                                      </td>
                                    </tr>
                                    <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" class="collapse">
                                      <td></td>
                                      <td colspan="7">
                                        <table class="table table-striped table-condensed table-bordered">
                                          <tbody id="tbAccount">
                                            <tr>
                                              <th class="col-sm-4">Nombre Cuenta</th>
                                              <th >Minutos</th>
                                              <th >Bloqueado?</th>
                                              <th >F. Bloqueo</th>
                                              <th >F. Desbloqueo</th>
                                              <th >Usuario Desblq.</th>
                                              <th class="col-sm-1">Opciones</th>
                                            </tr>
                                            <?php 
                                              if ($accountsCount > 0) {
                                                foreach ($accounts as $acc) {

                                                  //ARREGLO
                                                  //$accName = $accountsList[$acc['c_ICuenta']]['id'];
                                                  $accName = $_SESSION['accountsList'][$acc['c_ICuenta']]['id'];
                                                  $accColor = is_On($acc['i_Alerta']) ? 'warning' : "";
                                                  $accColor = is_On($acc['i_Cuarentena']) ? 'danger' : $accColor;
                                            ?>
                                            <tr>
                                              <td class="<? echo $accColor; ?>"><?php echo $accName; ?></td> <!-- Traer de PortaOne -->
                                              <td class="<? echo $accColor; ?>"><? echo $acc['q_Min_Cuenta']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? if(is_On($acc['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['f_Bloqueo']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['f_Desbloqueo']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['c_Usuario_Desbloqueo']; ?></td>
                                              <td class="icon-cell"><span id="CDR_cuentas" class="download.php?type=CDR_cuentas&c_dest=<?php echo $dest['c_IDestino'];?>&c_chequeo=<?php echo $check['c_IChequeo'];?>&c_reseller=<?php echo $res['c_IReseller'];?>&c_cclass=<?php echo $cc['c_ICClass'];?>&c_cliente=<?php echo $cus['c_ICliente'];?>&c_cuenta=<?php echo $acc['c_ICuenta'];?>"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?><? if(is_On($acc['i_Bloqueo'])) echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></span></td>
                                            </tr> <!-- quinto nivel -->
                                            <?php 
                                                }
                                              } else {
                                            ?>
                                            <tr>
                                              <td colspan=7>No se encuentran registros.</td>
                                            </tr>
                                            <?php
                                              }
                                            ?>
                                          </tbody>
                                        </table>
                                      </td>
                                    </tr><!-- cuarto nivel -->
                                    <?php 
                                        }
                                      } else {
                                    ?>
                                    <tr>
                                      <td colspan=8>No se encuentran registros.</td>
                                    </tr>
                                    <?php
                                      }
                                    ?>
                                  </tbody>
                                </table>
                              </td>
                            </tr> <!-- tercer nivel -->
                            <?php 
                                }
                              } else {
                            ?>
                            <tr>
                              <td colspan=4>No se encuentran registros.</td>
                            </tr>
                            <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </td>
                    </tr> <!-- segundo nivel -->
                    <?php 
                        }
                      } else {
                    ?>
                    <tr>
                      <td colspan=4>No se encuentran registros.</td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </td>
            </tr> <!-- primer nivel -->
            <?php 
                }
              } else {
            ?>
            <tr>
              <td colspan=5>No se encuentran registros.</td>
            </tr>
            <?php
              }
            ?>
            
          </tbody>
        </table>
      </div>

  <?php
    }
  }
  ?>
    
  </div>
</div><!-- treeContainer -->


<script>
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  $('#initialDateFil').val(today);
  $('#endDateFil').val(today);
  $('#initialDateFil').attr("max",today);
  $('#endDateFil').attr("max",today);

  //plus icon toggle
  $("a>span.glyphicon").on('click', function(){
    console.log("hice click en un mas "+$(this).html());
    var icon = $(this); 
    if(icon.hasClass("glyphicon-plus")){
      icon.removeClass( "glyphicon-plus" ).addClass( "glyphicon-minus" );
    }else if (icon.hasClass("glyphicon-minus")){
      setTimeout(function(){
        icon.removeClass( "glyphicon-minus" ).addClass( "glyphicon-plus" );
      }, 400);
    }
  });

  $(".chequeo_link").on("click",function(){
    $(".collapsible_open").collapse("hide").removeClass("collapsible_open");
    
    var collapsible_id = $(this).attr('href');
    console.log("collapsible_id:"+collapsible_id);
    $(collapsible_id).addClass("collapsible_open");
  });

</script>

<script>
$(document).on('click','#CDR_destinos',function(){
                                              
  $(location).attr('href',$(this).attr('class'));
 alert($(this).attr('class'));

});

$(document).on('click','#CDR_resellers',function(){
                                              
  $(location).attr('href',$(this).attr('class'));
 alert($(this).attr('class'));

});

$(document).on('click','#CDR_cclass',function(){
                                              
  $(location).attr('href',$(this).attr('class'));
 alert($(this).attr('class'));

});

$(document).on('click','#CDR_clientes',function(){
                                              
  $(location).attr('href',$(this).attr('class'));
 alert($(this).attr('class'));

});

$(document).on('click','#CDR_cuentas',function(){
                                              
  $(location).attr('href',$(this).attr('class'));
 alert($(this).attr('class'));

});

$(document).on('click','#desbloqueo_cli',function(){
                                              
  	//$(location).attr('href',"DesbloqueoCliente.php?i_customer=" + $(this).attr('class'));
 
 	var dataString = "i_customer=" + $(this).attr('class');
 	$.ajax({  
	  type: "POST",  
	  url: "DesbloqueoCliente.php",  
	  data: dataString,  
	  success: function(response) {  
		$(this).hide(); alert ("termino");
	  }
	});

});

</script>

<?php 
  if(isset($_POST['initialDateFil']) && isset($_POST['endDateFil'])){
?>
  <script>
  var initDate = "<?php echo $_POST['initialDateFil'] ?>";
  var endDate = "<?php echo $_POST['endDateFil'] ?>";
  
  if(initDate != ""){
    $('#initialDateFil').val(initDate);
  }
  if(endDate != ""){
    $('#endDateFil').val(endDate);  
  }
  </script>
<?php 
  }
?>

<?php include_once "footer.php" ?>
<?php
$af_chequeo_list->Page_Terminate();
?>
