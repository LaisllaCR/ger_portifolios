<?php

namespace Application\Model;

class ProjetoStatusJustificativa
{
	public $projeto_status_justificativa_id;
	public $projeto_id;
	public $projeto_status;
	public $projeto_status_data;
	public $projeto_status_justificativa;

	public function exchangeArray($data)
	{
		$this->projeto_status_justificativa_id     = (!empty($data['projeto_status_justificativa_id'])) ? $data['projeto_status_justificativa_id'] : null;
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->projeto_status     = (!empty($data['projeto_status'])) ? $data['projeto_status'] : null;
		$this->projeto_status_data     = (!empty($data['projeto_status_data'])) ? $data['projeto_status_data'] : null;
		$this->projeto_status_justificativa     = (!empty($data['projeto_status_justificativa'])) ? $data['projeto_status_justificativa'] : null;
	}
}