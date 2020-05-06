<?php

use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    // Nome, peso (nº de ocorrências), media (valor médio)
    private static $receitas = [
        [1,  'Salário',                 168,    800],
        [2,  'Trabalho Extra',          15,     300],
        [3,  'Bonus',                   5,      500],
        [4,  'Juros',                   10,     100],
        [5,  'Presente',                5,      200],
        [6,  'Dividendos',              2,      1000],
        [7,  'Venda 2ª mão',            20,     50],
        [8,  'Reembolso Seguros',       10,     100],
        [9,  'Reembolso Impostos',      10,     500],
        [10, 'Prémio Jogo',             1,      500],
        [11, 'Direitos Autor',          2,      200],
        [12, 'Reembolso Despesas',      10,     100],
    ];

    private static $despesas = [
        [13, 'Empréstimo Casa',             144,    350],
        [14, 'Empréstimo Automóvel',        72,     250],
        [15, 'Manutenção Casa',             2,      1000],
        [16, 'Electrodoméstico',            2,      500],
        [17, 'Comida',                      300,    60],
        [18, 'Mercearia',                   300,    60],
        [19, 'Restaurante',                 200,    40],
        [20, 'Roupa e Acessórios',          36,     150],
        [21, 'Combustivel',                 160,    60],
        [22, 'Manutenção Automóvel',        15,     200],
        [23, 'Seguro Automóvel',            10,     400],
        [24, 'Portagens',                   200,    10],
        [25, 'Multas',                      2,      100],
        [26, 'Gas',                         144,    40],
        [27, 'Electricidade',               144,    60],
        [28, 'Agua',                        144,    20],
        [29, 'Telecomunicações',            144,    60],
        [30, 'Seguro',                      10,     100],
        [31, 'Saúde',                       30,     100],
        [32, 'Donativos',                   2,      200],
        [33, 'Educação e Formação',         5,      300],
        [34, 'Computadores',                2,      1000],
        [35, 'Telemóveis',                  5,      300],
        [36, 'Aparelho Electrónico',        3,      200],
        [37, 'IMI',                         10,     150],
        [38, 'Presente',                    30,     50],
        [39, 'Espetáculo',                  20,     40],
        [40, 'Passeio',                     10,     200],
        [41, 'Férias',                      5,      1000],
        [42, 'Viagem Avião',                3,      300],
        [43, 'Desporto',                    60,     50]
    ];

    private static $pesosReceitasMin = 0;
    private static $pesosReceitasMax;
    private static $pesosDespesasMin;
    private static $pesosDespesasMax;

    public function run()
    {
        $this->command->line('--- > Criar Categorias');
        DB::table('categorias')->truncate();
        CategoriasSeeder::resetValues();
        // var_dump(CategoriasSeeder::$pesosReceitasMin);
        // var_dump(CategoriasSeeder::$pesosReceitasMax);
        // var_dump(CategoriasSeeder::$pesosDespesasMin);
        // var_dump(CategoriasSeeder::$pesosDespesasMax);
        // var_dump('RECEITAS');
        // var_dump(CategoriasSeeder::$receitas);
        // var_dump('DESPESAS');
        // var_dump(CategoriasSeeder::$despesas);
        // die();

        CategoriasSeeder::fillDB();

        // Para obter informação aleatória de categorias e valores de movimentos:
        // CategoriasSeeder::getMovimento($idCategoria, $tipo, $valor, $peso);
        // CategoriasSeeder::getReceita($idCategoria, $valor, $peso);
        // CategoriasSeeder::getDespesa($idCategoria, $valor, $peso);
    }

    public static function getReceita(&$idCategoria, &$valor, $factor = 1)
    {
        CategoriasSeeder::getMovimentoOfTipo('R', $idCategoria, $tipo, $valor, $factor);
    }

    public static function getDespesa(&$idCategoria, &$valor, $factor = 1)
    {
        CategoriasSeeder::getMovimentoOfTipo('D', $idCategoria, $tipo, $valor, $factor);
    }

    public static function getMovimento(&$idCategoria, &$tipo, &$valor, $factor = 1)
    {
        CategoriasSeeder::getMovimentoOfTipo('', $idCategoria, $tipo, $valor, $factor);
    }

    private static function getMovimentoOfTipo($tipoPredefinido, &$idCategoria, &$tipo, &$valor, $factor)
    {
        $semCategoria = rand(0, 7) < 3 ? true : false;
        $tipo = $tipoPredefinido ? $tipoPredefinido : (rand(1, 10) == 3 ? 'R' : 'D');
        if ($semCategoria) {
            $idCategoria = null;
            $valor = CategoriasSeeder::getValue(100, $factor);
            return;
        }
        if ($tipo == 'R') {
            $randomValue = rand(CategoriasSeeder::$pesosReceitasMin, CategoriasSeeder::$pesosReceitasMax);
            foreach (CategoriasSeeder::$receitas as $categoria) {
                if ($randomValue <= $categoria[4]) {
                    $idCategoria = $categoria[0];
                    $valor = CategoriasSeeder::getValue($categoria[3], $factor);
                    return;
                }
            }
        }
        if ($tipo == 'D') {
            $randomValue = rand(CategoriasSeeder::$pesosDespesasMin, CategoriasSeeder::$pesosDespesasMax);
            foreach (CategoriasSeeder::$despesas as $categoria) {
                if ($randomValue <= $categoria[4]) {
                    $idCategoria = $categoria[0];
                    $valor = CategoriasSeeder::getValue($categoria[3], $factor);
                    return;
                }
            }
        }
    }

    private static function getValue($valorBase, $factor = 1)
    {
        $a = [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 20, 20, 20, 20, 20, 20, 30, 40, 70, 95];
        $factorDelta = $a[array_rand($a)];
        $base = intval($valorBase * 100 * $factor); // $base está em centimos
        $delta = $base * $factorDelta / 100;        // $delta está em centimos
        $min = intval($base - $delta);
        $min = $min < 5 ? 5 : $min;
        $max = intval($base + $delta);
        return round(rand($min, $max) / 100, 2);  // Calculos em centimos, mas devolve em Euros
    }

    private static function resetValues()
    {
        $peso = 0;
        foreach (CategoriasSeeder::$receitas as $key => $categoria) {
            CategoriasSeeder::$receitas[$key][4] = $categoria[2] + $peso;
            $peso = CategoriasSeeder::$receitas[$key][4];
        }
        CategoriasSeeder::$pesosReceitasMax = $peso;
        CategoriasSeeder::$pesosDespesasMin = $peso;
        foreach (CategoriasSeeder::$despesas as $key => $categoria) {
            CategoriasSeeder::$despesas[$key][4] = $categoria[2] + $peso;
            $peso = CategoriasSeeder::$despesas[$key][4];
        }
        CategoriasSeeder::$pesosDespesasMax = $peso;
    }

    public static function fillDB()
    {
        foreach (CategoriasSeeder::$receitas as $categoria) {
            CategoriasSeeder::addOneCategory($categoria, true);
        }
        foreach (CategoriasSeeder::$despesas as $categoria) {
            CategoriasSeeder::addOneCategory($categoria, false);
        }
    }

    public static function addOneCategory($category, $receita)
    {
        DB::table('categorias')->insert(
            [
                'id' => $category[0],
                'nome' => $category[1],
                'tipo' => $receita ? 'R' : 'D'
            ]
        );
    }
}
