<?
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
    if(!(isset($_COOKIE["id"]) && isset($_COOKIE["hash"]))){
        if(isset($_POST["login"]) && isset($_POST["pass"])){
            $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");    
            mysqli_query($mysqli, "SET NAMES utf8");
            $query = mysqli_query($mysqli, "SELECT id,name,password FROM auth WHERE email='".$_POST['login']."' LIMIT 1");
            $data = mysqli_fetch_assoc($query);
            if($data['password'] == md5(md5($_POST['pass']))){
                $hash = md5(generateCode(10));
                mysqli_query($mysqli, "UPDATE auth SET hash='".$hash."' WHERE id='".$data['id']."'");
                setcookie("id", $data['id'], time()+60*60*24*365*10);
                setcookie("hash", $hash, time()+60*60*24*365*10);
                setcookie("name", $data['name'], time()+60*60*24*365*10);
                header("Location: index.php");
                //exit();
            }else{
                $errr = "Неверный логин или пароль";
            }      
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
    
                <div id="A4_inner">
                    <div> 
                        Пожалуйста авторизуйтесь или 
                    </div> 
                    <a href="reg.php" style="text-decoration:underline; font-style: italic;">зарегистрируйтесь </a> <br/><br/> 
                    <form action="/auth.php" method="post" accept-charset="UTF-8">  
                        <div style="font-style: italic;">
                            E-mail: 
                        </div> 
                        <input style="width:100%; height: 30px; font-size:20px;"name="login"/> <br/> <br/> 
                        <div style="font-style: italic;">
                            Пароль: 
                        </div> 
                        <input style="width:100%; height: 30px; font-size:20px;" name="pass" type="password"/> <br/> <br/>
                        <a style="text-decoration:underline; font-style: italic;" href="pass_recover.php" >Забыли пароль? </a>  <br/> <br/>
                        <input style="width:100%;" class="button7" type="submit" value="Войти"/>
                    </form>
                    <p style="color: red;font-size: 13px;"><?  if (isset($errr)){ print($errr); }?> </p>
                </div>
            </div>
    
    
	</div>
    


    <?php include "footer.php";
         file_get_contents('footer.php');?>

</body>
</html>