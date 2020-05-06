<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SoftDeletesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line('--- > Criar SoftDeletes');
        $this->command->line('--- > Reset de SoftDeletes');
        $this->resetSoftDeletes();

        $data = Carbon::now()->subSeconds(rand(30, 600));
        // Fazer SOFT DELETE da 1ª conta do user 3
        // e de várias (máx 100) contas (aleatórias) de users > 10

        $conta = DB::table('contas')->where('user_id', 3)->orderBy('id', 'asc')->first();
        $this->softDeleteAccount($conta->id, $data);
        $idContas = DB::table('contas')->where('user_id', '>', 10)->pluck('id')->toArray();
        for ($i = 1; $i < 100; $i++) {
            $this->softDeleteAccount($idContas[array_rand($idContas)], $data->copy());
            if ($i % 10 == 0) {
                $this->command->line('Criado o SoftDelete nº ' . $i . '/100');
            }
        }
    }

    private function resetSoftDeletes()
    {
        DB::table('contas')->whereNotNull('deleted_at')->update(["deleted_at" => null]);
        DB::table('movimentos')->whereNotNull('deleted_at')->update(["deleted_at" => null]);
    }

    private function softDeleteAccount($id, $data)
    {
        DB::table('contas')->where('id', $id)->update(["deleted_at" => $data]);
        $data->addSeconds(rand(5, 25));
        DB::table('movimentos')->where('conta_id', $id)->update(["deleted_at" => $data]);
    }
}
