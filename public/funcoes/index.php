<?php

/* 
1. Função Simples: Crie uma função chamada saudar() que não recebe parâmetros e apenas exibe a mensagem "Olá, mundo!". Chame a função para que a mensagem seja exibida. 
*/
function saudar()
{
    echo 'Olá, mundo!' . PHP_EOL;
}
saudar();
echo '==============================================================' . PHP_EOL;

/* 
2. Função com Parâmetro: Crie uma função chamada saudar_nome() que recebe um parâmetro $nome e exibe a mensagem "Olá, [nome]!". Chame a função passando seu nome como argumento. 
*/
function saudar_nome($nome)
{
    echo "Olá, {$nome}" . PHP_EOL;
}
saudar_nome('Iago');
echo '==============================================================' . PHP_EOL;

/* 
3. Múltiplos Parâmetros: Crie uma função chamada calcular_soma() que recebe dois parâmetros, $num1 e $num2. A função deve somar os dois números e exibir o resultado. 
*/
function calcular_soma($num1, $num2)
{
    $resultado = $num1 + $num2;
    echo "O resultado da soma entre {$num1} e {$num2} é {$resultado}" . PHP_EOL;
}
calcular_soma(10, 35);
echo '==============================================================' . PHP_EOL;

/* 
4. Função com Retorno: Crie uma função chamada dobrar_numero() que recebe um parâmetro $numero, calcula o dobro dele e retorna o resultado. Armazene o valor de retorno em uma variável e exiba-o. 
*/
function dobrar_numero($numero)
{
    return $numero * 2;
}
$numero_dobrado = dobrar_numero(4);
echo $numero_dobrado . PHP_EOL; 
echo '==============================================================' . PHP_EOL;

/* 
5. Parâmetro Opcional: Crie uma função chamada exibir_boas_vindas() que recebe um parâmetro $nome com um valor padrão de "Visitante". Chame a função duas vezes: uma sem passar um argumento e outra passando um nome. 
*/
function exibir_boas_vindas($nome = 'Visitante')
{
    return "Seja bem vindo {$nome}" . PHP_EOL;
}
echo exibir_boas_vindas();
echo exibir_boas_vindas('Iago');
echo '==============================================================' . PHP_EOL;

/* 
6. Declaração de Tipos (Type Hinting): Crie uma função chamada multiplicar_numeros() que aceita dois parâmetros, $num1 e $num2, ambos com declaração de tipo int. A função deve retornar um int. Chame a função passando dois números inteiros. 
*/
function multiplicar_numeros(int $num1, int $num2): int
{
    return $num1 * $num2;
}
echo multiplicar_numeros(25, 100) . PHP_EOL;
echo '==============================================================' . PHP_EOL;

/* 
7. Escopo de Variáveis: Crie uma variável global $global_nome = "João". Crie uma função que tente exibir essa variável. Explique por que a variável não é acessível e como você a acessaria usando a palavra-chave global ou passando-a como parâmetro. 
*/

/* 
    A palavra-chave global traz uma variável do escopo global para o escopo local da função. Na verdade, ela não copia o valor; ela cria um alias ou uma referência para a variável global. Isso significa que qualquer alteração feita na função afeta a variável original.

    A variável global é diretamente modificada pela função. Isso pode tornar o código difícil de rastrear e depurar, pois uma função pode ter um "efeito colateral" inesperado em uma variável global.
*/
$global_nome = "João";
function exibir_nome(): string
{
    global $global_nome;
    $global_nome .= ' da Silva';
    return "Meu nome é {$global_nome}" . PHP_EOL;
}
echo $global_nome . PHP_EOL;
echo exibir_nome();
echo $global_nome . PHP_EOL;

/* 
    Passar uma variável como parâmetro é a forma mais comum e segura de lidar com o escopo. Por padrão, o PHP passa as variáveis por valor, ou seja, ele cria uma cópia do valor da variável para uso exclusivo dentro da função.

    A variável original não é alterada. A função opera em uma cópia, e o código é mais previsível e isolado.
*/
$global_nome = "Maria";
function exibir_outro_nome($nome): string
{
    $global_nome = $nome;
    $global_nome .= ' da Silva';
    return "Meu nome é {$global_nome}" . PHP_EOL;
}
echo $global_nome . PHP_EOL;
echo exibir_outro_nome($global_nome);
echo $global_nome . PHP_EOL;
echo '==============================================================' . PHP_EOL;

