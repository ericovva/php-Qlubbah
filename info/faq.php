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
    
    <h1>FAQ</h1>
    <div style="padding: 20px; font-family: helvetica neue, helvetica, arial, sans-serif; font-size: large;">
Право на конфиденциальность незыблемо. Его соблюдение - наша обязанность.
</br></br>
О ЗАДАЧАХ QLUBBAH.
</br></br>
Нашей первостепенной задачей является сохранение и безопасное использование информации о посетителях заведений Москвы которые сотрудничают с Qlubbah. Мы используем только самые передовые технологии, главная особенность которых - надежность.
Подробнее о Правилах Использования и Политике Конфиденциальности. (Встроенные ссылки на страницы)
</br></br>
ВОПРОС-ОТВЕТ.
</br></br>
В: Какие персональные данные использует Qlubbah?</br>
О: Используя систему анонимной видеоаналитики, мы получаем лишь краткую демографическую информацию о посетителях (пол и возраст).
</br></br>
В: Способна ли система распознать мою личность?</br>
О: НЕТ. Камеры и датчики, которые мы используем, не обладают данной функцией. Кроме того невозможно осуществление видеосъемки. Мы храним лишь числовые данные для отображения статистики.</br></br>

В: В описании указано, что приложение предоставляет информацию в режиме онлайн. Значит ли это что обновление данных происходит сразу же после того, как новый посетитель появляется в заведении?</br>
О: НЕТ. Обновление данных происходит с задержкой в 15 минут, так как для сбора и подготовки информации требуется время.
</br></br>

В: Насколько точна предоставляемая информация?</br>
О: Современные технологии позволяют значительно снизить количество неточных данных. В результате многочисленных проверок было установлено, что данная система подсчета посетителей способна предоставлять информацию с точностью до 85%.</br></br>

В: Как я могу узнать о скидках в мобильном приложении?</br>
О: Наш сервис не только делится информацией о различных акциях и предложениях, но и дает возможность пользователям Qlubbah стать обладателем индивидуальных бонусов, которые будущие посетители могут использовать в заведениях.

    </div>
    </div>
    
    
	</div>
    


    <?php include "../footer.php";
         file_get_contents('../footer.php');?>

</body>
</html>