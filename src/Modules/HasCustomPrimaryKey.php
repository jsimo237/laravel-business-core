<?php

namespace Kirago\BusinessCore\Modules;

trait HasCustomPrimaryKey {

    /**
     * @var array
     */
     protected array $customPrimaryKeyConfig = [
        "column" => "code",
        "type" => "string",
        "autoIncrement" => false,
     ];

    public static function bootHasCustomPrimaryKey(){}

    public function __construct()
    {
       // parent::__construct($attributes);

        $this->applyCustomPrimaryKey();
    }

    /**
     * Appliquer la configuration de la clé primaire
     */
    protected function applyCustomPrimaryKey()
    {
        /**
         * Définir la colonne qui est utilisée comme clé primaire
         *
         * @var string
         */
        $this->primaryKey = $this->customPrimaryKeyConfig['column'] ?? "code";

        /**
         * Définir le type de clé primaire comme étant une chaîne de caractères
         *
         * @var string
         */
        $this->keyType = $this->customPrimaryKeyConfig['type'] ?? "string";

        /**
         * Indiquer que la clé primaire est auto-incrémentée
         *
         * @var bool
         */
        $this->incrementing = $this->customPrimaryKeyConfig['autoIncrement'] ?? false;
    }

}
