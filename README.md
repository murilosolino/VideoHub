# VideoHub

> Um playground de aprendizado PHP onde "best practices" deixam de ser buzzwords e viram código de verdade.

Este projeto nasceu como um exercício de estudos, mas acabou virando um laboratório completo de arquitetura web moderna em PHP puro. Nada de frameworks gigantes aqui — cada linha de código foi escrita pensando em **como** e **por quê**.

## 🎯 O que esse projeto faz

VideoHub é uma aplicação web para gerenciar vídeos com upload de capas. Simples assim. Mas o interessante não é o que ele faz, e sim **como** ele faz:

- Sistema de autenticação completo (login, logout, criação de conta)
- Gerenciamento CRUD de vídeos com URLs do YouTube
- Upload e gerenciamento de imagens de capa
- API REST com autenticação JWT
- Isolamento de usuários (cada um vê apenas seus próprios vídeos)

## 🧰 O que tem de interessante aqui

### Arquitetura MVC customizada
Nada de usar um framework pronto. Criei um sistema MVC do zero usando **PSR-7** (HTTP Message) e **PSR-15** (HTTP Handlers). Todos os controllers implementam `RequestHandlerInterface` e trabalham com requests/responses imutáveis.

### Dependency Injection com PHP-DI
Zero `new` dentro de controllers. Tudo resolvido via container de injeção de dependência usando **PHP-DI**.

### Repository Pattern
A camada de dados está completamente isolada. Os controllers conversam com Services, que conversam com Repositories, que conversam com o banco. Mudar de SQLite pra MySQL? Muda só o repositório.

### API REST com autenticação JWT
Tem endpoints `/api/videos-json` e `/api/novo-video` protegidos por **JWT** usando firebase/php-jwt. O middleware `JwtAuthenticationMiddleware` intercepta as requisições de API e valida o token antes de deixar passar.

### PSR-7 compliant
Requests e Responses implementados com **nyholm/psr7**. Nada de usar `$_GET`, `$_POST` ou `echo` diretamente nos controllers. Tudo passa por objetos padronizados.

### Flash Messages
Sistema de mensagens temporárias usando trait `FlashMessageTrait`.

### Upload seguro de arquivos
A classe `CheckUploadArquivo` valida MIME type, gera nomes únicos com slug e salva tudo na pasta correta.

### Segurança de sessão
Cookies com flags `secure`, `httponly` e `samesite`. Regeneração de ID de sessão após login. Validação de propriedade de recursos (um usuário não consegue editar vídeo de outro).

### Routing simples mas eficaz
Sistema de roteamento baseado em array associativo (`método|path => Controller`). Limpo, legível e fácil de debugar.

## 🏗️ Stack técnica

- **PHP 8.x** (strict types em todos os arquivos)
- **SQLite** (banco relacional simples para desenvolvimento)
- **Composer** (autoload PSR-4)
- **League Plates** (template engine sem lógica no HTML)
- **Firebase JWT** (autenticação stateless na API)
- **Nyholm PSR-7** (implementação de HTTP messages)
- **PHP-DI** (container de injeção de dependência)

## 🚀 Como rodar na sua máquina

### 1. Clone e instale as dependências

```bash
git clone https://github.com/seu-usuario/VideoHub.git
cd VideoHub
composer install
```

### 2. Crie o banco de dados

```bash
php criar-banco.php
```

Isso vai gerar um arquivo `bancosqlite.sqlite` na raiz do projeto com as tabelas `usuarios` e `videos`.

### 3. Suba o servidor local

```bash
php -S localhost:8080 -t ./public/
```

Pronto! Acesse `http://localhost:8080` no navegador.

### 4. Crie um usuário manualmente

crie pelo formulário em `/criar-conta`.

## 📂 Estrutura do projeto

```
├── config/
│   ├── dependencies.php   # Container DI e bindings
│   └── routes.php         # Mapeamento de rotas
├── public/
│   ├── index.php          # Entry point da aplicação
│   ├── css/               # Estilos
│   └── img/uploads/       # Uploads de capas
├── src/
│   ├── Controller/        # Controllers web e API
│   ├── Entity/            # Modelos de domínio (Video, Usuario)
│   ├── Repository/        # Camada de acesso a dados
│   ├── Service/           # Lógica de negócio
│   ├── Middleware/        # JWT authentication
│   └── Helper/            # Traits e utilitários
├── views/                 # Templates PHP (Plates)
└── vendor/                # Dependências do Composer
```

## 🔐 Sobre a API

### Autenticação

```bash
POST /auth
Content-Type: application/json

{
  "email": "seu@email.com",
  "senha": "suasenha"
}
```

Retorna um JWT que você deve usar para acessar as rotas /api/

### Listar vídeos

```bash
GET /api/videos-json
Authorization: Bearer seu_token_jwt_aqui
```

### Criar vídeo via API

```bash
POST /api/novo-video
Authorization: Bearer seu_token_jwt_aqui
Content-Type: application/json

{
  "url": "https://youtube.com/watch?v=exemplo",
  "titulo": "Meu vídeo"
}
```

## 🎓 O que aprendi construindo isso

- Implementar PSRs na prática (não só ler a especificação)
- Criar um sistema de roteamento manual
- Trabalhar com HTTP messages imutáveis
- Separar responsabilidades em camadas (MVC + Services + Repositories)
- Segurança em upload de arquivos
- Autenticação stateless com JWT
- Injeção de dependência sem framework
- Foreign keys e integridade referencial no SQLite

## ⚠️ Disclaimer

Este é um **projeto de estudos**. Não foi pensado para produção. Faltam coisas tipo:

- Testes automatizados (PHPUnit)
- Validação mais robusta de inputs
- Paginação na listagem
- Rate limiting na API
- Logs estruturados
- Tratamento de erros mais elegante
- CORS configurável

Mas o objetivo era aprender fazendo, e isso foi cumprido. 🎯

## 📝 Licença

Livre para usar, estudar, modificar e aprender. Se ajudar alguém, já valeu.

---
