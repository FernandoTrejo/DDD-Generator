<?php

class ContractGenerator{
    public static function generate($namespace, $entityName){
        $modelName = ucfirst($entityName);
        $pluralModelName = $modelName . "s";
        $name = $modelName . "Repository";
        $idName = $modelName . "Id";
        $modelVariableName = lcfirst($entityName);

        $content = "
<?php

declare(strict_types=1);

namespace $namespace\\$modelName\\Domain\\Contracts;

use $namespace\\$modelName\\Domain\\$modelName;
use $namespace\\$modelName\\Domain\\$pluralModelName;
use $namespace\\$modelName\\Domain\\ValueObjects\\$idName;

interface $name
{
    public function findAll(): $pluralModelName;

    public function find($idName ".'$id'."): ?$modelName;

    public function save($modelName $"."$modelVariableName"."): void;

    public function update($idName ".'$id'.", $modelName $"."$modelVariableName"."): void;
}
        ";

        return [
            'name' => $name,
            'content' => $content,
            'url' => "$modelName/Domain/Contracts/$name"
        ];
    }
}