<?php

namespace Base;

use \JobQueue as ChildJobQueue;
use \JobQueueQuery as ChildJobQueueQuery;
use \Exception;
use \PDO;
use Map\JobQueueTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'job_queue' table.
 *
 * 
 *
 * @method     ChildJobQueueQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildJobQueueQuery orderByLetterId($order = Criteria::ASC) Order by the letter_id column
 * @method     ChildJobQueueQuery orderByRecipientsId($order = Criteria::ASC) Order by the recipients_id column
 * @method     ChildJobQueueQuery orderByJobType($order = Criteria::ASC) Order by the job_type column
 * @method     ChildJobQueueQuery orderByScheduledTime($order = Criteria::ASC) Order by the scheduled_time column
 * @method     ChildJobQueueQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildJobQueueQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildJobQueueQuery groupByValue() Group by the value column
 * @method     ChildJobQueueQuery groupByLetterId() Group by the letter_id column
 * @method     ChildJobQueueQuery groupByRecipientsId() Group by the recipients_id column
 * @method     ChildJobQueueQuery groupByJobType() Group by the job_type column
 * @method     ChildJobQueueQuery groupByScheduledTime() Group by the scheduled_time column
 * @method     ChildJobQueueQuery groupByStatus() Group by the status column
 * @method     ChildJobQueueQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildJobQueueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJobQueueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJobQueueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJobQueueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJobQueueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJobQueueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJobQueueQuery leftJoinLetters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Letters relation
 * @method     ChildJobQueueQuery rightJoinLetters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Letters relation
 * @method     ChildJobQueueQuery innerJoinLetters($relationAlias = null) Adds a INNER JOIN clause to the query using the Letters relation
 *
 * @method     ChildJobQueueQuery joinWithLetters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Letters relation
 *
 * @method     ChildJobQueueQuery leftJoinWithLetters() Adds a LEFT JOIN clause and with to the query using the Letters relation
 * @method     ChildJobQueueQuery rightJoinWithLetters() Adds a RIGHT JOIN clause and with to the query using the Letters relation
 * @method     ChildJobQueueQuery innerJoinWithLetters() Adds a INNER JOIN clause and with to the query using the Letters relation
 *
 * @method     ChildJobQueueQuery leftJoinLetterQueue($relationAlias = null) Adds a LEFT JOIN clause to the query using the LetterQueue relation
 * @method     ChildJobQueueQuery rightJoinLetterQueue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LetterQueue relation
 * @method     ChildJobQueueQuery innerJoinLetterQueue($relationAlias = null) Adds a INNER JOIN clause to the query using the LetterQueue relation
 *
 * @method     ChildJobQueueQuery joinWithLetterQueue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the LetterQueue relation
 *
 * @method     ChildJobQueueQuery leftJoinWithLetterQueue() Adds a LEFT JOIN clause and with to the query using the LetterQueue relation
 * @method     ChildJobQueueQuery rightJoinWithLetterQueue() Adds a RIGHT JOIN clause and with to the query using the LetterQueue relation
 * @method     ChildJobQueueQuery innerJoinWithLetterQueue() Adds a INNER JOIN clause and with to the query using the LetterQueue relation
 *
 * @method     \LettersQuery|\LetterQueueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJobQueue findOne(ConnectionInterface $con = null) Return the first ChildJobQueue matching the query
 * @method     ChildJobQueue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJobQueue matching the query, or a new ChildJobQueue object populated from the query conditions when no match is found
 *
 * @method     ChildJobQueue findOneByValue(int $value) Return the first ChildJobQueue filtered by the value column
 * @method     ChildJobQueue findOneByLetterId(int $letter_id) Return the first ChildJobQueue filtered by the letter_id column
 * @method     ChildJobQueue findOneByRecipientsId(int $recipients_id) Return the first ChildJobQueue filtered by the recipients_id column
 * @method     ChildJobQueue findOneByJobType(string $job_type) Return the first ChildJobQueue filtered by the job_type column
 * @method     ChildJobQueue findOneByScheduledTime(string $scheduled_time) Return the first ChildJobQueue filtered by the scheduled_time column
 * @method     ChildJobQueue findOneByStatus(string $status) Return the first ChildJobQueue filtered by the status column
 * @method     ChildJobQueue findOneByCreatedAt(string $created_at) Return the first ChildJobQueue filtered by the created_at column *

 * @method     ChildJobQueue requirePk($key, ConnectionInterface $con = null) Return the ChildJobQueue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOne(ConnectionInterface $con = null) Return the first ChildJobQueue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJobQueue requireOneByValue(int $value) Return the first ChildJobQueue filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByLetterId(int $letter_id) Return the first ChildJobQueue filtered by the letter_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByRecipientsId(int $recipients_id) Return the first ChildJobQueue filtered by the recipients_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByJobType(string $job_type) Return the first ChildJobQueue filtered by the job_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByScheduledTime(string $scheduled_time) Return the first ChildJobQueue filtered by the scheduled_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByStatus(string $status) Return the first ChildJobQueue filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJobQueue requireOneByCreatedAt(string $created_at) Return the first ChildJobQueue filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJobQueue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJobQueue objects based on current ModelCriteria
 * @method     ChildJobQueue[]|ObjectCollection findByValue(int $value) Return ChildJobQueue objects filtered by the value column
 * @method     ChildJobQueue[]|ObjectCollection findByLetterId(int $letter_id) Return ChildJobQueue objects filtered by the letter_id column
 * @method     ChildJobQueue[]|ObjectCollection findByRecipientsId(int $recipients_id) Return ChildJobQueue objects filtered by the recipients_id column
 * @method     ChildJobQueue[]|ObjectCollection findByJobType(string $job_type) Return ChildJobQueue objects filtered by the job_type column
 * @method     ChildJobQueue[]|ObjectCollection findByScheduledTime(string $scheduled_time) Return ChildJobQueue objects filtered by the scheduled_time column
 * @method     ChildJobQueue[]|ObjectCollection findByStatus(string $status) Return ChildJobQueue objects filtered by the status column
 * @method     ChildJobQueue[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildJobQueue objects filtered by the created_at column
 * @method     ChildJobQueue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JobQueueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JobQueueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JobQueue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJobQueueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJobQueueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJobQueueQuery) {
            return $criteria;
        }
        $query = new ChildJobQueueQuery();
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
     * @return ChildJobQueue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JobQueueTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = JobQueueTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildJobQueue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, letter_id, recipients_id, job_type, scheduled_time, status, created_at FROM job_queue WHERE value = :p0';
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
            /** @var ChildJobQueue $obj */
            $obj = new ChildJobQueue();
            $obj->hydrate($row);
            JobQueueTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildJobQueue|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the letter_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLetterId(1234); // WHERE letter_id = 1234
     * $query->filterByLetterId(array(12, 34)); // WHERE letter_id IN (12, 34)
     * $query->filterByLetterId(array('min' => 12)); // WHERE letter_id > 12
     * </code>
     *
     * @see       filterByLetters()
     *
     * @param     mixed $letterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByLetterId($letterId = null, $comparison = null)
    {
        if (is_array($letterId)) {
            $useMinMax = false;
            if (isset($letterId['min'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_LETTER_ID, $letterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($letterId['max'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_LETTER_ID, $letterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_LETTER_ID, $letterId, $comparison);
    }

    /**
     * Filter the query on the recipients_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRecipientsId(1234); // WHERE recipients_id = 1234
     * $query->filterByRecipientsId(array(12, 34)); // WHERE recipients_id IN (12, 34)
     * $query->filterByRecipientsId(array('min' => 12)); // WHERE recipients_id > 12
     * </code>
     *
     * @param     mixed $recipientsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByRecipientsId($recipientsId = null, $comparison = null)
    {
        if (is_array($recipientsId)) {
            $useMinMax = false;
            if (isset($recipientsId['min'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_RECIPIENTS_ID, $recipientsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recipientsId['max'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_RECIPIENTS_ID, $recipientsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_RECIPIENTS_ID, $recipientsId, $comparison);
    }

    /**
     * Filter the query on the job_type column
     *
     * Example usage:
     * <code>
     * $query->filterByJobType('fooValue');   // WHERE job_type = 'fooValue'
     * $query->filterByJobType('%fooValue%'); // WHERE job_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $jobType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByJobType($jobType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($jobType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_JOB_TYPE, $jobType, $comparison);
    }

    /**
     * Filter the query on the scheduled_time column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduledTime('fooValue');   // WHERE scheduled_time = 'fooValue'
     * $query->filterByScheduledTime('%fooValue%'); // WHERE scheduled_time LIKE '%fooValue%'
     * </code>
     *
     * @param     string $scheduledTime The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByScheduledTime($scheduledTime = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($scheduledTime)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_SCHEDULED_TIME, $scheduledTime, $comparison);
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
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(JobQueueTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobQueueTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Letters object
     *
     * @param \Letters|ObjectCollection $letters The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByLetters($letters, $comparison = null)
    {
        if ($letters instanceof \Letters) {
            return $this
                ->addUsingAlias(JobQueueTableMap::COL_LETTER_ID, $letters->getValue(), $comparison);
        } elseif ($letters instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobQueueTableMap::COL_LETTER_ID, $letters->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByLetters() only accepts arguments of type \Letters or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Letters relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function joinLetters($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Letters');

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
            $this->addJoinObject($join, 'Letters');
        }

        return $this;
    }

    /**
     * Use the Letters relation Letters object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LettersQuery A secondary query class using the current class as primary query
     */
    public function useLettersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLetters($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Letters', '\LettersQuery');
    }

    /**
     * Filter the query by a related \LetterQueue object
     *
     * @param \LetterQueue|ObjectCollection $letterQueue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJobQueueQuery The current query, for fluid interface
     */
    public function filterByLetterQueue($letterQueue, $comparison = null)
    {
        if ($letterQueue instanceof \LetterQueue) {
            return $this
                ->addUsingAlias(JobQueueTableMap::COL_VALUE, $letterQueue->getJobId(), $comparison);
        } elseif ($letterQueue instanceof ObjectCollection) {
            return $this
                ->useLetterQueueQuery()
                ->filterByPrimaryKeys($letterQueue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLetterQueue() only accepts arguments of type \LetterQueue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LetterQueue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function joinLetterQueue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LetterQueue');

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
            $this->addJoinObject($join, 'LetterQueue');
        }

        return $this;
    }

    /**
     * Use the LetterQueue relation LetterQueue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LetterQueueQuery A secondary query class using the current class as primary query
     */
    public function useLetterQueueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLetterQueue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LetterQueue', '\LetterQueueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJobQueue $jobQueue Object to remove from the list of results
     *
     * @return $this|ChildJobQueueQuery The current query, for fluid interface
     */
    public function prune($jobQueue = null)
    {
        if ($jobQueue) {
            $this->addUsingAlias(JobQueueTableMap::COL_VALUE, $jobQueue->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the job_queue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JobQueueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JobQueueTableMap::clearInstancePool();
            JobQueueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JobQueueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JobQueueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JobQueueTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JobQueueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JobQueueQuery
