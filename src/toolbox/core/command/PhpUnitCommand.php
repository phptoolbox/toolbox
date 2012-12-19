<?php

namespace toolbox\core\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of PhpUnitCommand
 *
 * @author toni
 */
class PhpUnitCommand extends Command
{
    protected function configure()
    {
        $dir = is_dir(getcwd().'/dev') ? getcwd().'/dev':  getcwd();
        $this
            ->setName('test')
            ->setDescription("Run a phpunit test in ".$dir. " directory")
        ;
    }

    private function getTestDirectory()
    {
        $cwd = getcwd();
        if(is_dir($wdir = $cwd.'/dev')){
            chdir($wdir);
        }else{
            $wdir = $cwd;
        }
        return $wdir;
    }

    protected function execute(InputInterface $input,  OutputInterface $output)
    {
        $cwd = getcwd();
        $wdir = $this->getTestDirectory();
        $output->writeln('Running test in directory '.$wdir);
        passthru('phpunit');
        chdir($cwd);
    }
}
?>
