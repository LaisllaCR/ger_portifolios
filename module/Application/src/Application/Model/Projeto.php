<?php

namespace Application\Model;

class Projeto
{
	public $projeto_id;
	public $projeto_nome;
	public $projeto_data_inicio;
	public $projeto_data_previsao_termino;
	public $projeto_data_real_termino;
	public $projeto_gerente_id;
	public $projeto_orcamento_total;
	public $projeto_descricao;
	public $projeto_status;
	public $projeto_risco;

	public function exchangeArray($data)
	{
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->projeto_nome = (!empty($data['projeto_nome'])) ? $data['projeto_nome'] : null;
		$this->projeto_data_inicio  = (!empty($data['projeto_data_inicio'])) ? $data['projeto_data_inicio'] : null;
		$this->projeto_data_previsao_termino  = (!empty($data['projeto_data_previsao_termino'])) ? $data['projeto_data_previsao_termino'] : null;
		$this->projeto_data_real_termino  = (!empty($data['projeto_data_real_termino'])) ? $data['projeto_data_real_termino'] : null;
		$this->projeto_gerente_id  = (!empty($data['projeto_gerente_id'])) ? $data['projeto_gerente_id'] : null;
		$this->projeto_orcamento_total  = (!empty($data['projeto_orcamento_total'])) ? $data['projeto_orcamento_total'] : null;
		$this->projeto_descricao  = (!empty($data['projeto_descricao'])) ? $data['projeto_descricao'] : null;
		$this->projeto_status  = (!empty($data['projeto_status'])) ? $data['projeto_status'] : null;
		$this->projeto_risco  = (!empty($data['projeto_risco'])) ? $data['projeto_risco'] : null;
	}
}