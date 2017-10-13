<?php

namespace Base;

use \Give as ChildGive;
use \GiveQuery as ChildGiveQuery;
use \Exception;
use \PDO;
use Map\GiveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'give' table.
 *
 * 
 *
 * @method     ChildGiveQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildGiveQuery orderByProfileId($order = Criteria::ASC) Order by the profile_id column
 * @method     ChildGiveQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildGiveQuery orderByMethodId($order = Criteria::ASC) Order by the method_id column
 * @method     ChildGiveQuery orderByCurrency($order = Criteria::ASC) Order by the currency column
 * @method     ChildGiveQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildGiveQuery orderByTxnRef($order = Criteria::ASC) Order by the txn_ref column
 * @method     ChildGiveQuery orderByTxnStatus($order = Criteria::ASC) Order by the txn_status column
 * @method     ChildGiveQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildGiveQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildGiveQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildGiveQuery groupByValue() Group by the value column
 * @method     ChildGiveQuery groupByProfileId() Group by the profile_id column
 * @method     ChildGiveQuery groupByParishId() Group by the parish_id column
 * @method     ChildGiveQuery groupByMethodId() Group by the method_id column
 * @method     ChildGiveQuery groupByCurrency() Group by the currency column
 * @method     ChildGiveQuery groupByTotal() Group by the total column
 * @method     ChildGiveQuery groupByTxnRef() Group by the txn_ref column
 * @method     ChildGiveQuery groupByTxnStatus() Group by the txn_status column
 * @method     ChildGiveQuery groupByDescription() Group by the description column
 * @method     ChildGiveQuery groupByCardId() Group by the card_id column
 * @method     ChildGiveQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildGiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGiveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGiveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGiveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGiveQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildGiveQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildGiveQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildGiveQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildGiveQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildGiveQuery leftJoinUserProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserProfile relation
 * @method     ChildGiveQuery rightJoinUserProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserProfile relation
 * @method     ChildGiveQuery innerJoinUserProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the UserProfile relation
 *
 * @method     ChildGiveQuery joinWithUserProfile($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserProfile relation
 *
 * @method     ChildGiveQuery leftJoinWithUserProfile() Adds a LEFT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildGiveQuery rightJoinWithUserProfile() Adds a RIGHT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildGiveQuery innerJoinWithUserProfile() Adds a INNER JOIN clause and with to the query using the UserProfile relation
 *
 * @method     ChildGiveQuery leftJoinGiveParishMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveParishMethods relation
 * @method     ChildGiveQuery rightJoinGiveParishMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveParishMethods relation
 * @method     ChildGiveQuery innerJoinGiveParishMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveParishMethods relation
 *
 * @method     ChildGiveQuery joinWithGiveParishMethods($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveParishMethods relation
 *
 * @method     ChildGiveQuery leftJoinWithGiveParishMethods() Adds a LEFT JOIN clause and with to the query using the GiveParishMethods relation
 * @method     ChildGiveQuery rightJoinWithGiveParishMethods() Adds a RIGHT JOIN clause and with to the query using the GiveParishMethods relation
 * @method     ChildGiveQuery innerJoinWithGiveParishMethods() Adds a INNER JOIN clause and with to the query using the GiveParishMethods relation
 *
 * @method     ChildGiveQuery leftJoinGiveSplit($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveSplit relation
 * @method     ChildGiveQuery rightJoinGiveSplit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveSplit relation
 * @method     ChildGiveQuery innerJoinGiveSplit($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveSplit relation
 *
 * @method     ChildGiveQuery joinWithGiveSplit($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveSplit relation
 *
 * @method     ChildGiveQuery leftJoinWithGiveSplit() Adds a LEFT JOIN clause and with to the query using the GiveSplit relation
 * @method     ChildGiveQuery rightJoinWithGiveSplit() Adds a RIGHT JOIN clause and with to the query using the GiveSplit relation
 * @method     ChildGiveQuery innerJoinWithGiveSplit() Adds a INNER JOIN clause and with to the query using the GiveSplit relation
 *
 * @method     \ParishQuery|\UserProfileQuery|\GiveParishMethodsQuery|\GiveSplitQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGive findOne(ConnectionInterface $con = null) Return the first ChildGive matching the query
 * @method     ChildGive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGive matching the query, or a new ChildGive object populated from the query conditions when no match is found
 *
 * @method     ChildGive findOneByValue(int $value) Return the first ChildGive filtered by the value column
 * @method     ChildGive findOneByProfileId(int $profile_id) Return the first ChildGive filtered by the profile_id column
 * @method     ChildGive findOneByParishId(int $parish_id) Return the first ChildGive filtered by the parish_id column
 * @method     ChildGive findOneByMethodId(int $method_id) Return the first ChildGive filtered by the method_id column
 * @method     ChildGive findOneByCurrency(string $currency) Return the first ChildGive filtered by the currency column
 * @method     ChildGive findOneByTotal(string $total) Return the first ChildGive filtered by the total column
 * @method     ChildGive findOneByTxnRef(string $txn_ref) Return the first ChildGive filtered by the txn_ref column
 * @method     ChildGive findOneByTxnStatus(string $txn_status) Return the first ChildGive filtered by the txn_status column
 * @method     ChildGive findOneByDescription(string $description) Return the first ChildGive filtered by the description column
 * @method     ChildGive findOneByCardId(string $card_id) Return the first ChildGive filtered by the card_id column
 * @method     ChildGive findOneByCreatedAt(string $created_at) Return the first ChildGive filtered by the created_at column *

 * @method     ChildGive requirePk($key, ConnectionInterface $con = null) Return the ChildGive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOne(ConnectionInterface $con = null) Return the first ChildGive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGive requireOneByValue(int $value) Return the first ChildGive filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByProfileId(int $profile_id) Return the first ChildGive filtered by the profile_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByParishId(int $parish_id) Return the first ChildGive filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByMethodId(int $method_id) Return the first ChildGive filtered by the method_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByCurrency(string $currency) Return the first ChildGive filtered by the currency column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByTotal(string $total) Return the first ChildGive filtered by the total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByTxnRef(string $txn_ref) Return the first ChildGive filtered by the txn_ref column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByTxnStatus(string $txn_status) Return the first ChildGive filtered by the txn_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByDescription(string $description) Return the first ChildGive filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByCardId(string $card_id) Return the first ChildGive filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGive requireOneByCreatedAt(string $created_at) Return the first ChildGive filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGive objects based on current ModelCriteria
 * @method     ChildGive[]|ObjectCollection findByValue(int $value) Return ChildGive objects filtered by the value column
 * @method     ChildGive[]|ObjectCollection findByProfileId(int $profile_id) Return ChildGive objects filtered by the profile_id column
 * @method     ChildGive[]|ObjectCollection findByParishId(int $parish_id) Return ChildGive objects filtered by the parish_id column
 * @method     ChildGive[]|ObjectCollection findByMethodId(int $method_id) Return ChildGive objects filtered by the method_id column
 * @method     ChildGive[]|ObjectCollection findByCurrency(string $currency) Return ChildGive objects filtered by the currency column
 * @method     ChildGive[]|ObjectCollection findByTotal(string $total) Return ChildGive objects filtered by the total column
 * @method     ChildGive[]|ObjectCollection findByTxnRef(string $txn_ref) Return ChildGive objects filtered by the txn_ref column
 * @method     ChildGive[]|ObjectCollection findByTxnStatus(string $txn_status) Return ChildGive objects filtered by the txn_status column
 * @method     ChildGive[]|ObjectCollection findByDescription(string $description) Return ChildGive objects filtered by the description column
 * @method     ChildGive[]|ObjectCollection findByCardId(string $card_id) Return ChildGive objects filtered by the card_id column
 * @method     ChildGive[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildGive objects filtered by the created_at column
 * @method     ChildGive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Give', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGiveQuery) {
            return $criteria;
        }
        $query = new ChildGiveQuery();
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
     * @return ChildGive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GiveTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GiveTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, profile_id, parish_id, method_id, currency, total, txn_ref, txn_status, description, card_id, created_at FROM give WHERE value = :p0';
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
            /** @var ChildGive $obj */
            $obj = new ChildGive();
            $obj->hydrate($row);
            GiveTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GiveTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GiveTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the profile_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProfileId(1234); // WHERE profile_id = 1234
     * $query->filterByProfileId(array(12, 34)); // WHERE profile_id IN (12, 34)
     * $query->filterByProfileId(array('min' => 12)); // WHERE profile_id > 12
     * </code>
     *
     * @see       filterByUserProfile()
     *
     * @param     mixed $profileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByProfileId($profileId = null, $comparison = null)
    {
        if (is_array($profileId)) {
            $useMinMax = false;
            if (isset($profileId['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_PROFILE_ID, $profileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profileId['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_PROFILE_ID, $profileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_PROFILE_ID, $profileId, $comparison);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the method_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMethodId(1234); // WHERE method_id = 1234
     * $query->filterByMethodId(array(12, 34)); // WHERE method_id IN (12, 34)
     * $query->filterByMethodId(array('min' => 12)); // WHERE method_id > 12
     * </code>
     *
     * @see       filterByGiveParishMethods()
     *
     * @param     mixed $methodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByMethodId($methodId = null, $comparison = null)
    {
        if (is_array($methodId)) {
            $useMinMax = false;
            if (isset($methodId['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_METHOD_ID, $methodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($methodId['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_METHOD_ID, $methodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_METHOD_ID, $methodId, $comparison);
    }

    /**
     * Filter the query on the currency column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrency('fooValue');   // WHERE currency = 'fooValue'
     * $query->filterByCurrency('%fooValue%'); // WHERE currency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $currency The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByCurrency($currency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($currency)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_CURRENCY, $currency, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_TOTAL, $total, $comparison);
    }

    /**
     * Filter the query on the txn_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnRef('fooValue');   // WHERE txn_ref = 'fooValue'
     * $query->filterByTxnRef('%fooValue%'); // WHERE txn_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByTxnRef($txnRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnRef)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_TXN_REF, $txnRef, $comparison);
    }

    /**
     * Filter the query on the txn_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnStatus('fooValue');   // WHERE txn_status = 'fooValue'
     * $query->filterByTxnStatus('%fooValue%'); // WHERE txn_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByTxnStatus($txnStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnStatus)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_TXN_STATUS, $txnStatus, $comparison);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the card_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardId('fooValue');   // WHERE card_id = 'fooValue'
     * $query->filterByCardId('%fooValue%'); // WHERE card_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cardId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cardId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_CARD_ID, $cardId, $comparison);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GiveTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GiveTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(GiveTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
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
     * Filter the query by a related \UserProfile object
     *
     * @param \UserProfile|ObjectCollection $userProfile The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveQuery The current query, for fluid interface
     */
    public function filterByUserProfile($userProfile, $comparison = null)
    {
        if ($userProfile instanceof \UserProfile) {
            return $this
                ->addUsingAlias(GiveTableMap::COL_PROFILE_ID, $userProfile->getValue(), $comparison);
        } elseif ($userProfile instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveTableMap::COL_PROFILE_ID, $userProfile->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildGiveQuery The current query, for fluid interface
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
     * Filter the query by a related \GiveParishMethods object
     *
     * @param \GiveParishMethods|ObjectCollection $giveParishMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveQuery The current query, for fluid interface
     */
    public function filterByGiveParishMethods($giveParishMethods, $comparison = null)
    {
        if ($giveParishMethods instanceof \GiveParishMethods) {
            return $this
                ->addUsingAlias(GiveTableMap::COL_METHOD_ID, $giveParishMethods->getValue(), $comparison);
        } elseif ($giveParishMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveTableMap::COL_METHOD_ID, $giveParishMethods->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByGiveParishMethods() only accepts arguments of type \GiveParishMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveParishMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function joinGiveParishMethods($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveParishMethods');

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
            $this->addJoinObject($join, 'GiveParishMethods');
        }

        return $this;
    }

    /**
     * Use the GiveParishMethods relation GiveParishMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveParishMethodsQuery A secondary query class using the current class as primary query
     */
    public function useGiveParishMethodsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveParishMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveParishMethods', '\GiveParishMethodsQuery');
    }

    /**
     * Filter the query by a related \GiveSplit object
     *
     * @param \GiveSplit|ObjectCollection $giveSplit the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiveQuery The current query, for fluid interface
     */
    public function filterByGiveSplit($giveSplit, $comparison = null)
    {
        if ($giveSplit instanceof \GiveSplit) {
            return $this
                ->addUsingAlias(GiveTableMap::COL_VALUE, $giveSplit->getGiveId(), $comparison);
        } elseif ($giveSplit instanceof ObjectCollection) {
            return $this
                ->useGiveSplitQuery()
                ->filterByPrimaryKeys($giveSplit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiveSplit() only accepts arguments of type \GiveSplit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveSplit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function joinGiveSplit($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveSplit');

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
            $this->addJoinObject($join, 'GiveSplit');
        }

        return $this;
    }

    /**
     * Use the GiveSplit relation GiveSplit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveSplitQuery A secondary query class using the current class as primary query
     */
    public function useGiveSplitQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveSplit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveSplit', '\GiveSplitQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGive $give Object to remove from the list of results
     *
     * @return $this|ChildGiveQuery The current query, for fluid interface
     */
    public function prune($give = null)
    {
        if ($give) {
            $this->addUsingAlias(GiveTableMap::COL_VALUE, $give->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the give table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GiveTableMap::clearInstancePool();
            GiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GiveTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GiveQuery
