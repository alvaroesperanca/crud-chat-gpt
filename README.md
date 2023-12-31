# Projeto CRUD em PHP com MySQL

Este é um simples projeto CRUD (Create, Read, Update, Delete) em PHP utilizando MySQL como banco de dados. O projeto inclui páginas para login, cadastro de usuários, listagem e cadastro de novos usuários.

## Estrutura do Projeto

- **conexao.php:** Arquivo de conexão com o banco de dados MySQL.
- **login.php:** Página de login que redireciona para a página de cadastro se o usuário for um administrador.
- **cadastro.php:** Página que exibe uma lista de usuários e permite cadastrar novos usuários. Também inclui um botão de logout.
- **processa_cadastro.php:** Lógica para processar o formulário de cadastro e inserir novos usuários no banco de dados.
- **logout.php:** Script para realizar o logout do usuário.
- **README.md:** Este arquivo, contendo informações sobre o projeto.

## Instruções de Uso

1. Configure a conexão com o banco de dados no arquivo `conexao.php` substituindo os valores de `$servername`, `$username`, `$password`, e `$dbname` pelos seus próprios.
2. Importe o script SQL fornecido (`script.sql`) para criar o banco de dados e a tabela necessários.
3. Execute o projeto em um servidor web (por exemplo, Apache) com suporte ao PHP.

## Configuração do Banco de Dados

1. **Criar Banco de Dados:**
    ```sql
    CREATE DATABASE crud;
    ```

2. **Criar Tabela "usuarios":**
    ```sql
    USE crud;

    CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        senha VARCHAR(50) NOT NULL,
        role VARCHAR(20) NOT NULL
    );
    ```

3. **Inserir Usuário Admin:**
    ```sql
    USE crud;

    INSERT INTO usuarios (nome, senha, role) VALUES ('admin', 'admin', 'admin');
    ```

## Dependências Externas

- Bootstrap 4.5.2: Uma biblioteca de design para criar interfaces web elegantes e responsivas. Link CDN utilizado no código.

## Observações

- O projeto é para fins educacionais e pode necessitar de ajustes de segurança para uso em um ambiente de produção.
- Certifique-se de sempre proteger informações sensíveis, como senhas de banco de dados.

Sinta-se à vontade para contribuir, reportar problemas ou sugerir melhorias para este projeto.
