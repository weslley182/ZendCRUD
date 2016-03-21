<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 20-Mar-16
 * Time: 22:10
 */
namespace Application\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class ProdutoForm extends Form{
    public function __construct(){
        parent::__construct('produto');

        $id = new Hidden('id');
        $nome = new Text('nome');
        $nome->setLabel('Nome:')
            ->setAttributes([
                'style' => 'width:150px;'
            ]);
        $preco = new Text('preco');
        $preco->setLabel('Preço:')
            ->setAttributes([
                'style' => 'width:60px;'
            ]);
        $foto = new File('foto');
        $foto->setLabel('Foto:')
            ->setAttributes([
                'style' => 'width:150px;'
            ]);

        $descricao = new Textarea('descricao');
        $descricao->setLabel('Descricao')
            ->setAttributes([
                'style' => 'width:150px; heigth:100px;'
            ]);

        $status = new Checkbox('status');
        $status->setLabel('Status:')
            ->setValue(1);

        $submit = new Button('submit');
        $submit->setLabel('Cadastrar')
            ->setAttributes([
                'type' => 'submit'
            ]);

        $this->add($id);
        $this->add($nome);
        $this->add($preco);
        $this->add($foto);
        $this->add($descricao);
        $this->add($status);
        $this->add($submit,['priority' => -100]);

    }
}