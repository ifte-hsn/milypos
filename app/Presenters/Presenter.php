<?php

namespace App\Presenters;
Use App\MilyPosModel;

abstract class Presenter
{
    /**
     * @var MilyPosModel
     */
    protected $model;


    public function __construct(MilyPosModel $model)
    {
        $this->model = $model;
    }

    public function name()
    {
        return $this->model->name;
    }

    /**
     * Magic Method
     * @param $property
     * @return string
     */
    public function _get($property)
    {
        if(method_exists($this, $property)) {
            return $this->{$property}();
        }
        return e($this->{$property}());
    }

    /**
     * Magic mathod
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->model->$method($args);
    }
}