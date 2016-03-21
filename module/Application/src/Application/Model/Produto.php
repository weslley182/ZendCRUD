<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 21-Mar-16
 * Time: 09:22
 */
namespace Application\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class Produto implements InputFilterAwareInterface{
    public $id;
    public $nome;
    public $preco;
    public $foto;
    public $descricao;
    public $status;

    protected $inputFilter;

    public function exchangeArray($data){
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->preco = (isset($data['preco'])) ? $data['preco'] : null;
        $this->foto = (isset($data['foto'])) ? $data['foto'] : null;
        $this->descricao = (isset($data['descricao'])) ? $data['descricao'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function setInputFilter(inputFilterInterface $inputFilter){
        throw new \Exception("Not Used");
    }

    public function getInputFilter(){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput([
                'name' => 'id',
                'required' => true,
                'filters' => [
                    'name' => 'Int'
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'nome',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Favor digitar corretamente o campo nome'
                            ]
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'preco',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'foto',
                'required' => false,
                'filters' => [
                    ['name' => 'StringTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'descricao',
                'required' => false,
                'filters' => [
                    ['name' => 'StringTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Favor digitar corretamente o campo descri��o'
                            ]
                        ]
                    ],
                    [
                        'name' => 'StringLength',
                        true,
                        'options' =>[
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                            'message' => 'Descri��o do produto deve ter entre 3 e 100 caracteres.'
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'status',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->$inputFilter;
    }


}#end class