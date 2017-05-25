<?$auth = 0;
    if(isset($_COOKIE["id"]) && isset($_COOKIE["hash"])){
        $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
        mysqli_query($mysqli, "SET NAMES utf8");
        $bd_hash = mysqli_fetch_array(mysqli_query($mysqli, "SELECT hash FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
        if($bd_hash[0] == $_COOKIE['hash']){
            $auth_on = 1;
            $query = mysqli_query($mysqli,"SELECT * FROM auth WHERE id=".$_COOKIE['id']);
            $data = mysqli_fetch_assoc($query);
        
            if(isset($_POST["new_pass"]) && isset($_POST["new_pass_prove"]) && isset($_POST["old_pass"]) ){
                 if ($_POST["new_pass"] == $_POST["new_pass_prove"]){
                   if (md5(md5(trim($_POST['old_pass']))) == $data["password"]){
                      $new_pas =  md5(md5(trim($_POST['new_pass'])));
                      mysqli_query($mysqli, "UPDATE auth SET password='".$new_pas."' WHERE id='".$_COOKIE['id']."' ");
                   }
                   else $mes = "Старый пароль введён неверно";
                
                }
                else $mes = "Пароли не совпадают";
            }
            
        } else {
            unset($_COOKIE['hash']);
            unset($_COOKIE['id']);  
            unset($_COOKIE['name']);  
            setcookie('hash', null, -1, '/');
            setcookie('id', null, -1, '/');
            setcookie('name', null, -1, '/');
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
 <script src="http://qlubbah.ru/js/header.js"></script> 
</head>
<body>

    


	   	<?php include "header.php";
         file_get_contents('header.php');?>
	
	<div  id="block1">
            <div id="A4">
    
                <div id="A4_inner" >
                    <div style="font-size: 25pt;"> 
                        Профиль:  
                    </div> <br />
                    <!--<a href="reg.php" style="text-decoration:underline; font-style: italic;">зарегистрируйтесь </a> <br/><br/> --> 
                    <form action="/profile.php" method="post" accept-charset="UTF-8">  
                        <div >
                            Имя: <span style="font-style: italic;"><? print($data['name']); ?> </span>
                        </div> 
                        <div >
                            Моб. телефон:  <span style="font-style: italic;"><? print($data['phone']); ?> </span>
                        </div> 
                        <div >
                            E-mail:  <span style="font-style: italic;"><? print($data['email']); ?> </span>
                        </div> 
                        <div >
                            Промокод:  <span style="font-style: italic;"><? print($data['present_code']); ?> </span>
                        </div>
                        <br/>
                        <div style="font-size: 16pt;">
                            Если хотите сменить пароль, заполните поля
                        </div>
                        <br/>
                        <? print("$mes"); ?>
                        Старый пароль:
                        <input style="width:100%; height: 30px; font-size:20px;" name="old_pass" type="password"/> <br/> <br/>
                        Новый пароль:
                        <input style="width:100%; height: 30px; font-size:20px;" name="new_pass" type="password"/> <br/> <br/>
                        Повторите пароль:
                        <input style="width:100%; height: 30px; font-size:20px;" name="new_pass_prove" type="password"/> <br/> <br/>
                        <input style="width:100%;" class="button7" type="submit" value="Сменить"/>
                    </form>
                    <p style="color: red;font-size: 13px;"><?  if (isset($errr)){ print($errr); }?> </p>
                </div>
            </div>
    
    
	</div>
    


    <?php include "footer.php";
         file_get_contents('footer.php');?>

</body>
</html>