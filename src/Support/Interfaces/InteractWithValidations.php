<?php

namespace Kirago\BusinessCore\Support\Interfaces;

interface InteractWithValidations {

    /** The validation rules of the model.
     * @return array
     */
    public function validationsRules() : array;

    /**
     * The validation error messages of the model.
     * @return array
     */
    public function validationsMessages() : array;

    /**
     * The validation error messages of the model.
     * @return array
     */

    public function validationsAttributes() : array;


//    /**
//     * The validation errors of model.
//     * @param bool $returnArray
//     * @return mixed
//     */
//    public function errors(bool $returnArray = true) : mixed;


    public function validationsSchema() : array;


}
