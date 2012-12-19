<?php

/*
 * This file is part of the toolbox package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\core\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;
use dayax\core\Dayax;

/**
 * Description of ComposerCommand
 *
 * @author Anthonius Munthi <toni.munthi@gmail.com>
 */
class ComposerCommand extends Command
{
    protected function configure()
    {
        $this->setName('composer');
    }
    public function testLoadComposer()
    {

        $tmpDir = sys_get_temp_dir() . '/dayax/toolbox/composer';
        $phar = new \Phar('/apps/tools/bin/composer.phar');
        $phar->extractTo($tmpDir, null, true);

        Dayax::getLoader()->add('Composer', $tmpDir . '/src');

        $i = Finder::create();
        $i
                ->name('*.php')
                ->in($tmpDir . '/src');
        foreach ($i->files() as $file) {
            ///$s = new \Symfony\Component\Finder\SplFileInfo();
            $namespace = str_replace('/', '\\', $file->getRelativePath());
            $fullname = $namespace . '\\' . $file->getBaseName('.php');
            $file = $file->getPathname();
            if (false !== strpos($fullname, 'Composer\Command')) {
                if (class_exists($fullname, true)) {
                    $r = new \ReflectionClass($fullname);
                    if (!$r->isAbstract() && $r->isSubclassOf('Symfony\Component\Console\Command\Command')) {
                        $this->loadComposerCommand(new $fullname());
                    }
                }
            }
        }
    }

    private function loadComposerCommand(Command $ob)
    {
        $options = array();
        $shortcuts = array();
        foreach ($ob->getDefinition()->getOptions() as $option) {
            $options[] = '--' . $option->getName();
            if (!is_null($option->getShortcut())) {
                $shortcuts[] = '-' . $option->getShortcut();
            }
        }
        sort($options);
        sort($shortcuts);
        return array_merge($shortcuts, $options);
    }
}

?>
