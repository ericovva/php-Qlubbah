<?php
    $mes = '';
    if(isset($_POST["phone"])){
        if($_POST["phone"] != ''){
            if(preg_match("/^[0-9]{10,10}+$/", $_POST["phone"])){
                $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                mysqli_query($mysqli, "SET NAMES utf8");
                $query = mysqli_query($mysqli, "SELECT COUNT(id) FROM auth WHERE phone='+7".$_POST['phone']."'");
                $data = mysqli_fetch_array($query, MYSQLI_NUM);
                if($data[0] > 0){
                    $a = rand (100000, 999999);
                    //$body = file_get_contents("http://sms.ru/sms/send?api_id=0ece9e5e-2386-b6b4-9db5-d68320b78b44&to=+7".$_POST['phone']."&text=".$a."&test=1");
                    $body = "100";
                    if(substr($body, 0, 3) == '100' || substr($body, 0, 3) == '201'){
                        $mes = "Введите новый пароль и код пришедший на телефон,у вас есть 3 попытки:";
                        mysqli_query($mysqli, "UPDATE auth SET pass_cng='".$a."',try=3 WHERE phone='+7".$_POST['phone']."'");
                        setcookie("phone", "+7".$_POST['phone'], time()+60*15);
                    }
                }else{
                    $errr = "Пользователя с таким мобильным телефоном не зарегистрирован.";
                }
            } else {
                $errr = "Вы не правильно ввели номер мобильного телефона.";
            }
        } else{
            $errr = "Вы не ввели номер мобильного телефона.";
        }
    }
    
    if(isset($_POST["pass"]) && isset($_POST["pass1"]) && isset($_POST["pass_code"]) && isset($_COOKIE['phone'])){
        $mes = "Введите новый пароль и код пришедший на телефон";
        if(($_POST["pass"] != '') && ($_POST["pass1"] != '') && ($_POST["pass_code"] != '') && ($_COOKIE['phone'] != '')){   
            if($_POST["pass"] == $_POST["pass1"]){   
                $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                mysqli_query($mysqli, "SET NAMES utf8");
                $data = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT pass_cng,try FROM auth WHERE phone='".$_COOKIE['phone']."'"));
                if($data["try"] > 0){
                    mysqli_query($mysqli, "UPDATE auth SET try=try-1 WHERE phone='".$_COOKIE['phone']."'");
                    if($_POST["pass_code"] == $data["pass_cng"]){
                        $password = md5(md5(trim($_POST['pass'])));
                        mysqli_query($mysqli, "UPDATE auth SET password='".$password."',try=3,pass_cng=0 WHERE phone='".$_COOKIE['phone']."'");
                        unset($_COOKIE['phone']);  
                        setcookie('phone', null, -1, '/');
                        $fin = 1;
                        $mes = "Пароль изменен.";
                    } else {
                        if(($data['try'] - 1) > 0) {
                            $num = $data['try'] - 1;
                            $mes .= ",у вас есть ".$num." попытки:";
                            $errr = "Не правильный код.";
                        } else {
                            $fin = 1;
                            $mes = "Попытки кончились.";
                            mysqli_query($mysqli, "UPDATE auth SET pass_cng=0 WHERE phone='".$_COOKIE['phone']."'");
                            unset($_COOKIE['phone']);  
                            setcookie('phone', null, -1, '/');
                        }
                    }
                }
            } else {
                $errr = "Пароли не совпадают.";
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
 <script src="jpanelmenu.js"></script>
 <script src="jRespond.js"></script> 
 <script src='https://www.google.com/recaptcha/api.js'></script>
<script>
function getCookie(name) {
          var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
          ));
          return matches ? decodeURIComponent(matches[1]) : undefined;
        } 
function setCookie(name, value, options) { 
                                  options = options || {};
                                  var expires = options.expires;                     
                                  if (typeof expires == "number" && expires) {
                                    var d = new Date();
                                    d.setTime(d.getTime() + expires * 1000);
                                    expires = options.expires = d;
                                  }
                                  if (expires && expires.toUTCString) {
                                    options.expires = expires.toUTCString();
                                  }
                                  value = encodeURIComponent(value);
                                  var updatedCookie = name + "=" + value;
                                  for (var propName in options) {
                                    updatedCookie += "; " + propName;
                                    var propValue = options[propName];
                                    if (propValue !== true) {
                                      updatedCookie += "=" + propValue;
                                    }
                                  }
                                  document.cookie = updatedCookie+"; path=/;"; 
                                  
} 


var mobile;
        if(window.screen.width<1100) 
            mobile=true; 
        else 
            mobile=false;

    $(document).ready(function() { 
        document.body.style.overflow = "visible"; 
        var exit;
        
        if (mobile){ //alert( 'Текущая прокрутка сверху: ' + window.pageYOffset );
             var jPM = $.jPanelMenu({excludedPanelContent: "#header",
             afterOpen: function(){document.body.style.overflowX = "hidden";  },
             afterClose: function(){ document.body.style.overflowX = "visible";},
        
             });
             exit = document.getElementById("m_exit");
             exit.style.display = "block";                            
             jPM.on();
             
        } else {
            exit = document.getElementById("menu");  
            var newLi = document.createElement('li');
            var newa = document.createElement('a');
            newa.innerHTML = 'ВЫХОД';
            exit.appendChild(newLi);
            newLi.appendChild(newa);
            exit = newLi;
        } 
        
        exit.addEventListener('click',function(e){ 
             //alert("Вы уверене что хотите выйти?");  
              result = confirm("Вы уверене что хотите выйти?");  
              if (result){        
                 setCookie("name", "", {
                    expires: -1
                 });
                 setCookie("hash", "", {
                    expires: -1
                 });
                 setCookie("id", "", {
                    expires: -1
                 });
                 exit.style.display = "none"; 
                 var enter = document.getElementById("enter");
                 enter.innerHTML = "ВОЙТИ";
                 enter.href = "http://qlubbah.ru/auth.php";
                 if(mobile) location.reload();
             }
             
        });
        
        if (!getCookie("name")){exit.style.display = "none"; }
          
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
        <div id="A4">
            <div id="A4_inner">
                <div id="mes_answer">
                <?if($mes != ''){print($mes);if(!isset($fin)){?>
                
                <form action="pass_recover.php" method="post" accept-charset="UTF-8">
                    <div style="margin-top:15px"> Пароль: </div><input style="height: 20px;width:100%;" name="pass" type="password"/>
                    <div style="margin-top:15px"> Повторить пароль: </div><input style="height: 20px;width:100%;" type="password" name="pass1"/>
                    <div style="margin-top:15px"> Код: </div><input style="height: 20px;width:100%;" name="pass_code"/>
                    <input style="width:100%;margin-top:15px;" class="button7" type="submit" value="Отправить"/>
                </form>
                <?}}else{ ?>
                    Введите мобильный телефон прикрепленный к вашему аккаунту <br />(пример: 9004003020): 
                </div>
                <div>
                    <form action="pass_recover.php" method="post" accept-charset="UTF-8">
                        <input style="height: 20px;width:100%;margin-top:15px;" name="phone"/>
                        <input style="width:100%;margin-top:15px;" class="button7" type="submit" value="Отправить"/>
                    </form>
                    <?}?>
                    <p style="color:red; font-size: 18px;"><?  if (isset($errr)){ print($errr); }?> </p>
                     
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php";
         file_get_contents('footer.php');?>

</body>
</html>