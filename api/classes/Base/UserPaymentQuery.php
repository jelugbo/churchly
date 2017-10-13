<?php

namespace Base;

use \UserPayment as ChildUserPayment;
use \UserPaymentQuery as ChildUserPaymentQuery;
use \Exception;
use \PDO;
use Map\UserPaymentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_payment' table.
 *
 * 
 *
 * @method     ChildUserPaymentQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUserPaymentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildUserPaymentQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildUserPaymentQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildUserPaymentQuery orderByReference($order = Criteria::ASC) Order by the reference column
 * @method     ChildUserPaymentQuery orderByLog($order = Criteria::ASC) Order by the log column
 * @method     ChildUserPaymentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildUserPaymentQuery groupByValue() Group by the value column
 * @method     ChildUserPaymentQuery groupByDescription() Group by the description column
 * @method     ChildUserPaymentQuery groupByUserId() Group by the user_id column
 * @method     ChildUserPaymentQuery groupByStatus() Group by the status column
 * @method     ChildUserPaymentQuery groupByReference() Group by the reference column
 * @method     ChildUserPaymentQuery groupByLog() Group by the log column
 * @method     ChildUserPaymentQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildUserPaymentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserPaymentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserPaymentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserPaymentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserPaymentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserPaymentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserPaymentQuery leftJoinUserLogin($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLogin relation
 * @method     ChildUserPaymentQuery rightJoinUserLogin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLogin relation
 * @method     ChildUserPaymentQuery innerJoinUserLogin($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLogin relation
 *
 * @method     ChildUserPaymentQuery joinWithUserLogin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserLogin relation
 *
 * @method     ChildUserPaymentQuery leftJoinWithUserLogin() Adds a LEFT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildUserPaymentQuery rightJoinWithUserLogin() Adds a RIGHT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildUserPaymentQuery innerJoinWithUserLogin() Adds a INNER JOIN clause and with to the query using the UserLogin relation
 *
 * @method     ChildUserPaymentQuery leftJoinUserSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserPaymentQuery rightJoinUserSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserPaymentQuery innerJoinUserSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSubscription relation
 *
 * @method     ChildUserPaymentQuery joinWithUserSubscription($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSubscription relation
 *
 * @method     ChildUserPaymentQuery leftJoinWithUserSubscription() Adds a LEFT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserPaymentQuery rightJoinWithUserSubscription() Adds a RIGHT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserPaymentQuery innerJoinWithUserSubscription() Adds a INNER JOIN clause and with to the query using the UserSubscription relation
 *
 * @method     \UserLoginQuery|\UserSubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserPayment findOne(ConnectionInterface $con = null) Return the first ChildUserPayment matching the query
 * @method     ChildUserPayment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserPayment matching the query, or a new ChildUserPayment object populated from the query conditions when no match is found
 *
 * @method     ChildUserPayment findOneByValue(int $value) Return the first ChildUserPayment filtered by the value column
 * @method     ChildUserPayment findOneByDescription(string $description) Return the first ChildUserPayment filtered by the description column
 * @method     ChildUserPayment findOneByUserId(int $user_id) Return the first ChildUserPayment filtered by the user_id column
 * @method     ChildUserPayment findOneByStatus(string $status) Return the first ChildUserPayment filtered by the status column
 * @method     ChildUserPayment findOneByReference(string $reference) Return the first ChildUserPayment filtered by the reference column
 * @method     ChildUserPayment findOneByLog(string $log) Return the first ChildUserPayment filtered by the log column
 * @method     ChildUserPayment findOneByCreatedAt(string $created_at) Return the first ChildUserPayment filtered by the created_at column *

 * @method     ChildUserPayment requirePk($key, ConnectionInterface $con = null) Return the ChildUserPayment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOne(ConnectionInterface $con = null) Return the first ChildUserPayment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserPayment requireOneByValue(int $value) Return the first ChildUserPayment filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByDescription(string $description) Return the first ChildUserPayment filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByUserId(int $user_id) Return the first ChildUserPayment filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByStatus(string $status) Return the first ChildUserPayment filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByReference(string $reference) Return the first ChildUserPayment filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByLog(string $log) Return the first ChildUserPayment filtered by the log column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserPayment requireOneByCreatedAt(string $created_at) Return the first ChildUserPayment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserPayment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserPayment objects based on current ModelCriteria
 * @method     ChildUserPayment[]|ObjectCollection findByValue(int $value) Return ChildUserPayment objects filtered by the value column
 * @method     ChildUserPayment[]|ObjectCollection findByDescription(string $description) Return ChildUserPayment objects filtered by the description column
 * @method     ChildUserPayment[]|ObjectCollection findByUserId(int $user_id) Return ChildUserPayment objects filtered by the user_id column
 * @method     ChildUserPayment[]|ObjectCollection findByStatus(string $status) Return ChildUserPayment objects filtered by the status column
 * @method     ChildUserPayment[]|ObjectCollection findByReference(string $reference) Return ChildUserPayment objects filtered by the reference column
 * @method     ChildUserPayment[]|ObjectCollection findByLog(string $log) Return ChildUserPayment objects filtered by the log column
 * @method     ChildUserPayment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserPayment objects filtered by the created_at column
 * @method     ChildUserPayment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserPaymentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserPaymentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UserPayment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserPaymentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserPaymentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserPaymentQuery) {
            return $criteria;
        }
        $query = new ChildUserPaymentQuery();
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
     * @return ChildUserPayment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserPaymentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserPaymentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserPayment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, description, user_id, status, reference, log, created_at FROM user_payment WHERE value = :p0';
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
            /** @var ChildUserPayment $obj */
            $obj = new ChildUserPayment();
            $obj->hydrate($row);
            UserPaymentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserPayment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @see       filterByUserLogin()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference('fooValue');   // WHERE reference = 'fooValue'
     * $query->filterByReference('%fooValue%'); // WHERE reference LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the log column
     *
     * Example usage:
     * <code>
     * $query->filterByLog('fooValue');   // WHERE log = 'fooValue'
     * $query->filterByLog('%fooValue%'); // WHERE log LIKE '%fooValue%'
     * </code>
     *
     * @param     string $log The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByLog($log = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($log)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_LOG, $log, $comparison);
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
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserPaymentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPaymentTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \UserLogin object
     *
     * @param \UserLogin|ObjectCollection $userLogin The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByUserLogin($userLogin, $comparison = null)
    {
        if ($userLogin instanceof \UserLogin) {
            return $this
                ->addUsingAlias(UserPaymentTableMap::COL_USER_ID, $userLogin->getValue(), $comparison);
        } elseif ($userLogin instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserPaymentTableMap::COL_USER_ID, $userLogin->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByUserLogin() only accepts arguments of type \UserLogin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserLogin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function joinUserLogin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserLogin');

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
            $this->addJoinObject($join, 'UserLogin');
        }

        return $this;
    }

    /**
     * Use the UserLogin relation UserLogin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserLoginQuery A secondary query class using the current class as primary query
     */
    public function useUserLoginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserLogin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserLogin', '\UserLoginQuery');
    }

    /**
     * Filter the query by a related \UserSubscription object
     *
     * @param \UserSubscription|ObjectCollection $userSubscription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserPaymentQuery The current query, for fluid interface
     */
    public function filterByUserSubscription($userSubscription, $comparison = null)
    {
        if ($userSubscription instanceof \UserSubscription) {
            return $this
                ->addUsingAlias(UserPaymentTableMap::COL_VALUE, $userSubscription->getPayId(), $comparison);
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
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function joinUserSubscription($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useUserSubscriptionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserSubscription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSubscription', '\UserSubscriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserPayment $userPayment Object to remove from the list of results
     *
     * @return $this|ChildUserPaymentQuery The current query, for fluid interface
     */
    public function prune($userPayment = null)
    {
        if ($userPayment) {
            $this->addUsingAlias(UserPaymentTableMap::COL_VALUE, $userPayment->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_payment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserPaymentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserPaymentTableMap::clearInstancePool();
            UserPaymentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserPaymentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserPaymentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserPaymentTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserPaymentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserPaymentQuery
