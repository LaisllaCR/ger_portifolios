<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ProjetoTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function getProjetosCancelados($mes)
	{		
		$sqlq = new Sql($this->tableGateway->adapter);
		
		$sql = 'SELECT * FROM projeto_status_justificativa as a JOIN projeto as b ON a.projeto_id = b.projeto_id WHERE Month(a.projeto_status_data) = '.$mes.' and a.projeto_status = "cancelado"';
		
		$statement = $this->tableGateway->adapter->query($sql);
		
		return $statement->execute();
	}

	public function saveProjeto(Projeto $projeto)
	{
		$data = array(
				'projeto_nome' => $projeto->projeto_nome,
				'projeto_data_inicio'  => $projeto->projeto_data_inicio,
				'projeto_data_previsao_termino'  => $projeto->projeto_data_previsao_termino,
				'projeto_data_real_termino'  => $projeto->projeto_data_real_termino,
				'projeto_gerente_id'  => $projeto->projeto_gerente_id,
				'projeto_orcamento_total'  => $projeto->projeto_orcamento_total,
				'projeto_descricao'  => $projeto->projeto_descricao,
				'projeto_status'  => $projeto->projeto_status,
				'projeto_risco'  => $projeto->projeto_risco,
		);

		$id = (int) $projeto->projeto_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
			$id = $this->tableGateway->getLastInsertValue();
			return $id;
		} else {
			if ($this->getProjeto($id)) {
				$this->tableGateway->update($data, array('projeto_id' => $id));
			} else {
				throw new \Exception('Projeto id does not exist');
			}
		}
	}

	public function deleteProjeto($id)
	{
		$this->tableGateway->delete(array('projeto_id' => (int) $id));
	}
}