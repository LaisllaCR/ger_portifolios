<?php

namespace Application\Model;

class Logs
{
	public $log_id;
	public $usuario_id;
	public $data;
	public $acao;
	public $id;

	public function exchangeArray($data)
	{
		$this->log_id     = (!empty($data['log_id'])) ? $data['log_id'] : null;
		$this->usuario_id     = (!empty($data['usuario_id'])) ? $data['usuario_id'] : null;
		$this->data     = (!empty($data['data'])) ? $data['data'] : null;
		$this->acao     = (!empty($data['acao'])) ? $data['acao'] : null;
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
	}
}