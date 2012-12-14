<?php

//From DevShed
//http://www.devshed.com/c/a/PHP/Building-Object-Oriented-Database-Interfaces-in-PHP-Processing-Data-through-Data-Access-Objects/

class modelGenerator{
  // define data members
  var $tableName;
  var $idFieldName;
  var $fields;

  function modelGenerator($name,$id,$fields)
  {
    $this->tableName= Util::getSystemName($name);
    $this->fields = array();
    foreach($fields as $field)
    {
       $field->dbTableFieldName = Util::getSystemName($field->dbTableFieldName);
       $this->fields[] = $field;
    }
    $this->idFieldName = Util::getSystemName($id);
  }
  function create(){
     
    // create class data members definition
    $str='<?php'."\n";
    $str.='class '. ucwords($this->tableName).' extends DBTable {'."\n";

    $str.= 'var $'. Util::lowerFirstChar($this->idFieldName) ."='';" ."\n";
    foreach($this->fields as $field)
    {
       $str.= 'var $'. Util::lowerFirstChar($field->dbTableFieldName) ."='';" ."\n";
    }
    $str.= "\n";
    
    // create constructor
    $str.='function '. $this->tableName.'(){'."\n";
    $str.= '$this->tableKey="' . $this->idFieldName .'";' . "\n";
    $str.= '$this->tableName="' . $this->tableName .'";' . "\n\n";
    $str.='}' . "\n";
    // create modifiers and accessors
    $str .= 'function set'. $this->idFieldName .'($'. Util::lowerFirstChar($this->idFieldName) .'){'."\n";
   $str .= '$this->' . Util::lowerFirstChar($this->idFieldName) .'=$'. Util::lowerFirstChar($this->idFieldName).';'."\n";
   $str .= '}'."\n";
   $str .= 'function get'. $this->idFieldName .'(){'."\n";
   $str .= 'return $this->'.  Util::lowerFirstChar($this->idFieldName) .';'."\n";
   $str .= '}'."\n";
      
    foreach($this->fields as $field){
      $str .= 'function set'. $field->dbTableFieldName.'($'. Util::lowerFirstChar($field->dbTableFieldName) .'){'."\n";
      $str .= '$this->' . Util::lowerFirstChar($field->dbTableFieldName) .'=$'. Util::lowerFirstChar($field->dbTableFieldName).';'."\n";
      $str .= '}'."\n";
      $str .= 'function get'. $field->dbTableFieldName .'(){'."\n";
      $str .= 'return $this->'.  Util::lowerFirstChar($field->dbTableFieldName) .';'."\n";
      $str .= '}'."\n";
    }
    // create "insert()" method
    $str.='function insert(){'."\n";
    // build insert query
    $str.='global $dbConnection;'."\n";
    $str.='$sql="INSERT INTO $this->tableName SET ';
    $inserts= array();

    foreach($this->fields as $field)
    {
      if($field->dbTableFieldName != $this->idFieldName)
         $inserts[] = Util::lowerFirstChar($field->dbTableFieldName) . 
                           '=\'$this->'. Util::lowerFirstChar($field->dbTableFieldName) .'\'';
    }
    $str .= implode(' ,'. "\n", $inserts);
    $str.='";'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='$this->' . Util::lowerFirstChar($this->idFieldName) .' = $dbConnection->getInsertID();'."\n";
    $str.='}'."\n";
    // create "select" method
    $str.='function select(){'."\n";
    // build query
    
    $str.='global $dbConnection;'."\n";
    $str.='$sql="SELECT * FROM $this->tableName WHERE '. Util::lowerFirstChar($this->idFieldName)
                . '=".$this->' . Util::lowerFirstChar($this->idFieldName) . ';'."\n";
    // perform query
    $str.='if($dbConnection->query($sql))'."\n";
    $str.='return $dbConnection->getResults();'."\n";
    $str.='}'."\n";
    // create "update" method
    $str.='function update(){'."\n";
    $str.='global $dbConnection;'."\n";
    // build query
    $str.='$sql="UPDATE $this->tableName SET ';
    foreach($this->fields as $field){
      $str.=($field->dbTableFieldName!=$this->idFieldName) ?
                             Util::lowerFirstChar($field->dbTableFieldName )
                             .'=\'$this->' . Util::lowerFirstChar($field->dbTableFieldName) .'\','. "\n":'';
    }
    // remove trailing comma
    $str=preg_replace("/,$/","",$str);
    $str.=' WHERE '. Util::lowerFirstChar($this->idFieldName) 
              . '=" . $this->'  . Util::lowerFirstChar($this->idFieldName) . ';'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='}'."\n";
    // create "delete" method
    $str.='function delete(){'."\n";
    $str.='global $dbConnection;'."\n";
    // build query
    $str.='$sql="DELETE FROM $this->tableName WHERE '. Util::lowerFirstChar($this->idFieldName) 
               . '= " . $this->' . Util::lowerFirstChar($this->idFieldName) . ';'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='}'."\n";
    $str.='}?>';
    
     return  $str;
  }
  
}

?>
