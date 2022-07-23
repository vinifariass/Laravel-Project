<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings,WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return auth()->user()->tarefas()->get();
    }

    public function headings(): array
    {
        return ['ID da Tarefa', 'ID do Usuário', 'Tarefa', 'Data limite conclusão', 'Data criação', 'Data atualização'];
    }

    public function map($row): array
    {
        
    }
}
