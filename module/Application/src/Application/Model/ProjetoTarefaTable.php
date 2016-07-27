<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjetoTarefaTable
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

	public function getTarefaProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('tarefa_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}	

	public function getTarefasProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
	
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveTarefaProjeto(ProjetoTarefa $tarefaProjeto)
	{	
		$data = array(
				'tarefa_nome' => $tarefaProjeto->tarefa_nome,
				'projeto_id' => $tarefaProjeto->projeto_id,
				'tarefa_descricao' => $tarefaProjeto->tarefa_descricao,
				'tarefa_status' => $tarefaProjeto->tarefa_status,
				'tarefa_data_inicio' => $tarefaProjeto->tarefa_data_inicio,
				'tarefa_data_termino' => $tarefaProjeto->tarefa_data_termino,
				'tarefa_data_previsao_termino' => $tarefaProjeto->tarefa_data_previsao_termino,
		);

		$id = (int) $tarefaProjeto->tarefa_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getTarefaProjeto($id)) {
				$this->tableGateway->update($data, array('tarefa_id' => $id));
			} else {
				throw new \Exception('Tarefa id does not exist');
			}
		}
	}

	public function deleteTarefaProjeto($id)
	{
		$this->tableGateway->delete(array('tarefa_id' => (int) $id));
	}
}