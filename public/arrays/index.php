<?php

/**
 * 1. Criação e Acesso Simples: Crie um array indexado com 5 nomes de frutas. Em seguida, exiba o terceiro elemento do array.
 */

$frutas = [
    'Maçã',
    'Uva',
    'Morango',
    'Mamão',
    'Banana'
];

// echo "A fruta na terceira posição do array frutas é: {$frutas[2]}" . PHP_EOL; // Morango

/**
 * 2. Adicionando Elementos: Crie um array vazio e adicione 3 nomes de cidades a ele, um de cada vez, usando a sintaxe `[]`. Por fim, exiba todos os elementos do array.
 */

$cidades = [];
$cidades[] = 'São Paulo';
$cidades[] = 'Rio de Janeiro';
$cidades[] = 'Minas Gerais';

// var_dump($cidades) . PHP_EOL; // array(3) { [0]=> string(10) "São Paulo" [1]=> string(14) "Rio de Janeiro" [2]=> string(12) "Minas Gerais"}

/**
 * 3. Array Associativo: Crie um array associativo para representar um perfil de usuário, com as chaves `"nome"`, `"idade"` e `"email"`. Preencha com seus dados e exiba o valor da chave `"idade"`.
 */

$usuario = [
    'nome' => 'John Doe',
    'idade' => 36,
    'email' => 'johndoe@email.com'
];

// echo "O usuário {$usuario['nome']} tem {$usuario['idade']} anos" . PHP_EOL; // O usuário John Doe tem 36 anos

/**
 * 4. Loop `foreach`: Crie um array de números inteiros. Use um loop `foreach` para percorrer o array e exibir cada número.
 */

$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
foreach($numeros as $numero) {
    // echo $numero . PHP_EOL; // 1 2 3 4 5 6 7 8 9 10
}

/**
 * 5. Contagem e Condição: Crie um array de preços de produtos. Use um loop `foreach` para somar apenas os preços que são maiores que R$ 50,00 e, no final, exiba o valor total.
 */

$precos = [15.99, 25, 67, 51.50, 59, 49.99, 100, 2.50];
$total = 0;
foreach($precos as $preco) {
    if ($preco > 50) {
        $total += $preco;
    }
}
// echo "A soma dos valores acima de 50,00 é de R$ {$total}" . PHP_EOL; // A soma dos valores acima de 50,00 é de R$ 277.5

/**
 * 6.  Verificando a Existência: Crie um array associativo de produtos e seus preços. Peça ao usuário (ou defina em uma variável) o nome de um produto. Use a função `array_key_exists()` para verificar se o produto existe no array e exiba uma mensagem apropriada.
 */

$produto = 'notebook';
$produtos = [
    'notebook' => 1500,
    'smartphone' => 1000,
    'monitor' => 500,
    'mouse' => 90,
];
if(array_key_exists(strtolower($produto), $produtos)) {
    // echo "O produto {$produto} custa R$ $produtos[$produto]" . PHP_EOL;
} else {
    // echo "O produto {$produto} não tem estoque" . PHP_EOL;
}

/**
 * 7.  Busca e `break`: Crie um array com nomes de alunos. Use um loop `foreach` para procurar um aluno específico (`"João"`, por exemplo). Quando encontrá-lo, exiba uma mensagem e use `break` para sair do loop imediatamente.
 * 
 * Aqui, a lógica não está totalmente correta, porque mostra a mensagem de aluno não encontrado em todas as iterações e que ele não for encontrado.
 * 
 * Para resolver isso (Solução 2), a lógica para mostrar se o aluno não foi encontrado deve ser movida pra fora do loop
 */

// Solução 1
$alunos = [
    'Pedro',
    'Maria',
    'José',
    'João',
    'Amaro'
];
foreach($alunos as $aluno) {
    if ($aluno === 'João') {
        // echo 'Aluno encontrado: ' . $aluno . PHP_EOL;
        break; 
    } else {
        // echo 'Aluno não encontrado' . PHP_EOL;
    }
}

// Solução 2 
$alunos = [
    'Pedro',
    'Maria',
    'José',
    'João',
    'Amaro'
];
$encontrado = false;
foreach($alunos as $aluno) {
    // echo 'Procurando aluno ...' . PHP_EOL;
    if ($aluno === 'João') {
        // echo 'Aluno encontrado: ' . $aluno . PHP_EOL;
        $encontrado = true;
        break; 
    }
}
if(!$encontrado) {
    // echo 'Aluno não encontrado' . PHP_EOL;
}

/**
 * 8. Arrays Multidimensionais: Crie um array multidimensional para armazenar 3 alunos. Cada aluno deve ter um array associativo com `"nome"`, `"nota1"` e `"nota2"`. Percorra este array usando um `foreach` aninhado e exiba a média de cada aluno.
 */

