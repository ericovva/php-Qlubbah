<?php
    $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
    mysqli_query($mysqli, "SET NAMES utf8");
    $auth_on = 0;
    if(isset($_COOKIE['id']) && isset($_COOKIE['hash'])){    
        $bd_hash = mysqli_fetch_array(mysqli_query($mysqli, "SELECT hash FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
        if($bd_hash[0] == $_COOKIE['hash']){
            $auth_on = 1;
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
    <link rel="stylesheet" href="style/styles.css"/>
    <link rel="stylesheet" href="style/m_styles.css"/>
    <link rel="stylesheet" href="style/list_view.css"/>
    <link rel="stylesheet" href="style/m_list_view.css"/>
    <link rel="stylesheet" href="style/owl.carousel.css"/>
    <link rel="stylesheet" href="style/owl.theme.css"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="http://qlubbah.ru/js/header.js"></script>
    <!-- PROGRESS - BAR -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<script>
    var mobile;
    var id_list = [];
    
    if(window.screen.width < 1100) mobile = true; else mobile = false;
    
    $(document).ready(function() { 
        var fl = false;
        // выдвигающаяся сортировка
        document.getElementById("sort_list").addEventListener("click", function(){
            if (fl) 
                $('#sort_div').fadeOut(400, 'swing', function(){});
            else 
                $('#sort_div').fadeIn(400, 'swing', function(){});
            fl = !fl;
        });

        
    });
</script>
<style>
    .item img{
        display: block;
        width: 100%;
        //height: 350px;
    }
    .close{
        z-index: 2;
		float:right;
		margin-top: 5px;
        margin-right: 5px;
		cursor: pointer;
	}
</style>
<script>
    function comment_send(eleme){
        $.post("comment.php", {mes: $("#comment" + eleme).val(),club_id: eleme,"g-recaptcha-response": grecaptcha.getResponse(id_list[eleme])}).done(function( data ) {
            if(data == '1'){
                $("#well_done" + eleme).text("Ваш отзыв теперь ожидает модерации.");
                $("#comment" + eleme).val("");
                grecaptcha.reset(id_list[eleme]);
                $("#well_done" + eleme).css('color', "#009900");
            }
            if(data == '2'){
                $("#well_done" + eleme).text("Вы не прошли капчу.");
                $("#well_done" + eleme).css('color', "#990000");
            }
            if(data == '3'){
                $("#well_done" + eleme).text("Вы ввели пустой отзыв.");
                $("#well_done" + eleme).css('color', "#990000");
            }
        });
    }

    function show(state1){
        var state = document.getElementById('window' + state1);
        
        if(state.style.display == 'block'){
            <?if($auth_on == 1){?>
            $("#well_done" + state1).text("");
            <?}?>  
            if(mobile){ 
                state.style.display = 'none'; 
                document.getElementsByClassName('jPanelMenu-panel')[0].style.display = "block";
                document.getElementById("jPanelMenu-menu").style.display = "block";
                document.getElementById("header").style.display = "block";
                state.appendChild(document.getElementById('close' + state1));
            } else {
                $(state).fadeOut(300, 'swing', function(){});
                $('#dark_fone').fadeOut(600, 'swing', function(){});
                document.body.style.overflowY = 'visible';
            }
            window.scrollTo(0,a);
        } else {
            <?if($auth_on == 1){?>
            if(id_list[state1] === undefined){
                id_list[state1] = grecaptcha.render('gcaptch' + state1, {'sitekey' : '6LeX8QoTAAAAALCJE_RfiE2apjAxioFjIcsHzJI1'});
            }
            <?}?>
            window.a = document.documentElement.scrollTop || document.body && document.body.scrollTop || 0 - document.documentElement.clientTop; 
            if(mobile){
                state.style.display = "block";
                document.getElementsByClassName('jPanelMenu-panel')[0].style.display = "none";
                document.getElementById("jPanelMenu-menu").style.display = "none";
                document.getElementById("header").style.display = "none";
                document.body.appendChild(state);
                document.body.appendChild(document.getElementById('close' + state1));
            } else { 
                $(state).fadeIn(300, 'swing', function(){});
                $('#dark_fone').fadeIn(600, 'swing', function(){});    
                document.body.style.overflow = 'hidden';                      
            }                        
        }
        
    }
    
    function adder(val_id){
        var a;
        var id = document.getElementById("l" + val_id).childNodes[3];
        var id_img = document.getElementById("l" + val_id).childNodes[1];   
        $.post("likes.php", {id: val_id});
        if(id_img.style.backgroundImage == 'url(http://qlubbah.ru/img/like_active.png)'){
            id_img.style.backgroundImage = 'url(img/like_passive.png)';
            id.style.fontWeight = "normal";
            a = parseInt(id.innerHTML,10) - 1;
        } else {
            id_img.style.backgroundImage = 'url(img/like_active.png)';
            id.style.fontWeight = "bold";
            a = parseInt(id.innerHTML,10) + 1;
        }
        
        id.innerHTML = String(a);
    }
    
</script>
</head>
<body>
    <?  include "header.php";
    file_get_contents('header.php');?>
    <div id="dark_fone" style="display:none; height: 100%;width: 100%; margin-top: 55px; position:fixed; background-color: #000;opacity: 0.87; z-index:100;"> </div>

	<div id="block1">
        <h1 style="text-align: center"> MОСКВА </h1> 
        <div style="margin:0 auto; width: 100%; text-align: center;font-size:13px; margin-bottom: 3px;">С О Р Т И Р О В К А</div> 
        <div id="sort_list" style="text-align: center;"></div>
        <div id="sort_div" style="text-align: center; ">
            <form action="http://qlubbah.ru/list_view.php" method="POST" target="_self" style="float: left;">
                <input type="submit" name="name" value="По названию" style="height: 50px; -webkit-appearance: none;"class="button7" />
                <input type="submit" name="women" value="Больше женщин"style="height: 50px; -webkit-appearance: none;"class="button7" />
                <input type="submit" name="men" value="Больше мужчин" style="height: 50px; -webkit-appearance: none;"class="button7"/>
                <input type="submit" name="stars" value="По рейтингу" style="height: 50px; -webkit-appearance: none;"class="button7"/>
                <input type="submit" name="age" value="По возрасту" style="height: 50px; -webkit-appearance: none;"class="button7"/>
                <input type="submit" name="favorite" value="По количеству" style="height: 50px; -webkit-appearance: none;"class="button7"/>
            </form> 
        </div>
        
		<?  
            $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY club_name"); 
            if (isset($_POST['name'])) {
                $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY club_name");
            } else if (isset($_POST['stars'])) {
                $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY likes DESC");
            } else if (isset($_POST['men'])) {
                $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY male DESC");
            } else if (isset($_POST['women'])) {
                $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY female DESC");
            } else if (isset($_POST['age'])) {
                $result = mysqli_query($mysqli, "SELECT * FROM club ORDER BY age DESC");
            } /*else if (isset($_POST['favorite']) && ($auth_on == 1)){
                $club_like_list_mas = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT likes_list FROM auth WHERE id='".$_COOKIE['id']."'")); 
                $abc = trim($club_like_list_mas['likes_list'], ',');
                $result = mysqli_query($mysqli, "SELECT * FROM club WHERE id in (".$abc.")");
            }*/
        while ($row = mysqli_fetch_assoc($result)) {
            
        ?><style>
           #window<?print($row['id'])?>::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-top: 5px red solid;
                border-color: #f3c800; 
                background-color: #000000;
            }

            #window<?print($row['id'])?>::-webkit-scrollbar
            {
                width: 10px;
                background-color: #f3c800;
            }

            #window<?print($row['id'])?>::-webkit-scrollbar-thumb
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #f3c800;
            }
        </style><?
                $photo_list = explode(',', $row['photo']);
                print('<div id="window'.$row['id'].'" class="windows" style="display: none;">
                        <img id="close'.$row['id'].'" class="close" onclick="show('.$row['id'].')" src="/img/close_admin.png"/>');
  //Слайдер              
                print('<div class="owl_user"><div style="height:auto;" id="owl-demo'.$row['id'].'" class="owl-carousel owl-theme">');
                foreach($photo_list as $photo){
                    print('<div class="item"> <img src="'.$photo.'"/> </div>');
                } 
                print('</div></div>');
  //Рассказ о клубе 
                print('<div style=" font-size: 18px; padding:20px; " class="about_club_in_window"><pre style="white-space: pre-line;font-family: \'Rubik\', sans-serif;">'.$row['about'].'</pre></div>');
  //Коменты
                print('<div id="comment_block">');
                $comment_result = mysqli_query($mysqli, "SELECT * FROM comment WHERE club_id='".$row['id']."' AND ok=1");
                while($comment_show = mysqli_fetch_assoc($comment_result)){ //print("<hr/>");
                    print('<div class="comment_block" style="padding: 4px 4px 4px 40px; margin-bottom:25px; ;"><div class="commentator">'.$comment_show['name'].'</div><div class="comment_time">'.date('Y-m-d, G:i', $comment_show['time']).'</div><br/><div id="club_comment"><pre style="white-space: pre-line;">'.$comment_show['comment'].'</pre></div><br/></div>');
                }
                print('</div>');
  //Добавить коменты
                
                if($auth_on){
                    print('<div><textarea class="put_comment" id="comment'.$row['id'].'"></textarea><div style="float: right;"id="gcaptch'.$row['id'].'" ></div><div class="well_done" id="well_done'.$row['id'].'"></div><button onclick="comment_send('.$row['id'].');" id="submit" class="button7" >Оставить отзыв</button></div>');
                }
                print('</div>');
            ?>
            <script>
                $(document).ready(function() {
                    $("#owl-demo<?print($row['id']);?>").owlCarousel({
                        slideSpeed : 300,
                        paginationSpeed : 400,
                        singleItem:true,
                        navigation : true
                    });
                });
                
            </script>

			<div class="list_element" style="float: left;" > 
                <div id="list_elem_innner">
                    <div class="list_img"> <img id="club_img"  src="<?print($photo_list[0]); ?>" /> </div>
                    <div class="list_element_text" style=" font-weight: 700px; font-size: 20px;color: #fff; font-family: 'Bebas';" > <? print($row['club_name']); ?> </div>
                                <div class="list_element_text" > <a  class="adres_a"  href="map.php?x=<? print($row['x']);?>&y=<? print($row['y']);?>"><? print($row['club_place']); ?></a> </div>
                                <div class="list_element_text" > <img alt="Мужчины: " title="Мужчины" class="mw_icon"  src= "img/male.png" /> <span class="mw_text"> <? print($row['male']."%&nbsp;&nbsp;&nbsp;");?></span><img alt="Средний возраст: " title="Средний возраст" class="mw_icon" src="img/age.png"/><span class="mw_text">&nbsp;<? print($row['age']." года");?> </span>  </div>
                                <div class="list_element_text" > <img alt="Женщины: " title="Женщины" class="mw_icon"  src= "img/female.png" /> <span class="mw_text"> <? print($row['female']."%&nbsp;&nbsp;");?> </span><img alt="Средний возраст: " title="Средний возраст" class="mw_icon" src="img/age.png"/><span class="mw_text">&nbsp;<? print($row['age']." года");?> </span>   </div>
                             
                                 <div class="list_element_text" ><div class="aaa" id="progressDiv"></div> </div>
                                 <script type="text/javascript">
                                        //progress-bar 
                                        $(function() {
                                            $('#progressDiv').progressbar({
                                                value: <? $v = (integer)($row['people']/50*100); $a = 12.5 *100*((integer)($v/10)) / 120;  print($a);?>
                                                
                                            });
                                        });
                                 </script>
                                 <style>
                                 @media screen and (max-width: 600px){.aaa{margin: 0 auto;}}
    #progressDiv .ui-progressbar-value { background: #000  url(img/person-icon-active.png) !important; ;  
        display: block!important} 
    .ui-progressbar {height:35px;width:120px;text-align:center;    border:none;}
    .ui-widget-content{background: #000 url(img/person-icon.png)  !important; }
    
</style>
                      
                               <!-- <div class="list_element_text" > <img class="mw_icon" src="img/age.png"/> <span class="mw_text"> <? print($row['age_female']." года");?> </span>  </div>
                                <div class="list_element_text" > <img class="mw_icon" src="img/age.png"/> <span class="mw_text"> <? print($row['people']." человека");?> </span>  </div>
                                -->
                                <div class="list_element_text" id="the_last_list_element_text">  <div class="about_club" style="cursor: pointer; color: rgb(255, 140, 0); font-size: 14px;  font-weight: bold; text-decoration: underline;"  onclick="show('<?print($row['id'])?>');"><div class="club_info_img" style="margin-top: -3px; padding-right: 5px;"><img width="20px" height="20px"  src="img/info.png"/></div>   О заведении   </div></div>
                                
                                
<!--Лайки -->
                                
                    <div class="likes" id="l<?print($row['id'])?>" <?if($auth_on == 1){print("onclick=\"adder(".$row['id'].")\"");}?> >
                      <div style="width: 27px; height: 27px;  float:left; margin-right:10px; 
                           <?
                            if($auth_on == 1){
                                $like_list = mysqli_fetch_array(mysqli_query($mysqli, "SELECT likes_list FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
                                if(strrpos($like_list[0] ,','.$row['id'].',') === false){?>
                           background-image: url(img/like_passive.png);
                           <?}else{?>
                           background-image: url(img/like_active.png);  
                           <?}}else{print('background-image: url(img/like_passive.png);');}?>
                           background-repeat: no-repeat;background-size: cover;"></div>
                      <div style="float:left; font-weight:<?if($auth_on == 1){if(strrpos($like_list[0] ,','.$row['id'].',') === false){print("normal");}else{print("bold");}}else{print("normal");}?>; margin-top: 7px;"><? print($row['likes']);?> </div>
                      
                    </div>
                </div>
			</div>
			<?}?>
	</div>
    
    <?php include "footer.php";
         file_get_contents('footer.php');?>
</body>
</html>