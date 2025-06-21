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


define('FRESH_DESK_API','cVcDxu8GWlqCNaVRYjT');
define('FRESH_DESK_PASSWORD','team2021');
define('FRESH_DESK_DOMAIN','newaccount1624337705803');

define('TRANSLATER_KEY','b9c0587eb1a3fddfc2eedb63be5c3919');

define('GOOGLE_KEY','AIzaSyAizP2gE4ufvHl6T9dvycCuSYz-yirExy4');

define('FIREBASE_SERVER_KEY','AAAAFx1kl_Q:APA91bFeAzIpQQaR1nQDDkBXu5p-lLo4OoO1ewonS4hrzWu0_JneD-n-4kpWb9BTrYk7HwCMIOohcVhr1KXjq2x56GtMxf4TqEnMI17ai7Lt2fYHnt0thMS7jtSD3QuSC-2ITPJBERHk');

//sayan code
$percentage_ary = array('>90% - 100%','>80% - 90%','>70% - 80%','>60% - 70%','>50% - 60%','>40% - 50%','>30% - 40%','>20% - 30%','>10% - 20%','0% - 10%');
define('PERCENTAGE_CHAIN', $percentage_ary);

$rentention_percentage_ary = array('0%','0% - 10%','10% - 20%','20% - 30%','30% - 40%','40% - 50%','50% - 60%','60% - 70%','70% - 80%','80% - 90%','90% - 100%');
define('RETENTION_PERCENTAGE_CHAIN', $rentention_percentage_ary);

$confidence_ary = array(
	'E' => array(
		'first' => array(
			'type' => 'le',
			'msg' => 'Student feels confident with grammar.',
			'compare_with' => '10'
		),
		'second' => array(
			'type' => 'both',
			'msg' => 'Student has some hesitency when answering grammar questions.',
			'compare_with' => '11@20'
		),
		'third' => array(
			'type' => 'gt',
			'msg' => 'Student is not confident when answering grammar questions.',
			'compare_with' => '20'
		)
	),
	'C' => array(
		'first' => array(
			'type' => 'le',
			'msg' => 'Student feels confident with grammar.',
			'compare_with' => '10'
		),
		'second' => array(
			'type' => 'both',
			'msg' => 'Student has some hesitency when answering grammar questions.',
			'compare_with' => '11@20'
		),
		'third' => array(
			'type' => 'gt',
			'msg' => 'Student is not confident when answering grammar questions.',
			'compare_with' => '20'
		)
	),
	'A' => array(
		'first' => array(
			'type' => 'le',
			'msg' => 'Student feels confident with grammar.',
			'compare_with' => '10'
		),
		'second' => array(
			'type' => 'both',
			'msg' => 'Student has some hesitency when answering grammar questions.',
			'compare_with' => '11@20'
		),
		'third' => array(
			'type' => 'gt',
			'msg' => 'Student is not confident when answering grammar questions.',
			'compare_with' => '20'
		)
	)
);

define('CONFIDENCE_MEASUREMENT', $confidence_ary);

define('ASSESSMENT_GROUPING_DIVIDER', 3);

define('ASSESSMENT_GROUPING_MULTIPLIER', 3);

$confidence_ary_based_on_group = array(
	'E' => array(
		'first' => array(
			'type' => 'lt',
			'msg' => 'Student has become more hesitant over duration of grammar course.',
			'compare_with' => '-.5'
		),
		'second' => array(
			'type' => '2le',
			'msg' => 'Student confidence in answering questions has remained consistent during grammar course.',
			'compare_with' => '-.5@.5'
		),
		'third' => array(
			'type' => '1lt1le',
			'msg' => 'Student has improved confidence when answering grammar questions.',
			'compare_with' => '.5@1.5'
		),
		'fourth' => array(
			'type' => 'ge',
			'msg' => 'Student has significant increase in confidence when answering grammar questions.',
			'compare_with' => '1.5'
		)
	),
	'C' => array(
		'first' => array(
			'type' => 'le',
			'msg' => 'Student feels confident with grammar.',
			'compare_with' => '10'
		),
		'second' => array(
			'type' => 'both',
			'msg' => 'Student has some hesitency when answering grammar questions.',
			'compare_with' => '11@20'
		),
		'third' => array(
			'type' => 'gt',
			'msg' => 'Student is not confident when answering grammar questions.',
			'compare_with' => '20'
		)
	),
	'A' => array(
		'first' => array(
			'type' => 'le',
			'msg' => 'Student feels confident with grammar.',
			'compare_with' => '10'
		),
		'second' => array(
			'type' => 'both',
			'msg' => 'Student has some hesitency when answering grammar questions.',
			'compare_with' => '11@20'
		),
		'third' => array(
			'type' => 'gt',
			'msg' => 'Student is not confident when answering grammar questions.',
			'compare_with' => '20'
		)
	)
);

