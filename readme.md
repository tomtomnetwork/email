<h1 caso apresente o erro abaixo a seguir 

/bin/bash^M: bad interpreter: No such file or directory. 

rode o comando abaixo para corrigir

sed -i -e 's/\r$//' install.sh

depois rode novamente o script
