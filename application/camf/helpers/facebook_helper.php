<?php
function getFbPageInfoByUrl($url,$accessToken){
    $CI = get_instance();
    $id =  substr(strrchr(trim($url,"/"),'/'),1);
    $json = file_get_contents('https://graph.facebook.com/'.$id."?access_token=".$CI->facebook->getAccessToken());
    return json_decode($json);
}
function getFbId($url){
    $CI = get_instance();
    $id =  substr(strrchr(trim($url,"/"),'/'),1);
    $arr_id = explode("-",$id);
    if(!empty($arr_id) && count($arr_id)>1){
        $count = count($arr_id) - 1;
        return $arr_id[$count];
    }else{
        $json = file_get_contents('https://graph.facebook.com/'.$id."?access_token=".$CI->facebook->getAccessToken());
        $arr_info = json_decode($json);        
        if(isset($arr_info->id)){
            return $arr_info->id;
        }else{
            return '';
        }
    }
}
?>
