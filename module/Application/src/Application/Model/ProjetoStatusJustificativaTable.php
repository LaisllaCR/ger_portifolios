<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjetoStatusJustificativaTable
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

	public function getProjetoStatusJustificativa($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_status_justificativa_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getProjetoStatusJustificativas($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveProjetoStatusJustificativa(ProjetoStatusJustificativa $projetoJustificativa)
	{
		$data = array(
				'projeto_id' => $projetoJustificativa->projeto_id,
				'projeto_status_justificativa'  => $projetoJustificativa->projeto_status_justificativa,
				'projeto_status'  => $projetoJustificativa->projeto_status,
				'projeto_status_data'  => $projetoJustificativa->projeto_status_data,
		);

		$id = (int) $projetoJustificativa->projeto_status_justificativa_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjetoStatusJustificativa($id)) {
				$this->tableGateway->update($data, array('projeto_status_justificativa_id' => $id));
			} else {
				throw new \Exception('Acompanhamento id does not exist');
			}
		}
	}
	

	public function deleteProjetoStatusJustificativas($id)
	{
		$this->tableGateway->delete(array('projeto_id' => (int) $id));
	}
}