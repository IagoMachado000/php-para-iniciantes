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

