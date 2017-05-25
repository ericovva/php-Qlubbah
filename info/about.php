<!DOCTYPE html>
<html >
<head>
 <title> Qlubbah </title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
 <link rel="stylesheet" href="../style/content_style.css"/>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
     <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

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

          

</script>
<script>

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
</script>
</head>
<body>

    


	  <?php include "../header.php" ?>
        <? file_get_contents('../header.php');?>

        <div  id="block1">
            <div id="A4" style="height:auto;">
    
    <h1>Qlubbah позволяет проверить заведение в режиме реального времени.</h1>
    <div style="padding: 30px; font-family: helvetica neue, helvetica, arial, sans-serif; font-size: large;">

	

    
  



<pre style="white-space: pre-line;font-family: helvetica neue, helvetica, arial, sans-serif; font-size: large;">
Как найти подходящее место для отдыха на сегодняшнюю ночь? Возможно ли заранее подобрать клуб или бар по определенным параметрам? Хочешь узнать сколько девушек и парней развлекаются сейчас на танцполе твоего любимого заведения? 

С Qlubbah теперь это стало возможным!

Новое революционное мобильное приложение Qlubbah совсем скоро будет доступно в AppStore и GooglePlay совершенно бесплатно!

Одним кликом сервис позволит Вам наблюдать за аудиторией клуба в режиме реального времени, а именно - узнать количество посетителей, их пол и возраст, не выходя из дома. С нами Вы будете в курсе всех самых ярких ночных событий Москвы, у Вас появится возможность участвовать в различного рода акциях и промо-предложениях. 


</pre>

    </div>
    </div>
    
    
	</div>
    


    <?php include "../footer.php";
         file_get_contents('../footer.php');?>

</body>
</html>