<?php

namespace Base;

use \UserSubscription as ChildUserSubscription;
use \UserSubscriptionQuery as ChildUserSubscriptionQuery;
use \Exception;
use \PDO;
use Map\UserSubscriptionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_subscription' table.
 *
 * 
 *
 * @method     ChildUserSubscriptionQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUserSubscriptionQuery orderByPlanId($order = Criteria::ASC) Order by the plan_id column
 * @method     ChildUserSubscriptionQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildUserSubscriptionQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildUserSubscriptionQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildUserSubscriptionQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildUserSubscriptionQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 * @method     ChildUserSubscriptionQuery orderByPayId($order = Criteria::ASC) Order by the pay_id column
 * @method     ChildUserSubscriptionQuery orderByCustomerRef($order = Criteria::ASC) Order by the customer_ref column
 * @method     ChildUserSubscriptionQuery orderByMileage($order = Criteria::ASC) Order by the mileage column
 *
 * @method     ChildUserSubscriptionQuery groupByValue() Group by the value column
 * @method     ChildUserSubscriptionQuery groupByPlanId() Group by the plan_id column
 * @method     ChildUserSubscriptionQuery groupByUserId() Group by the user_id column
 * @method     ChildUserSubscriptionQuery groupByParishId() Group by the parish_id column
 * @method     ChildUserSubscriptionQuery groupByStatus() Group by the status column
 * @method     ChildUserSubscriptionQuery groupByStartDate() Group by the start_date column
 * @method     ChildUserSubscriptionQuery groupByEndDate() Group by the end_date column
 * @method     ChildUserSubscriptionQuery groupByPayId() Group by the pay_id column
 * @method     ChildUserSubscriptionQuery groupByCustomerRef() Group by the customer_ref column
 * @method     ChildUserSubscriptionQuery groupByMileage() Group by the mileage column
 *
 * @method     ChildUserSubscriptionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserSubscriptionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserSubscriptionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserSubscriptionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserSubscriptionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserSubscriptionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserSubscriptionQuery leftJoinUserLogin($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLogin relation
 * @method     ChildUserSubscriptionQuery rightJoinUserLogin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLogin relation
 * @method     ChildUserSubscriptionQuery innerJoinUserLogin($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLogin relation
 *
 * @method     ChildUserSubscriptionQuery joinWithUserLogin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserLogin relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinWithUserLogin() Adds a LEFT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildUserSubscriptionQuery rightJoinWithUserLogin() Adds a RIGHT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildUserSubscriptionQuery innerJoinWithUserLogin() Adds a INNER JOIN clause and with to the query using the UserLogin relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinUserPlan($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserPlan relation
 * @method     ChildUserSubscriptionQuery rightJoinUserPlan($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserPlan relation
 * @method     ChildUserSubscriptionQuery innerJoinUserPlan($relationAlias = null) Adds a INNER JOIN clause to the query using the UserPlan relation
 *
 * @method     ChildUserSubscriptionQuery joinWithUserPlan($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserPlan relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinWithUserPlan() Adds a LEFT JOIN clause and with to the query using the UserPlan relation
 * @method     ChildUserSubscriptionQuery rightJoinWithUserPlan() Adds a RIGHT JOIN clause and with to the query using the UserPlan relation
 * @method     ChildUserSubscriptionQuery innerJoinWithUserPlan() Adds a INNER JOIN clause and with to the query using the UserPlan relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinUserPayment($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserPayment relation
 * @method     ChildUserSubscriptionQuery rightJoinUserPayment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserPayment relation
 * @method     ChildUserSubscriptionQuery innerJoinUserPayment($relationAlias = null) Adds a INNER JOIN clause to the query using the UserPayment relation
 *
 * @method     ChildUserSubscriptionQuery joinWithUserPayment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserPayment relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinWithUserPayment() Adds a LEFT JOIN clause and with to the query using the UserPayment relation
 * @method     ChildUserSubscriptionQuery rightJoinWithUserPayment() Adds a RIGHT JOIN clause and with to the query using the UserPayment relation
 * @method     ChildUserSubscriptionQuery innerJoinWithUserPayment() Adds a INNER JOIN clause and with to the query using the UserPayment relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildUserSubscriptionQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildUserSubscriptionQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildUserSubscriptionQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildUserSubscriptionQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserSubscriptionQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserSubscriptionQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     \UserLoginQuery|\UserPlanQuery|\UserPaymentQuery|\ParishQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserSubscription findOne(ConnectionInterface $con = null) Return the first ChildUserSubscription matching the query
 * @method     ChildUserSubscription findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserSubscription matching the query, or a new ChildUserSubscription object populated from the query conditions when no match is found
 *
 * @method     ChildUserSubscription findOneByValue(int $value) Return the first ChildUserSubscription filtered by the value column
 * @method     ChildUserSubscription findOneByPlanId(int $plan_id) Return the first ChildUserSubscription filtered by the plan_id column
 * @method     ChildUserSubscription findOneByUserId(int $user_id) Return the first ChildUserSubscription filtered by the user_id column
 * @method     ChildUserSubscription findOneByParishId(int $parish_id) Return the first ChildUserSubscription filtered by the parish_id column
 * @method     ChildUserSubscription findOneByStatus(boolean $status) Return the first ChildUserSubscription filtered by the status column
 * @method     ChildUserSubscription findOneByStartDate(string $start_date) Return the first ChildUserSubscription filtered by the start_date column
 * @method     ChildUserSubscription findOneByEndDate(string $end_date) Return the first ChildUserSubscription filtered by the end_date column
 * @method     ChildUserSubscription findOneByPayId(int $pay_id) Return the first ChildUserSubscription filtered by the pay_id column
 * @method     ChildUserSubscription findOneByCustomerRef(string $customer_ref) Return the first ChildUserSubscription filtered by the customer_ref column
 * @method     ChildUserSubscription findOneByMileage(string $mileage) Return the first ChildUserSubscription filtered by the mileage column *

 * @method     ChildUserSubscription requirePk($key, ConnectionInterface $con = null) Return the ChildUserSubscription by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOne(ConnectionInterface $con = null) Return the first ChildUserSubscription matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserSubscription requireOneByValue(int $value) Return the first ChildUserSubscription filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByPlanId(int $plan_id) Return the first ChildUserSubscription filtered by the plan_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByUserId(int $user_id) Return the first ChildUserSubscription filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByParishId(int $parish_id) Return the first ChildUserSubscription filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByStatus(boolean $status) Return the first ChildUserSubscription filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByStartDate(string $start_date) Return the first ChildUserSubscription filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByEndDate(string $end_date) Return the first ChildUserSubscription filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByPayId(int $pay_id) Return the first ChildUserSubscription filtered by the pay_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByCustomerRef(string $customer_ref) Return the first ChildUserSubscription filtered by the customer_ref column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSubscription requireOneByMileage(string $mileage) Return the first ChildUserSubscription filtered by the mileage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserSubscription[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserSubscription objects based on current ModelCriteria
 * @method     ChildUserSubscription[]|ObjectCollection findByValue(int $value) Return ChildUserSubscription objects filtered by the value column
 * @method     ChildUserSubscription[]|ObjectCollection findByPlanId(int $plan_id) Return ChildUserSubscription objects filtered by the plan_id column
 * @method     ChildUserSubscription[]|ObjectCollection findByUserId(int $user_id) Return ChildUserSubscription objects filtered by the user_id column
 * @method     ChildUserSubscription[]|ObjectCollection findByParishId(int $parish_id) Return ChildUserSubscription objects filtered by the parish_id column
 * @method     ChildUserSubscription[]|ObjectCollection findByStatus(boolean $status) Return ChildUserSubscription objects filtered by the status column
 * @method     ChildUserSubscription[]|ObjectCollection findByStartDate(string $start_date) Return ChildUserSubscription objects filtered by the start_date column
 * @method     ChildUserSubscription[]|ObjectCollection findByEndDate(string $end_date) Return ChildUserSubscription objects filtered by the end_date column
 * @method     ChildUserSubscription[]|ObjectCollection findByPayId(int $pay_id) Return ChildUserSubscription objects filtered by the pay_id column
 * @method     ChildUserSubscription[]|ObjectCollection findByCustomerRef(string $customer_ref) Return ChildUserSubscription objects filtered by the customer_ref column
 * @method     ChildUserSubscription[]|ObjectCollection findByMileage(string $mileage) Return ChildUserSubscription objects filtered by the mileage column
 * @method     ChildUserSubscription[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserSubscriptionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserSubscriptionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UserSubscription', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserSubscriptionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserSubscriptionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserSubscriptionQuery) {
            return $criteria;
        }
        $query = new ChildUserSubscriptionQuery();
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
     * @return ChildUserSubscription|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserSubscriptionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserSubscription A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, plan_id, user_id, parish_id, status, start_date, end_date, pay_id, customer_ref, mileage FROM user_subscription WHERE value = :p0';
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
            /** @var ChildUserSubscription $obj */
            $obj = new ChildUserSubscription();
            $obj->hydrate($row);
            UserSubscriptionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserSubscription|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the plan_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlanId(1234); // WHERE plan_id = 1234
     * $query->filterByPlanId(array(12, 34)); // WHERE plan_id IN (12, 34)
     * $query->filterByPlanId(array('min' => 12)); // WHERE plan_id > 12
     * </code>
     *
     * @see       filterByUserPlan()
     *
     * @param     mixed $planId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByPlanId($planId = null, $comparison = null)
    {
        if (is_array($planId)) {
            $useMinMax = false;
            if (isset($planId['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PLAN_ID, $planId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($planId['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PLAN_ID, $planId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_PLAN_ID, $planId, $comparison);
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
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the parish_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParishId(1234); // WHERE parish_id = 1234
     * $query->filterByParishId(array(12, 34)); // WHERE parish_id IN (12, 34)
     * $query->filterByParishId(array('min' => 12)); // WHERE parish_id > 12
     * </code>
     *
     * @see       filterByParish()
     *
     * @param     mixed $parishId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(true); // WHERE status = true
     * $query->filterByStatus('yes'); // WHERE status = true
     * </code>
     *
     * @param     boolean|string $status The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_string($status)) {
            $status = in_array(strtolower($status), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE start_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_END_DATE, $endDate, $comparison);
    }

    /**
     * Filter the query on the pay_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPayId(1234); // WHERE pay_id = 1234
     * $query->filterByPayId(array(12, 34)); // WHERE pay_id IN (12, 34)
     * $query->filterByPayId(array('min' => 12)); // WHERE pay_id > 12
     * </code>
     *
     * @see       filterByUserPayment()
     *
     * @param     mixed $payId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByPayId($payId = null, $comparison = null)
    {
        if (is_array($payId)) {
            $useMinMax = false;
            if (isset($payId['min'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PAY_ID, $payId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($payId['max'])) {
                $this->addUsingAlias(UserSubscriptionTableMap::COL_PAY_ID, $payId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_PAY_ID, $payId, $comparison);
    }

    /**
     * Filter the query on the customer_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerRef('fooValue');   // WHERE customer_ref = 'fooValue'
     * $query->filterByCustomerRef('%fooValue%'); // WHERE customer_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $customerRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByCustomerRef($customerRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($customerRef)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_CUSTOMER_REF, $customerRef, $comparison);
    }

    /**
     * Filter the query on the mileage column
     *
     * Example usage:
     * <code>
     * $query->filterByMileage('fooValue');   // WHERE mileage = 'fooValue'
     * $query->filterByMileage('%fooValue%'); // WHERE mileage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mileage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByMileage($mileage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mileage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSubscriptionTableMap::COL_MILEAGE, $mileage, $comparison);
    }

    /**
     * Filter the query by a related \UserLogin object
     *
     * @param \UserLogin|ObjectCollection $userLogin The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByUserLogin($userLogin, $comparison = null)
    {
        if ($userLogin instanceof \UserLogin) {
            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_USER_ID, $userLogin->getValue(), $comparison);
        } elseif ($userLogin instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_USER_ID, $userLogin->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
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
     * Filter the query by a related \UserPlan object
     *
     * @param \UserPlan|ObjectCollection $userPlan The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByUserPlan($userPlan, $comparison = null)
    {
        if ($userPlan instanceof \UserPlan) {
            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PLAN_ID, $userPlan->getValue(), $comparison);
        } elseif ($userPlan instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PLAN_ID, $userPlan->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByUserPlan() only accepts arguments of type \UserPlan or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserPlan relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function joinUserPlan($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserPlan');

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
            $this->addJoinObject($join, 'UserPlan');
        }

        return $this;
    }

    /**
     * Use the UserPlan relation UserPlan object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserPlanQuery A secondary query class using the current class as primary query
     */
    public function useUserPlanQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserPlan($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserPlan', '\UserPlanQuery');
    }

    /**
     * Filter the query by a related \UserPayment object
     *
     * @param \UserPayment|ObjectCollection $userPayment The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByUserPayment($userPayment, $comparison = null)
    {
        if ($userPayment instanceof \UserPayment) {
            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PAY_ID, $userPayment->getValue(), $comparison);
        } elseif ($userPayment instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PAY_ID, $userPayment->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByUserPayment() only accepts arguments of type \UserPayment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserPayment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function joinUserPayment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserPayment');

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
            $this->addJoinObject($join, 'UserPayment');
        }

        return $this;
    }

    /**
     * Use the UserPayment relation UserPayment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserPaymentQuery A secondary query class using the current class as primary query
     */
    public function useUserPaymentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserPayment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserPayment', '\UserPaymentQuery');
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSubscriptionTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByParish() only accepts arguments of type \Parish or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Parish relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function joinParish($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Parish');

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
            $this->addJoinObject($join, 'Parish');
        }

        return $this;
    }

    /**
     * Use the Parish relation Parish object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ParishQuery A secondary query class using the current class as primary query
     */
    public function useParishQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParish($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Parish', '\ParishQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserSubscription $userSubscription Object to remove from the list of results
     *
     * @return $this|ChildUserSubscriptionQuery The current query, for fluid interface
     */
    public function prune($userSubscription = null)
    {
        if ($userSubscription) {
            $this->addUsingAlias(UserSubscriptionTableMap::COL_VALUE, $userSubscription->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_subscription table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserSubscriptionTableMap::clearInstancePool();
            UserSubscriptionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserSubscriptionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserSubscriptionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserSubscriptionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserSubscriptionQuery
