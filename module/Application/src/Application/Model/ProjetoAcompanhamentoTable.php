<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProjetoAcompanhamentoTable
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

	public function getProjetoAcompanhamento($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_acompanhamento_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getAcompanhamentosProjeto($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('projeto_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row projeto $id");
		}
		return $rowset;
	}

	public function saveAcompanhamentoProjeto(ProjetoAcompanhamento $projetoAcompanhamento)
	{
		$data = array(
				'projeto_id' => $projetoAcompanhamento->projeto_id,
				'projeto_acompanhamento_semana'  => $projetoAcompanhamento->projeto_acompanhamento_semana,
				'projeto_acompanhamento_data_inicio'  => $projetoAcompanhamento->projeto_acompanhamento_data_inicio,
				'projeto_acompanhamento_data_termino'  => $projetoAcompanhamento->projeto_acompanhamento_data_termino,
				'projeto_acompanhamento_descricao'  => $projetoAcompanhamento->projeto_acompanhamento_descricao,
		);

		$id = (int) $projetoAcompanhamento->projeto_acompanhamento_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getProjetoAcompanhamento($id)) {
				$this->tableGateway->update($data, array('projeto_acompanhamento_id' => $id));
			} else {
				throw new \Exception('Acompanhamento id does not exist');
			}
		}
	}

	public function deleteProjetoAcompanhamento($id)
	{
		$this->tableGateway->delete(array('projeto_acompanhamento_id' => (int) $id));
	}
	
	public function salvarDatasAcompanhamento(Projeto $projeto)
	{
		 
		if (is_object($projeto)) {
			 
			$dataInicio = $projeto->projeto_data_inicio;
			$array_datas = Array();
			$array_datas[] = $dataInicio;
			 
			if(empty($projeto->projeto_data_real_termino) || $projeto->projeto_data_real_termino == NULL){
				$dataFinal =$projeto->projeto_data_previsao_termino;
			}else{
				$dataFinal =$projeto->projeto_data_real_termino;
			}
			 
			while (strtotime($dataInicio) < strtotime($dataFinal)){
				$dataInicio = date('Y-m-d', strtotime("+7 days",strtotime($dataInicio)));
				$array_datas[] = $dataInicio;
			}
			 
			$ultimo = end($array_datas);
			 
			if(strtotime($ultimo) > strtotime($dataFinal)){
				$pos = count($array_datas) - 1;
				$array_datas[$pos] = $dataFinal;
			}
			 
			$count = 0;
			$array_datas_bd = Array();
			foreach ($array_datas as $data){
				if(!empty($array_datas[$count +1])){
						
					$acompanhamentoProjeto = new ProjetoAcompanhamento();
					$acompanhamentoProjeto->projeto_acompanhamento_semana = $count +1;
					$acompanhamentoProjeto->projeto_acompanhamento_data_inicio = $data;
					$acompanhamentoProjeto->projeto_acompanhamento_data_termino = $array_datas[$count +1];
					$acompanhamentoProjeto->projeto_id = $projeto->projeto_id;
					$acompanhamentoProjeto->projeto_acompanhamento_descricao = NULL;
			   
					$this->saveAcompanhamentoProjeto($acompanhamentoProjeto);
				}
	
				$count++;
			}
		}
	}
}