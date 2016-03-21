<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 20-Mar-16
 * Time: 20:03
 */

namespace Application\Controller;

use Application\Form\ProdutoForm;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class ProdutosController extends AbstractActionController{
    public function indexAction(){

    }

    public function cadastrarAction(){
        $form = new ProdutoForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            var_dump($data);
        }
        $view = new ViewModel(['form' => $form]);
        $view->setTemplate('application/produtos/form.phtml');
        return $view;
    }

}