<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistsUniqueByActionRule implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Aplica um SPLIT  no nome do atributo para recuperar o index dele
        $equipamentoIndex = explode(".", $attribute)[1];
        // Recupera a ação do equipamento sendo validado
        $acao = request()->equipamentos[$equipamentoIndex]['acao'];
        // Busca o pivo pelo id do equipamento informado
        $equipamentoPivot = request()->projeto->equipamentos()->wherePivot('equipamento_id', $value)->get()->count();
        // Caso seja uma ATUALIZAÇÃO/EXCLUSÃO verifica se o código do equipamento já esta cadastrado
        // do contrário lança um erro de validação
        switch ($acao) {
            case 'U':
            case 'D':
                if ($equipamentoPivot === 0) {
                    $fail('O :attribute não está cadastrado e não é possível atualizar ou excluir.');
                }
                break;
            case 'C':
                if ($equipamentoPivot === 1) {
                    $fail('O :attribute está cadastrado e não é possível criar um novo.');
                }
                break;
            default:
                break;
        }
    }
}
