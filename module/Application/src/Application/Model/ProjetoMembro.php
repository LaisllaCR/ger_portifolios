<?php

namespace Application\Model;

class ProjetoMembro
{
	public $projeto_membro_id;
	public $projeto_id;
	public $usuario_id;
	public $projeto_membro_papel;

	public function exchangeArray($data)
	{
		$this->projeto_membro_id     = (!empty($data['projeto_membro_id'])) ? $data['projeto_membro_id'] : null;
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->usuario_id     = (!empty($data['usuario_id'])) ? $data['usuario_id'] : null;
		$this->projeto_membro_papel     = (!empty($data['projeto_membro_papel'])) ? $data['projeto_membro_papel'] : null;
	}
}