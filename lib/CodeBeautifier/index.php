<?php
function beautifyCode($code)
{
   $newCode = array();
   file_put_contents('code.php', $code);
   system('D:\wamp\www\instance\lib\CodeBeautifier\phpCB.exe code.php > newcode.php');
   return file_get_contents('newcode.php');
}

?>