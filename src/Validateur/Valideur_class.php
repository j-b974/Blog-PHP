<?php

namespace app\Validateur;
use Valitron\Validator;

abstract  class Valideur_class
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @param data liste a vérifié ;
     */
    public function __construct(array $data)
    {
        Validator::lang('fr');
        $v = new Validator($data);
        $this->validator = $v;

    }
    public function valideur(): bool
    {
        return $this->validator->validate();

    }
    public function get_errors(): array
    {
        return $this->validator->errors();
    }
}