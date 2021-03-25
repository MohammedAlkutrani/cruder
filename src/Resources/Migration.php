<?php

namespace Cruder\Resources;

use Carbon\Carbon;
use Cruder\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Migration extends Resource
{
    /**
     *
     */
    private $migrationTemplate;

    /**
     *
     */
    private $migrationFileName;

    /**
     *
     */
    public function generate(): void
    {
        $this->prepare();
        $this->setFileName();
        File::put(database_path('migrations').DIRECTORY_SEPARATOR.$this->migrationFileName,$this->migrationTemplate);
    }


    /**
     *
     */
    private function prepare()
    {
        $this->migrationTemplate = Str::of($this->getStub('migration'))
            ->replace('{{ class }}', $this->getClassName())
            ->replace('{{ table }}', $this->getTableName())
            ->replace('{{ fields }}',$this->generateFields(function($field){
                $type = $field['type'];
                $attribute = $field['attribute'];
                return '$table->'.$type.'('."'$attribute'".');';
            },PHP_EOL));
    }

    /**
     *
     */
    private function setFileName()
    {
        $this->migrationFileName = Str::of(
                Carbon::now()
                ->toDateTimeString())
                ->replace('-','_')
                ->replace(' ','_')
                ->replace(':','')
                .'_create_'.$this->getTableName().'_table.php';
    }

    /**
     *
     */
    public function getClassName()
    {
        return 'Create'.Str::studly($this->bootstrap->getResourceName()).'Table';
    }

    /**
     *
     */
    public function getTableName()
    {
        return Str::plural($this->bootstrap->getResourceName());
    }
}

