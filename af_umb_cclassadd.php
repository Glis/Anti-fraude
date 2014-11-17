<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_umb_cclassinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD_portaone.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
}

$options_res = select_sql_PO('select_porta_customers');
$cant = count($options_res);
$k = 1;
$html_res_resellers = "<option value='' selected='selected'>Por favor Seleccione</option>";

while ($k <= $cant) {
	$html_res_resellers .= "<option value='". $options_res[$k]['i_customer']."'>". $options_res[$k]['name']. "</option>"; 
	$k++;
}

echo('<div class="new_select_reseller" style="display:none">'); echo $html_res_resellers; echo'</div>';

$options_dest = select_sql_PO('select_destinos_all');
$cant = count($options_dest);
$k = 1;
$html_res_dest = "<option value='' selected='selected'>Por favor Seleccione</option>";

while ($k <= $cant) {
	$html_res_dest .= "<option value='". $options_dest[$k]['i_dest']."'>". $options_dest[$k]['destination']. " - " . $options_dest[$k]['description'] . "</option>"; 
	$k++;
}

echo('<div class="new_select_destino" style="display:none">'); echo $html_res_dest; echo'</div>';


//
// Page class
//

$af_umb_cclass_add = NULL; // Initialize page object first

class caf_umb_cclass_add extends caf_umb_cclass {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_umb_cclass';

	// Page object name
	var $PageObjName = 'af_umb_cclass_add';

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

