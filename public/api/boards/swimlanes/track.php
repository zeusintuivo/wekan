<?php
$request_body = file_get_contents('php://input');
//$data = json_decode($request_body);
$data = json_decode($request_body, TRUE); //convert JSON into array

$myFile = "tracking.php";
$fh = fopen($myFile, 'a') or die("var message='Can't open file';");
$stringData = "\n- - - - - - - - - - - - - - - - - Tracked on: " . date('Y-m-d H:i:s') . ";\n";
$stringData .= "- - - _HEADERS's: \n";
foreach (getallheaders() as $name => $value) {
    $stringData .=  "$name: $value\n";
}
$stringData .= "- - - _INPUT's: \n";
if (is_array($data)) {
    foreach ($data as $key => $value) {
        $stringData .= "$key: $value;\n";
    }
}
$stringData .= "- - - _GET's: \n";
if (is_array($_GET)) {
    foreach ($_GET as $key => $value) {
        $stringData .= "$key: $value;\n";
    }
}
if (is_array($_POST)) {
    $stringData .= "- - - _POST's: \n";
    foreach ($_POST as $key => $value) {
        $stringData .= "$key: $value;\n";
    }
}
//Not Working for now
//$stringData .= "- - - _REFERRER: \n";
//$stringData .= get_search_query(). "\n";
$stringData .= "- - - _SERVER's: \n";
if (is_array($_SERVER)) {
    foreach ($_SERVER as $key => $value) {
        $stringData .= "$key: $value;\n";
    }
}
$stringData .= "- - - _REQUEST's: \n";
if (is_array($_REQUEST)) {
    foreach ($_REQUEST as $key => $value) {
        $stringData .= "$key: $value;\n";
    }
}
fwrite($fh, $stringData);
fclose($fh);

$output = file_get_contents($myFile);
$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
    $js_code = '<script>' . $js_code . '</script>';
echo $js_code;
//echo "<pre>var message='$output ';";
exit;


# from
# https://techtalk.virendrachandak.com/get-search-query-string-from-search-engines-using-php/
/**
 * Validate an email address.
 * Provide email address (raw input)
 * Returns true if the email address has the email
 * address format and the domain exists.
 */
function validEmail($email)
{
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
            str_replace("\\\\", "", $local))) {
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/',
                str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if (function_exists('checkdnsrr')) {
            if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                // domain not found in DNS
                $isValid = false;
            }

        }
    }
    return $isValid;
}

function validEquationAnt($before, $operant, $alter, $result)
{
    $resTMP = 0;
    if ($operant == 'plus') {
        $resTMP = $before + $alter;
    } elseif ($operant == 'minus') {
        $resTMP = $before - $alter;
    } elseif ($operant == 'times') {
        $resTMP = $before * $alter;
    } elseif ($operant == 'divided') {
        $resTMP = $before / $alter;
    }
    if ($resTMP == $result) {
        return true;
    }
    return false;
}
