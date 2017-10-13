<?php

namespace Map;

use \Letters;
use \LettersQuery;
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
 * This class defines the structure of the 'letters' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LettersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.LettersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'letters';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Letters';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Letters';

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
    const COL_VALUE = 'letters.value';

    /**
     * the column name for the parish_id field
     */
    const COL_PARISH_ID = 'letters.parish_id';

    /**
     * the column name for the type_id field
     */
    const COL_TYPE_ID = 'letters.type_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'letters.name';

    /**
     * the column name for the sender_name field
     */
    const COL_SENDER_NAME = 'letters.sender_name';

    /**
     * the column name for the sender_email field
     */
    const COL_SENDER_EMAIL = 'letters.sender_email';

    /**
     * the column name for the subject field
     */
    const COL_SUBJECT = 'letters.subject';

    /**
     * the column name for the letter field
     */
    const COL_LETTER = 'letters.letter';

    /**
     * the column name for the published field
     */
    const COL_PUBLISHED = 'letters.published';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'letters.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'ParishId', 'TypeId', 'Name', 'SenderName', 'SenderEmail', 'Subject', 'Letter', 'Published', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'parishId', 'typeId', 'name', 'senderName', 'senderEmail', 'subject', 'letter', 'published', 'createdAt', ),
        self::TYPE_COLNAME       => array(LettersTableMap::COL_VALUE, LettersTableMap::COL_PARISH_ID, LettersTableMap::COL_TYPE_ID, LettersTableMap::COL_NAME, LettersTableMap::COL_SENDER_NAME, LettersTableMap::COL_SENDER_EMAIL, LettersTableMap::COL_SUBJECT, LettersTableMap::COL_LETTER, LettersTableMap::COL_PUBLISHED, LettersTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'parish_id', 'type_id', 'name', 'sender_name', 'sender_email', 'subject', 'letter', 'published', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'ParishId' => 1, 'TypeId' => 2, 'Name' => 3, 'SenderName' => 4, 'SenderEmail' => 5, 'Subject' => 6, 'Letter' => 7, 'Published' => 8, 'CreatedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'parishId' => 1, 'typeId' => 2, 'name' => 3, 'senderName' => 4, 'senderEmail' => 5, 'subject' => 6, 'letter' => 7, 'published' => 8, 'createdAt' => 9, ),
        self::TYPE_COLNAME       => array(LettersTableMap::COL_VALUE => 0, LettersTableMap::COL_PARISH_ID => 1, LettersTableMap::COL_TYPE_ID => 2, LettersTableMap::COL_NAME => 3, LettersTableMap::COL_SENDER_NAME => 4, LettersTableMap::COL_SENDER_EMAIL => 5, LettersTableMap::COL_SUBJECT => 6, LettersTableMap::COL_LETTER => 7, LettersTableMap::COL_PUBLISHED => 8, LettersTableMap::COL_CREATED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'parish_id' => 1, 'type_id' => 2, 'name' => 3, 'sender_name' => 4, 'sender_email' => 5, 'subject' => 6, 'letter' => 7, 'published' => 8, 'created_at' => 9, ),
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
        $this->setName('letters');
        $this->setPhpName('Letters');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Letters');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('parish_id', 'ParishId', 'INTEGER', 'parish', 'value', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'letter_type', 'value', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 250, null);
        $this->addColumn('sender_name', 'SenderName', 'VARCHAR', true, 100, null);
        $this->addColumn('sender_email', 'SenderEmail', 'VARCHAR', true, 100, null);
        $this->addColumn('subject', 'Subject', 'VARCHAR', true, 250, null);
        $this->addColumn('letter', 'Letter', 'LONGVARCHAR', true, null, null);
        $this->addColumn('published', 'Published', 'BOOLEAN', true, 1, true);
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
        $this->addRelation('LetterType', '\\LetterType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':type_id',
    1 => ':value',
  ),
), null, null, null, false);
        $this->addRelation('JobQueue', '\\JobQueue', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':letter_id',
    1 => ':value',
  ),
), null, null, 'JobQueues', false);
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
        return $withPrefix ? LettersTableMap::CLASS_DEFAULT : LettersTableMap::OM_CLASS;
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
     * @return array           (Letters object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LettersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LettersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LettersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LettersTableMap::OM_CLASS;
            /** @var Letters $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LettersTableMap::addInstanceToPool($obj, $key);
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
            $key = LettersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LettersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Letters $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LettersTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(LettersTableMap::COL_VALUE);
            $criteria->addSelectColumn(LettersTableMap::COL_PARISH_ID);
            $criteria->addSelectColumn(LettersTableMap::COL_TYPE_ID);
            $criteria->addSelectColumn(LettersTableMap::COL_NAME);
            $criteria->addSelectColumn(LettersTableMap::COL_SENDER_NAME);
            $criteria->addSelectColumn(LettersTableMap::COL_SENDER_EMAIL);
            $criteria->addSelectColumn(LettersTableMap::COL_SUBJECT);
            $criteria->addSelectColumn(LettersTableMap::COL_LETTER);
            $criteria->addSelectColumn(LettersTableMap::COL_PUBLISHED);
            $criteria->addSelectColumn(LettersTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.parish_id');
            $criteria->addSelectColumn($alias . '.type_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.sender_name');
            $criteria->addSelectColumn($alias . '.sender_email');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.letter');
            $criteria->addSelectColumn($alias . '.published');
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
        return Propel::getServiceContainer()->getDatabaseMap(LettersTableMap::DATABASE_NAME)->getTable(LettersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(LettersTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(LettersTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new LettersTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Letters or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Letters object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LettersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Letters) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LettersTableMap::DATABASE_NAME);
            $criteria->add(LettersTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = LettersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            LettersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                LettersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the letters table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LettersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Letters or Criteria object.
     *
     * @param mixed               $criteria Criteria or Letters object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LettersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Letters object
        }

        if ($criteria->containsKey(LettersTableMap::COL_VALUE) && $criteria->keyContainsValue(LettersTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LettersTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = LettersQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // LettersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LettersTableMap::buildTableMap();