		// Table object (af_umb_cclass)
		if (!isset($GLOBALS["af_umb_cclass"]) || get_class($GLOBALS["af_umb_cclass"]) == "caf_umb_cclass") {
			$GLOBALS["af_umb_cclass"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_umb_cclass"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_umb_cclass', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["c_IDestino"] != "") {
				$this->c_IDestino->setQueryStringValue($_GET["c_IDestino"]);
				$this->setKey("c_IDestino", $this->c_IDestino->CurrentValue); // Set up key
			} else {
				$this->setKey("c_IDestino", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["c_IReseller"] != "") {
				$this->c_IReseller->setQueryStringValue($_GET["c_IReseller"]);
				$this->setKey("c_IReseller", $this->c_IReseller->CurrentValue); // Set up key
			} else {
				$this->setKey("c_IReseller", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["c_ICClass"] != "") {
				$this->c_ICClass->setQueryStringValue($_GET["c_ICClass"]);
				$this->setKey("c_ICClass", $this->c_ICClass->CurrentValue); // Set up key
			} else {
				$this->setKey("c_ICClass", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("af_umb_cclasslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "af_umb_cclassview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->c_IDestino->CurrentValue = NULL;
		$this->c_IDestino->OldValue = $this->c_IDestino->CurrentValue;
		$this->c_IReseller->CurrentValue = NULL;
		$this->c_IReseller->OldValue = $this->c_IReseller->CurrentValue;
		$this->c_ICClass->CurrentValue = NULL;
		$this->c_ICClass->OldValue = $this->c_ICClass->CurrentValue;
		$this->q_MinAl_CClass->CurrentValue = NULL;
		$this->q_MinAl_CClass->OldValue = $this->q_MinAl_CClass->CurrentValue;
		$this->q_MinCu_CClass->CurrentValue = NULL;
		$this->q_MinCu_CClass->OldValue = $this->q_MinCu_CClass->CurrentValue;
		$this->f_Ult_Mod->CurrentValue = NULL;
		$this->f_Ult_Mod->OldValue = $this->f_Ult_Mod->CurrentValue;
		$this->c_Usuario_Ult_Mod->CurrentValue = NULL;
		$this->c_Usuario_Ult_Mod->OldValue = $this->c_Usuario_Ult_Mod->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->c_IDestino->FldIsDetailKey) {
			$this->c_IDestino->setFormValue($objForm->GetValue("x_c_IDestino"));
		}
		if (!$this->c_IReseller->FldIsDetailKey) {
			$this->c_IReseller->setFormValue($objForm->GetValue("x_c_IReseller"));
		}
		if (!$this->c_ICClass->FldIsDetailKey) {
			$this->c_ICClass->setFormValue($objForm->GetValue("x_c_ICClass"));
		}
		if (!$this->q_MinAl_CClass->FldIsDetailKey) {
			$this->q_MinAl_CClass->setFormValue($objForm->GetValue("x_q_MinAl_CClass"));
		}
		if (!$this->q_MinCu_CClass->FldIsDetailKey) {
			$this->q_MinCu_CClass->setFormValue($objForm->GetValue("x_q_MinCu_CClass"));
		}
		if (!$this->f_Ult_Mod->FldIsDetailKey) {
			$this->f_Ult_Mod->setFormValue($objForm->GetValue("x_f_Ult_Mod"));
			$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 9);
		}
		if (!$this->c_Usuario_Ult_Mod->FldIsDetailKey) {
			$this->c_Usuario_Ult_Mod->setFormValue($objForm->GetValue("x_c_Usuario_Ult_Mod"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->c_IDestino->CurrentValue = $this->c_IDestino->FormValue;
		$this->c_IReseller->CurrentValue = $this->c_IReseller->FormValue;
		$this->c_ICClass->CurrentValue = $this->c_ICClass->FormValue;
		$this->q_MinAl_CClass->CurrentValue = $this->q_MinAl_CClass->FormValue;
		$this->q_MinCu_CClass->CurrentValue = $this->q_MinCu_CClass->FormValue;
		$this->f_Ult_Mod->CurrentValue = $this->f_Ult_Mod->FormValue;
		$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 9);
		$this->c_Usuario_Ult_Mod->CurrentValue = $this->c_Usuario_Ult_Mod->FormValue;
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
		$this->c_ICClass->setDbValue($rs->fields('c_ICClass'));
		$this->q_MinAl_CClass->setDbValue($rs->fields('q_MinAl_CClass'));
		$this->q_MinCu_CClass->setDbValue($rs->fields('q_MinCu_CClass'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_IDestino->DbValue = $row['c_IDestino'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->c_ICClass->DbValue = $row['c_ICClass'];
		$this->q_MinAl_CClass->DbValue = $row['q_MinAl_CClass'];
		$this->q_MinCu_CClass->DbValue = $row['q_MinCu_CClass'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("c_IDestino")) <> "")
			$this->c_IDestino->CurrentValue = $this->getKey("c_IDestino"); // c_IDestino
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_IReseller")) <> "")
			$this->c_IReseller->CurrentValue = $this->getKey("c_IReseller"); // c_IReseller
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("c_ICClass")) <> "")
			$this->c_ICClass->CurrentValue = $this->getKey("c_ICClass"); // c_ICClass
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// c_IDestino
		// c_IReseller
		// c_ICClass
		// q_MinAl_CClass
		// q_MinCu_CClass
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
				} else {
					$this->c_IDestino->ViewValue = $this->c_IDestino->CurrentValue;
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
				} else {
					$this->c_IReseller->ViewValue = $this->c_IReseller->CurrentValue;
				}
			} else {
				$this->c_IReseller->ViewValue = NULL;
			}
			$this->c_IReseller->ViewCustomAttributes = "";

			// c_ICClass
			if (strval($this->c_ICClass->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->c_ICClass->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_ICClass, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->c_ICClass->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->c_ICClass->ViewValue = $this->c_ICClass->CurrentValue;
				}
			} else {
				$this->c_ICClass->ViewValue = NULL;
			}
			$this->c_ICClass->ViewCustomAttributes = "";

			// q_MinAl_CClass
			$this->q_MinAl_CClass->ViewValue = $this->q_MinAl_CClass->CurrentValue;
			$this->q_MinAl_CClass->ViewCustomAttributes = "";

			// q_MinCu_CClass
			$this->q_MinCu_CClass->ViewValue = $this->q_MinCu_CClass->CurrentValue;
			$this->q_MinCu_CClass->ViewCustomAttributes = "";

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

			// c_ICClass
			$this->c_ICClass->LinkCustomAttributes = "";
			$this->c_ICClass->HrefValue = "";
			$this->c_ICClass->TooltipValue = "";

			// q_MinAl_CClass
			$this->q_MinAl_CClass->LinkCustomAttributes = "";
			$this->q_MinAl_CClass->HrefValue = "";
			$this->q_MinAl_CClass->TooltipValue = "";

			// q_MinCu_CClass
			$this->q_MinCu_CClass->LinkCustomAttributes = "";
			$this->q_MinCu_CClass->HrefValue = "";
			$this->q_MinCu_CClass->TooltipValue = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->LinkCustomAttributes = "";
			$this->f_Ult_Mod->HrefValue = "";
			$this->f_Ult_Mod->TooltipValue = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->LinkCustomAttributes = "";
			$this->c_Usuario_Ult_Mod->HrefValue = "";
			$this->c_Usuario_Ult_Mod->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// c_IDestino
			$this->c_IDestino->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IDestino, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->c_IDestino->EditValue = $arwrk;

			// c_IReseller
			$this->c_IReseller->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IReseller, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->c_IReseller->EditValue = $arwrk;

			// c_ICClass
			$this->c_ICClass->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_ICClass, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->c_ICClass->EditValue = $arwrk;

			// q_MinAl_CClass
			$this->q_MinAl_CClass->EditCustomAttributes = "";
			$this->q_MinAl_CClass->EditValue = ew_HtmlEncode($this->q_MinAl_CClass->CurrentValue);
			$this->q_MinAl_CClass->PlaceHolder = ew_RemoveHtml($this->q_MinAl_CClass->FldCaption());

			// q_MinCu_CClass
			$this->q_MinCu_CClass->EditCustomAttributes = "";
			$this->q_MinCu_CClass->EditValue = ew_HtmlEncode($this->q_MinCu_CClass->CurrentValue);
			$this->q_MinCu_CClass->PlaceHolder = ew_RemoveHtml($this->q_MinCu_CClass->FldCaption());

			// f_Ult_Mod
			// c_Usuario_Ult_Mod
			// Edit refer script
			// c_IDestino

			$this->c_IDestino->HrefValue = "";

			// c_IReseller
			$this->c_IReseller->HrefValue = "";

			// c_ICClass
			$this->c_ICClass->HrefValue = "";

			// q_MinAl_CClass
			$this->q_MinAl_CClass->HrefValue = "";

			// q_MinCu_CClass
			$this->q_MinCu_CClass->HrefValue = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->HrefValue = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->c_IDestino->FldIsDetailKey && !is_null($this->c_IDestino->FormValue) && $this->c_IDestino->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_IDestino->FldCaption());
		}
		if (!$this->c_IReseller->FldIsDetailKey && !is_null($this->c_IReseller->FormValue) && $this->c_IReseller->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_IReseller->FldCaption());
		}
		if (!$this->c_ICClass->FldIsDetailKey && !is_null($this->c_ICClass->FormValue) && $this->c_ICClass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_ICClass->FldCaption());
		}
		if (!$this->q_MinAl_CClass->FldIsDetailKey && !is_null($this->q_MinAl_CClass->FormValue) && $this->q_MinAl_CClass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->q_MinAl_CClass->FldCaption());
		}
		if (!ew_CheckInteger($this->q_MinAl_CClass->FormValue)) {
			ew_AddMessage($gsFormError, $this->q_MinAl_CClass->FldErrMsg());
		}
		if (!$this->q_MinCu_CClass->FldIsDetailKey && !is_null($this->q_MinCu_CClass->FormValue) && $this->q_MinCu_CClass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->q_MinCu_CClass->FldCaption());
		}
		if (!ew_CheckInteger($this->q_MinCu_CClass->FormValue)) {
			ew_AddMessage($gsFormError, $this->q_MinCu_CClass->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// c_IDestino
		$this->c_IDestino->SetDbValueDef($rsnew, $this->c_IDestino->CurrentValue, "", FALSE);

		// c_IReseller
		$this->c_IReseller->SetDbValueDef($rsnew, $this->c_IReseller->CurrentValue, "", FALSE);

		// c_ICClass
		$this->c_ICClass->SetDbValueDef($rsnew, $this->c_ICClass->CurrentValue, "", FALSE);

		// q_MinAl_CClass
		$this->q_MinAl_CClass->SetDbValueDef($rsnew, $this->q_MinAl_CClass->CurrentValue, 0, FALSE);

		// q_MinCu_CClass
		$this->q_MinCu_CClass->SetDbValueDef($rsnew, $this->q_MinCu_CClass->CurrentValue, 0, FALSE);

		// f_Ult_Mod
		$this->f_Ult_Mod->SetDbValueDef($rsnew,  gmdate("Y-m-d H:i:s")/*ew_CurrentDate()*/, NULL);
		$rsnew['f_Ult_Mod'] = &$this->f_Ult_Mod->DbValue;

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['c_Usuario_Ult_Mod'] = &$this->c_Usuario_Ult_Mod->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->c_IDestino->CurrentValue == "" && $this->c_IDestino->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->c_IReseller->CurrentValue == "" && $this->c_IReseller->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->c_ICClass->CurrentValue == "" && $this->c_ICClass->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_umb_cclasslist.php", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($af_umb_cclass_add)) $af_umb_cclass_add = new caf_umb_cclass_add();

// Page init
$af_umb_cclass_add->Page_Init();

// Page main
$af_umb_cclass_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_umb_cclass_add->Page_Render();
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
$( document ).ready(function() {
    $('#x_c_IDestino').empty();
    $('#x_c_IDestino').append($('.new_select_destino').html());

    $('#x_c_IReseller').empty();
    $('#x_c_IReseller').append($('.new_select_reseller').html());

    $('#x_c_ICClass').prop('disabled', true);
});

$(document).on('change','#x_c_IReseller',function(){

		if($("#x_c_IReseller").find("option:selected").val() == ""){
			$('#x_c_ICClass').empty().append("<option value='' selected='selected'>Por favor Seleccione</option>");
			$( "#x_c_ICClass" ).prop( "disabled", true );
		}else{
		var dataString = "pag=customer_class_add&reseller="+$("#x_c_IReseller").find("option:selected").val();
		$.ajax({  
			  type: "POST",  
			  url: "lib/functions.php",  
			  data: dataString,  
			  success: function(response) {  
				$('#x_c_ICClass').empty().append(response);
				$( "#x_c_ICClass" ).prop( "disabled", false );
			  }
			});
		}
});

</script>


<script type="text/javascript">

// Page object
var af_umb_cclass_add = new ew_Page("af_umb_cclass_add");
af_umb_cclass_add.PageID = "add"; // Page ID
var EW_PAGE_ID = af_umb_cclass_add.PageID; // For backward compatibility

// Form object
var faf_umb_cclassadd = new ew_Form("faf_umb_cclassadd");

// Validate form
faf_umb_cclassadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_c_IDestino");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_umb_cclass->c_IDestino->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_c_IReseller");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_umb_cclass->c_IReseller->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_c_ICClass");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_umb_cclass->c_ICClass->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_q_MinAl_CClass");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_umb_cclass->q_MinAl_CClass->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_q_MinAl_CClass");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($af_umb_cclass->q_MinAl_CClass->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_q_MinCu_CClass");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_umb_cclass->q_MinCu_CClass->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_q_MinCu_CClass");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($af_umb_cclass->q_MinCu_CClass->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
faf_umb_cclassadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_umb_cclassadd.ValidateRequired = true;
<?php } else { ?>
faf_umb_cclassadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_umb_cclassadd.Lists["x_c_IDestino"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_umb_cclassadd.Lists["x_c_IReseller"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_umb_cclassadd.Lists["x_c_ICClass"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $af_umb_cclass_add->ShowPageHeader(); ?>
<?php
$af_umb_cclass_add->ShowMessage();
?>
<form name="faf_umb_cclassadd" id="faf_umb_cclassadd" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_umb_cclass">
<input type="hidden" name="a_add" id="a_add" value="A">
<div id="page_title"> - Añadir</div>
<table class="ewGrid"><tr><td>
<table id="tbl_af_umb_cclassadd" class="table table-bordered table-striped">
<?php if ($af_umb_cclass->c_IDestino->Visible) { // c_IDestino ?>
	<tr id="r_c_IDestino">
		<td><span id="elh_af_umb_cclass_c_IDestino"><?php echo $af_umb_cclass->c_IDestino->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_umb_cclass->c_IDestino->CellAttributes() ?>>
<span id="el_af_umb_cclass_c_IDestino" class="control-group">
<select class="form-control" data-field="x_c_IDestino" id="x_c_IDestino" name="x_c_IDestino"<?php echo $af_umb_cclass->c_IDestino->EditAttributes() ?>>
<?php
if (is_array($af_umb_cclass->c_IDestino->EditValue)) {
	$arwrk = $af_umb_cclass->c_IDestino->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_umb_cclass->c_IDestino->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
faf_umb_cclassadd.Lists["x_c_IDestino"].Options = <?php echo (is_array($af_umb_cclass->c_IDestino->EditValue)) ? ew_ArrayToJson($af_umb_cclass->c_IDestino->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_umb_cclass->c_IDestino->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_umb_cclass->c_IReseller->Visible) { // c_IReseller ?>
	<tr id="r_c_IReseller">
		<td><span id="elh_af_umb_cclass_c_IReseller"><?php echo $af_umb_cclass->c_IReseller->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_umb_cclass->c_IReseller->CellAttributes() ?>>
<span id="el_af_umb_cclass_c_IReseller" class="control-group">
<select class="form-control" data-field="x_c_IReseller" id="x_c_IReseller" name="x_c_IReseller"<?php echo $af_umb_cclass->c_IReseller->EditAttributes() ?>>
<?php
if (is_array($af_umb_cclass->c_IReseller->EditValue)) {
	$arwrk = $af_umb_cclass->c_IReseller->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_umb_cclass->c_IReseller->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
faf_umb_cclassadd.Lists["x_c_IReseller"].Options = <?php echo (is_array($af_umb_cclass->c_IReseller->EditValue)) ? ew_ArrayToJson($af_umb_cclass->c_IReseller->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_umb_cclass->c_IReseller->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_umb_cclass->c_ICClass->Visible) { // c_ICClass ?>
	<tr id="r_c_ICClass">
		<td><span id="elh_af_umb_cclass_c_ICClass"><?php echo $af_umb_cclass->c_ICClass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_umb_cclass->c_ICClass->CellAttributes() ?>>
<span id="el_af_umb_cclass_c_ICClass" class="control-group">
<select class="form-control" data-field="x_c_ICClass" id="x_c_ICClass" name="x_c_ICClass"<?php echo $af_umb_cclass->c_ICClass->EditAttributes() ?>>
<?php
if (is_array($af_umb_cclass->c_ICClass->EditValue)) {
	$arwrk = $af_umb_cclass->c_ICClass->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_umb_cclass->c_ICClass->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
faf_umb_cclassadd.Lists["x_c_ICClass"].Options = <?php echo (is_array($af_umb_cclass->c_ICClass->EditValue)) ? ew_ArrayToJson($af_umb_cclass->c_ICClass->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_umb_cclass->c_ICClass->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_umb_cclass->q_MinAl_CClass->Visible) { // q_MinAl_CClass ?>
	<tr id="r_q_MinAl_CClass">
		<td><span id="elh_af_umb_cclass_q_MinAl_CClass"><?php echo $af_umb_cclass->q_MinAl_CClass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_umb_cclass->q_MinAl_CClass->CellAttributes() ?>>
<span id="el_af_umb_cclass_q_MinAl_CClass" class="control-group">
<input class="form-control" type="number" min="0" data-field="x_q_MinAl_CClass" name="x_q_MinAl_CClass" id="x_q_MinAl_CClass" size="30" placeholder="<?php echo ew_HtmlEncode($af_umb_cclass->q_MinAl_CClass->PlaceHolder) ?>" value="<?php echo $af_umb_cclass->q_MinAl_CClass->EditValue ?>"<?php echo $af_umb_cclass->q_MinAl_CClass->EditAttributes() ?>>
</span>
<?php echo $af_umb_cclass->q_MinAl_CClass->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_umb_cclass->q_MinCu_CClass->Visible) { // q_MinCu_CClass ?>
	<tr id="r_q_MinCu_CClass">
		<td><span id="elh_af_umb_cclass_q_MinCu_CClass"><?php echo $af_umb_cclass->q_MinCu_CClass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_umb_cclass->q_MinCu_CClass->CellAttributes() ?>>
<span id="el_af_umb_cclass_q_MinCu_CClass" class="control-group">
<input class="form-control" type="number" min="0" data-field="x_q_MinCu_CClass" name="x_q_MinCu_CClass" id="x_q_MinCu_CClass" size="30" placeholder="<?php echo ew_HtmlEncode($af_umb_cclass->q_MinCu_CClass->PlaceHolder) ?>" value="<?php echo $af_umb_cclass->q_MinCu_CClass->EditValue ?>"<?php echo $af_umb_cclass->q_MinCu_CClass->EditAttributes() ?>>
</span>
<?php echo $af_umb_cclass->q_MinCu_CClass->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
faf_umb_cclassadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$af_umb_cclass_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_umb_cclass_add->Page_Terminate();
?>
