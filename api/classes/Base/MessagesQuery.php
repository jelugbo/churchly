<?php

namespace Base;

use \Messages as ChildMessages;
use \MessagesQuery as ChildMessagesQuery;
use \Exception;
use \PDO;
use Map\MessagesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'messages' table.
 *
 * 
 *
 * @method     ChildMessagesQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildMessagesQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildMessagesQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildMessagesQuery orderByPayload($order = Criteria::ASC) Order by the payload column
 * @method     ChildMessagesQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     ChildMessagesQuery orderByScheduledTime($order = Criteria::ASC) Order by the scheduled_time column
 * @method     ChildMessagesQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildMessagesQuery orderByLastRun($order = Criteria::ASC) Order by the last_run column
 * @method     ChildMessagesQuery orderByLastDeviceId($order = Criteria::ASC) Order by the last_device_id column
 * @method     ChildMessagesQuery orderByLockedOut($order = Criteria::ASC) Order by the locked_out column
 * @method     ChildMessagesQuery orderByLockedOutTime($order = Criteria::ASC) Order by the locked_out_time column
 * @method     ChildMessagesQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildMessagesQuery groupByValue() Group by the value column
 * @method     ChildMessagesQuery groupByTitle() Group by the title column
 * @method     ChildMessagesQuery groupByMessage() Group by the message column
 * @method     ChildMessagesQuery groupByPayload() Group by the payload column
 * @method     ChildMessagesQuery groupByGroupId() Group by the group_id column
 * @method     ChildMessagesQuery groupByScheduledTime() Group by the scheduled_time column
 * @method     ChildMessagesQuery groupByStatus() Group by the status column
 * @method     ChildMessagesQuery groupByLastRun() Group by the last_run column
 * @method     ChildMessagesQuery groupByLastDeviceId() Group by the last_device_id column
 * @method     ChildMessagesQuery groupByLockedOut() Group by the locked_out column
 * @method     ChildMessagesQuery groupByLockedOutTime() Group by the locked_out_time column
 * @method     ChildMessagesQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildMessagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMessagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMessagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMessagesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMessagesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMessagesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMessagesQuery leftJoinEconnect($relationAlias = null) Adds a LEFT JOIN clause to the query using the Econnect relation
 * @method     ChildMessagesQuery rightJoinEconnect($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Econnect relation
 * @method     ChildMessagesQuery innerJoinEconnect($relationAlias = null) Adds a INNER JOIN clause to the query using the Econnect relation
 *
 * @method     ChildMessagesQuery joinWithEconnect($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Econnect relation
 *
 * @method     ChildMessagesQuery leftJoinWithEconnect() Adds a LEFT JOIN clause and with to the query using the Econnect relation
 * @method     ChildMessagesQuery rightJoinWithEconnect() Adds a RIGHT JOIN clause and with to the query using the Econnect relation
 * @method     ChildMessagesQuery innerJoinWithEconnect() Adds a INNER JOIN clause and with to the query using the Econnect relation
 *
 * @method     \EconnectQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMessages findOne(ConnectionInterface $con = null) Return the first ChildMessages matching the query
 * @method     ChildMessages findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMessages matching the query, or a new ChildMessages object populated from the query conditions when no match is found
 *
 * @method     ChildMessages findOneByValue(int $value) Return the first ChildMessages filtered by the value column
 * @method     ChildMessages findOneByTitle(string $title) Return the first ChildMessages filtered by the title column
 * @method     ChildMessages findOneByMessage(string $message) Return the first ChildMessages filtered by the message column
 * @method     ChildMessages findOneByPayload(string $payload) Return the first ChildMessages filtered by the payload column
 * @method     ChildMessages findOneByGroupId(int $group_id) Return the first ChildMessages filtered by the group_id column
 * @method     ChildMessages findOneByScheduledTime(string $scheduled_time) Return the first ChildMessages filtered by the scheduled_time column
 * @method     ChildMessages findOneByStatus(int $status) Return the first ChildMessages filtered by the status column
 * @method     ChildMessages findOneByLastRun(string $last_run) Return the first ChildMessages filtered by the last_run column
 * @method     ChildMessages findOneByLastDeviceId(int $last_device_id) Return the first ChildMessages filtered by the last_device_id column
 * @method     ChildMessages findOneByLockedOut(int $locked_out) Return the first ChildMessages filtered by the locked_out column
 * @method     ChildMessages findOneByLockedOutTime(string $locked_out_time) Return the first ChildMessages filtered by the locked_out_time column
 * @method     ChildMessages findOneByCreatedAt(string $created_at) Return the first ChildMessages filtered by the created_at column *

 * @method     ChildMessages requirePk($key, ConnectionInterface $con = null) Return the ChildMessages by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOne(ConnectionInterface $con = null) Return the first ChildMessages matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessages requireOneByValue(int $value) Return the first ChildMessages filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByTitle(string $title) Return the first ChildMessages filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByMessage(string $message) Return the first ChildMessages filtered by the message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByPayload(string $payload) Return the first ChildMessages filtered by the payload column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByGroupId(int $group_id) Return the first ChildMessages filtered by the group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByScheduledTime(string $scheduled_time) Return the first ChildMessages filtered by the scheduled_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByStatus(int $status) Return the first ChildMessages filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByLastRun(string $last_run) Return the first ChildMessages filtered by the last_run column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByLastDeviceId(int $last_device_id) Return the first ChildMessages filtered by the last_device_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByLockedOut(int $locked_out) Return the first ChildMessages filtered by the locked_out column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByLockedOutTime(string $locked_out_time) Return the first ChildMessages filtered by the locked_out_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByCreatedAt(string $created_at) Return the first ChildMessages filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessages[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMessages objects based on current ModelCriteria
 * @method     ChildMessages[]|ObjectCollection findByValue(int $value) Return ChildMessages objects filtered by the value column
 * @method     ChildMessages[]|ObjectCollection findByTitle(string $title) Return ChildMessages objects filtered by the title column
 * @method     ChildMessages[]|ObjectCollection findByMessage(string $message) Return ChildMessages objects filtered by the message column
 * @method     ChildMessages[]|ObjectCollection findByPayload(string $payload) Return ChildMessages objects filtered by the payload column
 * @method     ChildMessages[]|ObjectCollection findByGroupId(int $group_id) Return ChildMessages objects filtered by the group_id column
 * @method     ChildMessages[]|ObjectCollection findByScheduledTime(string $scheduled_time) Return ChildMessages objects filtered by the scheduled_time column
 * @method     ChildMessages[]|ObjectCollection findByStatus(int $status) Return ChildMessages objects filtered by the status column
 * @method     ChildMessages[]|ObjectCollection findByLastRun(string $last_run) Return ChildMessages objects filtered by the last_run column
 * @method     ChildMessages[]|ObjectCollection findByLastDeviceId(int $last_device_id) Return ChildMessages objects filtered by the last_device_id column
 * @method     ChildMessages[]|ObjectCollection findByLockedOut(int $locked_out) Return ChildMessages objects filtered by the locked_out column
 * @method     ChildMessages[]|ObjectCollection findByLockedOutTime(string $locked_out_time) Return ChildMessages objects filtered by the locked_out_time column
 * @method     ChildMessages[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildMessages objects filtered by the created_at column
 * @method     ChildMessages[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MessagesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MessagesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Messages', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMessagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMessagesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMessagesQuery) {
            return $criteria;
        }
        $query = new ChildMessagesQuery();
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
     * @return ChildMessages|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MessagesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MessagesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMessages A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, title, message, payload, group_id, scheduled_time, status, last_run, last_device_id, locked_out, locked_out_time, created_at FROM messages WHERE value = :p0';
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
            /** @var ChildMessages $obj */
            $obj = new ChildMessages();
            $obj->hydrate($row);
            MessagesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMessages|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MessagesTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MessagesTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the payload column
     *
     * Example usage:
     * <code>
     * $query->filterByPayload('fooValue');   // WHERE payload = 'fooValue'
     * $query->filterByPayload('%fooValue%'); // WHERE payload LIKE '%fooValue%'
     * </code>
     *
     * @param     string $payload The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByPayload($payload = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($payload)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_PAYLOAD, $payload, $comparison);
    }

    /**
     * Filter the query on the group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupId(1234); // WHERE group_id = 1234
     * $query->filterByGroupId(array(12, 34)); // WHERE group_id IN (12, 34)
     * $query->filterByGroupId(array('min' => 12)); // WHERE group_id > 12
     * </code>
     *
     * @see       filterByEconnect()
     *
     * @param     mixed $groupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByGroupId($groupId = null, $comparison = null)
    {
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_GROUP_ID, $groupId, $comparison);
    }

    /**
     * Filter the query on the scheduled_time column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduledTime('2011-03-14'); // WHERE scheduled_time = '2011-03-14'
     * $query->filterByScheduledTime('now'); // WHERE scheduled_time = '2011-03-14'
     * $query->filterByScheduledTime(array('max' => 'yesterday')); // WHERE scheduled_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $scheduledTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByScheduledTime($scheduledTime = null, $comparison = null)
    {
        if (is_array($scheduledTime)) {
            $useMinMax = false;
            if (isset($scheduledTime['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_SCHEDULED_TIME, $scheduledTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($scheduledTime['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_SCHEDULED_TIME, $scheduledTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_SCHEDULED_TIME, $scheduledTime, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the last_run column
     *
     * Example usage:
     * <code>
     * $query->filterByLastRun('2011-03-14'); // WHERE last_run = '2011-03-14'
     * $query->filterByLastRun('now'); // WHERE last_run = '2011-03-14'
     * $query->filterByLastRun(array('max' => 'yesterday')); // WHERE last_run > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastRun The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByLastRun($lastRun = null, $comparison = null)
    {
        if (is_array($lastRun)) {
            $useMinMax = false;
            if (isset($lastRun['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LAST_RUN, $lastRun['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastRun['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LAST_RUN, $lastRun['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_LAST_RUN, $lastRun, $comparison);
    }

    /**
     * Filter the query on the last_device_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLastDeviceId(1234); // WHERE last_device_id = 1234
     * $query->filterByLastDeviceId(array(12, 34)); // WHERE last_device_id IN (12, 34)
     * $query->filterByLastDeviceId(array('min' => 12)); // WHERE last_device_id > 12
     * </code>
     *
     * @param     mixed $lastDeviceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByLastDeviceId($lastDeviceId = null, $comparison = null)
    {
        if (is_array($lastDeviceId)) {
            $useMinMax = false;
            if (isset($lastDeviceId['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LAST_DEVICE_ID, $lastDeviceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastDeviceId['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LAST_DEVICE_ID, $lastDeviceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_LAST_DEVICE_ID, $lastDeviceId, $comparison);
    }

    /**
     * Filter the query on the locked_out column
     *
     * Example usage:
     * <code>
     * $query->filterByLockedOut(1234); // WHERE locked_out = 1234
     * $query->filterByLockedOut(array(12, 34)); // WHERE locked_out IN (12, 34)
     * $query->filterByLockedOut(array('min' => 12)); // WHERE locked_out > 12
     * </code>
     *
     * @param     mixed $lockedOut The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByLockedOut($lockedOut = null, $comparison = null)
    {
        if (is_array($lockedOut)) {
            $useMinMax = false;
            if (isset($lockedOut['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT, $lockedOut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lockedOut['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT, $lockedOut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT, $lockedOut, $comparison);
    }

    /**
     * Filter the query on the locked_out_time column
     *
     * Example usage:
     * <code>
     * $query->filterByLockedOutTime('2011-03-14'); // WHERE locked_out_time = '2011-03-14'
     * $query->filterByLockedOutTime('now'); // WHERE locked_out_time = '2011-03-14'
     * $query->filterByLockedOutTime(array('max' => 'yesterday')); // WHERE locked_out_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $lockedOutTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByLockedOutTime($lockedOutTime = null, $comparison = null)
    {
        if (is_array($lockedOutTime)) {
            $useMinMax = false;
            if (isset($lockedOutTime['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT_TIME, $lockedOutTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lockedOutTime['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT_TIME, $lockedOutTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_LOCKED_OUT_TIME, $lockedOutTime, $comparison);
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
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Econnect object
     *
     * @param \Econnect|ObjectCollection $econnect The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByEconnect($econnect, $comparison = null)
    {
        if ($econnect instanceof \Econnect) {
            return $this
                ->addUsingAlias(MessagesTableMap::COL_GROUP_ID, $econnect->getValue(), $comparison);
        } elseif ($econnect instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MessagesTableMap::COL_GROUP_ID, $econnect->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByEconnect() only accepts arguments of type \Econnect or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Econnect relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function joinEconnect($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Econnect');

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
            $this->addJoinObject($join, 'Econnect');
        }

        return $this;
    }

    /**
     * Use the Econnect relation Econnect object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EconnectQuery A secondary query class using the current class as primary query
     */
    public function useEconnectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEconnect($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Econnect', '\EconnectQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMessages $messages Object to remove from the list of results
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function prune($messages = null)
    {
        if ($messages) {
            $this->addUsingAlias(MessagesTableMap::COL_VALUE, $messages->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the messages table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MessagesTableMap::clearInstancePool();
            MessagesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MessagesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MessagesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MessagesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MessagesQuery
