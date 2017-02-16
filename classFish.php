<?php
//demonstrate
// the use of the __construct parent function in a subclass
//the use of double quotes
class Fish
{
    public $common_name;
    public $flavor;
    public $record_weight;

    function __construct($name, $flavor, $record){
        $this->common_name = $name;
        $this->flavor = $flavor;
        $this->record_weight = $record;
    }

    public function getInfo() {
        $output  = "The {$this->common_name} is an awesome fish. ";
        $output .= "It is very {$this->flavor} when eaten. ";
        $output .= "Currently the world record {$this->common_name} weighed {$this->record_weight}.";
        return $output;
    }
}

class Trout extends Fish {
  public $species;
  function __construct($name, $flavor, $record, $species){ 
    parent::__construct($name, $flavor, $record);
    $this->species = $species;
  }
  public function getInfo() {
    return $this->species . " " . $this->common_name . " tastes " . $this->flavor . ". The record " . $this->species . " " . $this->common_name .  " weighed ". $this->record_weight .".";  
  }
}
$brook_trout = new Trout("Trout", "Delicious", "14 pounds 8 ounces", "Brook");
//push $brook_trout's data into getInfo and echo that result
//echo $brook_trout->getInfo();
//output: From subclass: Brook Trout tastes Delicious. The record Brook Trout weighed 14 pounds 8 ounces. 

//Per PHP7/zend engine, I removed de close delimiter


