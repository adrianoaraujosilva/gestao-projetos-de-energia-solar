## Começando com o Gerenciamento de Projetos de Energia Solar

Este repositório contém o código-fonte de um aplicativo completo para gerenciar projetos de energia solar. ☀️

### Pré-requisitos

Para executar o projeto, você precisará ter o Docker instalado em sua máquina.

### Instalação

1. **Clone o repositório:**

```bash
git clone https://github.com/adrianoaraujosilva/gestao-projetos-de-energia-solar.git
```

2. **Renomeie o arquivo de ambiente:**

```bash
mv www/.env.example www/.env
```

3. **Suba o container:**

```bash
docker-compose up
```

4. **Aguarde:**

Aguarde o download dos pacotes e a estabilização do servidor.

5. **Entre no container:**

```bash
docker-compose exec app bash
```

6. **Crie a chave de criptografia da aplicação:**

```bash
php artisan key:generate
```

7. **Crie as tabelas da aplicação:**

```bash
php artisan migrate
```

8. **Semeie as tabelas com dados:**

```bash
php artisan db:seed
```

9. **Execute os testes (alguns podem falhar):**

```bash
php artisan test --testsuite=Unit
```

### Acessando a aplicação

- **URL:** http://localhost:8000/
- **Documentação da API:** http://localhost:8000/api/documentation

### Credenciais de Acesso Inicial

- **Usuário:** ADMIN
- **E-mail:** admin@admin.com
- **Senha:** Admin@123

**Diretórios:**

- **mysql:** Contém os arquivos de inicialização do banco de dados (MySQL).
- **nginx:** Armazena os arquivos de configuração do container NGINX.
- **php:** Contém os arquivos de configuração do container da aplicação.
- **www:** Pasta raiz da aplicação.

**Subdiretórios da pasta www:**

- **app:**
  - **Filters:** Arquivos de filtragem dos modelos para os métodos `findAll()`.
  - **Http\Controllers:** Controladores da aplicação.
  - **Http\Middleware:** Regras de acesso e injeção no header das requisições.
  - **Http\Requests:** Regras de validação para as requisições da aplicação.
  - **Http\Resources:** Recursos que manipulam os retornos da API para o usuário.
  - **Model:** Modelos das tabelas do sistema, relacionamentos e injeções globais para controlar o acesso de usuários.
  - **Pagination:** Arquivo de padronização da paginação.
  - **Rules:** Regras customizadas para validação do cadastro/edição de equipamentos nos projetos.
  - **Services:** Arquivos que controlam todas as regras de negócio da aplicação.
  - **Traits:** Códigos reutilizáveis em diversos pontos da aplicação.
- **database:**
  - **factories:** Arquivos para criação aleatória de dados nas tabelas.
  - **migrations:** Arquivos contendo a estrutura para criação de todas as tabelas da aplicação.
  - **seeders:** Arquivos para semear as tabelas com registros aleatórios.
- **routes:** Arquivos contendo as rotas da aplicação (especificamente, o `api.php`).
- **tests\Unit:** Arquivos com os testes unitários.
- **.env:** Arquivo com as propriedades padrão da aplicação.
- **composer.json:** Relação de todas as dependências e pacotes necessários para a aplicação rodar.

**Outros arquivos:**

- **docker-compose.yml:** Arquivo de configuração dos containers.

### Débitos Técnicos

- Finalizar os testes unitários para o Controller e Service de Projetos;
- Refatorar as classes de serviço, incluindo paginação nos métodos `findAll()`, e validação de dados dentro dos métodos (para evitar erros nos testes unitários);
- Refatorar e aumentar a cobertura dos testes unitários;
- Melhorar a legibilidade do Readme e incluir a estrutura de pastas do projeto.

### Contribuições

Sinta-se à vontade para contribuir com o projeto! Envie suas sugestões, correções de bugs e novos recursos através de pull requests.
