
<?php
function checkRemoteFile($url)
{
	$res=getimagesize($url);
	return is_array($res);
}

?>
