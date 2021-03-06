<?php

namespace UeDehua\LaravelDoctrine\Console;

use Illuminate\Console\Command;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Symfony\Component\Console\Input\InputOption;

class SchemaDropCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'doctrine:schema:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database schema';

    /**
     * The schema tool.
     *
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    private $tool;

    /**
     * The class metadata factory
     *
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    private $metadata;

    public function __construct(SchemaTool $tool, ClassMetadataFactory $metadata)
    {
        parent::__construct();
        $this->tool = $tool;
        $this->metadata = $metadata;
    }

    protected function configure()
    {
        $this->addOption('show-sql', false, InputOption::VALUE_NONE, 'Dumps SQL query and does not execute drop.');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $sql = $this->tool->getDropSchemaSQL($this->metadata->getAllMetadata());
        if (empty($sql)) {
            $this->info('Current models do not exist in schema.');
            return;
        }
        if ($this->option('show-sql')) {
            $this->info('Outputting drop query:');
            $this->info(implode(';' . PHP_EOL, $sql));
        } else {
            $this->info('Dropping database schema....');
            $this->tool->dropSchema($this->metadata->getAllMetadata());
            $this->info('Schema has been dropped!');
        }
    }

}
