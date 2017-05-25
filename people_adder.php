<?  
    error_reporting(0);
    $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
    mysqli_query($mysqli, "SET NAMES utf8");
    date_default_timezone_set("UTC");
    $zap = date("005138001_Y-m-d", time() + 3 * 3600);
    $people = 0;
    
    $data = file_get_contents("/var/www/h27141/data/Qlubbah/Russia/Moscow/Moscow/Deparole_petrovka_17_4/Vxod/".$zap);
    if($data != false){
        $mas = explode(chr(10),$data);
        foreach($mas as $del){
            if($del != "EOF"){
                $mas1 = explode(' ', $del);
                $people += $mas1[2] - $mas1[1];
            }else{
                break;
            }
        }
    }
    mysqli_query($mysqli, "UPDATE club SET people='".$people."' WHERE id='19'");
?>