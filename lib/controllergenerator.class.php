<?php

class controllerGenerator{
   // define data members
   var $tableName;
   var $idFieldName;
   var $fields;
   var $fieldsInList;

   function controllerGenerator($name,$id,$fields)
   {
      $this->tableName=$name;
      $this->fields=$fields;
      $this->idFieldName = $id;
   }
   function create()
   {
      $tableSystemName = Util::getSystemName($this->tableName);
      $str = '';
      $str.='<?php'."\n";
      $str.='class '.  $tableSystemName .'Controller '."\n".'{'."\n";

      // Save Function
      $str.='static function save($obj)'."\n".'{'."\n";
      $str .= '$a'. $tableSystemName .'= new '. $tableSystemName .'();'."\n";

      foreach($this->fields as $field)
         $str .= '$a'. $tableSystemName . '->set' . Util::getSystemName($field->dbTableFieldName) .
                          '($obj[\'' . Util::lowerFirstChar(Util::getSystemName($field->dbTableFieldName)) . '\']);' ."\n";

      $str .=	'if($obj[\'' .  Util::lowerFirstChar(Util::getSystemName($this->idFieldName)) . '\']){' . "\n";
      $str .=	'$a'. $tableSystemName . '->set' . $tableSystemName . 'ID($obj[\'' .  Util::lowerFirstChar(Util::getSystemName($this->idFieldName)) . '\']);' . "\n" ;
      $str .=	'$a'. $tableSystemName . '->' .'update();' .  "\n" . '}' . "\n";
      $str .= 'else' . "\n";
      $str .= '$a'. $tableSystemName . '->' .'insert();' ."\n}" . "\n";

      // Get List Function For Listing
      $str .= 'static function getList()'."\n".'{'."\n";
      $str .= '$fieldList = array();' ."\n";

      $str .= '$fieldList[] = "' . Util::lowerFirstChar(Util::getSystemName($this->idFieldName)) . '";' . "\n";
      foreach($this->fields as $field)
         if($field->dbTableShowInList)
            $str .= '$fieldList[] = "' . Util::lowerFirstChar(Util::getSystemName($field->dbTableFieldName)) . '";' . "\n";
      
      $str .= '$a'. $tableSystemName . ' = new ' . $tableSystemName . '();' . "\n";
      $str .= 'return  $a'. $tableSystemName . '->getFields($fieldList);' . "\n";
      $str .= '}' . "\n";

      // Get Item
      $str .= 'static function get' . $tableSystemName . '($id)' . "\n {\n";
      $str .= '$a'. $tableSystemName . '= new '. $tableSystemName .'();' . "\n";
      $str .= '$a'. $tableSystemName . '->set'. Util::getSystemName($this->idFieldName) . '($id);' . "\n";
      $str .= '$record = $a'. $tableSystemName . '->select();'  . "\n";
      $str .= 'return  $record[0];' . "\n";
      $str .= '}' . "\n";

      // Delete Function
      $str.='static function delete($'. Util::getSystemName($this->idFieldName) . ')' . "\n {\n";
      $str.='$a'. $tableSystemName . '= new '. $tableSystemName .'();' . "\n";
      $str.='$a'. $tableSystemName . '->set'. Util::getSystemName($this->idFieldName) . '=$' . Util::getSystemName($this->idFieldName) .';'."\n";
      $str.='$a'. $tableSystemName . '->delete();' . "\n".'}' . "\n";

      $str .= '}' . "\n" ;
      $str.='?>';
      return  $str;
   }
}
?>