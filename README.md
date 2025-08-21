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

## 06 - Operadores aritméticos

Os operadores aritméticos no PHP são símbolos que você usa para realizar operações matemáticas, como adição, subtração, multiplicação, etc., com valores numéricos.

Aqui está uma lista dos principais operadores aritméticos:

### 1\. Adição (`+`)

Soma dois valores.

```php
<?php
$a = 5;
$b = 3;
$soma = $a + $b; // $soma agora é 8
?>
```

-----

### 2\. Subtração (`-`)

Subtrai o segundo valor do primeiro.

```php
<?php
$a = 10;
$b = 4;
$subtracao = $a - $b; // $subtracao agora é 6
?>
```

-----

### 3\. Multiplicação (`*`)

Multiplica dois valores.

```php
<?php
$a = 6;
$b = 7;
$multiplicacao = $a * $b; // $multiplicacao agora é 42
?>
```

-----

### 4\. Divisão (`/`)

Divide o primeiro valor pelo segundo. O resultado pode ser um número decimal (float).

```php
<?php
$a = 20;
$b = 5;
$divisao = $a / $b; // $divisao agora é 4

$c = 10;
$d = 3;
$divisao_decimal = $c / $d; // $divisao_decimal agora é 3.333...
?>
```

-----

### 5\. Módulo (`%`)

Retorna o **resto** da divisão de um número por outro. É muito útil para verificar se um número é par ou ímpar, ou para operações cíclicas.

```php
<?php
$a = 10;
$b = 3;
$resto = $a % $b; // 10 dividido por 3 é 3, com resto 1. $resto agora é 1.

$par_ou_impar = 4 % 2; // O resto da divisão de 4 por 2 é 0.
$par_ou_impar_2 = 5 % 2; // O resto da divisão de 5 por 2 é 1.
?>
```

-----

### 6\. Exponenciação (`**`)

Eleva o primeiro valor à potência do segundo. Funciona como um "elevado a".

```php
<?php
$a = 2;
$b = 3;
$potencia = $a ** $b; // 2 elevado a 3, ou seja, 2 * 2 * 2. $potencia agora é 8.
?>
```

### Precedência de Operadores

Assim como na matemática, os operadores têm uma ordem de precedência. Por exemplo, a multiplicação e a divisão são realizadas antes da adição e da subtração. Se você precisar alterar essa ordem, pode usar parênteses `()`.

**Ordem (da maior para a menor precedência):**

1.  Parênteses `()`
2.  Exponenciação `**`
3.  Multiplicação `*`, Divisão `/`, Módulo `%` (mesma precedência, avaliados da esquerda para a direita)
4.  Adição `+`, Subtração `-` (mesma precedência, avaliados da esquerda para a direita)

**Exemplo:**

```php
<?php
// Sem parênteses
$resultado = 5 + 2 * 3; // Primeiro 2 * 3 = 6, depois 5 + 6 = 11.
echo $resultado; // Saída: 11

// Com parênteses
$resultado_com_parenteses = (5 + 2) * 3; // Primeiro 5 + 2 = 7, depois 7 * 3 = 21.
echo $resultado_com_parenteses; // Saída: 21
?>
```

## 07 - Operadores de atribuição

O **operador de atribuição** em PHP é o sinal de igual (`=`). Ele é usado para dar um valor a uma variável.

Pense nele como um comando que diz: "pegar o valor do lado direito e colocar dentro da variável do lado esquerdo".

```php
<?php
$nome = "João"; // Atribui a string "João" à variável $nome
$idade = 30; // Atribui o número 30 à variável $idade
$preco = 9.99; // Atribui o float 9.99 à variável $preco
?>
```

### Operadores de Atribuição Combinados

Além da atribuição simples, o PHP oferece uma série de operadores combinados que realizam uma operação aritmética e uma atribuição ao mesmo tempo. Eles são uma forma mais curta de escrever o código e são muito comuns.

| Operador | Equivalente a... | Exemplo | Descrição |
| :--- | :--- | :--- | :--- |
| `+=` | `$x = $x + $y` | `$x += 5;` | Adiciona um valor à variável. |
| `-=` | `$x = $x - $y` | `$x -= 3;` | Subtrai um valor da variável. |
| `*=` | `$x = $x * $y` | `$x *= 2;` | Multiplica a variável por um valor. |
| `/=` | `$x = $x / $y` | `$x /= 4;` | Divide a variável por um valor. |
| `%=` | `$x = $x % $y` | `$x %= 3;` | Atribui o resto da divisão. |
| `**=` | `$x = $x ** $y` | `$x **= 2;` | Eleva a variável a uma potência. |
| `.=` | `$x = $x . $y` | `$x .= "!";` | Concatena uma string à variável. |

-----

### Exemplos de Uso

Imagine que você tem a variável `$contador` com o valor `10`.

```php
<?php
$contador = 10;

// Somando 5 de forma normal
$contador = $contador + 5;
echo $contador; // Saída: 15

// Fazendo a mesma coisa com o operador combinado
$contador = 10;
$contador += 5;
echo $contador; // Saída: 15
?>
```

O operador de concatenação de strings (`.`) também tem uma versão de atribuição.

```php
<?php
$nome = "Olá";
$nome .= " Mundo"; // O mesmo que $nome = $nome . " Mundo";
echo $nome; // Saída: Olá Mundo
?>
```

## 08 - Operadores de incremento/decremento

Os operadores de incremento e decremento no PHP são atalhos para adicionar ou subtrair o valor **1** de uma variável numérica.

Eles são muito usados em laços de repetição (`for`, `while`) ou para simplesmente contar.

O mais importante é entender que eles possuem duas variações: **pré-incremento/decremento** e **pós-incremento/decremento**.

-----

### Incremento (adicionar 1)

  * **Pós-incremento (`$x++`)**: O valor da variável é **primeiro usado** na expressão, e **depois incrementado**.

    ```php
    <?php
    $a = 5;
    $b = $a++; // $b recebe o valor atual de $a (5), e só depois $a é incrementado.

    echo "Valor de \$a: " . $a; // Saída: 6
    echo "Valor de \$b: " . $b; // Saída: 5
    ?>
    ```

  * **Pré-incremento (`++$x`)**: O valor da variável é **primeiro incrementado**, e **depois usado** na expressão.

    ```php
    <?php
    $a = 5;
    $b = ++$a; // $a é incrementado para 6, e depois $b recebe esse novo valor.

    echo "Valor de \$a: " . $a; // Saída: 6
    echo "Valor de \$b: " . $b; // Saída: 6
    ?>
    ```

-----

### Decremento (subtrair 1)

  * **Pós-decremento (`$x--`)**: O valor da variável é **primeiro usado** na expressão, e **depois decrementado**.

    ```php
    <?php
    $a = 5;
    $b = $a--; // $b recebe o valor atual de $a (5), e depois $a é decrementado.

    echo "Valor de \$a: " . $a; // Saída: 4
    echo "Valor de \$b: " . $b; // Saída: 5
    ?>
    ```

  * **Pré-decremento (`--$x`)**: O valor da variável é **primeiro decrementado**, e **depois usado** na expressão.

    ```php
    <?php
    $a = 5;
    $b = --$a; // $a é decrementado para 4, e depois $b recebe esse novo valor.

    echo "Valor de \$a: " . $a; // Saída: 4
    echo "Valor de \$b: " . $b; // Saída: 4
    ?>
    ```

-----

### Por que a diferença é importante?

A diferença entre a forma pré e pós é crucial quando você usa o operador dentro de uma expressão maior, como na atribuição (`$b = $a++`) ou dentro de um laço de repetição.

Na maioria das vezes, quando você simplesmente incrementa uma variável em uma linha separada (`$contador++`), a escolha entre pré e pós não faz diferença no resultado final.

