# PHP para iniciantes

## Iniciando o servidor local

- Comando `php -S localhost:<port> -t public`
- **-t public** sinaliza pro servidor o diretório raiz (document root)
- Esse acréscimo no comando é necessário pra aplicações personalizadas ou frameworks que tem o core e a aplicação fora da pasta public e a única coisa que é exposta diretamente à web é o conteúdo da pasta public (É um boa prática de segurança expor apenas a public e todo o core da aplicação estar fora da /public)

## 02 - Onde digitar meu código e include/require

Para incluir um arquivo PHP dentro de outro, você pode usar uma das quatro construções de linguagem: `include`, `include_once`, `require` ou `require_once`.

### 1\. `include`

A função `include` é usada para incluir e avaliar um arquivo no script atual. Se o arquivo não puder ser encontrado, o script continuará a ser executado, mas com um **aviso** (`warning`).

**Exemplo de uso:**

```php
<?php

// arquivo: header.php
echo "<h1>Cabeçalho do Site</h1>";

?>

<?php

// arquivo: index.php
include 'header.php';
echo "<p>Conteúdo principal da página.</p>";
include 'footer.php'; // Se este arquivo não existir, o script mostrará um aviso, mas continuará.

?>
```

-----

### 2\. `require`

A função `require` funciona de forma muito similar ao `include`, mas com uma diferença crucial: se o arquivo não puder ser encontrado, o script **parará de ser executado** e gerará um **erro fatal** (`fatal error`). Isso é útil para quando o arquivo a ser incluído é essencial para o funcionamento do script.

**Exemplo de uso:**

```php
<?php

// arquivo: database.php
$db = new PDO(...); // Conexão com o banco de dados

?>

<?php

// arquivo: profile.php
require 'database.php'; // Se a conexão com o banco de dados falhar, o script inteiro para.
$user = $db->query("SELECT * FROM users WHERE id = 1");

?>
```

-----

### 3\. `include_once` e `require_once`

Essas duas variações se comportam exatamente como `include` e `require`, mas com uma diferença importante: elas garantem que o arquivo será incluído **apenas uma vez** durante a execução do script.

Isso é extremamente útil para evitar problemas como a redefinição de funções, classes ou variáveis.

**Exemplo de uso:**

```php
<?php

// arquivo: functions.php
function sayHello() {
    echo "Olá!";
}

?>

<?php

// arquivo: index.php
include 'functions.php'; // Inclui pela primeira vez
include 'functions.php'; // Inclui pela segunda vez, causando um erro fatal

// Para evitar isso, use:
require_once 'functions.php'; // Inclui pela primeira vez e ignora as próximas
require_once 'functions.php'; // Será ignorado, pois o arquivo já foi incluído

?>
```

### Qual usar?

  * Use `require` ou `require_once` para arquivos que são **críticos** para a operação do seu script (como arquivos de configuração ou classes essenciais).
  * Use `include` ou `include_once` para arquivos que são **não-críticos** e a execução do script pode continuar mesmo se eles não forem encontrados (como rodapés ou menus opcionais).
  * Prefira sempre a versão `_once` (`include_once` e `require_once`) para evitar problemas com a inclusão duplicada de arquivos.