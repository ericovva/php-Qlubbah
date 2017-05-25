;(function() {
     function get_browser_info(){
        var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
        if(/trident/i.test(M[1])){
            tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
            return {name:'IE',version:(tem[1]||'')};
        }   
        if(M[1]==='Chrome'){
            tem=ua.match(/\bOPR\/(\d+)/)
            if(tem!=null)   {return {name:'Opera', version:tem[1]};}
        }   
        M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
        return {
            name: M[0],
            version: M[1]
        };
    }
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
        if(mobile){
            if(state.style.display != 'block'){
                window.a = document.documentElement.scrollTop || document.body && document.body.scrollTop || 0 - document.documentElement.clientTop;
            }
            document.getElementsByClassName('jPanelMenu-panel')[0].style.transform = '';
            document.getElementsByClassName('jPanelMenu-panel')[0].style.overflowY = 'hidden';
            state.style.height = parseInt(document.documentElement.clientHeight) - 55 + 'px';
            var browser=get_browser_info();
            if (browser.name == "Safari" && (parseInt(browser.version) < 9)){
                state.style.top = '86px';
            }
        }


        if(state.style.display == 'block'){
            <?if($auth_on == 1){?>
            $("#well_done" + state1).text("");
            <?}?>
            //state.style.display = 'none';   
            if(mobile){ state.style.display = 'none'; 
                document.getElementsByClassName('jPanelMenu-panel')[0].style.overflowY = 'visible';
                //document.getElementsByClassName('jPanelMenu-panel')[0].style.WebkitOverflowScrolling = 'touch';
                window.scrollTo(0,a);
            } else{
                $(state).fadeOut(800, 'swing', function(){});
                $('#dark_fone').fadeOut(1400, 'swing', function(){});
                document.body.style.overflowY = 'visible';
                //document.body.style.WebkitOverflowScrolling = 'touch';
            }
        } else {
            <?if($auth_on == 1){?>
            if(id_list[state1] === undefined){
                id_list[state1] = grecaptcha.render('gcaptch' + state1, {'sitekey' : '6LeX8QoTAAAAALCJE_RfiE2apjAxioFjIcsHzJI1'});
            }
            <?}?>
            $(state).fadeIn(800, 'swing', function(){});//state.style.display = 'block';
            if(!mobile){
                document.body.style.overflow = 'hidden'; $('#dark_fone').fadeIn(1400, 'swing', function(){});//document.getElementById("dark_fone").style.display = "block";
            } else { 
                state.style.overflowY = 'auto';
                state.style.WebkitOverflowScrolling = 'touch';                             
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
    
    
    
    
    
    
    
})();