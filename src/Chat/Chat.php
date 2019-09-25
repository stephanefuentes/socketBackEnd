<?php

namespace App\Chat;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{
    protected $clients = [];

    public function onOpen(ConnectionInterface $conn)
    {
        echo "Un client s'est connecté ({$conn->resourceId})\n";
        $this->clients[$conn->resourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {

        echo "Un message a été reçu de la part de {$from->resourceId} \n";
        dump($msg);
        // Je boucle sur toutes les connexions (ce que j'appelle "clients")
        // En récupérant leur ID et la connexion elle même
        foreach ($this->clients as $id => $client) {
            // Si l'id du client sur lequel je boucle est différent de l'id
            // qui vient d'envoyer le message
            if ($id !== $from->resourceId) {
                // J'envoi le message au client
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    { }



}