/* 
8. Função e Array: Crie uma função chamada encontrar_maior_numero() que recebe um array de números como parâmetro. A função deve percorrer o array e retornar o maior número encontrado. 
*/
$numeros = [3, 7.5, 12, 4.2, 19, 8.8, 1, 15.3, 6, 11.7, 22, 2.9, 18, 9.4, 5, 13.6, 27, 10.1, 30, 16.8];
function encontrar_maior_numero(array $arr): int|float
{
    return max($arr);
}
echo 'O maior número é ' . encontrar_maior_numero($numeros) . PHP_EOL;
echo '==============================================================' . PHP_EOL;

/* 
9. Parâmetro por Referência: Crie uma função chamada adicionar_dez() que recebe um parâmetro $numero por referência (usando &). Dentro da função, adicione 10 ao valor do parâmetro. Crie uma variável e chame a função, observando como o valor original da variável é alterado. 
*/
$numero = 0;
function adicionar_dez(int &$numero): int
{
    return $numero += 10;
}
echo $numero . PHP_EOL;
echo adicionar_dez($numero) . PHP_EOL;
echo adicionar_dez($numero) . PHP_EOL;
echo $numero . PHP_EOL;
echo '==============================================================' . PHP_EOL;

/* 
10. Callback (Função como Parâmetro): Crie uma função chamada executar_operacao() que recebe um array de números e uma função de callback como parâmetros. O executar_operacao() deve aplicar o callback a cada número do array. Use-a para criar um novo array com cada número dobrado. 
*/

// Solução 1
$valores = [1, 2, 3, 4, 5, 6, 7.5, 8, 8.5, 9];
function dobro_numero(int|float $num): int|float
{
    return $num * 2;
}
function executar_operacao(array $arr, callable $fn): array
{
    $numeros_dobrados = [];
    foreach ($arr as $num) {
        array_push($numeros_dobrados, $fn($num));
    }
    return $numeros_dobrados;
}
var_dump(executar_operacao($valores, 'dobro_numero'));
echo '==============================================================' . PHP_EOL;

// Solução 2
$valores2 = [1, 2, 3, 4, 5, 6, 7.5, 8, 8.5, 9];
function executar_operacao_anonima(array $arr, callable $fn): array
{
    $numeros_processados = [];
    foreach ($arr as $num) {
        $numeros_processados[] = $fn($num);
    }
    return $numeros_processados;
}

// Passando uma função anônima
$numeros_dobrados = executar_operacao_anonima($valores2, function($num) {
    return $num * 2;
});
var_dump($numeros_dobrados);
echo '==============================================================' . PHP_EOL;

/* 
11. Percorrendo um Array Manualmente: Crie uma função chamada encontrar_menor_numero() que recebe um array de números. Use um loop foreach para percorrer o array e retornar o menor número encontrado. Não use a função min(). 
*/
$numeros2 = [42, 3.14, 87, 19.6, 5, 72.8, 101, 0.5, 66, 12.34, 9, 250.75, 33, 7.89, 118, 45.2, 3, 90.01, 14, 200.6];

// Solução 1 - For
function encontrar_menor_numero(array $arr): mixed
{
    // verificando se o array está vazio
    if (empty($arr)) {
        return null;
    }

    // inicializando a variável com o primeiro valor do array
    $menor = $arr[0];

    // itera sobre o restante do array (a partir do segundo elemento)
    for($i = 1; $i < count($arr); $i++) {

        if ($arr[$i] < $menor) {
            
            // se o elemento atual for menor que o menor valor atual, atualiza o menor valor 
            $menor = $arr[$i];
        }
    }

    return $menor;
} 
echo 'O menor número é ' . encontrar_menor_numero($numeros2) . PHP_EOL;

// Solução 2 - ForEach
function encontrar_menor_numero2(array $arr): mixed
{
    // verificando se o array está vazio
    if (empty($arr)) {
        return null;
    }

    // inicializando a variável com o primeiro valor do array
    $menor_valor = $arr[0];

    // itera sobre o restante do array
    foreach ($arr as $valor_atual) {
        if ($valor_atual < $menor_valor) {
            
            // se o elemento atual for menor que o menor valor atual, atualiza o menor valor 
            $menor_valor = $valor_atual;
        }
    }

    return $menor_valor;
} 
echo 'O menor número é ' . encontrar_menor_numero2($numeros2) . PHP_EOL;

