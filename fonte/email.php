<?php
function sendEmail(string $sender, string $senderEmail, string $to, string $subject, string $content, string $attachment = '', string $attachmentName = '') {
  $refNumber = generateRefNumber();
  $from = "{$sender}<{$senderEmail}>";
  $subject = "{$subject}   ($refNumber)";
  $boundary = md5(microtime());
  $content = str_replace('xxlinkxx', generateRandomString(), $content);
  $content = str_replace('﻿', '', $content);

  debugLn("Referencia: $refNumber");
  debugLn("Boundary: $boundary");

  $headers = [
    'X-Mailer: Apple Mail (2.1990.1)',
    "From: {$from}",
    'MIME-Version: 1.0',
    "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
    'Content-Transfer-Encoding: 7bit',
    'This is a MIME encoded message.'
  ];

  $msg = [
    "--{$boundary}",
    'Content-Type: text/html; charset="UTF-8"',
    'Content-Transfer-Encoding: 8bit',
    '',
    $content,
    '',
  ];

  if($attachment) {
    $attachment = chunk_split(base64_encode($attachment));

    $msg = array_merge($msg, [
      "--{$boundary}",
      "Content-Type: application/octet-stream; name=\"{$attachmentName}\"",
      "Content-Transfer-Encoding: base64",
      "Content-Disposition: attachment",
      '',
      $attachment,
      '',
      "--{$boundary}--"
    ]);
  }

  $msg = implode("\r\n", $msg);
  $headers = implode("\r\n", $headers);

  debugLn('');
  debugLn("Cabeçalho:", BLUE);
  debugLn($headers, MAGENTA);
  debugLn('');
  debugLn("Mensagem:", BLUE);
  debugLn($msg, MAGENTA);

  return mail($to, $subject, $msg, $headers);
}
