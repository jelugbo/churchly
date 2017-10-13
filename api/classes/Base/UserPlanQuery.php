<?php

namespace Base;

use \UserPlan as ChildUserPlan;
use \UserPlanQuery as ChildUserPlanQuery;
use \Exception;
use \PDO;
use Map\UserPlanTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_plan' table.
 *
 * 
 *
 * @method     ChildUserPlanQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUserPlanQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUserPlanQuery orderByParams($order = Criteria::ASC) Order by the params column
 * @method     ChildUserPlanQuery orderByCost($order = Criteria::ASC) Order by the cost column
 *
 * @method     ChildUserPlanQuery groupByValue() Group by the value column
 * @method     ChildUserPlanQuery groupByName() Group by the name column
 * @method     ChildUserPlanQuery groupByParams() Group by the params column
 * @method     ChildUserPlanQuery groupByCost() Group by the cost column
 *
 * @method     ChildUserPlanQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserPlanQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserPlanQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserPlanQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserPlanQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserPlanQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserPlanQuery leftJoinUserSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserPlanQuery rightJoinUserSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserPlanQuery innerJoinUserSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSubscription relation
 *
 * @method     ChildUserPlanQuery joinWithUserSubscription($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSubscription relation
 *
 * @method     ChildUserPlanQuery leftJoinWithUserSubscription() Adds a LEFT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserPlanQuery rightJoinWithUserSubscription() Adds a RIGHT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserPlanQuery innerJoinWithUserSubscription() Adds a INNER JOIN clause and with to the query using the UserSubscription relation
 *
 * @method     \UserSubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserPlan findOne(ConnectionInterface $con = null) Return the first ChildUserPlan matching the query
 * @method     ChildUserPlan findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserPlan matching the query, or a new ChildUserPlan object populated from the query conditions when no match is found
 *
 * @method     ChildUserPlan findOneByValue(int $value) Return the first ChildUserPlan filtered by the value column
 * @method     ChildUserPlan findOneByName(string $name) Return the first ChildUserPlan filtered by the name column
 * @method     ChildUserPlan findOneByParams(string $params) Return the first ChildUserPlan filtered by the params column
 * @method     ChildUserPlan findOneByCost(string $cost) Return the first ChildUserPlan filtered by the cost column *

 * @method     ChildUserPlan requirePk($key, ConnectionInterface $con = null) Return the ChildUserPlan by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPlan requireOne(ConnectionInterface $con = null) Return the first ChildUserPlan matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserPlan requireOneByValue(int $value) Return the first ChildUserPlan filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPlan requireOneByName(string $name) Return the first ChildUserPlan filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPlan requireOneByParams(string $params) Return the first ChildUserPlan filtered by the params column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPlan requireOneByCost(string $cost) Return the first ChildUserPlan filtered by the cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserPlan[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserPlan objects based on current ModelCriteria
 * @method     ChildUserPlan[]|ObjectCollection findByValue(int $value) Return ChildUserPlan objects filtered by the value column
 * @method     ChildUserPlan[]|ObjectCollection findByName(string $name) Return ChildUserPlan objects filtered by the name column
 * @method     ChildUserPlan[]|ObjectCollection findByParams(string $params) Return ChildUserPlan objects filtered by the params column
 * @method     ChildUserPlan[]|ObjectCollection findByCost(string $cost) Return ChildUserPlan objects filtered by the cost column
 * @method     ChildUserPlan[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserPlanQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserPlanQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UserPlan', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserPlanQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserPlanQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserPlanQuery) {
            return $criteria;
        }
        $query = new ChildUserPlanQuery();
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
     * @return ChildUserPlan|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserPlanTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserPlanTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserPlan A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, name, params, cost FROM user_plan WHERE value = :p0';
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
            /** @var ChildUserPlan $obj */
            $obj = new ChildUserPlan();
            $obj->hydrate($row);
            UserPlanTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserPlan|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPlanTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the params column
     *
     * Example usage:
     * <code>
     * $query->filterByParams('fooValue');   // WHERE params = 'fooValue'
     * $query->filterByParams('%fooValue%'); // WHERE params LIKE '%fooValue%'
     * </code>
     *
     * @param     string $params The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByParams($params = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($params)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPlanTableMap::COL_PARAMS, $params, $comparison);
    }

    /**
     * Filter the query on the cost column
     *
     * Example usage:
     * <code>
     * $query->filterByCost('fooValue');   // WHERE cost = 'fooValue'
     * $query->filterByCost('%fooValue%'); // WHERE cost LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cost The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByCost($cost = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cost)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPlanTableMap::COL_COST, $cost, $comparison);
    }

    /**
     * Filter the query by a related \UserSubscription object
     *
     * @param \UserSubscription|ObjectCollection $userSubscription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserPlanQuery The current query, for fluid interface
     */
    public function filterByUserSubscription($userSubscription, $comparison = null)
    {
        if ($userSubscription instanceof \UserSubscription) {
            return $this
                ->addUsingAlias(UserPlanTableMap::COL_VALUE, $userSubscription->getPlanId(), $comparison);
        } elseif ($userSubscription instanceof ObjectCollection) {
            return $this
                ->useUserSubscriptionQuery()
                ->filterByPrimaryKeys($userSubscription->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserSubscription() only accepts arguments of type \UserSubscription or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserSubscription relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function joinUserSubscription($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserSubscription');

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
            $this->addJoinObject($join, 'UserSubscription');
        }

        return $this;
    }

    /**
     * Use the UserSubscription relation UserSubscription object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserSubscriptionQuery A secondary query class using the current class as primary query
     */
    public function useUserSubscriptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserSubscription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSubscription', '\UserSubscriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserPlan $userPlan Object to remove from the list of results
     *
     * @return $this|ChildUserPlanQuery The current query, for fluid interface
     */
    public function prune($userPlan = null)
    {
        if ($userPlan) {
            $this->addUsingAlias(UserPlanTableMap::COL_VALUE, $userPlan->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_plan table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserPlanTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserPlanTableMap::clearInstancePool();
            UserPlanTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserPlanTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserPlanTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserPlanTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserPlanTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserPlanQuery
