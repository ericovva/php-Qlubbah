;(function() {	
     $(document).ready(function() { 
         var mobile;
        if(window.screen.width<1100) 
            mobile=true; 
        else 
            mobile=false;
    
        $("#arrow_href").click(function () {  
			var elementClick = $(this).attr("href");
			var destination = $(elementClick).offset().top; 
		    
				$('body').animate({ scrollTop: destination }, 1100); 

			return false; 
		});  
                $("#desktop_href").click(function () {  
			var elementClick = $(this).attr("href");
			var destination = $(elementClick).offset().top; 
		    alert("Наше приложение в стадии разработки,вы можете оставить отзыв о нашем проекте на странице \"Свяжитесь с нами\", а также воспользоваться мобильной версией нашего сайта");
				$('body').animate({ scrollTop: destination }, 1100); 

			return false; 
		});  $("#apple_href").click(function () {  
			var elementClick = $(this).attr("href");
			var destination = $(elementClick).offset().top; 
		    alert("Наше приложение в стадии разработки,вы можете оставить отзыв о нашем проекте на странице \"Свяжитесь с нами\", а также воспользоваться мобильной версией нашего сайта");
				$('body').animate({ scrollTop: destination }, 1100); 

			return false; 
		}); 
                ///////Кнопки ,опускающиеся вниз/////////
                if (!mobile){
                        $("#app_desktop").hover(function() {
        		    $(this).stop().animate({ marginTop: "-10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});$("#app_desktop").hover(function() {
        		    $(this).stop().animate({ marginTop: "-10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});
                        $("#app_apple").hover(function() {
        		    $(this).stop().animate({ marginTop: "-10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});$("#app_apple").hover(function() {
        		    $(this).stop().animate({ marginTop: "-10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});
				$("#map").hover(function() {
        		    $(this).stop().animate({ marginTop: "10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});
				$("#list").hover(function() {
        		    $(this).stop().animate({ marginTop: "10px" }, 200);
        		    $(this).parent().find("span").stop().animate({ marginTop: "18px", opacity: 0.25 }, 200);
        		},function(){
        		    $(this).stop().animate({ marginTop: "0px" }, 300);
        		    $(this).parent().find("span").stop().animate({ marginTop: "1px", opacity: 1 }, 300);
        		});
                }
                
          	});
})();