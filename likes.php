<?php
    if(isset($_COOKIE['id']) && isset($_COOKIE['hash'])){ 
        $mysqli = mysqli_connect("localhost", "h27141_qlubbah", "qwerty7gas", "h27141_qlubbah");
        mysqli_query($mysqli, "SET NAMES utf8");
        $bd_hash = mysqli_fetch_array(mysqli_query($mysqli, "SELECT hash FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
        if($bd_hash[0] == $_COOKIE['hash']){
            $like_list = mysqli_fetch_array(mysqli_query($mysqli, "SELECT likes_list FROM auth WHERE id=".$_COOKIE['id']), MYSQLI_NUM);
            if(strrpos($like_list[0] ,','.$_POST['id'].',') === false){
                mysqli_query($mysqli, "UPDATE club SET likes=likes+1 WHERE id='".$_POST['id']."'");
                $like_list[0] .= $_POST['id'].',';
            } else {
                mysqli_query($mysqli, "UPDATE club SET likes=likes-1 WHERE id='".$_POST['id']."'");  
                $like_list[0] = str_replace(','.$_POST['id'].',', ',', $like_list[0]);
            }
            mysqli_query($mysqli, "UPDATE auth SET likes_list='".$like_list[0]."' WHERE id='".$_COOKIE['id']."'");
        }
    }
?>