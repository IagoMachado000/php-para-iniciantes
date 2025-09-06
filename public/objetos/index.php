<?php

/* 
1. Criando uma Classe e um Objeto: Crie uma classe chamada Pessoa com uma propriedade pública $nome e um método público apresentar(). O método deve exibir "Olá, meu nome é [nome]". Em seguida, crie um objeto a partir dessa classe, defina o nome e chame o método. 
*/
class Pessoa
{
    public string $nome;

    public function apresentar(): string
    {
        return "Olá, meu nome é {$this->nome}";
    }
}
$nova_pessoa = new Pessoa();
$nova_pessoa->nome = 'Fulano da Silva';
echo $nova_pessoa->apresentar() . PHP_EOL;

/* 
2. Método Construtor (__construct): Modifique a classe Pessoa para incluir um método construtor __construct(). O construtor deve receber o nome como um parâmetro e inicializar a propriedade $nome automaticamente quando o objeto for criado. 
*/

/* 
    Property Promotion -> __construct(public string $nome)
        Cria a propriedade $nome na classe
        Atribui o valor do parâmetro à propriedade
*/
class Pessoa2
{
    public function __construct(public string $nome) { }
}
$nova_pessoa2 = new Pessoa2('Ciclano da Silva');
echo $nova_pessoa2->nome . PHP_EOL;

/* 
3. Encapsulamento (Getters e Setters): Modifique a classe Pessoa para que a propriedade $nome seja private. Crie dois métodos públicos: getNome() para obter o valor e setNome() para alterar o valor. 
*/
class Pessoa3
{
    private string $nome;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        if (empty($nome)) {
            throw new Exception("Nome não pode ser vazio");
        }

        $this->nome = mb_strtoupper($nome);
    }
}
$nova_pessoa_3 = new Pessoa3();
$nova_pessoa_3->setNome('João Machado');
echo $nova_pessoa_3->getNome() . PHP_EOL;

/* 
4. Método com Parâmetro: Crie uma classe ContaBancaria com uma propriedade privada $saldo. Crie os métodos getSaldo() e depositar(). O método depositar() deve receber um parâmetro $valor e adicioná-lo ao saldo. 
*/
class ContaBancaria
{
    private float $saldo = 0;

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valor): void
    {
        if ($valor > 0) {
            $this->saldo += $valor;
        }
    }
}
$conta_1 = new ContaBancaria();

echo 'Seu saldo é de R$ ' . number_format($conta_1->getSaldo(), 2, ',' , '.') . PHP_EOL;

$conta_1->depositar(50);
echo 'Seu saldo é de R$ ' . number_format($conta_1->getSaldo(), 2, ',' , '.') . PHP_EOL;

$conta_1->depositar(100);
echo 'Seu saldo é de R$ ' . number_format($conta_1->getSaldo(), 2, ',' , '.') . PHP_EOL;

/* 
5. Herança (extends): Crie uma classe Animal com uma propriedade $nome e um método emitirSom(). Em seguida, crie uma classe Cachorro que herda de Animal e adiciona um método latir(). Crie um objeto Cachorro e chame os métodos de ambas as classes. 
*/

/* 
    A variável $nome deve ser protected (de preferência) ou public para que possa ser acessível na classe que herda
    
    Se a propriedade por private, ela é acessível apenas dentro da própria classe 

    O tipo no parâmetro do método (public function setNome(string $nome)) é um contrato público.

    Ele garante que qualquer pessoa que chame o método setNome() só possa passar uma string. Se alguém tentar passar um número ou um booleano, o PHP lançará um erro fatal imediatamente, antes mesmo de o código dentro do método ser executado.

    O tipo na propriedade (protected string $nome;) é uma garantia interna.

    Ele assegura que, em qualquer lugar da sua classe, a propriedade $nome sempre conterá uma string. Isso protege o estado do objeto contra atribuições de tipos incorretos, o que é especialmente útil em métodos maiores ou quando a propriedade pode ser alterada em vários lugares.

    Embora pareça uma repetição, o uso de ambos os tipos é uma prática de segurança.

    O tipo do parâmetro atua como um "porteiro" que valida a entrada. O tipo da propriedade garante a consistência do dado armazenado, mesmo que a propriedade seja alterada internamente por outros métodos ou lógica. Juntos, eles criam uma validação completa e robusta.
*/
class Animal
{
    protected string $nome;

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function emitirSom(): string
    {
        return 'Som genêrico';
    }
}