$alunos = [
    [
        'nome' => 'João',
        'nota1' => 9,
        'nota2' => 7.5,
    ],
    [
        'nome' => 'Maria',
        'nota1' => 8,
        'nota2' => 8,
    ],
    [
        'nome' => 'Pedro',
        'nota1' => 6,
        'nota2' => 7.5,
    ]
];
$media = 0;
foreach($alunos as $aluno) {
    $media = ($aluno['nota1'] + $aluno['nota2']) / 2;
    // echo 'Média do aluno ' . $aluno['nome'] . ' é ' . $media . PHP_EOL;
}

/**
 * 9.  Funções de Array (`count`, `array_push`, etc.): Crie um array de tarefas. Adicione uma nova tarefa usando `array_push()`. Em seguida, exiba o número total de tarefas usando `count()`.
 */

$tarefas = [];
array_push($tarefas, 'Comprar pão');
array_push($tarefas, 'Ir ao mercado');
array_push($tarefas, 'Revisar conteúdo para a prova');
// var_dump($tarefas);
// echo 'A lista de tarefas atualmente tem ' . count($tarefas) . ' tarefas a fazer.' . PHP_EOL;

/**
 * 10. Array e Validação: Crie um array de e-mails. Use um loop `foreach` com a função `filter_var()` e o filtro `FILTER_VALIDATE_EMAIL` para criar um novo array contendo apenas os e-mails válidos. Exiba o array final.
 */

$emails = [
    'usuario@email.com',
    'joao@gmail.com',
    'maria@',
    'pedro@HOTMAIL',
    '@yahoo.com.br'
];
$emails_validos = [];
foreach($emails as $email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emails_validos[] = $email;
    }
}
// var_dump($emails_validos);

/**
 * 11. Chaves e Valores Invertidos: Crie um array associativo de países e suas capitais. Use a função array_flip() para criar um novo array onde as chaves são as capitais e os valores são os países. Exiba o novo array.
 */
$paises_e_capitais = [
    'China' => 'Pequin',
    'Alemanha' => 'Berlin',
    'França' => 'Paris',
    'Reino Unido' => 'Londres',    
    'Japão' => 'Tóquio',    
];
var_dump($paises_e_capitais);
$capitais_e_paises = array_flip($paises_e_capitais);
var_dump($capitais_e_paises);

/**
 * 12. Filtragem com array_filter(): Crie um array de números inteiros. Use a função array_filter() com uma função anônima (closure) para remover todos os números ímpares e exibir o array resultante.
*/

/* 
    Objetivo -> Reduzir o número de elementos
    Tamanho do Array -> Pode ser diferente do original
    Retorno do Callback	-> true ou false
*/

$numeros_itenteiros = [1, 2, 3, 4, 5, 6, 7, 8, 9];
$numeros_pares = array_filter($numeros_itenteiros, function($numero) {  
    return $numero % 2 === 0;
});
var_dump($numeros_itenteiros);
var_dump($numeros_pares);

/**
 * 13. Mapeamento com array_map(): Crie um array de preços de produtos. Use a função array_map() com uma função anônima (closure) para aplicar um desconto de 15% em cada preço e exibir o novo array de preços com desconto.
 */

/* 
    Objetivo -> Transformar cada elemento
    Tamanho do Array -> É sempre o mesmo que o original
    Retorno do Callback	-> O novo valor para o elemento
*/
$precos = [10, 55.99, 60, 100, 112, ];
$preco_com_desconto = array_map(function($preco){
    return $preco * 0.85;
}, $precos);
var_dump($precos);
var_dump($preco_com_desconto);

/**
 * 14. Encontrar Duplicatas: Crie um array com nomes, onde alguns nomes se repetem. Crie um novo array contendo apenas os nomes que aparecem mais de uma vez na lista. Use as funções array_count_values() ou crie sua própria lógica com um loop.
 */
$nomes = [
    'Ana',
    'Maria',
    'João',
    'Ana',
    'Pedro',
    'Maria',
    'Ana',
    'Carlos'
];
$nomes_repetidos = [];
foreach (array_count_values($nomes) as $key => $qtd) {
    if ($qtd > 1) {
        array_push($nomes_repetidos, $key);
    }
}
var_dump($nomes);
var_dump(array_count_values($nomes));
var_dump($nomes_repetidos);

/**
 * 15. União de Arrays (array_merge()): Crie dois arrays de listas de compras. Um para a feira e outro para o supermercado. Use a função array_merge() para unir os dois em um único array e exiba a lista completa. Em seguida, adicione mais um item em um dos arrays originais e observe se o array final é alterado (e explique o porquê).
 */

/* 
    Quando usamos o array_merge pra mesclar arrays, o novo array resultante da mesclagem se torna uma variável isolada daquelas que deram a sua origem, ou seja, se os arrays de origem forem alterados após a mesclagem, a variável resultante dessa mesclagem não é alterada
*/
$feira = [
    'Maçã',
    'Banana',
    'Uva',
    'Morango',
];
$mercado = [
    'Arroz',
    'Feijão',
    'Macarrão',
];

$compras = array_merge($feira, $mercado);

var_dump($feira);
var_dump($mercado);
var_dump($compras);

