<?php

namespace Application\Model;

class ProjetoSemanaJustificativa
{
	public $projeto_semana_justificativa_id;
	public $projeto_semana_id;
	public $projeto_semana_justificativa;

	public function exchangeArray($data)
	{
		$this->projeto_semana_justificativa_id     = (!empty($data['projeto_semana_justificativa_id'])) ? $data['projeto_semana_justificativa_id'] : null;
		$this->projeto_semana_id     = (!empty($data['projeto_semana_id'])) ? $data['projeto_semana_id'] : null;
		$this->projeto_semana_justificativa     = (!empty($data['projeto_semana_justificativa'])) ? $data['projeto_semana_justificativa'] : null;
	}
}