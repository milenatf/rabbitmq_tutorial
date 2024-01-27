<?php
/**
 * Inclui o arquivo de autoload gerado pelo composer para carregar automaticamente as classe da biblioteca PhpAmqpLib que é utilizada para interagir
 * com o RabbitMq
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Importa a classe AMQPStreamConnection que é a classe usada para criar uma conexão com o servidor RabbitMq
 */
use PhpAmqpLib\Connection\AMQPStreamConnection;
/**
 * Importa a classe AMQPMessage que é usada para representar uma mensagem que será enviada para a fila
 */
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Cria uma instancia da classe AMQPStreamConnection para estabelecer uma conexão com o servidor RabbitMq
 *
 * Os parâmetros são, respectivamente:
 *
 * - Endereço IP do servidor (172.28.0.1: Neste caso este endereço IP é o do container docker que está executando o RabbitMq)
 * - A porta (5672 é a porta padrão do RabbitMq)
 * - Nome de usuário (admin: É o usuário padrão do RabbitMQ)
 * - Senha para autenticação (123456 é a senha padrão do RabbitMQ)
 */
$connection = new AMQPStreamConnection('172.28.0.1', 5672, 'admin', '123456');

/**
 * Cria um canal de comunicação dentro da conexão. Todas as operações relacionadas a fila e trocas acontecem em um canal
 */
$channel = $connection->channel();

/**
 * Declara uma fila chamada "hello"
 *
 * Os parâmetros são, respectivamente:
 *
 * - O nome da fila, neste caso é hello.
 * - Se deve ser uma fila durável (fila durável é uma fila que persiste mesmo quando o servidor é reiniciado. Isso significa que se uma fila é durável ela é armazenada
 * em um meio de armazenamento persistente - como o disco.)
 * - Se deve ser exclusiva
 * - Se deve ser excluída quando não estiver em uso
 * - Argumentos adicionaos
 */
$channel->queue_declare('hello', false, false, false, false);

/**
 * Cria uma instancia da classe AMQPMEssage contendo a string "Hello World", que será a mensagem enviada para a fila
 */
$msg = new AMQPMessage('Hello World 3!');

/**
 * Publica a mensagem na fila "hello".
 *
 * O segundo argumento é a rota (exchange), mas nesse caso, como estamos enviando diretamente para a fila, é deixado em branco.
 */
$channel->basic_publish($msg, '', 'hello');

/**
 * Exibe uma mensagem indicando que a mensagem foi enviada com sucesso.
 */
echo " [x] Sent 'Hello World 3!'\n";

/**
 * Fecha o canal
 */
$channel->close();

/**
 * Fecha a conexão com o servidor
 */
$connection->close();