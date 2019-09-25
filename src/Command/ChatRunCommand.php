<?php

namespace App\Command;

use App\Chat\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChatRunCommand extends Command
{
    protected static $defaultName = 'chat:run';

    protected $chat;

    public function __construct(Chat $chat)
    {
        parent::__construct();

        $this->chat = $chat;
    }


    protected function configure()
    {
        $this
            ->setDescription('Lance un serveur websocket pour le chat')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);


        // Création d'un serveur WebSocket avec Ratchet
        $server = IoServer::factory(new HttpServer(new WsServer($this->chat)), 8081);

        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('Le serveur de chat à été lancé et est prêt a communiquer');

        $server->run();
    }
}
