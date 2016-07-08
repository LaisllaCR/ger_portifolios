<?php

namespace Application\Model;

class Indicador
{
	public $indicador_id;
	public $indicador_nome;

	public function exchangeArray($data)
	{
		$this->indicador_id     = (!empty($data['indicador_id'])) ? $data['indicador_id'] : null;
		$this->indicador_nome = (!empty($data['indicador_nome'])) ? $data['indicador_nome'] : null;		
	}
}