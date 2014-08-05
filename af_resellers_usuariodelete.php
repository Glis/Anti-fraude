<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_resellers_usuarioinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD_portaone.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
}
//
// Page class
//

$af_resellers_usuario_delete = NULL; // Initialize page object first

class caf_resellers_usuario_delete extends caf_resellers_usuario {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_resellers_usuario';

	// Page object name
	var $PageObjName = 'af_resellers_usuario_delete';

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

		// Table object (af_resellers_usuario)
		if (!isset($GLOBALS["af_resellers_usuario"]) || get_class($GLOBALS["af_resellers_usuario"]) == "caf_resellers_usuario") {
			$GLOBALS["af_resellers_usuario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_resellers_usuario"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_resellers_usuario', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("af_resellers_usuariolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in af_resellers_usuario class, af_resellers_usuarioinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		$this->c_Usuario->setDbValue($rs->fields('c_Usuario'));
		if (array_key_exists('EV__c_Usuario', $rs->fields)) {
			$this->c_Usuario->VirtualValue = $rs->fields('EV__c_Usuario'); // Set up virtual field value
		} else {
			$this->c_Usuario->VirtualValue = ""; // Clear value
		}
		$this->c_IReseller->setDbValue($rs->fields('c_IReseller'));
		if (array_key_exists('EV__c_IReseller', $rs->fields)) {
			$this->c_IReseller->VirtualValue = $rs->fields('EV__c_IReseller'); // Set up virtual field value
		} else {
			$this->c_IReseller->VirtualValue = ""; // Clear value
		}
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_Usuario->DbValue = $row['c_Usuario'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// c_Usuario
		// c_IReseller
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

			// c_IReseller
			if ($this->c_IReseller->VirtualValue <> "") {
				$this->c_IReseller->ViewValue = $this->c_IReseller->VirtualValue;
			} else {
			if (strval($this->c_IReseller->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->c_IReseller->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IReseller, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->c_IReseller->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
					$result = select_sql_PO("select_porta_customers_where", array($this->c_IReseller->CurrentValue));
					$this->c_IReseller->ViewValue = $result[1]['name'];
				} else {
					$this->c_IReseller->ViewValue = $this->c_IReseller->CurrentValue;
					$result = select_sql_PO("select_porta_customers_where", array($this->c_IReseller->CurrentValue));
					$this->c_IReseller->ViewValue = $result[1]['name'];
				}
			} else {
				$this->c_IReseller->ViewValue = NULL;
			}
			}
			$this->c_IReseller->ViewCustomAttributes = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->ViewValue = $this->f_Ult_Mod->CurrentValue;
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 7);
			$this->f_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
			$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario
			$this->c_Usuario->LinkCustomAttributes = "";
			$this->c_Usuario->HrefValue = "";
			$this->c_Usuario->TooltipValue = "";

			// c_IReseller
			$this->c_IReseller->LinkCustomAttributes = "";
			$this->c_IReseller->HrefValue = "";
			$this->c_IReseller->TooltipValue = "";

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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['c_Usuario'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['c_IReseller'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_resellers_usuariolist.php", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, ew_CurrentUrl());
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
if (!isset($af_resellers_usuario_delete)) $af_resellers_usuario_delete = new caf_resellers_usuario_delete();

// Page init
$af_resellers_usuario_delete->Page_Init();

// Page main
$af_resellers_usuario_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_resellers_usuario_delete->Page_Render();
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
var af_resellers_usuario_delete = new ew_Page("af_resellers_usuario_delete");
af_resellers_usuario_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = af_resellers_usuario_delete.PageID; // For backward compatibility

// Form object
var faf_resellers_usuariodelete = new ew_Form("faf_resellers_usuariodelete");

// Form_CustomValidate event
faf_resellers_usuariodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_resellers_usuariodelete.ValidateRequired = true;
<?php } else { ?>
faf_resellers_usuariodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_resellers_usuariodelete.Lists["x_c_Usuario"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_resellers_usuariodelete.Lists["x_c_IReseller"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($af_resellers_usuario_delete->Recordset = $af_resellers_usuario_delete->LoadRecordset())
	$af_resellers_usuario_deleteTotalRecs = $af_resellers_usuario_delete->Recordset->RecordCount(); // Get record count
if ($af_resellers_usuario_deleteTotalRecs <= 0) { // No record found, exit
	if ($af_resellers_usuario_delete->Recordset)
		$af_resellers_usuario_delete->Recordset->Close();
	$af_resellers_usuario_delete->Page_Terminate("af_resellers_usuariolist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $af_resellers_usuario_delete->ShowPageHeader(); ?>
<?php
$af_resellers_usuario_delete->ShowMessage();
?>
<form name="faf_resellers_usuariodelete" id="faf_resellers_usuariodelete" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_resellers_usuario">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($af_resellers_usuario_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="page_title" style="text-align:center; width:100%"> - Eliminar</div>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_af_resellers_usuariodelete" class="ewTable ewTableSeparate">
<?php echo $af_resellers_usuario->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($af_resellers_usuario->c_Usuario->Visible) { // c_Usuario ?>
		<td><span id="elh_af_resellers_usuario_c_Usuario" class="af_resellers_usuario_c_Usuario"><?php echo $af_resellers_usuario->c_Usuario->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_resellers_usuario->c_IReseller->Visible) { // c_IReseller ?>
		<td><span id="elh_af_resellers_usuario_c_IReseller" class="af_resellers_usuario_c_IReseller"><?php echo $af_resellers_usuario->c_IReseller->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_resellers_usuario->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
		<td><span id="elh_af_resellers_usuario_f_Ult_Mod" class="af_resellers_usuario_f_Ult_Mod"><?php echo $af_resellers_usuario->f_Ult_Mod->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_resellers_usuario->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
		<td><span id="elh_af_resellers_usuario_c_Usuario_Ult_Mod" class="af_resellers_usuario_c_Usuario_Ult_Mod"><?php echo $af_resellers_usuario->c_Usuario_Ult_Mod->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$af_resellers_usuario_delete->RecCnt = 0;
$i = 0;
while (!$af_resellers_usuario_delete->Recordset->EOF) {
	$af_resellers_usuario_delete->RecCnt++;
	$af_resellers_usuario_delete->RowCnt++;

	// Set row properties
	$af_resellers_usuario->ResetAttrs();
	$af_resellers_usuario->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$af_resellers_usuario_delete->LoadRowValues($af_resellers_usuario_delete->Recordset);

	// Render row
	$af_resellers_usuario_delete->RenderRow();
?>
	<tr<?php echo $af_resellers_usuario->RowAttributes() ?>>
<?php if ($af_resellers_usuario->c_Usuario->Visible) { // c_Usuario ?>
		<td<?php echo $af_resellers_usuario->c_Usuario->CellAttributes() ?>>
<span id="el<?php echo $af_resellers_usuario_delete->RowCnt ?>_af_resellers_usuario_c_Usuario" class="control-group af_resellers_usuario_c_Usuario">
<span<?php echo $af_resellers_usuario->c_Usuario->ViewAttributes() ?>>
<?php echo $af_resellers_usuario->c_Usuario->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_resellers_usuario->c_IReseller->Visible) { // c_IReseller ?>
		<td<?php echo $af_resellers_usuario->c_IReseller->CellAttributes() ?>>
<span id="el<?php echo $af_resellers_usuario_delete->RowCnt ?>_af_resellers_usuario_c_IReseller" class="control-group af_resellers_usuario_c_IReseller">
<span<?php echo $af_resellers_usuario->c_IReseller->ViewAttributes() ?>>
<?php echo $af_resellers_usuario->c_IReseller->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_resellers_usuario->f_Ult_Mod->Visible) { // f_Ult_Mod ?>
		<td<?php echo $af_resellers_usuario->f_Ult_Mod->CellAttributes() ?>>
<span id="el<?php echo $af_resellers_usuario_delete->RowCnt ?>_af_resellers_usuario_f_Ult_Mod" class="control-group af_resellers_usuario_f_Ult_Mod">
<span<?php echo $af_resellers_usuario->f_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_resellers_usuario->f_Ult_Mod->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_resellers_usuario->c_Usuario_Ult_Mod->Visible) { // c_Usuario_Ult_Mod ?>
		<td<?php echo $af_resellers_usuario->c_Usuario_Ult_Mod->CellAttributes() ?>>
<span id="el<?php echo $af_resellers_usuario_delete->RowCnt ?>_af_resellers_usuario_c_Usuario_Ult_Mod" class="control-group af_resellers_usuario_c_Usuario_Ult_Mod">
<span<?php echo $af_resellers_usuario->c_Usuario_Ult_Mod->ViewAttributes() ?>>
<?php echo $af_resellers_usuario->c_Usuario_Ult_Mod->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$af_resellers_usuario_delete->Recordset->MoveNext();
}
$af_resellers_usuario_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
faf_resellers_usuariodelete.Init();
</script>
<?php
$af_resellers_usuario_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_resellers_usuario_delete->Page_Terminate();
?>
