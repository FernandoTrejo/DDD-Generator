<?php

class ValueObjectGenerator{

    public static function generate($namespace, $entityName, $property, $type){
        $nameParts = explode("_", $property);
        $name2 = "";
        foreach($nameParts as $namePart){
            $name2 .= ucfirst($namePart); 
        }

        $modelName = ucfirst($entityName);
        $name = $modelName . $name2;

        $content = "
<?php

declare(strict_types=1);

namespace $namespace\\$modelName\\Domain\\ValueObjects;

final class $name
{

    private ".'$value'.";

    
    public function __construct($type ".'$value'.")
    {
        ".'$this->value = $value'.";
    }

    public function value(): $type
    {
        return ".'$this->value;'."
    }
}
        ";

        return [
            'name' => $name,
            'content' => $content,
            'url' => "$modelName/Domain/ValueObjects/$name"
        ];
    }

}