<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

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
	
	public function getIndicadoresForaLimite()
	{				
		$sql = 'SELECT * FROM indicadores_projeto as a JOIN indicadores b ON a.indicador_id = b.indicador_id WHERE a.indicador_projeto_valor < a.valor_minimo or a.indicador_projeto_valor > a.valor_maximo';
		
		$statement = $this->tableGateway->adapter->query($sql);
		
		return $statement->execute();
	}

	public function saveIndicador(Indicador $indicador)
	{
		$data = array(
				'indicador_nome' => $indicador->indicador_nome,
		);

		$id = (int) $indicador->indicador_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
			$id = $this->tableGateway->getLastInsertValue();
			return $id;
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