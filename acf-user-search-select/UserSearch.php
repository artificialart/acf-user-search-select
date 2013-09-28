<?php
include_once '../../../wp-load.php';

$mode=$_GET['mode'];
$inputText = $_GET['inputText'];
$inputText = str_replace('&','&amp;',$inputText);
$inputText = str_replace("\'","'",$inputText);
$uid=$_GET['uid'];
$acfField=$_GET['acf'];
$nameField=$_GET['name'];
$resultField=$_GET['result'];
$siteurl=get_site_url();

if ($mode=='getuser'){
    $display_name =  $wpdb->get_var(
            "select display_name FROM $wpdb->users where ID=$uid"
            );
    echo str_replace('&amp;','&',$display_name);
}elseif ($mode=='getmatches'){
     $myrows =  $wpdb->get_results(
            $wpdb->prepare(
                    "select ID, display_name, user_email FROM $wpdb->users where display_name like '%%%s%%' order by display_name"
                    ,$inputText
                    )
     ); 

    foreach ( $myrows as $myrows ) 
    {
            $name=$myrows->display_name;
            $name=str_replace('&amp;','&',$name);
            $id=$myrows->ID;
            $email=$myrows->user_email;
            echo "<UL><li><a title='";
            echo $email;
            echo "' onclick=\"jQuery('#" . $acfField . "').val(";
            echo $id;
            echo ");jQuery('#" . $acfField . "').next('input').val('";
            echo $name;
            echo "');jQuery('#" . $acfField . "').siblings().eq(1).html('";
            echo "<a href=\'";
            echo $siteurl;
            echo "/wp-admin/user-edit.php?user_id=";
            echo $id;
            echo "\' target=\'_blank\'>";
            echo $name;
            echo "</a>";
            echo "');\">";
            echo $name;
            echo "</a></li></ul>";
    }
}

?>
