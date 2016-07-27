<?php

namespace Application\Model;

class Perfil
{
	public $perfil_id;
	public $perfil_nome;

	public function exchangeArray($data)
	{
		$this->perfil_id     = (!empty($data['perfil_id'])) ? $data['perfil_id'] : null;
		$this->perfil_nome     = (!empty($data['perfil_nome'])) ? $data['perfil_nome'] : null;
	}
}