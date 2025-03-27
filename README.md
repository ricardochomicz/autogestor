# Auto Gestor

Bem-vindo ao **Auto Gestor**, um sistema desenvolvido em Laravel para gerenciar recursos e funcionalidades de forma eficiente.

## Instalação

### Utilização Local

Para utilizar o Auto Gestor localmente, siga os seguintes passos:

1. Clone o repositório:

```bash
   git clone https://github.com/ricardochomicz/autogestor.git auto_gestor
   cd auto_gestor
```

2. Instale as dependências:

```bash
   composer install

   npm install && npm run dev
```

3. Configure as variáveis de ambiente:

```bash
   cp .env.example .env

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=autogestordb
   DB_USERNAME=root
   DB_PASSWORD=root
```

5. Gere o chave da aplicação:

```bash
   php artisan key:generate
```

6. Execute as migrations:

```bash
   php artisan migrate --seed
```

7. Inicie o servidor:

```bash
   php artisan serve
```

8. Acesse o aplicativo em http://localhost:8000

### Utilização Docker

Para utilizar o Auto Gestor em ambiente Docker, siga os seguintes passos:

1. Clone o repositório:

```bash
   git clone https://github.com/ricardochomicz/autogestor.git auto_gestor
   cd auto_gestor
```

2. Suba o container Docker:

```bash
   docker-compose up -d
```

3. Acesse o Container Docker e Instale as dependências:

```bash
   docker exec -it autogestor bash
   
   composer install

   cp .env.example .env

   chown -R www-data:www-data /var/www/auto_gestor/storage/
   chmod -R 775 /var/www/auto_gestor/storage/

   apt update && apt install -y nano (Para editar o arquivo .env)

   nano .env
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=autogestordb
   DB_USERNAME=user
   DB_PASSWORD=pass

   php artisan key:generate

   php artisan migrate --seed   
```

### Utilização
Faça o login de administrador gerado na seed com as seguintes credenciais:

```bash
    E-mail: admin@email.com
    Senha: password
```

- Após acessar o sistema com o login de adminnistrador, navegue até usuários e crie em permissões para o usuário (Usuário Comum).
- Clique no botão Adicionar Permissão e selecione as permissões desejadas.
- Após adicionar as permissões logue com Usuário Comum para testar as permissões.

```bash
    E-mail: user@email.com
    Senha: password
```

## Funcionalidades

- Gestão de Usuários
- Gestão de Marcas
- Gestão de Categorias
- Gestão de Produtos

* Middleware de Permissão: O middleware de permissão verifica se o usuário atual tem permissão para acessar determinada rota.