class Cachorro extends Animal
{
    public function latir(): string
    {
        return 'Au au';
    }
}

$cachorro = new Cachorro();
echo $cachorro->emitirSom() . PHP_EOL;
echo $cachorro->latir() . PHP_EOL;

/* 
6. Sobrescrita de Método (Method Override): Na classe Cachorro que você criou, sobrescreva o método emitirSom() da classe Animal. O novo método deve exibir uma mensagem específica para o cachorro, como "O cachorro latiu". 
*/
class Cachorro2 extends Animal
{
    public function emitirSom(): string
    {
        return 'O cachorro latiu';
    }
}
$cachorro2 = new Cachorro2();
echo $cachorro2->emitirSom() . PHP_EOL;

/* 
7. Membros Estáticos (static): Crie uma classe Matematica com uma propriedade static $PI = 3.14159. Crie um método static chamado circunferencia() que recebe um raio e usa a propriedade $PI para calcular a circunferência. Acesse a propriedade e chame o método sem instanciar a classe. 
*/

/* 
    O único detalhe é que a sua classe inclui um construtor (__construct()), mas ele não é necessário para esta solução. Membros estáticos pertencem à classe, não a um objeto individual. Portanto, a classe Matematica não precisa ser instanciada (usando new) para que seus membros estáticos sejam utilizados. 
*/
class Matematica
{
    private static float $pi = 3.14159;

    // public function __construct(private int|float $raio) 
    // { }

    public static function circunferencia($raio): float
    {
        return 2 * self::$pi * $raio;
    }
}
echo Matematica::circunferencia(10) . PHP_EOL;

/* 
8. Constantes de Classe: Crie uma classe Configuracao com uma constante chamada MAX_USUARIOS = 100. Crie um método exibirMaxUsuarios() que retorne o valor da constante. Tente alterar o valor da constante (o que deve resultar em um erro) e explique por que. 
*/

/* 
    Por definição, uma constante representa um valor fixo e inalterável que não pode ser alterado após sua definição.

    Constantes são definidas em tempo de compilação, dessa forma, o valor da constante é definido e fixado no momento em que o código compila, diferente de variáveis que são definidas em tempo de execução. Isso faz com que constantes sejam impossíveis de serem alteradas

    Constantes em uma classe pertencem a classe como um todo, e não a um objeto da classe, sendo assim um valor universal pra a classe e suas instâncias

    Constantes também geram uma garantia de estabilidade, pois quando vemos uma constante, sabemos que o valor dela não mudará, tornando o código mais previsível, fácil de ler e mais robustos a erros
*/

class Configuracao
{
    const MAX_USUARIOS = 100;

    public static function exibirMaxUsuarios(): int
    {
        return self::MAX_USUARIOS;
    }
}

echo 'O número máximo de usuário é ' . Configuracao::exibirMaxUsuarios() . PHP_EOL;

/* 
9. Classes Abstratas (abstract): Crie uma classe abstrata chamada FormaGeometrica com um método abstrato calcularArea(). Em seguida, crie uma classe Retangulo que herda de FormaGeometrica e implementa o método calcularArea(). 
*/
abstract class FormaGeometrica
{
    abstract public function calcularArea(): float;
}

class Retangulo extends FormaGeometrica
{
    public function __construct(
        private float $base,
        private float $altura,
    ) { }

    public function calcularArea(): float
    {
        return $this->base * $this->altura; 
    }
}
$retangulo = new Retangulo(10, 50);
echo 'A área é ' . $retangulo->calcularArea() . PHP_EOL; 

