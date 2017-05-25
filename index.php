<!DOCTYPE html>
<html >
<head>
 <title> Qlubbah </title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
 <link rel="stylesheet" href="style/m_styles.css"/>
 <link rel="stylesheet" href="style/styles.css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="http://qlubbah.ru/js/index.js"></script> 
  <script src="http://qlubbah.ru/js/header.js"></script>

  

</head>
<body>

	<?php include "header.php";
         file_get_contents('header.php');?>
	
	<div  id="block1">
            <div id="content1" style="height:  100%;width:  100%; margin: 0 auto;">
    		<h1> 
    			Qlubbah - твоё ночное видение
    		</h1>
    		<h2>
                <?if(!(isset($_COOKIE['id']) && (isset($_COOKIE['hash'])))){?>
    			Поделись своим промокодом с друзьями и получи подарок после <a href="http://qlubbah.ru/reg.php">регистрации</a>! 
                <?}?>
    		</h2>
                <div id="apps">
                    <h3> Наблюдайте за аудиторией заведения в реальном времени!</h3>
                    <div id="app_apple" ><a id="apple_href" href="#block2" style="display: block; height: 100%;"></a></div>
                    <div id="app_desktop"> <a id="desktop_href" href="#block2" style="display: block; height: 100%;"></a></div> 
                    <br /><br /><br /><br /><br />
                    
                </div>
                
                <div id="arrow">
                    <a  id="arrow_href" href="#block2" style="display: block; height: 100%;"> </a>
                </div>
            </div>
	</div>
    
	<div  id="block2"> 
            <div id="choose_div">
                <h4>ВЫБЕРИТЕ СПОСОБ ПРОСМОТРА ЗАВЕДЕНИЙ</h4>
                <div id="choose">
                <div id="map_block">
                    <div id="map"><a class="text" href="http://qlubbah.ru/map.php" style="display: block; height: 100%;" ></a></div>
                    <div id="map_text"><a class="text" href="http://qlubbah.ru/map.php">Посмотреть на карте</a></div>
                </div>
                 <div id="list_block"> 
                     <div id="list"><a class="text" href="http://qlubbah.ru/list_view.php" style="display: block; height: 100%;"></a></div>  
                    <div id="list_text"><a class="text" href="http://qlubbah.ru/list_view.php">Посмотреть списком</a></div>  
                 </div>  
                            
                </div>
            
            </div>
                <div id="quotes">
                    <P STYLE="font-family: Bebas; font-weight: bold; font-size: 25px;">ПОПУЛЯРНЫЕ ОТЗЫВЫ ПОЛЬЗОВАТЕЛЕЙ</P>
                    <hr/>
                    <div class="quotes_line">
                        <div  class = "quotes_text first_quote">
                            ".. невероятная технология, которая позволяет вам знать, 
                            что находится за дверью, прежде чем вы в неё войдёте .."
                            <br /> <br /> <br /> <p style="text-align: center; font-weight: bold; font-size: 25px; font-family:Verdana;">Самуэль</p>
                        </div>
                        <div  class = "quotes_text">
                            ".. вы можете понять все это прежде чем покинете свою квартиру."
                        <br /> <br /> <br /> <p style="text-align: center; font-weight: bold; font-size: 25px; font-family:Courier;">Дима</p>
                        </div>
                    </div>
                    <div class="quotes_line" >
                        <div id="first_quotes_line" class = "quotes_text"> 
                            ".. больше меня не будет заботить вопрос о том, в каком клубе лучше отпраздновать ДР, 
                            благодаря этому сервису я смогу выбрать место, которое подойдет для меня и моих гостей." 
                            <br /> <br /> <br /> <p style="text-align: center; font-weight: bold; font-size: 25px; font-family:Monospace;">Настюша</p>
                        </div>
                        <div class = "quotes_text">"Всегда мечтал узнать, в каком клубе больше девушек. 
                            Будет интересно анализировать обстановку, находясь у себя дома..."
                            <br /> <br /> <br /> <p style="text-align: center; font-weight: bold; font-size: 25px; font-family:Comic Sans;">Пётр</p>
                        </div> 
                    </div>
                </div>
            
            
	</div>	

    <?php include "footer.php";
         file_get_contents('footer.php');?>

</body>
</html>