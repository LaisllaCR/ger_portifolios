<?php

namespace Application\Model;

class IndicadorProjeto
{
	public $indicador_projeto_id;
	public $indicador_id;
	public $projeto_id;
	public $usuario_id;
	public $projeto_fase;
	public $valor_minimo;
	public $valor_maximo;
	public $indicador_projeto_valor;
	public $indicador_projeto_descricao;

	public function exchangeArray($data)
	{
		$this->indicador_projeto_id = (!empty($data['indicador_projeto_id'])) ? $data['indicador_projeto_id'] : null;
		$this->indicador_id     = (!empty($data['indicador_id'])) ? $data['indicador_id'] : null;		
		$this->projeto_id     = (!empty($data['projeto_id'])) ? $data['projeto_id'] : null;		
		$this->usuario_id     = (!empty($data['usuario_id'])) ? $data['usuario_id'] : null;		
		$this->projeto_fase     = (!empty($data['projeto_fase'])) ? $data['projeto_fase'] : null;		
		$this->valor_minimo     = (!empty($data['valor_minimo'])) ? $data['valor_minimo'] : null;		
		$this->valor_maximo     = (!empty($data['valor_maximo'])) ? $data['valor_maximo'] : null;		
		$this->indicador_projeto_valor     = (!empty($data['indicador_projeto_valor'])) ? $data['indicador_projeto_valor'] : null;		
		$this->indicador_projeto_descricao     = (!empty($data['indicador_projeto_descricao'])) ? $data['indicador_projeto_descricao'] : null;		
	}
}