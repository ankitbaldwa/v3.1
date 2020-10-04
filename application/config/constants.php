<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('LOGIN_PROCESS','login-action');
define('LOGIN','login');
define('LOGOUT','logout');
define('DASHBOARD','dashboard');
define('PROFILE','profile');
define('PROFILE_ACTION','profile-action');
define('CHANGEPASSWORD','changepassword');
define('CHANGEPASSWORD_ACTION','changepassword-action');
define('CHECKCORRECTPASSWORD','check-password');
define('USERS','users');
define('USER_AJAX','user-ajax');
define('USER_ADD','user-add');
define('USER_UPDATE','user-update');
define('PRODUCTS','products');
define('PRODUCTS_AJAX','products-ajax');
define('PRODUCTS_ADD','products-add');
define('PRODUCTS_ADD_ACTION','products-add-action');
define('PRODUCTS_UPDATE','products-update');
define('PRODUCTS_UPDATE_ACTION','products-update-action');
define('SETTINGS','settings');
define('SETTINGS_UPDATE','settings-update');
define('SETTINGS_UPDATE_ACTION','setting-update-action');
define('GSTIN_AJAX', 'gstin-ajax');
define('TAXES','taxes');
define('BANK_DETAILS','bank-details');
define('TAXES_UPDATE','Taxes-update');
define('UPDATE_BANK_DETAILS','bank-details-update');
define('VOUCHER','voucher');
define('VOUCHER_AJAX','voucher-ajax');
define('VOUCHER_ADD','voucher-add');
define('VOUCHER_ADD_ACTION','voucher-add-action');
define('VOUCHER_PRINT','voucher-print');
define('VOUCHER_NO','voucher-no');
define('CUSTOMERS','customers');
define('CUSTOMERS_AJAX','customers-ajax');
define('CUSTOMERS_INVOICE_AJAX','customers-invoice-ajax');
define('CUSTOMERS_ADD','customers-add');
define('CUSTOMERS_ADD_ACTION','customer-add-action');
define('CUSTOMERS_COUNTRIES','customers-countries');
define('CUSTOMERS_STATES','customers-states');
define('CUSTOMERS_CITIES','customers-cities');
define('CUSTOMERS_UPDATE','customers-update');
define('CUSTOMER_UPDATE_ACTION','customers-update-action');
define('CUSTOMERS_VIEW','customers-view');
define('CUSTOMERS_PAYMENTS','customers-payments');
define('CUSTOMER_PAYMENTS_ACTION','customers-payments-actions');
define('INVOICES','invoices');
define('INVOICES_AJAX','invoices-ajax');
define('INVOICES_PRODUCT_AJAX','invoices-product-ajax');
define('INVOICES_ADD','invoices-add');
define('INVOICES_ADD_ACTION','invoice-add-action');
define('INVOICES_VIEW','invoices-view');
define('INVOICES_CANCEL','invoices-cancel');
define('INVOICES_PAYMENT','invoices-payment');
define('INVOICES_PAYMENT_RECEIPT','invoices-payment-receipt');
define('INVOICES_PAYMENT_RECEIPT_PDF','invoices-payment-receipt-pdf');
define('INVOICES_PAYMENT_ADD','invoices-payment-add');
define('INVOICES_PAYMENT_ADD_ACTION','invoices-payment-add-action');
define('INVOICES_PAYMENT_AJAX','invoices-payment-ajax');
define('INVOICES_PRINT','invoices-print');
define('INVOICES_PDF','invoices-pdf');
define('SUPPLIERS','suppliers');
define('SUPPLIERS_AJAX','suppliers-ajax');
define('SUPPLIERS_INVOICE_AJAX','suppliers-invoice-ajax');
define('SUPPLIERS_ADD','suppliers-add');
define('SUPPLIERS_ADD_ACTION','suppliers-add-action');
define('SUPPLIERS_COUNTRIES','suppliers-countries');
define('SUPPLIERS_STATES','suppliers-states');
define('SUPPLIERS_CITIES','suppliers-cities');
define('SUPPLIERS_UPDATE','suppliers-update');
define('SUPPLIERS_UPDATE_ACTION','suppliers-update-action');
define('SUPPLIERS_VIEW','suppliers-view');
define('SUPPLIERS_GSTIN','suppliers-gstin');
define('CUSTOMER_GSTIN','customer-gstin');
define('PURCHASE','purchase');
define('PURCHASE_AJAX','purchase-ajax');
define('PURCHASE_PRODUCT_AJAX','purchase-product-ajax');
define('PURCHASE_ADD','purchase-add');
define('PURCHASE_ADD_ACTION','purchase-add-action');
define('PURCHASE_VIEW','purchase-view');
define('PURCHASE_PAYMENT','purchase-payment');
define('PURCHASE_PAYMENT_RECEIPT','purchase-payment-receipt');
define('PURCHASE_PAYMENT_RECEIPT_PDF','purchase-payment-receipt-pdf');
define('PURCHASE_PAYMENT_ADD','purchase-payment-add');
define('PURCHASE_PAYMENT_ADD_ACTION','purchase-payment-add-action');
define('PURCHASE_PAYMENT_AJAX','purchase-payment-ajax');
define('PURCHASE_PRINT','purchase-print');
define('PURCHASE_PDF','purchase-pdf');
//Sales Report
define('CUSTOMER_REPORT','customer-report');
define('CUSTOMER_REPORT_AJAX','customer-report-ajax');
define('CUSTOMER_REPORT_EXCEL','customer-report-excel');
define('GST_REPORT','gst-report');
define('GST_REPORT_EXCEL','gst-report-excel');
define('GST_REPORT_AJAX','gst-report-ajax');
define('GET_MONTHS','get-months');
define('MONTHLY_REPORT','monthly-report');
define('MONTHLY_REPORT_AJAX','monthly-report-ajax');
define('MONTHLY_REPORT_EXCEL','monthly-report-excel');
define('OUTSTANDING_REPORT','outstanding-report');
define('OUTSTANDING_REPORT_AJAX','outstanding-report-ajax');
define('OUTSTANDING_REPORT_EXCEL','outstanding-report-excel');
define('PAYMENT_REPORT','payment-report');
define('PAYMENT_REPORT_AJAX','payment-report-ajax');
define('PAYMENT_REPORT_EXCEL','payment-report-excel');
//Purchase Report
define('SUPPLIERS_REPORT','suppliers-report');
define('SUPPLIERS_REPORT_AJAX','suppliers-report-ajax');
define('SUPPLIERS_REPORT_EXCEL','suppliers-report-excel');
define('PURCHASE_GST_REPORT','purchase-gst-report');
define('PURCHASE_GST_REPORT_EXCEL','purchase-gst-report-excel');
define('PURCHASE_GST_REPORT_AJAX','purchase-gst-report-ajax');
define('MONTHLY_PURCHASE_REPORT','monthly-purchase-report');
define('MONTHLY_PURCHASE_REPORT_AJAX','monthly-purchase-report-ajax');
define('MONTHLY_PURCHASE_REPORT_EXCEL','monthly-purchase-report-excel');
define('PURCHASE_OUTSTANDING_REPORT','purchase-outstanding-report');
define('PURCHASE_OUTSTANDING_REPORT_AJAX','purchase-outstanding-report-ajax');
define('PURCHASE_OUTSTANDING_REPORT_EXCEL','purchase-outstanding-report-excel');
define('PURCHASE_PAYMENT_REPORT','purchase-payment-report');
define('PURCHASE_PAYMENT_REPORT_AJAX','purchase-payment-report-ajax');
define('PURCHASE_PAYMENT_REPORT_EXCEL','purchase-payment-report-excel');
define('SEND_MAIL', 'send-mail');
define('INV_MAIL','invoice-email');
define('PRODUCTION',($_SERVER['HTTP_HOST'] == 'localhost')?'development':$_SERVER['HTTP_HOST']);
define('UPLOAD_WAYBILL_PDF','upload-waybill-pdf');
define('TITLE','ACCORDANCE');
define('BODY_CLASS','hold-transition skin-blue sidebar-mini fixed layout-fixed');
define('MAINTANCE', false);
define('RELEASE_NOTES','release-notes');