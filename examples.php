<?php

/* this is just showing a few possible usages */

include_once dirname(__FILE__) . '/lib/ObcentoTwitter.class.php';

$consumer_key = '';
$consumer_secret = '';
$access_token = '';
$access_token_secret = '';

require_once('config.php');

$obcento = ObcentoTwitter::instance(
	$consumer_key,
	$consumer_secret,
	$access_token,
	$access_token_secret);

/* get the last few mentions of the authenticating user */
print_r(
    $obcento->statuses('user_timeline','',array())
);