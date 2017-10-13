<?php

namespace Map;

use \Pastor;
use \PastorQuery;
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
 * This class defines the structure of the 'pastor' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PastorTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PastorTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'pastor';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Pastor';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Pastor';

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
    const COL_VALUE = 'pastor.value';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'pastor.user_id';

    /**
     * the column name for the fname field
     */
    const COL_FNAME = 'pastor.fname';

    /**
     * the column name for the lname field
     */
    const COL_LNAME = 'pastor.lname';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'pastor.phone';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'pastor.email';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'pastor.comment';

    /**
     * the column name for the contact_date field
     */
    const COL_CONTACT_DATE = 'pastor.contact_date';

    /**
     * the column name for the contact_time field
     */
    const COL_CONTACT_TIME = 'pastor.contact_time';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'pastor.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'UserId', 'Fname', 'Lname', 'Phone', 'Email', 'Comment', 'ContactDate', 'ContactTime', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'userId', 'fname', 'lname', 'phone', 'email', 'comment', 'contactDate', 'contactTime', 'createdAt', ),
        self::TYPE_COLNAME       => array(PastorTableMap::COL_VALUE, PastorTableMap::COL_USER_ID, PastorTableMap::COL_FNAME, PastorTableMap::COL_LNAME, PastorTableMap::COL_PHONE, PastorTableMap::COL_EMAIL, PastorTableMap::COL_COMMENT, PastorTableMap::COL_CONTACT_DATE, PastorTableMap::COL_CONTACT_TIME, PastorTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'user_id', 'fname', 'lname', 'phone', 'email', 'comment', 'contact_date', 'contact_time', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'UserId' => 1, 'Fname' => 2, 'Lname' => 3, 'Phone' => 4, 'Email' => 5, 'Comment' => 6, 'ContactDate' => 7, 'ContactTime' => 8, 'CreatedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'userId' => 1, 'fname' => 2, 'lname' => 3, 'phone' => 4, 'email' => 5, 'comment' => 6, 'contactDate' => 7, 'contactTime' => 8, 'createdAt' => 9, ),
        self::TYPE_COLNAME       => array(PastorTableMap::COL_VALUE => 0, PastorTableMap::COL_USER_ID => 1, PastorTableMap::COL_FNAME => 2, PastorTableMap::COL_LNAME => 3, PastorTableMap::COL_PHONE => 4, PastorTableMap::COL_EMAIL => 5, PastorTableMap::COL_COMMENT => 6, PastorTableMap::COL_CONTACT_DATE => 7, PastorTableMap::COL_CONTACT_TIME => 8, PastorTableMap::COL_CREATED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'user_id' => 1, 'fname' => 2, 'lname' => 3, 'phone' => 4, 'email' => 5, 'comment' => 6, 'contact_date' => 7, 'contact_time' => 8, 'created_at' => 9, ),
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
        $this->setName('pastor');
        $this->setPhpName('Pastor');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Pastor');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user_profile', 'value', true, null, null);
        $this->addColumn('fname', 'Fname', 'VARCHAR', false, 50, null);
        $this->addColumn('lname', 'Lname', 'VARCHAR', false, 50, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 50, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 50, null);
        $this->addColumn('comment', 'Comment', 'LONGVARCHAR', false, null, null);
        $this->addColumn('contact_date', 'ContactDate', 'VARCHAR', false, 50, null);
        $this->addColumn('contact_time', 'ContactTime', 'VARCHAR', false, 50, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserProfile', '\\UserProfile', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
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
        return $withPrefix ? PastorTableMap::CLASS_DEFAULT : PastorTableMap::OM_CLASS;
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
     * @return array           (Pastor object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PastorTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PastorTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PastorTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PastorTableMap::OM_CLASS;
            /** @var Pastor $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PastorTableMap::addInstanceToPool($obj, $key);
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
            $key = PastorTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PastorTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Pastor $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PastorTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PastorTableMap::COL_VALUE);
            $criteria->addSelectColumn(PastorTableMap::COL_USER_ID);
            $criteria->addSelectColumn(PastorTableMap::COL_FNAME);
            $criteria->addSelectColumn(PastorTableMap::COL_LNAME);
            $criteria->addSelectColumn(PastorTableMap::COL_PHONE);
            $criteria->addSelectColumn(PastorTableMap::COL_EMAIL);
            $criteria->addSelectColumn(PastorTableMap::COL_COMMENT);
            $criteria->addSelectColumn(PastorTableMap::COL_CONTACT_DATE);
            $criteria->addSelectColumn(PastorTableMap::COL_CONTACT_TIME);
            $criteria->addSelectColumn(PastorTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.fname');
            $criteria->addSelectColumn($alias . '.lname');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.comment');
            $criteria->addSelectColumn($alias . '.contact_date');
            $criteria->addSelectColumn($alias . '.contact_time');
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
        return Propel::getServiceContainer()->getDatabaseMap(PastorTableMap::DATABASE_NAME)->getTable(PastorTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PastorTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PastorTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PastorTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Pastor or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Pastor object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PastorTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Pastor) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PastorTableMap::DATABASE_NAME);
            $criteria->add(PastorTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = PastorQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PastorTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PastorTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the pastor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PastorQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Pastor or Criteria object.
     *
     * @param mixed               $criteria Criteria or Pastor object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PastorTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Pastor object
        }

        if ($criteria->containsKey(PastorTableMap::COL_VALUE) && $criteria->keyContainsValue(PastorTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PastorTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = PastorQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PastorTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PastorTableMap::buildTableMap();