/* 
10. Interfaces (interface): Crie uma interface chamada Autenticavel com um método público autenticar(). Em seguida, crie uma classe Usuario que implementa a interface Autenticavel e fornece a lógica para o método autenticar(). 
*/
interface Autenticavel
{
    public function autenticar(): string;
}

class Usuario implements Autenticavel
{
    public function autenticar(): string
    {
        return 'Usuário autenticado';
    }
}
$usuario = new Usuario();
echo $usuario->autenticar() . PHP_EOL;

/* 
11. Herança com Visibilidade Protegida (protected): Crie uma classe Funcionario com uma propriedade protected chamada $salario. Em seguida, crie uma classe Gerente que herda de Funcionario e adicione um método público ajustarSalario() que tenha acesso à propriedade $salario do pai para alterá-la. 
*/

/* 
    A propriedade $salario da classe Funcionario só está visível pra ela mesma e para suas filhas porque o modificador de visibilidade é protected
*/
class Funcionario
{
    protected float $salario = 0;
}

/* 
    A classe Gerente herda a propriedade $salario da classe Funcionario

    O método ajustarSalaraio() altera o valor da propriedade $salario
*/
class Gerente extends Funcionario
{
    public function ajustarSalario(float $salario): float
    {
        return $this->salario = $salario;
    }
}
$gerente1 = new Gerente();
$gerente2 = new Gerente();
echo 'O salário do gerente 1 é ' . number_format($gerente1->ajustarSalario(2500), 2, ',', '.') . PHP_EOL;
echo 'O salário do gerente 2 é ' . number_format($gerente2->ajustarSalario(3500), 2, ',', '.') . PHP_EOL;

/* 
12. Polimorfismo: Crie uma classe Veiculo com um método mover(). Crie duas classes filhas, Carro e Bicicleta, que sobrescrevem o método mover() com uma implementação específica para cada uma. Em seguida, crie uma função separada chamada fazerMover() que aceite um parâmetro do tipo Veiculo e chame o método mover(). 
*/

/* 
    A classe sendo abstrata serve como uma superclasse (modelo) para aquelas que herdam. 
    
    A escolha de tornar essa classe abstrata foi tomada por conta do método mover, que é abstrato tornando obrigatório sua implementação nas classes herdeiras
    
    Quando uma classe tem pelo menos um método abstrato, ela também deve ser abstrata
*/
abstract class Veiculo
{
    abstract public function mover(): string;
}

class Carro extends Veiculo
{
    public function mover(): string
    {
        return 'O carro está andando';
    }
}

class Bicicleta extends Veiculo
{
    public function mover(): string
    {
        return 'A bicicleta está andando';
    }
}

function fazerMover(Veiculo $veiculo): string
{
    return $veiculo->mover();
}

$carro = new Carro();
$bicicleta = new Bicicleta();
echo fazerMover($carro) . PHP_EOL;
echo fazerMover($bicicleta) . PHP_EOL;

/* 
13. Método Mágico __toString(): Crie uma classe Produto com as propriedades $nome e $preco. Implemente o método mágico __toString() para que, ao tentar exibir o objeto como uma string, ele retorne uma mensagem formatada como "O produto [nome] custa R$ [preco]". 
*/

/* 
    O método __toString define como um objeto deve se comportar quando é usado em um contexto de string.

    Quando tentamos tratar um objeto como string, por exemplo, passando eo objeto pra um echo ou print, o PHP automaticamente procura e executa o método __toString dentro da classe daquele objeto para obter um valor que possa ser exibido.
    
    O principal uso do __toString() é fornecer uma representação legível do objeto

    Na classe Produto, se não tivéssemos o método __toString, quando usássemos o echo pra mostrar o objeto $notebook, teríamos um Fatal error, pois o objeto da classe não pode ser convertido pra string, mas com o método __toString, quando tratamos o objeto como string, esse método é chamado automaticamente e nos é mostrada a sua mensagem de retorno
*/
class Produto
{
    public function __construct(
        private string $nome,
        private float $preco,
    ) { }

