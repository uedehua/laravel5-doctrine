<?php

namespace UeDehua\LaravelDoctrine\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;

class DqlCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'doctrine:dql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a DQL query.';

    /**
     * The Entity Manager
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    
    protected function configure()
    {
        $this->addOption('hydrate', null, InputOption::VALUE_OPTIONAL,
                'Hydrate type. Available: object, array, scalar, single_scalar, simpleobject');
        
        $this->addArgument('dql', null, InputArgument::REQUIRED, 'DQL query.');
    }

    public function handle()
    {
        
    }

}
