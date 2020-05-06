<?php

use Illuminate\Database\Seeder;

class DocsSeeder extends Seeder
{
    private $docPath = 'docs';
    private $allFiles;


    public function run()
    {
        $this->command->line('--- > Criar Docs (cópias digitais de docs)');
        $this->command->line('Docs vão ser armazenados na pasta ' . storage_path('app/' . $this->docPath));

        $this->allFiles = collect(File::files(database_path('seeds/docs')))->toArray();

        // Apaga as fotos antigas
        try {
            Storage::deleteDirectory($this->docPath);
        } catch (Exception $e) { // Por vezes só apaga à segunda tentativa
            Storage::deleteDirectory($this->docPath);
        } finally {
            Storage::makeDirectory($this->docPath);
        }

        $idContas = DB::table('contas')->where('user_id', 1)->pluck('id')->toArray();
        $idMovimentos = DB::table('movimentos')->whereIn('conta_id', $idContas)->pluck('id')->toArray();
        shuffle($idMovimentos);
        for ($i = 0; $i < 400; $i++) {
            $this->addDoc($idMovimentos[$i]);
            if ($i % 100 == 0) {
                $this->command->line('Criado Doc ' . $i . '/400 (todas no 1º user)');
            }
        }
    }

    private function addDoc($idMovimento)
    {
        $targetDir = storage_path('app/' . $this->docPath);
        $file = $this->allFiles[array_rand($this->allFiles)];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $newfilename = $idMovimento . "_" . uniqid() . '.' . $ext;
        File::copy($file, $targetDir . '/' . $newfilename);
        DB::table('movimentos')->where('id',  $idMovimento)->update(['imagem_doc' => $newfilename]);
    }
}
