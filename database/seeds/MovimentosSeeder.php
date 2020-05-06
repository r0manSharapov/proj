<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovimentosSeeder extends Seeder
{
    private $date;
    // Média de movimentos por dia para um determinado mês
    private $mediaMovimentosContaDia = [2.1, 1.3, 1.5, 1.8, 1.2, 1.8, 2.1, 2.6, 2.2, 1.7, 1.1, 2.5];

    public function run()
    {
        $this->command->line('--- > Criar Movimentos');
        DB::table('movimentos')->truncate();

        $faker = \Faker\Factory::create('pt_PT');

        $this->date = Carbon::create(DatabaseSeeder::$ano_inicio, 1, 1);
        $hoje = Carbon::now();
        $i = 1;
        $idxContas = 0;
        $totalAbsolutoMovimentos = 0;
        while ($this->date < $hoje) {

            // $idxContas - index da ultima conta que existe na data de referência $this->date
            // $totalMovimentos = Total de movimentos a introduzir para o dia atual
            // tendo em conta a média de movimentos por conta -  $mediaMovimentosContaDia
            // do mês actual
            $mesActual = $this->date->month;
            $idxContas = $this->idxUltimaConta($idxContas, $this->date);
            $totalMovimentos = intval($this->mediaMovimentosContaDia[$mesActual - 1] * rand(2, 18) / 10 * $idxContas);
            $totalAbsolutoMovimentos += $totalMovimentos;
            $j = 0;
            $blockMovimentos = [];
            while ($totalMovimentos > 0) {
                $idxConta = rand(0, $idxContas);
                $contaAtual = ContasSeeder::$todasContas[$idxConta];
                $blockMovimentos[] = $this->createMovimentoArray($faker, $idxConta, $contaAtual, $this->date);
                if ($j % 100 == 0) {
                    DB::table('movimentos')->insert($blockMovimentos);
                    $blockMovimentos = [];
                }
                $j++;
                $totalMovimentos--;
            }
            if (count($blockMovimentos) > 0) {
                DB::table('movimentos')->insert($blockMovimentos);
                $blockMovimentos = [];
            }
            if ($i % 10 == 0) {
                $this->command->line('Criados ' . $totalAbsolutoMovimentos . ' movimentos até à data ' . $this->date->toDateString());
            }
            $i++;
            $this->date->addDay();
        }
        $this->command->line('Atualizar os saldos de todas as contas.');
        $this->updateAllContas();
    }

    private function updateAllContas()
    {
        $contasDB = [];
        $i = 0;
        foreach (ContasSeeder::$todasContas as $conta) {
            $contasDB = [
                "saldo_atual" => $conta["saldo_atual"],
                "data_ultimo_movimento" => $conta["data_ultimo_movimento"],
            ];
            DB::table('contas')->where('id', $conta["id"])->update($contasDB);
            if ($i % 100 == 0) {
                $this->command->line('Atualizada a conta nº ' . $i);
            }
            $i++;
        }
    }

    private function idxUltimaConta($latestIdx, $date)
    {
        $idx = $latestIdx < 0 ? 0 : $latestIdx;
        $totalContas = count(ContasSeeder::$todasContas);
        while (($idx < $totalContas)  && (Carbon::create(ContasSeeder::$todasContas[$idx]["data_inicio"]) <= $date)) {
            $idx++;
        }
        return $idx - 1;
    }

    public function createMovimentoArray($faker, $idxConta, $conta, $date)
    {
        $categoria_id = null;
        $tipo = null;
        $valor = 0;
        if (($conta["saldo_atual"] >= $conta["min"]) && ($conta["saldo_atual"] <= $conta["max"])) {
            CategoriasSeeder::getMovimento($categoria_id, $tipo, $valor, $conta["factor"]);
        } else
        if ($conta["saldo_atual"] < $conta["min"]) {
            $tipo = "R";
            CategoriasSeeder::getReceita($categoria_id, $valor, $conta["factor"] * 2);
        } else {
            $tipo = "D";
            CategoriasSeeder::getDespesa($categoria_id, $valor, $conta["factor"] * 2);
        }
        $oldSaldo = $conta["saldo_atual"];
        $novoSaldo = $tipo == 'R' ? $oldSaldo + $valor : $oldSaldo - $valor;
        ContasSeeder::$todasContas[$idxConta]["saldo_atual"] = $novoSaldo;
        ContasSeeder::$todasContas[$idxConta]["data_ultimo_movimento"] = $date->toDateString();
        return [
            "conta_id" => $idxConta + 1,
            "data" => $date,
            "valor" => $valor,
            "saldo_inicial" => $oldSaldo,
            "saldo_final" => $novoSaldo,
            "tipo" => $tipo,
            "categoria_id" => $categoria_id,
            "descricao" => rand(0, 50) == 5 ? $faker->realText() : null,
            "imagem_doc" => null,
            "deleted_at" => null
        ];
    }
}
