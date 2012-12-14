<?php
class DBTableInterfaceGenerator{
  // define data members
  var $tableName;
  var $path;
  var $idFieldName;
  var $options;

  function DBTableInterfaceGenerator($name,$id,$path,$options)
  {
    $this->tableName=$name;
    $this->path=$path;
    $this->options=$options;
    $this->idFieldName = $id;
  }
  function create(){
     
    // create class data members definition
    $str='<?php'."\n";
    $str.='class '. ucwords($this->tableName).' extends DBTable {'."\n";
    
    foreach($this->options as $option)
    {
                $str.= 'var $'. $option ."='';" ."\n";
    }
    $str.= "\n";
    
    // create constructor
    $str.='function '.ucwords($this->tableName).'(){'."\n";
    $str.= '$this->tableKey="' . $this->idFieldName .'";' . "\n";
    $str.= '$this->tableName="' . $this->tableName .'";' . "\n\n";
    $str.='}' . "\n";
    // create modifiers and accessors
    foreach($this->options as $option){
      $str.='function set'. ucwords($option).'($'.$option.'){'."\n";
      $str.='$this->'.$option.'=$'.$option.';'."\n";
      $str.='}'."\n";
      $str.='function get'. ucwords($option).'(){'."\n";
      $str.='return $this->'.$option.';'."\n";
      $str.='}'."\n";
    }
    // create "insert()" method
    $str.='function insert(){'."\n";
    // build insert query
    $str.='global $dbConnection;'."\n";
    $str.='$sql="INSERT INTO $this->tableName SET ';
    $inserts= array();

    foreach($this->options as $option)
    {
      if($option != $this->idFieldName)
         $inserts[] = $option.'=\'" . mysql_escape_string($this->'.$option.') . "\'';
      }
    $str .= implode(' ,'. "\n", $inserts);
    $str.='";'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='$this->' . $this->idFieldName .' = $dbConnection->getInsertID();'."\n";
    $str.='}'."\n";
    // create "select" method
    $str.='function select(){'."\n";
    // build query
    
    $str.='global $dbConnection;'."\n";
    $str.='$sql="SELECT * FROM $this->tableName WHERE '. $this->idFieldName . '=".$this->' . $this->idFieldName . ';'."\n";
    // perform query
    $str.='if($dbConnection->query($sql))'."\n";
    $str.='return $dbConnection->getResults();'."\n";
    $str.='}'."\n";
    // create "update" method
    $str.='function update(){'."\n";
    $str.='global $dbConnection;'."\n";
    // build query
    $str.='$sql="UPDATE $this->tableName SET ';
    foreach($this->options as $option){
      $str.=($option!=$this->idFieldName)?$option.'=\'" . mysql_escape_string($this->'.$option.') . "\','. "\n":'';
    }
    // remove trailing comma
    $str=preg_replace("/,$/","",$str);
    $str.=' WHERE '. $this->idFieldName . '=" . $this->' .$this->idFieldName . ';'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='}'."\n";
    // create "delete" method
    $str.='function delete(){'."\n";
    $str.='global $dbConnection;'."\n";
    // build query
    $str.='$sql="DELETE FROM $this->tableName WHERE '. $this->idFieldName . '= " . $this->' . $this->idFieldName . ';'."\n";
    // perform query
    $str.='$dbConnection->query($sql);'."\n";
    $str.='}'."\n";
    $str.='}?>';
    
    // write contents to class file
    $fp=fopen($this->path.$this->tableName.'.class.php',"w") or die('Error creating class file');
    fwrite($fp,$str);
    fclose($fp);
  }
  function getObject(){
    // create object
    if(file_exists($this->path.$this->tableName.'.php')){
      require_once($this->path.$this->tableName.'.php');
      return new $this->tableName;
    }
    return false;
  }
}

?>
