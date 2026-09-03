🇧🇷 Português | [🇺🇸 English](README.en.md)

---
<img src="https://github.com/user-attachments/assets/59a50e72-04e2-4fa1-a9ea-726220b2c1d9" width="100%" alt="Library">

# Library

![Laravel](https://img.shields.io/badge/Laravel-12-000000?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.2.12-000000?style=flat-square)
![Blade](https://img.shields.io/badge/Blade-000000?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-000000?style=flat-square)

Sistema web desenvolvido em Laravel como projeto acadêmico, com o objetivo de implementar um CRUD completo para gerenciamento de livros lidos pelos usuários.

---

## Sobre o projeto

O projeto consiste em uma aplicação web para gerenciamento de livros lidos.

Cada usuário pode criar sua própria conta, realizar login e cadastrar os livros que já leu, registrando informações como título, autor, gênero, ano de publicação, nota e data de conclusão.

A aplicação utiliza o sistema de autenticação padrão do Laravel e o middleware `auth` para restringir o acesso às funcionalidades relacionadas aos livros.

Cada livro é associado ao usuário que o cadastrou, permitindo que cada usuário gerencie sua própria coleção de livros.

Este projeto foi desenvolvido como parte de um trabalho acadêmico da faculdade, com foco na implementação de um CRUD utilizando o framework Laravel.

---

## Tecnologias utilizadas

| Tecnologia | Papel no projeto |
|---|---|
| PHP 8.2.12 | Linguagem de programação |
| Laravel 12 | Framework principal da aplicação |
| Blade | Engine de templates utilizada na construção das páginas |
| MySQL | Banco de dados relacional |
| Eloquent ORM | Interação com o banco de dados |
| Laravel Authentication | Sistema de autenticação dos usuários |
| Middleware `auth` | Proteção das rotas que exigem autenticação |
| Migrations | Criação e gerenciamento da estrutura do banco de dados |

---

## Funcionalidades

* Cadastro de usuários
* Login e logout
* Autenticação utilizando os recursos padrão do Laravel
* Proteção de rotas através do middleware `auth`
* Cadastro de livros
* Listagem de livros
* Visualização de livros
* Edição de livros
* Exclusão de livros
* Associação dos livros ao usuário autenticado
* Registro da nota atribuída ao livro
* Registro da data de conclusão da leitura
* Upload e armazenamento de arquivo relacionado ao livro

---

## Informações dos livros

Cada livro cadastrado possui as seguintes informações:

| Campo | Descrição |
|---|---|
| `id` | Identificador único do livro |
| `user_id` | Usuário responsável pelo cadastro |
| `titulo` | Título do livro |
| `autor` | Autor do livro |
| `genero` | Gênero literário |
| `ano_publicacao` | Ano de publicação |
| `nota` | Nota atribuída ao livro |
| `data_conclusao` | Data em que a leitura foi concluída |
| `arquivo` | Arquivo relacionado ao livro |
| `created_at` | Data de criação do registro |
| `updated_at` | Data da última atualização |

---

## Estrutura do banco de dados

A tabela de livros possui um relacionamento com a tabela de usuários através da chave estrangeira `user_id`.

```text
User
 │
 │ 1:N
 │
 ▼
Book
```

Um usuário pode possuir vários livros cadastrados, enquanto cada livro pertence a um único usuário.

A exclusão de um usuário também remove os livros associados a ele através de `cascadeOnDelete()`.

### Migration

```php
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->string('titulo');
$table->string('autor');
$table->string('genero');
$table->integer('ano_publicacao');
$table->decimal('nota', 3, 1);
$table->date('data_conclusao');
$table->string('arquivo');
$table->timestamps();
```

---

## Como funciona

```text
Usuário acessa a aplicação
        ↓
Realiza cadastro
        ↓
Faz login
        ↓
Acessa a área de livros
        ↓
Cadastra um livro
        ↓
Preenche as informações da leitura
        ↓
O livro é associado ao usuário autenticado
        ↓
O usuário pode visualizar, editar ou excluir seus livros
```

---

## Autenticação

A aplicação utiliza o sistema de autenticação padrão disponibilizado pelo Laravel.

As rotas que permitem o gerenciamento dos livros são protegidas pelo middleware:

```php
auth
```

Dessa forma, somente usuários autenticados podem acessar as funcionalidades relacionadas ao gerenciamento dos livros.

---

## CRUD de livros

O sistema implementa as quatro operações principais de um CRUD:

### Create

Permite ao usuário cadastrar um novo livro informando seus dados e registrando a leitura realizada.

### Read

Permite visualizar e listar os livros cadastrados pelo usuário.

### Update

Permite editar as informações de um livro já cadastrado.

### Delete

Permite excluir um livro da coleção do usuário.

---

## Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/academic-projects.git
```

Entre na pasta do projeto:

```bash
cd academic-projects
```

Depois, entre na pasta específica do projeto:

```bash
cd CRUD books
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure o ambiente

Copie o arquivo `.env.example`:

```bash
cp .env.example .env
```

No Windows, caso necessário, você também pode simplesmente copiar o arquivo `.env.example` e renomeá-lo para `.env`.

Configure no `.env` as informações do seu banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Execute as migrations

```bash
php artisan migrate
```

### 6. Inicie o servidor

```bash
php artisan serve
```

A aplicação estará disponível em:

```text
http://127.0.0.1:8000
```

---

## Requisitos

Antes de executar o projeto, certifique-se de ter instalado:

* PHP 8.2 ou superior
* Composer
* MySQL
* Extensões PHP necessárias pelo Laravel 12

---

## Contexto acadêmico

Este projeto foi desenvolvido como parte de uma atividade acadêmica da faculdade, tendo como principal objetivo a aplicação prática dos conceitos de desenvolvimento web, banco de dados, autenticação de usuários e operações CRUD utilizando o framework Laravel.

---