define('CONFIDENCE_MEASUREMENT_BASED_ON_GROUP', $confidence_ary_based_on_group);

$confidence_index_ary = array(
	'E' => array(
		'0-1.0' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.0-1.75' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.75-2.5' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'2.5-3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		)
	),
	'C' => array(
		'0-1.0' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.0-1.75' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.75-2.5' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'2.5-3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		)
	),
	'A' => array(
		'0-1.0' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.0-1.75' => array(
			'0-3' => 1,
			'4-10' => 1,
			'11-15' => 2,
			'15-20' => 3,
			'21-25' => 4,
			'26' => 5
		),
		'1.75-2.5' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'2.5-3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		),
		'3.25' => array(
			'0-3' => 1,
			'4-10' => 2,
			'11-15' => 3,
			'15-20' => 4,
			'21-25' => 5,
			'26' => 5
		)
	)
);

define('CONFIDENCE_INDEX_MEASUREMENT', $confidence_index_ary);

define('TOT_QUIZ_CNT_C', 20);
define('PER_SUM_SCO_E', 80);
define('PER_SUM_SCO_C', 70);

define('EMERGING_EMI_DURATION', 4);
define('CONSOLIDATED_EMI_DURATION', 6);
define('ADVANCED_EMI_DURATION', 7);

//define course readalong counts
define('EMERGING_READALONG', 10);
define('CONSOLATING_READALONG', 15);
define('ADVANCED_READALONG', 30);

//Global hash password
define('GLOBAL_PASS', '$2y$10$NwqSbD/gvU6qvYD5Xv1xYuv/2PgqWAX/ERwgNUmq27Txo3eAHQQI6');
define('report_date_from', "2022-08-01");

/*define('FACEBOOK_APP_ID', '772186277348460');
define('FACEBOOK_APP_SECRET', '0c37647edd065675c88cb0e1e080ebfb');
define('FACEBOOK_ACCESS_TOKEN', 'EAAKZBTKDDBGwBAMSj32DjC9YPOtSi7k1aruP55ZBiS5Tu9HnhdBYmXL784PoCbtA3OuP4VZAJdnGhAhuGjpCeN4am3sWwPFCFa1JUL2eAbunnNWcPDaWNZALGWj22oZC5GuV9JBJXIHjwEMYJvlLi363LjdtckNuDvDY1RqZBTHuhek7djgQyg0WC5IfmeYqKUj6bWCg9bc7C744PtBJXSy20F0XVPvx8F4LZA7qSMYZBMzQ8AdxiQ8diZCDhy67lCZAkZD');*/

define('FACEBOOK_APP_ID', '3175358559381085');
define('FACEBOOK_APP_SECRET', '5730a6095e2a45b0a342d1c5c52b87aa');
define('FACEBOOK_ACCESS_TOKEN', 'EAAtHZBMb3ZAl0BAJWPquhUjxum1UrCZCItJUxZCf8FrbgqAec3OeZBhb0zDP4kPHvfNRWBvkLctxZAD5WdgfCNEZAMZAMtgNZBlW4LRJFq1YDLSmYiRsgYHXNe91H56lbivGx6Chszq8AwTZCy9MEXXBUStpBvSwXfcPzIPPvYjnVeZC3te9ZBVtcDDGh1JlymzNg7U7GZAEmdCyQCUsdoIsdiZAya7ZBslQn9z6ZC0ZD');

