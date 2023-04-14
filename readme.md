Parametros
==========

### nome
`--nome Nome do Remetente`  
Indica o nome do remente da mensagem.

### de
`--de email@teste.com.br`   
Endereço de email do remetente da mensagem.

### assunto
`--assunto Esta é uma mensagem teste`   
Assunto da mensagem a ser enviada.

### lista
`--lista lista_de_emails.txt`   
Indica a lista de emails ao qual a mensagem será enviada. Pode ser usado em conjunto com o parametro `--para`.

### para
`--para destinatario@teste.com.br`   
Endereço de e-mail ao qual enviar a mensagem. Pode ser usado em conjunto com `--lista`.

### conteudo
`--conteudo mensagem.html`   
Arquivo contendo o corpo da mensagem a ser enviada.

### anexo
`--anexo anexo.zip`   
Indica o arquivo a ser enviado como anexo da mensagem. Este é um parametro opcional; Omita-o caso a mensagem não necessite um anexo.

### delay
`--delay 1000`
Delay entre execuções do script, especificada em milisegundos (1000 milisegundos = 1 segundo).

### debug
`--debug`
Indica ao programa que mensagens de depuração devem ser exibidas. Este é um parametro opcional; Omita-o para não exibir mensagens de depuração.