<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ProjetoMembroTable
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

	public function getProjetoMembro($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_membro_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getMembrosProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function getDadosMembro($id)
	{
		$sqlq = new Sql($this->tableGateway->adapter);
	
		$sql = 'SELECT * FROM projeto_membro a JOIN usuario b ON a.usuario_id = b.usuario_id WHERE a.projeto_id = '.$id;
	
		$statement = $this->tableGateway->adapter->query($sql);
	
		return $statement->execute();
	}
	
	public function getDadosProjetosMembro($usuario_id)
	{
		$sqlq = new Sql($this->tableGateway->adapter);
	
		$sql = 'SELECT * FROM projeto_membro a JOIN projeto b ON a.projeto_id = b.projeto_id WHERE a.usuario_id = '.$usuario_id;
	
		$statement = $this->tableGateway->adapter->query($sql);
	
		return $statement->execute();
	}
	
	public function saveMembroProjeto(ProjetoMembro $projetoMembro)
	{
		$data = array(
				'projeto_id' => $projetoMembro->projeto_id,
				'usuario_id'  => $projetoMembro->usuario_id,
				'projeto_membro_papel'  => $projetoMembro->projeto_membro_papel,
		);

		$id = (int) $projetoMembro->projeto_membro_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjetoMembro($id)) {
				$this->tableGateway->update($data, array('projeto_membro_id' => $id));
			} else {
				throw new \Exception('Membro id does not exist');
			}
		}
	}

	public function deleteProjetoMembro($id)
	{
		$this->tableGateway->delete(array('projeto_membro_id' => (int) $id));
	}
	
	public function deleteProjetoMembros($id)
	{
		$this->tableGateway->delete(array('projeto_id' => (int) $id));
	}
}