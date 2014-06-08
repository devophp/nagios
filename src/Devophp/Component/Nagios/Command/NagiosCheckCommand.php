<?php 

namespace Devophp\Component\Nagios\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Devophp\Component\Nagios\Checker;
use Devophp\Component\Nagios\CheckResponse;

class NagiosCheckCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('nagios:check')
            ->setDescription(
                'Run nagios check'
            )
            ->addArgument(
                'check',
                InputArgument::REQUIRED,
                'check'
            )
            ->addOption(
                'arguments',
                null,
                InputOption::VALUE_REQUIRED,
                'arguments'
            );
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $checkname = $input->getArgument('check');
        $arguments = $input->getOption('arguments');
        
        $nagioschecker = new Checker();
        $nagioschecker->autoDetectPluginPath();

        $output->writeln("Running check '" . $checkname . "' with arguments: '" . $arguments . "'");
        $output->writeln("Pluginpath: " . $nagioschecker->getPluginPath());

        $response = $nagioschecker->check($checkname, $arguments);
        $output->writeln("Statuscode: " . $response->getStatusCode() . ' (' . $response->getStatusText() . ')');
        $output->writeln("ServiceOutput: " . $response->getServiceOutput());
        $output->writeln("ServicePerfData: " . $response->getServicePerfData());
        exit($response->getStatusCode());
    }
}
