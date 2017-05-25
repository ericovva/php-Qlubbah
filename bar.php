<?
    if(($_POST['login'] == "admin") && ($_POST['pass'] == "admin")){
        setcookie('bar', 'e-FYH8jnbXSFoA-bj-=j', time()+60*60*24*365*10);
        header("Location: bar.php");
    }
    if(isset($_POST['code']) && ($_COOKIE['bar'] == "e-FYH8jnbXSFoA-bj-=j")){
        $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
        mysqli_query($mysqli, "SET NAMES utf8");
        $data = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) FROM present WHERE present_code='".$_POST['code']."'"));  
        if($data['COUNT(id)'] > 0){
            mysqli_query($mysqli, "DELETE FROM present WHERE present_code='".$_POST['code']."'");  
            print("Код подтвержден.");
        }else{
            print("Код либо просрочен, либо не существует!");
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>

<body>
    <? if(($_COOKIE['bar'] != "e-FYH8jnbXSFoA-bj-=j")){ ?>
    <form action="/bar.php" method="post" accept-charset="UTF-8">
        <div>E-mail: <input name="login"/> </div></br>
        <div>Пароль: <input name="pass" type="password"/> </div></br>
        <input type="submit" value="Войти"/>
    </form>
    <? } else { ?>
    <form action="/bar.php" method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
        <div>Код посетителя: <input name="code"/></div>
        <input type="submit" value="Проверить"/>
    </form> 
    
    
    
    
    
    
    <?}?>