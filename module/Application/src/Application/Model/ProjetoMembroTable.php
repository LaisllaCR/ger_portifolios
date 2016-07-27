<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

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

	public function saveMembroProjeto(ProjetoMembro $projetoMembro)
	{
		$data = array(
				'projeto_id' => $projetoMembro->projeto_id,
				'usuario_id'  => $projetoMembro->usuario_id,
				'perfil_id'  => $projetoMembro->perfil_id,
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
}