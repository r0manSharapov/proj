<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContasSeeder extends Seeder
{
    public static $todasContas = [];

    private static $nomesBancos = [
        'Conta CGD',
        'CGD',
        'Caixagest',
        'Conta Secundária CGD',
        'CGD 2',
        'Conta BCP',
        'BCP-2',
        'BBVA',
        'BBVA-2',
        'BPI',
        'BPI 2',
        'Santander',
        'Santander 2',
        'BIC',
        'Best',
        'Crédito Agricola',
        'Montepio',
        'Novo Banco',
        'Popular',
        'Paypal',
        'Amazon Cash',
    ];

    private static $nomesOutros = [
        'Dinheiro',
        'Dinheiro em Casa',
        'Dinheiro em Caixa',
        'Caixa',
        'Poupança em Casa',
        'Trocos'
    ];

    public function run()
    {
        $this->command->line('--- > Criar Contas');
        DB::table('contas')->truncate();

        $faker = \Faker\Factory::create('pt_PT');
        $i = 1;
        $total = count(UsersSeeder::$users);
        $newid = 1;
        $contas = [];
        foreach (UsersSeeder::$users as $key => $user) {
            shuffle(ContasSeeder::$nomesBancos);
            shuffle(ContasSeeder::$nomesOutros);
            if ($i <= 6) {
                switch ($i) {
                    case 1:
                        $factor = 10;  // Factor máxim0
                        break;
                    case 2:
                        $factor = 2;
                        break;
                    case 3:
                        $factor = 1.2;
                        break;
                    case 4:
                        $factor = 1;   // Médio
                        break;
                    case 5:
                        $factor = 0.8;
                        break;
                    case 6:
                        $factor = 0.2; // Factor minimo
                        break;
                }
            } else {
                $a = rand(1, 100);
                if ($a <= 50) {    // Metade dos users têm factor entre 0.8 e 1.2
                    $factor = round(0.8 + rand(0, 40) / 100, 2);
                } else if ($a <= 80) {    // 30% dos users têm factor entre 0.2 e 0.8
                    $factor = round(0.2 + rand(0, 60) / 100, 2);
                } else if ($a <= 95) {    // 15% dos users têm factor entre 1.2 e 2.0
                    $factor = round(1.2 + rand(0, 80) / 100, 2);
                } else {                  // 5% dos users têm factor entre 2.0 e 10
                    $factor = round(2.0 + rand(0, 800) / 100, 2);
                }
            }
            // UTILIZADORES de 1 a 6 TÊM SEMPRE 5 CONTAS
            $nomesContas = [];
            $totalConta = $i <= 6 ? 3 : rand(1, 3);
            while ($totalConta > 0) {
                $nomesContas[] = ContasSeeder::$nomesBancos[$totalConta];
                $totalConta--;
            }
            $totalConta =  $i <= 6 ? 2 : rand(1, 2);
            while ($totalConta > 0) {
                $nomesContas[] = ContasSeeder::$nomesOutros[$totalConta];
                $totalConta--;
            }

            foreach ($nomesContas as $nome) {
                $arrayConta = $this->createContaArray($faker, $user, $nome, $factor);
                $arrayConta["id"] = $newid;
                $newid++;

                ContasSeeder::$todasContas[] = $arrayConta;
                // array_diff_key devolve o array $arrayConta sem as chaves "factor", "data_inicio"
                $contas[] = array_diff_key($arrayConta, array_flip(["factor", "data_inicio", "min", "max"]));
            }

            if ($newid % 100 == 0) {
                DB::table('contas')->insert($contas);
                $contas = [];
            }
            if ($i % 100 == 0) {
                $this->command->line('Criadas contas do User nº ' . $i . '/' . $total);
            }
            $i++;
        }

        if (count($contas) > 0) {
            DB::table('contas')->insert($contas);
        }
    }

    public function createContaArray($faker, $user, $nome, $factor)
    {
        $saldoInicial = rand(0, 100) <= 60 ? 0 : max(0, 100 * $factor + rand(-200, 2000));
        $saldoInicial = round($saldoInicial, 2);

        return [
            "user_id" => $user["id"],
            "nome" => $nome,
            "descricao" => rand(0, 10) == 5 ? $faker->realText() : null,
            "saldo_abertura" => $saldoInicial,
            "saldo_atual" => $saldoInicial,
            "data_ultimo_movimento" => null,
            "deleted_at" => null,
            "factor" => $factor,
            "min" => -100 * $factor,
            "max" => 5000 * $factor,
            "data_inicio" => Carbon::create($user["created_at"])->toDateString()
        ];
    }
}
