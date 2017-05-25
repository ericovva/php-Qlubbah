<?php
    if($_POST['mes'] != ''){
        if(isset($_COOKIE['id']) && isset($_COOKIE['hash'])){ 
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('secret' => '6LeX8QoTAAAAAL5Ad6Qg48RUgGkgWUY5SD_QXQ-n','response' => $_POST['g-recaptcha-response']))
                ));
            $response = json_decode(curl_exec($myCurl),true);
            if($response['success'] == 'true'){    
                $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                mysqli_query($mysqli, "SET NAMES utf8");
                $bd_hash = mysqli_fetch_array(mysqli_query($mysqli, "SELECT hash FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
                if($bd_hash[0] == $_COOKIE['hash']){
                    mysqli_query($mysqli, "INSERT INTO comment SET club_id='".$_POST['club_id']."',user_id='".$_COOKIE['id']."',comment='".$_POST['mes']."',time='".time()."',name='".$_COOKIE['name']."'");
                    print(1);   
                }
                
            } else{
                print(2);
            }
        }
    }else{
        print(3);
    }
    
    /*
    $users_list = mysqli_fetch_array(mysqli_query($mysqli, "SELECT COUNT(id) FROM comment WHERE user_id=".$_COOKIE['id']), MYSQLI_NUM);
                    if($users_list[0] == 0)
    */
?>