/* 
12. Função Recursiva (Fatorial): Crie uma função recursiva (uma função que chama a si mesma) chamada calcular_fatorial(). Ela deve receber um número n e retornar o fatorial desse número. Lembre-se de definir uma condição de parada. 
*/

/* 
    A condição de parada da função é o parâmetro $n que vai diminuindo 1 até entrar na condição que ele seja menor ou igual a 1
*/
function calcular_fatorial(int $n): int
{
    // caso base: o fatorial de 0 e 1 é 1
    if ($n <= 1) {
        return 1;
    } else {
        // caso recursivo: n * (n - 1)!
        return $n * calcular_fatorial($n - 1);
    }
}
$fatorial = 5;
echo "O fatorial de {$fatorial} é " . calcular_fatorial($fatorial) . PHP_EOL;

/* 
13. Função com Variável Estática: Crie uma função chamada contador_de_chamadas(). Dentro dela, declare uma variável static chamada $contador inicializada com 0. A função deve incrementar o contador a cada chamada e exibir o valor atual. Chame a função várias vezes e observe o resultado. 
*/
function contador_de_chamadas(): int
{
    /* 
        Uma variável estática mantém seu valor entre as chamadas. Ao contrário das variáveis comuns, que são reiniciadas a cada chamada de função, uma variável estática é inicializada apenas na primeira execução da função e retém o valor atribuído em chamadas subsequentes. Isso é útil para funções que precisam de um "estado" interno, como contadores ou caches. 

        Essa é uma das maneiras mais eficientes de criar um "estado" interno para uma função sem precisar recorrer a variáveis globais. Ótimo trabalho!
    */
    static $contador = 0;
    $contador ++;
    return $contador;
}
echo contador_de_chamadas() . PHP_EOL;
echo contador_de_chamadas() . PHP_EOL;
echo contador_de_chamadas() . PHP_EOL;
echo contador_de_chamadas() . PHP_EOL;
echo contador_de_chamadas() . PHP_EOL;

/* 
14. Funções de Variável (Variable Functions): Crie duas funções simples: maiusculas() e minusculas(). Crie uma variável chamada $funcao e atribua a ela o nome de uma das funções. Em seguida, chame a função usando a variável ($funcao()) e exiba o resultado. 
*/

/* 
    Em PHP, "funções de variáveis" referem-se a chamadas de funções onde o nome da função é especificado por uma variável, utilizando a sintaxe $variavel()
    
    Se o nome de uma variável é seguido por parênteses (), o PHP assume que essa variável contém o nome de uma função e tenta executá-la.
*/
function maiusculas(string $str): string
{
    return mb_strtoupper($str);
}

function minusculas(string $str): string
{
    return mb_strtolower($str);
}

$funcao_maiusculas = 'maiusculas';
echo $funcao_maiusculas('Olá! Tudo bem com você?') . PHP_EOL;

$funcao_minusculas = 'minusculas';
echo $funcao_minusculas('Olá! Tudo bem com você?') . PHP_EOL;

/* 
15. Arrow Functions (PHP 7.4+): Crie um array de preços. Use a função array_filter() com uma arrow function (fn) para criar um novo array contendo apenas os preços que são maiores que R$ 50,00. 
*/

/* 
    Arrow functions (função de seta) é uma sintaxe curta para criar funções anônimas (closures) (PHP =^ 7.4)
    
    Sintaxe: fn (parâmetros) => expressão (o resultado da expressão é automaticamente retornado sem a necessidade de usar return)
    
    A maior vantagem é que elas capturam automaticamente as variáveis do escopo pai, sem que você precise usar a palavra-chave use.
*/
$precos = [9.99, 49.50, 120.75, 15.00, 299.90, 75.25, 5.49, 220.00, 18.30, 89.99, 450.10, 32.70, 12.00, 150.45, 8.80, 60.00, 310.25, 27.90, 999.99, 42.60];
$precos_maiores_que_50 = array_filter($precos, fn($preco) => $preco > 50);
var_dump($precos);
var_dump($precos_maiores_que_50);

