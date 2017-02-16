<?php
//Demonstrate 
//the Factory pattern,
//the use of single quotes
//
////scalar variable type declaration in function as per PHP7
////declare(strict_types=1);

class FishF {

    private $specie;
    private $common_name;
    private $flavor;
    private $record_weight;

    ////public function __construct(string $name, string $flavor, string $record, string $specie) {
    public function __construct($name, $flavor, $record, $specie) {
        $this->common_name = $name;
        $this->flavor = $flavor;
        $this->record_weight = $record;
        $this->specie = $specie;
    }

    public function getAllInfo() {

        $output = 'The '.$this->specie.' '.$this->common_name.' is an awesome fish.';
        $output .= ' It is very '. $this->flavor. ' when eaten.';
        $output .= ' Currently the world record '.$this->common_name. ' weighed '.$this->record_weight.'.';
        return $output;
    }
    
}

class FishFactory{
    public static function create($name, $flavor, $record, $specie){
        return new FishF($name, $flavor, $record, $specie);
    }
}

// have the factory create the $riverFish_1 object from the FishF class
$riverFish_1 = FishFactory::create('Trout', 'Delicious', '14 pounds 8 ounces', 'Brook');
        // outputs "From Factory pattern: The Trout Brook is an awesome fish. It is very Delicious when eaten. Currently the world record Trout weighed 14 pounds 8 ounces.";




//Per PHP7/zend engine, I removed de close delimiter