```php
<?php
// Não faz diferença
$i = 10;
$i++;
// O mesmo que
$j = 10;
++$j;

echo "Valor de \$i: " . $i; // Saída: 11
echo "Valor de \$j: " . $j; // Saída: 11
?>
```

No entanto, é uma boa prática ser consciente de qual deles você está usando para evitar resultados inesperados.

## 09 - Operadores de comparação

Os operadores de comparação em PHP são usados para comparar dois valores e determinar se a relação entre eles é verdadeira ou falsa. O resultado de uma comparação é sempre um valor **booleano**: `true` (verdadeiro) ou `false` (falso).

Eles são a base para qualquer estrutura de controle, como o `if`, `else`, e `switch`.

Aqui estão os principais operadores de comparação:

### 1. Igual (`==`)

Verifica se dois valores são iguais, mas **não considera o tipo de dado**. O PHP tentará converter os tipos para fazer a comparação.

```php
<?php
$a = 5;      // int
$b = "5";    // string

var_dump($a == $b); // Saída: bool(true) - O PHP converteu "5" para o número 5 para a comparação.
?>
```

-----

### 2. Idêntico (`===`)

Verifica se dois valores são iguais **e se eles têm o mesmo tipo de dado**. Esta é a forma mais rigorosa e segura de comparação.

```php
<?php
$a = 5;
$b = "5";

var_dump($a === $b); // Saída: bool(false) - Os valores são iguais, mas os tipos (int e string) são diferentes.

$c = 5;
var_dump($a === $c); // Saída: bool(true) - Os valores e os tipos são idênticos.
?>
```

-----

### 3. Diferente (`!=` ou `<>`)

Verifica se dois valores **não** são iguais. Novamente, a comparação é feita sem considerar o tipo de dado.

```php
<?php
$a = 5;
$b = "10";

var_dump($a != $b); // Saída: bool(true) - 5 não é igual a 10.
var_dump($a <> $b); // O mesmo que o anterior, `true`.
?>
```

-----

### 4. Não Idêntico (`!==`)

Verifica se os valores **não são iguais OU se os tipos de dados são diferentes**.

```php
<?php
$a = 5;
$b = "5";

var_dump($a !== $b); // Saída: bool(true) - Os tipos são diferentes, então a condição é verdadeira.
?>
```

-----

### 5. Maior que (`>`)

Verifica se o valor da esquerda é maior que o da direita.

```php
<?php
$idade = 18;
var_dump($idade > 16); // Saída: bool(true)
?>
```

-----

### 6. Menor que (`<`)

Verifica se o valor da esquerda é menor que o da direita.

```php
<?php
$preco = 50;
var_dump($preco < 100); // Saída: bool(true)
?>
```

-----

### 7. Maior ou igual a (`>=`)

Verifica se o valor da esquerda é maior ou igual ao da direita.

```php
<?php
$pontuacao = 80;
var_dump($pontuacao >= 80); // Saída: bool(true)
```

-----

### 8. Menor ou igual a (`<=`)

Verifica se o valor da esquerda é menor ou igual ao da direita.

```php
<?php
$saldo = 200;
var_dump($saldo <= 200); // Saída: bool(true)
```

-----

### Operador Spaceship (`<=>`)

Introduzido no PHP 7, este operador é usado para comparações de três vias. Ele retorna um `int` (`-1`, `0`, ou `1`) dependendo do resultado da comparação.

  * Retorna **-1** se o operando da esquerda for **menor** que o da direita.
  * Retorna **0** se os operados forem **iguais**.
  * Retorna **1** se o operando da esquerda for **maior** que o da direita.

<!-- end list -->

```php
<?php
// Exemplo de uso
echo 1 <=> 1; // 0 (iguais)
echo 1 <=> 2; // -1 (1 é menor que 2)
echo 2 <=> 1; // 1 (2 é maior que 1)
?>
```

## 10 - Operadores lógicos

Os operadores lógicos no PHP são usados para combinar duas ou mais expressões condicionais e retornar um único valor booleano (`true` ou `false`). Eles são essenciais para criar condições complexas em estruturas de controle como o `if`, `while` e `for`.

Aqui estão os principais operadores lógicos:

### 1. E (`AND` ou `&&`)

O resultado é `true` se **ambas** as expressões forem verdadeiras. Se uma delas for falsa, o resultado é falso.

```php
<?php
$idade = 25;
$salario = 3000;

// O usuário tem mais de 21 E o salário é maior que 2000?
if ($idade > 21 && $salario > 2000) {
    echo "Acesso permitido.";
} else {
    echo "Acesso negado.";
}
// Saída: Acesso permitido.
?>
```

-----

### 2. OU (`OR` ou `||`)

O resultado é `true` se **pelo menos uma** das expressões for verdadeira. O resultado só é falso se ambas forem falsas.

```php
<?php
$tem_carteira = true;
$tem_onibus = false;

// O usuário pode dirigir OU pegar o ônibus?
if ($tem_carteira || $tem_onibus) {
    echo "Pode sair de casa.";
} else {
    echo "Fique em casa.";
}
// Saída: Pode sair de casa.
?>
```

-----

### 3. OU Exclusivo (`XOR`)

O resultado é `true` se **apenas uma** das expressões for verdadeira. Se ambas forem verdadeiras ou ambas forem falsas, o resultado é falso.

```php
<?php
$usa_carro = true;
$usa_bicicleta = true;

// O usuário usa carro OU bicicleta, mas não os dois ao mesmo tempo?
if ($usa_carro XOR $usa_bicicleta) {
    echo "Regra de locomoção válida.";
} else {
    echo "Regra de locomoção inválida.";
}
// Saída: Regra de locomoção inválida.
?>
```

-----

### 4. NÃO (`NOT` ou `!`)

Inverte o valor booleano de uma expressão. Se a expressão for `true`, o resultado é `false`, e vice-versa.

```php
<?php
$esta_logado = false;

// O usuário NÃO está logado?
if (!$esta_logado) {
    echo "Por favor, faça login para continuar.";
}
// Saída: Por favor, faça login para continuar.
?>
```

### Diferença entre `AND` e `&&` e `OR` e `||`

Embora `AND` e `&&` (`OR` e `||`) pareçam iguais, existe uma diferença sutil em sua **precedência de operador**.

  * `&&` e `||` têm uma precedência maior do que `AND` e `OR`.

Isso pode causar resultados inesperados quando combinados com outros operadores, especialmente o de atribuição (`=`). Em geral, é uma boa prática usar `&&` e `||` para evitar confusão, pois eles são mais previsíveis.

```php
<?php
// Exemplo com && (precedência alta)
$a = true && false; // $a recebe o resultado de (true && false), que é false.
var_dump($a); // Saída: bool(false)

// Exemplo com AND (precedência baixa)
$b = true AND false; // A atribuição (=) é feita antes do AND.
// É o mesmo que ($b = true) AND false;
// $b recebe true, e depois o AND false não afeta a variável.
var_dump($b); // Saída: bool(true)
?>
```

## 11 - Truthy e Falsy

No PHP, **valores truthy e falsy** são um conceito que define como certos valores de diferentes tipos se comportam em um contexto booleano, ou seja, quando são avaliados como `true` ou `false`.

Basicamente, quando o PHP precisa de um booleano (como em uma condição `if`), ele avalia o valor que você deu e decide se ele é "verdadeiro" (`true`) ou "falso" (`false`) para essa situação.

-----

### Valores Falsy

