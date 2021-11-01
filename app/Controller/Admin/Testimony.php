<?php

namespace App\Controller\Admin;

use App\Db\Pagination;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;

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
        $objPagination = new Pagination($totalQuantity, $paginaAtual, 5);

        // RESULTADOS DA PÁGINAÇÃO
        $result = EntityTestimony::getTestimonies(null, 'id DESC', $objPagination->getLimit());

        // RENDERIZA O ITEM
        while ($objTestimony = $result->fetchObject(EntityTestimony::class)) {
            // VIEW DE ITENS
            $itens .= View::render('admin/modules/testimonies/item', [
                'id'       => $objTestimony->id,
                'nome'     => $objTestimony->nome,
                'mensagem' => $objTestimony->mensagem,
                'data'     => date('d/m/Y H:i:s', strtotime($objTestimony->data))
            ]);
        }
        // RETORNA OS DEPOIMENTOS
        return $itens;
    }
    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     *
     * @param Request $request
     * @return string
     */
    public static function getTestimony($request)
    {
        // CONTEÚDO DA HOME
        $content = View::render('admin/modules/testimonies/index', [
            'itens'      => self::getTestimonyItens($request, $objPagination),
            'pagination' => parent::getPagination($request, $objPagination),
            'status'     => self::getStatus($request)
        ]);

        return parent::getPanel('Depoimentos', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     *
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {
        // CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Cadastrar Depoimento',
            'nome'     => '',
            'mensagem' => '',
            'status'   => ''
        ]);

        return parent::getPanel('Cadastrar Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por cadastrar um novo depoimento no banco
     *
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();

        // NOVA INSTANCIA DE DEPOIMENTO
        $objTestimony = new EntityTestimony();
        $objTestimony->nome     = $postVars['nome'] ?? '';
        $objTestimony->mensagem = $postVars['mensagem'] ?? '';
        $objTestimony->cadastrar();

        // REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $objTestimony->id . '/edit?status=created');
    }

    /**
     * Método responsável por retornar o formulário de edição de um depoimento
     *
     * @param Request $request
     * @param integer
     * @return string
     */
    public static function getEditTestimony($request, $id)
    {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $objTestimony = EntityTestimony::getTestimonyById($id);

        // VALIDA A INSTANCIA
        if (!$objTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Editar Depoimento',
            'nome'     => $objTestimony->nome,
            'mensagem' => $objTestimony->mensagem,
            'status'   => self::getStatus($request)
        ]);

        return parent::getPanel('Editar Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por gravar a edição de um depoimento
     *
     * @param Request $request
     * @param integer
     * @return string
     */
    public static function setEditTestimony($request, $id)
    {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $objTestimony = EntityTestimony::getTestimonyById($id);

        // VALIDA A INSTANCIA
        if (!$objTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('admin/testimonies');
        }

        // ATUALIZA INSTANCIA
        $postVars               = $request->getPostVars();
        $objTestimony->nome     = $postVars['nome'] ?? $objTestimony->nome;
        $objTestimony->mensagem = $postVars['mensagem'] ?? $objTestimony->mensagem;
        $objTestimony->atualizar();

        // REDIRECIONA O USUÁRIO
        return $request->getRouter()->redirect('/admin/testimonies/' . $objTestimony->id . '/edit?status=updated');
    }

    public static function getDeleteTestimony($request, $id)
    {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $objTestimony = EntityTestimony::getTestimonyById($id);

        // VALIDA A INSTANCIA
        if (!$objTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $objTestimony->nome,
            'mensagem' => $objTestimony->mensagem
        ]);

        return parent::getPanel('Excluir Depoimento', $content, 'testimonies');
    }


    /**
     * Método responsável por excluir um depoimento
     *
     * @param Request $request
     * @param integer
     * @return string
     */
    public static function setDeleteTestimony($request, $id)
    {
        // OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $objTestimony = EntityTestimony::getTestimonyById($id);

        // VALIDA A INSTANCIA
        if (!$objTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('admin/testimonies');
        }

        $objTestimony->deletar();

        // REDIRECIONA O USUÁRIO
        return $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }

    private static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams)) {
            return '';
        }

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSucess('Depoimento criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSucess('Depoimento atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSucess('Depoimento excluido com sucesso!');
                break;
        }
    }
}