    public function __toString(): string
    {
        return "O produto {$this->nome} custa R$ " . number_format($this->preco, 2, ',', '.');        
    }
}
$notebook = new Produto('Notebook Samsung Galaxy Book 4', 2999);
echo $notebook . PHP_EOL;

/* 
14. Membros Estáticos e de Instância: Crie uma classe ContadorDeObjetos. Adicione uma propriedade static privada $totalObjetosCriados inicializada com zero. No construtor da classe, incremente essa propriedade. Crie um método estático getTotalObjetos() que retorne o valor do contador. Crie vários objetos e chame o método estático. 
*/

/* 
    Uma propriedade estática pertence a classe e não a um objeto individual dessa classe

    O valor dela é compartilhado entre todos os objetos da classe

    Pode ser acessada e alterada sem precisar criar um objeto

    O principal propósito de uma propriedade estática é armazenar dados que são universais para a classe. Elas são usadas em cenários como:

        Contadores: Como no exemplo acima, para contar quantos objetos foram criados.

        Dados Compartilhados: Para armazenar configurações ou dados de cache que não mudam entre instâncias.

        Constantes Mutáveis: Quando um valor precisa ser fixo, mas não pode ser uma const (porque precisa ser definido em tempo de execução, por exemplo).

        Singletons: Em padrões de design que exigem que apenas uma única instância de uma classe seja criada.
*/
class ContadorDeObjetos
{
    private static int $totalObjetosCriados = 0;

    public function __construct()
    {
        self::$totalObjetosCriados ++;
    }

    public static function getTotalObjetos(): int
    {
        return self::$totalObjetosCriados;
    }
}

$obj1 = new ContadorDeObjetos();
$obj2 = new ContadorDeObjetos();
$obj3 = new ContadorDeObjetos();
echo ContadorDeObjetos::getTotalObjetos() . PHP_EOL;

/* 
15. Método Mágico __destruct(): Crie uma classe Conexao com um construtor que exiba "Conexão estabelecida." Crie um método destrutor __destruct() que exiba "Conexão encerrada.". Crie uma instância da classe e observe a ordem das mensagens. 
*/

/* 
    O método mágico __destruct() é o oposto do construtor (__construct()). Ele é executado automaticamente quando um objeto é destruído ou quando o script termina.

    Seu principal propósito é realizar operações de limpeza. Pense no construtor como o método que configura o objeto, e no destrutor como o método que o "desmonta".

    O __destruct() é ideal para liberar recursos que o objeto pode ter alocado durante sua vida útil. Casos de uso comuns incluem:

        Fechamento de Conexões: Se o objeto abriu uma conexão com um banco de dados ou um arquivo, o destrutor pode garantir que essa conexão seja fechada corretamente.

        Limpeza de Memória: Liberar recursos de memória ou variáveis temporárias grandes que não são mais necessárias.

        Finalização de Processos: Encerrar um processo externo ou garantir que um arquivo temporário seja excluído.
*/
class Conexao
{
    public function __construct()
    {
        echo 'Conexão estabelecida' . PHP_EOL;
    }

    public function __destruct()
    {
        echo 'Conexão encerrada' . PHP_EOL;
    }
}
$conn = new Conexao();

/* 
16. Palavra-chave final: Crie uma classe Pessoa com um método público apresentar(). Crie uma classe filha Programador que estende Pessoa. Dentro da classe Pessoa, torne o método apresentar() final. Explique por que o método apresentar() não pode ser sobrescrito na classe Programador (isso deve gerar um erro). 
*/

