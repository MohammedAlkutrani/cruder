<?php

namespace Cruder;

use Illuminate\Support\Str;

class Bootstap implements BootstapInterface
{
    /**
     *  @var string
     */
    protected $resourceName;

    /**
     *  @var array
     */
    protected $fields = [];

    /**
     * setting the resource name
     *
     * @param string $name
     * @return void
     */
    public function setResourceName(string $name) : void
    {
        $this->resourceName = $name;
    }

    /**
     * getting the resource name
     *
     * @return string
     */
    public function getResourceName() : string
    {
        return $this->resourceName;
    }

    /**
     * setting the resource name
     *
     * @param string $name
     * @return void
     */
    public function setFields(string $fields) : void
    {
        $fieldsSplittedByComma = $this->split($fields,',');

        foreach($fieldsSplittedByComma as $field){
            $fieldSplittedByColon = $this->split($field,':');

            $this->fields[] = [
                'type'=>$fieldSplittedByColon[0],
                'attribute'=>$fieldSplittedByColon[1],
            ];
        }
    }

    /**
     * getting the resource name
     *
     * @return array
     */
    public function getFields() : array
    {
        return $this->fields;
    }

    /**
     * spliting string
     *
     * @param string $string
     * @return array
     */
    protected function split(string $string, string $pattern) : array
    {
        return Str::of($string)->explode($pattern)->toArray();
    }
}
