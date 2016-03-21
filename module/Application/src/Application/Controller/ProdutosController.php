<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 20-Mar-16
 * Time: 20:03
 */

namespace Application\Controller;

use Application\Form\ProdutoForm;
use Application\Model\Produto;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class ProdutosController
 * @package Application\Controller
 */
class ProdutosController extends AbstractActionController{

    /**
     * @var
     */
    protected $produtoTale;

    /**
     * @return array|object
     */
    public function getProdutoTale(){
        if(!$this->produtoTale){
            $sm = $this->getServiceLocator();
            $this->produtoTale = $sm->get('produto_table');
        }
        return $this->produtoTale;
    }

    /**
     *
     */
    public function indexAction(){

    }

    /**
     * @return ViewModel
     */
    public function cadastrarAction(){
        $form = new ProdutoForm();
        $request = $this->getRequest();

        if($request->isPost()){
            $produto = new Produto();
            $data = $request->getPost();
            $form->setInputFilter($produto->getInputFilter());

            if($form->isValid()){
                $produto->exchangeArray($data);
                $this->getProdutoTale()->saveProduto($produto);
            }

        }
        $view = new ViewModel(['form' => $form]);
        $view->setTemplate('application/produtos/form.phtml');
        return $view;
    }

}