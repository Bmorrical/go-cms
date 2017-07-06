<?php
defined('BASEPATH') OR exit('No direct script access allowed');

///////////////////////////////// start //////////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

/**
 * These are dynamic fields common to most go cms projects 
 * See also go_config.php for project common fields
 */

$config['go_base_folder'] = 'go-cms/'; // If any, such as localhost/{base-folder}/ (requires trailing slash)
$config['go_debug'] = 0; // ? true : false
$config['go_debug_white_bg'] = 1;  // if using a dark theme
$config['go_environment'] = 'DEVELOPMENT'; // DEVELOPMENT, STAGING, PRODUCTION
$config['go_base_url'] = ((isset($_SERVER['HTTPS'])) ? 'https://' : 'http://') . 'localhost/' . $config['go_base_folder']; // Base URL

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . '/' . $config['go_base_folder']; // localhost needs this for extra folder


/**
 * These are Development configurations.  Production configs are in go_config.php
 */

$config['go_admin_email'] = 'your_email@email.com'; // DEVELOPMENT Admin Email
$config['go_enable_go_postman_admin_emails'] = true;  // System should dispatch Admin emails

// SMTP 
$config['go_company_email'] = 'your_email@email.com';
$config['go_company_email_password'] = '###########';

// If not Gmail, then update the host parameters below
$config['go_smtp_development_host'] = "smtp.gmail.com";
$config['go_smtp_development_port'] = 465;
$config['go_smtp_development_crpt'] = "SSL";




$config['go_redirect_url'] = 'localhost/go-cms'; // for when not hitting ?go=key

$config['go_login_key'] = 'cms'; // ?go=key
$config['go_admin_login_default_route'] = '/admin/dashboard'; // after Admin login, which route should be served
$config['go_home_login_default_route'] = '/index'; // after Home login, which route should be served
$config['go_logo_default_route'] = 'admin/dashboard'; // when clicking logo, which route should be served, no starting slash
$config['go_logo_location'] = '';
$config['go_company_name'] = '{Your Company Name Here}';
$config['go_logo-email-path'] = '//your-website.com/assets/images/logo.png';

$config['go_dev_admin_login_username'] = "super-admin";
$config['go_dev_admin_login_password'] = "secret";

/**
 * These are Production configurations.  Development configs are in config.php
 */
 
// If not Gmail, then update the host parameters below
$config['go_smtp_development_host'] = "smtp.gmail.com";
$config['go_smtp_development_port'] = 465;
$config['go_smtp_development_crpt'] = "SSL";

/////////////////////////////////  end  //////////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////