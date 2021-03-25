<?php

namespace Cruder\Resources;

use Cruder\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Request extends Resource
{
    /**
     *
     */
    private $requestTemplate;

    /**
     *
     */
    private $requestFileName;

    /**
     *
     */
    private $output;

    /**
     *
     */
    public function generate(): void
    {
        $this->prepare();
        $this->setFileName();

        if(!File::isDirectory(app_path('Http'.DIRECTORY_SEPARATOR.'Requests')))
        {
            File::makeDirectory(app_path('Http'.DIRECTORY_SEPARATOR.'Requests'),0777);
        }

        File::put(app_path('Http'.DIRECTORY_SEPARATOR.'Requests').DIRECTORY_SEPARATOR.$this->requestFileName,$this->requestTemplate);
    }


    /**
     *
     */
    private function prepare()
    {
        $this->requestTemplate = Str::of($this->getStub('request'))
            ->replace('{{ class }}', $this->getClassName())
            ->replace('{{ validation }}',$this->generateFields(function($field){
                $attribute = $field['attribute'];
                return "'$attribute' => ['required',]";
            },','.PHP_EOL));
    }

    /**
     *
     */
    private function setFileName()
    {
        $this->requestFileName = $this->getClassName().'.php';
    }

    /**
     *
     */
    public function getClassName()
    {
        return Str::studly($this->bootstrap->getResourceName()).'Request';
    }
}
