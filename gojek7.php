<?php

error_reporting(0);
include ("func.php");
echo "\e            GOJEK VERSION 1.7.1            \n";
echo "\e SCRIPT GOJEK AUTO REGISTER + AUTO CLAIM VOUCHER\n";
echo "\n";
nope:
echo "\e[?] Masukkan Nomor HP Anda : ";
$nope = trim(fgets(STDIN));
$cek = cekno($nope);
if ($cek == false)
    {
    echo "\e[x] Nomor Telah Terdaftar\n";
			goto nope;
    }
  else
    {
echo "\e[!] Siapkan OTPmu\n";
sleep(5);
$register = register($nope);
if ($register == false)
    {
    echo "\e[x] Failed Get OTP!\n";
    }
  else
    {
    otp:
    echo "\e[!] Masukkan Kode Verifikasi (OTP) : ";
    $otp = trim(fgets(STDIN));
    $verif = verif($otp, $register);
    if ($verif == false)
        {
        echo "\e[x] Kode Verifikasi Salah\n";
        goto otp;
        }
      else
        {
		$h=fopen("newgojek.txt","a");
		fwrite($h,json_encode(array('token' => $verif, 'voc' => 'gofood gak ada'))."\n");
		fclose($h); 
                echo "\e[!] Trying to redeem Reff : G-75SR565 !\n";
                sleep(3);
            $claim = reff($verif);
            if ($claim == false){
            echo "\e[!] Failed to Claim Voucher, Try to Claim Manually\n";
            }else{
                echo "\e[+] ".$claim."\n";
            }

    setpin:
         echo \n ("MAU SET PIN = y/n");
         $pilih1 = trim(fgets(STDIN));
         if($pilih1 == "y" || $pilih1 == "Y"){
         //if($pilih1 == "y" && strpos($no, "628")){
         echo ("========( PIN ANDA = 141000 )========")."\n";
         $data2 = '{"pin":"141000"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo "Otp set pin: ";
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;
         }else if($pilih1 == "n" || $pilih1 == "N"){
         die();
         }
    }
    }
    }


?>
