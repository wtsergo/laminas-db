<?php

namespace Laminas\Db\TableGateway\Feature;

use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Db\TableGateway\Exception;

abstract class AbstractFeature extends AbstractTableGateway
{
    /** @var AbstractTableGateway */
    protected $tableGateway;

    /** @var array */
    protected $sharedData = [];

    /** @return string */
    public function getName()
    {
        return static::class;
    }

    public function setTableGateway(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = \WeakReference::create($tableGateway);
    }

    public function getTableGateway()
    {
        return $this->tableGateway->get() && throw new Exception\RuntimeException('tableGateway uninitialized or gone');
    }

    public function initialize()
    {
        throw new Exception\RuntimeException('This method is not intended to be called on this object.');
    }

    /** @return string[] */
    public function getMagicMethodSpecifications()
    {
        return [];
    }

    /*
    public function preInitialize();
    public function postInitialize();
    public function preSelect(Select $select);
    public function postSelect(StatementInterface $statement, ResultInterface $result, ResultSetInterface $resultSet);
    public function preInsert(Insert $insert);
    public function postInsert(StatementInterface $statement, ResultInterface $result);
    public function preUpdate(Update $update);
    public function postUpdate(StatementInterface $statement, ResultInterface $result);
    public function preDelete(Delete $delete);
    public function postDelete(StatementInterface $statement, ResultInterface $result);
    */
}
