<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_acc_cclassinfo.php" ?>
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

$af_acc_cclass_edit = NULL; // Initialize page object first

class caf_acc_cclass_edit extends caf_acc_cclass {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_acc_cclass';

	// Page object name
	var $PageObjName = 'af_acc_cclass_edit';

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

		// Table object (af_acc_cclass)
		if (!isset($GLOBALS["af_acc_cclass"]) || get_class($GLOBALS["af_acc_cclass"]) == "caf_acc_cclass") {
			$GLOBALS["af_acc_cclass"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_acc_cclass"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_acc_cclass', TRUE);

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
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $HashValue; // Hash Value

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["cl_Accion"] <> "") {
			$this->cl_Accion->setQueryStringValue($_GET["cl_Accion"]);
		}
		if (@$_GET["t_Accion"] <> "") {
			$this->t_Accion->setQueryStringValue($_GET["t_Accion"]);
		}
		if (@$_GET["c_IReseller"] <> "") {
			$this->c_IReseller->setQueryStringValue($_GET["c_IReseller"]);
		}
		if (@$_GET["c_ICClass"] <> "") {
			$this->c_ICClass->setQueryStringValue($_GET["c_ICClass"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Overwrite record, reload hash value
			if ($this->CurrentAction == "overwrite") {
				$this->LoadRowHash();
				$this->CurrentAction = "U";
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->cl_Accion->CurrentValue == "")
			$this->Page_Terminate("af_acc_cclasslist.php"); // Invalid key, return to list
		if ($this->t_Accion->CurrentValue == "")
			$this->Page_Terminate("af_acc_cclasslist.php"); // Invalid key, return to list
		if ($this->c_IReseller->CurrentValue == "")
			$this->Page_Terminate("af_acc_cclasslist.php"); // Invalid key, return to list
		if ($this->c_ICClass->CurrentValue == "")
			$this->Page_Terminate("af_acc_cclasslist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("af_acc_cclasslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cl_Accion->FldIsDetailKey) {
			$this->cl_Accion->setFormValue($objForm->GetValue("x_cl_Accion"));
		}
		if (!$this->t_Accion->FldIsDetailKey) {
			$this->t_Accion->setFormValue($objForm->GetValue("x_t_Accion"));
		}
		if (!$this->c_IReseller->FldIsDetailKey) {
			$this->c_IReseller->setFormValue($objForm->GetValue("x_c_IReseller"));
		}
		if (!$this->c_ICClass->FldIsDetailKey) {
			$this->c_ICClass->setFormValue($objForm->GetValue("x_c_ICClass"));
		}
		if (!$this->x_DirCorreo->FldIsDetailKey) {
			$this->x_DirCorreo->setFormValue($objForm->GetValue("x_x_DirCorreo"));
		}
		if (!$this->x_Titulo->FldIsDetailKey) {
			$this->x_Titulo->setFormValue($objForm->GetValue("x_x_Titulo"));
		}
		if (!$this->x_Mensaje->FldIsDetailKey) {
			$this->x_Mensaje->setFormValue($objForm->GetValue("x_x_Mensaje"));
		}
		if (!$this->f_Ult_Mod->FldIsDetailKey) {
			$this->f_Ult_Mod->setFormValue($objForm->GetValue("x_f_Ult_Mod"));
			$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 9);
		}
		if (!$this->c_Usuario_Ult_Mod->FldIsDetailKey) {
			$this->c_Usuario_Ult_Mod->setFormValue($objForm->GetValue("x_c_Usuario_Ult_Mod"));
		}
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->cl_Accion->CurrentValue = $this->cl_Accion->FormValue;
		$this->t_Accion->CurrentValue = $this->t_Accion->FormValue;
		$this->c_IReseller->CurrentValue = $this->c_IReseller->FormValue;
		$this->c_ICClass->CurrentValue = $this->c_ICClass->FormValue;
		$this->x_DirCorreo->CurrentValue = $this->x_DirCorreo->FormValue;
		$this->x_Titulo->CurrentValue = $this->x_Titulo->FormValue;
		$this->x_Mensaje->CurrentValue = $this->x_Mensaje->FormValue;
		$this->f_Ult_Mod->CurrentValue = $this->f_Ult_Mod->FormValue;
		$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 9);
		$this->c_Usuario_Ult_Mod->CurrentValue = $this->c_Usuario_Ult_Mod->FormValue;
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
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
			if (!$this->EventCancelled)
				$this->HashValue = $this->GetRowHash($rs); // Get hash value for record
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
		$this->cl_Accion->setDbValue($rs->fields('cl_Accion'));
		if (array_key_exists('EV__cl_Accion', $rs->fields)) {
			$this->cl_Accion->VirtualValue = $rs->fields('EV__cl_Accion'); // Set up virtual field value
		} else {
			$this->cl_Accion->VirtualValue = ""; // Clear value
		}
		$this->t_Accion->setDbValue($rs->fields('t_Accion'));
		$this->c_IReseller->setDbValue($rs->fields('c_IReseller'));
		$this->c_ICClass->setDbValue($rs->fields('c_ICClass'));
		$this->x_DirCorreo->setDbValue($rs->fields('x_DirCorreo'));
		$this->x_Titulo->setDbValue($rs->fields('x_Titulo'));
		$this->x_Mensaje->setDbValue($rs->fields('x_Mensaje'));
		$this->f_Ult_Mod->setDbValue($rs->fields('f_Ult_Mod'));
		$this->c_Usuario_Ult_Mod->setDbValue($rs->fields('c_Usuario_Ult_Mod'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->cl_Accion->DbValue = $row['cl_Accion'];
		$this->t_Accion->DbValue = $row['t_Accion'];
		$this->c_IReseller->DbValue = $row['c_IReseller'];
		$this->c_ICClass->DbValue = $row['c_ICClass'];
		$this->x_DirCorreo->DbValue = $row['x_DirCorreo'];
		$this->x_Titulo->DbValue = $row['x_Titulo'];
		$this->x_Mensaje->DbValue = $row['x_Mensaje'];
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
		// cl_Accion
		// t_Accion
		// c_IReseller
		// c_ICClass
		// x_DirCorreo
		// x_Titulo
		// x_Mensaje
		// f_Ult_Mod
		// c_Usuario_Ult_Mod

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// cl_Accion
			if ($this->cl_Accion->VirtualValue <> "") {
				$this->cl_Accion->ViewValue = $this->cl_Accion->VirtualValue;
			} else {
			if (strval($this->cl_Accion->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->cl_Accion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_CLASE_ACCION'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->cl_Accion, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->cl_Accion->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->cl_Accion->ViewValue = $this->cl_Accion->CurrentValue;
				}
			} else {
				$this->cl_Accion->ViewValue = NULL;
			}
			}
			$this->cl_Accion->ViewCustomAttributes = "";

			// t_Accion
			if (strval($this->t_Accion->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Accion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_ACCION_PLAT'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->t_Accion, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->t_Accion->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->t_Accion->ViewValue = $this->t_Accion->CurrentValue;
				}
			} else {
				$this->t_Accion->ViewValue = NULL;
			}
			$this->t_Accion->ViewCustomAttributes = "";

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

			// x_DirCorreo
			$this->x_DirCorreo->ViewValue = $this->x_DirCorreo->CurrentValue;
			$this->x_DirCorreo->ViewCustomAttributes = "";

			// x_Titulo
			$this->x_Titulo->ViewValue = $this->x_Titulo->CurrentValue;
			$this->x_Titulo->ViewCustomAttributes = "";

			// x_Mensaje
			$this->x_Mensaje->ViewValue = $this->x_Mensaje->CurrentValue;
			$this->x_Mensaje->ViewCustomAttributes = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->ViewValue = $this->f_Ult_Mod->CurrentValue;
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 9);
			$this->f_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
			$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

			// cl_Accion
			$this->cl_Accion->LinkCustomAttributes = "";
			$this->cl_Accion->HrefValue = "";
			$this->cl_Accion->TooltipValue = "";

			// t_Accion
			$this->t_Accion->LinkCustomAttributes = "";
			$this->t_Accion->HrefValue = "";
			$this->t_Accion->TooltipValue = "";

			// c_IReseller
			$this->c_IReseller->LinkCustomAttributes = "";
			$this->c_IReseller->HrefValue = "";
			$this->c_IReseller->TooltipValue = "";

			// c_ICClass
			$this->c_ICClass->LinkCustomAttributes = "";
			$this->c_ICClass->HrefValue = "";
			$this->c_ICClass->TooltipValue = "";

			// x_DirCorreo
			$this->x_DirCorreo->LinkCustomAttributes = "";
			$this->x_DirCorreo->HrefValue = "";
			$this->x_DirCorreo->TooltipValue = "";

			// x_Titulo
			$this->x_Titulo->LinkCustomAttributes = "";
			$this->x_Titulo->HrefValue = "";
			$this->x_Titulo->TooltipValue = "";

			// x_Mensaje
			$this->x_Mensaje->LinkCustomAttributes = "";
			$this->x_Mensaje->HrefValue = "";
			$this->x_Mensaje->TooltipValue = "";

			// f_Ult_Mod
			$this->f_Ult_Mod->LinkCustomAttributes = "";
			$this->f_Ult_Mod->HrefValue = "";
			$this->f_Ult_Mod->TooltipValue = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->LinkCustomAttributes = "";
			$this->c_Usuario_Ult_Mod->HrefValue = "";
			$this->c_Usuario_Ult_Mod->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cl_Accion
			$this->cl_Accion->EditCustomAttributes = "";
			if ($this->cl_Accion->VirtualValue <> "") {
				$this->cl_Accion->ViewValue = $this->cl_Accion->VirtualValue;
			} else {
			if (strval($this->cl_Accion->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->cl_Accion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_CLASE_ACCION'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->cl_Accion, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->cl_Accion->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->cl_Accion->EditValue = $this->cl_Accion->CurrentValue;
				}
			} else {
				$this->cl_Accion->EditValue = NULL;
			}
			}
			$this->cl_Accion->ViewCustomAttributes = "";

			// t_Accion
			$this->t_Accion->EditCustomAttributes = "";
			if (strval($this->t_Accion->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->t_Accion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_TIPO_ACCION_PLAT'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->t_Accion, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->t_Accion->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->t_Accion->EditValue = $this->t_Accion->CurrentValue;
				}
			} else {
				$this->t_Accion->EditValue = NULL;
			}
			$this->t_Accion->ViewCustomAttributes = "";

			// c_IReseller
			$this->c_IReseller->EditCustomAttributes = "";
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
					$this->c_IReseller->EditValue = $rswrk->fields('DispFld');
					$result = select_sql_PO("select_porta_customers_where", array($this->c_IReseller->CurrentValue));
					$this->c_IReseller->EditValue = $result[1]['name'];
					$rswrk->Close();
				} else {
					$this->c_IReseller->EditValue = $this->c_IReseller->CurrentValue;
					$result = select_sql_PO("select_porta_customers_where", array($this->c_IReseller->CurrentValue));
					$this->c_IReseller->EditValue = $result[1]['name'];
				}
			} else {
				$this->c_IReseller->EditValue = NULL;
			}
			$this->c_IReseller->ViewCustomAttributes = "";

			// c_ICClass
			$this->c_ICClass->EditCustomAttributes = "";
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
					$this->c_ICClass->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
					$result = select_sql_PO("select_porta_customers_class_where", array($this->c_ICClass->CurrentValue));
					$this->c_ICClass->EditValue = $result[1]['name'];
				} else {
					$this->c_ICClass->EditValue = $this->c_ICClass->CurrentValue;
					$result = select_sql_PO("select_porta_customers_class_where", array($this->c_ICClass->CurrentValue));
					$this->c_ICClass->EditValue = $result[1]['name'];
				}
			} else {
				$this->c_ICClass->EditValue = NULL;
			}
			$this->c_ICClass->ViewCustomAttributes = "";

			// x_DirCorreo
			$this->x_DirCorreo->EditCustomAttributes = "";
			$this->x_DirCorreo->EditValue = ew_HtmlEncode($this->x_DirCorreo->CurrentValue);
			$this->x_DirCorreo->PlaceHolder = ew_RemoveHtml($this->x_DirCorreo->FldCaption());

			// x_Titulo
			$this->x_Titulo->EditCustomAttributes = "";
			$this->x_Titulo->EditValue = ew_HtmlEncode($this->x_Titulo->CurrentValue);
			$this->x_Titulo->PlaceHolder = ew_RemoveHtml($this->x_Titulo->FldCaption());

			// x_Mensaje
			$this->x_Mensaje->EditCustomAttributes = "";
			$this->x_Mensaje->EditValue = $this->x_Mensaje->CurrentValue;
			$this->x_Mensaje->PlaceHolder = ew_RemoveHtml($this->x_Mensaje->FldCaption());

			// f_Ult_Mod
			// c_Usuario_Ult_Mod
			// Edit refer script
			// cl_Accion

			$this->cl_Accion->HrefValue = "";

			// t_Accion
			$this->t_Accion->HrefValue = "";

			// c_IReseller
			$this->c_IReseller->HrefValue = "";

			// c_ICClass
			$this->c_ICClass->HrefValue = "";

			// x_DirCorreo
			$this->x_DirCorreo->HrefValue = "";

			// x_Titulo
			$this->x_Titulo->HrefValue = "";

			// x_Mensaje
			$this->x_Mensaje->HrefValue = "";

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
		if (!$this->cl_Accion->FldIsDetailKey && !is_null($this->cl_Accion->FormValue) && $this->cl_Accion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->cl_Accion->FldCaption());
		}
		if (!$this->t_Accion->FldIsDetailKey && !is_null($this->t_Accion->FormValue) && $this->t_Accion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->t_Accion->FldCaption());
		}
		if (!$this->c_IReseller->FldIsDetailKey && !is_null($this->c_IReseller->FormValue) && $this->c_IReseller->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_IReseller->FldCaption());
		}
		if (!$this->c_ICClass->FldIsDetailKey && !is_null($this->c_ICClass->FormValue) && $this->c_ICClass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_ICClass->FldCaption());
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// cl_Accion
			// t_Accion
			// c_IReseller
			// c_ICClass
			// x_DirCorreo

			$this->x_DirCorreo->SetDbValueDef($rsnew, $this->x_DirCorreo->CurrentValue, NULL, $this->x_DirCorreo->ReadOnly);

			// x_Titulo
			$this->x_Titulo->SetDbValueDef($rsnew, $this->x_Titulo->CurrentValue, NULL, $this->x_Titulo->ReadOnly);

			// x_Mensaje
			$this->x_Mensaje->SetDbValueDef($rsnew, $this->x_Mensaje->CurrentValue, NULL, $this->x_Mensaje->ReadOnly);

			// Check hash value
			$bRowHasConflict = ($this->GetRowHash($rs) <> $this->HashValue);

			// Call Row Update Conflict event
			if ($bRowHasConflict)
				$bRowHasConflict = $this->Row_UpdateConflict($rsold, $rsnew);
			if ($bRowHasConflict) {
				$this->setFailureMessage($Language->Phrase("RecordChangedByOtherUser"));
				$this->UpdateConflict = "U";
				$rs->Close();
				return FALSE; // Update Failed
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Load row hash
	function LoadRowHash() {
		global $conn;
		$sFilter = $this->KeyFilter();

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$RsRow = $conn->Execute($sSql);
		$this->HashValue = ($RsRow && !$RsRow->EOF) ? $this->GetRowHash($RsRow) : ""; // Get hash value for record
		$RsRow->Close();
	}

	// Get Row Hash
	function GetRowHash(&$rs) {
		if (!$rs)
			return "";
		$sHash = "";
		$sHash .= ew_GetFldHash($rs->fields('cl_Accion')); // cl_Accion
		$sHash .= ew_GetFldHash($rs->fields('t_Accion')); // t_Accion
		$sHash .= ew_GetFldHash($rs->fields('c_IReseller')); // c_IReseller
		$sHash .= ew_GetFldHash($rs->fields('c_ICClass')); // c_ICClass
		$sHash .= ew_GetFldHash($rs->fields('x_DirCorreo')); // x_DirCorreo
		$sHash .= ew_GetFldHash($rs->fields('x_Titulo')); // x_Titulo
		$sHash .= ew_GetFldHash($rs->fields('x_Mensaje')); // x_Mensaje
		return md5($sHash);
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "af_acc_cclasslist.php", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
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
if (!isset($af_acc_cclass_edit)) $af_acc_cclass_edit = new caf_acc_cclass_edit();

// Page init
$af_acc_cclass_edit->Page_Init();

// Page main
$af_acc_cclass_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_acc_cclass_edit->Page_Render();
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
var af_acc_cclass_edit = new ew_Page("af_acc_cclass_edit");
af_acc_cclass_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = af_acc_cclass_edit.PageID; // For backward compatibility

// Form object
var faf_acc_cclassedit = new ew_Form("faf_acc_cclassedit");

// Validate form
faf_acc_cclassedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_cl_Accion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_acc_cclass->cl_Accion->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_t_Accion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_acc_cclass->t_Accion->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_c_IReseller");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_acc_cclass->c_IReseller->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_c_ICClass");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_acc_cclass->c_ICClass->FldCaption()) ?>");

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
faf_acc_cclassedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_acc_cclassedit.ValidateRequired = true;
<?php } else { ?>
faf_acc_cclassedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_acc_cclassedit.Lists["x_cl_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_acc_cclassedit.Lists["x_t_Accion"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_acc_cclassedit.Lists["x_c_IReseller"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_acc_cclassedit.Lists["x_c_ICClass"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $af_acc_cclass_edit->ShowPageHeader(); ?>
<?php
$af_acc_cclass_edit->ShowMessage();
?>
<form name="faf_acc_cclassedit" id="faf_acc_cclassedit" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_acc_cclass">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $af_acc_cclass_edit->HashValue ?>">
<div id="page_title"> - Editar</div>
<table class="ewGrid"><tr><td>
<table id="tbl_af_acc_cclassedit" class="table table-bordered table-striped">
<?php if ($af_acc_cclass->cl_Accion->Visible) { // cl_Accion ?>
	<tr id="r_cl_Accion">
		<td><span id="elh_af_acc_cclass_cl_Accion"><?php echo $af_acc_cclass->cl_Accion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_acc_cclass->cl_Accion->CellAttributes() ?>>
<span id="el_af_acc_cclass_cl_Accion" class="control-group">
<span<?php echo $af_acc_cclass->cl_Accion->ViewAttributes() ?>>
<?php echo $af_acc_cclass->cl_Accion->EditValue ?></span>
</span>
<input type="hidden" data-field="x_cl_Accion" name="x_cl_Accion" id="x_cl_Accion" value="<?php echo ew_HtmlEncode($af_acc_cclass->cl_Accion->CurrentValue) ?>">
<?php echo $af_acc_cclass->cl_Accion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->t_Accion->Visible) { // t_Accion ?>
	<tr id="r_t_Accion">
		<td>
			<span id="elh_af_acc_cclass_t_Accion"><?php echo $af_acc_cclass->t_Accion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_acc_cclass->t_Accion->CellAttributes() ?>>
<span id="el_af_acc_cclass_t_Accion" class="control-group">
<span<?php echo $af_acc_cclass->t_Accion->ViewAttributes() ?>>
<?php echo $af_acc_cclass->t_Accion->EditValue ?></span>
</span>
<input type="hidden" data-field="x_t_Accion" name="x_t_Accion" id="x_t_Accion" value="<?php echo ew_HtmlEncode($af_acc_cclass->t_Accion->CurrentValue) ?>">
<?php echo $af_acc_cclass->t_Accion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->c_IReseller->Visible) { // c_IReseller ?>
	<tr id="r_c_IReseller">
		<td><span id="elh_af_acc_cclass_c_IReseller"><?php echo $af_acc_cclass->c_IReseller->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_acc_cclass->c_IReseller->CellAttributes() ?>>
<span id="el_af_acc_cclass_c_IReseller" class="control-group">
<span<?php echo $af_acc_cclass->c_IReseller->ViewAttributes() ?>>
<?php echo $af_acc_cclass->c_IReseller->EditValue ?></span>
</span>
<input type="hidden" data-field="x_c_IReseller" name="x_c_IReseller" id="x_c_IReseller" value="<?php echo ew_HtmlEncode($af_acc_cclass->c_IReseller->CurrentValue) ?>">
<?php echo $af_acc_cclass->c_IReseller->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->c_ICClass->Visible) { // c_ICClass ?>
	<tr id="r_c_ICClass">
		<td><span id="elh_af_acc_cclass_c_ICClass"><?php echo $af_acc_cclass->c_ICClass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_acc_cclass->c_ICClass->CellAttributes() ?>>
<span id="el_af_acc_cclass_c_ICClass" class="control-group">
<span<?php echo $af_acc_cclass->c_ICClass->ViewAttributes() ?>>
<?php echo $af_acc_cclass->c_ICClass->EditValue ?></span>
</span>
<input type="hidden" data-field="x_c_ICClass" name="x_c_ICClass" id="x_c_ICClass" value="<?php echo ew_HtmlEncode($af_acc_cclass->c_ICClass->CurrentValue) ?>">
<?php echo $af_acc_cclass->c_ICClass->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->x_DirCorreo->Visible) { // x_DirCorreo ?>
	<tr id="r_x_DirCorreo">
		<td><span id="elh_af_acc_cclass_x_DirCorreo"><?php echo $af_acc_cclass->x_DirCorreo->FldCaption() ?></span></td>
		<td<?php echo $af_acc_cclass->x_DirCorreo->CellAttributes() ?>>
<span id="el_af_acc_cclass_x_DirCorreo" class="control-group">
<input class="form-control" type="text" data-field="x_x_DirCorreo" name="x_x_DirCorreo" id="x_x_DirCorreo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($af_acc_cclass->x_DirCorreo->PlaceHolder) ?>" value="<?php echo $af_acc_cclass->x_DirCorreo->EditValue ?>"<?php echo $af_acc_cclass->x_DirCorreo->EditAttributes() ?>>
</span>
<?php echo $af_acc_cclass->x_DirCorreo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->x_Titulo->Visible) { // x_Titulo ?>
	<tr id="r_x_Titulo">
		<td>
			<a id="tooltip_a" rel="tooltip" data-placement="left"data-html="true" data-toggle="tooltip" class="tooltipLink" title="#tooltip_info">
			  <span class="glyphicon glyphicon-info-sign"></span>
			</a>
			<span id="elh_af_acc_cclass_x_Titulo"><?php echo $af_acc_cclass->x_Titulo->FldCaption() ?></span></td>
		<td<?php echo $af_acc_cclass->x_Titulo->CellAttributes() ?>>
<span id="el_af_acc_cclass_x_Titulo" class="control-group">
<input class="form-control" data-field="x_x_Titulo" name="x_x_Titulo" id="x_x_Titulo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($af_acc_cclass->x_Titulo->PlaceHolder) ?>" value="<?php echo $af_acc_cclass->x_Titulo->EditValue ?>"<?php echo $af_acc_cclass->x_Titulo->EditAttributes() ?>>
</span>
<?php echo $af_acc_cclass->x_Titulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_acc_cclass->x_Mensaje->Visible) { // x_Mensaje ?>
	<tr id="r_x_Mensaje">
		<td>
			<a id="tooltip_a" rel="tooltip" data-placement="left"data-html="true" data-toggle="tooltip" class="tooltipLink" title="#tooltip_info">
			  <span class="glyphicon glyphicon-info-sign"></span>
			</a>
			<span id="elh_af_acc_cclass_x_Mensaje"><?php echo $af_acc_cclass->x_Mensaje->FldCaption() ?></span></td>
		<td<?php echo $af_acc_cclass->x_Mensaje->CellAttributes() ?>>
<span id="el_af_acc_cclass_x_Mensaje" class="control-group">
<textarea class="form-control" data-field="x_x_Mensaje" name="x_x_Mensaje" id="x_x_Mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($af_acc_cclass->x_Mensaje->PlaceHolder) ?>"<?php echo $af_acc_cclass->x_Mensaje->EditAttributes() ?>><?php echo $af_acc_cclass->x_Mensaje->EditValue ?></textarea>
</span>
<?php echo $af_acc_cclass->x_Mensaje->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($af_acc_cclass->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='overwrite';"><?php echo $Language->Phrase("OverwriteBtn") ?></button>
<button class="btn btn-primary ewButton" name="btnReload" id="btnReload" type="submit" onclick="this.form.a_edit.value='I';"><?php echo $Language->Phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
<?php } ?>
</form>
<script type="text/javascript">
faf_acc_cclassedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$af_acc_cclass_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
$( document ).ready(function() {

$("a.tooltipLink").attr('title', $('#tooltip_info').html());
$("a.tooltipLink").tooltip();
});
</script>
<?php include_once "footer.php" ?>

<table id="tooltip_info" style="display:none;">
<tr>
	<td>Nombre</td>
	<td>Descripción</td>
</tr>
<tr>
	<td>[/NB_CLIENTE]</td>
	<td>Nombre del cliente, campo name del Customer</td>
</tr>
<tr>
	<td>[/C_IDCHEQUEO]</td>
	<td>Código del chequeo</td>
</tr>
<tr>
	<td>[/NB_CL_ACCION]</td>
	<td>Nombre de la clase de la acción. Los valores válidos son: Alerta y Cuarentena</td>
</tr>
<tr>
	<td>[/NB_NV_ACCION]</td>
	<td>Nombre del nivel de la acción. Los valores válidos son: Plataforma, Reseller, Customer Class, Cliente, Cuenta</td>
</tr>
<tr>
	<td>[/NB_COD_NV_ACCION]</td>
	<td>Nombre asociado al nivel de la acción:
		<ul>
			<li>Para Reseller: Nombre del reseller</li>
			<li>Para Customer Class: Nombre del customer class</li>
			<li>Para Customers: Nombre del cliente, campo "Company Name" del Customer</li>
			<li>Para Accounts: Id de la cuenta</li>
		</ul>
	</td>
</tr>
<tr>
	<td>[/NB_IDESTINO]</td>
	<td>Nombre del destino, campo description de Tabla porta-billing.Destinations</td>
</tr>
<tr>
	<td>[/Q_MINUTOS]</td>
	<td>Cantidad de minutos que fueron detectados para la clase y el nivel de acción</td>
</tr>
<tr>
	<td>[/F_INICIO_CHEQUEO]</td>
	<td>Fecha/Hora de inicio de la ventana de chequeo</td>
</tr>
<tr>
	<td>[/F_FIN_CHEQUEO]</td>
	<td>Fecha/Hora de fin de la ventana de chequeo</td>
</tr>
</table>
</div>
<?php
$af_acc_cclass_edit->Page_Terminate();
?>
