<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "af_config_reportesinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$af_config_reportes_add = NULL; // Initialize page object first

class caf_config_reportes_add extends caf_config_reportes {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6DD8CE42-32CB-41B2-9566-7C52A93FF8EA}";

	// Table name
	var $TableName = 'af_config_reportes';

	// Page object name
	var $PageObjName = 'af_config_reportes_add';

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

		// Table object (af_config_reportes)
		if (!isset($GLOBALS["af_config_reportes"]) || get_class($GLOBALS["af_config_reportes"]) == "caf_config_reportes") {
			$GLOBALS["af_config_reportes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["af_config_reportes"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'af_config_reportes', TRUE);

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
			if (@$_GET["c_IConfig"] != "") {
				$this->c_IConfig->setQueryStringValue($_GET["c_IConfig"]);
				$this->setKey("c_IConfig", $this->c_IConfig->CurrentValue); // Set up key
			} else {
				$this->setKey("c_IConfig", ""); // Clear key
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
					$this->Page_Terminate("af_config_reporteslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "af_config_reportesview.php")
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
		$this->c_IConfig->CurrentValue = NULL;
		$this->c_IConfig->OldValue = $this->c_IConfig->CurrentValue;
		$this->c_IReporte->CurrentValue = NULL;
		$this->c_IReporte->OldValue = $this->c_IReporte->CurrentValue;
		$this->frec_Envio->CurrentValue = NULL;
		$this->frec_Envio->OldValue = $this->frec_Envio->CurrentValue;
		$this->i_Dia_Envio->CurrentValue = NULL;
		$this->i_Dia_Envio->OldValue = $this->i_Dia_Envio->CurrentValue;
		$this->x_Hora_Envio->CurrentValue = NULL;
		$this->x_Hora_Envio->OldValue = $this->x_Hora_Envio->CurrentValue;
		$this->p_Destino->CurrentValue = NULL;
		$this->p_Destino->OldValue = $this->p_Destino->CurrentValue;
		$this->p_Reseller->CurrentValue = NULL;
		$this->p_Reseller->OldValue = $this->p_Reseller->CurrentValue;
		$this->p_CClass->CurrentValue = NULL;
		$this->p_CClass->OldValue = $this->p_CClass->CurrentValue;
		$this->x_DirCorreo->CurrentValue = NULL;
		$this->x_DirCorreo->OldValue = $this->x_DirCorreo->CurrentValue;
		$this->x_Titulo->CurrentValue = NULL;
		$this->x_Titulo->OldValue = $this->x_Titulo->CurrentValue;
		$this->x_Mensaje->CurrentValue = NULL;
		$this->x_Mensaje->OldValue = $this->x_Mensaje->CurrentValue;
		$this->f_Ult_Mod->CurrentValue = NULL;
		$this->f_Ult_Mod->OldValue = $this->f_Ult_Mod->CurrentValue;
		$this->c_Usuario_Ult_Mod->CurrentValue = NULL;
		$this->c_Usuario_Ult_Mod->OldValue = $this->c_Usuario_Ult_Mod->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->c_IConfig->FldIsDetailKey) {
			$this->c_IConfig->setFormValue($objForm->GetValue("x_c_IConfig"));
		}
		if (!$this->c_IReporte->FldIsDetailKey) {
			$this->c_IReporte->setFormValue($objForm->GetValue("x_c_IReporte"));
		}
		if (!$this->frec_Envio->FldIsDetailKey) {
			$this->frec_Envio->setFormValue($objForm->GetValue("x_frec_Envio"));
		}
		if (!$this->i_Dia_Envio->FldIsDetailKey) {
			$this->i_Dia_Envio->setFormValue($objForm->GetValue("x_i_Dia_Envio"));
		}
		if (!$this->x_Hora_Envio->FldIsDetailKey) {
			$this->x_Hora_Envio->setFormValue($objForm->GetValue("x_x_Hora_Envio"));
		}
		if (!$this->p_Destino->FldIsDetailKey) {
			$this->p_Destino->setFormValue($objForm->GetValue("x_p_Destino"));
		}
		if (!$this->p_Reseller->FldIsDetailKey) {
			$this->p_Reseller->setFormValue($objForm->GetValue("x_p_Reseller"));
		}
		if (!$this->p_CClass->FldIsDetailKey) {
			$this->p_CClass->setFormValue($objForm->GetValue("x_p_CClass"));
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
			$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 7);
		}
		if (!$this->c_Usuario_Ult_Mod->FldIsDetailKey) {
			$this->c_Usuario_Ult_Mod->setFormValue($objForm->GetValue("x_c_Usuario_Ult_Mod"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->c_IConfig->CurrentValue = $this->c_IConfig->FormValue;
		$this->c_IReporte->CurrentValue = $this->c_IReporte->FormValue;
		$this->frec_Envio->CurrentValue = $this->frec_Envio->FormValue;
		$this->i_Dia_Envio->CurrentValue = $this->i_Dia_Envio->FormValue;
		$this->x_Hora_Envio->CurrentValue = $this->x_Hora_Envio->FormValue;
		$this->p_Destino->CurrentValue = $this->p_Destino->FormValue;
		$this->p_Reseller->CurrentValue = $this->p_Reseller->FormValue;
		$this->p_CClass->CurrentValue = $this->p_CClass->FormValue;
		$this->x_DirCorreo->CurrentValue = $this->x_DirCorreo->FormValue;
		$this->x_Titulo->CurrentValue = $this->x_Titulo->FormValue;
		$this->x_Mensaje->CurrentValue = $this->x_Mensaje->FormValue;
		$this->f_Ult_Mod->CurrentValue = $this->f_Ult_Mod->FormValue;
		$this->f_Ult_Mod->CurrentValue = ew_UnFormatDateTime($this->f_Ult_Mod->CurrentValue, 7);
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
		$this->c_IConfig->setDbValue($rs->fields('c_IConfig'));
		$this->c_IReporte->setDbValue($rs->fields('c_IReporte'));
		$this->frec_Envio->setDbValue($rs->fields('frec_Envio'));
		$this->i_Dia_Envio->setDbValue($rs->fields('i_Dia_Envio'));
		$this->x_Hora_Envio->setDbValue($rs->fields('x_Hora_Envio'));
		$this->p_Destino->setDbValue($rs->fields('p_Destino'));
		$this->p_Reseller->setDbValue($rs->fields('p_Reseller'));
		$this->p_CClass->setDbValue($rs->fields('p_CClass'));
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
		$this->c_IConfig->DbValue = $row['c_IConfig'];
		$this->c_IReporte->DbValue = $row['c_IReporte'];
		$this->frec_Envio->DbValue = $row['frec_Envio'];
		$this->i_Dia_Envio->DbValue = $row['i_Dia_Envio'];
		$this->x_Hora_Envio->DbValue = $row['x_Hora_Envio'];
		$this->p_Destino->DbValue = $row['p_Destino'];
		$this->p_Reseller->DbValue = $row['p_Reseller'];
		$this->p_CClass->DbValue = $row['p_CClass'];
		$this->x_DirCorreo->DbValue = $row['x_DirCorreo'];
		$this->x_Titulo->DbValue = $row['x_Titulo'];
		$this->x_Mensaje->DbValue = $row['x_Mensaje'];
		$this->f_Ult_Mod->DbValue = $row['f_Ult_Mod'];
		$this->c_Usuario_Ult_Mod->DbValue = $row['c_Usuario_Ult_Mod'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("c_IConfig")) <> "")
			$this->c_IConfig->CurrentValue = $this->getKey("c_IConfig"); // c_IConfig
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
		// c_IConfig
		// c_IReporte
		// frec_Envio
		// i_Dia_Envio
		// x_Hora_Envio
		// p_Destino
		// p_Reseller
		// p_CClass
		// x_DirCorreo
		// x_Titulo
		// x_Mensaje
		// f_Ult_Mod
		// c_Usuario_Ult_Mod

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// c_IConfig
			$this->c_IConfig->ViewValue = $this->c_IConfig->CurrentValue;
			$this->c_IConfig->ViewCustomAttributes = "";

			// c_IReporte
			if (strval($this->c_IReporte->CurrentValue) <> "") {
				$sFilterWrk = "`c_IReporte`" . ew_SearchString("=", $this->c_IReporte->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `c_IReporte`, `x_NbReporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_reportes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IReporte, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->c_IReporte->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->c_IReporte->ViewValue = $this->c_IReporte->CurrentValue;
				}
			} else {
				$this->c_IReporte->ViewValue = NULL;
			}
			$this->c_IReporte->ViewCustomAttributes = "";

			// frec_Envio
			if (strval($this->frec_Envio->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->frec_Envio->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_FREC_ENVIO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->frec_Envio, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->frec_Envio->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->frec_Envio->ViewValue = $this->frec_Envio->CurrentValue;
				}
			} else {
				$this->frec_Envio->ViewValue = NULL;
			}
			$this->frec_Envio->ViewCustomAttributes = "";

			// i_Dia_Envio
			if (strval($this->i_Dia_Envio->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->i_Dia_Envio->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_DIA_ENVIO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Dia_Envio, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->i_Dia_Envio->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->i_Dia_Envio->ViewValue = $this->i_Dia_Envio->CurrentValue;
				}
			} else {
				$this->i_Dia_Envio->ViewValue = NULL;
			}
			$this->i_Dia_Envio->ViewCustomAttributes = "";

			// x_Hora_Envio
			$this->x_Hora_Envio->ViewValue = $this->x_Hora_Envio->CurrentValue;
			$this->x_Hora_Envio->ViewCustomAttributes = "";

			// p_Destino
			if (strval($this->p_Destino->CurrentValue) <> "") {
				$sFilterWrk = "`rv_Low_Value`" . ew_SearchString("=", $this->p_Destino->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_PARREP_DESTINO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_Destino, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->p_Destino->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->p_Destino->ViewValue = $this->p_Destino->CurrentValue;
				}
			} else {
				$this->p_Destino->ViewValue = NULL;
			}
			$this->p_Destino->ViewCustomAttributes = "";

			// p_Reseller
			if (strval($this->p_Reseller->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->p_Reseller->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_Reseller, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->p_Reseller->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->p_Reseller->ViewValue = $this->p_Reseller->CurrentValue;
				}
			} else {
				$this->p_Reseller->ViewValue = NULL;
			}
			$this->p_Reseller->ViewCustomAttributes = "";

			// p_CClass
			if (strval($this->p_CClass->CurrentValue) <> "") {
				$sFilterWrk = "`c_Usuario`" . ew_SearchString("=", $this->p_CClass->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_CClass, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->p_CClass->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->p_CClass->ViewValue = $this->p_CClass->CurrentValue;
				}
			} else {
				$this->p_CClass->ViewValue = NULL;
			}
			$this->p_CClass->ViewCustomAttributes = "";

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
			$this->f_Ult_Mod->ViewValue = ew_FormatDateTime($this->f_Ult_Mod->ViewValue, 7);
			$this->f_Ult_Mod->ViewCustomAttributes = "";

			// c_Usuario_Ult_Mod
			$this->c_Usuario_Ult_Mod->ViewValue = $this->c_Usuario_Ult_Mod->CurrentValue;
			$this->c_Usuario_Ult_Mod->ViewCustomAttributes = "";

			// c_IConfig
			$this->c_IConfig->LinkCustomAttributes = "";
			$this->c_IConfig->HrefValue = "";
			$this->c_IConfig->TooltipValue = "";

			// c_IReporte
			$this->c_IReporte->LinkCustomAttributes = "";
			$this->c_IReporte->HrefValue = "";
			$this->c_IReporte->TooltipValue = "";

			// frec_Envio
			$this->frec_Envio->LinkCustomAttributes = "";
			$this->frec_Envio->HrefValue = "";
			$this->frec_Envio->TooltipValue = "";

			// i_Dia_Envio
			$this->i_Dia_Envio->LinkCustomAttributes = "";
			$this->i_Dia_Envio->HrefValue = "";
			$this->i_Dia_Envio->TooltipValue = "";

			// x_Hora_Envio
			$this->x_Hora_Envio->LinkCustomAttributes = "";
			$this->x_Hora_Envio->HrefValue = "";
			$this->x_Hora_Envio->TooltipValue = "";

			// p_Destino
			$this->p_Destino->LinkCustomAttributes = "";
			$this->p_Destino->HrefValue = "";
			$this->p_Destino->TooltipValue = "";

			// p_Reseller
			$this->p_Reseller->LinkCustomAttributes = "";
			$this->p_Reseller->HrefValue = "";
			$this->p_Reseller->TooltipValue = "";

			// p_CClass
			$this->p_CClass->LinkCustomAttributes = "";
			$this->p_CClass->HrefValue = "";
			$this->p_CClass->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// c_IConfig
			$this->c_IConfig->EditCustomAttributes = "";
			$this->c_IConfig->EditValue = ew_HtmlEncode($this->c_IConfig->CurrentValue);
			$this->c_IConfig->PlaceHolder = ew_RemoveHtml($this->c_IConfig->FldCaption());

			// c_IReporte
			$this->c_IReporte->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_IReporte`, `x_NbReporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_reportes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->c_IReporte, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->c_IReporte->EditValue = $arwrk;

			// frec_Envio
			$this->frec_Envio->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_FREC_ENVIO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->frec_Envio, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->frec_Envio->EditValue = $arwrk;

			// i_Dia_Envio
			$this->i_Dia_Envio->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_DIA_ENVIO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->i_Dia_Envio, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->i_Dia_Envio->EditValue = $arwrk;

			// x_Hora_Envio
			$this->x_Hora_Envio->EditCustomAttributes = "";
			$this->x_Hora_Envio->EditValue = ew_HtmlEncode($this->x_Hora_Envio->CurrentValue);
			$this->x_Hora_Envio->PlaceHolder = ew_RemoveHtml($this->x_Hora_Envio->FldCaption());

			// p_Destino
			$this->p_Destino->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `rv_Low_Value`, `rv_Meaning` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_dominios`";
			$sWhereWrk = "";
			$lookuptblfilter = "`rv_Domain` = 'DNIO_PARREP_DESTINO'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_Destino, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->p_Destino->EditValue = $arwrk;

			// p_Reseller
			$this->p_Reseller->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_Reseller, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->p_Reseller->EditValue = $arwrk;

			// p_CClass
			$this->p_CClass->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `c_Usuario`, `c_Usuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `af_usuarios`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->p_CClass, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->p_CClass->EditValue = $arwrk;

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
			// c_IConfig

			$this->c_IConfig->HrefValue = "";

			// c_IReporte
			$this->c_IReporte->HrefValue = "";

			// frec_Envio
			$this->frec_Envio->HrefValue = "";

			// i_Dia_Envio
			$this->i_Dia_Envio->HrefValue = "";

			// x_Hora_Envio
			$this->x_Hora_Envio->HrefValue = "";

			// p_Destino
			$this->p_Destino->HrefValue = "";

			// p_Reseller
			$this->p_Reseller->HrefValue = "";

			// p_CClass
			$this->p_CClass->HrefValue = "";

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
		if (!$this->c_IConfig->FldIsDetailKey && !is_null($this->c_IConfig->FormValue) && $this->c_IConfig->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_IConfig->FldCaption());
		}
		if (!ew_CheckInteger($this->c_IConfig->FormValue)) {
			ew_AddMessage($gsFormError, $this->c_IConfig->FldErrMsg());
		}
		if (!$this->c_IReporte->FldIsDetailKey && !is_null($this->c_IReporte->FormValue) && $this->c_IReporte->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->c_IReporte->FldCaption());
		}
		if (!$this->frec_Envio->FldIsDetailKey && !is_null($this->frec_Envio->FormValue) && $this->frec_Envio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->frec_Envio->FldCaption());
		}
		if (!$this->i_Dia_Envio->FldIsDetailKey && !is_null($this->i_Dia_Envio->FormValue) && $this->i_Dia_Envio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->i_Dia_Envio->FldCaption());
		}
		if (!$this->x_Hora_Envio->FldIsDetailKey && !is_null($this->x_Hora_Envio->FormValue) && $this->x_Hora_Envio->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->x_Hora_Envio->FldCaption());
		}
		if (!$this->p_Destino->FldIsDetailKey && !is_null($this->p_Destino->FormValue) && $this->p_Destino->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->p_Destino->FldCaption());
		}
		if (!$this->p_Reseller->FldIsDetailKey && !is_null($this->p_Reseller->FormValue) && $this->p_Reseller->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->p_Reseller->FldCaption());
		}
		if (!$this->p_CClass->FldIsDetailKey && !is_null($this->p_CClass->FormValue) && $this->p_CClass->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->p_CClass->FldCaption());
		}
		if (!$this->x_DirCorreo->FldIsDetailKey && !is_null($this->x_DirCorreo->FormValue) && $this->x_DirCorreo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->x_DirCorreo->FldCaption());
		}
		if (!$this->x_Titulo->FldIsDetailKey && !is_null($this->x_Titulo->FormValue) && $this->x_Titulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->x_Titulo->FldCaption());
		}
		if (!$this->x_Mensaje->FldIsDetailKey && !is_null($this->x_Mensaje->FormValue) && $this->x_Mensaje->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->x_Mensaje->FldCaption());
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

		// c_IConfig
		$this->c_IConfig->SetDbValueDef($rsnew, $this->c_IConfig->CurrentValue, 0, FALSE);

		// c_IReporte
		$this->c_IReporte->SetDbValueDef($rsnew, $this->c_IReporte->CurrentValue, 0, FALSE);

		// frec_Envio
		$this->frec_Envio->SetDbValueDef($rsnew, $this->frec_Envio->CurrentValue, 0, FALSE);

		// i_Dia_Envio
		$this->i_Dia_Envio->SetDbValueDef($rsnew, $this->i_Dia_Envio->CurrentValue, 0, FALSE);

		// x_Hora_Envio
		$this->x_Hora_Envio->SetDbValueDef($rsnew, $this->x_Hora_Envio->CurrentValue, "", FALSE);

		// p_Destino
		$this->p_Destino->SetDbValueDef($rsnew, $this->p_Destino->CurrentValue, 0, FALSE);

		// p_Reseller
		$this->p_Reseller->SetDbValueDef($rsnew, $this->p_Reseller->CurrentValue, "", FALSE);

		// p_CClass
		$this->p_CClass->SetDbValueDef($rsnew, $this->p_CClass->CurrentValue, "", FALSE);

		// x_DirCorreo
		$this->x_DirCorreo->SetDbValueDef($rsnew, $this->x_DirCorreo->CurrentValue, "", FALSE);

		// x_Titulo
		$this->x_Titulo->SetDbValueDef($rsnew, $this->x_Titulo->CurrentValue, "", FALSE);

		// x_Mensaje
		$this->x_Mensaje->SetDbValueDef($rsnew, $this->x_Mensaje->CurrentValue, "", FALSE);

		// f_Ult_Mod
		$this->f_Ult_Mod->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['f_Ult_Mod'] = &$this->f_Ult_Mod->DbValue;

		// c_Usuario_Ult_Mod
		$this->c_Usuario_Ult_Mod->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['c_Usuario_Ult_Mod'] = &$this->c_Usuario_Ult_Mod->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->c_IConfig->CurrentValue == "" && $this->c_IConfig->getSessionValue() == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, "af_config_reporteslist.php", $this->TableVar, TRUE);
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
if (!isset($af_config_reportes_add)) $af_config_reportes_add = new caf_config_reportes_add();

// Page init
$af_config_reportes_add->Page_Init();

// Page main
$af_config_reportes_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$af_config_reportes_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var af_config_reportes_add = new ew_Page("af_config_reportes_add");
af_config_reportes_add.PageID = "add"; // Page ID
var EW_PAGE_ID = af_config_reportes_add.PageID; // For backward compatibility

// Form object
var faf_config_reportesadd = new ew_Form("faf_config_reportesadd");

// Validate form
faf_config_reportesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_c_IConfig");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->c_IConfig->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_c_IConfig");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($af_config_reportes->c_IConfig->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_c_IReporte");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->c_IReporte->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_frec_Envio");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->frec_Envio->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_i_Dia_Envio");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->i_Dia_Envio->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_x_Hora_Envio");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->x_Hora_Envio->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_p_Destino");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->p_Destino->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_p_Reseller");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->p_Reseller->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_p_CClass");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->p_CClass->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_x_DirCorreo");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->x_DirCorreo->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_x_Titulo");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->x_Titulo->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_x_Mensaje");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($af_config_reportes->x_Mensaje->FldCaption()) ?>");

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
faf_config_reportesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faf_config_reportesadd.ValidateRequired = true;
<?php } else { ?>
faf_config_reportesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faf_config_reportesadd.Lists["x_c_IReporte"] = {"LinkField":"x_c_IReporte","Ajax":null,"AutoFill":false,"DisplayFields":["x_x_NbReporte","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_config_reportesadd.Lists["x_frec_Envio"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_config_reportesadd.Lists["x_i_Dia_Envio"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_config_reportesadd.Lists["x_p_Destino"] = {"LinkField":"x_rv_Low_Value","Ajax":null,"AutoFill":false,"DisplayFields":["x_rv_Meaning","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_config_reportesadd.Lists["x_p_Reseller"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
faf_config_reportesadd.Lists["x_p_CClass"] = {"LinkField":"x_c_Usuario","Ajax":null,"AutoFill":false,"DisplayFields":["x_c_Usuario","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $af_config_reportes_add->ShowPageHeader(); ?>
<?php
$af_config_reportes_add->ShowMessage();
?>
<form name="faf_config_reportesadd" id="faf_config_reportesadd" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="af_config_reportes">
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewGrid"><tr><td>
<table id="tbl_af_config_reportesadd" class="table table-bordered table-striped">
<?php if ($af_config_reportes->c_IConfig->Visible) { // c_IConfig ?>
	<tr id="r_c_IConfig">
		<td><span id="elh_af_config_reportes_c_IConfig"><?php echo $af_config_reportes->c_IConfig->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->c_IConfig->CellAttributes() ?>>
<span id="el_af_config_reportes_c_IConfig" class="control-group">
<input type="text" data-field="x_c_IConfig" name="x_c_IConfig" id="x_c_IConfig" size="30" placeholder="<?php echo ew_HtmlEncode($af_config_reportes->c_IConfig->PlaceHolder) ?>" value="<?php echo $af_config_reportes->c_IConfig->EditValue ?>"<?php echo $af_config_reportes->c_IConfig->EditAttributes() ?>>
</span>
<?php echo $af_config_reportes->c_IConfig->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->c_IReporte->Visible) { // c_IReporte ?>
	<tr id="r_c_IReporte">
		<td><span id="elh_af_config_reportes_c_IReporte"><?php echo $af_config_reportes->c_IReporte->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->c_IReporte->CellAttributes() ?>>
<span id="el_af_config_reportes_c_IReporte" class="control-group">
<select data-field="x_c_IReporte" id="x_c_IReporte" name="x_c_IReporte"<?php echo $af_config_reportes->c_IReporte->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->c_IReporte->EditValue)) {
	$arwrk = $af_config_reportes->c_IReporte->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->c_IReporte->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_c_IReporte"].Options = <?php echo (is_array($af_config_reportes->c_IReporte->EditValue)) ? ew_ArrayToJson($af_config_reportes->c_IReporte->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->c_IReporte->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->frec_Envio->Visible) { // frec_Envio ?>
	<tr id="r_frec_Envio">
		<td><span id="elh_af_config_reportes_frec_Envio"><?php echo $af_config_reportes->frec_Envio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->frec_Envio->CellAttributes() ?>>
<span id="el_af_config_reportes_frec_Envio" class="control-group">
<select data-field="x_frec_Envio" id="x_frec_Envio" name="x_frec_Envio"<?php echo $af_config_reportes->frec_Envio->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->frec_Envio->EditValue)) {
	$arwrk = $af_config_reportes->frec_Envio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->frec_Envio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_frec_Envio"].Options = <?php echo (is_array($af_config_reportes->frec_Envio->EditValue)) ? ew_ArrayToJson($af_config_reportes->frec_Envio->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->frec_Envio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->i_Dia_Envio->Visible) { // i_Dia_Envio ?>
	<tr id="r_i_Dia_Envio">
		<td><span id="elh_af_config_reportes_i_Dia_Envio"><?php echo $af_config_reportes->i_Dia_Envio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->i_Dia_Envio->CellAttributes() ?>>
<span id="el_af_config_reportes_i_Dia_Envio" class="control-group">
<select data-field="x_i_Dia_Envio" id="x_i_Dia_Envio" name="x_i_Dia_Envio"<?php echo $af_config_reportes->i_Dia_Envio->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->i_Dia_Envio->EditValue)) {
	$arwrk = $af_config_reportes->i_Dia_Envio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->i_Dia_Envio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_i_Dia_Envio"].Options = <?php echo (is_array($af_config_reportes->i_Dia_Envio->EditValue)) ? ew_ArrayToJson($af_config_reportes->i_Dia_Envio->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->i_Dia_Envio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->x_Hora_Envio->Visible) { // x_Hora_Envio ?>
	<tr id="r_x_Hora_Envio">
		<td><span id="elh_af_config_reportes_x_Hora_Envio"><?php echo $af_config_reportes->x_Hora_Envio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->x_Hora_Envio->CellAttributes() ?>>
<span id="el_af_config_reportes_x_Hora_Envio" class="control-group">
<input type="text" data-field="x_x_Hora_Envio" name="x_x_Hora_Envio" id="x_x_Hora_Envio" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($af_config_reportes->x_Hora_Envio->PlaceHolder) ?>" value="<?php echo $af_config_reportes->x_Hora_Envio->EditValue ?>"<?php echo $af_config_reportes->x_Hora_Envio->EditAttributes() ?>>
</span>
<?php echo $af_config_reportes->x_Hora_Envio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->p_Destino->Visible) { // p_Destino ?>
	<tr id="r_p_Destino">
		<td><span id="elh_af_config_reportes_p_Destino"><?php echo $af_config_reportes->p_Destino->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->p_Destino->CellAttributes() ?>>
<span id="el_af_config_reportes_p_Destino" class="control-group">
<select data-field="x_p_Destino" id="x_p_Destino" name="x_p_Destino"<?php echo $af_config_reportes->p_Destino->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->p_Destino->EditValue)) {
	$arwrk = $af_config_reportes->p_Destino->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->p_Destino->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_p_Destino"].Options = <?php echo (is_array($af_config_reportes->p_Destino->EditValue)) ? ew_ArrayToJson($af_config_reportes->p_Destino->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->p_Destino->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->p_Reseller->Visible) { // p_Reseller ?>
	<tr id="r_p_Reseller">
		<td><span id="elh_af_config_reportes_p_Reseller"><?php echo $af_config_reportes->p_Reseller->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->p_Reseller->CellAttributes() ?>>
<span id="el_af_config_reportes_p_Reseller" class="control-group">
<select data-field="x_p_Reseller" id="x_p_Reseller" name="x_p_Reseller"<?php echo $af_config_reportes->p_Reseller->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->p_Reseller->EditValue)) {
	$arwrk = $af_config_reportes->p_Reseller->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->p_Reseller->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_p_Reseller"].Options = <?php echo (is_array($af_config_reportes->p_Reseller->EditValue)) ? ew_ArrayToJson($af_config_reportes->p_Reseller->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->p_Reseller->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->p_CClass->Visible) { // p_CClass ?>
	<tr id="r_p_CClass">
		<td><span id="elh_af_config_reportes_p_CClass"><?php echo $af_config_reportes->p_CClass->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->p_CClass->CellAttributes() ?>>
<span id="el_af_config_reportes_p_CClass" class="control-group">
<select data-field="x_p_CClass" id="x_p_CClass" name="x_p_CClass"<?php echo $af_config_reportes->p_CClass->EditAttributes() ?>>
<?php
if (is_array($af_config_reportes->p_CClass->EditValue)) {
	$arwrk = $af_config_reportes->p_CClass->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($af_config_reportes->p_CClass->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
faf_config_reportesadd.Lists["x_p_CClass"].Options = <?php echo (is_array($af_config_reportes->p_CClass->EditValue)) ? ew_ArrayToJson($af_config_reportes->p_CClass->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $af_config_reportes->p_CClass->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->x_DirCorreo->Visible) { // x_DirCorreo ?>
	<tr id="r_x_DirCorreo">
		<td><span id="elh_af_config_reportes_x_DirCorreo"><?php echo $af_config_reportes->x_DirCorreo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->x_DirCorreo->CellAttributes() ?>>
<span id="el_af_config_reportes_x_DirCorreo" class="control-group">
<input type="text" data-field="x_x_DirCorreo" name="x_x_DirCorreo" id="x_x_DirCorreo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($af_config_reportes->x_DirCorreo->PlaceHolder) ?>" value="<?php echo $af_config_reportes->x_DirCorreo->EditValue ?>"<?php echo $af_config_reportes->x_DirCorreo->EditAttributes() ?>>
</span>
<?php echo $af_config_reportes->x_DirCorreo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->x_Titulo->Visible) { // x_Titulo ?>
	<tr id="r_x_Titulo">
		<td><span id="elh_af_config_reportes_x_Titulo"><?php echo $af_config_reportes->x_Titulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->x_Titulo->CellAttributes() ?>>
<span id="el_af_config_reportes_x_Titulo" class="control-group">
<input type="text" data-field="x_x_Titulo" name="x_x_Titulo" id="x_x_Titulo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($af_config_reportes->x_Titulo->PlaceHolder) ?>" value="<?php echo $af_config_reportes->x_Titulo->EditValue ?>"<?php echo $af_config_reportes->x_Titulo->EditAttributes() ?>>
</span>
<?php echo $af_config_reportes->x_Titulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($af_config_reportes->x_Mensaje->Visible) { // x_Mensaje ?>
	<tr id="r_x_Mensaje">
		<td><span id="elh_af_config_reportes_x_Mensaje"><?php echo $af_config_reportes->x_Mensaje->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $af_config_reportes->x_Mensaje->CellAttributes() ?>>
<span id="el_af_config_reportes_x_Mensaje" class="control-group">
<textarea data-field="x_x_Mensaje" name="x_x_Mensaje" id="x_x_Mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($af_config_reportes->x_Mensaje->PlaceHolder) ?>"<?php echo $af_config_reportes->x_Mensaje->EditAttributes() ?>><?php echo $af_config_reportes->x_Mensaje->EditValue ?></textarea>
</span>
<?php echo $af_config_reportes->x_Mensaje->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
faf_config_reportesadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$af_config_reportes_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$af_config_reportes_add->Page_Terminate();
?>
