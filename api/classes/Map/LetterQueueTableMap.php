<?php

namespace Map;

use \LetterQueue;
use \LetterQueueQuery;
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
 * This class defines the structure of the 'letter_queue' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LetterQueueTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.LetterQueueTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'letter_queue';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\LetterQueue';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'LetterQueue';

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
    const COL_VALUE = 'letter_queue.value';

    /**
     * the column name for the job_id field
     */
    const COL_JOB_ID = 'letter_queue.job_id';

    /**
     * the column name for the subject field
     */
    const COL_SUBJECT = 'letter_queue.subject';

    /**
     * the column name for the message field
     */
    const COL_MESSAGE = 'letter_queue.message';

    /**
     * the column name for the from_name field
     */
    const COL_FROM_NAME = 'letter_queue.from_name';

    /**
     * the column name for the from_email field
     */
    const COL_FROM_EMAIL = 'letter_queue.from_email';

    /**
     * the column name for the to_name field
     */
    const COL_TO_NAME = 'letter_queue.to_name';

    /**
     * the column name for the to_email field
     */
    const COL_TO_EMAIL = 'letter_queue.to_email';

    /**
     * the column name for the count field
     */
    const COL_COUNT = 'letter_queue.count';

    /**
     * the column name for the last_status_msg field
     */
    const COL_LAST_STATUS_MSG = 'letter_queue.last_status_msg';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'letter_queue.status';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'letter_queue.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'JobId', 'Subject', 'Message', 'FromName', 'FromEmail', 'ToName', 'ToEmail', 'Count', 'LastStatusMsg', 'Status', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'jobId', 'subject', 'message', 'fromName', 'fromEmail', 'toName', 'toEmail', 'count', 'lastStatusMsg', 'status', 'createdAt', ),
        self::TYPE_COLNAME       => array(LetterQueueTableMap::COL_VALUE, LetterQueueTableMap::COL_JOB_ID, LetterQueueTableMap::COL_SUBJECT, LetterQueueTableMap::COL_MESSAGE, LetterQueueTableMap::COL_FROM_NAME, LetterQueueTableMap::COL_FROM_EMAIL, LetterQueueTableMap::COL_TO_NAME, LetterQueueTableMap::COL_TO_EMAIL, LetterQueueTableMap::COL_COUNT, LetterQueueTableMap::COL_LAST_STATUS_MSG, LetterQueueTableMap::COL_STATUS, LetterQueueTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'job_id', 'subject', 'message', 'from_name', 'from_email', 'to_name', 'to_email', 'count', 'last_status_msg', 'status', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'JobId' => 1, 'Subject' => 2, 'Message' => 3, 'FromName' => 4, 'FromEmail' => 5, 'ToName' => 6, 'ToEmail' => 7, 'Count' => 8, 'LastStatusMsg' => 9, 'Status' => 10, 'CreatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'jobId' => 1, 'subject' => 2, 'message' => 3, 'fromName' => 4, 'fromEmail' => 5, 'toName' => 6, 'toEmail' => 7, 'count' => 8, 'lastStatusMsg' => 9, 'status' => 10, 'createdAt' => 11, ),
        self::TYPE_COLNAME       => array(LetterQueueTableMap::COL_VALUE => 0, LetterQueueTableMap::COL_JOB_ID => 1, LetterQueueTableMap::COL_SUBJECT => 2, LetterQueueTableMap::COL_MESSAGE => 3, LetterQueueTableMap::COL_FROM_NAME => 4, LetterQueueTableMap::COL_FROM_EMAIL => 5, LetterQueueTableMap::COL_TO_NAME => 6, LetterQueueTableMap::COL_TO_EMAIL => 7, LetterQueueTableMap::COL_COUNT => 8, LetterQueueTableMap::COL_LAST_STATUS_MSG => 9, LetterQueueTableMap::COL_STATUS => 10, LetterQueueTableMap::COL_CREATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'job_id' => 1, 'subject' => 2, 'message' => 3, 'from_name' => 4, 'from_email' => 5, 'to_name' => 6, 'to_email' => 7, 'count' => 8, 'last_status_msg' => 9, 'status' => 10, 'created_at' => 11, ),
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
        $this->setName('letter_queue');
        $this->setPhpName('LetterQueue');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\LetterQueue');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('job_id', 'JobId', 'INTEGER', 'job_queue', 'value', true, null, null);
        $this->addColumn('subject', 'Subject', 'VARCHAR', true, 200, null);
        $this->addColumn('message', 'Message', 'LONGVARCHAR', true, null, null);
        $this->addColumn('from_name', 'FromName', 'VARCHAR', true, 100, null);
        $this->addColumn('from_email', 'FromEmail', 'VARCHAR', true, 100, null);
        $this->addColumn('to_name', 'ToName', 'VARCHAR', true, 200, null);
        $this->addColumn('to_email', 'ToEmail', 'VARCHAR', true, 100, null);
        $this->addColumn('count', 'Count', 'INTEGER', false, null, 0);
        $this->addColumn('last_status_msg', 'LastStatusMsg', 'VARCHAR', false, 200, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 100, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JobQueue', '\\JobQueue', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':job_id',
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
        return $withPrefix ? LetterQueueTableMap::CLASS_DEFAULT : LetterQueueTableMap::OM_CLASS;
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
     * @return array           (LetterQueue object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LetterQueueTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LetterQueueTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LetterQueueTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LetterQueueTableMap::OM_CLASS;
            /** @var LetterQueue $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LetterQueueTableMap::addInstanceToPool($obj, $key);
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
            $key = LetterQueueTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LetterQueueTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var LetterQueue $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LetterQueueTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(LetterQueueTableMap::COL_VALUE);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_JOB_ID);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_SUBJECT);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_MESSAGE);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_FROM_NAME);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_FROM_EMAIL);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_TO_NAME);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_TO_EMAIL);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_COUNT);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_LAST_STATUS_MSG);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_STATUS);
            $criteria->addSelectColumn(LetterQueueTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.job_id');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.message');
            $criteria->addSelectColumn($alias . '.from_name');
            $criteria->addSelectColumn($alias . '.from_email');
            $criteria->addSelectColumn($alias . '.to_name');
            $criteria->addSelectColumn($alias . '.to_email');
            $criteria->addSelectColumn($alias . '.count');
            $criteria->addSelectColumn($alias . '.last_status_msg');
            $criteria->addSelectColumn($alias . '.status');
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
        return Propel::getServiceContainer()->getDatabaseMap(LetterQueueTableMap::DATABASE_NAME)->getTable(LetterQueueTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(LetterQueueTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(LetterQueueTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new LetterQueueTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a LetterQueue or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or LetterQueue object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LetterQueueTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \LetterQueue) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LetterQueueTableMap::DATABASE_NAME);
            $criteria->add(LetterQueueTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = LetterQueueQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            LetterQueueTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                LetterQueueTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the letter_queue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LetterQueueQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a LetterQueue or Criteria object.
     *
     * @param mixed               $criteria Criteria or LetterQueue object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LetterQueueTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from LetterQueue object
        }

        if ($criteria->containsKey(LetterQueueTableMap::COL_VALUE) && $criteria->keyContainsValue(LetterQueueTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LetterQueueTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = LetterQueueQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // LetterQueueTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LetterQueueTableMap::buildTableMap();
