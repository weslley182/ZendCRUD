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

/**
 * Class ProdutoTable
 * @package Application\Model
 */
class ProdutoTable extends AbstractTableGateway{

    /**
     * @var string
     */
    protected $table = 'produto';

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Produto());
        $this->initialize();
    }

    /**
     * @param int $currentPage
     * @param int $countPerPage
     * @return Paginator
     */
    public function fetchAll($currentPage = 1, $countPerPage = 2){
        $select = new Select();
        $select->from($this->table)->order('nome');

        $adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage($countPerPage);

        return $paginator;
    }

    /**
     * @param $idProduto
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getProduto($idProduto){
        $idProduto = (int)$idProduto;
        $rowSet = $this->select(['id' => $idProduto]);
        $row = $rowSet->current();

        if(!$row){
            throw new \Exception("Registro ID: $idProduto não encontrado");
        }

        return $row;
    }

    /**
     * @param Produto $produto
     * @throws \Exception
     */
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