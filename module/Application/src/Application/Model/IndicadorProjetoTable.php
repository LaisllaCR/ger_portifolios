<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class IndicadorProjetoTable
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

	public function getIndicadorProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('indicador_projeto_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getIndicadoresProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveIndicadorProjeto(IndicadorProjeto $indicadorProjeto)
	{
		$data = array(
				'indicador_id' => $indicadorProjeto->indicador_id,
				'projeto_id' => $indicadorProjeto->projeto_id,
				'usuario_id' => $indicadorProjeto->usuario_id,
				'projeto_fase' => $indicadorProjeto->projeto_fase,
				'valor_minimo' => $indicadorProjeto->valor_minimo,
				'valor_maximo' => $indicadorProjeto->valor_maximo,
		);

		$id = (int) $indicadorProjeto->indicador_projeto_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getIndicadorProjeto($id)) {
				$this->tableGateway->update($data, array('indicador_projeto_id' => $id));
			} else {
				throw new \Exception('Indicador id does not exist');
			}
		}
	}

	public function deleteIndicadorProjeto($id)
	{
		$this->tableGateway->delete(array('indicador_projeto_id' => (int) $id));
	}
}