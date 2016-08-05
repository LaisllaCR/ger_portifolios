<?php

namespace Application\Model;

class ProjetoSemana
{
	public $projeto_semana_id;
	public $projeto_id;
	public $projeto_semana;
	public $projeto_semana_data_inicio;
	public $projeto_semana_data_fim;

	public function exchangeArray($data)
	{
		$this->projeto_semana_id     = (!empty($data['projeto_semana_id'])) ? $data['projeto_semana_id'] : null;
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->projeto_semana     = (!empty($data['projeto_semana'])) ? $data['projeto_semana'] : null;
		$this->projeto_semana_data_inicio     = (!empty($data['projeto_semana_data_inicio'])) ? $data['projeto_semana_data_inicio'] : null;
		$this->projeto_semana_data_fim     = (!empty($data['projeto_semana_data_fim'])) ? $data['projeto_semana_data_fim'] : null;
	}
}