<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Db\Pagination;

class Testimony extends Page
{

    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $objPagination Essa variável é uma referencia de memória e tudo que for alterado nela em qualquer lugar, todas as outras verão
     * @return string
     */
    private static function getTestimonyItens($request, &$objPagination)
    {
        // DEPOIMENTOS
        $itens = '';

        // QUANTIDADE TOTAL DE REGISTRO
        $totalQuantity = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        // PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // INSTANCIA DA PÁGINA
        $objPagination = new Pagination($totalQuantity, $paginaAtual, 3);

        // RESULTADOS DA PÁGINAÇÃO
        $result = EntityTestimony::getTestimonies(null, 'id DESC', $objPagination->getLimit());

        // RENDERIZA O ITEM
        while ($objTestimony = $result->fetchObject(EntityTestimony::class)) {
            // VIEW DE ITENS
            $itens .= View::render('pages/testimonies/item', [
                'nome'     => $objTestimony->nome,
                'mensagem' => $objTestimony->mensagem,
                'data'     => date('d/m/Y H:i:s', strtotime($objTestimony->data))
            ]);
        }
        // RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por retornar o conteúdo (view) de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        // VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItens($request, $objPagination),
            'pagination' => parent::getPagination($request, $objPagination)
        ]);

        return parent::getPage('Depoimentos', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param Request $request
     * @return string
     */
    public static function insertTestimony($request)
    {
        // DADOS DO POST
        $postVars = $request->getPostVars();

        // NOVA INSTANCIA DE DEPOIMENTO
        $objTestimony = new EntityTestimony();
        $objTestimony->nome     = $postVars['nome'];
        $objTestimony->mensagem = $postVars['mensagem'];

        $objTestimony->cadastrar();

        // RETORNA A PÁGINA DA LISTAGEM DE DEPOIMENTOS
        return self::getTestimonies($request);
    }
}
