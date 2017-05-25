<?php
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
    if(isset($_POST['code']) && isset($_COOKIE['id_reg'])) {
        $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
        mysqli_query($mysqli, "SET NAMES utf8");
        $data = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM auth_new WHERE id='".$_COOKIE['id_reg']."'"));
        if(isset($data['try'])){
            if($data['try'] > 0){
                mysqli_query($mysqli, "UPDATE auth_new SET try=try-1 WHERE id='".$_COOKIE['id_reg']."'");
                if($data['active_code'] == $_POST['code']){
                    $a = rand (100000, 999999);
                    $hash = md5(generateCode(10));
                    mysqli_query($mysqli, "INSERT INTO auth SET name='".$data["name"]."', email='".$data["email"]."', password='".$data["password"]."', phone='".$data['phone']."', present_code='".$a."', hash='".$hash."'");
                    setcookie("id", mysqli_insert_id($mysqli), time()+60*60*24*365*10);
                    setcookie("name", $data['name'], time()+60*60*24*365*10);
                    setcookie("hash", $hash, time()+60*60*24*365*10);
                    mysqli_query($mysqli, "DELETE FROM auth_new WHERE id='".$_COOKIE['id_reg']."'");
                    unset($_COOKIE['id_reg']);
                    setcookie('id_reg', null, -1, '/');
                    if($data['present_code'] > 10){
                        $present_id = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT id FROM auth WHERE present_code='".$data['present_code']."'"));
                        if(isset($present_id['id'])){
                            mysqli_query($mysqli, "INSERT INTO present SET user_id='".$present_id['id']."', present_code='".$a."'"); 
                            //$body = file_get_contents("http://sms.ru/sms/send?api_id=0ece9e5e-2386-b6b4-9db5-d68320b78b44&to=".$data['phone']."&text=Ваш друг зарегестрировался,вот ваш код подарка:".$a.".&test=1");
                        }
                    }
                    print($a);
                } else {
                    if(($data['try'] - 1) > 0) {
                        print($data['try'] - 1);
                    } else {
                        print(4);
                        mysqli_query($mysqli, "DELETE FROM auth_new WHERE id='".$_COOKIE['id_reg']."'");
                    }
                }
            }
        } else {
            print(5);
        }
	}
?>