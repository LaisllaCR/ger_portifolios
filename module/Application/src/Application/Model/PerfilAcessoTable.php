<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class PerfilAcessoTable
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

	public function getPerfilAcesso($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('perfil_acesso_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getPerfilAcessos($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('perfil_id' => $id));
		
		if (!$rowset) {
			throw new \Exception("Could not find row $id");
		}
		return $rowset;
	}

	public function savePerfilAcesso(PerfilAcesso $perfilAcesso)
	{
		$data = array(
				'perfil_id' => $perfilAcesso->perfil_id,
				'funcionalidade_id' => $perfilAcesso->funcionalidade_id,
		);

		$id = (int) $perfilAcesso->perfil_acesso_id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getPerfilAcesso($id)) {
				$this->tableGateway->update($data, array('perfil_acesso_id' => $id));
			} else {
				throw new \Exception('Perfil de Acesso id does not exist');
			}
		}
	}

	public function deletePerfilAcesso($id)
	{
		$this->tableGateway->delete(array('perfil_id' => (int) $id));
	}
}