/* 
    Quando usamos a palavra-chave final em um método de uma classe, estamos dizendo que essa é a implementação definitiva do método e que nenhuma classe filha pode alterá-lo. Se uma classe herdeira tentar sobrescrevê-lo, o PHP gerará um erro fatal.
    
    O propósito de um final method não é arbitrário; é uma decisão de design que garante a integridade e a consistência do seu código. Os principais motivos são:

        Garantir a Lógica Crítica: Em alguns casos, a lógica de um método é tão crucial (como um cálculo complexo, uma validação de segurança ou um passo em um processo de transação) que não pode ser alterada. Torná-lo final assegura que ele sempre se comportará exatamente como foi projetado.

        Proteger a Consistência: Quando você está criando uma hierarquia de classes, um método final garante que uma regra de negócio ou um comportamento padrão será mantido em todas as classes filhas, evitando que um desenvolvedor altere essa lógica por engano ou desconhecimento.

        Estabilidade de API: Em bibliotecas e frameworks, o uso de final methods é uma forma de garantir que certas partes da sua API permaneçam estáveis. Outros desenvolvedores podem herdar suas classes, mas não podem mudar os métodos final, o que protege a integridade do seu código-base.
*/
class Pessoa4
{
    final public function apresentar()
    {

    }
}

class Programador extends Pessoa4
{
    // Error -> Method 'Programador::apresentar()' cannot override final method 'Pessoa4::apresentar()'
    // public function apresentar()
    // {

    // }
}

/* 
17. Traits: Crie uma trait chamada Mensagens com um método enviarMensagem(). Crie duas classes separadas, Usuario e Sistema, e faça com que ambas usem a trait Mensagens. Crie instâncias de ambas as classes e chame o método enviarMensagem() para demonstrar a reutilização de código. 
*/

/* 
    Um trait é um mecanismo de reuso de código que permite que você reutilize um conjunto de métodos e propriedades em diferentes classes, independentemente da hierarquia de herança.

    O principal propósito de uma trait é superar a limitação de herança única do PHP, onde uma classe só pode herdar de uma outra classe.

    Imagine que você tem uma classe Cachorro e uma classe Gato. Ambas precisam de um método para emitir um som. Você pode ter uma classe Animal e usar herança, mas e se você precisar de um método salvarLog() em ambas as classes, e também na classe Configuracao? A herança não funcionaria, pois Cachorro não "é um" Log.

    A trait resolve esse problema, permitindo que você "misture" (mixin) funcionalidades em classes que não têm uma relação de herança direta.

    Vantagens e Propósito
        Reutilização de Código: O objetivo principal. Reduz a duplicação de código.

        Flexibilidade: Uma classe pode usar múltiplas traits, resolvendo a limitação da herança única.

        Complementa a Herança: Traits não substituem a herança. A herança descreve uma relação de "é um" (Cachorro é um Animal), enquanto a trait descreve uma relação de "tem um" (Usuario tem a habilidade de logar).

        Composição sobre Herança: Incentiva uma abordagem de design onde você "compõe" objetos com comportamentos específicos, em vez de herdar toda a hierarquia.

    Traits x Interfaces
    
    Interfaces: O Contrato
        O objetivo de uma interface é firmar um contrato. Ela é puramente teórica e não contém nenhuma lógica. A interface diz: "Se uma classe me implementar, ela promete que terá estes métodos, com estas assinaturas".

        Propósito: Garantir que classes diferentes (que podem até não ter herança em comum) sigam um mesmo padrão de comportamento.

        Relacionamento: É uma relação de "pode ser". Por exemplo, uma classe Usuario pode ser Autenticavel, ou uma classe Carro pode ser Nadavel.

    Traits: A Ferramenta
        O objetivo de uma trait é fornecer um pacote de código pronto para usar. Ela permite que você injete a implementação de um ou mais métodos em uma classe, resolvendo o problema de ter que duplicar o mesmo código em vários lugares.

        Propósito: Compartilhar e reutilizar código, evitando a duplicação sem o uso da herança.

        Relacionamento: É uma relação de "tem um". Por exemplo, uma classe Usuario tem a habilidade de logar, ou uma classe Animal tem a habilidade de emitirSom.

    A interface é sobre um contrato de comportamento, enquanto a trait é sobre reutilização de código.
*/
trait Mensagens
{
    public function enviarMensagem()
    {
        return 'Mensagem enviada!';
    }
}

class Usuario2
{
    use Mensagens;
}

class Sistema
{
    use Mensagens;
}

$user = new Usuario2();
echo $user->enviarMensagem() . PHP_EOL;

$system = new Sistema();
echo $system->enviarMensagem() . PHP_EOL;

