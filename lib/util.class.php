<?php
class Util
{
   static function getSystemName($name)
   {
      return str_replace(' ', '', ucwords($name));//name without whitespaces
   }

   static function getFileName($name)
   {
      return strtolower(str_replace(' ', '', $name)) ;//name without whitespaces and capital letters
   }

   static function lowerFirstChar($str)
   {
      $str[0] = strtolower(substr($str,0,1));
      return $str;
   }
}
?>