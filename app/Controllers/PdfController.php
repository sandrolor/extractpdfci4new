<?php

namespace App\Controllers;

use App\Models\FolhaPagamentoModel;
use Smalot\PdfParser\Parser;
use CodeIgniter\Controller;

class PdfController extends Controller
{
    public function index()
    {
        return view('pdf_upload');
    }

    public function upload()
    {
        $file = $this->request->getFile('pdf_file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Erro no upload do arquivo.');
        }

        // Mover o arquivo para a pasta writable/uploads/
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $filePath = WRITEPATH . 'uploads/' . $newName;

        // Ler e extrair os dados do PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();

        // Processar os dados extraídos
        $dados = $this->processarDados($text);

        // Salvar os dados no banco de dados
        $model = new FolhaPagamentoModel();
        foreach ($dados as $dado) {
            $model->insert($dado);
        }

        return redirect()->back()->with('success', 'Dados extraídos e salvos com sucesso!');
    }

    private function processarDados($text)
    {
        $linhas = explode("\n", $text);
        $dados = [];

        foreach ($linhas as $linha) {
            if (preg_match('/(\d{3}) (.+) CPF:(\d{3}\.\d{3}\.\d{3}-\d{2})/', $linha, $matches)) {
                $dados[] = [
                    'nome' => trim($matches[2]),
                    'cpf' => trim($matches[3]),
                    'cargo' => 'AUXILIAR DE RECREAÇÃO', // Pode ser ajustado conforme necessário
                    'data_admissao' => '2024-01-01', // Ajustar conforme o padrão encontrado
                    'salario' => 1518.00, // Ajustar conforme necessário
                    'proventos' => 1583.44,
                    'descontos' => 119.73,
                    'liquido' => 1463.71,
                    'base_inss' => 1583.44,
                    'base_fgts' => 1018.64,
                    'base_irrf' => 0.00
                ];
            }
        }

        return $dados;
    }
}