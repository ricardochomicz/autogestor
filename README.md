# Auto Gestor

Bem-vindo ao **Auto Gestor**, um sistema desenvolvido em Laravel para gerenciar recursos e funcionalidades de forma eficiente.

## Estrutura do Projeto

O projeto segue a estrutura padrão do Laravel, com algumas pastas e arquivos adicionais para funcionalidades específicas:

## Instalação

1. Clone o repositório:

```bash
   git clone https://github.com/ricardochomicz/autogestor.git
   cd autogestor
```

2. Instale as dependências:

```bash
   composer install
   npm install
   npm run dev
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

9. Utilize o login:

```bash
    E-mail: admin@example.com
    Senha: password
```

## Funcionalidades

- Gestão de Usuários
- Gestão de Marcas
- Gestão de Categorias
- Gestão de Produtos

* Middleware de Permissão: O middleware de permissão verifica se o usuário atual tem permissão para acessar determinada rota.

## Como utilizar
- Após acessar o sistema com o login de adminnistrador, navegue até usuários e crie em permissões para o usuário (Usuário).
- Clique no botão Adicionar Permissão e selecione as permissões desejadas.