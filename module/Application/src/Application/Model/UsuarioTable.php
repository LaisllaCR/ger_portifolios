<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UsuarioTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getUsuario($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('usuario_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveUsuario(Usuario $usuario)
	{
		$data = array(
				'usuario_nome' => $usuario->usuario_nome,
				'usuario_email' => $usuario->usuario_email,
				'usuario_senha' => $usuario->usuario_senha,
				'perfil_id' => $usuario->perfil_id,
		);

		$id = (int) $usuario->usuario_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUsuario($id)) {
				$this->tableGateway->update($data, array('usuario_id' => $id));
			} else {
				throw new \Exception('Usuario id does not exist');
			}
		}
	}

	public function deleteUsuario($id)
	{
		$this->tableGateway->delete(array('usuario_id' => (int) $id));
	}
}