<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Gestao Projetos de Energia Solar",
 *   description="Sistema CRUD desenvolvido utilizando a framework Laravel em PHP é voltado para a gestão de projetos de energia solar. Ele adere aos princípios da arquitetura limpa (Clean Architecture), incorporando testes unitários para assegurar a qualidade do código. Além disso, oferece uma documentação abrangente para facilitar o entendimento e a manutenção do sistema.",
 *   @OA\Contact(email="adriano@instalustres.com.br"),
 *   @OA\License(
 *       name="Apache 2.0",
 *       url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *   )
 * )
 *
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="Servidor local"
 * )
 *
 * @OA\Tag(
 *   name="Login",
 *   description="Endpoint para efetuar login"
 * )
 *
 * @OA\Tag(
 *   name="Integradores",
 *   description="Endpoints para manutenção dos integradores (Somente integrador do tipo 'ADMIN')",
 * )
 *
 * @OA\Tag(
 *   name="Clientes",
 *   description="Endpoints para manutenção dos clientes",
 * )
 *
 * @OA\Tag(
 *   name="Instalações",
 *   description="Endpoints para manutenção das instalações",
 * )
 *
 * @OA\Tag(
 *   name="Equipamentos",
 *   description="Endpoints para manutenção dos equipamentos",
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HttpResponse;
}
