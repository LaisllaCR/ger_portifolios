<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjetoSemanaTable
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

	public function getProjetoSemana($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_semana_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getProjetoSemanas($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveProjetoSemana(ProjetoSemana $projetoSemana)
	{
		$data = array(
				'projeto_id' => $projetoSemana->projeto_id,
				'projeto_semana'  => $projetoSemana->projeto_semana,
				'projeto_semana_data_inicio'  => $projetoSemana->projeto_semana_data_inicio,
				'projeto_semana_data_fim'  => $projetoSemana->projeto_semana_data_fim,
		);

		$id = (int) $projetoSemana->projeto_semana_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjetoSemana($id)) {
				$this->tableGateway->update($data, array('projeto_semana_id' => $id));
			} else {
				throw new \Exception('Acompanhamento id does not exist');
			}
		}
	}
	
	public function atualizaProjetoSemana(ProjetoSemana $projetoSemana)
	{
		$data = array(
				'projeto_id' => $projetoSemana->projeto_id,
				'projeto_semana'  => $projetoSemana->projeto_semana,
				'projeto_semana_data_inicio'  => $projetoSemana->projeto_semana_data_inicio,
				'projeto_semana_data_fim'  => $projetoSemana->projeto_semana_data_fim,
		);
	
		$id = (int) $projetoSemana->projeto_semana_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjetoSemana($id)) {
				$this->tableGateway->update($data, array('projeto_semana' => $projetoSemana->projeto_semana));
			} else {
				throw new \Exception('Acompanhamento id does not exist');
			}
		}
	}
	

	public function deleteProjetoSemanas($id)
	{
		$this->tableGateway->delete(array('projeto_id' => (int) $id));
	}
	
	public function deleteProjetoSemana($id)
	{
		$this->tableGateway->delete(array('projeto_semana_id' => (int) $id));
	}
}