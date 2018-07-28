<?php
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

function godaddy_domain_check($domain, $tld) {
	$apiurl = "https://api.godaddy.com/v1/domains/available?domain=" . $domain . $tld ;
	$header = array(
           'Authorization: sso-key AEfKCVoZq2W_Hp3tHFCr7g44jncrff25hc:Hp3wp9KSCXVNKQ1TgBBuLW'
    );

    //open connection
    $ch = curl_init();
    $timeout=60;

    //set the url and other options for curl
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    //execute post and return response data.
    $result = curl_exec($ch);
    //close curl connection
    curl_close($ch);
    // decode the json response
    return json_decode($result, true);
}

function godaddy_domain_suggestion($domain, $tld) {
	$sugg_url = "https://api.godaddy.com/v1/domains/suggest?query=" . $domain . $tld . "&tlds=com,org,net,us,info,co,co.in,in,uk,net.in&limit=10";
    $ch = curl_init();
	$timeout=60;

	$header = array(
           'Authorization: sso-key AEfKCVoZq2W_Hp3tHFCr7g44jncrff25hc:Hp3wp9KSCXVNKQ1TgBBuLW'
    );

	//set the url and other options for curl
	curl_setopt($ch, CURLOPT_URL, $sugg_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	//execute post and return response data.
	$result = curl_exec($ch);

	//close curl connection
	curl_close($ch);

	// decode the json response
	$dn = json_decode($result, true);
	// check if error code

	if(isset($dn['code'])){
		return false;
	} else {
		return $dn;
	}
}

$domain_error = $tld_error = "";
$domain = $tld = "";
$domain_status = "";
$tlds = array('.com', '.org', '.net', '.us', '.info', '.co', '.co.in', '.in', '.uk', '.net.in');
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
		$tld_error = "Please Select Available Domain Extension.";
	} else {
		$tld = test_input($_GET["tld"]);
		if( !in_array($tld, $tlds) ) {
			$tld_error = 'Domain Extension not supported';
		}
	}

	if( empty($domain_error) && empty($tld_error) ) {

		// curl --request GET "https://httpbin.org/get?key=value"
		$curl = new Curl();

		$header = array(
			'Authorization: sso-key AEfKCVoZq2W_Hp3tHFCr7g44jncrff25hc:Hp3wp9KSCXVNKQ1TgBBuLW'
		);

		$curl->setOpt(CURLOPT_HTTPHEADER, $header);
		$curl->setConnectTimeout(60);
		$curl->get('https://api.godaddy.com/v1/domains/available', array(
		    'domain' => $domain . $tld,
		));

		if ($curl->error) {
		    echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
		} else {
		    $dn = (array) $curl->response;
		}

        // check if error code
        if(isset($dn['code'])){

            $domain_status = explode(":",$dn['message']);
            $domain_status = $domain_status[0];
            $domain_av_status = false;

        // proceed if no error
        } else {
            // the domain is available
            if(isset($dn['available']) && $dn['available'] == true){

                $domain_status = $domain . $tld . ' is Available';
                $domain_av_status = true;

            // else the domain is NOT available
            } else {

                $domain_status = $domain . $tld . ' is Not Available';
                $domain_av_status = false;

                $suggested_domain = godaddy_domain_suggestion($domain, $tld);
                
            }        
        }
	}

	if( empty($domain_error) && empty($tld_error) && $domain_av_status === true ) {

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "domainsprice";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT r.registrar_name, r.registrar_url, r.registrar_img, tp.registrar_id, tp.tlds, tp.year, tp.cost FROM registrars as r, tld_price as tp WHERE r.item_id=tp.registrar_id AND tlds='" . $tld . "' ORDER BY tp.cost";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
	}
	
}