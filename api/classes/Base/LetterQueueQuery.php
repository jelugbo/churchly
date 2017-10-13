<?php

namespace Base;

use \LetterQueue as ChildLetterQueue;
use \LetterQueueQuery as ChildLetterQueueQuery;
use \Exception;
use \PDO;
use Map\LetterQueueTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'letter_queue' table.
 *
 * 
 *
 * @method     ChildLetterQueueQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildLetterQueueQuery orderByJobId($order = Criteria::ASC) Order by the job_id column
 * @method     ChildLetterQueueQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method     ChildLetterQueueQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildLetterQueueQuery orderByFromName($order = Criteria::ASC) Order by the from_name column
 * @method     ChildLetterQueueQuery orderByFromEmail($order = Criteria::ASC) Order by the from_email column
 * @method     ChildLetterQueueQuery orderByToName($order = Criteria::ASC) Order by the to_name column
 * @method     ChildLetterQueueQuery orderByToEmail($order = Criteria::ASC) Order by the to_email column
 * @method     ChildLetterQueueQuery orderByCount($order = Criteria::ASC) Order by the count column
 * @method     ChildLetterQueueQuery orderByLastStatusMsg($order = Criteria::ASC) Order by the last_status_msg column
 * @method     ChildLetterQueueQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildLetterQueueQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildLetterQueueQuery groupByValue() Group by the value column
 * @method     ChildLetterQueueQuery groupByJobId() Group by the job_id column
 * @method     ChildLetterQueueQuery groupBySubject() Group by the subject column
 * @method     ChildLetterQueueQuery groupByMessage() Group by the message column
 * @method     ChildLetterQueueQuery groupByFromName() Group by the from_name column
 * @method     ChildLetterQueueQuery groupByFromEmail() Group by the from_email column
 * @method     ChildLetterQueueQuery groupByToName() Group by the to_name column
 * @method     ChildLetterQueueQuery groupByToEmail() Group by the to_email column
 * @method     ChildLetterQueueQuery groupByCount() Group by the count column
 * @method     ChildLetterQueueQuery groupByLastStatusMsg() Group by the last_status_msg column
 * @method     ChildLetterQueueQuery groupByStatus() Group by the status column
 * @method     ChildLetterQueueQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildLetterQueueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLetterQueueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLetterQueueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLetterQueueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLetterQueueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLetterQueueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLetterQueueQuery leftJoinJobQueue($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobQueue relation
 * @method     ChildLetterQueueQuery rightJoinJobQueue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobQueue relation
 * @method     ChildLetterQueueQuery innerJoinJobQueue($relationAlias = null) Adds a INNER JOIN clause to the query using the JobQueue relation
 *
 * @method     ChildLetterQueueQuery joinWithJobQueue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JobQueue relation
 *
 * @method     ChildLetterQueueQuery leftJoinWithJobQueue() Adds a LEFT JOIN clause and with to the query using the JobQueue relation
 * @method     ChildLetterQueueQuery rightJoinWithJobQueue() Adds a RIGHT JOIN clause and with to the query using the JobQueue relation
 * @method     ChildLetterQueueQuery innerJoinWithJobQueue() Adds a INNER JOIN clause and with to the query using the JobQueue relation
 *
 * @method     \JobQueueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLetterQueue findOne(ConnectionInterface $con = null) Return the first ChildLetterQueue matching the query
 * @method     ChildLetterQueue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLetterQueue matching the query, or a new ChildLetterQueue object populated from the query conditions when no match is found
 *
 * @method     ChildLetterQueue findOneByValue(int $value) Return the first ChildLetterQueue filtered by the value column
 * @method     ChildLetterQueue findOneByJobId(int $job_id) Return the first ChildLetterQueue filtered by the job_id column
 * @method     ChildLetterQueue findOneBySubject(string $subject) Return the first ChildLetterQueue filtered by the subject column
 * @method     ChildLetterQueue findOneByMessage(string $message) Return the first ChildLetterQueue filtered by the message column
 * @method     ChildLetterQueue findOneByFromName(string $from_name) Return the first ChildLetterQueue filtered by the from_name column
 * @method     ChildLetterQueue findOneByFromEmail(string $from_email) Return the first ChildLetterQueue filtered by the from_email column
 * @method     ChildLetterQueue findOneByToName(string $to_name) Return the first ChildLetterQueue filtered by the to_name column
 * @method     ChildLetterQueue findOneByToEmail(string $to_email) Return the first ChildLetterQueue filtered by the to_email column
 * @method     ChildLetterQueue findOneByCount(int $count) Return the first ChildLetterQueue filtered by the count column
 * @method     ChildLetterQueue findOneByLastStatusMsg(string $last_status_msg) Return the first ChildLetterQueue filtered by the last_status_msg column
 * @method     ChildLetterQueue findOneByStatus(string $status) Return the first ChildLetterQueue filtered by the status column
 * @method     ChildLetterQueue findOneByCreatedAt(string $created_at) Return the first ChildLetterQueue filtered by the created_at column *

 * @method     ChildLetterQueue requirePk($key, ConnectionInterface $con = null) Return the ChildLetterQueue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOne(ConnectionInterface $con = null) Return the first ChildLetterQueue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLetterQueue requireOneByValue(int $value) Return the first ChildLetterQueue filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByJobId(int $job_id) Return the first ChildLetterQueue filtered by the job_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneBySubject(string $subject) Return the first ChildLetterQueue filtered by the subject column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByMessage(string $message) Return the first ChildLetterQueue filtered by the message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByFromName(string $from_name) Return the first ChildLetterQueue filtered by the from_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByFromEmail(string $from_email) Return the first ChildLetterQueue filtered by the from_email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByToName(string $to_name) Return the first ChildLetterQueue filtered by the to_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByToEmail(string $to_email) Return the first ChildLetterQueue filtered by the to_email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByCount(int $count) Return the first ChildLetterQueue filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByLastStatusMsg(string $last_status_msg) Return the first ChildLetterQueue filtered by the last_status_msg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByStatus(string $status) Return the first ChildLetterQueue filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetterQueue requireOneByCreatedAt(string $created_at) Return the first ChildLetterQueue filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLetterQueue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLetterQueue objects based on current ModelCriteria
 * @method     ChildLetterQueue[]|ObjectCollection findByValue(int $value) Return ChildLetterQueue objects filtered by the value column
 * @method     ChildLetterQueue[]|ObjectCollection findByJobId(int $job_id) Return ChildLetterQueue objects filtered by the job_id column
 * @method     ChildLetterQueue[]|ObjectCollection findBySubject(string $subject) Return ChildLetterQueue objects filtered by the subject column
 * @method     ChildLetterQueue[]|ObjectCollection findByMessage(string $message) Return ChildLetterQueue objects filtered by the message column
 * @method     ChildLetterQueue[]|ObjectCollection findByFromName(string $from_name) Return ChildLetterQueue objects filtered by the from_name column
 * @method     ChildLetterQueue[]|ObjectCollection findByFromEmail(string $from_email) Return ChildLetterQueue objects filtered by the from_email column
 * @method     ChildLetterQueue[]|ObjectCollection findByToName(string $to_name) Return ChildLetterQueue objects filtered by the to_name column
 * @method     ChildLetterQueue[]|ObjectCollection findByToEmail(string $to_email) Return ChildLetterQueue objects filtered by the to_email column
 * @method     ChildLetterQueue[]|ObjectCollection findByCount(int $count) Return ChildLetterQueue objects filtered by the count column
 * @method     ChildLetterQueue[]|ObjectCollection findByLastStatusMsg(string $last_status_msg) Return ChildLetterQueue objects filtered by the last_status_msg column
 * @method     ChildLetterQueue[]|ObjectCollection findByStatus(string $status) Return ChildLetterQueue objects filtered by the status column
 * @method     ChildLetterQueue[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildLetterQueue objects filtered by the created_at column
 * @method     ChildLetterQueue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LetterQueueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LetterQueueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\LetterQueue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLetterQueueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLetterQueueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLetterQueueQuery) {
            return $criteria;
        }
        $query = new ChildLetterQueueQuery();
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
     * @return ChildLetterQueue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LetterQueueTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LetterQueueTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildLetterQueue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, job_id, subject, message, from_name, from_email, to_name, to_email, count, last_status_msg, status, created_at FROM letter_queue WHERE value = :p0';
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
            /** @var ChildLetterQueue $obj */
            $obj = new ChildLetterQueue();
            $obj->hydrate($row);
            LetterQueueTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLetterQueue|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the job_id column
     *
     * Example usage:
     * <code>
     * $query->filterByJobId(1234); // WHERE job_id = 1234
     * $query->filterByJobId(array(12, 34)); // WHERE job_id IN (12, 34)
     * $query->filterByJobId(array('min' => 12)); // WHERE job_id > 12
     * </code>
     *
     * @see       filterByJobQueue()
     *
     * @param     mixed $jobId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByJobId($jobId = null, $comparison = null)
    {
        if (is_array($jobId)) {
            $useMinMax = false;
            if (isset($jobId['min'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_JOB_ID, $jobId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($jobId['max'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_JOB_ID, $jobId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_JOB_ID, $jobId, $comparison);
    }

    /**
     * Filter the query on the subject column
     *
     * Example usage:
     * <code>
     * $query->filterBySubject('fooValue');   // WHERE subject = 'fooValue'
     * $query->filterBySubject('%fooValue%'); // WHERE subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subject The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_SUBJECT, $subject, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the from_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFromName('fooValue');   // WHERE from_name = 'fooValue'
     * $query->filterByFromName('%fooValue%'); // WHERE from_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fromName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByFromName($fromName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fromName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_FROM_NAME, $fromName, $comparison);
    }

    /**
     * Filter the query on the from_email column
     *
     * Example usage:
     * <code>
     * $query->filterByFromEmail('fooValue');   // WHERE from_email = 'fooValue'
     * $query->filterByFromEmail('%fooValue%'); // WHERE from_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fromEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByFromEmail($fromEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fromEmail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_FROM_EMAIL, $fromEmail, $comparison);
    }

    /**
     * Filter the query on the to_name column
     *
     * Example usage:
     * <code>
     * $query->filterByToName('fooValue');   // WHERE to_name = 'fooValue'
     * $query->filterByToName('%fooValue%'); // WHERE to_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $toName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByToName($toName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($toName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_TO_NAME, $toName, $comparison);
    }

    /**
     * Filter the query on the to_email column
     *
     * Example usage:
     * <code>
     * $query->filterByToEmail('fooValue');   // WHERE to_email = 'fooValue'
     * $query->filterByToEmail('%fooValue%'); // WHERE to_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $toEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByToEmail($toEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($toEmail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_TO_EMAIL, $toEmail, $comparison);
    }

    /**
     * Filter the query on the count column
     *
     * Example usage:
     * <code>
     * $query->filterByCount(1234); // WHERE count = 1234
     * $query->filterByCount(array(12, 34)); // WHERE count IN (12, 34)
     * $query->filterByCount(array('min' => 12)); // WHERE count > 12
     * </code>
     *
     * @param     mixed $count The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByCount($count = null, $comparison = null)
    {
        if (is_array($count)) {
            $useMinMax = false;
            if (isset($count['min'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_COUNT, $count, $comparison);
    }

    /**
     * Filter the query on the last_status_msg column
     *
     * Example usage:
     * <code>
     * $query->filterByLastStatusMsg('fooValue');   // WHERE last_status_msg = 'fooValue'
     * $query->filterByLastStatusMsg('%fooValue%'); // WHERE last_status_msg LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastStatusMsg The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByLastStatusMsg($lastStatusMsg = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastStatusMsg)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_LAST_STATUS_MSG, $lastStatusMsg, $comparison);
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
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(LetterQueueTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LetterQueueTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \JobQueue object
     *
     * @param \JobQueue|ObjectCollection $jobQueue The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLetterQueueQuery The current query, for fluid interface
     */
    public function filterByJobQueue($jobQueue, $comparison = null)
    {
        if ($jobQueue instanceof \JobQueue) {
            return $this
                ->addUsingAlias(LetterQueueTableMap::COL_JOB_ID, $jobQueue->getValue(), $comparison);
        } elseif ($jobQueue instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LetterQueueTableMap::COL_JOB_ID, $jobQueue->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByJobQueue() only accepts arguments of type \JobQueue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobQueue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function joinJobQueue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobQueue');

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
            $this->addJoinObject($join, 'JobQueue');
        }

        return $this;
    }

    /**
     * Use the JobQueue relation JobQueue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JobQueueQuery A secondary query class using the current class as primary query
     */
    public function useJobQueueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobQueue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobQueue', '\JobQueueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLetterQueue $letterQueue Object to remove from the list of results
     *
     * @return $this|ChildLetterQueueQuery The current query, for fluid interface
     */
    public function prune($letterQueue = null)
    {
        if ($letterQueue) {
            $this->addUsingAlias(LetterQueueTableMap::COL_VALUE, $letterQueue->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the letter_queue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LetterQueueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LetterQueueTableMap::clearInstancePool();
            LetterQueueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LetterQueueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LetterQueueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            LetterQueueTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            LetterQueueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LetterQueueQuery
