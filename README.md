<p align="center">
<img src="https://ultralinks.com.br/wp-content/uploads/2021/04/ultralinks-logo-horiz.svg" alt="Logo Ultralinks" width="200" />
</p>

# API Ultralinks
Esta é uma API desenvolvida em Laravel que oferece diversas funcionalidades para registro de usuários, autenticação, depósito e transferência de dinheiro entre contas.

### Funcionalidades disponíveis
- Registro de usuário
- Login e autenticação com JWT
- Depósito de dinheiro em contas de usuário
- Transferência de dinheiro entre contas de usuário
- Envio de e-mail com confirmação de depósito (RabbitMQ)

### Regras de negócio aplicadas
- Para realizar depósitos e/ou transferências, é necessário estar autenticado na aplicação.
- Não é possível fazer depósitos em sua própria conta (usuário autenticado).
- Não é possível transferir dinheiro da sua conta (usuário autenticado) para sua própria conta.
- Ao transferir valores, o valor informado deverá estar disponível na conta de origem (usuário autenticado) para então poder ser creditado na conta destino.

### Rodando o projeto localmente
1. Clone este repositório usando o comando `git clone` no seu terminal.
2. Depois de clonar o projeto, entre na pasta e execute o comando `docker-compose up -d` para subir os containers.
3. Em seguida, acesse o container do php através do comando `docker exec -it php /bin/bash` e execute `composer install` no terminal.
4. Copie o arquivo `.env-example` da pasta raíz do projeto e renomeie para `.env`.
5. Gere a chave da aplicação Laravel com o comando `php artisan key:generate`.
6. O banco de dados MySQL já está configurado. É necessário apenas rodar as migrations com o comando `php artisan migrate`.
7. Existe um arquivo na raíz do projeto com o nome de `endpoints.json` que contém todas as rotas da aplicação. Você pode importá-lo no Insomnia para fazer as requisições.
8. Também é necessário adicionar o endereço da nossa aplicação no arquivo de `hosts` da sua máquina.
9. Estamos prontos! A API vai estar disponível no endereço [http://ultralinks.local/api](http://ultralinks.local/api).

#### Importante
Antes de realizar algum depósito, deixe o worker das filas do Laravel ativo para ele processar o envio dos e-mails. Isso pode ser realizado com o comando `php artisan queue:work` dentro do container do php. O envio do e-mail será processado de forma assíncrona e poderá ser visualizado no arquivo de logs do framework, em `./laravel/logs/laravel.log`.
