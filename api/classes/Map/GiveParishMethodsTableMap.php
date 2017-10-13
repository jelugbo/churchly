<?php

namespace Map;

use \GiveParishMethods;
use \GiveParishMethodsQuery;
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
 * This class defines the structure of the 'give_parish_methods' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GiveParishMethodsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GiveParishMethodsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'give_parish_methods';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GiveParishMethods';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GiveParishMethods';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'give_parish_methods.value';

    /**
     * the column name for the parish_id field
     */
    const COL_PARISH_ID = 'give_parish_methods.parish_id';

    /**
     * the column name for the method_id field
     */
    const COL_METHOD_ID = 'give_parish_methods.method_id';

    /**
     * the column name for the settings field
     */
    const COL_SETTINGS = 'give_parish_methods.settings';

    /**
     * the column name for the enabled field
     */
    const COL_ENABLED = 'give_parish_methods.enabled';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'give_parish_methods.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'ParishId', 'MethodId', 'Settings', 'Enabled', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'parishId', 'methodId', 'settings', 'enabled', 'createdAt', ),
        self::TYPE_COLNAME       => array(GiveParishMethodsTableMap::COL_VALUE, GiveParishMethodsTableMap::COL_PARISH_ID, GiveParishMethodsTableMap::COL_METHOD_ID, GiveParishMethodsTableMap::COL_SETTINGS, GiveParishMethodsTableMap::COL_ENABLED, GiveParishMethodsTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'parish_id', 'method_id', 'settings', 'enabled', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'ParishId' => 1, 'MethodId' => 2, 'Settings' => 3, 'Enabled' => 4, 'CreatedAt' => 5, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'parishId' => 1, 'methodId' => 2, 'settings' => 3, 'enabled' => 4, 'createdAt' => 5, ),
        self::TYPE_COLNAME       => array(GiveParishMethodsTableMap::COL_VALUE => 0, GiveParishMethodsTableMap::COL_PARISH_ID => 1, GiveParishMethodsTableMap::COL_METHOD_ID => 2, GiveParishMethodsTableMap::COL_SETTINGS => 3, GiveParishMethodsTableMap::COL_ENABLED => 4, GiveParishMethodsTableMap::COL_CREATED_AT => 5, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'parish_id' => 1, 'method_id' => 2, 'settings' => 3, 'enabled' => 4, 'created_at' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('give_parish_methods');
        $this->setPhpName('GiveParishMethods');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GiveParishMethods');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('parish_id', 'ParishId', 'INTEGER', 'parish', 'value', true, null, null);
        $this->addForeignKey('method_id', 'MethodId', 'INTEGER', 'give_methods', 'value', true, null, null);
        $this->addColumn('settings', 'Settings', 'VARCHAR', true, 250, null);
        $this->addColumn('enabled', 'Enabled', 'TINYINT', true, null, 1);
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
        $this->addRelation('GiveMethods', '\\GiveMethods', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':method_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('Give', '\\Give', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':method_id',
    1 => ':value',
  ),
), null, null, 'Gives', false);
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
        return $withPrefix ? GiveParishMethodsTableMap::CLASS_DEFAULT : GiveParishMethodsTableMap::OM_CLASS;
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
     * @return array           (GiveParishMethods object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GiveParishMethodsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GiveParishMethodsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GiveParishMethodsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GiveParishMethodsTableMap::OM_CLASS;
            /** @var GiveParishMethods $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GiveParishMethodsTableMap::addInstanceToPool($obj, $key);
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
            $key = GiveParishMethodsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GiveParishMethodsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var GiveParishMethods $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GiveParishMethodsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_VALUE);
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_PARISH_ID);
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_METHOD_ID);
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_SETTINGS);
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_ENABLED);
            $criteria->addSelectColumn(GiveParishMethodsTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.parish_id');
            $criteria->addSelectColumn($alias . '.method_id');
            $criteria->addSelectColumn($alias . '.settings');
            $criteria->addSelectColumn($alias . '.enabled');
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
        return Propel::getServiceContainer()->getDatabaseMap(GiveParishMethodsTableMap::DATABASE_NAME)->getTable(GiveParishMethodsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GiveParishMethodsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GiveParishMethodsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GiveParishMethodsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a GiveParishMethods or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or GiveParishMethods object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GiveParishMethodsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GiveParishMethods) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GiveParishMethodsTableMap::DATABASE_NAME);
            $criteria->add(GiveParishMethodsTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = GiveParishMethodsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GiveParishMethodsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GiveParishMethodsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the give_parish_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GiveParishMethodsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a GiveParishMethods or Criteria object.
     *
     * @param mixed               $criteria Criteria or GiveParishMethods object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveParishMethodsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from GiveParishMethods object
        }

        if ($criteria->containsKey(GiveParishMethodsTableMap::COL_VALUE) && $criteria->keyContainsValue(GiveParishMethodsTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GiveParishMethodsTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = GiveParishMethodsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GiveParishMethodsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GiveParishMethodsTableMap::buildTableMap();
