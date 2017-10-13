<?php

namespace Map;

use \UserSubscription;
use \UserSubscriptionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'user_subscription' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserSubscriptionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UserSubscriptionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user_subscription';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\UserSubscription';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'UserSubscription';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'user_subscription.value';

    /**
     * the column name for the plan_id field
     */
    const COL_PLAN_ID = 'user_subscription.plan_id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'user_subscription.user_id';

    /**
     * the column name for the parish_id field
     */
    const COL_PARISH_ID = 'user_subscription.parish_id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'user_subscription.status';

    /**
     * the column name for the start_date field
     */
    const COL_START_DATE = 'user_subscription.start_date';

    /**
     * the column name for the end_date field
     */
    const COL_END_DATE = 'user_subscription.end_date';

    /**
     * the column name for the pay_id field
     */
    const COL_PAY_ID = 'user_subscription.pay_id';

    /**
     * the column name for the customer_ref field
     */
    const COL_CUSTOMER_REF = 'user_subscription.customer_ref';

    /**
     * the column name for the mileage field
     */
    const COL_MILEAGE = 'user_subscription.mileage';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Value', 'PlanId', 'UserId', 'ParishId', 'Status', 'StartDate', 'EndDate', 'PayId', 'CustomerRef', 'Mileage', ),
        self::TYPE_CAMELNAME     => array('value', 'planId', 'userId', 'parishId', 'status', 'startDate', 'endDate', 'payId', 'customerRef', 'mileage', ),
        self::TYPE_COLNAME       => array(UserSubscriptionTableMap::COL_VALUE, UserSubscriptionTableMap::COL_PLAN_ID, UserSubscriptionTableMap::COL_USER_ID, UserSubscriptionTableMap::COL_PARISH_ID, UserSubscriptionTableMap::COL_STATUS, UserSubscriptionTableMap::COL_START_DATE, UserSubscriptionTableMap::COL_END_DATE, UserSubscriptionTableMap::COL_PAY_ID, UserSubscriptionTableMap::COL_CUSTOMER_REF, UserSubscriptionTableMap::COL_MILEAGE, ),
        self::TYPE_FIELDNAME     => array('value', 'plan_id', 'user_id', 'parish_id', 'status', 'start_date', 'end_date', 'pay_id', 'customer_ref', 'mileage', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'PlanId' => 1, 'UserId' => 2, 'ParishId' => 3, 'Status' => 4, 'StartDate' => 5, 'EndDate' => 6, 'PayId' => 7, 'CustomerRef' => 8, 'Mileage' => 9, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'planId' => 1, 'userId' => 2, 'parishId' => 3, 'status' => 4, 'startDate' => 5, 'endDate' => 6, 'payId' => 7, 'customerRef' => 8, 'mileage' => 9, ),
        self::TYPE_COLNAME       => array(UserSubscriptionTableMap::COL_VALUE => 0, UserSubscriptionTableMap::COL_PLAN_ID => 1, UserSubscriptionTableMap::COL_USER_ID => 2, UserSubscriptionTableMap::COL_PARISH_ID => 3, UserSubscriptionTableMap::COL_STATUS => 4, UserSubscriptionTableMap::COL_START_DATE => 5, UserSubscriptionTableMap::COL_END_DATE => 6, UserSubscriptionTableMap::COL_PAY_ID => 7, UserSubscriptionTableMap::COL_CUSTOMER_REF => 8, UserSubscriptionTableMap::COL_MILEAGE => 9, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'plan_id' => 1, 'user_id' => 2, 'parish_id' => 3, 'status' => 4, 'start_date' => 5, 'end_date' => 6, 'pay_id' => 7, 'customer_ref' => 8, 'mileage' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('user_subscription');
        $this->setPhpName('UserSubscription');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\UserSubscription');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('plan_id', 'PlanId', 'INTEGER', 'user_plan', 'value', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user_login', 'value', true, null, null);
        $this->addForeignKey('parish_id', 'ParishId', 'INTEGER', 'parish', 'value', true, null, null);
        $this->addColumn('status', 'Status', 'BOOLEAN', false, 1, null);
        $this->addColumn('start_date', 'StartDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('end_date', 'EndDate', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('pay_id', 'PayId', 'INTEGER', 'user_payment', 'value', false, null, null);
        $this->addColumn('customer_ref', 'CustomerRef', 'VARCHAR', true, 100, null);
        $this->addColumn('mileage', 'Mileage', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserLogin', '\\UserLogin', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('UserPlan', '\\UserPlan', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':plan_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('UserPayment', '\\UserPayment', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':pay_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('Parish', '\\Parish', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parish_id',
    1 => ':value',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UserSubscriptionTableMap::CLASS_DEFAULT : UserSubscriptionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (UserSubscription object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserSubscriptionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserSubscriptionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserSubscriptionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserSubscriptionTableMap::OM_CLASS;
            /** @var UserSubscription $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserSubscriptionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UserSubscriptionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserSubscriptionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UserSubscription $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserSubscriptionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_VALUE);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_PLAN_ID);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_USER_ID);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_PARISH_ID);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_STATUS);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_START_DATE);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_END_DATE);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_PAY_ID);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_CUSTOMER_REF);
            $criteria->addSelectColumn(UserSubscriptionTableMap::COL_MILEAGE);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.plan_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.parish_id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.start_date');
            $criteria->addSelectColumn($alias . '.end_date');
            $criteria->addSelectColumn($alias . '.pay_id');
            $criteria->addSelectColumn($alias . '.customer_ref');
            $criteria->addSelectColumn($alias . '.mileage');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UserSubscriptionTableMap::DATABASE_NAME)->getTable(UserSubscriptionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserSubscriptionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserSubscriptionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserSubscriptionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UserSubscription or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UserSubscription object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \UserSubscription) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserSubscriptionTableMap::DATABASE_NAME);
            $criteria->add(UserSubscriptionTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = UserSubscriptionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserSubscriptionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserSubscriptionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_subscription table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserSubscriptionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UserSubscription or Criteria object.
     *
     * @param mixed               $criteria Criteria or UserSubscription object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UserSubscription object
        }

        if ($criteria->containsKey(UserSubscriptionTableMap::COL_VALUE) && $criteria->keyContainsValue(UserSubscriptionTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserSubscriptionTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = UserSubscriptionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserSubscriptionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserSubscriptionTableMap::buildTableMap();