$feira[] = 'Alface';
$feira[] = 'Tomate';

var_dump($feira);
var_dump($mercado);
var_dump($compras);

/**
 * 16. Soma de Array com array_sum(): Crie um array com valores de vendas diárias. Use a função array_sum() para calcular o total das vendas. Em seguida, adicione um valor de string (como "100") ao array e explique por que a função ainda funciona.
 */
/* 
    A função array_sum espera que o valores do array sejam do tipo int ou flout, mas se for uma string e puder ser convertida para int ou flout pela conversão interna (coerção de tipo) do php, a soma é feita com sucesso. Contudo, nos casos que a conversão não consegue converter para um número, o php trata ele como 0 na operação de soma
*/
$vendas_diarias = [
    150.50,
    210.00,
    95.75,
    300.20,
    180.00,
    45.00,
    125.60,
];
$total = array_sum($vendas_diarias);
echo 'O valor total das vendas é R$ ' . number_format($total, 2, ',', '.') . PHP_EOL;

$vendas_diarias[] = '100';
$vendas_diarias[] = 'abc';
$total = array_sum($vendas_diarias);
echo 'O valor total das vendas é R$ ' . number_format($total, 2, ',', '.') . PHP_EOL;
var_dump($vendas_diarias);

/**
 * 17. Subtração de Arrays (array_diff()): Crie um array de produtos disponíveis e outro array de produtos vendidos. Use a função array_diff() para encontrar a lista de produtos que ainda estão em estoque.
 */

/* 
    Na função array_diff a ordem dos parâmetros importa, porque o PHP compara o primeiro array com o segundo e retorna apenas os elementos que estão no primeiro e não no segundo.
*/
$produtos_disponiveis = [
    'Teclado Mecânico',
    'Mouse Gamer',
    'Monitor 24 polegadas',
    'Fone de Ouvido sem Fio',
    'Webcam Full HD',
    'HD Externo 1TB',
];
$produtos_vendidos = [
    'Monitor 24 polegadas',
    'Mouse Gamer',
    'Fone de Ouvido sem Fio',
];
$produtos_em_estoque = array_diff($produtos_disponiveis, $produtos_vendidos);
foreach($produtos_em_estoque as $produto) {
    echo "O produto {$produto} tem estoque" . PHP_EOL;
}

/**
 * 18. Reorganização com sort() e rsort(): Crie um array com uma lista de nomes em ordem aleatória. Use a função sort() para ordenar o array em ordem alfabética crescente e, em seguida, use rsort() para ordenar em ordem decrescente. Exiba os resultados em cada etapa.
 */
$nomes = [
    'Ana',
    'Carlos',
    'Beatriz',
    'Eduardo',
    'Fernanda',
    'Daniel',
    'Gabriela',
];
var_dump($nomes);
sort($nomes);
var_dump($nomes);
rsort($nomes);
var_dump($nomes);

/**
 * 19. Busca de Elementos com array_search(): Crie um array de cores. Use a função array_search() para encontrar a chave da cor "vermelho". Se a cor for encontrada, exiba a chave; caso contrário, exiba uma mensagem de "Cor não encontrada".
 */

/* 
    O array_search() retorna o índice do elemento se ele for encontrado e false se não for. Em PHP, o número 0 é considerado "falsy" (falso) em uma expressão booleana.

    Se a lista de cores começasse com 'vermelho', o array_search() retornaria a chave 0. E se a comparação fosse if ($cor) avaliaria 0 como false e exibiria a mensagem "Cor não encontrada", o que estaria incorreto.

    A forma correta e segura de verificar o retorno de array_search() é usando o operador de comparação estrita !== (diferente de e não é o mesmo tipo).
*/
$cores = [
    'vermelho',
    'azul',
    'verde',
    'amarelo',
    'roxo',
    'laranja',
];
$cor = array_search('vermelho', $cores);

// Cor não encontrada
if ($cor) {
    echo "A posição da cor {$cores[$cor]} é {$cor}" . PHP_EOL;
} else {
    echo 'Cor não encontrada' . PHP_EOL;
}

// A posição da cor vermelho é 0
if ($cor !== false) {
    echo "A posição da cor {$cores[$cor]} é {$cor}" . PHP_EOL;
} else {
    echo 'Cor não encontrada' . PHP_EOL;
}

/**
 * 20. Ordenação de Arrays Associativos: Crie um array de alunos com suas notas, onde a chave é o nome do aluno e o valor é a nota. Use a função asort() para ordenar o array pela nota (valor), mantendo a associação entre o nome e a nota. Exiba o array ordenado.
 */

/* 
    A função asort ordena o array pelos valores de forma crescente e mantém a associação entre as chaves e os valores (ou seja, o nome do aluno continua ligado à sua nota).
*/
$alunos = [
    'Ana' => 8.5,
    'Pedro' => 6.0,
    'Maria' => 9.2,
    'João' => 7.8,
    'Clara' => 9.5,
];
var_dump($alunos);
asort($alunos);
var_dump($alunos);