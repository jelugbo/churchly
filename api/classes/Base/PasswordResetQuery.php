<?php

namespace Base;

use \PasswordReset as ChildPasswordReset;
use \PasswordResetQuery as ChildPasswordResetQuery;
use \Exception;
use \PDO;
use Map\PasswordResetTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'password_reset' table.
 *
 * 
 *
 * @method     ChildPasswordResetQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildPasswordResetQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildPasswordResetQuery orderByToken($order = Criteria::ASC) Order by the token column
 * @method     ChildPasswordResetQuery orderByAttempts($order = Criteria::ASC) Order by the attempts column
 * @method     ChildPasswordResetQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 *
 * @method     ChildPasswordResetQuery groupByValue() Group by the value column
 * @method     ChildPasswordResetQuery groupByUsername() Group by the username column
 * @method     ChildPasswordResetQuery groupByToken() Group by the token column
 * @method     ChildPasswordResetQuery groupByAttempts() Group by the attempts column
 * @method     ChildPasswordResetQuery groupByTimestamp() Group by the timestamp column
 *
 * @method     ChildPasswordResetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPasswordResetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPasswordResetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPasswordResetQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPasswordResetQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPasswordResetQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPasswordReset findOne(ConnectionInterface $con = null) Return the first ChildPasswordReset matching the query
 * @method     ChildPasswordReset findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPasswordReset matching the query, or a new ChildPasswordReset object populated from the query conditions when no match is found
 *
 * @method     ChildPasswordReset findOneByValue(int $value) Return the first ChildPasswordReset filtered by the value column
 * @method     ChildPasswordReset findOneByUsername(string $username) Return the first ChildPasswordReset filtered by the username column
 * @method     ChildPasswordReset findOneByToken(string $token) Return the first ChildPasswordReset filtered by the token column
 * @method     ChildPasswordReset findOneByAttempts(int $attempts) Return the first ChildPasswordReset filtered by the attempts column
 * @method     ChildPasswordReset findOneByTimestamp(string $timestamp) Return the first ChildPasswordReset filtered by the timestamp column *

 * @method     ChildPasswordReset requirePk($key, ConnectionInterface $con = null) Return the ChildPasswordReset by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPasswordReset requireOne(ConnectionInterface $con = null) Return the first ChildPasswordReset matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPasswordReset requireOneByValue(int $value) Return the first ChildPasswordReset filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPasswordReset requireOneByUsername(string $username) Return the first ChildPasswordReset filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPasswordReset requireOneByToken(string $token) Return the first ChildPasswordReset filtered by the token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPasswordReset requireOneByAttempts(int $attempts) Return the first ChildPasswordReset filtered by the attempts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPasswordReset requireOneByTimestamp(string $timestamp) Return the first ChildPasswordReset filtered by the timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPasswordReset[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPasswordReset objects based on current ModelCriteria
 * @method     ChildPasswordReset[]|ObjectCollection findByValue(int $value) Return ChildPasswordReset objects filtered by the value column
 * @method     ChildPasswordReset[]|ObjectCollection findByUsername(string $username) Return ChildPasswordReset objects filtered by the username column
 * @method     ChildPasswordReset[]|ObjectCollection findByToken(string $token) Return ChildPasswordReset objects filtered by the token column
 * @method     ChildPasswordReset[]|ObjectCollection findByAttempts(int $attempts) Return ChildPasswordReset objects filtered by the attempts column
 * @method     ChildPasswordReset[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildPasswordReset objects filtered by the timestamp column
 * @method     ChildPasswordReset[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PasswordResetQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PasswordResetQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PasswordReset', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPasswordResetQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPasswordResetQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPasswordResetQuery) {
            return $criteria;
        }
        $query = new ChildPasswordResetQuery();
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
     * @return ChildPasswordReset|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PasswordResetTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PasswordResetTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPasswordReset A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, username, token, attempts, timestamp FROM password_reset WHERE value = :p0';
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
            /** @var ChildPasswordReset $obj */
            $obj = new ChildPasswordReset();
            $obj->hydrate($row);
            PasswordResetTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPasswordReset|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PasswordResetTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the token column
     *
     * Example usage:
     * <code>
     * $query->filterByToken('fooValue');   // WHERE token = 'fooValue'
     * $query->filterByToken('%fooValue%'); // WHERE token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $token The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByToken($token = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($token)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PasswordResetTableMap::COL_TOKEN, $token, $comparison);
    }

    /**
     * Filter the query on the attempts column
     *
     * Example usage:
     * <code>
     * $query->filterByAttempts(1234); // WHERE attempts = 1234
     * $query->filterByAttempts(array(12, 34)); // WHERE attempts IN (12, 34)
     * $query->filterByAttempts(array('min' => 12)); // WHERE attempts > 12
     * </code>
     *
     * @param     mixed $attempts The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByAttempts($attempts = null, $comparison = null)
    {
        if (is_array($attempts)) {
            $useMinMax = false;
            if (isset($attempts['min'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_ATTEMPTS, $attempts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($attempts['max'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_ATTEMPTS, $attempts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PasswordResetTableMap::COL_ATTEMPTS, $attempts, $comparison);
    }

    /**
     * Filter the query on the timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestamp('2011-03-14'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp('now'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp(array('max' => 'yesterday')); // WHERE timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(PasswordResetTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PasswordResetTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPasswordReset $passwordReset Object to remove from the list of results
     *
     * @return $this|ChildPasswordResetQuery The current query, for fluid interface
     */
    public function prune($passwordReset = null)
    {
        if ($passwordReset) {
            $this->addUsingAlias(PasswordResetTableMap::COL_VALUE, $passwordReset->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the password_reset table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PasswordResetTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PasswordResetTableMap::clearInstancePool();
            PasswordResetTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PasswordResetTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PasswordResetTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PasswordResetTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PasswordResetTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PasswordResetQuery
