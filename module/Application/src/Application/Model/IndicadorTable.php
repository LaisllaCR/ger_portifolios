<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class IndicadorTable
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

	public function getIndicador($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('indicador_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveIndicador(Indicador $indicador)
	{
		$data = array(
				'indicador_nome' => $indicador->indicador_nome,
		);

		$id = (int) $indicador->indicador_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getIndicador($id)) {
				$this->tableGateway->update($data, array('indicador_id' => $id));
			} else {
				throw new \Exception('Indicador id does not exist');
			}
		}
	}

	public function deleteIndicador($id)
	{
		$this->tableGateway->delete(array('indicador_id' => (int) $id));
	}
}