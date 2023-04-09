<?php
defined('DIR') OR exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
use \Curl\Curl;

function url_to_domain($url) {
    $host = @parse_url($url, PHP_URL_HOST);
    // If the URL can't be parsed, use the original URL
    // Change to "return false" if you don't want that
    if (!$host)
        $host = $url;
    // The "www." prefix isn't really needed if you're just using
    // this to display the domain to the user
    if (substr($host, 0, 4) == "www.")
        $host = substr($host, 4);
    // You might also want to limit the length if screen space is limited
    if (strlen($host) > 50)
        $host = substr($host, 0, 47) . '...';
    return $host;
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function is_valid_domain_name($domain_name){
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
}

function resellerclub_suggestions( $curl, $domain ) {
	$curl->setConnectTimeout(60);
	$curl->get('https://test.httpapi.com/api/domains/v5/suggest-names.json', array(
		'auth-userid' 	=> '729763',
		'api-key'		=> 'Gmuoi2QVg2jkEwY7TtIkHYIJzcm1bKFc',
		'keyword'		=> $domain,
		'no-of-results'	=> 20,
		'tld-only'		=> 'com'
	));

	if ($curl->error) {
	    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
	    return false;
	} else {
	    $dn = (array) $curl->response;

	    if( count($dn) > 0 ) {
	    	foreach ($dn as $key => $value) {
		    	$suggested_domain[]['domain'] = $key;
		    }
		    return $suggested_domain;
	    } else {
	    	return false;
	    }
	}
}

function godaddy_name_check( $curl, $domain, $tld ) {

	$header = array(
		'Authorization: sso-key AEfKCVoZq2W_Hp3tHFCr7g44jncrff25hc:Hp3wp9KSCXVNKQ1TgBBuLW'
	);

	$curl->setOpt(CURLOPT_HTTPHEADER, $header);
	$curl->setConnectTimeout(60);
	$curl->get('https://api.godaddy.com/v1/domains/available', array(
	    'domain' => $domain . $tld
	));

	if ($curl->error) {
	    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
	    return false;
	} else {
	    $dn = (array) $curl->response;
	    return $dn;
	}
}

function godaddy_suggestions( $curl, $domain, $tld ) {

	$header = array(
		'Authorization: sso-key AEfKCVoZq2W_Hp3tHFCr7g44jncrff25hc:Hp3wp9KSCXVNKQ1TgBBuLW'
	);

	$curl->setOpt(CURLOPT_HTTPHEADER, $header);
    $curl->setConnectTimeout(60);

    //$suggested_domain = godaddy_domain_suggestion($domain, $tld);
    $curl->get('https://api.godaddy.com/v1/domains/suggest', array(
	    'query' => $domain . $tld,
	    'tlds'	=> 'com,org,net,us,info,co,co.in,in,uk,net.in',
	    'limit'	=> '20'
	));
	if ($curl->error) {
	    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
	    return false;
	} else {
	    $dn = (array) $curl->response;				    
		if(isset($dn['code'])){
			return false;
		} else {
			if( !count($dn) > 0 ) {
				return false;
			} else {
				return $dn;
			}
		}
	}
}

function utf8_char_code_at($str, $index) {
    $char = mb_substr($str, $index, 1, 'UTF-8');

    if (mb_check_encoding($char, 'UTF-8')) {
        $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
        return hexdec(bin2hex($ret));
    } else {
        return null;
    }
}

function instant_domain_suggestion( $curl, $domain, $tld ) {

	$hash = 42;
	for ($i=0; $i < strlen($domain); $i += 1) {
		//list(, $ord) = unpack('N', mb_convert_encoding($domain, 'UCS-4BE', 'UTF-8'));
		$hash = ( $hash << 5 ) - $hash + utf8_char_code_at($domain, $i);
		$hash &= $hash;
	}

	$curl->setConnectTimeout(60);

    //$suggested_domain = godaddy_domain_suggestion($domain, $tld);
    $curl->get('https://instantdomainsearch.com/services/name/'  . $domain, array(
	    'hash' => $hash,
	    'limit'	=> '1',
	    'tlds'	=> $tld,
	));
	if ($curl->error) {
	    //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
	    return false;
	} else {
	    $dn = (array) $curl->response;
	    return $dn;
	}
}

function price_data( $tld ) {
	if( isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:gethostbyname(gethostname()) == '127.0.0.1' ) {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "domainsprice";
	} else {
		$servername = "hi4manohar10060.ipagemysql.com";
		$username = "user_noticemate";
		$password = "2/.&H96*g?=Cb9&;f-h?";
		$dbname = "domaincost";
	}
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT r.registrar_name, r.registrar_url, r.registrar_img, tp.registrar_id, tp.tlds, tp.year, tp.cost FROM registrars as r, tld_price as tp WHERE r.item_id=tp.registrar_id AND tlds='" . $tld . "' ORDER BY tp.cost";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		if (function_exists('mysqli_fetch_all')) {
			$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		} else {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	} else {
		return false;
	}
}

