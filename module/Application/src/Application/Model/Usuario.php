<?php

namespace Application\Model;

class Usuario
{
	public $usuario_id;
	public $usuario_nome;
	public $usuario_email;
	public $usuario_senha;
	public $perfil_id;

	public function exchangeArray($data)
	{
		$this->usuario_id     = (!empty($data['usuario_id'])) ? $data['usuario_id'] : null;
		$this->usuario_nome     = (!empty($data['usuario_nome'])) ? $data['usuario_nome'] : null;
		$this->usuario_email     = (!empty($data['usuario_email'])) ? $data['usuario_email'] : null;
		$this->usuario_senha     = (!empty($data['usuario_senha'])) ? $data['usuario_senha'] : null;
		$this->perfil_id = (!empty($data['perfil_id'])) ? $data['perfil_id'] : null;		
	}
}