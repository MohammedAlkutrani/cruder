<?php

namespace Cruder\Commands;

use Cruder\Bootstap;
use Cruder\Resources\Controller;
use Cruder\Resources\Migration;
use Cruder\Resources\Model;
use Cruder\Resources\Request;
use Cruder\Resources\Resource;
use Illuminate\Console\Command;

class Cruder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cruder:make-api-resource {name} {--f=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generator = new Bootstap();
        $generator->setResourceName($this->argument('name'));
        $generator->setFields($this->option('f'));

        (new Migration($generator));
        (new Model($generator));
        (new Controller($generator));
        (new Request($generator));
        (new Resource($generator));

        dd($generator->getResourceName(),$generator->getFields());
        $this->info($this->argument('name'));
    }
}
