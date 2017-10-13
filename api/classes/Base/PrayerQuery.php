<?php

namespace Base;

use \Prayer as ChildPrayer;
use \PrayerQuery as ChildPrayerQuery;
use \Exception;
use \PDO;
use Map\PrayerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'prayer' table.
 *
 * 
 *
 * @method     ChildPrayerQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildPrayerQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPrayerQuery orderByFullName($order = Criteria::ASC) Order by the full_name column
 * @method     ChildPrayerQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildPrayerQuery orderByPrayer($order = Criteria::ASC) Order by the prayer column
 * @method     ChildPrayerQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildPrayerQuery groupByValue() Group by the value column
 * @method     ChildPrayerQuery groupByUserId() Group by the user_id column
 * @method     ChildPrayerQuery groupByFullName() Group by the full_name column
 * @method     ChildPrayerQuery groupByEmail() Group by the email column
 * @method     ChildPrayerQuery groupByPrayer() Group by the prayer column
 * @method     ChildPrayerQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildPrayerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPrayerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPrayerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPrayerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPrayerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPrayerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPrayerQuery leftJoinUserProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserProfile relation
 * @method     ChildPrayerQuery rightJoinUserProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserProfile relation
 * @method     ChildPrayerQuery innerJoinUserProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the UserProfile relation
 *
 * @method     ChildPrayerQuery joinWithUserProfile($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserProfile relation
 *
 * @method     ChildPrayerQuery leftJoinWithUserProfile() Adds a LEFT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildPrayerQuery rightJoinWithUserProfile() Adds a RIGHT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildPrayerQuery innerJoinWithUserProfile() Adds a INNER JOIN clause and with to the query using the UserProfile relation
 *
 * @method     \UserProfileQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPrayer findOne(ConnectionInterface $con = null) Return the first ChildPrayer matching the query
 * @method     ChildPrayer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPrayer matching the query, or a new ChildPrayer object populated from the query conditions when no match is found
 *
 * @method     ChildPrayer findOneByValue(int $value) Return the first ChildPrayer filtered by the value column
 * @method     ChildPrayer findOneByUserId(int $user_id) Return the first ChildPrayer filtered by the user_id column
 * @method     ChildPrayer findOneByFullName(string $full_name) Return the first ChildPrayer filtered by the full_name column
 * @method     ChildPrayer findOneByEmail(string $email) Return the first ChildPrayer filtered by the email column
 * @method     ChildPrayer findOneByPrayer(string $prayer) Return the first ChildPrayer filtered by the prayer column
 * @method     ChildPrayer findOneByCreatedAt(string $created_at) Return the first ChildPrayer filtered by the created_at column *

 * @method     ChildPrayer requirePk($key, ConnectionInterface $con = null) Return the ChildPrayer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOne(ConnectionInterface $con = null) Return the first ChildPrayer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrayer requireOneByValue(int $value) Return the first ChildPrayer filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOneByUserId(int $user_id) Return the first ChildPrayer filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOneByFullName(string $full_name) Return the first ChildPrayer filtered by the full_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOneByEmail(string $email) Return the first ChildPrayer filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOneByPrayer(string $prayer) Return the first ChildPrayer filtered by the prayer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrayer requireOneByCreatedAt(string $created_at) Return the first ChildPrayer filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrayer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPrayer objects based on current ModelCriteria
 * @method     ChildPrayer[]|ObjectCollection findByValue(int $value) Return ChildPrayer objects filtered by the value column
 * @method     ChildPrayer[]|ObjectCollection findByUserId(int $user_id) Return ChildPrayer objects filtered by the user_id column
 * @method     ChildPrayer[]|ObjectCollection findByFullName(string $full_name) Return ChildPrayer objects filtered by the full_name column
 * @method     ChildPrayer[]|ObjectCollection findByEmail(string $email) Return ChildPrayer objects filtered by the email column
 * @method     ChildPrayer[]|ObjectCollection findByPrayer(string $prayer) Return ChildPrayer objects filtered by the prayer column
 * @method     ChildPrayer[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPrayer objects filtered by the created_at column
 * @method     ChildPrayer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PrayerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PrayerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Prayer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPrayerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPrayerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPrayerQuery) {
            return $criteria;
        }
        $query = new ChildPrayerQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPrayer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PrayerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PrayerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPrayer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, user_id, full_name, email, prayer, created_at FROM prayer WHERE value = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPrayer $obj */
            $obj = new ChildPrayer();
            $obj->hydrate($row);
            PrayerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPrayer|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PrayerTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PrayerTableMap::COL_VALUE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue(1234); // WHERE value = 1234
     * $query->filterByValue(array(12, 34)); // WHERE value IN (12, 34)
     * $query->filterByValue(array('min' => 12)); // WHERE value > 12
     * </code>
     *
     * @param     mixed $value The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(PrayerTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(PrayerTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUserProfile()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(PrayerTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(PrayerTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the full_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFullName('fooValue');   // WHERE full_name = 'fooValue'
     * $query->filterByFullName('%fooValue%'); // WHERE full_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByFullName($fullName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_FULL_NAME, $fullName, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the prayer column
     *
     * Example usage:
     * <code>
     * $query->filterByPrayer('fooValue');   // WHERE prayer = 'fooValue'
     * $query->filterByPrayer('%fooValue%'); // WHERE prayer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prayer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByPrayer($prayer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prayer)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_PRAYER, $prayer, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PrayerTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PrayerTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrayerTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \UserProfile object
     *
     * @param \UserProfile|ObjectCollection $userProfile The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPrayerQuery The current query, for fluid interface
     */
    public function filterByUserProfile($userProfile, $comparison = null)
    {
        if ($userProfile instanceof \UserProfile) {
            return $this
                ->addUsingAlias(PrayerTableMap::COL_USER_ID, $userProfile->getValue(), $comparison);
        } elseif ($userProfile instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PrayerTableMap::COL_USER_ID, $userProfile->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByUserProfile() only accepts arguments of type \UserProfile or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserProfile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function joinUserProfile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserProfile');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserProfile');
        }

        return $this;
    }

    /**
     * Use the UserProfile relation UserProfile object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserProfileQuery A secondary query class using the current class as primary query
     */
    public function useUserProfileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserProfile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserProfile', '\UserProfileQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPrayer $prayer Object to remove from the list of results
     *
     * @return $this|ChildPrayerQuery The current query, for fluid interface
     */
    public function prune($prayer = null)
    {
        if ($prayer) {
            $this->addUsingAlias(PrayerTableMap::COL_VALUE, $prayer->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the prayer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PrayerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PrayerTableMap::clearInstancePool();
            PrayerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PrayerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PrayerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PrayerTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PrayerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PrayerQuery
