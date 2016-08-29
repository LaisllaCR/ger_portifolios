<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class LogsTable
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

	public function getUsuarioLogs($usuario_id)
	{
		$resultSet = $this->tableGateway->select(array('usuario_id' => $usuario_id));
		return $resultSet;
	}
		
	public function saveLogs(Logs $logs)
	{
		$data = array(
				'log_id' => $logs->log_id,
				'usuario_id' => $logs->usuario_id,
				'data' => $logs->data,
				'acao' => $logs->acao,
				'id' => $logs->id,
		);

		$id = (int) $logs->log_id;
		
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUsuario($id)) {
				$this->tableGateway->update($data, array('log_id' => $id));
			} else {
				throw new \Exception('Usuario id does not exist');
			}
		}
	}
}