São todos os valores que, quando avaliados em um contexto booleano, são considerados `false`. São eles:

  * **`false`** (o próprio valor booleano)
  * **`0`** (o número inteiro zero)
  * **`0.0`** (o número float zero)
  * **`""`** (uma string vazia)
  * **`"0"`** (a string que contém apenas o caractere zero)
  * **`[]`** (um array vazio)
  * **`null`** (o valor nulo)
  * Variáveis declaradas mas sem valor atribuído (elas têm o valor `null`)

-----

### Valores Truthy

São todos os valores que **não** são falsy. Quando avaliados em um contexto booleano, são considerados `true`. Isso inclui:

  * **`true`** (o próprio valor booleano)
  * Qualquer número diferente de zero (positivo ou negativo)
      * Ex: `1`, `42`, `-5`
  * Qualquer string que não seja vazia ou `"0"`
      * Ex: `"Olá"`, `"false"`, `"0.0"`
  * Qualquer array que contenha pelo menos um elemento
  * Qualquer objeto
  * Qualquer `resource` (como um arquivo aberto ou uma conexão com banco de dados)

-----

### Exemplo Prático

A principal aplicação desse conceito é nas condições `if`, onde você pode simplificar o seu código.

Em vez de escrever uma condição explícita, como:

```php
<?php
$username = "joao";

if ($username != "") {
    echo "Bem-vindo, " . $username . "!";
}
?>
```

Você pode simplesmente usar a variável diretamente no `if`, porque o PHP a avaliará como `true` ou `false`:

```php
<?php
$username = "joao";

// O PHP vai avaliar se a string "$username" é truthy.
// Como não é vazia, a condição é verdadeira.
if ($username) {
    echo "Bem-vindo, " . $username . "!";
}
?>
```

Outro exemplo comum é verificar se um array não está vazio:

```php
<?php
$carrinho = ["produto1", "produto2"];

if ($carrinho) {
    echo "Seu carrinho tem itens.";
}
?>
```

Este conceito é fundamental para escrever código mais limpo e conciso em PHP. No entanto, é importante estar ciente dos valores que podem ser falsy (como a string `"0"`) para evitar comportamentos inesperados. Se você precisa de uma comparação rigorosa, use sempre o operador de identidade `===`.

## 12 - Condicionais If e Else

O `if` e `else` são estruturas de controle fundamentais no PHP (e na maioria das linguagens de programação). Eles permitem que o seu código tome decisões, executando blocos de código diferentes com base em uma condição.

### O que é e para que serve?

O `if` (que significa "se" em inglês) é usado para testar uma condição. Se essa condição for `true` (verdadeira), o bloco de código dentro do `if` será executado.

O `else` (que significa "senão") é opcional e serve como uma alternativa. Se a condição do `if` for `false` (falsa), o bloco de código do `else` será executado.

Pense nisso como um simples fluxo de decisão:

  * **SE** a condição for verdadeira, faça isso.
  * **SENÃO**, faça aquilo.

-----

### Como usar `if`

A sintaxe básica é:

```php
if (condição) {
  // Código a ser executado se a condição for verdadeira
}
```

**Exemplo:**

```php
<?php
$idade = 20;

if ($idade >= 18) {
    echo "Você é maior de idade.";
}
?>
```

Neste exemplo, a condição `$idade >= 18` é avaliada como `true`, então a mensagem "Você é maior de idade." é exibida.

-----

### Como usar `if...else`

A sintaxe com `else` é:

```php
if (condição) {
  // Código a ser executado se a condição for verdadeira
} else {
  // Código a ser executado se a condição for falsa
}
```

**Exemplo:**

```php
<?php
$saldo = 150;

if ($saldo >= 200) {
    echo "Você pode fazer a compra.";
} else {
    echo "Saldo insuficiente.";
}
// Saída: Saldo insuficiente.
?>
```

Neste caso, a condição `$saldo >= 200` é `false`, então o código dentro do bloco `else` é executado.

-----

### Múltiplas Condições com `elseif`

E se você precisar verificar mais de duas condições? É aí que entra o `elseif`. Ele permite adicionar quantas verificações intermediárias você precisar.

A sintaxe é:

```php
if (condição1) {
  // Código se a condição1 for verdadeira
} elseif (condição2) {
  // Código se a condição1 for falsa E a condição2 for verdadeira
} elseif (condição3) {
  // Código se a condição1 e 2 forem falsas E a condição3 for verdadeira
} else {
  // Código se nenhuma das condições for verdadeira
}
```

**Exemplo:**

```php
<?php
$nota = 7;

if ($nota >= 9) {
    echo "Excelente!";
} elseif ($nota >= 7) {
    echo "Muito bom.";
} elseif ($nota >= 5) {
    echo "Satisfatório.";
} else {
    echo "Reprovado.";
}
// Saída: Muito bom.
?>
```

Neste exemplo, o PHP verifica a primeira condição (`$nota >= 9`). Como é falsa, ele passa para a próxima (`$nota >= 7`). Como esta é `true`, o código correspondente é executado e o restante da estrutura é ignorado.

O `if`, `else` e `elseif` são a espinha dorsal da lógica de um programa, permitindo que você crie fluxos de código dinâmicos e adaptáveis.

## 13 - Condicionais Switch

O `switch` é uma estrutura de controle que oferece uma alternativa ao uso de múltiplos `elseif` encadeados, tornando o código mais legível e, em alguns casos, mais eficiente.

Ele é ideal para situações em que você precisa comparar uma única variável com vários valores diferentes.

### Como funciona?

O `switch` avalia uma expressão uma única vez e, em seguida, compara o resultado com os valores de cada bloco `case`. Quando encontra uma correspondência, executa o código associado a esse `case`.

A sintaxe básica é:

```php
switch (expressão) {
    case valor1:
        // Código a ser executado se expressão == valor1
        break;
    case valor2:
        // Código a ser executado se expressão == valor2
        break;
    default:
        // Código a ser executado se nenhum dos cases corresponder
        break;
}
```

-----

### Exemplo Prático

Imagine que você quer exibir o nome de um dia da semana com base em um número de 1 a 7.

Usando `if...elseif`:

```php
<?php
$dia = 3;

if ($dia == 1) {
    echo "Domingo";
} elseif ($dia == 2) {
    echo "Segunda-feira";
} elseif ($dia == 3) {
    echo "Terça-feira";
} elseif ($dia == 4) {
    echo "Quarta-feira";
} else {
    echo "Outro dia";
}
// Saída: Terça-feira
?>
```

Usando `switch`:

```php
<?php
$dia = 3;

switch ($dia) {
    case 1:
        echo "Domingo";
        break;
    case 2:
        echo "Segunda-feira";
        break;
    case 3:
        echo "Terça-feira";
        break;
    case 4:
        echo "Quarta-feira";
        break;
    default:
        echo "Outro dia";
        break;
}
// Saída: Terça-feira
?>
```

Como você pode ver, o código com `switch` se torna mais limpo e organizado, especialmente quando há muitos casos a serem verificados.

-----

### Componentes Importantes

  * **`switch (expressão)`**: A expressão que será avaliada. O PHP a avalia uma vez.
  * **`case valor:`**: Um rótulo para um valor específico. O PHP compara a expressão com este valor.
  * **`break;`**: O `break` é crucial\! Ele interrompe a execução do `switch` e impede que o código "caia" para o próximo `case`. Se você esquecer o `break`, o PHP executará o código de todos os `case` subsequentes até encontrar um `break` ou o final da estrutura.
  * **`default:`**: É opcional e funciona como o `else` no `if`. O código dentro do `default` é executado se nenhum dos `case`s corresponder à expressão. É uma boa prática incluí-lo para tratar valores inesperados.

-----

### Diferença entre `switch` e `if`

