<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjetoSemanaJustificativaTable
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

	public function getProjetoSemanaJustificativa($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_semana_id' => $id));
		$row = $rowset->current();
		
		if (!$row) {
			return 0;
		}
		return $row;
	}
	
	public function getProjetoJustificativa($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_semana_justificativa_id' => $id));
		$row = $rowset->current();
		
		if (!$row) {
			return 0;
		}
		return $row;
	}
	
	public function getProjetoSemanaJustificativas($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveProjetoSemanaJustificativa(ProjetoSemanaJustificativa $projetoJustificativa)
	{
		$data = array(
				'projeto_semana_justificativa'  => $projetoJustificativa->projeto_semana_justificativa,
				'projeto_semana_id'  => $projetoJustificativa->projeto_semana_id,
				'usuario_id'  => $projetoJustificativa->usuario_id,
		);

		$id = (int) $projetoJustificativa->projeto_semana_justificativa_id;
		
		if ($id == 0) {
			$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		} else {
			if ($this->getProjetoJustificativa($id)) {
				$this->tableGateway->update($data, array('projeto_semana_justificativa_id' => $id));
			} else {
				throw new \Exception('Acompanhamento id does not exist');
			}
		}
	}
	

	public function deleteProjetoSemanaJustificativas($id)
	{
		$this->tableGateway->delete(array('projeto_id' => (int) $id));
	}
}