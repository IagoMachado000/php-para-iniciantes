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

## 03 - Variáveis, seus tipos de dados e referência 

No PHP, as variáveis não precisam ter seus tipos definidos explicitamente. O tipo de dado é determinado pelo valor que você atribui a ela.

Existem oito tipos de dados primitivos, que podem ser divididos em três categorias principais:

-----

### Tipos Escalares (Unidade Simples)

Esses tipos representam valores únicos e simples.

  * **`Boolean`**: Armazena apenas dois valores possíveis: **`true`** (verdadeiro) ou **`false`** (falso). É muito usado em testes condicionais (`if`, `while`).
    ```php
    $logado = true;
    ```
  * **`Integer`**: Usado para números inteiros (positivos ou negativos), sem casas decimais. O tamanho do valor pode variar dependendo do seu sistema operacional (32-bit ou 64-bit).
    ```php
    $idade = 30;
    ```
  * **`Float`** (ou `double`): Usado para números com casas decimais ou em notação exponencial.
    ```php
    $preco = 19.99;
    $velocidade = 2.99792458e8; // velocidade da luz
    ```
  * **`String`**: Representa uma sequência de caracteres, ou seja, um texto. Pode ser delimitada por aspas simples (`'`) ou aspas duplas (`"`).
    ```php
    $nome = "Maria";
    $mensagem = 'Olá, mundo!';
    ```

-----

### Tipos Compostos (Coleções)

Esses tipos podem armazenar mais de um valor por vez.

  * **`Array`**: Um array é uma coleção ordenada de valores. O PHP oferece arrays muito flexíveis que podem ser tanto listas indexadas por números quanto mapas associativos com chaves e valores.
    ```php
    $frutas = ["Maçã", "Banana", "Laranja"]; // Array indexado
    $aluno = [
        "nome" => "João",
        "idade" => 25,
        "cidade" => "São Paulo"
    ]; // Array associativo
    ```
  * **`Object`**: Representa uma instância de uma classe. Os objetos armazenam dados (propriedades) e comportamentos (métodos) de forma organizada.
    ```php
    class Carro {
        public $cor;
        public function __construct($cor) {
            $this->cor = $cor;
        }
    }

    $meuCarro = new Carro("vermelho");
    ```

-----

### Tipos Especiais

Estes tipos têm propósitos específicos.

  * **`Resource`**: Um tipo especial que representa um recurso externo, como uma conexão com um banco de dados, um arquivo aberto ou uma imagem. O PHP usa `resource` para gerenciar esses recursos e garantir que sejam liberados corretamente após o uso.
    ```php
    $file = fopen("arquivo.txt", "r"); // $file é um resource
    ```
  * **`NULL`**: Um tipo que indica que uma variável não tem valor. Uma variável é `NULL` se ela:
      * Foi atribuída explicitamente com o valor `NULL`.
      * Ainda não foi declarada.
      * Foi "destruída" usando a função `unset()`.
    <!-- end list -->
    ```php
    $vazio = NULL;
    ```

---
### Referência

No contexto de variáveis no PHP, uma **referência** é uma forma de criar um **apelido** para outra variável. Em vez de copiar o valor da variável, a referência aponta para o mesmo local de memória.

Pense da seguinte forma:

  * **Atribuição normal (por valor):**
    Quando você faz `$b = $a;`, o PHP copia o **valor** de `$a` para uma nova variável `$b`. Elas são duas variáveis independentes. Se você mudar o valor de `$a`, `$b` não será afetado.

    ```php
    <?php
    $a = 10;
    $b = $a; // $b recebe uma cópia do valor de $a

    $a = 20; // Muda apenas o valor de $a

    echo $b; // Saída: 10
    ?>
    ```

  * **Atribuição por referência:**
    Quando você faz `$b = &$a;` (usando o `&`), o PHP faz com que `$b` seja uma **referência** para `$a`. Isso significa que `$a` e `$b` agora se referem à **mesma informação na memória**. Qualquer mudança feita em uma afetará a outra.

    ```php
    <?php
    $a = 10;
    $b = &$a; // $b é uma referência para $a

    $a = 20; // Muda o valor de $a...

    echo $b; // Saída: 20 (porque $b aponta para o mesmo local de memória)

    $b = 30; // Muda o valor de $b...

    echo $a; // Saída: 30 (porque $a também foi alterado)
    ?>
    ```

-----

### Por que usar referências?

As referências são úteis em alguns cenários específicos:

1.  **Modificar variáveis dentro de funções:**
    Normalmente, as funções operam em cópias das variáveis que recebem. Usando referências, você pode permitir que uma função altere o valor de uma variável passada como argumento.

    ```php
    <?php
    function adicionar_dez(&$numero) {
        $numero += 10;
    }

    $valor = 5;
    adicionar_dez($valor); // O valor de $valor agora é 15
    echo $valor; // Saída: 15
    ?>
    ```

