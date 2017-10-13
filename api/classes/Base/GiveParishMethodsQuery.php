<?php

namespace Base;

use \GiveParishMethods as ChildGiveParishMethods;
use \GiveParishMethodsQuery as ChildGiveParishMethodsQuery;
use \Exception;
use \PDO;
use Map\GiveParishMethodsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'give_parish_methods' table.
 *
 * 
 *
 * @method     ChildGiveParishMethodsQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildGiveParishMethodsQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildGiveParishMethodsQuery orderByMethodId($order = Criteria::ASC) Order by the method_id column
 * @method     ChildGiveParishMethodsQuery orderBySettings($order = Criteria::ASC) Order by the settings column
 * @method     ChildGiveParishMethodsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method     ChildGiveParishMethodsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildGiveParishMethodsQuery groupByValue() Group by the value column
 * @method     ChildGiveParishMethodsQuery groupByParishId() Group by the parish_id column
 * @method     ChildGiveParishMethodsQuery groupByMethodId() Group by the method_id column
 * @method     ChildGiveParishMethodsQuery groupBySettings() Group by the settings column
 * @method     ChildGiveParishMethodsQuery groupByEnabled() Group by the enabled column
 * @method     ChildGiveParishMethodsQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildGiveParishMethodsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGiveParishMethodsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGiveParishMethodsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGiveParishMethodsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGiveParishMethodsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGiveParishMethodsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGiveParishMethodsQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildGiveParishMethodsQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildGiveParishMethodsQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildGiveParishMethodsQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildGiveParishMethodsQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveParishMethodsQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveParishMethodsQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildGiveParishMethodsQuery leftJoinGiveMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveMethods relation
 * @method     ChildGiveParishMethodsQuery rightJoinGiveMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveMethods relation
 * @method     ChildGiveParishMethodsQuery innerJoinGiveMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveMethods relation
 *
 * @method     ChildGiveParishMethodsQuery joinWithGiveMethods($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveMethods relation
 *
 * @method     ChildGiveParishMethodsQuery leftJoinWithGiveMethods() Adds a LEFT JOIN clause and with to the query using the GiveMethods relation
 * @method     ChildGiveParishMethodsQuery rightJoinWithGiveMethods() Adds a RIGHT JOIN clause and with to the query using the GiveMethods relation
 * @method     ChildGiveParishMethodsQuery innerJoinWithGiveMethods() Adds a INNER JOIN clause and with to the query using the GiveMethods relation
 *
 * @method     ChildGiveParishMethodsQuery leftJoinGive($relationAlias = null) Adds a LEFT JOIN clause to the query using the Give relation
 * @method     ChildGiveParishMethodsQuery rightJoinGive($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Give relation
 * @method     ChildGiveParishMethodsQuery innerJoinGive($relationAlias = null) Adds a INNER JOIN clause to the query using the Give relation
 *
 * @method     ChildGiveParishMethodsQuery joinWithGive($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Give relation
 *
 * @method     ChildGiveParishMethodsQuery leftJoinWithGive() Adds a LEFT JOIN clause and with to the query using the Give relation
 * @method     ChildGiveParishMethodsQuery rightJoinWithGive() Adds a RIGHT JOIN clause and with to the query using the Give relation
 * @method     ChildGiveParishMethodsQuery innerJoinWithGive() Adds a INNER JOIN clause and with to the query using the Give relation
 *
 * @method     \ParishQuery|\GiveMethodsQuery|\GiveQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGiveParishMethods findOne(ConnectionInterface $con = null) Return the first ChildGiveParishMethods matching the query
 * @method     ChildGiveParishMethods findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGiveParishMethods matching the query, or a new ChildGiveParishMethods object populated from the query conditions when no match is found
 *
 * @method     ChildGiveParishMethods findOneByValue(int $value) Return the first ChildGiveParishMethods filtered by the value column
 * @method     ChildGiveParishMethods findOneByParishId(int $parish_id) Return the first ChildGiveParishMethods filtered by the parish_id column
 * @method     ChildGiveParishMethods findOneByMethodId(int $method_id) Return the first ChildGiveParishMethods filtered by the method_id column
 * @method     ChildGiveParishMethods findOneBySettings(string $settings) Return the first ChildGiveParishMethods filtered by the settings column
 * @method     ChildGiveParishMethods findOneByEnabled(int $enabled) Return the first ChildGiveParishMethods filtered by the enabled column
 * @method     ChildGiveParishMethods findOneByCreatedAt(string $created_at) Return the first ChildGiveParishMethods filtered by the created_at column *

 * @method     ChildGiveParishMethods requirePk($key, ConnectionInterface $con = null) Return the ChildGiveParishMethods by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOne(ConnectionInterface $con = null) Return the first ChildGiveParishMethods matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGiveParishMethods requireOneByValue(int $value) Return the first ChildGiveParishMethods filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOneByParishId(int $parish_id) Return the first ChildGiveParishMethods filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOneByMethodId(int $method_id) Return the first ChildGiveParishMethods filtered by the method_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOneBySettings(string $settings) Return the first ChildGiveParishMethods filtered by the settings column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOneByEnabled(int $enabled) Return the first ChildGiveParishMethods filtered by the enabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveParishMethods requireOneByCreatedAt(string $created_at) Return the first ChildGiveParishMethods filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGiveParishMethods[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGiveParishMethods objects based on current ModelCriteria
 * @method     ChildGiveParishMethods[]|ObjectCollection findByValue(int $value) Return ChildGiveParishMethods objects filtered by the value column
 * @method     ChildGiveParishMethods[]|ObjectCollection findByParishId(int $parish_id) Return ChildGiveParishMethods objects filtered by the parish_id column
 * @method     ChildGiveParishMethods[]|ObjectCollection findByMethodId(int $method_id) Return ChildGiveParishMethods objects filtered by the method_id column
 * @method     ChildGiveParishMethods[]|ObjectCollection findBySettings(string $settings) Return ChildGiveParishMethods objects filtered by the settings column
 * @method     ChildGiveParishMethods[]|ObjectCollection findByEnabled(int $enabled) Return ChildGiveParishMethods objects filtered by the enabled column
 * @method     ChildGiveParishMethods[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildGiveParishMethods objects filtered by the created_at column
 * @method     ChildGiveParishMethods[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GiveParishMethodsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GiveParishMethodsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\GiveParishMethods', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGiveParishMethodsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGiveParishMethodsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGiveParishMethodsQuery) {
            return $criteria;
        }
        $query = new ChildGiveParishMethodsQuery();
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
     * @return ChildGiveParishMethods|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GiveParishMethodsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GiveParishMethodsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGiveParishMethods A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, parish_id, method_id, settings, enabled, created_at FROM give_parish_methods WHERE value = :p0';
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
            /** @var ChildGiveParishMethods $obj */
            $obj = new ChildGiveParishMethods();
            $obj->hydrate($row);
            GiveParishMethodsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGiveParishMethods|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_PARISH_ID, $parishId, $comparison);
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
     * @see       filterByGiveMethods()
     *
     * @param     mixed $methodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByMethodId($methodId = null, $comparison = null)
    {
        if (is_array($methodId)) {
            $useMinMax = false;
            if (isset($methodId['min'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_METHOD_ID, $methodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($methodId['max'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_METHOD_ID, $methodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_METHOD_ID, $methodId, $comparison);
    }

    /**
     * Filter the query on the settings column
     *
     * Example usage:
     * <code>
     * $query->filterBySettings('fooValue');   // WHERE settings = 'fooValue'
     * $query->filterBySettings('%fooValue%'); // WHERE settings LIKE '%fooValue%'
     * </code>
     *
     * @param     string $settings The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterBySettings($settings = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($settings)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_SETTINGS, $settings, $comparison);
    }

    /**
     * Filter the query on the enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabled(1234); // WHERE enabled = 1234
     * $query->filterByEnabled(array(12, 34)); // WHERE enabled IN (12, 34)
     * $query->filterByEnabled(array('min' => 12)); // WHERE enabled > 12
     * </code>
     *
     * @param     mixed $enabled The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_array($enabled)) {
            $useMinMax = false;
            if (isset($enabled['min'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_ENABLED, $enabled['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enabled['max'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_ENABLED, $enabled['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_ENABLED, $enabled, $comparison);
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
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GiveParishMethodsTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveParishMethodsTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(GiveParishMethodsTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveParishMethodsTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
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
     * Filter the query by a related \GiveMethods object
     *
     * @param \GiveMethods|ObjectCollection $giveMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByGiveMethods($giveMethods, $comparison = null)
    {
        if ($giveMethods instanceof \GiveMethods) {
            return $this
                ->addUsingAlias(GiveParishMethodsTableMap::COL_METHOD_ID, $giveMethods->getValue(), $comparison);
        } elseif ($giveMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveParishMethodsTableMap::COL_METHOD_ID, $giveMethods->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByGiveMethods() only accepts arguments of type \GiveMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function joinGiveMethods($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveMethods');

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
            $this->addJoinObject($join, 'GiveMethods');
        }

        return $this;
    }

    /**
     * Use the GiveMethods relation GiveMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveMethodsQuery A secondary query class using the current class as primary query
     */
    public function useGiveMethodsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveMethods', '\GiveMethodsQuery');
    }

    /**
     * Filter the query by a related \Give object
     *
     * @param \Give|ObjectCollection $give the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function filterByGive($give, $comparison = null)
    {
        if ($give instanceof \Give) {
            return $this
                ->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $give->getMethodId(), $comparison);
        } elseif ($give instanceof ObjectCollection) {
            return $this
                ->useGiveQuery()
                ->filterByPrimaryKeys($give->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGive() only accepts arguments of type \Give or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Give relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function joinGive($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Give');

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
            $this->addJoinObject($join, 'Give');
        }

        return $this;
    }

    /**
     * Use the Give relation Give object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveQuery A secondary query class using the current class as primary query
     */
    public function useGiveQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGive($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Give', '\GiveQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGiveParishMethods $giveParishMethods Object to remove from the list of results
     *
     * @return $this|ChildGiveParishMethodsQuery The current query, for fluid interface
     */
    public function prune($giveParishMethods = null)
    {
        if ($giveParishMethods) {
            $this->addUsingAlias(GiveParishMethodsTableMap::COL_VALUE, $giveParishMethods->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the give_parish_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveParishMethodsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GiveParishMethodsTableMap::clearInstancePool();
            GiveParishMethodsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GiveParishMethodsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GiveParishMethodsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GiveParishMethodsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GiveParishMethodsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GiveParishMethodsQuery
