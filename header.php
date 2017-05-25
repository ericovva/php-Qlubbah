<link rel="stylesheet" href="http://qlubbah.ru/style/header.css"/>
<link href="http://fonts.googleapis.com/css?family=Ledger|Rubik|Kurale&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css"/>	
<script src="http://qlubbah.ru/js/jpanelmenu.js"></script>
<script src="http://qlubbah.ru/js/jRespond.js"></script>

<header id="header">
		<div id="top">
 	        <div class="menu-trigger" id="trigger"  ></div>
			<nav id="links" >
				<a id="qlubbah_logo" href="http://qlubbah.ru/"> 
                                     <div style="float:left"> <img src="http://qlubbah.ru/img/logo.png" width = "45px"  height = "45px" style="margin-top:1px;"/> </div>
                                     <div  style="float:left; margin-top: 15px;"> LUBBAH </div>  
                                </a> 
				<ul  class="menu_button" id="menu"> 
						<li>  <a href="http://qlubbah.ru/map.php">КАРТА</a>  </li>
						<li>  <a href="http://qlubbah.ru/list_view.php">МЕСТА</a>  </li>

						 <? if(!(isset($_COOKIE["id"]) && isset($_COOKIE["hash"]))){ ?>
                        <li>  <a  href="http://qlubbah.ru/auth.php"> ВОЙТИ </a>  </li>
                         <? } else { ?>
                         <li >  <a   id="enter" href="http://qlubbah.ru/profile.php"> ПРОФИЛЬ </a>  </li>	
                         <li id="exit" style="display:none;" > <a> ВЫЙТИ </a>  </li> 
                         <? } ?>		
				</ul>
                
			</nav>
		</div>
        <div id="m_exit" style="display:none;">  </div>
	</header>