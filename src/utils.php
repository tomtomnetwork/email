<?php
require('term.php');

function generateRefNumber(): int {
  return mt_rand(111111, 999999);
}

function generateRandomString(int $length = 16): string {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
  $str = '';
  
  for($i = 0; $i < $length; $i++) {
    $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
  }

  return $str;
}

function debug(string $msg, int $forecolor = 39, int $backcolor = 49) {
  if(!defined('DEBUG')) return;
  write(' > ', DEFAULT_COLOR, DEFAULT_COLOR, BOLD);
  write($msg, $forecolor, $backcolor);
}

function debugLn(string $msg, int $forecolor = 39, int $backcolor = 49) {
  if(!defined('DEBUG')) return;
  debug($msg, $forecolor, $backcolor);
  echo "\n";
}

function debugOk() {
  debugLn('OK', GREEN);
}

function parseArgv() {
  $argv = $_SERVER['argv'];
  $params = [];
  $lastKey = '';

  foreach($argv as $i => $arg) {
    if($i === 0) continue;

    if(preg_match('/^--/', $arg)) {
      $lastKey = substr($arg, 2);
      $params[$lastKey] = '';
    } else {
      $params[$lastKey] .= " $arg";
    }
  }

  foreach($params as &$value) {
    $value = trim($value);
  }

  $params['delay'] = $params['delay'] ?? 100;

  return $params;
}

function getParams(): object {
  $params = parseArgv();
  $obj = new stdClass;

  $obj->debug = isset($params['debug']);

  if($obj->debug) define('DEBUG', true);

  debugLn('');
  debugLn('MODO DE DEPURAÇÃO', WHITE, BLUE);
  debugLn('Parametros passados pelo usuário:');
  debugLn( print_r($params, true) );

  $obj->delay = $params['delay'] ?? null;
  debugLn("Delay de envio definido para {$obj->delay} milisegundos.");

  $obj->senderName = $params['nome'] ?? null;
  debugLn("Remetente definido para {$obj->senderName}");

  $obj->senderEmail = $params['de'] ?? null;
  debugLn("E-mail de remetente definido para {$obj->senderEmail}");
  
  $obj->subject = $params['assunto'] ?? null;
  debugLn("Assunto definido para {$obj->subject}");

  $obj->targets = [];

  try {
    debug("Carregando conteúdo de '{$params['conteudo']}'.");
    $obj->content = isset($params['conteudo']) ? file_get_contents($params['conteudo']) : null;
    debugOk();

    debug("Carregando anexo de '{$params['anexo']}.");
    $obj->attachment = isset($params['anexo']) ? file_get_contents($params['anexo']) : null;
    $obj->attachmentName = basename($params['anexo']);
    debugOk();
  } catch(Exception $e) {
    writeLn($e->getMessage(), WHITE, RED, BOLD);
    exit;
  }

  if(isset($params['para']) && !empty($params['para'])) {
    $obj->targets[] = $params['para'];
    debugLn("Destinatário {$params['para']} adicionado.");
  }

  if(isset($params['lista']) && is_readable($params['lista'])) {
    debugLn("Carregando destinatários da lista '{$params['lista']}'.");
    $fhandle = fopen($params['lista'], 'r');
    while(!feof($fhandle)) {
      $target = trim(fgets($fhandle));

      if(!filter_var($target, FILTER_VALIDATE_EMAIL)) {
        debugLn("Email {$target} não é válido. Ignorando...");
        continue;
      }

      $obj->targets[] = $target;

      debugLn("Destinatário {$target} adicionado.");
    }
    fclose($fhandle);
    debugOk();
  }

  try {
    validateParams($obj);
  } catch(Exception $e) {
    writeLn($e->getMessage(), WHITE, RED, BOLD);
    exit;
  }

  return $obj;
}

function validateParams(object $params) {
  debugLn('Validando parametros.');
  debug('Verificando presença de nome de remetente.');
  if(!$params->senderName) throw new Exception("\nForneça o nome do remetente.");
  debugOk();
  
  debug('Verificando presença de email do remetente.');
  if(!$params->senderEmail) throw new Exception("\nForneça o email do remetente.");
  debugOk();
  
  debug('Verificando se assunto foi fornecido.');
  if(!$params->subject) throw new Exception("\nForneça o assunto da mensagem.");
  debugOk();
  
  debug('Verificando se destinatários foram fornecidos.');
  if(count($params->targets) === 0) throw new Exception("\nForneça ao menos um destinatário para a mensagem.");
  debugOk();
  
  debug('Verificando se existe conteúdo a ser enviado na mensagem.');
  if(!$params->content) throw new Exception("\nNenhum conteúdo para enviar. O arquivo não existe, está vázio ou não pôde ser lido.");
  debugOk();
}

function verifySendMail() {
  if(!is_file('/usr/bin/sendmail') && !is_file('/usr/sbin/sendmail')) {
    writeLn('Sendmail não encontrado.', WHITE, RED);
    writeLn('Execute o comando', YELLOW);
    writeLn('sudo apt-get install postfix', WHITE);
    writeLn('ou', YELLOW);
    writeLn('sudo apt-get install sendmail', WHITE);
    writeLn('e tente executar este script novamente.', YELLOW);
    writeLn('');
    exit;
  }
}