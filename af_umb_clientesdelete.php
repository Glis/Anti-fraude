<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_umb_clientesinfo.php" ?>
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

$af_umb_clientes_delete = NULL; // Initialize page object first

class caf_umb_clientes_delete extends caf_umb_clientes {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_umb_clientes';

	// Page object name
	var $PageObjName = 'af_umb_clientes_delete';

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

		// Table object (af_umb_clientes)
		if (!isset($GLOBALS["af_umb_clientes"]) || get_class($GLOBALS["af_umb_clientes"]) == "caf_umb_clientes") {
			$GLOBALS["af_umb_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_umb_clientes"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_umb_clientes', TRUE);

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
			$this->Page_Terminate("af_umb_clienteslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in af_umb_clientes class, af_umb_clientesinfo.php

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
		$this->c_IDestino->setDbValue($rs->fields('c_IDestino'));
		$this->c_IReseller->setDbValue($rs->fields('c_IReseller'));
		$this->c_ICliente->setDbValue($rs->fields('c_ICliente'));
		$this->q_MinAl_Cli->setDbValue($rs->fields('q_MinAl_Cli'));
		$this->q_MinCu_Cli->setDbValue($rs->fields('q_MinCu_Cli'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_IDestino->DbValue = $row['c_IDestino'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->c_ICliente->DbValue = $row['c_ICliente'];
		$this->q_MinAl_Cli->DbValue = $row['q_MinAl_Cli'];
		$this->q_MinCu_Cli->DbValue = $row['q_MinCu_Cli'];
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
		// c_IDestino
		// c_IReseller
		// c_ICliente
		// q_MinAl_Cli
		// q_MinCu_Cli
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

			// c_IReseller
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
			$this->c_IReseller->ViewCustomAttributes = "";

			// c_ICliente
			if (strval($this->c_ICliente->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->c_ICliente->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_ICliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->c_ICliente->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
					$result = select_sql_PO("select_porta_customers_where_class", array($this->c_ICliente->CurrentValue));
					$this->c_ICliente->ViewValue = $result[1]['name'];
				} else {
					$this->c_ICliente->ViewValue = $this->c_ICliente->CurrentValue;
					$result = select_sql_PO("select_porta_customers_where_class", array($this->c_ICliente->CurrentValue));
					$this->c_ICliente->ViewValue = $result[1]['name'];
				}
			} else {
				$this->c_ICliente->ViewValue = NULL;
			}
			$this->c_ICliente->ViewCustomAttributes = "";

			// q_MinAl_Cli
			$this->q_MinAl_Cli->ViewValue = $this->q_MinAl_Cli->CurrentValue;
			$this->q_MinAl_Cli->ViewCustomAttributes = "";

			// q_MinCu_Cli
			$this->q_MinCu_Cli->ViewValue = $this->q_MinCu_Cli->CurrentValue;
			$this->q_MinCu_Cli->ViewCustomAttributes = "";

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

			// c_IReseller
			$this->c_IReseller->LinkCustomAttributes = "";
			$this->c_IReseller->HrefValue = "";
			$this->c_IReseller->TooltipValue = "";

			// c_ICliente
			$this->c_ICliente->LinkCustomAttributes = "";
			$this->c_ICliente->HrefValue = "";
			$this->c_ICliente->TooltipValue = "";

			// q_MinAl_Cli
			$this->q_MinAl_Cli->LinkCustomAttributes = "";
			$this->q_MinAl_Cli->HrefValue = "";
			$this->q_MinAl_Cli->TooltipValue = "";

			// q_MinCu_Cli
			$this->q_MinCu_Cli->LinkCustomAttributes = "";
			$this->q_MinCu_Cli->HrefValue = "";
			$this->q_MinCu_Cli->TooltipValue = "";
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
				$sThisKey .= $row['c_IDestino'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['c_IReseller'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['c_ICliente'];
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
		$Breadcrumb->Add("list", $this->TableVar, "af_umb_clienteslist.php", $this->TableVar, TRUE);
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
if (!isset($af_umb_clientes_delete)) $af_umb_clientes_delete = new caf_umb_clientes_delete();

// Page init
$af_umb_clientes_delete->Page_Init();

// Page main
$af_umb_clientes_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_umb_clientes_delete->Page_Render();
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
var af_umb_clientes_delete = new ew_Page("af_umb_clientes_delete");
af_umb_clientes_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = af_umb_clientes_delete.PageID; // For backward compatibility

// Form object
var faf_umb_clientesdelete = new ew_Form("faf_umb_clientesdelete");

// Form_CustomValidate event
faf_umb_clientesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_umb_clientesdelete.ValidateRequired = true;
<?php } else { ?>
faf_umb_clientesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_umb_clientesdelete.Lists["x_c_IDestino"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_umb_clientesdelete.Lists["x_c_IReseller"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_umb_clientesdelete.Lists["x_c_ICliente"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($af_umb_clientes_delete->Recordset = $af_umb_clientes_delete->LoadRecordset())
	$af_umb_clientes_deleteTotalRecs = $af_umb_clientes_delete->Recordset->RecordCount(); // Get record count
if ($af_umb_clientes_deleteTotalRecs <= 0) { // No record found, exit
	if ($af_umb_clientes_delete->Recordset)
		$af_umb_clientes_delete->Recordset->Close();
	$af_umb_clientes_delete->Page_Terminate("af_umb_clienteslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $af_umb_clientes_delete->ShowPageHeader(); ?>
<?php
$af_umb_clientes_delete->ShowMessage();
?>
<form name="faf_umb_clientesdelete" id="faf_umb_clientesdelete" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_umb_clientes">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($af_umb_clientes_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="page_title" style="text-align:center; width:100%"> - Eliminar</div>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_af_umb_clientesdelete" class="ewTable ewTableSeparate">
<?php echo $af_umb_clientes->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($af_umb_clientes->c_IDestino->Visible) { // c_IDestino ?>
		<td><span id="elh_af_umb_clientes_c_IDestino" class="af_umb_clientes_c_IDestino"><?php echo $af_umb_clientes->c_IDestino->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_umb_clientes->c_IReseller->Visible) { // c_IReseller ?>
		<td><span id="elh_af_umb_clientes_c_IReseller" class="af_umb_clientes_c_IReseller"><?php echo $af_umb_clientes->c_IReseller->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_umb_clientes->c_ICliente->Visible) { // c_ICliente ?>
		<td><span id="elh_af_umb_clientes_c_ICliente" class="af_umb_clientes_c_ICliente"><?php echo $af_umb_clientes->c_ICliente->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_umb_clientes->q_MinAl_Cli->Visible) { // q_MinAl_Cli ?>
		<td><span id="elh_af_umb_clientes_q_MinAl_Cli" class="af_umb_clientes_q_MinAl_Cli"><?php echo $af_umb_clientes->q_MinAl_Cli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($af_umb_clientes->q_MinCu_Cli->Visible) { // q_MinCu_Cli ?>
		<td><span id="elh_af_umb_clientes_q_MinCu_Cli" class="af_umb_clientes_q_MinCu_Cli"><?php echo $af_umb_clientes->q_MinCu_Cli->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$af_umb_clientes_delete->RecCnt = 0;
$i = 0;
while (!$af_umb_clientes_delete->Recordset->EOF) {
	$af_umb_clientes_delete->RecCnt++;
	$af_umb_clientes_delete->RowCnt++;

	// Set row properties
	$af_umb_clientes->ResetAttrs();
	$af_umb_clientes->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$af_umb_clientes_delete->LoadRowValues($af_umb_clientes_delete->Recordset);

	// Render row
	$af_umb_clientes_delete->RenderRow();
?>
	<tr<?php echo $af_umb_clientes->RowAttributes() ?>>
<?php if ($af_umb_clientes->c_IDestino->Visible) { // c_IDestino ?>
		<td<?php echo $af_umb_clientes->c_IDestino->CellAttributes() ?>>
<span id="el<?php echo $af_umb_clientes_delete->RowCnt ?>_af_umb_clientes_c_IDestino" class="control-group af_umb_clientes_c_IDestino">
<span<?php echo $af_umb_clientes->c_IDestino->ViewAttributes() ?>>
<?php echo $af_umb_clientes->c_IDestino->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_umb_clientes->c_IReseller->Visible) { // c_IReseller ?>
		<td<?php echo $af_umb_clientes->c_IReseller->CellAttributes() ?>>
<span id="el<?php echo $af_umb_clientes_delete->RowCnt ?>_af_umb_clientes_c_IReseller" class="control-group af_umb_clientes_c_IReseller">
<span<?php echo $af_umb_clientes->c_IReseller->ViewAttributes() ?>>
<?php echo $af_umb_clientes->c_IReseller->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_umb_clientes->c_ICliente->Visible) { // c_ICliente ?>
		<td<?php echo $af_umb_clientes->c_ICliente->CellAttributes() ?>>
<span id="el<?php echo $af_umb_clientes_delete->RowCnt ?>_af_umb_clientes_c_ICliente" class="control-group af_umb_clientes_c_ICliente">
<span<?php echo $af_umb_clientes->c_ICliente->ViewAttributes() ?>>
<?php echo $af_umb_clientes->c_ICliente->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_umb_clientes->q_MinAl_Cli->Visible) { // q_MinAl_Cli ?>
		<td<?php echo $af_umb_clientes->q_MinAl_Cli->CellAttributes() ?>>
<span id="el<?php echo $af_umb_clientes_delete->RowCnt ?>_af_umb_clientes_q_MinAl_Cli" class="control-group af_umb_clientes_q_MinAl_Cli">
<span<?php echo $af_umb_clientes->q_MinAl_Cli->ViewAttributes() ?>>
<?php echo $af_umb_clientes->q_MinAl_Cli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($af_umb_clientes->q_MinCu_Cli->Visible) { // q_MinCu_Cli ?>
		<td<?php echo $af_umb_clientes->q_MinCu_Cli->CellAttributes() ?>>
<span id="el<?php echo $af_umb_clientes_delete->RowCnt ?>_af_umb_clientes_q_MinCu_Cli" class="control-group af_umb_clientes_q_MinCu_Cli">
<span<?php echo $af_umb_clientes->q_MinCu_Cli->ViewAttributes() ?>>
<?php echo $af_umb_clientes->q_MinCu_Cli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$af_umb_clientes_delete->Recordset->MoveNext();
}
$af_umb_clientes_delete->Recordset->Close();
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
faf_umb_clientesdelete.Init();
</script>
<?php
$af_umb_clientes_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_umb_clientes_delete->Page_Terminate();
?>
