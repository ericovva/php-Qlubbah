<?php
    $mes = '';
    if(isset($_POST["new_name"]) && isset($_POST["new_email"]) && isset($_POST["new_pas"]) && isset($_POST["new_pas1"]) && isset($_POST["phone"])){
        if(!(empty($_POST["new_name"]) || empty($_POST["new_email"]) || empty($_POST["new_pas"]) || empty($_POST["new_pas1"]) || empty($_POST["phone"]))){
             if(preg_match("/^[0-9]{10,10}+$/", $_POST["phone"])){
                $phone = '+7'.$_POST["phone"];
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('secret' => '6LeX8QoTAAAAAL5Ad6Qg48RUgGkgWUY5SD_QXQ-n','response' => $_POST['g-recaptcha-response']))
                ));
                $response = json_decode(curl_exec($myCurl),true);
                if($response['success'] == 'true'){
                    if($_POST["new_pas"] == $_POST["new_pas1"]){
                        if (filter_var($_POST["new_email"], FILTER_VALIDATE_EMAIL)) {
                            $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                            mysqli_query($mysqli, "SET NAMES utf8");
                            $query = mysqli_query($mysqli, "SELECT COUNT(id) FROM auth WHERE email='".$_POST['new_email']."' OR phone='".$phone."'");
                            $data = mysqli_fetch_array($query, MYSQLI_NUM);
                            if($data[0] == 0) {
                                $a = rand (100000, 999999);
                                //$body = file_get_contents("http://sms.ru/sms/send?api_id=0ece9e5e-2386-b6b4-9db5-d68320b78b44&to=".$phone."&text=".$a."&test=1");
                                $body = "100";
                                if(substr($body, 0, 3) == '100' || substr($body, 0, 3) == '201'){
                                    $mes = "Сейчас вам придем СМС с кодом активации,введите его,у вас будет 3 попытки:";
                                    $password = md5(md5(trim($_POST['new_pas'])));
                                    if(isset($_POST["present_code"])){
                                        if($_POST["present_code"] == '')
                                            $_POST["present_code"] = 0;  
                                    }
                                        
                                    mysqli_query($mysqli, "INSERT INTO auth_new SET name='".$_POST["new_name"]."', email='".$_POST["new_email"]."', password='".$password."', phone='".$phone."', active_code='".$a."', time='".time()."', present_code='".$_POST['present_code']."'");
                                    setcookie("id_reg", mysqli_insert_id($mysqli), time()+60*15);
                                }
                                if(substr($body, 0, 3) == '202'){
                                    $errr = "Вы не правильно ввели мобильный телефон.";
                                }
                                
                            } else {
                                $errr = "Пользователь с таким E-mail или телефоном уже существует в базе данных.";
                            }
                        } else {
                            $errr = "Вы не правильно ввели E-mail.";
                        }
                    } else {
                        $errr = "Пароли не совпадают.";
                    }
                } else {
                    $errr = "Вы не прошли капчу.";
                }
            }else{
                $errr = "Вы не правильно ввели мобильный телефон.";
            }
        } else {
             $errr = "Есть пустое поле.";
        }
    }
?>  

<!DOCTYPE html>
<html >
<head>
 <title> Qlubbah </title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
 <link rel="stylesheet" href="style/auth.css"/>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> 
 <script src='https://www.google.com/recaptcha/api.js'></script>
 <script src="http://qlubbah.ru/js/header.js"></script> 
<script>


var mobile;
        if(window.screen.width<1100) 
            mobile=true; 
        else 
            mobile=false;

    $(document).ready(function() { 

        $("#send_active_code").click(function() {
            var codee    = $("#active").val();
            $.post("active_check.php", {code: codee}).done(function( data ) {
                if(parseInt(data) > 5){
                    $('#A4_inner').text('Ваш аккаунт активирован.Запомните этот промокод :' + data + ', чтобы приглашать друзей и получать подарки!');
                } 
                if(data == '4'){
                    $('#A4_inner').text('У вас кончились попытки.');
                }
                if(data == '5'){
                    $('#A4_inner').text('Такого зарегистрированного пользователя не существует или он уже активирован.');
                }
                if(parseInt(data) < 3){
                    $('#mes_answer').text('Неверный код активации.Количество попыток: ' + data + '.');
                }
            });
        });  
    });
            
</script>
<style>

.captcha-item {
    float: left;
    text-align: center;
    width: 50px;
    padding-bottom: 4px;
}
</style>
</head>
<body>

    


	  	<?php include "header.php";
         file_get_contents('header.php');?>

	<div  id="block1">
            <div id="A4" style="height: auto; margin-bottom: 50px;">
    
                <div id="A4_inner">
                <div id="mes_answer">
                    <? if($mes != ''){
        print($mes);
       ?>
       </div>
       <div>
            <input style="height: 20px;width:100%;" id="active"/>
            <button id="send_active_code" class="button7" style="width:100%;margin-top:15px">Отправить</button>
       </div>
     <?}else{?>
    <div style="font-size: 25pt"> Регистрация: </div>  </br>
    <form action="/reg.php" method="post" accept-charset="UTF-8">         
        <div> Ваше имя: </div> <input style="width:100%; height: 30px; font-size:20px;" name="new_name" value="<?if(isset($_POST["new_name"])){print($_POST["new_name"]);}?>"/>  </input> </br> 
        <div style="margin-top:15px"> E-mail: </div> <input style="width:100%; height: 30px; font-size:20px;"  name="new_email" type="email" value="<?if(isset($_POST["new_email"])){print($_POST["new_email"]);}?>"/> </input> </br>
        <div style="margin-top:15px"> Мобильный телефон<br />(пример: 9004003020): </div> <input style="width:100%; height: 30px; font-size:20px;" type="tel"  name="phone" value="<?if(isset($_POST["phone"])){print($_POST["phone"]);}?>"/> </input> </br>
        <div style="margin-top:15px"> Промокод пригласителя:</div><input style="width:100%; height: 30px; font-size:20px;" value="<?if(isset($_POST["present_code"])){print($_POST["present_code"]);}?>" name="present_code" /> </input> </br>
        <div style="margin-top:15px"> Пароль: </div> <input style="width:100%; height: 30px; font-size:20px;" name="new_pas" type="password"/>  </input> </br>
        <div style="margin-top:15px"> Повторить пароль: </div> <input style="width:100%; height: 30px; font-size:20px;"  name="new_pas1" type="password"/>  </input> </br> </br>
        <div id="ccha" class="g-recaptcha" data-sitekey="6LeX8QoTAAAAALCJE_RfiE2apjAxioFjIcsHzJI1"></div>
        <input style="width:100%;margin-top:15px;" class="button7" type="submit" value="Зарегистрироваться"/>
    </form> <? } ?>
    <p style="color:red; font-size: 18px;"><?  if (isset($errr)){ print($errr); }?> </p>

                </div>
            </div>
    
    
	</div>
    


    <?php include "footer.php";
         file_get_contents('footer.php');?>

</body>
</html>