/* 
18. Acessando Membros Estáticos (self:: vs. static::): Crie uma classe Base com uma propriedade estática $nome = 'Base'. Crie um método público que retorne a propriedade estática. Crie uma classe filha Filha que estende Base e redefine a propriedade estática $nome = 'Filha'. Chame o método da classe Filha e explique a diferença entre usar self:: e static:: para acessar a propriedade $nome. 
*/

/* 
    Para redefinirmos uma propriedade estática herdada dentro de uma classe filha, basta declarar a propriedade estática novamente na classe filha. O PHP trata a propriedade estática da classe filha como uma entidade separada da propriedade estática da classe pai.
    
    Isso significa que você está criando uma nova "cópia" da propriedade estática para a classe herdeira, sem alterar a original na classe pai.

    self:: - A Referência Estática
        A palavra-chave self:: sempre se refere à classe na qual o código foi escrito. É uma referência estática, que não muda, independentemente da classe que a chama.

    static:: - A Referência Dinâmica (Late Static Bindings)
        A palavra-chave static:: (conhecida como "Late Static Bindings") se refere à classe que foi chamada em tempo de execução. É uma referência dinâmica, que se adapta à classe que está sendo usada.

    Ou seja, self sempre será resolvido referenciando a classe onde o código está escrito, enquanto o static será resolvido na classe em que é chamado em tempo de execução
*/
class Base
{
    protected static string $nome = 'Base';

    public static function propStatic1(): string
    {
        return self::$nome;
    }

    public static function propStatic2(): string
    {
        return static::$nome;
    }
}

class Filha extends Base
{
    protected static string $nome = 'Filha';
}

echo Base::propStatic1() . PHP_EOL;
echo Base::propStatic2() . PHP_EOL;

echo Filha::propStatic1() . PHP_EOL;
echo Filha::propStatic2() . PHP_EOL;

/* 
19 Implementando Múltiplas Interfaces: Crie duas interfaces: Voavel (com método voar()) e Nadavel (com método nadar()). Em seguida, crie uma classe Pato que implemente ambas as interfaces e forneça a lógica para os dois métodos. 
*/
interface Voavel
{
    public function voar(): string;
}

interface Nadavel
{
    public function nadar(): string;
}

class Pato implements Voavel, Nadavel
{
    public function voar(): string
    {
        return 'O pato está voando';
    }

    public function nadar(): string
    {
        return 'O pato está nadando';
        
    }
}
$pato = new Pato();
echo $pato->voar() . PHP_EOL;
echo $pato->nadar() . PHP_EOL;

/*
20. Desafio Final (Combinando Conceitos): Crie uma classe Calculadora que tenha uma propriedade static privada $historico (um array). Crie um método static público chamado somar() que recebe um array de números, retorna a soma, e adiciona o resultado ao $historico. Crie um método static público chamado getHistorico() que retorne o $historico. Chame o método somar() várias vezes com arrays diferentes e, em seguida, chame getHistorico(). 
*/

/* 
    Se um objeto não for criado a partir de uma classe, o $this não existe, ou seja, teremos apenas o self, caso seja um contexto estático
*/
class Calculadora
{
    private static array $historico = [];

    public static function somar(array $arr): void
    {
        $operacao = [];
        $total = 0;

        foreach ($arr as $value) {
            $total += $value;
        }

        $operacao['operandos'] = $arr;
        $operacao['total'] = $total;

        array_unshift(self::$historico, $operacao);
    }

    public static function getHistorico(): array
    {
        return self::formatarResultado(self::$historico);
    }

    private static function formatarResultado(array $arr): array
    {
        $resultados = [];

        foreach (self::$historico as $linha) {
            $operacao = implode(' + ', $linha['operandos']);
            $operacao .= " = {$linha['total']}";

            $resultados[] = $operacao;
        }

        return $resultados;
    }
}

Calculadora::somar([2, 3]);
Calculadora::somar([10, 20, 30]);
Calculadora::somar([100, 20, 500]);
var_dump(Calculadora::getHistorico());