$domain_error = $tld_error = "";
$domain = $tld = "";
$domain_status = "";
$tlds = array('.com', '.org', '.net');
$tlds_without_dots = array('com', 'org', 'net');
//$tlds = array('.com', '.org', '.net', '.us', '.info', '.co', '.co.in', '.in', '.uk', '.net.in');
//$tlds_without_dots = array('com', 'org', 'net', 'us', 'info', 'co', 'co.in', 'in', 'uk', 'net.in');
$domain_av_status = false;

if ( $_SERVER["REQUEST_METHOD"] === "GET" && ( isset($_GET["domain"]) || isset($_GET['tld']) ) ) {

	if( empty( $_GET["domain"] ) ) {
		$domain_error = "Domain not valid. Please enter a valid domain name";
	} else {
		$domain = strtolower( test_input($_GET["domain"]) );
		$domain = url_to_domain( $domain );

		if( is_valid_domain_name($domain) == false ) {
			$domain_error = "Domain not valid. Please enter a valid domain name";
		}

		if (strpos($domain, '.') !== false) {

			$_GET['tld'] = strstr($domain,'.');
			$domain_pure = explode('.', $domain);
			$domain = $domain_pure[0];
		}
	}
	
	if( empty( $_GET["tld"] ) ) {
		$_GET["tld"] = '.com';
		$tld = test_input($_GET["tld"]);
	} else {
		$tld = test_input($_GET["tld"]);
		if( !in_array($tld, $tlds) ) {
			$tld_error = 'Domain Extension not supported';
		}
	}

	if( empty($domain_error) && empty($tld_error) ) {

		//initialize curl
		$curl = new Curl();

		if( strpos($tld, '.') == '0' ) {
			$inds_tld = ltrim($tld, '.');
		} else {
			$inds_tld = ltrim($tld, '.');
		}

		if( ( $dn = instant_domain_suggestion( $curl, $domain, $inds_tld ) ) == false ) {
			$dn = godaddy_name_check( $curl, $domain, $tld );
		} else {
			$dn['available'] = $dn['isRegistered'] == 1 ? false : true;
		}

		if( $dn === false ) {
			$domain_status = $curl->errorMessage;
        	$domain_av_status = false;
        	include 'resellerclubapi.php';
		}

		// the domain is available
        if(isset($dn['available']) && $dn['available'] == true){
            $domain_status = $domain . $tld . ' is Available';
            $domain_av_status = true;
        // else the domain is NOT available
        } else {
            $domain_status = $domain . $tld . ' is not Available';
            $domain_av_status = false;
            $suggested_domain = godaddy_suggestions( $curl, $domain, $tld );
            if( $suggested_domain === false ) {
            	$suggested_domain = resellerclub_suggestions( $curl, $domain );
            }
        }
	}

	if( empty($domain_error) && empty($tld_error) && $domain_av_status === true ) {
		$data = price_data( $tld );
	}	
}