| Característica | `if...elseif` | `switch` |
| :--- | :--- | :--- |
| **Comparação** | Avalia uma nova condição em cada `elseif`. | Avalia a expressão uma única vez e compara o resultado. |
| **Tipo de comparação**| Permite qualquer tipo de comparação (igualdade, maior que, etc.). | Geralmente compara apenas a igualdade estrita (`===`). |
| **Legibilidade** | Pode se tornar difícil de ler com muitos `elseif`. | É mais limpo e legível para múltiplos testes de igualdade. |

Em resumo, use o `switch` quando você precisar comparar uma variável com vários valores fixos de forma **igualitária**. Para comparações mais complexas ou com intervalos (`>`,`<`), o `if...elseif` ainda é a melhor escolha.

## 16 - Tipos de dados Numbers (integer e float)

Os tipos de dados para números são divididos em dois tipos primitivos: **`integer`** e **`float`**.

Essa separação é fundamental para como o PHP gerencia a memória e realiza operações matemáticas.

-----

### `Integer` (números inteiros)

O tipo `integer` armazena números inteiros, que são números sem casas decimais. Eles podem ser positivos ou negativos.

  * **Valores de Exemplo:** `10`, `-5`, `0`, `2048`
  * **Quando usar:** Para contagens, IDs, índices de array e qualquer valor que não tenha uma parte fracionária.

**Exemplo:**

```php
<?php
$idade = 30;
$ano = 2025;
$quantidade_produtos = 5;

var_dump($idade); // Saída: int(30)
?>
```

O PHP detecta automaticamente que a variável é um `integer` quando você atribui um número inteiro a ela.

-----

### `Float` (números de ponto flutuante)

O tipo `float` (também conhecido como `double` em outras linguagens) armazena números com casas decimais ou em notação exponencial.

  * **Valores de Exemplo:** `3.14`, `-9.99`, `1.2e3` (que é 1200)
  * **Quando usar:** Para valores monetários, medições, cálculos científicos e qualquer valor que tenha uma parte fracionária.

**Exemplo:**

```php
<?php
$preco = 19.99;
$altura = 1.75;
$pi = 3.14159;

var_dump($preco); // Saída: float(19.99)
?>
```

### O que acontece em operações mistas?

O PHP é uma linguagem com tipagem dinâmica, o que significa que ele tenta converter os tipos automaticamente para realizar operações. Se você misturar `integer` e `float` em um cálculo, o resultado será sempre um `float`.

**Exemplo:**

```php
<?php
$int_var = 10;
$float_var = 5.5;

$resultado = $int_var + $float_var;

var_dump($resultado); // Saída: float(15.5)
?>
```

Essa conversão automática é chamada de **coerção de tipo** e é um comportamento comum no PHP.

Em resumo, quando você lida com números em PHP, você estará usando um desses dois tipos de dados: `integer` para números inteiros e `float` para números com casas decimais.

## 17 - Tipos de dados Array

O tipo de dado **`array`** é uma das estruturas mais poderosas e versáteis do PHP. Ele é uma coleção ordenada de valores. O que torna os arrays do PHP especiais é que eles são, na verdade, um **mapa ordenado**, o que significa que eles podem ser usados de duas maneiras principais: como uma lista de valores indexada por números inteiros, ou como um dicionário (mapa associativo) com chaves de `string` e valores.

-----

### O que é e para que serve?

Um `array` permite que você armazene vários valores em uma única variável. Isso é extremamente útil para agrupar dados relacionados. Em vez de criar variáveis separadas como `$nome1`, `$nome2`, `$nome3`, você pode criar um único array `$nomes` para armazenar todos eles.

-----

### Como criar um `array`

Você pode criar um array de duas maneiras:

#### 1\. Usando a sintaxe `array()`

Esta é a sintaxe mais antiga e ainda amplamente utilizada.

```php
<?php
$frutas = array("Maçã", "Banana", "Laranja");
```

#### 2\. Usando a sintaxe curta `[]`

Introduzida no PHP 5.4, esta é a sintaxe preferida atualmente, pois é mais concisa.

```php
<?php
$frutas = ["Maçã", "Banana", "Laranja"];
```

-----

### Tipos de Arrays

Como mencionei, os arrays podem ser usados de duas formas:

#### 1\. Arrays Indexados

São arrays onde cada item tem um índice numérico, começando em 0. O PHP atribui esses índices automaticamente.

```php
<?php
$frutas = ["Maçã", "Banana", "Laranja"];

echo $frutas[0]; // Saída: Maçã
echo $frutas[1]; // Saída: Banana
echo $frutas[2]; // Saída: Laranja
?>
```

Para adicionar um novo item, basta usar `[]` sem um índice:

```php
<?php
$frutas[] = "Morango";
// O array agora tem 4 itens: ["Maçã", "Banana", "Laranja", "Morango"]
?>
```

#### 2\. Arrays Associativos

São arrays onde cada item tem uma chave de `string` (ao invés de um índice numérico). Isso permite que você acesse os valores usando nomes significativos.

```php
<?php
$aluno = [
    "nome" => "João",
    "idade" => 25,
    "cidade" => "São Paulo"
];

echo $aluno["nome"];   // Saída: João
echo $aluno["cidade"]; // Saída: São Paulo
?>
```

Você pode adicionar ou modificar valores facilmente:

```php
<?php
$aluno["cidade"] = "Rio de Janeiro"; // Altera o valor da chave "cidade"
$aluno["curso"] = "Engenharia";       // Adiciona uma nova chave "curso"
?>
```

-----

### Arrays Multidimensionais

Um array pode conter outros arrays. Isso é útil para criar estruturas de dados mais complexas, como uma matriz ou uma lista de registros.

```php
<?php
$alunos = [
    ["nome" => "João", "idade" => 25],
    ["nome" => "Maria", "idade" => 22],
    ["nome" => "Pedro", "idade" => 28]
];

echo $alunos[0]["nome"]; // Acessa o nome do primeiro aluno (João)
echo $alunos[1]["idade"]; // Acessa a idade da segunda aluna (22)
?>
```

### Funções Úteis

O PHP possui centenas de funções para manipular arrays. Algumas das mais comuns são:

  * **`count($array)`**: Retorna o número de elementos em um array.
  * **`in_array($valor, $array)`**: Verifica se um valor existe em um array.
  * **`array_keys($array)`**: Retorna todas as chaves de um array.
  * **`array_values($array)`**: Retorna todos os valores de um array.
  * **`array_push($array, $valor)`**: Adiciona um ou mais elementos no final do array.

Em resumo, o tipo `array` é uma das ferramentas mais importantes que você tem no PHP. Dominar o seu uso, tanto como uma lista indexada quanto como um mapa associativo, é fundamental para o desenvolvimento em PHP.

## 18 - Mudando tipos de dados

Em PHP, o processo de converter um valor de um tipo de dado para outro é chamado de **conversão de tipo** ou **type casting**. O PHP é uma linguagem flexível e, na maioria das vezes, faz isso automaticamente (coerção de tipo), mas você também pode forçar a conversão de forma explícita.

-----

### Coerção de Tipo (Automática)

Esta é a forma mais comum e acontece quando o PHP precisa que um valor tenha um tipo específico para uma operação e, então, o converte sozinho.

**Exemplo:**

```php
<?php
$a = "10"; // string
$b = 5;    // int

$soma = $a + $b;
// O PHP converte a string "10" para o inteiro 10 para poder somar.

echo $soma;       // Saída: 15
var_dump($soma);  // Saída: int(15)
?>
```

A coerção automática é conveniente, mas pode levar a resultados inesperados, especialmente com strings que não contêm números válidos.

-----

### Conversão Explícita (Manual)

Se você quer garantir que um valor tenha um tipo específico, pode forçar a conversão usando um "operador de casting". Para fazer isso, coloque o nome do tipo desejado entre parênteses na frente da variável.

