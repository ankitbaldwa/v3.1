<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function get_company(){
    $ci =& get_instance();
    if(PRODUCTION == 'development'){
        $company = $ci->Mymodel->GetData('subscription',"company_url LIKE '%".$_SERVER['HTTP_HOST']."%'");
    } else {
        $company = $ci->Mymodel->GetData('subscription',"company_url LIKE '%".$_SERVER['HTTP_HOST']."%'");
    }
    return $company;
}
function load_db($company){
    $ci =& get_instance();
    /** Dynamic Database Connection starts here */
    $database = switch_db_dinamico($company->company_db_database, $company->company_db_host, $company->company_db_username, $company->comapny_db_password);
    $db = $ci->load->database($database, TRUE);
    /** Dynamic Database Connection starts here */
    return $db;
}
function switch_db_dinamico($name_db, $host, $username, $password)
{
    $config_app['hostname'] = $host;
    $config_app['username'] = $username;
    $config_app['password'] = $password;
    $config_app['database'] = $name_db;
    $config_app['dbdriver'] = 'mysqli';
    $config_app['dbprefix'] = '';
    $config_app['pconnect'] = FALSE;
    $config_app['db_debug'] = TRUE;
    return $config_app;
}
function switch_db_main()
{
    $config_app['hostname'] = 'localhost';
    $config_app['username'] = 'root';
    $config_app['password'] = '';
    $config_app['database'] = 'accordance';
    $config_app['dbdriver'] = 'mysqli';
    $config_app['dbprefix'] = '';
    $config_app['pconnect'] = FALSE;
    $config_app['db_debug'] = TRUE;
    return $config_app;
}