<?php

defined('DIR') OR exit('No direct script access allowed');
if ($curl->errorCode !== 400) {
	$curl->setConnectTimeout(60);
	$curl->get('https://test.httpapi.com/api/domains/available.json', array(
		'auth-userid' 	=> '729763',
		'api-key'		=> 'Gmuoi2QVg2jkEwY7TtIkHYIJzcm1bKFc',
		'domain-name'	=> $domain,
		'tlds'			=> str_replace('.', '', $tld)
	));

	if ($curl->error) {
	    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
	    $domain_status = $curl->errorMessage;
	    $domain_av_status = false;
	} else {
	    $dn = (array) $curl->response;

		if( $dn[$domain . $tld]->status == 'available' ) {
			$domain_status = $domain . $tld . ' is Available';
			$domain_av_status = true;
		} else {
			$domain_status = $domain . $tld . ' is not Available';
			$domain_av_status = false;

		    $suggested_domain = resellerclub_suggestions( $curl, $domain );
		}
	}
}


?>