<?  
    error_reporting(0);
    
    $real_pos = '';
    $coordinate = ''; 
    
    $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
    mysqli_query($mysqli, "SET NAMES utf8");
    
    function yandex_pos ($func_place){     
        global $real_pos,$coordinate;
        $geocoder = json_decode(file_get_contents("https://geocode-maps.yandex.ru/1.x/?geocode=".$func_place."&format=json&results=1"),true);  
        $coordinate = explode(" ",$geocoder['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
        $real_pos = $geocoder['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AddressLine'];                       
    } 
    
    function images_adder ($file_name, $id, $type){
        global $mysqli;
        $uploadfile = 'uploads/'.$type.$id.'_0.'.pathinfo(basename($file_name['name']),PATHINFO_EXTENSION);
        move_uploaded_file($file_name['tmp_name'], $uploadfile);
        mysqli_query($mysqli, "UPDATE club SET ".$type."='".$uploadfile."' WHERE id='".$id."'");                                        
    }    
    
    function data_adder ($ip,$id){
        global $mysqli;
        $ago = time() - 60*60*24;
        $data = file_get_contents("https://aimsuite.intel.com/analytics/rpc_get_aimview_log.php?username=nikitaostroverkhov@mail.ru&password=Qlubbah&did=".$ip."&start_year=".date('Y', $ago)."&start_month=".date('m', $ago)."&start_day=".date('d', $ago)."&end_year=".date('Y', time())."&end_month=".date('m', time())."&end_day=".date('d', time())."&v=2");
        if($data != false){
            $val = explode(",", $data);
            $male = 0;
            $female = 0;
            for($i = 3;$i < count($val);$i += 4){
                if($val[$i] == "male")
                    $male++;
                if($val[$i] == "female")
                    $female++;     
                $val1 = explode("\n", $val[$i + 1]);
                $age[$val1[0]]++;
            }
            $middle = round(($age['child'] * 14 + $age['young_adult'] * 18 + $age['adult'] * 22 + $age['senior'] * 26) / ($age['child'] + $age['young_adult'] + $age['senior'] + $age['adult']));
            mysqli_query($mysqli, "UPDATE club SET male='".(100 * $male / ($male + $female))."',female='".(100 * $female / ($male + $female))."',age='".$middle."' WHERE id='".$id."'");
        } else {
            mysqli_query($mysqli, "UPDATE club SET male='0',female='0',age='Undefined' WHERE id='".$id."'");
        }        
    }
    
    if (isset($_POST['save']) && ($_COOKIE['admin'] == "e-FYH8xnbXSFoA-bL-==")) {
        mysqli_query($mysqli, "UPDATE comment SET ok=1 WHERE id=".$_POST['comment_id']);
    }else if (isset($_POST['delete']) && ($_COOKIE['admin'] == "e-FYH8xnbXSFoA-bL-==")) {
        mysqli_query($mysqli, "DELETE FROM comment WHERE id=".$_POST['comment_id']);
    }
        
    if(($_POST['login'] == "admin") && ($_POST['pass'] == "admin")){
        setcookie('admin', 'e-FYH8xnbXSFoA-bL-==', time()+60*60*24*365*10);
        header("Location: admin.php");
    }   
    
    if(isset($_POST['name']) && isset($_POST['ip']) && isset($_POST['place']) && ($_COOKIE['admin'] == "e-FYH8xnbXSFoA-bL-==")){
        if(($_POST['name'] != '') && ($_POST['ip'] != '') && ($_POST['place'] != '')){
            yandex_pos($_POST['place']);
            
            $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT COUNT(id) FROM club WHERE club_place='".$real_pos."'"), MYSQLI_NUM);
            if($data[0] == 0){
                mysqli_query($mysqli, "INSERT INTO club SET club_name='".$_POST['name']."', club_ip='".$_POST['ip']."', club_place='".$real_pos."', x='".$coordinate[1]."', y='".$coordinate[0]."', about='".$_POST['about']."'");
                
                $last_id = mysqli_insert_id($mysqli);
                
                if((isset($_FILES['file']['name'])) && (basename($_FILES['file']['name']) != '')){
                    images_adder($_FILES['file'], $last_id, 'photo');
                }
                
                if((isset($_FILES['logo']['name'])) && (basename($_FILES['logo']['name']) != '')){
                    images_adder($_FILES['logo'], $last_id, 'logo');
                }
                
                data_adder($_POST['ip'], $last_id);
            } else {
                $errr = "Уже есть клуб с таким адресом.";
            }
        }else {
            $errr = "Пустое поле";
        }
    }
    
    if(isset($_POST['name_cng']) && isset($_POST['ip_cng']) && isset($_POST['place_cng']) && isset($_POST['likes_cng']) && isset($_POST['male']) && isset($_POST['female']) && isset($_POST['age']) && ($_COOKIE['admin'] == "e-FYH8xnbXSFoA-bL-==")){
        if(($_POST['name_cng'] != '') && ($_POST['ip_cng'] != '') && ($_POST['place_cng'] != '') && ($_POST['likes_cng'] != '') && ($_POST['male'] != '') && ($_POST['female'] != '') && ($_POST['age'] != '')){
            yandex_pos($_POST['place_cng']);  
             
            $did_old = mysqli_fetch_array(mysqli_query($mysqli, "SELECT club_ip FROM club WHERE id=".$_POST['id_cng']), MYSQLI_NUM);
                            
            mysqli_query($mysqli, "UPDATE club SET club_name='".$_POST['name_cng']."', club_ip='".$_POST['ip_cng']."', club_place='".$real_pos."', likes='".$_POST['likes_cng']."', x='".$coordinate[1]."', y='".$coordinate[0]."',male='".$_POST['male']."',female='".$_POST['female']."',age='".$_POST['age']."',about='".$_POST['about_cng']."' WHERE id='".$_POST['id_cng']."'");
            
            if((isset($_FILES['add_photo']['name'][0])) && (basename($_FILES['add_photo']['name'][0]) != '')){
                $photo_list_bd = mysqli_fetch_array(mysqli_query($mysqli, "SELECT photo FROM club WHERE id=".$_POST['id_cng']), MYSQLI_NUM);
                if($photo_list_bd[0] != ''){
                    $photo_list = explode(',', $photo_list_bd[0]);
                } else {
                    $photo_list = array();
                }
                
                for($i = 0; $i < count($_FILES['add_photo']['name']); $i++){
                    $uploadfile = 'uploads/photo'.$_POST['id_cng'].'_'.(count($photo_list)).'.'.pathinfo(basename($_FILES['add_photo']['name'][$i]), PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['add_photo']['tmp_name'][$i], $uploadfile);
                    array_push($photo_list, $uploadfile);
                }
                $write_data = implode(',', $photo_list);
                mysqli_query($mysqli, "UPDATE club SET photo='".$write_data."' WHERE id='".$_POST['id_cng']."'");
                
            }
            
            if((isset($_FILES['logo_cng']['name'])) && (basename($_FILES['logo_cng']['name']) != '')){
                $logo_file = mysqli_fetch_array(mysqli_query($mysqli, "SELECT logo FROM club WHERE id=".$_POST['id_cng']), MYSQLI_NUM);
                if($photo_file[0] != '')
                    unlink($photo_file[0]);
                $uploadfile = 'uploads/logo'.$_POST['id_cng'].'.'.pathinfo(basename($_FILES['logo_cng']['name']), PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['logo_cng']['tmp_name'], $uploadfile);
                mysqli_query($mysqli, "UPDATE club SET logo='".$uploadfile."' WHERE id='".$_POST['id_cng']."'");
            }
            
            if($did_old[0] != $_POST['ip_cng']){
                data_adder($_POST['ip_cng'], $_POST['id_cng']);
            }
            
            if($_POST['photo_list_del'] != ','){
                $photo_list_bd = mysqli_fetch_array(mysqli_query($mysqli, "SELECT photo FROM club WHERE id=".$_POST['id_cng']), MYSQLI_NUM);
                $photo_list = explode(',', $photo_list_bd[0]);
                $del_list = explode(',', $_POST['photo_list_del']);
                foreach($del_list as $list_photo_val){
                    if($list_photo_val != ''){
                        unlink($photo_list[$list_photo_val]);
                        unset($photo_list[$list_photo_val]);
                    }
                }
                $write_data = implode(',', $photo_list);
                mysqli_query($mysqli, "UPDATE club SET photo='".$write_data."' WHERE id=".$_POST['id_cng']);
            }
            
        } else {
            $errr = "Пустое поле";
        } 
    }
    
    if(isset($_POST['delete']) && ($_COOKIE['admin'] == "e-FYH8xnbXSFoA-bL-==")){
        $delet_files = mysqli_fetch_array(mysqli_query($mysqli, "SELECT photo,logo FROM club WHERE id=".$_POST['delete']), MYSQLI_NUM);
        if($delet_files[0] != ''){
            $delete_photo_list = explode(',', $delet_files[0]);
            foreach($delete_photo_list as $del){
                unlink($del); 
            }
        }
            
        if($delet_files[1] != '')
            unlink($delet_files[1]);    
        mysqli_query($mysqli, "DELETE FROM club WHERE id='".$_POST['delete']."'");
        mysqli_query($mysqli, "DELETE FROM comment WHERE club_id='".$_POST['delete']."'");
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<script type="text/javascript">
    function show(state){
        if(state.style.display == 'block'){
            state.style.display = 'none';    
        } else {
            state.style.display = 'block';
        }
    }
    function image_show(image_id) {
        var s;
        s =  document.getElementById('photo_list_del').value;
        
        if(image_id.style.visibility == 'visible'){
            image_id.style.visibility = 'hidden';
            s = s.replace(',' + image_id.id.match(/\d+/)[0] + ',', ',');
        } else {
            s += image_id.id.match(/\d+/)[0] + ',';
            image_id.style.visibility = 'visible';
        }
        document.getElementById('photo_list_del').value = s;
    }		
</script>
<style>
    .windows{
        width: 50%;
        overflow-y:auto;
        height: 60%;
        margin: auto;
        margin-top:10%;
        display: none;
        z-index: 200;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(255,239,213,0.98);
    }
    .text_image{
        display:inline-block;   
        position:relative; 
        margin:10px;
    }
    .text_image span {
        display:inline-block;
        position:absolute;
        top:20px;   
        left:0px;
        visibility:hidden;
        color:#FFF;
        font-family:Arial, Helvetica, sans-serif;
        font-size:20px; 
        background-color:rgba(0,0,0,.4);
        padding:10px 30px;
    }
    .windows_photo{
        display: none;
        overflow-y:auto;
        z-index: 200;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.25);
    }
    .close{
		float:right;
		margin-top: 5px;
        margin-right: 5px;
		cursor: pointer;
	}
    .commentator{
        font-size: 20px;
        font-family: 'Bebas';
        font-weight: normal;
    }
    .comment_time{
        font-size: 12px;
    }
    .comment_block{
        background-color:  #F0F9FC;
        box-shadow: 6px 6px 0 0 rgba(0,0,0,0.25);
    }
</style>
</head>







<body>
    <? if(($_COOKIE['admin'] != "e-FYH8xnbXSFoA-bL-==")){ ?>
    <form action="/admin.php" method="post" accept-charset="UTF-8">
        <div>E-mail: <input name="login"/> </div></br>
        <div>Пароль: <input name="pass" type="password"/> </div></br>
        <input type="submit" value="Войти"/>
    </form>
    <? } else {
        if(isset($errr)){
            print('<div style="font-size: 20pt;">'.$errr.'</div>');
        }
    ?>
    
    <form action="/admin.php" method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
        <div>Добавить название клуба: <input name="name"/></div>
        <div>Добавить DID клуба: <input name="ip"/></div>
        <div>Добавить адрес клуба: <input name="place"/></div>
        <div>Добавить о клубе: <textarea  name="about"></textarea></div>
        <div>Загрузка фото клуба: <input type="file" name="file"/></div>
        <div>Загрузка лого клуба: <input type="file" name="logo"/></div>
        <input type="submit" value="Добавить"/>
    </form>     
    
    <table border="1">
        <tr>
            <th>Id клуба</th>
            <th>Название клуба</th>
            <th>Адрес клуба</th>
            <th>DID клуба</th>
            <th>Лайки</th>
            <th>Мужчины в %</th>
            <th>Женщины в %</th> 
            <th>Возраст</th>
            <th>О клубе</th>
            <th>Фото клуба</th>
            <th>Лого клуба</th>
            <th>Редактирование</th>
            <? if(!isset($_POST['change'])) print("<th>Удаление</th>"); ?>
        </tr>
        <? $result =  mysqli_query($mysqli, "SELECT * FROM club");
        while ($row = mysqli_fetch_assoc($result)) {
            if(isset($_POST['change'])) {
                if($_POST['change'] == $row['id']) {
                    if($row['photo'] != ''){
                        $photo_list = explode(",", $row['photo']);
                    }else {
                        $photo_list = array();
                    }
                    
                    print('<div id="window'.$row['id'].'" class="windows" style="display: none;">
                               <img class="close" onclick="show(document.getElementById(\'window'.$row['id'].'\'))" src="/img/close_admin.png"/>
                               <textarea form="cng" rows="25" style="width:94%;margin:10px" name="about_cng">'.$row['about'].'</textarea>
                           </div>');
                    
                    print('<div id="window_photo'.$row['id'].'" class="windows_photo" style="display: none;">
                               <input form="cng" type="file" id="add_photo" name="add_photo[]" style="display: none;" multiple/>
                               <img class="close" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))" src="/img/close_admin.png"/>
                               <div style="margin-top:40px" >');
                               foreach($photo_list as $g => $photo_val){
                                    print('<div class="text_image"><img onclick="image_show(document.getElementById(\'span_text'.$g.'\'))" height="300px" width="300px"  src="/'.$photo_val.'"/><span id="span_text'.$g.'" class="text_image_span">Выделено</span></div>');
                               }
                    print('<img height="300px" width="300px" onclick="document.getElementById(\'add_photo\').click();"  src="/img/add_in_list.png"/></div></div>');
                    
                    print('<tr>
                               <form id="cng" action="/admin.php" method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
                                    <th>'.$row['id'].'<input name="id_cng" style="display:none" value="'.$row['id'].'"/><input name="photo_list_del" id="photo_list_del" value="," style="display:none"/></th>
                                    <th><input value="'.$row['club_name'].'" name="name_cng"/></th>
                                    <th><input size="60" value="'.$row['club_place'].'" name="place_cng"/></th>
                                    <th><input size="10" value="'.$row['club_ip'].'" name="ip_cng"/></th>
                                    <th><input size="5" value="'.$row['likes'].'" name="likes_cng"/></th>
                                    <th><input size="5" value="'.$row['male'].'" name="male"/></th>
                                    <th><input size="5" value="'.$row['female'].'" name="female"/></th>
                                    <th><input size="5" value="'.$row['age'].'" name="age"/></th>
                                    <th><img src="img/open_logo_cng.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window'.$row['id'].'\'))"/></th>
                                    <th><img src="img/photo_load_icon_cng.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))"/></th>
                                    <th><input type="file" name="logo_cng"/></th>
                                    <th><input type="submit" value="Изменить"/></th>
                               </form>
                           </tr>');
                } else {
                    if($row['about'] != ''){
                        print('<div id="window'.$row['id'].'" class="windows" style="display: none;">
                                   <img class="close" onclick="show(document.getElementById(\'window'.$row['id'].'\'))" src="/img/close_admin.png"/>
                                   <div style="margin:10px">'.$row['about'].'</div>
                               </div>');
                    }
                
                    if(count($photo_list = explode(",", $row['photo'])) > 1){
                        print('<div id="window_photo'.$row['id'].'" class="windows_photo" style="display: none;">
                                <img class="close" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))" src="/img/close_admin.png"/>
                                <div style="margin-top:40px" >');
                               foreach($photo_list as $photo_val){
                                    print('<img height="300px" width="300px" style="margin:10px;" src="/'.$photo_val.'"/>');
                               }
                        print('</div></div>');
                    }
                    
                    print('<tr>
                               <th>'.$row['id'].'</th>
                               <th>'.$row['club_name'].'</th>
                               <th>'.$row['club_place'].'</th>
                               <th>'.$row['club_ip'].'</th>
                               <th>'.$row['likes'].'</th>
                               <th>'.$row['male'].'</th>
                               <th>'.$row['female'].'</th>
                               <th>'.$row['age'].'</th>');
                               if($row['about'] != ''){
                                   print('<th><img src="img/open_logo.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window'.$row['id'].'\'))"/></th>');
                               } else {
                                   print('<th>Нет</th>');
                               }
                               
                               if($row['photo'] == ''){
                                    print('<th>Нет</th>');
                               } elseif(count($photo_list) == 1) {
                                    print('<th><a target="_blank" href="/'.$row['photo'].'"><img height="40px" width="40px" src="/'.$row['photo'].'"></a></th>');
                               } else {
                                    print('<th><img src="img/photo_load_icon.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))"/></th>'); 
                               }
                               
                               if($row['logo'] != ''){
                                    print('<th><a target="_blank" href="/'.$row['logo'].'"><img height="40px" width="40px" src="/'.$row['logo'].'"></a></th>');
                               } else {
                                    print('<th>Нет</th>');
                               }
                               
                               print('
                               <th>
                                   <form action="/admin.php" method="post" accept-charset="UTF-8">
                                       <input name="change" style="display:none" value="'.$row['id'].'"/>
                                       <input type="submit" value="Изменить"/>
                                   </form>
                               </th>
                           </tr>');
                }          
            } else {
                if($row['about'] != ''){
                    print('<div id="window'.$row['id'].'" class="windows" style="display: none;">
                               <img class="close" onclick="show(document.getElementById(\'window'.$row['id'].'\'))" src="/img/close_admin.png"/>
                               <div style="margin:10px">'.$row['about'].'</div>
                           </div>');
                }
                
                if(count($photo_list = explode(",", $row['photo'])) > 1){
                    print('<div id="window_photo'.$row['id'].'" class="windows_photo" style="display: none;">
                               <img class="close" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))" src="/img/close_admin.png"/>
                               <div style="margin-top:40px" >');
                               foreach($photo_list as $photo_val){
                                    print('<img height="300px" width="300px" style="margin:10px;" src="/'.$photo_val.'"/>');
                               }
                    print('</div></div>');
                }
                
                print('<tr>
                           <th>'.$row['id'].'</th>
                           <th>'.$row['club_name'].'</th>
                           <th>'.$row['club_place'].'</th>
                           <th>'.$row['club_ip'].'</th>
                           <th>'.$row['likes'].'</th>
                           <th>'.$row['male'].'</th>
                           <th>'.$row['female'].'</th>
                           <th>'.$row['age'].'</th>');
                           if($row['about'] != ''){
                               print('<th><img src="img/open_logo.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window'.$row['id'].'\'))"/></th>');
                           } else {
                               print('<th>Нет</th>');
                           }
                           
                           if($row['photo'] == ''){
                                print('<th>Нет</th>');
                           } elseif(count($photo_list) == 1) {
                                print('<th><a target="_blank" href="/'.$row['photo'].'"><img height="40px" width="40px" src="/'.$row['photo'].'"></a></th>');
                           } else {
                                print('<th><img src="img/photo_load_icon.png" style="cursor: pointer;" onclick="show(document.getElementById(\'window_photo'.$row['id'].'\'))"/></th>'); 
                           }
                           
                           if($row['logo'] != ''){
                                print('<th><a target="_blank" href="/'.$row['logo'].'"><img height="40px" width="40px" src="/'.$row['logo'].'"></a></th>');
                           } else {
                                print('<th>Нет</th>');
                           }
                           print('
                           <th>
                              <form action="/admin.php" method="post" accept-charset="UTF-8">
                                  <input name="change" style="display:none" value="'.$row['id'].'"/>
                                  <input type="submit" value="Изменить"/>
                              </form>
                           </th>
                           <th>
                              <form action="/admin.php" method="post" accept-charset="UTF-8" onsubmit="return confirm(\'Вы уверене что хотите удалить?\');">
                                  <input name="delete" style="display:none" value="'.$row['id'].'"/>
                                  <input type="submit" value="Удалить"/>
                              </form>
                           </th>
                       </tr>');
            }
        }
   ?>
   
</table>
<div id="comment_block">
<?  $result =  mysqli_query($mysqli, "SELECT * FROM comment WHERE ok=0");
    while ($row = mysqli_fetch_assoc($result)) {
        $data1 = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT club_name FROM club WHERE id='".$row['club_id']."'"));        ?>
        <div class="comment_block" style="padding: 4px 4px 4px 40px; margin-bottom:25px; ;">
<form method="post" action="/admin.php">
    <div style="font-size: 25px;"> <?print($data1['club_name']);?></div><br />
    <div class="commentator"><?print($row['name']);?></div><br />
    <div class="comment_time"><?print(date('Y-m-d, G:i', $row['time']));?></div><br />
    <div> <?print($row['comment']);?></div><br />
    <input name="comment_id" style="display:none" value="<?print($row['id']);?>"/>
    <input type="submit" name="save" value="Принять" />
    <input type="submit" name="delete" value="Отклонить" />
</form>
</div>
<?}}?>
</div>
</body>
</html>