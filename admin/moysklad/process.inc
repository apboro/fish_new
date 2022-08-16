<?php
function SetPID(){
$path=sys_get_temp_dir().'/PID.infinity';
$fw=fopen($path,'w');
if (isset($fw)){
fwrite($fw,getmypid());
fclose($fw);
}

}

function isProcRun(){
$PID=ReadPID();
if ($PID==-1){return false;}
if ($PID!==false){
exec('/bin/ps  '.$PID.' | /bin/grep '.$PID.' |/usr/bin/wc|/usr/bin/awk '."'{print $1}'",$out);
    if ($out[0]>0){return($out[0]>0);}
	else{unSetPID();SafeExit('Process '.$PID.' was killed');}
	}else{return false;}
return false;
}

function unSetPID(){
$path=sys_get_temp_dir().'/PID.infinity';
if (file_exists($path)){unlink($path);}
}

function ReadPID(){
$PID=-1;
$path=sys_get_temp_dir().'/PID.infinity';
if (file_exists($path)){
    $fr=fopen($path,'r');
    if (isset($fr)){
	$PID=fgets($fr);
	fclose($fr);
	}else{return false;}
    }
return $PID;
}

?>