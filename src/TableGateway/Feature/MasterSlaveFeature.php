<?php

namespace Laminas\Db\TableGateway\Feature;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;

class MasterSlaveFeature extends AbstractFeature
{
    /** @var AdapterInterface */
    protected $slaveAdapter;

    /** @var Sql */
    protected $masterSql;

    /** @var Sql */
    protected $slaveSql;

    /**
     * Constructor
     */
    public function __construct(AdapterInterface $slaveAdapter, ?Sql $slaveSql = null)
    {
        $this->slaveAdapter = $slaveAdapter;
        if ($slaveSql) {
            $this->slaveSql = $slaveSql;
        }
    }

    /** @return AdapterInterface */
    public function getSlaveAdapter()
    {
        return $this->slaveAdapter;
    }

    /**
     * @return Sql
     */
    public function getSlaveSql()
    {
        return $this->slaveSql;
    }

    /**
     * after initialization, retrieve the original adapter as "master"
     */
    public function postInitialize()
    {
        $this->masterSql = $this->getTableGateway()->sql;
        if ($this->slaveSql === null) {
            $this->slaveSql = new Sql(
                $this->slaveAdapter,
                $this->getTableGateway()->sql->getTable(),
                $this->getTableGateway()->sql->getSqlPlatform()
            );
        }
    }

    /**
     * preSelect()
     * Replace adapter with slave temporarily
     */
    public function preSelect()
    {
        $this->getTableGateway()->sql = $this->slaveSql;
    }

    /**
     * postSelect()
     * Ensure to return to the master adapter
     */
    public function postSelect()
    {
        $this->getTableGateway()->sql = $this->masterSql;
    }
}
