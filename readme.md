
instalar o git clone 

apt update; apt upgrade; apt install git net-tools dnsutils traceroute mtr grc -y \
echo "alias tail='grc tail'" >> /root/.bashrc \
echo "alias ping='grc ping'" >> /root/.bashrc \
echo "alias ps='grc ps'" >> /root/.bashrc \
echo "alias netstat='grc netstat'" >> /root/.bashrc \
echo "alias dig='grc dig'" >> /root/.bashrc \
echo "alias traceroute='grc traceroute'" >> /root/.bashrc 

caso apresente o erro abaixo a seguir 

/bin/bash^M: bad interpreter: No such file or directory. 

rode o comando abaixo para corrigir

sed -i -e 's/\r$//' install.sh

depois rode novamente o script
