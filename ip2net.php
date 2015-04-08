<?php

function ip2wc ($old_ips){
    $arr=ip2net($old_ips);
    foreach ($arr as $val){
	$wc=32-strlen($val);
	$wcm=0;
	for ($i=0; $i<$wc; $i++)
	{
	    $val.="0";
	    $wcm.="1";
	}
	
	$out_arr[long2ip(bindec($val))] = long2ip(bindec($wcm));
    }
    return $out_arr;
}


function ip2net($old_ips){
    
    foreach ($old_ips as $key => $val)
    {
        $old_ips[$key] = ip2long($val);
    }
    foreach ($old_ips as $key => $val)
    {
        $old_ips[$key] = decbin($val);
        while (strlen($old_ips[$key])<32) {
    	    $old_ips[$key]="0".$old_ips[$key];
        }
    }
    return rq($old_ips);
}
    
function rq ($old_ips) {
    $wc="";
    foreach ($old_ips as $key => $val)
    {
	$len=strlen($val);
	foreach ($old_ips as $ikey => $ival) {
	    if ($key != $ikey) {
		$flag=true;
		for ($i=0; $i<$len-1; $i++) {
		    if ($val[$i] xor $ival[$i]) {
		    $flag=false;
		    break 1;
		    }
		}
		if ($flag) {
		    if ($val[$len-1] xor $ival[$len-1]) {
			$wc[$key]=substr($val, 0, $len-1);
			unset ($old_ips[$ikey]);
			unset ($old_ips[$key]);
			$flag=false;
		    }
		}
	    }
	}
    }
    if (count($wc)>1) {
	return array_merge ($old_ips, rq($wc));
    } else {
	return $old_ips;
    }
}

?>