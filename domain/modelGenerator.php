<?php

class ModelGenerator{
    public static function generate($namespace, $entityName, $properties){
        $modelName = ucfirst($entityName);
        $idName = $modelName . "Id";
        $modelVariableName = lcfirst($entityName);

        
        $valueObjects = "\n";
        $propertiesText = "\n";
        $propertiesText2 = "\n";
        $createParams = "\n";
        $createParamsArray = array();
        $construct = "\n";
        $getters = "\n";
        $paramsFromPrimitives = "\n";
        $propsCopyFrom = "\n";
        $toArray = "\n";

        foreach($properties as $prop){
            $propName = $prop['name'];
            $type = trim($prop['type']);

            $propNameParts = explode("_", $propName);
            $propName2 = "";
            
            foreach($propNameParts as $namePart){
                $propName2 .= ucfirst($namePart); 
            }

            $varName = lcfirst($propName2);

            //value objects
            $valueObject = $modelName . $propName2;
            $valueObjects .= "use $namespace\\$modelName\\Domain\\ValueObjects\\$valueObject; \n";

            //properties / constructor
            $propertiesText .= "private $$varName;\n";
            $propertiesText2 .= "$$varName,\n";

            //createParams
            // $createParams .= "$valueObject $$varName = null,\n";
            $createParamsArray[] = "$valueObject $$varName = null";

            //construct
            $construct .= '$this->' . "$varName = $$varName;\n";

            //getters
            $getters .= "
            public function $varName(): ?$valueObject{
                return ".'$this->'."$varName;
            }
            \n";

            //params from primitives
            $paramsFromPrimitives .= "new $valueObject(($type) ".'$primitives'."['$propName']),\n";

            //copyfrom
            $propsCopyFrom .= '$this->' . "$varName = $$modelVariableName".'->'."$varName();\n";

            //toarrray
            $toArray .= 'if($this->' . "$varName){
                ".'$data'."['$propName'] = ".'$this->'.$varName."->value();
            } \n\n";
        }
        $createParams = implode(",\n", $createParamsArray);

        $content = "
<?php

declare(strict_types=1);

namespace $namespace\\$modelName\\Domain;

//value objects

$valueObjects

final class $modelName
{
    $propertiesText

    public function __construct(
        $createParams
    ) {
        $construct
    }

    //getters
    $getters


    public static function create(
        $createParams
    ): $modelName {
        $$modelVariableName = new self(
            $propertiesText2
        );

        return $$modelVariableName;
    }

    public static function fromPrimitives(array ".'$primitives'."){
        $$modelVariableName = new self(
            $paramsFromPrimitives
        );

        return $$modelVariableName;
    }

    public function copyFrom($modelName $$modelVariableName){
        $propsCopyFrom
    }

    public function toArray(){
        ".'$data = [];'."

        $toArray
        

        return ".'$data'.";
    }

}
        ";

        return [
            'name' => $modelName,
            'content' => $content,
            'url' => "$modelName/Domain/$modelName"
        ];
    }
}