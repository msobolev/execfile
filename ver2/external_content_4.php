<?php // demo/temp_jporter80.php
//error_reporting(E_ALL);



//echo file_get_contents('https://www.crunchbase.com/organization/magic-leap');

//$userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';

/*
$url = 'https://www.crunchbase.com/organization/magic-leap';
$curl = curl_init();
//curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$data = curl_exec($curl);
curl_close($curl);
echo "<br>HTML: ".$data;
*/


//$header=array('GET /1575051 HTTP/1.1','Host: adfoc.us','Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Accept-Language:en-US,en;q=0.8','Cache-Control:max-age=0','Connection:keep-alive','Host:adfoc.us','User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4)  AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36');
/*
$url = 'https://www.crunchbase.com/organization/magic-leap';
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
curl_setopt( $ch, CURLOPT_COOKIESESSION, true );

curl_setopt($ch,CURLOPT_COOKIEFILE,'cookies.txt');
curl_setopt($ch,CURLOPT_COOKIEJAR,'cookies.txt');
curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
curl_setopt($ch,CURLOPT_ENCODING , "");
$data = curl_exec($ch);
curl_close($ch);
*/


function get_web_page( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

$data_arr = get_web_page('https://www.crunchbase.com/organization/magic-leap');
echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";

//echo "<br>HTML: ".$data;

die();

// SEE http://www.experts-exchange.com/Web_Development/Web_Languages-Standards/PHP/Q_28379490.html

