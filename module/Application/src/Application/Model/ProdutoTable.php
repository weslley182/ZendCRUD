<?php
/**
 * Created by PhpStorm.
 * User: Wesley
 * Date: 21-Mar-16
 * Time: 10:10
 */
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProdutoTable extends AbstractTableGateway{

    protected $table = 'produto';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Produto());
        $this->initialize();
    }

    public function fetchAll($currentPage = 1, $countPerPage = 2){
        $select = new Select();
        $select->from($this->table)->order('nome');

        $adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage($countPerPage);

        return $paginator;
    }

    public function getProduto($idProduto){
        $idProduto = (int)$idProduto;
        $rowSet = $this->select(['id' => $idProduto]);
        $row = $rowSet->current();

        if(!$row){
            throw new \Exception("Registro ID: $idProduto não encontrado");
        }

        return $row;
    }

    public function saveProduto(Produto $produto){
        $data = [
            'nome' => $produto->nome,
            'preco' => $produto->preco,
            'foto' => $produto->foto,
            'descricao' => $produto->descricao,
            'status' => $produto->status
        ];

        $idProduto = (int)$produto->id;
        if($idProduto == 0){
            $this->insert($data);
        }else{
            if($this->getProduto($idProduto)){
                $this->update($data, ['id' => $idProduto]);
            }else{
                throw new \Exception("O produto de id: '$idProduto' não foi encontrado no banco de dados.");
            }
        }
    }

}