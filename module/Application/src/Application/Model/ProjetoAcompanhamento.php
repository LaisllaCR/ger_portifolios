<?php

namespace Application\Model;

class ProjetoAcompanhamento
{
	public $projeto_acompanhamento_id;
	public $projeto_id;
	
	public $projeto_acompanhamento_semana;
	public $projeto_acompanhamento_data_inicio;
	public $projeto_acompanhamento_data_termino;
	
	public $projeto_acompanhamento_descricao;

	public function exchangeArray($data)
	{
		$this->projeto_acompanhamento_id     = (!empty($data['projeto_acompanhamento_id'])) ? $data['projeto_acompanhamento_id'] : null;
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;
		$this->projeto_acompanhamento_semana     = (!empty($data['projeto_acompanhamento_semana'])) ? $data['projeto_acompanhamento_semana'] : null;
		$this->projeto_acompanhamento_data_inicio     = (!empty($data['projeto_acompanhamento_data_inicio'])) ? $data['projeto_acompanhamento_data_inicio'] : null;
		$this->projeto_acompanhamento_data_termino     = (!empty($data['projeto_acompanhamento_data_termino'])) ? $data['projeto_acompanhamento_data_termino'] : null;
				
		$this->projeto_acompanhamento_descricao     = (!empty($data['projeto_acompanhamento_descricao'])) ? $data['projeto_acompanhamento_descricao'] : null;
	}
}