/* 
16. Callback (O Desafio Final): Crie uma função chamada aplicar_operacao() que recebe um array de números e uma função de callback como parâmetros. A função deve retornar um novo array com o resultado da aplicação do callback a cada elemento. Use esta função para subtrair 5 de cada número em um array. 
*/
$nums = [42, 3.14, 87, 19.6, 5, 72.8, 101, 0.5, 66, 12.34, 9, 250.75, 33, 7.89, 118, 45.2, 3, 90.01, 14, 200.6];
$fator = 5;
function aplicar_operacao(array $arr, callable $fn): array
{
    $new_arr = [];
    foreach ($arr as $value) {
        $new_arr[] = $fn($value);
    }
    return $new_arr;
}
var_dump(aplicar_operacao($nums, fn($value) => $value - $fator));

/* 
17. Funções Variádicas (...): Crie uma função variádica chamada somar_varios(), que pode aceitar um número ilimitado de argumentos. Use o operador ... para coletar todos os argumentos em um array e, em seguida, some-os e retorne o total. 
*/

/* 
    As funções variádicas em PHP permitem que uma função aceite um número indefinido de argumentos
    
    Existem duas formas principais: a sintaxe moderna com o operador ... (reticências), introduzida no PHP 5.6, e as funções func_num_args(), func_get_arg() e func_get_args(), usadas em versões anteriores do PHP
    
    O operador ... coleta os argumentos restantes num array, enquanto as funções func_* permitem gerir os argumentos manualmente

    A declaração variádica (...) só pode ser um único parâmetro e deve ser o último na lista de parâmetros da função. 

    Um parâmetro variádico não pode ter um valor default. 
*/
function somar_varios(int|float ...$args): int|float
{
    return array_sum($args);
}
var_dump(somar_varios(1, 2, 3));
var_dump(somar_varios(10, 20.97, 30, 4.5, 50));

/* 
18. Combinando Funções: Crie uma função chamada calcular_imposto() que recebe um valor e retorna o valor com um imposto de 10%. Em seguida, crie outra função chamada aplicar_desconto() que recebe um valor e retorna o valor com um desconto de 5%. Crie uma terceira função que combine as duas, aplicando primeiro o desconto e depois o imposto sobre um valor inicial. 
*/
function calcular_imposto(int|float $valor): float
{
    return $valor * 1.1;
}

function aplicar_desconto(int|float $valor): float
{
    return $valor * 0.95;
}

function total(int|float $valor): float
{
    $resultado = aplicar_desconto($valor);
    $resultado = calcular_imposto($resultado);
    return $resultado;
}

echo total(100) . PHP_EOL;

/* 
19. Funções Aninhadas: Dentro de uma função chamada processar_dados(), crie outra função aninhada (dentro dela) chamada formatar_texto(). A função processar_dados() deve receber uma string, chamar a função formatar_texto() e exibir o resultado. 
*/
function processar_dados(string $str): string
{
    function formatar_texto(string $str): string
    {
        return $str;
    }

    return formatar_texto($str);
}
echo processar_dados('Olá, Mundo!') . PHP_EOL;

/* 
20. Função Pura vs. Impura: Crie uma função chamada adicionar_aleatorio() que adiciona um número aleatório a um valor de entrada. Chame-a duas vezes com o mesmo valor de entrada e explique por que os resultados são diferentes. Explique a diferença entre uma função pura (que sempre retorna o mesmo resultado para a mesma entrada) e uma função impura. 
*/

/* 
    Uma função pura sempre retorna o mesmo valor para os mesmos inputs e não causa efeitos colaterais (altera o estado do sistema fora do seu escopo) 
        Determinística: Dados os mesmos argumentos, o resultado é sempre o mesmo.

        Sem Efeitos Colaterais: Não altera dados externos ou estado de variáveis fora do seu escopo.

    Uma função impura pode variar o retorno mesmo com inputs iguais e/ou causa efeitos colaterais
        Não Determinística: O resultado pode variar mesmo com os mesmos inputs. 

        Com Efeitos Colaterais: Modifica o estado de variáveis externas, interage com o sistema de arquivos, banco de dados, ou a tela. 
*/
function adicionar_aleatorio($entrada)
{
    $valor_aleatorio = rand(0, 10);
    return $entrada + $valor_aleatorio;
}

echo adicionar_aleatorio(1) . PHP_EOL;
echo adicionar_aleatorio(1) . PHP_EOL;