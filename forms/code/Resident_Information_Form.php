<?PHP
/*
Simfatic Forms Main Form processor script

This script does all the server side processing. 
(Displaying the form, processing form submissions,
displaying errors, making CAPTCHA image, and so on.) 

All pages (including the form page) are displayed using 
templates in the 'templ' sub folder. 

The overall structure is that of a list of modules. Depending on the 
arguments (POST/GET) passed to the script, the modules process in sequence. 

Please note that just appending  a header and footer to this script won't work.
To embed the form, use the 'Copy & Paste' code in the 'Take the Code' page. 
To extend the functionality, see 'Extension Modules' in the help.

*/

@ini_set("display_errors", 1);//the error handler is added later in FormProc
error_reporting(E_ALL);

require_once(dirname(__FILE__)."/includes/Resident_Information_Form-lib.php");
$formproc_obj =  new SFM_FormProcessor('Resident_Information_Form');
$formproc_obj->initTimeZone('US/Central');
$formproc_obj->setFormID('56725d27-1b47-421b-a7c5-2cc306a4f4d3');
$formproc_obj->setFormKey('544eb3d5-eed5-4e96-a1b3-97c89545c4f6');
$formproc_obj->setLocale('en-US','yyyy-MM-dd');
$formproc_obj->setEmailFormatHTML(true);
$formproc_obj->EnableLogging(true);
$formproc_obj->SetErrorEmail('humistondalen@gmail.com');
$formproc_obj->SetDebugMode(false);
$formproc_obj->setIsInstalled(true);
$formproc_obj->SetPrintPreviewPage(sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_print_preview_file.txt"));
$formproc_obj->SetSingleBoxErrorDisplay(true);
$formproc_obj->setFormPage(0,sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_form_page_0.txt"));
$formproc_obj->AddElementInfo('EstablishedResidentUpdateInformation','single_chk','');
$formproc_obj->AddElementInfo('NewResidentInformation','single_chk','');
$formproc_obj->AddElementInfo('MoveIn','datepicker','');
$formproc_obj->AddElementInfo('DatePicker1','datepicker','');
$formproc_obj->AddElementInfo('Phone1','telephone','');
$formproc_obj->AddElementInfo('FirstName1','text','');
$formproc_obj->AddElementInfo('Middle1','text','');
$formproc_obj->AddElementInfo('LastName1','text','');
$formproc_obj->AddElementInfo('Last2','text','');
$formproc_obj->AddElementInfo('First2','text','');
$formproc_obj->AddElementInfo('Middle2','text','');
$formproc_obj->AddElementInfo('Phone2','telephone','');
$formproc_obj->AddElementInfo('Address','text','');
$formproc_obj->AddElementInfo('Email1','email','');
$formproc_obj->AddElementInfo('Email2','email','');
$formproc_obj->AddElementInfo('AdultsInHouse','decimal','');
$formproc_obj->AddElementInfo('ChildrenInHouse','decimal','');
$formproc_obj->AddElementInfo('Pets','multiline','');
$formproc_obj->AddElementInfo('ChildrenNames','multiline','');
$formproc_obj->AddElementInfo('Pool_volunteer','chk_group','');
$formproc_obj->AddElementInfo('ArchitecturalControlCommittee','single_chk','');
$formproc_obj->AddElementInfo('AuditCommittee','single_chk','');
$formproc_obj->AddElementInfo('NominationCommittee','single_chk','');
$formproc_obj->AddElementInfo('PoolCommittee','single_chk','');
$formproc_obj->AddElementInfo('SnowIceCommittee','single_chk','');
$formproc_obj->AddElementInfo('SpecialCommittee','single_chk','');
$formproc_obj->AddElementInfo('WebsiteCommittee','single_chk','');
$formproc_obj->AddElementInfo('NeighborhoodWatch','single_chk','');
$formproc_obj->AddDefaultValue('AdultsInHouse','0');
$formproc_obj->AddDefaultValue('ChildrenInHouse','0');
$formproc_obj->setIsInstalled(true);
$formproc_obj->setFormFileFolder('./formdata');
$formproc_obj->SetHiddenInputTrapVarName('tcebe9436a68077ee7f26');
$formproc_obj->SetFromAddress('forms@s707873718.onlinehome.us');
$page_renderer =  new FM_FormPageDisplayModule();
$formproc_obj->addModule($page_renderer);

$validator =  new FM_FormValidator();
$validator->addValidation("MoveIn","required","Please fill in MoveIn");
$validator->addValidation("DatePicker1","required","Please fill in DatePicker1");
$validator->addValidation("Phone1","required","Please fill in Phone1");
$validator->addValidation("FirstName1","required","Please fill in Homeowner1");
$validator->addValidation("Middle1","required","Please fill in Homeowner1");
$validator->addValidation("LastName1","required","Please fill in Homeowner1");
$validator->addValidation("Last2","required","Please fill in Homeowner1");
$validator->addValidation("First2","required","Please fill in Homeowner1");
$validator->addValidation("Middle2","required","Please fill in Homeowner1");
$validator->addValidation("Address","required","Please fill in Address");
$validator->addValidation("Address","alnum_s","The input for Address should be a valid alpha-numeric value");
$validator->addValidation("Email1","email","The input for  should be a valid email value");
$validator->addValidation("Email1","required","Please fill in Email1");
$validator->addValidation("Email2","email","The input for  should be a valid email value","greaterthan(AdultsInHouse,\"1\")");
$validator->addValidation("AdultsInHouse","numeric","The input for  should be a valid numeric value");
$validator->addValidation("AdultsInHouse","required","Please fill in AdultsInHouse");
$validator->addValidation("ChildrenInHouse","numeric","The input for  should be a valid numeric value");
$validator->addValidation("ChildrenInHouse","required","Please fill in ChildrenInHouse");
$validator->addValidation("Pets","required","Please fill in Pets");
$formproc_obj->addModule($validator);

$data_email_sender =  new FM_FormDataSender(sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_email_subj.txt"),sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_email_body.txt"),'');
$data_email_sender->AddToAddr('Cedar Ridge Board <board.hoa.cedar.ridge@gmail.com>');
$formproc_obj->addModule($data_email_sender);

$autoresp =  new FM_AutoResponseSender(sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_resp_subj.txt"),sfm_readfile(dirname(__FILE__)."/templ/Resident_Information_Form_resp_body.txt"));
$autoresp->SetToVariables('','Email1');
$formproc_obj->addModule($autoresp);

$page_renderer->SetFormValidator($validator);
$formproc_obj->ProcessForm();

?>