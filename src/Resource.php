<?php

namespace Cruder;

use Illuminate\Support\Facades\File;

abstract class Resource implements ResourceInterface
{
    /**
     *
     */
    protected $bootstrap;

    /**
     *
     */
    public function __construct(BootstapInterface $bootstrap)
    {
        $this->bootstrap = $bootstrap;
        $this->generate();
    }

    /**
     * getting stub file.
     *
     * @param string $type
     * @return string
     */
    protected function getStub(string $type)
    {
        return File::get(__DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$type.'.stub');
    }

    /**
     * getting the file
     *
     * @param callable $callback
     * @param string $implodeBy
     *
     * @return string
     */
    protected function generateFields(callable $callback, string $implodeBy)
    {
        return collect($this->bootstrap->getFields())->map($callback)->implode($implodeBy);
    }
}
