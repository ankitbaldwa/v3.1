<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
 
if (! function_exists('moneyFormatIndia')) {
    function moneyFormatIndia($num) {
        // get main CodeIgniter object
        $ci = get_instance();
	    $explrestunits = "" ;
		$num=preg_replace('/,+/', '', $num);
		$words = explode(".", $num);
		$des="00";
		if(count($words)<=2){
		    $num=$words[0];
		    if(count($words)>=2){$des=$words[1];}
		    if(strlen($des)<2){$des="$des";}else{$des=substr($des,0,2);}
		}
		if(strlen($num)>3){
		    $lastthree = substr($num, strlen($num)-3, strlen($num));
		    $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
		    $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
		    $expunit = str_split($restunits, 2);
		    for($i=0; $i<sizeof($expunit); $i++){
		        // creates each of the 2's group and adds a comma to the end
		        if($i==0)
		        {
		            $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
		        }else{
		            $explrestunits .= $expunit[$i].",";
		        }
		    }
		    $thecash = $explrestunits.$lastthree;
		} else {
		    $thecash = $num;
		}
		return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
	}
}
if (! function_exists('enc_dec')) {
    function enc_dec($action, $string){
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //these are test keys, you can be generate one at https://asecuritysite.com/encryption/keygen
        $secret_key = 'ACCORDANCE'; //This is my secret key
        
        $secret_iv = 'ACCORDANCEGSTBILLING'; //This is my secret iv
        $CI = get_instance();
        $option = array(
            'cipher' => $encrypt_method,
            'mode' => 'ctr',
            'key' => 'ACCORDANCE',
            'driver' => 'OpenSSL'
        );
        $CI->encryption->initialize($option);
        if($action == 1){ // For encrypy the string
            // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
            //$output = $CI->encryption->encrypt(base64_encode($string));
            $output = strtr(
                $output,
                array(
                    '+' => '.',
                    '=' => '-',
                    '/' => '~'
                )
            );
        } else { // For decrypt the string
            $string = strtr(
                    $string,
                    array(
                        '.' => '+',
                        '-' => '=',
                        '~' => '/'
                    )
            );
            // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            //$output = base64_decode($CI->encryption->decrypt($string));
        }
        return $output;
    }
}
if (! function_exists('convert_number')) {
 	function convert_number($number) {
        $no = round($number);
        $decimal = round($number - ($no = floor($number)), 2) * 100;    
        $digits_length = strlen($no);    
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
            } else {
                $str [] = null;
            }  
        }
        
        $Rupees = implode(' ', array_reverse($str));
        $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
        return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
    }
 }
?>