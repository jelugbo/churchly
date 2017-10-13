<?php

namespace Map;

use \UserProfile;
use \UserProfileQuery;
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
 * This class defines the structure of the 'user_profile' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserProfileTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UserProfileTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user_profile';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\UserProfile';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'UserProfile';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'user_profile.value';

    /**
     * the column name for the parish_id field
     */
    const COL_PARISH_ID = 'user_profile.parish_id';

    /**
     * the column name for the fname field
     */
    const COL_FNAME = 'user_profile.fname';

    /**
     * the column name for the lname field
     */
    const COL_LNAME = 'user_profile.lname';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'user_profile.address';

    /**
     * the column name for the city field
     */
    const COL_CITY = 'user_profile.city';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'user_profile.state';

    /**
     * the column name for the zip field
     */
    const COL_ZIP = 'user_profile.zip';

    /**
     * the column name for the country field
     */
    const COL_COUNTRY = 'user_profile.country';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'user_profile.phone';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'user_profile.email';

    /**
     * the column name for the dob field
     */
    const COL_DOB = 'user_profile.dob';

    /**
     * the column name for the married field
     */
    const COL_MARRIED = 'user_profile.married';

    /**
     * the column name for the wedding field
     */
    const COL_WEDDING = 'user_profile.wedding';

    /**
     * the column name for the push_id field
     */
    const COL_PUSH_ID = 'user_profile.push_id';

    /**
     * the column name for the platform field
     */
    const COL_PLATFORM = 'user_profile.platform';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'user_profile.created_at';

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
        self::TYPE_PHPNAME       => array('Value', 'ParishId', 'Fname', 'Lname', 'Address', 'City', 'State', 'Zip', 'Country', 'Phone', 'Email', 'Dob', 'Married', 'Wedding', 'PushId', 'Platform', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('value', 'parishId', 'fname', 'lname', 'address', 'city', 'state', 'zip', 'country', 'phone', 'email', 'dob', 'married', 'wedding', 'pushId', 'platform', 'createdAt', ),
        self::TYPE_COLNAME       => array(UserProfileTableMap::COL_VALUE, UserProfileTableMap::COL_PARISH_ID, UserProfileTableMap::COL_FNAME, UserProfileTableMap::COL_LNAME, UserProfileTableMap::COL_ADDRESS, UserProfileTableMap::COL_CITY, UserProfileTableMap::COL_STATE, UserProfileTableMap::COL_ZIP, UserProfileTableMap::COL_COUNTRY, UserProfileTableMap::COL_PHONE, UserProfileTableMap::COL_EMAIL, UserProfileTableMap::COL_DOB, UserProfileTableMap::COL_MARRIED, UserProfileTableMap::COL_WEDDING, UserProfileTableMap::COL_PUSH_ID, UserProfileTableMap::COL_PLATFORM, UserProfileTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('value', 'parish_id', 'fname', 'lname', 'address', 'city', 'state', 'zip', 'country', 'phone', 'email', 'dob', 'married', 'wedding', 'push_id', 'platform', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Value' => 0, 'ParishId' => 1, 'Fname' => 2, 'Lname' => 3, 'Address' => 4, 'City' => 5, 'State' => 6, 'Zip' => 7, 'Country' => 8, 'Phone' => 9, 'Email' => 10, 'Dob' => 11, 'Married' => 12, 'Wedding' => 13, 'PushId' => 14, 'Platform' => 15, 'CreatedAt' => 16, ),
        self::TYPE_CAMELNAME     => array('value' => 0, 'parishId' => 1, 'fname' => 2, 'lname' => 3, 'address' => 4, 'city' => 5, 'state' => 6, 'zip' => 7, 'country' => 8, 'phone' => 9, 'email' => 10, 'dob' => 11, 'married' => 12, 'wedding' => 13, 'pushId' => 14, 'platform' => 15, 'createdAt' => 16, ),
        self::TYPE_COLNAME       => array(UserProfileTableMap::COL_VALUE => 0, UserProfileTableMap::COL_PARISH_ID => 1, UserProfileTableMap::COL_FNAME => 2, UserProfileTableMap::COL_LNAME => 3, UserProfileTableMap::COL_ADDRESS => 4, UserProfileTableMap::COL_CITY => 5, UserProfileTableMap::COL_STATE => 6, UserProfileTableMap::COL_ZIP => 7, UserProfileTableMap::COL_COUNTRY => 8, UserProfileTableMap::COL_PHONE => 9, UserProfileTableMap::COL_EMAIL => 10, UserProfileTableMap::COL_DOB => 11, UserProfileTableMap::COL_MARRIED => 12, UserProfileTableMap::COL_WEDDING => 13, UserProfileTableMap::COL_PUSH_ID => 14, UserProfileTableMap::COL_PLATFORM => 15, UserProfileTableMap::COL_CREATED_AT => 16, ),
        self::TYPE_FIELDNAME     => array('value' => 0, 'parish_id' => 1, 'fname' => 2, 'lname' => 3, 'address' => 4, 'city' => 5, 'state' => 6, 'zip' => 7, 'country' => 8, 'phone' => 9, 'email' => 10, 'dob' => 11, 'married' => 12, 'wedding' => 13, 'push_id' => 14, 'platform' => 15, 'created_at' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
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
        $this->setName('user_profile');
        $this->setPhpName('UserProfile');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\UserProfile');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('value', 'Value', 'INTEGER', true, null, null);
        $this->addForeignKey('parish_id', 'ParishId', 'INTEGER', 'parish', 'value', true, null, null);
        $this->addColumn('fname', 'Fname', 'VARCHAR', false, 50, null);
        $this->addColumn('lname', 'Lname', 'VARCHAR', false, 50, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 200, null);
        $this->addColumn('city', 'City', 'VARCHAR', false, 50, null);
        $this->addColumn('state', 'State', 'VARCHAR', false, 50, null);
        $this->addColumn('zip', 'Zip', 'VARCHAR', false, 20, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 50, 'USA');
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 20, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 50, null);
        $this->addColumn('dob', 'Dob', 'VARCHAR', false, 50, null);
        $this->addColumn('married', 'Married', 'BOOLEAN', true, 1, null);
        $this->addColumn('wedding', 'Wedding', 'VARCHAR', false, 50, null);
        $this->addColumn('push_id', 'PushId', 'VARCHAR', true, 250, null);
        $this->addColumn('platform', 'Platform', 'VARCHAR', true, 50, null);
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
        $this->addRelation('Give', '\\Give', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':profile_id',
    1 => ':value',
  ),
), null, null, 'Gives', false);
        $this->addRelation('Pastor', '\\Pastor', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':value',
  ),
), null, null, 'Pastors', false);
        $this->addRelation('Prayer', '\\Prayer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':value',
  ),
), null, null, 'Prayers', false);
        $this->addRelation('PushRegister', '\\PushRegister', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':value',
  ),
), null, null, 'PushRegisters', false);
        $this->addRelation('Testimonials', '\\Testimonials', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':value',
  ),
), null, null, 'Testimonialss', false);
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
        return $withPrefix ? UserProfileTableMap::CLASS_DEFAULT : UserProfileTableMap::OM_CLASS;
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
     * @return array           (UserProfile object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserProfileTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserProfileTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserProfileTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserProfileTableMap::OM_CLASS;
            /** @var UserProfile $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserProfileTableMap::addInstanceToPool($obj, $key);
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
            $key = UserProfileTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserProfileTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UserProfile $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserProfileTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserProfileTableMap::COL_VALUE);
            $criteria->addSelectColumn(UserProfileTableMap::COL_PARISH_ID);
            $criteria->addSelectColumn(UserProfileTableMap::COL_FNAME);
            $criteria->addSelectColumn(UserProfileTableMap::COL_LNAME);
            $criteria->addSelectColumn(UserProfileTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(UserProfileTableMap::COL_CITY);
            $criteria->addSelectColumn(UserProfileTableMap::COL_STATE);
            $criteria->addSelectColumn(UserProfileTableMap::COL_ZIP);
            $criteria->addSelectColumn(UserProfileTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(UserProfileTableMap::COL_PHONE);
            $criteria->addSelectColumn(UserProfileTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UserProfileTableMap::COL_DOB);
            $criteria->addSelectColumn(UserProfileTableMap::COL_MARRIED);
            $criteria->addSelectColumn(UserProfileTableMap::COL_WEDDING);
            $criteria->addSelectColumn(UserProfileTableMap::COL_PUSH_ID);
            $criteria->addSelectColumn(UserProfileTableMap::COL_PLATFORM);
            $criteria->addSelectColumn(UserProfileTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.parish_id');
            $criteria->addSelectColumn($alias . '.fname');
            $criteria->addSelectColumn($alias . '.lname');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.zip');
            $criteria->addSelectColumn($alias . '.country');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.dob');
            $criteria->addSelectColumn($alias . '.married');
            $criteria->addSelectColumn($alias . '.wedding');
            $criteria->addSelectColumn($alias . '.push_id');
            $criteria->addSelectColumn($alias . '.platform');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserProfileTableMap::DATABASE_NAME)->getTable(UserProfileTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserProfileTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserProfileTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserProfileTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UserProfile or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UserProfile object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \UserProfile) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserProfileTableMap::DATABASE_NAME);
            $criteria->add(UserProfileTableMap::COL_VALUE, (array) $values, Criteria::IN);
        }

        $query = UserProfileQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserProfileTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserProfileTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_profile table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserProfileQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UserProfile or Criteria object.
     *
     * @param mixed               $criteria Criteria or UserProfile object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UserProfile object
        }

        if ($criteria->containsKey(UserProfileTableMap::COL_VALUE) && $criteria->keyContainsValue(UserProfileTableMap::COL_VALUE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserProfileTableMap::COL_VALUE.')');
        }


        // Set the correct dbName
        $query = UserProfileQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserProfileTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserProfileTableMap::buildTableMap();
