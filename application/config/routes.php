<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route[LOGIN_PROCESS] = "Welcome/user_login_process";
$route[LOGIN] = "Welcome/index";
$route[LOGOUT] = "Welcome/logout";
$route[DASHBOARD] = "Welcome/Mydashboard";
$route[PROFILE] = "Welcome/Profile";
$route[PROFILE_ACTION] = "Welcome/Profile_action";
$route[CHANGEPASSWORD] = "Welcome/Changepassword";
$route[CHANGEPASSWORD_ACTION] = "Welcome/Changepassword_action";
$route[CHECKCORRECTPASSWORD] = 'Welcome/checkCorrectPassword';
$route[USERS] = "Users/index";
$route[USER_AJAX] = "Users/ajax";
$route[USER_ADD] = "Users/create";
$route[USER_UPDATE.'/(:any)'] = "Users/Update/$1";
$route[PRODUCTS] = "Products/index";
$route[PRODUCTS_AJAX] = "Products/ajax";
$route[PRODUCTS_ADD] = "Products/create";
$route[PRODUCTS_ADD_ACTION] = "Products/create_action";
$route[PRODUCTS_UPDATE.'/(:any)'] = "Products/Update/$1";
$route[PRODUCTS_UPDATE_ACTION] = "Products/update_action";
$route[SETTINGS] = "Settings/index";
$route[SETTINGS_UPDATE.'/(:any)'] = "Settings/update/$1";
$route[SETTINGS_UPDATE_ACTION] = "Settings/update_action";
$route[GSTIN_AJAX] = "Customers/GSTIN_ajax";
$route[TAXES] = "Taxes/index";
$route[TAXES_UPDATE] = "Taxes/update";
$route[BANK_DETAILS] = "Taxes/bankDetails";
$route[UPDATE_BANK_DETAILS] = "Taxes/update_bank";
$route[VOUCHER] = "Vouchers/index";
$route[VOUCHER_AJAX] = "Vouchers/ajax";
$route[VOUCHER_ADD] = "Vouchers/create";
$route[VOUCHER_ADD_ACTION] = "Vouchers/create_action";
$route[VOUCHER_PRINT.'/(:any)'] = "Vouchers/voucher_print/$1";
$route[VOUCHER_NO.'/(:any)'] = "Vouchers/ajax_voucher_no/$1";
$route[CUSTOMERS] = "Customers/index";
$route[CUSTOMERS_AJAX] = "Customers/ajax";
$route[CUSTOMERS_INVOICE_AJAX.'/(:any)'] = "Customers/cust_ajax/$1";
$route[CUSTOMERS_ADD] = "Customers/create";
$route[CUSTOMERS_ADD_ACTION] = "Customers/create_action";
$route[CUSTOMERS_COUNTRIES] = "Customers/countries";
$route[CUSTOMERS_STATES] = "Customers/states";
$route[CUSTOMERS_CITIES] = "Customers/cities";
$route[CUSTOMERS_UPDATE.'/(:any)'] = "Customers/Update/$1";
$route[CUSTOMER_UPDATE_ACTION] = "Customers/update_action";
$route[CUSTOMERS_VIEW.'/(:any)'] = "Customers/View/$1";
$route[CUSTOMERS_PAYMENTS.'/(:any)'] = "Customers/Payments/$1";
$route[CUSTOMER_PAYMENTS_ACTION] = "Customers/Payments_action";
$route[INVOICES] = "Invoices/index";
$route[INVOICES_AJAX] = "Invoices/ajax";
$route[INVOICES_PRODUCT_AJAX] = "Invoices/get_Products";
$route[INVOICES_ADD] = "Invoices/create";
$route[INVOICES_ADD_ACTION]="Invoices/create_action";
$route[INVOICES_VIEW.'/(:any)'] = "Invoices/view/$1";
$route[INVOICES_CANCEL.'/(:any)'] = "Invoices/Inv_cancel/$1";
$route[INVOICES_PAYMENT.'/(:any)'] = "Invoices/payments/$1";
$route[INVOICES_PAYMENT_RECEIPT.'/(:any)'] = "Invoices/receipt/$1";
$route[INVOICES_PAYMENT_RECEIPT_PDF.'/(:any)'] = "Invoices/receipt_pdf/$1";
$route[INVOICES_PAYMENT_ADD.'/(:any)'] = "Invoices/payments_add/$1";
$route[INVOICES_PAYMENT_ADD_ACTION.'/(:any)'] = "Invoices/payment_action/$1";
$route[INVOICES_PAYMENT_AJAX.'/(:any)'] = "Invoices/payment_ajax/$1";
$route[INVOICES_PRINT.'/(:any)'] = "Invoices/Inv_print/$1";
$route[INVOICES_PDF.'/(:any)'] = "Invoices/Inv_pdf/$1";
$route[SUPPLIERS] = "Suppliers/index";
$route[SUPPLIERS_AJAX] = "Suppliers/ajax";
$route[SUPPLIERS_INVOICE_AJAX.'/(:any)'] = "Suppliers/cust_ajax/$1";
$route[SUPPLIERS_ADD] = "Suppliers/create";
$route[SUPPLIERS_ADD_ACTION] = "Suppliers/create_action";
$route[SUPPLIERS_COUNTRIES] = "Suppliers/countries";
$route[SUPPLIERS_STATES] = "Suppliers/states";
$route[SUPPLIERS_CITIES] = "Suppliers/cities";
$route[SUPPLIERS_UPDATE.'/(:any)'] = "Suppliers/Update/$1";
$route[SUPPLIERS_UPDATE_ACTION] = "Suppliers/update_action";
$route[SUPPLIERS_VIEW.'/(:any)'] = "Suppliers/View/$1";
$route[SUPPLIERS_GSTIN] = "Suppliers/Get_GSTIN";
$route[CUSTOMER_GSTIN] ="Invoices/Get_GSTIN";
$route[PURCHASE] = "Purchase/index";
$route[PURCHASE_AJAX] = "Purchase/ajax";
$route[PURCHASE_PRODUCT_AJAX] = "Purchase/get_Products";
$route[PURCHASE_ADD] = "Purchase/create";
$route[PURCHASE_ADD_ACTION]="Purchase/create_action";
$route[PURCHASE_VIEW.'/(:any)'] = "Purchase/view/$1";
$route[PURCHASE_PAYMENT.'/(:any)'] = "Purchase/payments/$1";
$route[PURCHASE_PAYMENT_RECEIPT.'/(:any)'] = "Purchase/receipt/$1";
$route[PURCHASE_PAYMENT_RECEIPT_PDF.'/(:any)'] = "Purchase/receipt_pdf/$1";
$route[PURCHASE_PAYMENT_ADD.'/(:any)'] = "Purchase/payments_add/$1";
$route[PURCHASE_PAYMENT_ADD_ACTION.'/(:any)'] = "Purchase/payment_action/$1";
$route[PURCHASE_PAYMENT_AJAX.'/(:any)'] = "Purchase/payment_ajax/$1";
$route[PURCHASE_PRINT.'/(:any)'] = "Purchase/Inv_print/$1";
$route[PURCHASE_PDF.'/(:any)'] = "Purchase/Inv_pdf/$1";
//Sales Reports
$route[CUSTOMER_REPORT] = "Reports/customerReport";
$route[CUSTOMER_REPORT_AJAX] = "Reports/customerReport_ajax";
$route[CUSTOMER_REPORT_EXCEL] = "Reports/customerReport_excel";
$route[GST_REPORT] = "Reports/gstReport";
$route[GST_REPORT_EXCEL] = "Reports/gstReportExcel";
$route[GST_REPORT_AJAX] = "Reports/gstReport_ajax";
$route[MONTHLY_REPORT] = "Reports/monthlyReport";
$route[MONTHLY_REPORT_AJAX] = 'Reports/monthlyReport_ajax';
$route[MONTHLY_REPORT_EXCEL] = 'Reports/monthlyReportExcel';
$route[OUTSTANDING_REPORT] = "Reports/outstandingReport";
$route[GET_MONTHS] = "Reports/get_months";
$route[OUTSTANDING_REPORT_AJAX] = 'Reports/outstandingReport_ajax';
$route[OUTSTANDING_REPORT_EXCEL] = 'Reports/outstandingReportExcel';
$route[PAYMENT_REPORT] = "Reports/paymentReport";
$route[PAYMENT_REPORT_AJAX] = 'Reports/paymentReport_ajax';
$route[PAYMENT_REPORT_EXCEL] = 'Reports/paymentReport_excel';
//Purchase Reports
$route[SUPPLIERS_REPORT] = "Purchase_Reports/supplierReport";
$route[SUPPLIERS_REPORT_AJAX] = "Purchase_Reports/supplierReport_ajax";
$route[SUPPLIERS_REPORT_EXCEL] = "Purchase_Reports/supplierReport_excel";
$route[PURCHASE_GST_REPORT] = "Purchase_Reports/gstReport";
$route[PURCHASE_GST_REPORT_EXCEL] = "Purchase_Reports/gstReportExcel";
$route[PURCHASE_GST_REPORT_AJAX] = "Purchase_Reports/gstReport_ajax";
$route[MONTHLY_PURCHASE_REPORT] = "Purchase_Reports/monthlyReport";
$route[MONTHLY_PURCHASE_REPORT_AJAX] = 'Purchase_Reports/monthlyReport_ajax';
$route[MONTHLY_PURCHASE_REPORT_EXCEL] = 'Purchase_Reports/monthlyReportExcel';
$route[PURCHASE_OUTSTANDING_REPORT] = "Purchase_Reports/outstandingReport";
$route[PURCHASE_OUTSTANDING_REPORT_AJAX] = 'Purchase_Reports/outstandingReport_ajax';
$route[PURCHASE_OUTSTANDING_REPORT_EXCEL] = 'Purchase_Reports/outstandingReportExcel';
$route[PURCHASE_PAYMENT_REPORT] = "Purchase_Reports/paymentReport";
$route[PURCHASE_PAYMENT_REPORT_AJAX] = 'Purchase_Reports/paymentReport_ajax';
$route[PURCHASE_PAYMENT_REPORT_EXCEL] = 'Purchase_Reports/paymentReport_excel';
$route[SEND_MAIL.'/(:any)'] = 'Reports/send_mail/$1';
$route[INV_MAIL.'/(:any)'] = 'Invoices/inv_mail/$1';
$route[UPLOAD_WAYBILL_PDF] = 'Invoices/upload_waybill';

$route['countries'] = "Mst_countries/index";
$route['countries-create'] = "Mst_countries/create";
$route['countries-create-action'] = "Mst_countries/create_action";
$route['countries-update'] = "Mst_countries/update";
$route['countries-update-action'] = "Mst_countries/update_action";

$route['states'] = "Mst_states/index";
$route['states-create'] = "Mst_states/create";
$route['states-create-action'] = "Mst_states/create_action";
$route['states-update'] = "Mst_states/update";
$route['states-update-action'] = "Mst_states/update_action";

$route['city'] = "Mst_cities/index";
$route['city-create'] = "Mst_cities/create";
$route['city-create-action'] = "Mst_cities/create_action";
$route['city-update'] = "Mst_cities/update";
$route['city-update-action'] = "Mst_cities/update_action";