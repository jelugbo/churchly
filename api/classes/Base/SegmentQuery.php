<?php

namespace Base;

use \Segment as ChildSegment;
use \SegmentQuery as ChildSegmentQuery;
use \Exception;
use \PDO;
use Map\SegmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'segment' table.
 *
 * 
 *
 * @method     ChildSegmentQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildSegmentQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildSegmentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildSegmentQuery orderByProjectId($order = Criteria::ASC) Order by the project_id column
 * @method     ChildSegmentQuery orderByProjectNumber($order = Criteria::ASC) Order by the project_number column
 * @method     ChildSegmentQuery orderByApiKey($order = Criteria::ASC) Order by the api_key column
 * @method     ChildSegmentQuery orderBySslCert($order = Criteria::ASC) Order by the ssl_cert column
 * @method     ChildSegmentQuery orderByPwdCert($order = Criteria::ASC) Order by the pwd_cert column
 * @method     ChildSegmentQuery orderBySendLimit($order = Criteria::ASC) Order by the send_limit column
 * @method     ChildSegmentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildSegmentQuery groupByValue() Group by the value column
 * @method     ChildSegmentQuery groupByCode() Group by the code column
 * @method     ChildSegmentQuery groupByDescription() Group by the description column
 * @method     ChildSegmentQuery groupByProjectId() Group by the project_id column
 * @method     ChildSegmentQuery groupByProjectNumber() Group by the project_number column
 * @method     ChildSegmentQuery groupByApiKey() Group by the api_key column
 * @method     ChildSegmentQuery groupBySslCert() Group by the ssl_cert column
 * @method     ChildSegmentQuery groupByPwdCert() Group by the pwd_cert column
 * @method     ChildSegmentQuery groupBySendLimit() Group by the send_limit column
 * @method     ChildSegmentQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildSegmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSegmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSegmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSegmentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSegmentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSegmentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSegmentQuery leftJoinParishSegment($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParishSegment relation
 * @method     ChildSegmentQuery rightJoinParishSegment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParishSegment relation
 * @method     ChildSegmentQuery innerJoinParishSegment($relationAlias = null) Adds a INNER JOIN clause to the query using the ParishSegment relation
 *
 * @method     ChildSegmentQuery joinWithParishSegment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ParishSegment relation
 *
 * @method     ChildSegmentQuery leftJoinWithParishSegment() Adds a LEFT JOIN clause and with to the query using the ParishSegment relation
 * @method     ChildSegmentQuery rightJoinWithParishSegment() Adds a RIGHT JOIN clause and with to the query using the ParishSegment relation
 * @method     ChildSegmentQuery innerJoinWithParishSegment() Adds a INNER JOIN clause and with to the query using the ParishSegment relation
 *
 * @method     \ParishSegmentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSegment findOne(ConnectionInterface $con = null) Return the first ChildSegment matching the query
 * @method     ChildSegment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSegment matching the query, or a new ChildSegment object populated from the query conditions when no match is found
 *
 * @method     ChildSegment findOneByValue(int $value) Return the first ChildSegment filtered by the value column
 * @method     ChildSegment findOneByCode(string $code) Return the first ChildSegment filtered by the code column
 * @method     ChildSegment findOneByDescription(string $description) Return the first ChildSegment filtered by the description column
 * @method     ChildSegment findOneByProjectId(string $project_id) Return the first ChildSegment filtered by the project_id column
 * @method     ChildSegment findOneByProjectNumber(string $project_number) Return the first ChildSegment filtered by the project_number column
 * @method     ChildSegment findOneByApiKey(string $api_key) Return the first ChildSegment filtered by the api_key column
 * @method     ChildSegment findOneBySslCert(string $ssl_cert) Return the first ChildSegment filtered by the ssl_cert column
 * @method     ChildSegment findOneByPwdCert(string $pwd_cert) Return the first ChildSegment filtered by the pwd_cert column
 * @method     ChildSegment findOneBySendLimit(int $send_limit) Return the first ChildSegment filtered by the send_limit column
 * @method     ChildSegment findOneByCreatedAt(string $created_at) Return the first ChildSegment filtered by the created_at column *

 * @method     ChildSegment requirePk($key, ConnectionInterface $con = null) Return the ChildSegment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOne(ConnectionInterface $con = null) Return the first ChildSegment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSegment requireOneByValue(int $value) Return the first ChildSegment filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByCode(string $code) Return the first ChildSegment filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByDescription(string $description) Return the first ChildSegment filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByProjectId(string $project_id) Return the first ChildSegment filtered by the project_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByProjectNumber(string $project_number) Return the first ChildSegment filtered by the project_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByApiKey(string $api_key) Return the first ChildSegment filtered by the api_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneBySslCert(string $ssl_cert) Return the first ChildSegment filtered by the ssl_cert column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByPwdCert(string $pwd_cert) Return the first ChildSegment filtered by the pwd_cert column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneBySendLimit(int $send_limit) Return the first ChildSegment filtered by the send_limit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSegment requireOneByCreatedAt(string $created_at) Return the first ChildSegment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSegment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSegment objects based on current ModelCriteria
 * @method     ChildSegment[]|ObjectCollection findByValue(int $value) Return ChildSegment objects filtered by the value column
 * @method     ChildSegment[]|ObjectCollection findByCode(string $code) Return ChildSegment objects filtered by the code column
 * @method     ChildSegment[]|ObjectCollection findByDescription(string $description) Return ChildSegment objects filtered by the description column
 * @method     ChildSegment[]|ObjectCollection findByProjectId(string $project_id) Return ChildSegment objects filtered by the project_id column
 * @method     ChildSegment[]|ObjectCollection findByProjectNumber(string $project_number) Return ChildSegment objects filtered by the project_number column
 * @method     ChildSegment[]|ObjectCollection findByApiKey(string $api_key) Return ChildSegment objects filtered by the api_key column
 * @method     ChildSegment[]|ObjectCollection findBySslCert(string $ssl_cert) Return ChildSegment objects filtered by the ssl_cert column
 * @method     ChildSegment[]|ObjectCollection findByPwdCert(string $pwd_cert) Return ChildSegment objects filtered by the pwd_cert column
 * @method     ChildSegment[]|ObjectCollection findBySendLimit(int $send_limit) Return ChildSegment objects filtered by the send_limit column
 * @method     ChildSegment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSegment objects filtered by the created_at column
 * @method     ChildSegment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SegmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SegmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Segment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSegmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSegmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSegmentQuery) {
            return $criteria;
        }
        $query = new ChildSegmentQuery();
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
     * @return ChildSegment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SegmentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SegmentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSegment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, code, description, project_id, project_number, api_key, ssl_cert, pwd_cert, send_limit, created_at FROM segment WHERE value = :p0';
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
            /** @var ChildSegment $obj */
            $obj = new ChildSegment();
            $obj->hydrate($row);
            SegmentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSegment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SegmentTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SegmentTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(SegmentTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(SegmentTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_CODE, $code, $comparison);
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
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectId('fooValue');   // WHERE project_id = 'fooValue'
     * $query->filterByProjectId('%fooValue%'); // WHERE project_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $projectId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($projectId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the project_number column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectNumber('fooValue');   // WHERE project_number = 'fooValue'
     * $query->filterByProjectNumber('%fooValue%'); // WHERE project_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $projectNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByProjectNumber($projectNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($projectNumber)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_PROJECT_NUMBER, $projectNumber, $comparison);
    }

    /**
     * Filter the query on the api_key column
     *
     * Example usage:
     * <code>
     * $query->filterByApiKey('fooValue');   // WHERE api_key = 'fooValue'
     * $query->filterByApiKey('%fooValue%'); // WHERE api_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByApiKey($apiKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiKey)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_API_KEY, $apiKey, $comparison);
    }

    /**
     * Filter the query on the ssl_cert column
     *
     * Example usage:
     * <code>
     * $query->filterBySslCert('fooValue');   // WHERE ssl_cert = 'fooValue'
     * $query->filterBySslCert('%fooValue%'); // WHERE ssl_cert LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sslCert The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterBySslCert($sslCert = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sslCert)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_SSL_CERT, $sslCert, $comparison);
    }

    /**
     * Filter the query on the pwd_cert column
     *
     * Example usage:
     * <code>
     * $query->filterByPwdCert('fooValue');   // WHERE pwd_cert = 'fooValue'
     * $query->filterByPwdCert('%fooValue%'); // WHERE pwd_cert LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pwdCert The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByPwdCert($pwdCert = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pwdCert)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_PWD_CERT, $pwdCert, $comparison);
    }

    /**
     * Filter the query on the send_limit column
     *
     * Example usage:
     * <code>
     * $query->filterBySendLimit(1234); // WHERE send_limit = 1234
     * $query->filterBySendLimit(array(12, 34)); // WHERE send_limit IN (12, 34)
     * $query->filterBySendLimit(array('min' => 12)); // WHERE send_limit > 12
     * </code>
     *
     * @param     mixed $sendLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterBySendLimit($sendLimit = null, $comparison = null)
    {
        if (is_array($sendLimit)) {
            $useMinMax = false;
            if (isset($sendLimit['min'])) {
                $this->addUsingAlias(SegmentTableMap::COL_SEND_LIMIT, $sendLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sendLimit['max'])) {
                $this->addUsingAlias(SegmentTableMap::COL_SEND_LIMIT, $sendLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_SEND_LIMIT, $sendLimit, $comparison);
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
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SegmentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SegmentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SegmentTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \ParishSegment object
     *
     * @param \ParishSegment|ObjectCollection $parishSegment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSegmentQuery The current query, for fluid interface
     */
    public function filterByParishSegment($parishSegment, $comparison = null)
    {
        if ($parishSegment instanceof \ParishSegment) {
            return $this
                ->addUsingAlias(SegmentTableMap::COL_VALUE, $parishSegment->getSegmentId(), $comparison);
        } elseif ($parishSegment instanceof ObjectCollection) {
            return $this
                ->useParishSegmentQuery()
                ->filterByPrimaryKeys($parishSegment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParishSegment() only accepts arguments of type \ParishSegment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParishSegment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function joinParishSegment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParishSegment');

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
            $this->addJoinObject($join, 'ParishSegment');
        }

        return $this;
    }

    /**
     * Use the ParishSegment relation ParishSegment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ParishSegmentQuery A secondary query class using the current class as primary query
     */
    public function useParishSegmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParishSegment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParishSegment', '\ParishSegmentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSegment $segment Object to remove from the list of results
     *
     * @return $this|ChildSegmentQuery The current query, for fluid interface
     */
    public function prune($segment = null)
    {
        if ($segment) {
            $this->addUsingAlias(SegmentTableMap::COL_VALUE, $segment->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the segment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SegmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SegmentTableMap::clearInstancePool();
            SegmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SegmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SegmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            SegmentTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SegmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SegmentQuery
