<?php

class ModelListGenerator{
    public static function generate($namespace, $entityName){
        $modelName = ucfirst($entityName);
        $pluralModelName = $modelName . "s";

        $content = "
<?php

declare(strict_types=1);

namespace $namespace\\$modelName\\Domain;

final class $pluralModelName
{
    private array ".'$list'."; 

    public function __construct(array ".'$list'.")
    {
        ".'$this->list = $list'.";
    }

    public function toArray(): array
    {
        ".'$itemList = []'.";
        foreach(".'$this->list as $item'."){
            ".'$itemList[] = $item->toArray()'.";
        }
        return ".'$itemList'.";
    }

    public function list(){
        return ".'$this->list'.";
    }

    public function first(): ?$modelName{
        if(count(".'$this->list'.") < 1){
            return null;
        }

        return ".'$this->list'."[0];
    }

}
        ";

        return [
            'name' => $pluralModelName,
            'content' => $content,
            'url' => "$modelName/Domain/$pluralModelName"
        ];
    }


}