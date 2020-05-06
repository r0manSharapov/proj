<?php

use Illuminate\Database\Seeder;

class AutorizacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line('--- > Criar Autorizações');
        DB::table('autorizacoes_contas')->truncate();

        // Utilizador 1 pode ver todas as contas de 5 - primera com todas permissões, restantes só leitura
        // Utilizador 1 pode ver 1ª conta de 2 - só leitura
        // Utilizador 1 pode ver 1ª conta de 3 - leitura e escrita
        // Utilizador 5 pode ver 1ª conta de 1 - só leitura
        // Utilizador 5 pode ver 1ª conta de 2 - leitura e escrita
        // Utilizador 5 pode ver 1ª conta de 3 - só leitura
        // NOTA : 1ª conta de 3 deverá estar "APAGADA" com softdelete

        // Depois são criadas aleatoriamente relacoes de autorização - só entre users com id>6

        $idContas1 = DB::table('contas')->where('user_id', 1)->orderBy('id', 'asc')->pluck('id')->toArray();
        $idContas2 = DB::table('contas')->where('user_id', 2)->orderBy('id', 'asc')->pluck('id')->toArray();
        $idContas3 = DB::table('contas')->where('user_id', 3)->orderBy('id', 'asc')->pluck('id')->toArray();
        $idContas5 = DB::table('contas')->where('user_id', 5)->orderBy('id', 'asc')->pluck('id')->toArray();

        $i = 1;
        foreach ($idContas5 as $conta_id) {
            $this->createAutorizacao($conta_id, 1, $i != 1);
            $i++;
        }
        $this->createAutorizacao($idContas2[0], 1, true);
        $this->createAutorizacao($idContas3[0], 1, false);
        $this->createAutorizacao($idContas1[0], 5, true);
        $this->createAutorizacao($idContas2[0], 5, false);
        $this->createAutorizacao($idContas3[0], 5, true);

        $idContas = DB::table('contas')->where('user_id', '>', 10)->orderBy('id', 'asc')->pluck('id')->toArray();
        $user_id_max = DB::table('contas')->max('user_id');
        for ($i = 1; $i < 2000; $i++) {
            $this->createAutorizacao($idContas[array_rand($idContas)], rand(11, $user_id_max), rand(1, 6) != 1);
        }
        $pairsToDelete = DB::select('select a.user_id, a.conta_id ' .
            'from autorizacoes_contas as a left join contas as c on c.id = a.conta_id ' .
            'where a.user_id = c.user_id');
        foreach ($pairsToDelete as $pair) {
            DB::table('autorizacoes_contas')->where('user_id', $pair->user_id)->where('conta_id', $pair->conta_id)->delete();
        }
    }

    private function createAutorizacao($conta_id, $user_id, $so_leitura = true)
    {
        try {
            DB::table('autorizacoes_contas')->insert([
                "user_id" => $user_id,
                "conta_id" => $conta_id,
                "so_leitura" => $so_leitura
            ]);
        } catch (Exception $e) {
            // Se der um erro a inserir - por exemplo, registo repetido, continua na próxima
            //var_dump($e);
        }
    }
}
