<?php

include_once './domain/value_object_generator.php';
include_once './domain/contract_generator.php';
include_once './domain/validator_generator.php';
include_once './domain/modelGenerator.php';
include_once './domain/modelListGenerator.php';
include_once './file_generator.php';

class Gen{
    public $namespace;
    public $entityName;
    public $properties;

    public $baseFolder = "structures/";
    public function __construct($namespace, $entityName, $properties)
    {
        $this->namespace = $namespace;
        $this->entityName = $entityName;
        $this->properties = $properties;
    }

    public function generate(){
        $this->folderStructure();
        $this->valueObjects();
        $this->domainContracts();
        $this->validators();
        $this->domainModel();
        $this->domainPluralModel();
    }

    private function folder(){
        return $this->baseFolder . $this->entityName;
    }

    private function folderStructure(){
        $paths = [
            $this->folder() . '/Domain/ValueObjects',
            $this->folder() . '/Domain/Validations',
            $this->folder() . '/Domain/Contracts',
            $this->folder() . '/Application/Requests',
            $this->folder() . '/Infrastructure/Repositories',
        ];

        foreach($paths as $path){
            mkdir($path, 0777, true);
        }
        
    }

    private function valueObjects(){
        foreach($this->properties as $prop){
            $propertyName = $prop['name'];
            $propertyType = $prop['type'];

            $data = ValueObjectGenerator::generate(
                $this->namespace,
                trim($this->entityName),
                trim($propertyName),
                trim($propertyType)
            );

            FileGenerator::create(
                $this->baseFolder . $data['url'], 
                $data['content']
            );
        }
        
    }

    private function domainContracts(){
        $data = ContractGenerator::generate(
            $this->namespace,
            trim($this->entityName)
        );

        FileGenerator::create(
            $this->baseFolder . $data['url'], 
            $data['content']
        );
        
    }

    private function validators(){
        $data1 = ValidatorGenerator::generate(
            $this->namespace,
            trim($this->entityName),
            $this->properties,
            "Create"
        );
        
        $data2 = ValidatorGenerator::generate(
            $this->namespace,
            trim($this->entityName),
            $this->properties,
            "Modify"
        );

        FileGenerator::create(
            $this->baseFolder . $data1['url'], 
            $data1['content']
        );

        FileGenerator::create(
            $this->baseFolder . $data2['url'], 
            $data2['content']
        );
        
    }

    private function domainModel(){

        $data = ModelGenerator::generate(
            $this->namespace,
            trim($this->entityName),
            $this->properties
        );

        FileGenerator::create(
            $this->baseFolder . $data['url'], 
            $data['content']
        );
        
    }

    private function domainPluralModel(){

        $data = ModelListGenerator::generate(
            $this->namespace,
            trim($this->entityName)
        );

        FileGenerator::create(
            $this->baseFolder . $data['url'], 
            $data['content']
        );
        
    }


}