2.  **Operar com grandes estruturas de dados:**
    Para arrays e objetos muito grandes, passar por valor (copiando tudo) pode ser ineficiente em termos de memória e desempenho. Usar referências pode evitar essa cópia, mas é preciso ter cuidado, pois mudanças inesperadas podem acontecer.

### O que você deve saber:

  * Usar referências pode tornar o seu código mais difícil de entender e depurar, pois não é óbvio que uma variável está sendo modificada em outro lugar.
  * Em PHP, a atribuição padrão é sempre **por valor**, a menos que você use o `&` para criar uma referência.
  * Objetos, por padrão, são atribuídos por referência no PHP 5 e versões mais recentes, o que significa que se você copiar um objeto, as duas variáveis se referirão à mesma instância.

## 04 - Constantes

As **constantes** no PHP são identificadores para um valor que **não pode ser alterado** durante a execução do script. Pense nelas como valores fixos que você pode reutilizar ao longo do seu código.

Diferente das variáveis, que podem ter seu valor mudado a qualquer momento, o valor de uma constante é definido uma única vez e permanece o mesmo até o fim da execução do programa.

-----

### Para que servem?

Usar constantes traz vários benefícios para o seu código:

1.  **Melhor legibilidade:** É muito mais fácil entender o que significa `URL_BASE` ou `LIMITE_UPLOAD` do que um valor "mágico" como `"/meu-site/"` ou `2048`.
2.  **Facilidade de manutenção:** Se um valor fixo precisar ser alterado (por exemplo, a senha do banco de dados ou a taxa de impostos), você só precisa mudar a constante em um único lugar, em vez de procurar e alterar o valor em todas as partes do código.
3.  **Segurança:** Constantes garantem que valores críticos, como chaves de API ou configurações de segurança, não sejam acidentalmente sobrescritos por outras partes do código.
4.  **Desempenho:** Acessar o valor de uma constante é um pouco mais rápido do que acessar o de uma variável.

-----

### Como usar?

Existem duas formas principais de definir constantes no PHP.

#### 1\. Usando a função `define()`

Esta é a forma mais tradicional de definir constantes em qualquer lugar do seu script.

**Sintaxe:** `define(nome, valor)`

  * `nome`: Uma `string` com o nome da constante. Por convenção, os nomes de constantes são escritos em **letras maiúsculas** para diferenciá-los de variáveis.
  * `valor`: O valor que você quer atribuir à constante. Pode ser um `boolean`, `integer`, `float`, `string`, `array` ou até mesmo `NULL`.

**Exemplo:**

```php
<?php
// Definindo uma constante para o nome do site
define("NOME_SITE", "Minha Loja Online");

// Definindo a taxa de imposto
define("TAXA_IMPOSTO", 0.05);

// Usando as constantes
echo "Bem-vindo(a) ao " . NOME_SITE . "!<br>";

$preco_produto = 100;
$valor_imposto = $preco_produto * TAXA_IMPOSTO;

echo "O imposto a ser pago é: R$ " . $valor_imposto;

// Tentar redefinir a constante causará um erro
// define("NOME_SITE", "Outro Nome"); // Fatal error: Constant NOME_SITE already defined

// Constantes também podem ser arrays
define("STATUS_USUARIO", ["ativo", "inativo", "pendente"]);
echo "O status inicial é: " . STATUS_USUARIO[0];
?>
```

-----

#### 2\. Usando a palavra-chave `const`

A partir do PHP 5.3, você pode usar a palavra-chave `const` para definir constantes, principalmente dentro de classes. A partir do PHP 7, ela também pode ser usada fora de classes.

**Sintaxe:** `const NOME = valor;`

**Exemplo:**

```php
<?php
// Constante definida fora de uma classe (a partir do PHP 7)
const URL_BASE = "https://www.meusite.com.br";

class Usuario {
    // Constante definida dentro de uma classe
    const TIPO_PADRAO = "cliente";
}

echo "A URL base é: " . URL_BASE . "<br>";

// Acessando uma constante de classe
echo "O tipo de usuário padrão é: " . Usuario::TIPO_PADRAO;

// Tentar redefinir também causa um erro
// const URL_BASE = "http://novo-site.com"; // Parse error
?>
```

### Qual usar?

  * Use `const` quando você precisar definir constantes dentro de **classes** ou em um **nível global** a partir do PHP 7. É a forma mais moderna e recomendada.
  * Use `define()` quando precisar definir uma constante de forma **condicional**, como dentro de um `if` ou `else`, já que `const` deve ser declarada no escopo principal do script.

## 