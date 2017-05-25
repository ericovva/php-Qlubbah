<?
    error_reporting(0);
    $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
    mysqli_query($mysqli, "SET NAMES utf8");
    $result =  mysqli_query($mysqli, "SELECT * FROM club");
    while ($row = mysqli_fetch_assoc($result)) {
        $ago = time() - 60*60*24;
        $data = file_get_contents("https://aimsuite.intel.com/analytics/rpc_get_aimview_log.php?username=nikitaostroverkhov@mail.ru&password=Qlubbah&did=".$row['club_ip']."&start_year=".date('Y', $ago)."&start_month=".date('m', $ago)."&start_day=".date('d', $ago)."&end_year=".date('Y', time())."&end_month=".date('m', time())."&end_day=".date('d', time())."&v=2");
        if($data != false){
            $val = explode(",",$data);
            $male = 0;
            $female = 0;
            unset($age);
            unset($age_female);
            for($i = 3;$i < count($val);$i += 4){
                $val1 = explode("\n",$val[$i + 1]);
                if($val[$i] == "male"){
                    $male++;
                    $age[$val1[0]]++;
                }
                if($val[$i] == "female"){
                    $female++;     
                    $age_female[$val1[0]]++;
                }
                
                
            } 
            $middle = round(($age['child'] * 14 + $age['young_adult'] * 18 + $age['adult'] * 22 + $age['senior'] * 26) / ($age['child'] + $age['young_adult'] + $age['senior'] + $age['adult']));
            $middle_female = round(($age_female['child'] * 14 + $age_female['young_adult'] * 18 + $age_female['adult'] * 22 + $age_female['senior'] * 26) / ($age_female['child'] + $age_female['young_adult'] + $age_female['senior'] + $age_female['adult']));
            mysqli_query($mysqli, "UPDATE club SET male='".(100 * $male / ($male + $female))."',female='".(100 * $female / ($male + $female))."',age='".$middle."',age_female='".$middle_female."' WHERE id='".$row['id']."'");
        }else{
            mysqli_query($mysqli, "UPDATE club SET male='0',female='0',age='Undefined',age_female='Undefined' WHERE id='".$row['id']."'");    
        }
    }
    print("OK");
?>