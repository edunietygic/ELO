<?php
function edu_get_instance($sClassName, $sType='library')
{
    $CI = & get_instance();

    $nLastPost = strrpos($sClassName, '/');
    if($nLastPost !== false)
        $sVarName = substr($sClassName, $nLastPost + 1 );
    else
        $sVarName = $sClassName;

    if($sType == 'model')
        $sCiValName = $sVarName;
    else
        $sCiValName = strtolower($sVarName);

    if(!isset($CI->{$sCiValName}))
    {
        $CI->load->{$sType}($sClassName);
    }

    return $CI->{$sCiValName};
}
function edu_get_config($sKey, $sFileName, $bUsePart=true)
{
    $CI = & get_instance();
    $CI->config->load($sFileName, $bUsePart);

    if($bUsePart)
        return $CI->config->item($sKey, $sFileName);
    else
        return $CI->config->item($sKey);
}
function response_json($aRtn)
{
    $res = "";

    if(is_array($aRtn))
        $res = json_encode($aRtn);
    elseif(is_array(json_encode($aRtn)))
        $res = $aRtn;

    if($res == '') return;

    header('Content-type: text/json');
    header('Content-type: application/json');
    echo $res;
}
function getCookieInfo()
{
    $CI = & get_instance();
    $CI->load->helper('cookie');
    return  get_cookie('eduniety_membership');
}
function setDateFormat($sDate, $type)
{
    if(!$sDate) return '-';

    switch($type)
    {
        case 'YMD':
            $result = substr($sDate, 0, 4). "년 ". substr($sDate, 5, 2). "월 ". substr($sDate, 8, 2). "일 ";
            break;
        case 'Y-M-D':
            $result = substr($sDate, 0, 4). "-". substr($sDate, 4, 2). "-". substr($sDate, 6, 2);
            break;
    }
    return $result;
}
function sendCURLPost($url,$params)
{
    if(!$url) return false;

    $postData = '';
    
    foreach($params as $k => $v) 
    { 
        if($v)  $postData .= $k . '='.$v.'&'; 
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();  
                                
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
                                                         
    $output=curl_exec($ch);
                                                              
    curl_close($ch);

    return $output;
}
function sendCURLGet($url,$params)
{
    if(!$url) return false;

    $postData = '';
    
    foreach($params as $k => $v) 
    {
        if($v)  $postData .= $k . '='.$v.'&'; 
    }
    $postData = rtrim($postData, '&');

    $url .= "?".$postData;

    $ch = curl_init();  
    
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                                                         
    $output=curl_exec($ch);

    //$output = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $output);
    
    curl_close($ch);
    return $output;
}
function getMenuData($sController, $sMethod)
{
    $aMenu = edu_get_config('menu','menu');

    $aRtn = $aMenu[$sController]['sub'][$sMethod];

    return $aRtn;
}
function chkLoginInfo()
{
    // chk login session
    if($aMemberInfo = LoginClass::isLogin())
    {
        return $aMemberInfo;
    }
    else
    {
        $aRtn = array('usn'=>'4');
        return (object)$aRtn;
    }    
    // view login page 
    //header('Location: '.HOSTURL.'/Login');
}
function replaceArticleHTML($sText)
{
    $sText = preg_replace("/<script([^>]*)>/i", '&lt;script$1&gt;', $sText);
    $sText = preg_replace("/<\/script>/i", '&lt;/script&gt;', $sText);

    return $sText;
}
