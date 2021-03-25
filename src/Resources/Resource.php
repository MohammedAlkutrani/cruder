<?php

namespace Cruder\Resources;

use Cruder\Resource as CruderResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Resource extends CruderResource
{
    /**
     *
     */
    private $resourceTemplate;

    /**
     *
     */
    private $resourceFileName;

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

        if(!File::isDirectory(app_path('Http'.DIRECTORY_SEPARATOR.'Resources')))
        {
            File::makeDirectory(app_path('Http'.DIRECTORY_SEPARATOR.'Resources'),0777);
        }

        File::put(app_path('Http'.DIRECTORY_SEPARATOR.'Resources').DIRECTORY_SEPARATOR.$this->resourceFileName,$this->resourceTemplate);

    }



    /**
     *
     */
    private function prepare()
    {
        $this->resourceTemplate = Str::of($this->getStub('resource'))
            ->replace('{{ class }}', $this->getClassName())
            ->replace('{{ response }}',$this->generateFields(function($field){
                $attribute = $field['attribute'];
                return "'$attribute' => ".'$this->'."$attribute";
            },','.PHP_EOL));
    }

    /**
     *
     */
    private function setFileName()
    {
        $this->resourceFileName = $this->getClassName().'.php';
    }

    /**
     *
     */
    public function getClassName()
    {
        return Str::studly($this->bootstrap->getResourceName()).'Resource';
    }
}