Os principais operadores de casting são:

  * `(int)` ou `(integer)`
  * `(float)` ou `(double)` ou `(real)`
  * `(string)`
  * `(bool)` ou `(boolean)`
  * `(array)`
  * `(object)`
  * `(unset)` (converte para `NULL`)

#### Exemplos de Uso

**1. Para `Integer`:**

```php
<?php
$valor_string = "15.99";
$valor_int = (int) $valor_string; // O PHP descarta a parte decimal.

echo $valor_int;      // Saída: 15
var_dump($valor_int); // Saída: int(15)
?>
```

**2. Para `Float`:**

```php
<?php
$valor_string = "3.14159";
$valor_float = (float) $valor_string;

echo $valor_float;      // Saída: 3.14159
var_dump($valor_float); // Saída: float(3.14159)
?>
```

**3. Para `String`:**

```php
<?php
$valor_int = 123;
$valor_string = (string) $valor_int;

echo gettype($valor_string); // Saída: string
?>
```

**4. Para `Boolean`:**

Qualquer valor **falsy** (0, "", [], null) se tornará `false`, e qualquer valor **truthy** se tornará `true`.

```php
<?php
$valor1 = 0;
$valor2 = "Olá";

$bool1 = (bool) $valor1;
$bool2 = (bool) $valor2;

var_dump($bool1); // Saída: bool(false)
var_dump($bool2); // Saída: bool(true)
?>
```

**5. Para `Array`:**

```php
<?php
$valor_string = "Meu nome";
$array_convertido = (array) $valor_string;
// O PHP cria um array com o valor na chave 0.

print_r($array_convertido);
/*
Saída:
Array
(
    [0] => Meu nome
)
*/
?>
```

-----

### Quando usar conversão explícita?

Embora a conversão automática do PHP seja conveniente, a conversão explícita é uma boa prática quando:

1.  Você quer ter certeza do tipo de dado que está usando para evitar resultados inesperados.
2.  Você precisa de um tipo específico para uma função ou operação.
3.  Você quer melhorar a legibilidade do seu código, deixando claro qual tipo de dado é esperado.

## 19 - Looping For

O `for` é uma estrutura de loop em PHP (e em muitas outras linguagens) que é ideal para quando você sabe exatamente quantas vezes deseja repetir um bloco de código. Ele é mais conciso do que um `while` para tarefas de contagem.

### Como funciona?

O loop `for` é dividido em três partes principais, todas dentro dos parênteses e separadas por ponto e vírgula:

1.  **Inicialização:** Executada apenas **uma vez** no início do loop. É onde você geralmente declara e inicializa a variável de contagem.
2.  **Condição:** Avaliada no **início de cada iteração**. Se for `true`, o loop continua; se for `false`, o loop para.
3.  **Incremento/Decremento:** Executado no **final de cada iteração**, após o bloco de código. É onde você geralmente atualiza a variável de contagem.

A sintaxe é:

```php
for (inicialização; condição; incremento/decremento) {
  // Código a ser executado em cada iteração
}
```

-----

### Exemplo Prático

Vamos criar um loop para exibir os números de 1 a 5.

```php
<?php
// Exemplo de loop for para contar de 1 a 5
for ($i = 1; $i <= 5; $i++) {
    echo "O número é: " . $i . "<br>";
}
?>
```

**Análise do exemplo:**

  * **`$i = 1;`** (Inicialização): A variável `$i` é criada e recebe o valor `1`. Isso só acontece uma vez.
  * **`$i <= 5;`** (Condição): Em cada iteração, o PHP verifica se `$i` é menor ou igual a `5`.
      * **1ª iteração:** `$i` é 1. `1 <= 5` é `true`. O loop continua.
      * **2ª iteração:** `$i` é 2. `2 <= 5` é `true`. O loop continua.
      * ...
      * **5ª iteração:** `$i` é 5. `5 <= 5` é `true`. O loop continua.
      * **6ª iteração:** `$i` agora é 6. `6 <= 5` é `false`. O loop **para**.
  * **`$i++`** (Incremento): No final de cada iteração, o valor de `$i` é aumentado em 1.

O resultado do código acima será:

```
O número é: 1
O número é: 2
O número é: 3
O número é: 4
O número é: 5
```

-----

### Aplicações Comuns

O loop `for` é perfeito para tarefas como:

  * **Iterar sobre um array de forma numérica:**
    ```php
    $frutas = ["Maçã", "Banana", "Morango"];
    for ($i = 0; $i < count($frutas); $i++) {
        echo "A fruta na posição " . $i . " é " . $frutas[$i] . "<br>";
    }
    ```
  * **Repetir uma tarefa um número fixo de vezes:**
    ```php
    for ($i = 0; $i < 10; $i++) {
        echo "Gerando linha " . ($i + 1) . "<br>";
    }
    ```
  * **Fazer uma contagem regressiva:**
    ```php
    for ($i = 10; $i > 0; $i--) {
        echo $i . "...<br>";
    }
    echo "Lançar!";
    ```

Em resumo, use o loop `for` sempre que você tiver um número predefinido de iterações a serem realizadas. Se a condição para parar o loop for desconhecida, o `while` ou `do...while` podem ser opções mais adequadas.

## 20 - Looping While

O loop `while` é uma estrutura de controle que executa um bloco de código **enquanto** uma condição específica for verdadeira. Ao contrário do `for`, que é ideal para um número predefinido de iterações, o `while` é perfeito para situações em que você não sabe de antemão quantas vezes o loop precisa ser executado.

### Como funciona?

O loop `while` tem a seguinte sintaxe:

```php
while (condição) {
  // Código a ser executado
}
```

1.  O PHP avalia a **condição** antes de cada iteração.
2.  Se a condição for `true`, o código dentro do bloco é executado.
3.  Após a execução do bloco, o PHP retorna para o início e reavalia a condição.
4.  Esse processo se repete até que a condição se torne `false`. Quando isso acontece, o loop é interrompido, e o script continua a ser executado a partir da linha seguinte.

-----

### Exemplo Prático

Vamos usar um `while` para fazer uma contagem simples, similar ao exemplo do `for`.

```php
<?php
$contador = 1;

while ($contador <= 5) {
    echo "O número é: " . $contador . "<br>";
    $contador++; // Esta linha é crucial para evitar um loop infinito
}
?>
```

**Análise do exemplo:**

  * `$contador = 1;` (Inicialização): A variável é inicializada antes do loop.
  * `while ($contador <= 5)` (Condição): O loop continua enquanto `$contador` for menor ou igual a 5.
  * `$contador++;` (Incremento): A cada passagem, o valor de `$contador` aumenta em 1. **Essa linha é fundamental.** Sem ela, `$contador` nunca mudaria, e a condição seria sempre verdadeira, resultando em um **loop infinito**.

O resultado será o mesmo do exemplo do `for`:

```
O número é: 1
O número é: 2
O número é: 3
O número é: 4
O número é: 5
```

### O Perigo do Loop Infinito

É muito fácil criar um loop infinito com `while` se você esquecer de incluir a lógica para que a condição se torne falsa em algum momento. Por exemplo:

```php
<?php
// Exemplo de loop infinito!
$i = 1;
while ($i < 10) {
    echo "Isso vai continuar para sempre...";
    // Falta a linha que altera o valor de $i, como $i++;
}
?>
```

-----

### `do...while`

Existe uma variação do `while` chamada `do...while`. A diferença principal é que o `do...while` **executa o bloco de código pelo menos uma vez**, antes de avaliar a condição.

Sintaxe:

```php
do {
  // Código a ser executado
} while (condição);
```

**Exemplo:**

```php
<?php
$i = 10;

// O bloco de código será executado uma vez, mesmo que a condição seja falsa desde o início.
do {
    echo "Executando o do...while. O número é: " . $i . "<br>";
    $i++;
} while ($i < 5);
// Saída: Executando o do...while. O número é: 10
?>
```

