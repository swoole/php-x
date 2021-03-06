<?php

namespace phpx\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Stop extends Command
{
    protected function configure()
    {
        $this
            ->setName('stop')
            ->setDescription('stop project')
            ->setHelp('This command allows you to stop project...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pid_file = getcwd() . '/project.pid';
        if (!is_file($pid_file)) {
            $output->write("<error>[$pid_file] not exists.</error>\n");
            return;
        }
        $pid = file_get_contents($pid_file);
        if (empty($pid) or \Swoole::$php->os->kill($pid, SIGTERM) == false) {
            $output->write("<error>Server is not running</error>\n");
            return;
        }
    }
}