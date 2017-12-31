<?php
defined('BASEPATH') OR exit('No direct script access allowed');

///////////////////////////////// start //////////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

/**
 *  These are configurable parameters specific to your instance of go-cms
 *  This will be improved at some time later to be options in admin/config
 */

$config['go_base_folder'] = 'go-cms/'; // If any, such as localhost/{base-folder}/ (requires trailing slash)
$config['go_login_key'] = 'cms'; // ?go=key
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . '/' . $config['go_base_folder']; // localhost needs this for extra folder

$config['go_debug'] = false; // ? true : false
$config['go_debug_white_bg'] = 1;  // if using a dark theme

$config['go_environment'] = 'DEVELOPMENT'; // DEVELOPMENT, STAGING, PRODUCTION
$config['base_url'] = 'http://localhost/' . $config['go_base_folder']; // Base URL

$config['go_redirect_url'] = 'home';  // change the starting route

$config['go_admin_login_default_route'] = '/admin/dashboard'; // after Admin login, which route should be served
$config['go_home_login_default_route'] = '/index'; // after Home login, which route should be served
$config['go_logo_default_route'] = 'admin/dashboard'; // when clicking logo, which route should be served, no starting slash

$config['go_company_name'] = '{Your Company Name Here}';

/* For Login/Dashboard, start here the rest of the path is built in the view, can be set to "" empty string for none */

$config['go_logo_location'] = '';

/* For Emails, pull from production URL */

$config['go_logo_email_path'] = '//your-website.com/assets/images/logo.png';

/** Login */

$config['go_dev_admin_login_username'] = "super-admin";
$config['go_dev_admin_login_password'] = "secret";

/** SMTP */

$config['go_admin_email'] = 'your_email@email.com'; // DEVELOPMENT Admin Email
$config['go_enable_go_postal_admin_emails'] = false;  // System should dispatch Admin emails

$config['go_company_email'] = 'your_email@email.com';
$config['go_company_email_password'] = '###########';

$config['go_smtp_development_host'] = "smtp.gmail.com";
$config['go_smtp_development_port'] = 465;
$config['go_smtp_development_crpt'] = "SSL";

$config['go_smtp_staging_host'] = "smtp.gmail.com";
$config['go_smtp_staging_port'] = 465;
$config['go_smtp_staging_crpt'] = "SSL";

$config['go_smtp_production_host'] = "smtp.gmail.com";
$config['go_smtp_production_port'] = 465;
$config['go_smtp_production_crpt'] = "SSL";


/** 2017-10-15 */

$config['go_admin_login_cookie'] = "Ixbf24x";  // some random varchar, used in cookie for validating if you need ?go=cms on admin
$config['go_home_login_route'] = "login"; // which slug in the home login page

/** 2017-11-20 */

$config['go_admin_login_originator_links'] = true; // go-cms and CodeIgniter links on Admin login page.  on/off

/////////////////////////////////  end  //////////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////