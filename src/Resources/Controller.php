<?php

namespace Cruder\Resources;

use Cruder\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Controller extends Resource
{
    /**
     *
     */
    private $controllerTemplate;

    /**
     *
     */
    private $controllerFileName;

    /**
     *
     */
    public function generate(): void
    {
        $this->prepare();
        $this->setFileName();

        File::put(app_path('Http'.DIRECTORY_SEPARATOR.'Controllers').DIRECTORY_SEPARATOR.$this->controllerFileName,$this->controllerTemplate);
        File::append(base_path('routes/api.php'), 'Route::apiResource(\'' . $this->bootstrap->getResourceName() . "', '\App\Http\Controllers\\".$this->getClassName()."');".PHP_EOL);
    }


    /**
     *
     */
    private function prepare()
    {
        $this->controllerTemplate = Str::of($this->getStub('controller'))->replace('{{ class }}', $this->getClassName());

        $this->controllerTemplate = $this->controllerTemplate->replace('{{ request_class }}', Str::studly($this->bootstrap->getResourceName()).'Request');
        $this->controllerTemplate = $this->controllerTemplate->replace('{{ model_class }}', Str::studly($this->bootstrap->getResourceName()))
                ->replace('{{ model_var }}', $this->bootstrap->getResourceName());

        $this->controllerTemplate = $this->controllerTemplate->replace('{{ resource_class }}', Str::studly($this->bootstrap->getResourceName().'Resource'));
    }

    /**
     *
     */
    private function setFileName()
    {
        $this->controllerFileName = $this->getClassName().'.php';
    }

    /**
     *
     */
    public function getClassName()
    {
        return Str::studly($this->bootstrap->getResourceName()).'Controller';
    }
}
