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


/**
 * Class Produto
 * @package Application\Model
 */
class Produto implements InputFilterAwareInterface{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $nome;
    /**
     * @var
     */
    public $preco;
    /**
     * @var
     */
    public $foto;
    /**
     * @var
     */
    public $descricao;
    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    protected $inputFilter;

    /**
     * @param $data
     */
    public function exchangeArray($data){
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->preco = (isset($data['preco'])) ? $data['preco'] : null;
        $this->foto = (isset($data['foto'])) ? $data['foto'] : null;
        $this->descricao = (isset($data['descricao'])) ? $data['descricao'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
    }

    /**
     * @return array
     */
    public function getArrayCopy(){
        return get_object_vars($this);
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(inputFilterInterface $inputFilter){
        throw new \Exception("Not Used");
    }

    /**
     * @return mixed
     */
    public function getInputFilter(){
        if(!$this->inputFilter){

            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput([
                'name' => 'id',
                'required' => false,
                'filters' => [
                    ['name' => 'Int']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'nome',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
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
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'foto',
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'descricao',
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Favor digitar corretamente o campo descrição'
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
                            'message' => 'Descrição do produto deve ter entre 3 e 100 caracteres.'
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'status',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ]
            ]));

            $this->inputFilter = $inputFilter;
        }

        return $this->$inputFilter;
    }


}#end class