<?php

namespace Map;

use \Give;
use \GiveQuery;
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
 * This class defines the structure of the 'give' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GiveTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GiveTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'give';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Give';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Give';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'give.value';

    /**
     * the column name for the profile_id field
     */
    const COL_PROFILE_ID = 'give.profile_id';

    /**
     * the column name for the parish_id field
     */
    const COL_PARISH_ID = 'give.parish_id';

    /**
     * the column name for the method_id field
     */
    const COL_METHOD_ID = 'give.method_id';

    /**
     * the column name for the currency field
     */
    const COL_CURRENCY = 'give.currency';

    /**
     * the column name for the total field
     */
    const COL_TOTAL = 'give.total';

    /**
     * the column name for the txn_ref field
     */
    const COL_TXN_REF = 'give.txn_ref';

    /**
     * the column name for the txn_status field
     */
    const COL_TXN_STATUS = 'give.txn_status';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'give.description';

    /**
     * the column name for the card_id field
     */
    const COL_CARD_ID = 'give.card_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'give.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'ProfileId', 'ParishId', 'MethodId', 'Currency', 'Total', 'TxnRef', 'TxnStatus', 'Description', 'CardId', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'profileId', 'parishId', 'methodId', 'currency', 'total', 'txnRef', 'txnStatus', 'description', 'cardId', 'createdAt', ),
        self::TYPE_COLNAME       => array(GiveTableMap::COL_VALUE, GiveTableMap::COL_PROFILE_ID, GiveTableMap::COL_PARISH_ID, GiveTableMap::COL_METHOD_ID, GiveTableMap::COL_CURRENCY, GiveTableMap::COL_TOTAL, GiveTableMap::COL_TXN_REF, GiveTableMap::COL_TXN_STATUS, GiveTableMap::COL_DESCRIPTION, GiveTableMap::COL_CARD_ID, GiveTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'profile_id', 'parish_id', 'method_id', 'currency', 'total', 'txn_ref', 'txn_status', 'description', 'card_id', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'ProfileId' => 1, 'ParishId' => 2, 'MethodId' => 3, 'Currency' => 4, 'Total' => 5, 'TxnRef' => 6, 'TxnStatus' => 7, 'Description' => 8, 'CardId' => 9, 'CreatedAt' => 10, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'profileId' => 1, 'parishId' => 2, 'methodId' => 3, 'currency' => 4, 'total' => 5, 'txnRef' => 6, 'txnStatus' => 7, 'description' => 8, 'cardId' => 9, 'createdAt' => 10, ),
        self::TYPE_COLNAME       => array(GiveTableMap::COL_VALUE => 0, GiveTableMap::COL_PROFILE_ID => 1, GiveTableMap::COL_PARISH_ID => 2, GiveTableMap::COL_METHOD_ID => 3, GiveTableMap::COL_CURRENCY => 4, GiveTableMap::COL_TOTAL => 5, GiveTableMap::COL_TXN_REF => 6, GiveTableMap::COL_TXN_STATUS => 7, GiveTableMap::COL_DESCRIPTION => 8, GiveTableMap::COL_CARD_ID => 9, GiveTableMap::COL_CREATED_AT => 10, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'profile_id' => 1, 'parish_id' => 2, 'method_id' => 3, 'currency' => 4, 'total' => 5, 'txn_ref' => 6, 'txn_status' => 7, 'description' => 8, 'card_id' => 9, 'created_at' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('give');
        $this->setPhpName('Give');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Give');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('profile_id', 'ProfileId', 'INTEGER', 'user_profile', 'value', true, null, null);
        $this->addForeignKey('parish_id', 'ParishId', 'INTEGER', 'parish', 'value', true, null, null);
        $this->addForeignKey('method_id', 'MethodId', 'INTEGER', 'give_parish_methods', 'value', true, null, null);
        $this->addColumn('currency', 'Currency', 'VARCHAR', true, 20, null);
        $this->addColumn('total', 'Total', 'DECIMAL', true, 10, null);
        $this->addColumn('txn_ref', 'TxnRef', 'VARCHAR', false, 200, null);
        $this->addColumn('txn_status', 'TxnStatus', 'VARCHAR', false, 200, null);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 250, null);
        $this->addColumn('card_id', 'CardId', 'VARCHAR', false, 20, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Parish', '\\Parish', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parish_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('UserProfile', '\\UserProfile', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':profile_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('GiveParishMethods', '\\GiveParishMethods', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':method_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('GiveSplit', '\\GiveSplit', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':give_id',
    1 => ':value',
  ),
), null, null, 'GiveSplits', false);
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
        return $withPrefix ? GiveTableMap::CLASS_DEFAULT : GiveTableMap::OM_CLASS;
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
     * @return array           (Give object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GiveTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GiveTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GiveTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GiveTableMap::OM_CLASS;
            /** @var Give $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GiveTableMap::addInstanceToPool($obj, $key);
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
            $key = GiveTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GiveTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Give $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GiveTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GiveTableMap::COL_VALUE);
            $criteria->addSelectColumn(GiveTableMap::COL_PROFILE_ID);
            $criteria->addSelectColumn(GiveTableMap::COL_PARISH_ID);
            $criteria->addSelectColumn(GiveTableMap::COL_METHOD_ID);
            $criteria->addSelectColumn(GiveTableMap::COL_CURRENCY);
            $criteria->addSelectColumn(GiveTableMap::COL_TOTAL);
            $criteria->addSelectColumn(GiveTableMap::COL_TXN_REF);
            $criteria->addSelectColumn(GiveTableMap::COL_TXN_STATUS);
            $criteria->addSelectColumn(GiveTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(GiveTableMap::COL_CARD_ID);
            $criteria->addSelectColumn(GiveTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.profile_id');
            $criteria->addSelectColumn($alias . '.parish_id');
            $criteria->addSelectColumn($alias . '.method_id');
            $criteria->addSelectColumn($alias . '.currency');
            $criteria->addSelectColumn($alias . '.total');
            $criteria->addSelectColumn($alias . '.txn_ref');
            $criteria->addSelectColumn($alias . '.txn_status');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.card_id');
            $criteria->addSelectColumn($alias . '.created_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(GiveTableMap::DATABASE_NAME)->getTable(GiveTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GiveTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GiveTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GiveTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Give or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Give object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Give) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GiveTableMap::DATABASE_NAME);
            $criteria->add(GiveTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = GiveQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GiveTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GiveTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the give table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GiveQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Give or Criteria object.
     *
     * @param mixed               $criteria Criteria or Give object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Give object
        }

        if ($criteria->containsKey(GiveTableMap::COL_VALUE) && $criteria->keyContainsValue(GiveTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GiveTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = GiveQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GiveTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GiveTableMap::buildTableMap();
