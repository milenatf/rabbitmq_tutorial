<?php
/**
 * Inclui o arquivo de autoload gerado pelo composer para carregar automaticamente as classe da biblioteca PhpAmqpLib que é utilizada para interagir
 * com o RabbitMq
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Importa a classe AMQPMessage que é usada para representar uma mensagem que será enviada para a fila
 */
use PhpAmqpLib\Message\AMQPMessage;

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, '', 'hello');

echo ' [x] Sent ', $data, "\n";