<?php

class ValidatorGenerator{
    public static function generate($namespace, $entityName, $properties, $type){
        $modelName = ucfirst($entityName);
        $name = $type . $modelName . "Validator"; //CreateModelValidator

        $rules = "\n";
        foreach($properties as $prop){
            $propName = $prop['name'];
            $rules .= "'$propName' => 'required', \n";
        }

        $content = "
<?php

declare(strict_types=1);

namespace $namespace\\$modelName\\Domain\\Validations;

use $namespace\\$modelName\\Domain\\$modelName;
use Src\Shared\Domain\Services\NotificationService;
use Src\Shared\Domain\Services\ValidatorService;

class $name{

    private ".'$rules'." = [
        $rules
    ];

    private ".'$data'.";

    public function __construct(array ".'$data'.")
    { 
        ".'$this->data = $data;'."
    }

    public function validate(){
        ".'$notifier'." = new NotificationService();
        ".'$validator'." = new ValidatorService(
            ".'$this->data'.", 
            ".'$this->rules'.",
            ".'$notifier'."
        );
        ".'$validator->validate();'."
        if(".'$notifier->hasError()'." === true){
            return ".'$notifier'.";
        }

        //validaciones extras 

        return ".'$notifier'.";
    }

}
        ";

        return [
            'name' => $name,
            'content' => $content,
            'url' => "$modelName/Domain/Validations/$name"
        ];
    }
}