Em resumo, use o **`while`** quando você precisar repetir uma ação até que uma condição seja satisfeita, sem saber quantas vezes isso acontecerá. Use o **`do...while`** quando você precisar que o código seja executado pelo menos uma vez, independentemente da condição.

## 22 - Looping ForEach

O `foreach` é uma estrutura de loop do PHP, projetada especificamente para iterar sobre os elementos de um **`array`** ou um **`object`**. Ele oferece uma maneira mais simples, limpa e segura de percorrer coleções de dados do que o loop `for` tradicional.

A principal vantagem do `foreach` é que você não precisa se preocupar com os índices numéricos ou com o tamanho do array; ele automaticamente lida com isso para você.

### Como funciona?

O `foreach` tem duas sintaxes principais:

1.  **Iterando sobre os valores:** Esta é a forma mais simples e comum, onde você acessa diretamente o valor de cada elemento.

    ```php
    foreach (array as $valor) {
      // Código a ser executado para cada valor
    }
    ```

2.  **Iterando sobre as chaves e os valores:** Esta é útil quando você precisa do índice ou da chave associativa de cada elemento.

    ```php
    foreach (array as $chave => $valor) {
      // Código a ser executado para cada par chave/valor
    }
    ```

-----

### Exemplo Prático: Arrays Indexados

Vamos usar um array de frutas.

```php
<?php
$frutas = ["Maçã", "Banana", "Morango"];

echo "Lista de frutas:<br>";

// Iterando apenas sobre os valores
foreach ($frutas as $fruta) {
    echo "- " . $fruta . "<br>";
}

echo "<hr>";

// Iterando sobre as chaves e os valores
foreach ($frutas as $indice => $fruta) {
    echo "A fruta no índice " . $indice . " é " . $fruta . "<br>";
}
?>
```

**Saída:**

```
Lista de frutas:
- Maçã
- Banana
- Morango
-------------------
A fruta no índice 0 é Maçã
A fruta no índice 1 é Banana
A fruta no índice 2 é Morango
```

-----

### Exemplo Prático: Arrays Associativos

O `foreach` se destaca ao trabalhar com arrays associativos.

```php
<?php
$aluno = [
    "nome" => "João",
    "idade" => 25,
    "cidade" => "São Paulo"
];

echo "Dados do aluno:<br>";

// Iterando sobre as chaves e os valores
foreach ($aluno as $chave => $valor) {
    echo ucfirst($chave) . ": " . $valor . "<br>";
}
?>
```

**Saída:**

```
Dados do aluno:
Nome: João
Idade: 25
Cidade: São Paulo
```

### Vantagens do `foreach`

  * **Legibilidade:** O código fica mais claro e direto, pois você está dizendo "para cada item no array, faça isso".
  * **Segurança:** Você não precisa se preocupar em errar a contagem do loop ou em acessar um índice que não existe, o que poderia gerar um erro. O `foreach` só percorre os elementos que existem.
  * **Simplicidade:** Não é necessário inicializar, definir a condição ou incrementar um contador.

Em resumo, o `foreach` é a forma **preferida e recomendada** de iterar sobre arrays e objetos em PHP. Ele simplifica o código e o torna mais robusto e fácil de ler.

## 23 - Looping Continue e Break

Em PHP, **`continue`** e **`break`** são palavras-chave usadas para controlar o fluxo de execução de loops (`for`, `foreach`, `while`, `do...while`). Eles permitem que você altere o comportamento padrão de um loop, que é executar todas as suas iterações de forma sequencial.

-----

### `continue`

O `continue` é usado para **pular uma iteração do loop atual e seguir para a próxima**. Quando o PHP encontra a palavra-chave `continue`, ele para de executar o restante do código dentro do loop para aquela iteração e imediatamente passa para a próxima.

Pense no `continue` como uma forma de "pular esta vez".

**Exemplo:**

Imagine que você quer exibir os números de 1 a 10, mas quer pular o número 5.

```php
<?php
for ($i = 1; $i <= 10; $i++) {
    // Se o número for 5, pule esta iteração
    if ($i == 5) {
        continue;
    }
    echo "O número é: " . $i . "<br>";
}

// Saída:
// O número é: 1
// O número é: 2
// O número é: 3
// O número é: 4
// O número é: 6
// O número é: 7
// O número é: 8
// O número é: 9
// O número é: 10
?>
```

-----

### `break`

O `break` é usado para **interromper completamente a execução do loop atual**. Quando o PHP encontra a palavra-chave `break`, ele sai imediatamente do loop e continua a executar o código que vem depois dele.

Pense no `break` como uma forma de "parar tudo e sair".

**Exemplo:**

Imagine que você está procurando um item em um array e quer parar de procurar assim que o encontrar.

```php
<?php
$alunos = ["Ana", "Pedro", "Maria", "João", "Clara"];
$procurar = "Maria";

foreach ($alunos as $aluno) {
    if ($aluno == $procurar) {
        echo "O aluno " . $procurar . " foi encontrado!";
        break; // Interrompe o loop, pois não é necessário continuar
    }
    echo "Procurando... " . $aluno . "<br>";
}
echo "<br>Busca finalizada.";

// Saída:
// Procurando... Ana
// Procurando... Pedro
// O aluno Maria foi encontrado!
// Busca finalizada.
?>
```

Neste exemplo, assim que "Maria" é encontrada, o `break` é executado, e o loop `foreach` é interrompido. O código não continua a procurar "João" e "Clara".

-----

### Resumo e Diferença

| Característica | `continue` | `break` |
| :--- | :--- | :--- |
| **Ação** | Pula a iteração atual | Sai do loop completamente |
| **Onde Continua** | Passa para a próxima iteração do loop | Passa para o código após o loop |
| **Uso Ideal** | Quando uma condição específica precisa ser ignorada sem parar a contagem | Quando o objetivo do loop foi alcançado e ele não é mais necessário |

Em resumo, use **`continue`** para pular etapas em um loop e **`break`** para sair de um loop completamente. Eles são ferramentas poderosas para otimizar e controlar o fluxo do seu código.

**Contudo, o `continue` não funciona em loops while e do...while, apenas o `break`**

## 24 - Funções

Uma **função** em PHP é um bloco de código que você pode nomear, salvar e reutilizar quantas vezes quiser.

Pense nela como uma pequena máquina: você fornece uma entrada (chamada de **argumento** ou **parâmetro**), ela processa essa entrada e, opcionalmente, produz uma saída (**retorno**).

-----

### O que é e para que serve?

O principal objetivo das funções é organizar o código, torná-lo mais limpo e evitar a duplicação. Se você tem uma tarefa que precisa ser realizada em vários lugares do seu script (por exemplo, calcular o valor de um imposto, formatar uma data ou enviar um e-mail), é muito mais eficiente criar uma função para essa tarefa em vez de reescrever o mesmo código repetidamente.

Usar funções traz as seguintes vantagens:

  * **Reutilização:** Você pode chamar a mesma função em qualquer parte do seu script.
  * **Manutenção:** Se precisar corrigir um bug ou alterar a lógica, você só precisa fazer isso em um único lugar.
  * **Legibilidade:** O código principal fica mais fácil de ler e entender.

-----

### Como criar uma função

A sintaxe básica para declarar uma função é:

```php
function nomeDaFuncao($parametro1, $parametro2, ...) {
    // Bloco de código da função
    // Faça algo aqui com os parâmetros
    return $valor; // Opcional: retorna um valor
}
```

  * `function`: A palavra-chave que inicia a declaração da função.
  * `nomeDaFuncao`: O nome que você dará à sua função. Use nomes que descrevam o que ela faz.
  * `($parametro1, ...)`: A lista de parâmetros que a função espera receber. Os parâmetros são opcionais.
  * `return`: A palavra-chave opcional que faz a função retornar um valor. Se não houver `return`, a função retorna `NULL` por padrão.

