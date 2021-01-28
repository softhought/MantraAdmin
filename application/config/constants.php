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


// How to define

define ("SEARCH_BY", json_encode(array ( 
    "FOLLOW-UP DATE" => "FOLLOW-UP DATE",
    "ENQIRY DATE" => "ENQIRY DATE",
   
)));

define ("GENDER", json_encode(array ( 
    "M" => "MALE",
    "F" => "FEMALE",
    "O" => "OTHER",
   
)));
define ("SEARCH_BY2", json_encode(array ( 
    "FRESH" => " FRESH",
    "FOLLOW-UP" => "FOLLOW-UP",
   
)));

define ("Rate_TYPE", json_encode(array ( 
    "Not Free" => "Not Free",
    "Free" => "Free",
   
)));
define ("PACK_TYPE", json_encode(array ( 
    "Part of Package" => "Part of Package",
    "Complimentary" => "Complimentary",
   
)));
define ("PACK_SUB_TYPE", json_encode(array ( 
    "W/OUT" => "W/OUT",
    "H and F" => "H and F",
   
)));
define ("HF_GROUP_TYPE", json_encode(array ( 
    "GEN MED" => "GEN MED",
    "BODY COMP" => "BODY COMP",
    "ORTHO" => "ORTHO",
    "GEN FIT" => "GEN FIT",
    "BLOOD TEST" => "BLOOD TEST",
   
)));
define ("PACKAGE_TYPE", json_encode(array ( 
    "M" => "Mother Package",
    "C" => "Child Package",
       
)));

define ("MOTHER_PACKAGE_STATUS", json_encode(array ( 
    "ALL" => "ALL",
    "FRESH" => "FRESH",
    "CONVERTED" => "CONVERTED",
       
)));
define ("MOTHER_PACKAGE_SEARCH", json_encode(array ( 
    "REG DATE" => "REG DATE",
    "PAYMENT DATE" => "PAYMENT DATE",
       
)));
define ("TRASANCTION_TYPE", json_encode(array ( 
    "CASH" => "CASH",
    "BANK" => "BANK",
    "CONTRA" => "CONTRA",
    "JOURNAL" => "JOURNAL",
       
)));

define ("SUB_TRASANCTION_TYPE", json_encode(array ( 
    "RECEIPT" => "RECEIPT",
    "PAYMENT" => "PAYMENT",
       
)));

define ("ACCOUNT_TAG", json_encode(array ( 
    "Dr" => "Dr",
    "Cr" => "Cr",
       
)));
define ("MONTH_MASTER", json_encode(array ( 
    "Apr" => "April",
    "May" => "May",
    "Jun" => "June",
    "Jul" => "July",
    "Aug" => "August",
    "Sep" => "September",
    "Oct" => "October",
    "Nov" => "November",
    "Dec" => "December",
    "Jan" => "January",
    "Feb" => "February",
    "Mar" => "March",
       
)));

define ("TRASANCTION_TYPE2", json_encode(array ( 
    "RECEIPT" => "RECEIPT",
    "PAYMENT" => "PAYMENT",
    "JOURNAL" => "JOURNAL",
    "REG" => "REG",
       
)));
define ("COLLECTION_TYPE", json_encode(array ( 
    "Y" => "Daily Collection",
    "N" => "Without Daily Collection",
   
       
)));
define ("PAYMENT_MODE", json_encode(array ( 
    "Cash" => "Cash",
    "ONP" => "ONP",
    "Cheque" => "Cheque",
    "Card" => "Card",
    "Fund Transfer" => "Fund Transfer",
   
       
)));

