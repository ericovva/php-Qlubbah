<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Карта</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
     <link rel="stylesheet" href="style/styles.css"/>
     <link rel="stylesheet" href="style/m_styles.css"/>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="js/jpanelmenu.js"></script>
<style>
html { overflow:  hidden; }
</style>
     
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
                                  document.cookie = updatedCookie;
} 


</script>
    <script type="text/javascript">
    /////////////////////////////////////////
    var mobile;
        if(window.screen.width<1100) 
            mobile=true; 
        else 
            mobile=false;

 $(document).ready(function() {
        document.getElementById('map_yandex').style.height = parseInt(document.documentElement.clientHeight) - 55 + 'px';
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
             
        }
        else{
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
    
    
    var current_route;
        function vvv(map,x,y){
            navigator.geolocation.getCurrentPosition(
    function(position) {
      //alert('Последний раз вас засекали здесь: ' + position.coords.latitude + ", " + position.coords.longitude);
      
            
            ymaps.route([
               [position.coords.latitude , position.coords.longitude], [x,y]


              ],{mapStateAutoApply: true}).then(
    function (route) {
       var points = route.getWayPoints(),
            lastPoint = points.getLength() - 1;
             points.get(0).properties.set('iconContent', 'Я');
        points.get(lastPoint).properties.set('iconContent', '');
        points.options.set('preset', {
                    iconImageHref: 'http://qlubbah.ru/img/vk_logo.png', // картинка иконки
                    iconImageSize: [32, 37], // размеры картинки
                    
        });

        if (current_route) map.geoObjects.remove(current_route);
        current_route = route;
        map.geoObjects.add(route);
    },
    function (error) {
        alert('Возникла ошибка: ' + error.message);
    }
);
  }
);
        }
        ymaps.ready(init);
        var myMap;

        function init(){ 
            myMap = new ymaps.Map("map_yandex", {
                <?if(isset($_GET['x']) && isset($_GET['y'])){
                    print('center: ['.$_GET['x'].','.$_GET['y'].'],zoom:15,');
                 } else {  ?>
                center: [55.734, 37.622093],
                zoom: 11,
                <?}?>
                controls: ['geolocationControl','searchControl','trafficControl','typeSelector']
            }); 
			myMap.controls.add('routeEditor',{float: "none",position:{top:50,right:10}});
/*
navigator.geolocation.getCurrentPosition(
    function(position) {
      //alert('Последний раз вас засекали здесь: ' + position.coords.latitude + ", " + position.coords.longitude);
      myMap.controls.add('routeEditor',{float: "none",position:{top:50,right:10}});
            
            ymaps.route(['Москва', [position.coords.latitude , position.coords.longitude]]).then(
    function (route) {
        myMap.geoObjects.add(route);
    },
    function (error) {
        alert('Возникла ошибка: ' + error.message);
    }
);
  }
);
*/


            
            
            <?
            $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
            mysqli_query($mysqli, "SET NAMES utf8");
            $result = mysqli_query($mysqli, "SELECT * FROM club");
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                print("
                myPlacemark".$i." = new ymaps.Placemark([".$row['x'].", ".$row['y']."], {
                    hintContent: '".$row['club_name']."',
                    balloonContentHeader:'".$row['club_name']."',
                    balloonContent:'<p style=\"font-family: \'Rubik\', sans-serif;\"><span style=\"font-weight: bold;\">".$row['club_place']."</span><br/> Мужчин:&nbsp".$row['male']."% <br/> Женщин:&nbsp".$row['female']."% <br/> Средний возраст:&nbsp".$row['age']."<br/>  <button class=\"button7\" id=\"m$i\" onClick=\' vvv(myMap,".$row['x'].",".$row['y'].");  \'> Построить маршрут </button> </p>'
                  }");
                if($row['logo'] != '')
                    print("
                    ,{
                    iconLayout: 'default#image',
                    iconImageSize: [47, 52],
                    iconImageHref:'".$row['logo']."',
                    iconImageOffset: [-24, -45] // смещение картинки    
                    }");
                print(");\n");
                $i++;
            }
            for($t = 0; $t < $i; $t++){
                print("myMap.geoObjects.add(myPlacemark".$t.");\n");
            } /*
              $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
            mysqli_query($mysqli, "SET NAMES utf8");
            $result = mysqli_query($mysqli, "SELECT * FROM club");
             $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                print("document.getElementById('m$i').addEventListener('click',f$i);");
                $i++;
            } */
            ?>


             var cityList = new ymaps.control.ListBox({
                  data: {
                    content: 'Список заведений'
                  },
                  items: [ 
                  <?   
                    $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                    mysqli_query($mysqli, "SET NAMES utf8");
                    $result = mysqli_query($mysqli, "SELECT * FROM club");
                    $result = mysqli_query($mysqli, "SELECT * FROM club"); 
                    while ($row = mysqli_fetch_assoc($result)) { 
                      $name = $row['club_name'];
                      print("new ymaps.control.ListBoxItem('$name'),"); 
                    }
                  ?>
                   ],
                   options: {
                      itemSelectOnClick: false
                    }
              });

             <? $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
                    mysqli_query($mysqli, "SET NAMES utf8");
                    $result = mysqli_query($mysqli, "SELECT * FROM club");
                    $result = mysqli_query($mysqli, "SELECT * FROM club"); 
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) { print("
                      cityList.get($i).events.add('click', function () {
                          myMap.setCenter([".$row['x'].", ".$row['y']."],15);
                      }); ");
                        $i++;
                    }?>

       myMap.controls.add(cityList);
            
            
            //myMap.controls.add('searchControl',{
              //  float: "none",position:{top:50,left:50}
            //});
        }
    </script>
</head>

<body style="overflow-x: hidden;">

    	<?php include "header.php";
         file_get_contents('header.php');?>

    <div id="map_yandex" style="margin-top: 55px; width: 100%;"></div>
</body>

</html>