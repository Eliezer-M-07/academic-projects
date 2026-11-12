Português | [English](README.en.md)

---

# Saboria

![Node.js](https://img.shields.io/badge/Node.js-ESM-000000?style=flat-square&logo=node.js&logoColor=white)
![Express](https://img.shields.io/badge/Express-5-000000?style=flat-square&logo=express&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-000000?style=flat-square&logo=mysql&logoColor=white)
![EJS](https://img.shields.io/badge/Views-EJS-000000?style=flat-square)

Aplicação web para cadastro, consulta e gerenciamento de receitas, desenvolvida com Node.js, Express, MySQL e EJS. O projeto inclui autenticação por sessão, envio de imagens e controle de propriedade das receitas.

---

## Sobre o projeto

O Saboria permite que visitantes consultem receitas publicadas por todos os usuários. Usuários autenticados podem cadastrar receitas e gerenciar as próprias publicações.

Cada receita possui título, descrição, categoria, caminho da imagem, autor e data de criação. As imagens são servidas pelo Express a partir do diretório `public/`.

O fluxo principal de uma operação segue esta estrutura:

```text
HTTP Request
    ↓
Express Route
    ↓
Authentication Middleware (protected routes)
    ↓
Controller
    ↓
Sequelize Model
    ↓
MySQL
```

As páginas são renderizadas no servidor com EJS. Os arquivos enviados por formulários `multipart/form-data` são processados com Formidable.

---

## Tecnologias utilizadas

| Tecnologia | Papel no projeto |
|---|---|
| Node.js | Runtime da aplicação |
| Express 5 | Servidor HTTP, middleware e rotas |
| MySQL | Banco de dados relacional |
| Sequelize | Mapeamento objeto-relacional e consultas ao banco |
| EJS | Renderização de páginas no servidor |
| express-session | Sessões de autenticação |
| Formidable | Processamento de formulários com upload de arquivos |
| bcrypt | Hash e verificação de senhas |
| Tailwind CSS 4 | Estilização da interface |
| dotenv | Carregamento das variáveis de ambiente |

---

## Funcionalidades

- Cadastro e login de usuários.
- Foto de perfil opcional no cadastro e edição posterior pelo perfil.
- Hash de senha com bcrypt.
- Criação, consulta, edição e exclusão de receitas.
- Listagem pública de receitas em cards com imagem, categoria, descrição e autor.
- Consulta pública dos detalhes de cada receita.
- Controle de acesso por sessão nas operações de escrita.
- Restrição de edição e exclusão ao autor da receita.
- Upload de imagens JPG, PNG e WEBP, com limite de 5 MB.
- Navbar compartilhada com opções de navegação conforme o estado de autenticação.
- Paginação da listagem pública e das receitas do perfil.

---

## Arquitetura

### Routes

As rotas conectam métodos e caminhos HTTP aos controllers. As rotas que criam, editam ou excluem receitas usam o middleware `requireAuth`.

### Middleware

`requireAuth` verifica a existência de `req.session.userId`. Sem uma sessão autenticada, a requisição é redirecionada para `/login`.

### Controllers

Os controllers coordenam a requisição, validam os dados recebidos, executam operações por meio dos modelos Sequelize e escolhem a resposta ou view.

### Models

Os modelos Sequelize representam as tabelas `users`, `categories` e `recipes`. As associações permitem consultar a categoria e o autor de cada receita.

### Views

As páginas EJS ficam em `views/`. Componentes compartilhados, como a navbar, o formulário e o card de receita, ficam em `views/partials/` ou `views/recipes/partials/`.

---

## Estrutura do projeto

```text
src/
├── config/
│   └── database.js
├── controllers/
│   ├── authController.js
│   ├── recipeController.js
│   └── userController.js
├── middlewares/
│   └── authMiddleware.js
├── models/
│   ├── Category.js
│   ├── Recipe.js
│   ├── User.js
│   └── index.js
└── routes/
    ├── authRoutes.js
    ├── recipeRoutes.js
    └── userRoutes.js

views/
├── auth/
├── partials/
├── recipes/
└── user/

public/
├── css/
├── images/
└── uploads/       # criado quando um arquivo é enviado

app.js
server.js
```

---

## Banco de dados

O banco utilizado pela aplicação é MySQL. O bloco SQL abaixo define as tabelas necessárias e insere as categorias iniciais. A aplicação espera que esse esquema exista e não o cria nem sincroniza automaticamente.

### SQL do esquema

O bloco abaixo cria as tabelas e insere as categorias iniciais:

```sql
CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL
);

CREATE TABLE categories(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL
);

INSERT INTO categories (name) VALUES
('Café da manhã'),
('Lanches'),
('Entradas'),
('Saladas'),
('Massas'),
('Carnes'),
('Frango'),
('Peixes e frutos do mar'),
('Acompanhamentos'),
('Pratos vegetarianos'),
('Pratos veganos'),
('Sopas e caldos'),
('Arroz e risotos'),
('Sobremesas'),
('Bolos e tortas'),
('Doces'),
('Pães e salgados'),
('Bebidas'),
('Sucos e vitaminas'),
('Receitas fitness'),
('Receitas rápidas'),
('Receitas econômicas'),
('Comida brasileira'),
('Comida internacional');

CREATE TABLE recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category_id INT NOT NULL,
    archive VARCHAR(255) NOT NULL,
    user_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

Ao remover uma conta, `user_id` das receitas relacionadas passa a `NULL`, preservando as receitas e suas imagens.

O campo `archive` armazena um caminho relativo, por exemplo `/uploads/nome-gerado.webp`. Os arquivos correspondentes são gravados em `public/uploads/`.

---

## Upload de imagens

- Receitas novas exigem uma imagem.
- Na edição de uma receita, a imagem pode ser mantida ou substituída.
- A foto de perfil é opcional no cadastro e pode ser alterada na tela de perfil.
- Os formatos aceitos pela aplicação são JPG, PNG e WEBP.
- O limite de tamanho configurado nos formulários de upload é 5 MB.
- O diretório `public/uploads/` é criado quando necessário.

---

## Autenticação e autorização

O Express Session mantém o identificador, o nome e a foto do usuário autenticado na sessão. O cookie é configurado como `httpOnly` e expira após 24 horas. O armazenamento de sessão padrão do Express Session é em memória.

O middleware de autenticação protege as rotas de cadastro, edição e exclusão de receitas. Os controllers também consultam a receita pelo identificador junto com `user_id` da sessão antes de permitir edição ou exclusão. As rotas de listagem e detalhes permanecem públicas.

As senhas são armazenadas como hashes gerados com bcrypt; a senha original não é gravada no banco.

---

## Rotas

| Método | Rota | Acesso | Descrição |
|---|---|---|---|
| `GET` | `/` | Público | Página inicial e receitas recentes |
| `GET` | `/recipes` | Público | Listagem paginada de receitas |
| `GET` | `/recipes/:id` | Público | Detalhes de uma receita |
| `GET` | `/register` | Público | Formulário de cadastro |
| `POST` | `/register` | Público | Cria uma conta e recebe foto opcional |
| `GET` | `/login` | Público | Formulário de login |
| `POST` | `/login` | Público | Autentica um usuário |
| `POST` | `/logout` | Autenticado | Encerra a sessão |
| `GET` | `/profile` | Autenticado | Perfil e receitas do usuário |
| `POST` | `/profile/edit` | Autenticado | Atualiza nome, e-mail ou foto de perfil |
| `POST` | `/profile/delete` | Autenticado | Exclui a conta |
| `GET` | `/recipes/create` | Autenticado | Formulário de cadastro de receita |
| `POST` | `/recipes/create` | Autenticado | Cria uma receita |
| `GET` | `/recipes/edit/:id` | Autor autenticado | Formulário de edição |
| `POST` | `/recipes/edit/:id` | Autor autenticado | Atualiza uma receita |
| `POST` | `/recipes/delete/:id` | Autor autenticado | Exclui uma receita |

---

## Variáveis de ambiente

Crie um arquivo `.env` na raiz do projeto:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=saboria
DB_USER=root
DB_PASSWORD=sua_senha_mysql
SESSION_SECRET=defina-uma-chave-longa-e-aleatoria
PORT=3000
```

`DB_PASSWORD` pode ficar vazio se a instalação local do MySQL não exigir senha. `PORT` é opcional e, quando omitido, o servidor usa a porta `3000`.

---

## Instalação e execução

### 1. Instalar dependências

```bash
npm install
```

### 2. Criar o banco

No MySQL, crie o banco:

```sql
CREATE DATABASE saboria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Execute o bloco SQL da seção Banco de dados no banco `saboria`. O servidor verifica a conexão, mas não cria as tabelas automaticamente.

### 3. Configurar ambiente

Crie o `.env` com os dados da conexão MySQL e a chave da sessão.

### 4. Iniciar o servidor

```bash
npm start
```

O servidor testa a conexão com o banco antes de escutar na porta configurada. A aplicação fica disponível em `http://localhost:3000`, salvo alteração de `PORT`.

Para desenvolvimento com reinicialização automática:

```bash
npm run dev
```

---

## Tailwind CSS

O CSS compilado é servido de `public/css/style.css`. Para recompilar após alterações nas views ou classes:

```bash
npm run css:build
```

Para recompilar automaticamente durante o desenvolvimento:

```bash
npm run css:watch
```

---

## Scripts disponíveis

| Comando | Descrição |
|---|---|
| `npm start` | Inicia o servidor |
| `npm run dev` | Inicia o servidor com Nodemon |
| `npm run css:build` | Gera o CSS do Tailwind |
| `npm run css:watch` | Observa alterações e recompila o CSS |
