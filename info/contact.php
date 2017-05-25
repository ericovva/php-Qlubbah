<?php
    if(isset($_POST["letter_poster_name"]) && isset($_POST["letter_poster_mail"]) && isset($_POST["message"])){
        $message = "Line 1\r\nLine 2\r\nLine 3";
        $message = wordwrap($_POST["message"], strlen ( $_POST["message"] ), "\r\n");
        $from = "root@server";
        $headers = "User From: $from";
        mail('karen0734@gmail.com', 'My Subject',"привет");
    }
    mail('karen0734@gmail.com', 'My Subject',"привет");

?>

<!DOCTYPE html>
<html >
<head>
 <title> Qlubbah </title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
 <link rel="stylesheet" href="../style/auth.css"/>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
 <script src="http://qlubbah.ru/js/header.js"></script>
</head>
<body>

    


	   <?php include "../header.php" ?>
        <? file_get_contents('../header.php');?>
	
	<div  id="block1">
            <div id="A4">
    
                <div id="A4_inner" style="margin-right: 20px; width: 90%;">
                    <div> 
                            
                    </div> 
                    <form action="http://qlubbah.ru/info/contact.php" method="post" accept-charset="UTF-8">  
                        <div style="font-style: italic;">
                            Ваше имя: 
                        </div> 
                        <input style="width:40%; height: 30px; font-size:20px;"name="letter_poster_name"/> <br/> <br/> 
                        <div style="font-style: italic;">
                            E-mail: 
                        </div> 
                        <input style="width:40%; height: 30px; font-size:20px;"name="letter_poster_mail"/> <br/> <br/> 
                        <div style="font-style: italic;">
                            Сообщение: 
                        </div> 
                        <textarea style="width:90%; height: 150px;font-size:16px;"  name="message"/> </textarea> <br/> <br/>
                        <input style="width:90%;" class="button7" type="submit" value="Отправить"/>
                    </form>
                    <p style="color: red;font-size: 13px;"><?  if (isset($errr)){ print($errr); }?> </p>
                </div>
            </div>
    
    
	</div>
    


    <?php include "../footer.php";
         file_get_contents('../footer.php');?>

</body>
</html>