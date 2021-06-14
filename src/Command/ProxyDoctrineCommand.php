<?php


namespace Zfegg\DoctrineHelper\Command;


use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProxyDoctrineCommand extends Command
{

    /**
     * @var Command
     */
    private $command;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, Command $command, string $prefix = 'doctrine')
    {
        $this->doctrine = $doctrine;
        $this->command = $command;
        $command->setName($prefix . ':' . $command->getName());
        $command
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command');

        $command->setCode(
            \Closure::fromCallable(function (InputInterface $input, OutputInterface $output) use($doctrine) {
                $em = $input->hasOption('em') ? $input->getOption('em') : null;
                $this->setHelperSet(ConsoleRunner::createHelperSet($doctrine->getManager($em)));
                $this->execute($input, $output);
            })->bindTo($command)
        );
        parent::__construct();
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->command->run($input, $output);
    }

    public function addArgument($name, $mode = null, $description = '', $default = null)
    {
        return $this->command->addArgument($name, $mode, $description, $default);
    }

    public function addOption($name, $shortcut = null, $mode = null, $description = '', $default = null)
    {
        return $this->command->addOption($name, $shortcut, $mode, $description, $default);
    }

    public function addUsage($usage)
    {
        return $this->command->addUsage($usage);
    }

    public function getAliases()
    {
        return $this->command->getAliases();
    }

    public function getApplication()
    {
        return $this->command->getApplication();
    }

    public function getDefinition()
    {
        return $this->command->getDefinition();
    }

    public function getDescription()
    {
        return $this->command->getDescription();
    }

    public function getHelp()
    {
        return $this->command->getHelp();
    }

    public function getHelper($name)
    {
        return $this->command->getHelper($name);
    }

    public function getHelperSet()
    {
        return $this->command->getHelperSet();
    }

    public function getName()
    {
        return $this->command->getName();
    }

    public function getNativeDefinition()
    {
        return $this->command->getNativeDefinition();
    }

    public function getProcessedHelp()
    {
        return $this->command->getProcessedHelp();
    }

    public function getSynopsis($short = false)
    {
        return $this->command->getSynopsis($short);
    }

    public function getUsages()
    {
        return $this->command->getUsages();
    }

    public function ignoreValidationErrors()
    {
        $this->command->ignoreValidationErrors();
    }

    public function isEnabled()
    {
        return $this->command->isEnabled();
    }

    public function isHidden()
    {
        return $this->command->isHidden();
    }

    public function mergeApplicationDefinition($mergeArgs = true)
    {
        $this->command->mergeApplicationDefinition($mergeArgs);
    }

    public function setAliases($aliases)
    {
        return $this->command->setAliases($aliases);
    }

    public function setCode($code)
    {
        return $this->command->setCode($code);
    }

    public function setDefinition($definition)
    {
        return $this->command->setDefinition($definition);
    }

    public function setDescription($description)
    {
        return $this->command->setDescription($description);
    }

    public function setHelp($help)
    {
        return $this->command->setHelp($help);
    }

    public function setHelperSet(HelperSet $helperSet)
    {
        $this->command->setHelperSet($helperSet);
    }

    public function setHidden($hidden)
    {
        return $this->command->setHidden($hidden);
    }

    public function setName($name)
    {
        return $this->command->setName($name);
    }

    public function setProcessTitle($title)
    {
        return $this->command->setProcessTitle($title);
    }

    public function setApplication(Application $application = null)
    {
        $this->command->setApplication($application);
    }
}
