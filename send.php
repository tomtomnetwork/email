<?php
require('src/utils.php');
require('src/email.php');

verifySendMail();

$rndStr = generateRandomString();
$params = getParams();

$totalTargets = count($params->targets);

foreach($params->targets as $i => $to) {
  $current = $i + 1;

  write("Enviando email $current de $totalTargets para ", WHITE);
  writeLn($to, YELLOW, DEFAULT_COLOR);

  $result = sendEmail(
    $params->senderName, 
    $params->senderEmail,
    $to,
    $params->subject,
    $params->content,
    $params->attachment ?? '',
    $params->attachmentName ?? ''
  );

  $result
    ? writeLn("Email enviado para $to", GREEN)
    : writeLn("Não foi possível enviar email para $to", RED);

  usleep($params->delay);
}

writeLn('Execução finalizada.', WHITE, BLUE);