<?php

namespace Map;

use \Messages;
use \MessagesQuery;
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
 * This class defines the structure of the 'messages' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MessagesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.MessagesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'messages';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Messages';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Messages';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'messages.value';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'messages.title';

    /**
     * the column name for the message field
     */
    const COL_MESSAGE = 'messages.message';

    /**
     * the column name for the payload field
     */
    const COL_PAYLOAD = 'messages.payload';

    /**
     * the column name for the group_id field
     */
    const COL_GROUP_ID = 'messages.group_id';

    /**
     * the column name for the scheduled_time field
     */
    const COL_SCHEDULED_TIME = 'messages.scheduled_time';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'messages.status';

    /**
     * the column name for the last_run field
     */
    const COL_LAST_RUN = 'messages.last_run';

    /**
     * the column name for the last_device_id field
     */
    const COL_LAST_DEVICE_ID = 'messages.last_device_id';

    /**
     * the column name for the locked_out field
     */
    const COL_LOCKED_OUT = 'messages.locked_out';

    /**
     * the column name for the locked_out_time field
     */
    const COL_LOCKED_OUT_TIME = 'messages.locked_out_time';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'messages.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'Title', 'Message', 'Payload', 'GroupId', 'ScheduledTime', 'Status', 'LastRun', 'LastDeviceId', 'LockedOut', 'LockedOutTime', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'title', 'message', 'payload', 'groupId', 'scheduledTime', 'status', 'lastRun', 'lastDeviceId', 'lockedOut', 'lockedOutTime', 'createdAt', ),
        self::TYPE_COLNAME       => array(MessagesTableMap::COL_VALUE, MessagesTableMap::COL_TITLE, MessagesTableMap::COL_MESSAGE, MessagesTableMap::COL_PAYLOAD, MessagesTableMap::COL_GROUP_ID, MessagesTableMap::COL_SCHEDULED_TIME, MessagesTableMap::COL_STATUS, MessagesTableMap::COL_LAST_RUN, MessagesTableMap::COL_LAST_DEVICE_ID, MessagesTableMap::COL_LOCKED_OUT, MessagesTableMap::COL_LOCKED_OUT_TIME, MessagesTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'title', 'message', 'payload', 'group_id', 'scheduled_time', 'status', 'last_run', 'last_device_id', 'locked_out', 'locked_out_time', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'Title' => 1, 'Message' => 2, 'Payload' => 3, 'GroupId' => 4, 'ScheduledTime' => 5, 'Status' => 6, 'LastRun' => 7, 'LastDeviceId' => 8, 'LockedOut' => 9, 'LockedOutTime' => 10, 'CreatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'title' => 1, 'message' => 2, 'payload' => 3, 'groupId' => 4, 'scheduledTime' => 5, 'status' => 6, 'lastRun' => 7, 'lastDeviceId' => 8, 'lockedOut' => 9, 'lockedOutTime' => 10, 'createdAt' => 11, ),
        self::TYPE_COLNAME       => array(MessagesTableMap::COL_VALUE => 0, MessagesTableMap::COL_TITLE => 1, MessagesTableMap::COL_MESSAGE => 2, MessagesTableMap::COL_PAYLOAD => 3, MessagesTableMap::COL_GROUP_ID => 4, MessagesTableMap::COL_SCHEDULED_TIME => 5, MessagesTableMap::COL_STATUS => 6, MessagesTableMap::COL_LAST_RUN => 7, MessagesTableMap::COL_LAST_DEVICE_ID => 8, MessagesTableMap::COL_LOCKED_OUT => 9, MessagesTableMap::COL_LOCKED_OUT_TIME => 10, MessagesTableMap::COL_CREATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'title' => 1, 'message' => 2, 'payload' => 3, 'group_id' => 4, 'scheduled_time' => 5, 'status' => 6, 'last_run' => 7, 'last_device_id' => 8, 'locked_out' => 9, 'locked_out_time' => 10, 'created_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('messages');
        $this->setPhpName('Messages');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Messages');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 200, null);
        $this->addColumn('message', 'Message', 'LONGVARCHAR', false, null, null);
        $this->addColumn('payload', 'Payload', 'LONGVARCHAR', false, null, null);
        $this->addForeignKey('group_id', 'GroupId', 'INTEGER', 'econnect', 'value', true, null, null);
        $this->addColumn('scheduled_time', 'ScheduledTime', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('status', 'Status', 'TINYINT', false, null, null);
        $this->addColumn('last_run', 'LastRun', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_device_id', 'LastDeviceId', 'INTEGER', false, null, null);
        $this->addColumn('locked_out', 'LockedOut', 'TINYINT', false, null, null);
        $this->addColumn('locked_out_time', 'LockedOutTime', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Econnect', '\\Econnect', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':group_id',
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
        return $withPrefix ? MessagesTableMap::CLASS_DEFAULT : MessagesTableMap::OM_CLASS;
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
     * @return array           (Messages object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MessagesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MessagesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MessagesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MessagesTableMap::OM_CLASS;
            /** @var Messages $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MessagesTableMap::addInstanceToPool($obj, $key);
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
            $key = MessagesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MessagesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Messages $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MessagesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MessagesTableMap::COL_VALUE);
            $criteria->addSelectColumn(MessagesTableMap::COL_TITLE);
            $criteria->addSelectColumn(MessagesTableMap::COL_MESSAGE);
            $criteria->addSelectColumn(MessagesTableMap::COL_PAYLOAD);
            $criteria->addSelectColumn(MessagesTableMap::COL_GROUP_ID);
            $criteria->addSelectColumn(MessagesTableMap::COL_SCHEDULED_TIME);
            $criteria->addSelectColumn(MessagesTableMap::COL_STATUS);
            $criteria->addSelectColumn(MessagesTableMap::COL_LAST_RUN);
            $criteria->addSelectColumn(MessagesTableMap::COL_LAST_DEVICE_ID);
            $criteria->addSelectColumn(MessagesTableMap::COL_LOCKED_OUT);
            $criteria->addSelectColumn(MessagesTableMap::COL_LOCKED_OUT_TIME);
            $criteria->addSelectColumn(MessagesTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.message');
            $criteria->addSelectColumn($alias . '.payload');
            $criteria->addSelectColumn($alias . '.group_id');
            $criteria->addSelectColumn($alias . '.scheduled_time');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.last_run');
            $criteria->addSelectColumn($alias . '.last_device_id');
            $criteria->addSelectColumn($alias . '.locked_out');
            $criteria->addSelectColumn($alias . '.locked_out_time');
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
        return Propel::getServiceContainer()->getDatabaseMap(MessagesTableMap::DATABASE_NAME)->getTable(MessagesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MessagesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MessagesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MessagesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Messages or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Messages object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Messages) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MessagesTableMap::DATABASE_NAME);
            $criteria->add(MessagesTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = MessagesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MessagesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MessagesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the messages table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MessagesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Messages or Criteria object.
     *
     * @param mixed               $criteria Criteria or Messages object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Messages object
        }

        if ($criteria->containsKey(MessagesTableMap::COL_VALUE) && $criteria->keyContainsValue(MessagesTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MessagesTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = MessagesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MessagesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MessagesTableMap::buildTableMap();