-----

### Exemplo Prático

Vamos criar uma função para somar dois números.

```php
<?php
// Declaração da função
function somar($num1, $num2) {
    $resultado = $num1 + $num2;
    return $resultado;
}

// Chamando a função para usá-la
$total = somar(5, 10);
echo "A soma é: " . $total . "<br>"; // Saída: A soma é: 15

// Você pode chamar a função várias vezes com valores diferentes
$total2 = somar(20, 8);
echo "A soma é: " . $total2; // Saída: A soma é: 28
?>
```

### Funções sem Retorno e sem Parâmetros

Você não é obrigado a usar parâmetros ou a retornar um valor. Uma função pode simplesmente executar uma ação, como exibir uma mensagem na tela.

```php
<?php
// Função sem parâmetros e sem retorno
function exibirBoasVindas() {
    echo "Bem-vindo ao meu site!";
}

exibirBoasVindas(); // Saída: Bem-vindo ao meu site!
?>
```

-----

### Escopo de Variáveis

Uma coisa importante sobre funções é o **escopo de variáveis**. Por padrão, as variáveis declaradas dentro de uma função são "locais", ou seja, só existem dentro daquela função. Variáveis declaradas fora da função são "globais" e não podem ser acessadas diretamente dentro da função.

```php
<?php
$nome = "Maria"; // Variável global

function dizerNome() {
    // echo $nome; // Isso causaria um erro, pois $nome não está no escopo local
    echo "Olá, mundo!";
}

dizerNome();
?>
```

Para passar dados para a função, use **parâmetros**. Para obter dados da função, use a instrução **`return`**. Essa é a forma mais segura e recomendada de trabalhar com funções.

## 25 - Closures

**Closure** (também conhecida como **função anônima** ou **lambda**) é uma função que não tem nome e pode ser armazenada em uma variável. A principal característica de uma closure é que ela pode "herdar" variáveis do escopo pai (fora da função) através da palavra-chave `use`, mesmo depois que esse escopo não existir mais.

-----

### O que é e para que serve?

A sintaxe de uma closure é muito parecida com a de uma função normal, mas sem o nome.

```php
<?php
$minhaFuncao = function($parametro) {
    // Código da função
};
?>
```

A principal utilidade de uma closure é criar funções de forma dinâmica, que podem ser passadas como argumentos para outras funções ou retornadas por elas. Isso é comum em funções de *callback* ou em métodos de array como `array_filter` e `array_map`.

### Como usar `use`

A magia das closures está na capacidade de usar variáveis de fora do seu escopo, o que não acontece com funções normais. Para fazer isso, você deve explicitamente importar a variável usando a palavra-chave `use`.

**Exemplo:**

Imagine que você quer filtrar um array de números para manter apenas os que são maiores que um determinado valor.

```php
<?php
$numeros = [1, 5, 8, 12, 15, 20];
$valorLimite = 10;

// A closure "usa" a variável $valorLimite do escopo pai
$numerosFiltrados = array_filter($numeros, function($numero) use ($valorLimite) {
    return $numero > $valorLimite;
});

print_r($numerosFiltrados);
/*
Saída:
Array
(
    [3] => 12
    [4] => 15
    [5] => 20
)
*/
?>
```

Neste exemplo, a função anônima passada para `array_filter` precisa acessar a variável `$valorLimite`. Sem a palavra-chave `use`, ela não saberia o que é essa variável e causaria um erro.

### `Closure` e `array_map`

Outro uso comum é com a função `array_map`, que aplica uma função a cada elemento de um array.

**Exemplo:**

```php
<?php
$produtos = [
    ["nome" => "Camiseta", "preco" => 50],
    ["nome" => "Calça", "preco" => 120],
    ["nome" => "Boné", "preco" => 30]
];

$desconto = 0.10; // 10% de desconto

// Mapeia o array de produtos para aplicar o desconto em cada preço
$produtosComDesconto = array_map(function($produto) use ($desconto) {
    $produto["preco"] = $produto["preco"] * (1 - $desconto);
    return $produto;
}, $produtos);

print_r($produtosComDesconto);
/*
Saída:
Array
(
    [0] => Array
        (
            [nome] => Camiseta
            [preco] => 45
        )
    ... (e assim por diante)
)
*/
?>
```

### Resumo

| Característica | Função Normal | Closure (Função Anônima) |
| :--- | :--- | :--- |
| **Nome** | Tem um nome definido (`function nome()`) | Não tem nome, é armazenada em uma variável |
| **Escopo** | Não acessa variáveis do escopo pai por padrão | Pode herdar variáveis do escopo pai com `use` |
| **Uso** | Usada para blocos de código reutilizáveis | Usada para callbacks e para criar funções dinâmicas |

Em resumo, as **closures** são poderosas para criar funções flexíveis e compactas que podem acessar e manipular dados de seu contexto exterior, tornando-as ideais para operações de array e programação funcional.

## 26 - Callback no PHP

Em PHP, um **callback** é uma função que é passada como argumento para outra função. A função que recebe o callback não executa a lógica do callback imediatamente; em vez disso, ela o armazena para chamá-lo em um momento posterior, geralmente quando uma determinada tarefa ou evento ocorre.

Pense nisso como um "telefonema de retorno": você entrega seu número de telefone (o callback) a alguém e diz "me ligue de volta quando X acontecer". A outra pessoa vai realizar a tarefa dela e, no momento certo, usará o seu número para te ligar (executar o callback).

-----

### Qual a utilidade?

A principal utilidade dos callbacks é tornar o código mais **flexível e dinâmico**. Eles permitem que você crie funções genéricas que podem se adaptar a diferentes necessidades, sem ter que reescrevê-las.

Por exemplo, imagine que você tem uma função para processar uma lista de números. O que você faz com cada número (somar, multiplicar, exibir, etc.) pode mudar. Em vez de criar uma função para cada operação, você cria uma função genérica `processar_numeros()` que aceita uma função de callback para realizar a operação desejada.

-----

### Como usar callbacks

Qualquer coisa que possa ser chamada com parênteses (`()`) pode ser usada como callback. Isso inclui:

  * Strings com o nome de uma função (ex: `"minhaFuncao"`)
  * Arrays com o nome de uma classe e um método (ex: `[$objeto, "metodo"]`)
  * **Closures (funções anônimas)** - Esta é a forma mais comum e poderosa, pois permite criar callbacks personalizados no local.

#### Exemplo com `array_filter` e Closure

A função `array_filter()` é um exemplo clássico de uma função que usa um callback. Ela percorre um array e retorna um novo array contendo apenas os elementos que satisfazem a condição definida pelo callback.

```php
<?php
$numeros = [1, 5, 8, 12, 15, 20];

// Queremos manter apenas os números pares
function isPar($numero) {
    return ($numero % 2 == 0);
}

// Usando o nome da função 'isPar' como callback
$numerosPares = array_filter($numeros, "isPar");
print_r($numerosPares);
/*
Saída:
Array
(
    [2] => 8
    [3] => 12
    [5] => 20
)
*/
```

A forma mais moderna e flexível é usar uma **closure** como callback:

```php
<?php
$numeros = [1, 5, 8, 12, 15, 20];

// Usando uma função anônima (closure) como callback
$numerosPares = array_filter($numeros, function($numero) {
    return ($numero % 2 == 0);
});

print_r($numerosPares);
// Saída: A mesma do exemplo anterior
?>
```

A grande vantagem de usar a closure é que você não precisa criar uma função separada; a lógica fica compacta e no mesmo local onde é usada.

