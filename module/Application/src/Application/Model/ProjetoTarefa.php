<?php

namespace Application\Model;

class ProjetoTarefa
{
	public $tarefa_id;
	public $projeto_id;
	public $tarefa_nome;
	public $tarefa_descricao;
	public $tarefa_status;
	public $tarefa_data_inicio;
	public $tarefa_data_termino;
	public $tarefa_data_previsao_termino;

	public function exchangeArray($data)
	{
		$this->tarefa_id     = (!empty($data['tarefa_id'])) ? $data['tarefa_id'] : null;
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->tarefa_nome = (!empty($data['tarefa_nome'])) ? $data['tarefa_nome'] : null;	
		$this->tarefa_descricao = (!empty($data['tarefa_descricao'])) ? $data['tarefa_descricao'] : null;		
		$this->tarefa_status = (!empty($data['tarefa_status'])) ? $data['tarefa_status'] : null;		
		$this->tarefa_data_inicio = (!empty($data['tarefa_data_inicio'])) ? $data['tarefa_data_inicio'] : null;		
		$this->tarefa_data_termino = (!empty($data['tarefa_data_termino'])) ? $data['tarefa_data_termino'] : null;		
		$this->tarefa_data_previsao_termino = (!empty($data['tarefa_data_previsao_termino'])) ? $data['tarefa_data_previsao_termino'] : null;			
	}
}