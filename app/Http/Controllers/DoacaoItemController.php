<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use App\Models\DoacaoItem;
use Illuminate\Http\Request;

class DoacaoItemController extends Controller
{
    /**
     * Armazena um novo item de necessidade na campanha de doação.
     */
    public function store(Request $request, Doacao $doacao)
    {
        // Validação focada em doações
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade_meta' => 'required|integer|min:1',
            'unidade_medida' => 'required|string|max:20',
        ]);

        // Cria o item vinculado à doação correta
        $doacao->itens()->create($validated);

        return redirect()->route('doacoes.show', $doacao)
        ->with('success', 'Item adicionado à lista de necessidades!');
    }

    /**
     * Remove um item da campanha.
     */
    public function destroy(DoacaoItem $item)
    {
        $doacao = $item->doacao;
        $item->delete();

        return redirect()->route('doacoes.show', $doacao)
        ->with('success', 'Item removido da campanha.');
    }

    public function edit(DoacaoItem $item)
    {
        return view('doacoes.edit', compact('item'));
    }

    public function update(Request $request, DoacaoItem $item)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade_meta' => 'required|integer|min:1',
            'unidade_medida' => 'required|string|max:20',
        ]);

        $item->update($validated);

        return redirect()->route('doacoes.show', $item->doacao_id)
        ->with('success', 'Item atualizado com sucesso!');
    }
}