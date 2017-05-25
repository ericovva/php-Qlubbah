;(function() {
    
    
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
             //afterOpen: function(){document.body.style.overflowX = "hidden";  },
             //afterClose: function(){ document.body.style.overflowX = "visible";},
        
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
    
    
})();