#### Exemplo com `array_map`

Outra função comum que utiliza callbacks é `array_map()`, que aplica um callback a cada elemento de um array e retorna um novo array com os resultados.

```php
<?php
$nomes = ["ana", "pedro", "joao"];

// O callback converte a primeira letra para maiúscula
$nomesFormatados = array_map(function($nome) {
    return ucfirst($nome);
}, $nomes);

print_r($nomesFormatados);
/*
Saída:
Array
(
    [0] => Ana
    [1] => Pedro
    [2] => Joao
)
*/
?>
```

### Resumo

| Conceito | Explicação | Exemplo |
| :--- | :--- | :--- |
| **Callback** | Uma função passada como argumento para outra função. | `$array_filter($numeros, "isPar")` |
| **Utilidade** | Deixa o código mais flexível, genérico e reutilizável. | Processar dados de diferentes formas sem mudar a função principal. |
| **Melhor Prática** | Usar **closures** (funções anônimas) para callbacks simples. | `array_map(function() { ... })` |

## 27 - Verificando se uma variável existe

Para verificar se uma variável existe no PHP, você deve usar a função `isset()`.

-----

### O que é e como funciona `isset()`?

A função **`isset()`** verifica se uma variável foi declarada e se ela não tem o valor `NULL`. Ela retorna `true` se a variável existir e for diferente de `NULL`, e `false` caso contrário.

Essa é a forma mais comum e segura de verificar a existência de uma variável, pois ela não causa erros ou avisos se a variável não estiver definida.

**Sintaxe:** `isset($variavel)`

### Exemplos de Uso

**1. Verificando uma variável que existe e tem valor:**

```php
<?php
$nome = "João";

if (isset($nome)) {
    echo "A variável \$nome existe e tem o valor: " . $nome;
}
// Saída: A variável $nome existe e tem o valor: João
?>
```

**2. Verificando uma variável que não foi declarada:**

```php
<?php
// A variável $email não existe neste ponto

if (isset($email)) {
    echo "A variável \$email existe.";
} else {
    echo "A variável \$email não existe.";
}
// Saída: A variável $email não existe.
?>
```

**3. Verificando uma variável que tem o valor `NULL`:**

```php
<?php
$telefone = NULL;

if (isset($telefone)) {
    echo "A variável \$telefone existe.";
} else {
    echo "A variável \$telefone não existe.";
}
// Saída: A variável $telefone não existe.
?>
```

Perceba que, mesmo a variável estando declarada, o `isset()` a considera como "não existente" porque seu valor é `NULL`. Isso é muito útil para evitar erros em formulários ou dados que podem não ser preenchidos.

-----

### Verificando Múltiplas Variáveis

Você pode passar múltiplas variáveis para a função `isset()`. Ela retornará `true` apenas se **todas** as variáveis existirem e não forem `NULL`.

```php
<?php
$nome = "Maria";
$idade = 30;
$cidade = NULL;

if (isset($nome, $idade, $cidade)) {
    echo "Todas as variáveis existem.";
} else {
    echo "Pelo menos uma variável não existe ou é NULL.";
}
// Saída: Pelo menos uma variável não existe ou é NULL.
?>
```

### O que evitar: `empty()` e `is_null()`

É importante não confundir `isset()` com outras funções:

  * **`empty()`**: Verifica se uma variável está vazia. Uma variável é considerada vazia se ela não existir, for `NULL`, `false`, `0`, `"0"`, `""` ou um array vazio. Use `empty()` quando você quer saber se uma variável **tem um valor útil**.

    ```php
    $variavel = "";
    var_dump(isset($variavel)); // true (a variável existe)
    var_dump(empty($variavel)); // true (a variável está vazia)
    ```

  * **`is_null()`**: Verifica se o valor de uma variável é estritamente `NULL`. Ela causa um aviso se a variável não for declarada. Por isso, **`isset()` é mais seguro**.

    ```php
    // $minha_variavel não existe
    // is_null($minha_variavel); // Causa um aviso: Undefined variable
    ```

Em resumo, use **`isset()`** como sua principal ferramenta para verificar se uma variável existe antes de usá-la, evitando assim erros e garantindo que seu código seja mais robusto.

## 30 - Cookies

No contexto do PHP e desenvolvimento web, **cookies** são pequenos arquivos de texto que um servidor envia para o navegador do usuário. O navegador armazena esses arquivos e os devolve para o servidor em cada requisição subsequente.

-----

### O que são e para que servem?

A principal função dos cookies é **armazenar informações de estado no lado do cliente**. Como o protocolo HTTP é "sem estado" (stateless), o servidor não se lembra de quem você é entre uma requisição e outra. Os cookies resolvem esse problema, permitindo que o servidor identifique o usuário ou mantenha informações importantes, como:

  * **Sessão de login:** Mantenha o usuário logado entre as páginas.
  * **Preferências do usuário:** Lembre o idioma, o tema do site ou o tamanho da fonte preferidos.
  * **Conteúdo do carrinho de compras:** Guarde os itens que o usuário adicionou ao carrinho antes de fazer o checkout.
  * **Rastreamento de usuários:** Monitore o comportamento do usuário para fins de publicidade ou análise.

### Como criar e ler cookies em PHP

O PHP oferece funções simples para gerenciar cookies.

#### 1\. Criando um Cookie

Para criar um cookie, você usa a função `setcookie()`. Ela deve ser chamada **antes de qualquer saída HTML** para o navegador (antes de tags como `<html>` ou `<body>`).

```php
<?php
// O nome do cookie é "usuario"
// O valor é "joao"
// O cookie vai expirar em 3600 segundos (1 hora)
setcookie("usuario", "joao", time() + 3600); 
?>
```

A função `setcookie()` tem vários parâmetros, mas os mais importantes são:

  * `nome`: O nome do cookie (ex: `"usuario"`).
  * `valor`: O valor a ser armazenado (ex: `"joao"`).
  * `expiração`: O tempo de expiração em segundos. Usar `time()` + o número de segundos é a forma mais comum de definir o tempo de vida do cookie.

#### 2\. Lendo um Cookie

Para ler os dados de um cookie, você acessa a variável superglobal `$_COOKIE`. É uma boa prática verificar se o cookie existe com `isset()` antes de tentar acessá-lo para evitar erros.

```php
<?php
if (isset($_COOKIE["usuario"])) {
    $nome_usuario = $_COOKIE["usuario"];
    echo "Bem-vindo de volta, " . htmlspecialchars($nome_usuario) . "!";
} else {
    echo "Olá, visitante!";
}
?>
```

É fundamental usar `htmlspecialchars()` ao exibir dados de cookies para evitar ataques de *cross-site scripting* (XSS).

#### 3\. Apagando um Cookie

Para apagar um cookie, você chama a função `setcookie()` novamente, mas com um tempo de expiração no passado.

```php
<?php
// O cookie vai expirar imediatamente
setcookie("usuario", "", time() - 3600);
?>
```

### Segurança e Considerações

  * **Visibilidade:** Os cookies são armazenados no navegador do cliente, o que significa que eles **podem ser visualizados e alterados pelo usuário**. Por isso, **nunca armazene informações sensíveis** como senhas, números de cartão de crédito ou dados privados em cookies.
  * **Tamanho:** O tamanho de um cookie é limitado (geralmente cerca de 4KB). Se você precisar armazenar mais dados, considere usar sessões.
  * **Domínio e Caminho:** Os cookies são associados a um domínio e a um caminho específico, o que impede que um site acesse os cookies de outro.

Em resumo, os cookies são uma ferramenta essencial para manter o estado em aplicações web. Eles são fáceis de usar e perfeitos para armazenar pequenas quantidades de dados não sensíveis no lado do cliente.