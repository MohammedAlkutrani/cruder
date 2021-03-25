<?php

namespace Cruder\Resources;

use Cruder\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Model extends Resource
{
    /**
     *
     */
    private $modelTemplate;

    /**
     *
     */
    private $modelFileName;

    /**
     *
     */
    public function generate(): void
    {
        $this->prepare();
        $this->setFileName();
        File::put(app_path('Models').DIRECTORY_SEPARATOR.$this->modelFileName,$this->modelTemplate);
    }


    /**
     *
     */
    private function prepare()
    {
        $this->modelTemplate = Str::of($this->getStub('model'))
            ->replace('{{ class }}', $this->getClassName())
            ->replace('{{ fillable }}',$this->generateFields(function($field){
                $attribute = $field['attribute'];
                return "'$attribute'";
            },', '));
    }

    /**
     *
     */
    private function setFileName()
    {
        $this->modelFileName = $this->getClassName().'.php';
    }

    /**
     *
     */
    public function getClassName()
    {
        return Str::studly($this->bootstrap->getResourceName());
    }
}
