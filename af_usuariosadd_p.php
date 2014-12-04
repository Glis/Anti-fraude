<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_usuariosinfo.php" ?>
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

$af_usuarios_add = NULL; // Initialize page object first

class caf_usuarios_add extends caf_usuarios {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_usuarios';

	// Page object name
	var $PageObjName = 'af_usuarios_add';

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

		// Table object (af_usuarios)
		if (!isset($GLOBALS["af_usuarios"]) || get_class($GLOBALS["af_usuarios"]) == "caf_usuarios") {
			$GLOBALS["af_usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_usuarios"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_usuarios', TRUE);

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
			if (@$_GET["c_Usuario"] != "") {
				$this->c_Usuario->setQueryStringValue($_GET["c_Usuario"]);
				$this->setKey("c_Usuario", $this->c_Usuario->CurrentValue); // Set up key
			} else {
				$this->setKey("c_Usuario", ""); // Clear key
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
					$this->Page_Terminate("af_usuarioslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "af_usuariosview.php")
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
		$this->c_Usuario->CurrentValue = NULL;
		$this->c_Usuario->OldValue = $this->c_Usuario->CurrentValue;
		$this->i_Activo->CurrentValue = NULL;
		$this->i_Activo->OldValue = $this->i_Activo->CurrentValue;
		$this->i_Admin->CurrentValue = NULL;
		$this->i_Admin->OldValue = $this->i_Admin->CurrentValue;
		$this->i_Config->CurrentValue = NULL;
		$this->i_Config->OldValue = $this->i_Config->CurrentValue;
		$this->x_Obs->CurrentValue = NULL;
		$this->x_Obs->OldValue = $this->x_Obs->CurrentValue;
		$this->f_Ult_Mod->CurrentValue = NULL;
		$this->f_Ult_Mod->OldValue = $this->f_Ult_Mod->CurrentValue;
		$this->c_Usuario_Ult_Mod->CurrentValue = NULL;
		$this->c_Usuario_Ult_Mod->OldValue = $this->c_Usuario_Ult_Mod->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->c_Usuario->FldIsDetailKey) {
			$this->c_Usuario->setFormValue($objForm->GetValue("x_c_Usuario"));
		}
		if (!$this->i_Activo->FldIsDetailKey) {
			$this->i_Activo->setFormValue($objForm->GetValue("x_i_Activo"));
		}
		if (!$this->i_Admin->FldIsDetailKey) {
			$this->i_Admin->setFormValue($objForm->GetValue("x_i_Admin"));
		}
		if (!$this->i_Config->FldIsDetailKey) {
			$this->i_Config->setFormValue($objForm->GetValue("x_i_Config"));
		}
		if (!$this->x_Obs->FldIsDetailKey) {
			$this->x_Obs->setFormValue($objForm->GetValue("x_x_Obs"));
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
		$this->c_Usuario->CurrentValue = $this->c_Usuario->FormValue;
		$this->i_Activo->CurrentValue = $this->i_Activo->FormValue;
		$this->i_Admin->CurrentValue = $this->i_Admin->FormValue;
		$this->i_Config->CurrentValue = $this->i_Config->FormValue;
		$this->x_Obs->CurrentValue = $this->x_Obs->FormValue;
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
		$this->c_Usuario->setDbValue($rs->fields('c_Usuario'));
		$this->i_Activo->setDbValue($rs->fields('i_Activo'));
		$this->i_Admin->setDbValue($rs->fields('i_Admin'));
		$this->i_Config->setDbValue($rs->fields('i_Config'));
		if (array_key_exists('EV__i_Config', $rs->fields)) {
			$this->i_Config->VirtualValue = $rs->fields('EV__i_Config'); // Set up virtual field value
		} else {
			$this->i_Config->VirtualValue = ""; // Clear value
		}
		$this->x_Obs->setDbValue($rs->fields('x_Obs'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->c_Usuario->DbValue = $row['c_Usuario'];
		$this->i_Activo->DbValue = $row['i_Activo'];
		$this->i_Admin->DbValue = $row['i_Admin'];
		$this->i_Config->DbValue = $row['i_Config'];
		$this->x_Obs->DbValue = $row['x_Obs'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("c_Usuario")) <> "")
			$this->c_Usuario->CurrentValue = $this->getKey("c_Usuario"); // c_Usuario
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
		// c_Usuario
		// i_Activo
		// i_Admin
		// i_Config
		// x_Obs
		// f_Ult_Mod
		// c_Usuario_Ult_Mod

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// c_Usuario
			$this->c_Usuario->ViewValue = $this->c_Usuario->CurrentValue;
			$this->c_Usuario->ViewCustomAttributes = "";

			// i_Activo
			if (strval($this->i_Activo->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->i_Activo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Activo, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->i_Activo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->i_Activo->ViewValue = $this->i_Activo->CurrentValue;
				}
			} else {
				$this->i_Activo->ViewValue = NULL;
			}
			$this->i_Activo->ViewCustomAttributes = "";

			// i_Admin
			if (strval($this->i_Admin->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->i_Admin->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Admin, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->i_Admin->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->i_Admin->ViewValue = $this->i_Admin->CurrentValue;
				}
			} else {
				$this->i_Admin->ViewValue = NULL;
			}
			$this->i_Admin->ViewCustomAttributes = "";

			// i_Config
			if ($this->i_Config->VirtualValue <> "") {
				$this->i_Config->ViewValue = $this->i_Config->VirtualValue;
			} else {
			if (strval($this->i_Config->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->i_Config->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Config, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->i_Config->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->i_Config->ViewValue = $this->i_Config->CurrentValue;
				}
			} else {
				$this->i_Config->ViewValue = NULL;
			}
			}
			$this->i_Config->ViewCustomAttributes = "";

			// x_Obs
			$this->x_Obs->ViewValue = $this->x_Obs->CurrentValue;
			$this->x_Obs->ViewCustomAttributes = "";

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

			// i_Activo
			$this->i_Activo->LinkCustomAttributes = "";
			$this->i_Activo->HrefValue = "";
			$this->i_Activo->TooltipValue = "";

			// i_Admin
			$this->i_Admin->LinkCustomAttributes = "";
			$this->i_Admin->HrefValue = "";
			$this->i_Admin->TooltipValue = "";

			// i_Config
			$this->i_Config->LinkCustomAttributes = "";
			$this->i_Config->HrefValue = "";
			$this->i_Config->TooltipValue = "";

			// x_Obs
			$this->x_Obs->LinkCustomAttributes = "";
			$this->x_Obs->HrefValue = "";
			$this->x_Obs->TooltipValue = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->LinkCustomAttributes = "";
			$this->f_Ult_Mod->HrefValue = "";
			$this->f_Ult_Mod->TooltipValue = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->LinkCustomAttributes = "";
			$this->c_Usuario_Ult_Mod->HrefValue = "";
			$this->c_Usuario_Ult_Mod->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// c_Usuario
			$this->c_Usuario->EditCustomAttributes = "";
			$this->c_Usuario->EditValue = ew_HtmlEncode($this->c_Usuario->CurrentValue);
			$this->c_Usuario->PlaceHolder = ew_RemoveHtml($this->c_Usuario->FldCaption());

			// i_Activo
			$this->i_Activo->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Activo, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->i_Activo->EditValue = $arwrk;

			// i_Admin
			$this->i_Admin->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Admin, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->i_Admin->EditValue = $arwrk;

			// i_Config
			$this->i_Config->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_SI_NO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Config, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->i_Config->EditValue = $arwrk;

			// x_Obs
			$this->x_Obs->EditCustomAttributes = "";
			$this->x_Obs->EditValue = ew_HtmlEncode($this->x_Obs->CurrentValue);
			$this->x_Obs->PlaceHolder = ew_RemoveHtml($this->x_Obs->FldCaption());

			// f_Ult_Mod
			// c_Usuario_Ult_Mod
			// Edit refer script
			// c_Usuario

			$this->c_Usuario->HrefValue = "";

			// i_Activo
			$this->i_Activo->HrefValue = "";

			// i_Admin
			$this->i_Admin->HrefValue = "";

			// i_Config
			$this->i_Config->HrefValue = "";

			// x_Obs
			$this->x_Obs->HrefValue = "";

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
		if (!$this->c_Usuario->FldIsDetailKey && !is_null($this->c_Usuario->FormValue) && $this->c_Usuario->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_Usuario->FldCaption());
		}
		if (!$this->i_Activo->FldIsDetailKey && !is_null($this->i_Activo->FormValue) && $this->i_Activo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->i_Activo->FldCaption());
		}
		if (!$this->i_Admin->FldIsDetailKey && !is_null($this->i_Admin->FormValue) && $this->i_Admin->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->i_Admin->FldCaption());
		}
		if (!$this->i_Config->FldIsDetailKey && !is_null($this->i_Config->FormValue) && $this->i_Config->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->i_Config->FldCaption());
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

		// c_Usuario
		$this->c_Usuario->SetDbValueDef($rsnew, $this->c_Usuario->CurrentValue, "", FALSE);

		// i_Activo
		$this->i_Activo->SetDbValueDef($rsnew, $this->i_Activo->CurrentValue, 0, FALSE);

		// i_Admin
		$this->i_Admin->SetDbValueDef($rsnew, $this->i_Admin->CurrentValue, 0, FALSE);

		// i_Config
		$this->i_Config->SetDbValueDef($rsnew, $this->i_Config->CurrentValue, 0, FALSE);

		// x_Obs
		$this->x_Obs->SetDbValueDef($rsnew, $this->x_Obs->CurrentValue, NULL, FALSE);

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
		if ($bInsertRow && $this->ValidateKey && $this->c_Usuario->CurrentValue == "" && $this->c_Usuario->getSessionValue() == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, "af_usuarioslist.php", $this->TableVar, TRUE);
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
if (!isset($af_usuarios_add)) $af_usuarios_add = new caf_usuarios_add();

// Page init
$af_usuarios_add->Page_Init();

// Page main
$af_usuarios_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_usuarios_add->Page_Render();
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
var af_usuarios_add = new ew_Page("af_usuarios_add");
af_usuarios_add.PageID = "add"; // Page ID
var EW_PAGE_ID = af_usuarios_add.PageID; // For backward compatibility

// Form object
var faf_usuariosadd = new ew_Form("faf_usuariosadd");

// Validate form
faf_usuariosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_c_Usuario");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_usuarios->c_Usuario->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_i_Activo");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_usuarios->i_Activo->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_i_Admin");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_usuarios->i_Admin->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_i_Config");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_usuarios->i_Config->FldCaption()) ?>");

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
faf_usuariosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_usuariosadd.ValidateRequired = true;
<?php } else { ?>
faf_usuariosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_usuariosadd.Lists["x_i_Activo"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_usuariosadd.Lists["x_i_Admin"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_usuariosadd.Lists["x_i_Config"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $af_usuarios_add->ShowPageHeader(); ?>
<?php
$af_usuarios_add->ShowMessage();
?>
<form name="faf_usuariosadd" id="faf_usuariosadd" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_usuarios">
<input type="hidden" name="a_add" id="a_add" value="A">
<div id="page_title"> - Añadir</div>
<table class="ewGrid"><tr><td>
<table id="tbl_af_usuariosadd" class="table table-bordered table-striped">
<?php if ($af_usuarios->c_Usuario->Visible) { // c_Usuario ?>
	<tr id="r_c_Usuario">
		<td><span id="elh_af_usuarios_c_Usuario"><?php echo $af_usuarios->c_Usuario->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_usuarios->c_Usuario->CellAttributes() ?>>
<span id="el_af_usuarios_c_Usuario" class="control-group">
<input class = "form-control" type="text" data-field="x_c_Usuario" name="x_c_Usuario" id="x_c_Usuario" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($af_usuarios->c_Usuario->PlaceHolder) ?>" value="<?php echo $af_usuarios->c_Usuario->EditValue ?>"<?php echo $af_usuarios->c_Usuario->EditAttributes() ?>>
</span>
<?php echo $af_usuarios->c_Usuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_usuarios->i_Activo->Visible) { // i_Activo ?>
	<tr id="r_i_Activo">
		<td><span id="elh_af_usuarios_i_Activo"><?php echo $af_usuarios->i_Activo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_usuarios->i_Activo->CellAttributes() ?>>
<span id="el_af_usuarios_i_Activo" class="control-group">
<select class = "form-control" data-field="x_i_Activo" id="x_i_Activo" name="x_i_Activo"<?php echo $af_usuarios->i_Activo->EditAttributes() ?>>
<?php
if (is_array($af_usuarios->i_Activo->EditValue)) {
	$arwrk = $af_usuarios->i_Activo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_usuarios->i_Activo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_usuariosadd.Lists["x_i_Activo"].Options = <?php echo (is_array($af_usuarios->i_Activo->EditValue)) ? ew_ArrayToJson($af_usuarios->i_Activo->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_usuarios->i_Activo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_usuarios->i_Admin->Visible) { // i_Admin ?>
	<tr id="r_i_Admin">
		<td><span id="elh_af_usuarios_i_Admin"><?php echo $af_usuarios->i_Admin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_usuarios->i_Admin->CellAttributes() ?>>
<span id="el_af_usuarios_i_Admin" class="control-group">
<select class = "form-control" data-field="x_i_Admin" id="x_i_Admin" name="x_i_Admin"<?php echo $af_usuarios->i_Admin->EditAttributes() ?>>
<?php
if (is_array($af_usuarios->i_Admin->EditValue)) {
	$arwrk = $af_usuarios->i_Admin->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_usuarios->i_Admin->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_usuariosadd.Lists["x_i_Admin"].Options = <?php echo (is_array($af_usuarios->i_Admin->EditValue)) ? ew_ArrayToJson($af_usuarios->i_Admin->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_usuarios->i_Admin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_usuarios->i_Config->Visible) { // i_Config ?>
	<tr id="r_i_Config">
		<td><span id="elh_af_usuarios_i_Config"><?php echo $af_usuarios->i_Config->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_usuarios->i_Config->CellAttributes() ?>>
<span id="el_af_usuarios_i_Config" class="control-group">
<select class = "form-control" data-field="x_i_Config" id="x_i_Config" name="x_i_Config"<?php echo $af_usuarios->i_Config->EditAttributes() ?>>
<?php
if (is_array($af_usuarios->i_Config->EditValue)) {
	$arwrk = $af_usuarios->i_Config->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_usuarios->i_Config->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_usuariosadd.Lists["x_i_Config"].Options = <?php echo (is_array($af_usuarios->i_Config->EditValue)) ? ew_ArrayToJson($af_usuarios->i_Config->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_usuarios->i_Config->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_usuarios->x_Obs->Visible) { // x_Obs ?>
	<tr id="r_x_Obs">
		<td><span id="elh_af_usuarios_x_Obs"><?php echo $af_usuarios->x_Obs->FldCaption() ?></span></td>
		<td<?php echo $af_usuarios->x_Obs->CellAttributes() ?>>
<span id="el_af_usuarios_x_Obs" class="control-group">
<input class = "form-control" type="text" data-field="x_x_Obs" name="x_x_Obs" id="x_x_Obs" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($af_usuarios->x_Obs->PlaceHolder) ?>" value="<?php echo $af_usuarios->x_Obs->EditValue ?>"<?php echo $af_usuarios->x_Obs->EditAttributes() ?>>
</span>
<?php echo $af_usuarios->x_Obs->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
faf_usuariosadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$af_usuarios_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_usuarios_add->Page_Terminate();
?>
