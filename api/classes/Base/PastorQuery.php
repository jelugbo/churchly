<?php

namespace Base;

use \Pastor as ChildPastor;
use \PastorQuery as ChildPastorQuery;
use \Exception;
use \PDO;
use Map\PastorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pastor' table.
 *
 * 
 *
 * @method     ChildPastorQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildPastorQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPastorQuery orderByFname($order = Criteria::ASC) Order by the fname column
 * @method     ChildPastorQuery orderByLname($order = Criteria::ASC) Order by the lname column
 * @method     ChildPastorQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildPastorQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildPastorQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildPastorQuery orderByContactDate($order = Criteria::ASC) Order by the contact_date column
 * @method     ChildPastorQuery orderByContactTime($order = Criteria::ASC) Order by the contact_time column
 * @method     ChildPastorQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildPastorQuery groupByValue() Group by the value column
 * @method     ChildPastorQuery groupByUserId() Group by the user_id column
 * @method     ChildPastorQuery groupByFname() Group by the fname column
 * @method     ChildPastorQuery groupByLname() Group by the lname column
 * @method     ChildPastorQuery groupByPhone() Group by the phone column
 * @method     ChildPastorQuery groupByEmail() Group by the email column
 * @method     ChildPastorQuery groupByComment() Group by the comment column
 * @method     ChildPastorQuery groupByContactDate() Group by the contact_date column
 * @method     ChildPastorQuery groupByContactTime() Group by the contact_time column
 * @method     ChildPastorQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildPastorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPastorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPastorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPastorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPastorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPastorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPastorQuery leftJoinUserProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserProfile relation
 * @method     ChildPastorQuery rightJoinUserProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserProfile relation
 * @method     ChildPastorQuery innerJoinUserProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the UserProfile relation
 *
 * @method     ChildPastorQuery joinWithUserProfile($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserProfile relation
 *
 * @method     ChildPastorQuery leftJoinWithUserProfile() Adds a LEFT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildPastorQuery rightJoinWithUserProfile() Adds a RIGHT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildPastorQuery innerJoinWithUserProfile() Adds a INNER JOIN clause and with to the query using the UserProfile relation
 *
 * @method     \UserProfileQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPastor findOne(ConnectionInterface $con = null) Return the first ChildPastor matching the query
 * @method     ChildPastor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPastor matching the query, or a new ChildPastor object populated from the query conditions when no match is found
 *
 * @method     ChildPastor findOneByValue(int $value) Return the first ChildPastor filtered by the value column
 * @method     ChildPastor findOneByUserId(int $user_id) Return the first ChildPastor filtered by the user_id column
 * @method     ChildPastor findOneByFname(string $fname) Return the first ChildPastor filtered by the fname column
 * @method     ChildPastor findOneByLname(string $lname) Return the first ChildPastor filtered by the lname column
 * @method     ChildPastor findOneByPhone(string $phone) Return the first ChildPastor filtered by the phone column
 * @method     ChildPastor findOneByEmail(string $email) Return the first ChildPastor filtered by the email column
 * @method     ChildPastor findOneByComment(string $comment) Return the first ChildPastor filtered by the comment column
 * @method     ChildPastor findOneByContactDate(string $contact_date) Return the first ChildPastor filtered by the contact_date column
 * @method     ChildPastor findOneByContactTime(string $contact_time) Return the first ChildPastor filtered by the contact_time column
 * @method     ChildPastor findOneByCreatedAt(string $created_at) Return the first ChildPastor filtered by the created_at column *

 * @method     ChildPastor requirePk($key, ConnectionInterface $con = null) Return the ChildPastor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOne(ConnectionInterface $con = null) Return the first ChildPastor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPastor requireOneByValue(int $value) Return the first ChildPastor filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByUserId(int $user_id) Return the first ChildPastor filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByFname(string $fname) Return the first ChildPastor filtered by the fname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByLname(string $lname) Return the first ChildPastor filtered by the lname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByPhone(string $phone) Return the first ChildPastor filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByEmail(string $email) Return the first ChildPastor filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByComment(string $comment) Return the first ChildPastor filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByContactDate(string $contact_date) Return the first ChildPastor filtered by the contact_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByContactTime(string $contact_time) Return the first ChildPastor filtered by the contact_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPastor requireOneByCreatedAt(string $created_at) Return the first ChildPastor filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPastor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPastor objects based on current ModelCriteria
 * @method     ChildPastor[]|ObjectCollection findByValue(int $value) Return ChildPastor objects filtered by the value column
 * @method     ChildPastor[]|ObjectCollection findByUserId(int $user_id) Return ChildPastor objects filtered by the user_id column
 * @method     ChildPastor[]|ObjectCollection findByFname(string $fname) Return ChildPastor objects filtered by the fname column
 * @method     ChildPastor[]|ObjectCollection findByLname(string $lname) Return ChildPastor objects filtered by the lname column
 * @method     ChildPastor[]|ObjectCollection findByPhone(string $phone) Return ChildPastor objects filtered by the phone column
 * @method     ChildPastor[]|ObjectCollection findByEmail(string $email) Return ChildPastor objects filtered by the email column
 * @method     ChildPastor[]|ObjectCollection findByComment(string $comment) Return ChildPastor objects filtered by the comment column
 * @method     ChildPastor[]|ObjectCollection findByContactDate(string $contact_date) Return ChildPastor objects filtered by the contact_date column
 * @method     ChildPastor[]|ObjectCollection findByContactTime(string $contact_time) Return ChildPastor objects filtered by the contact_time column
 * @method     ChildPastor[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPastor objects filtered by the created_at column
 * @method     ChildPastor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PastorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PastorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Pastor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPastorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPastorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPastorQuery) {
            return $criteria;
        }
        $query = new ChildPastorQuery();
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
     * @return ChildPastor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PastorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PastorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPastor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, user_id, fname, lname, phone, email, comment, contact_date, contact_time, created_at FROM pastor WHERE value = :p0';
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
            /** @var ChildPastor $obj */
            $obj = new ChildPastor();
            $obj->hydrate($row);
            PastorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPastor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PastorTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PastorTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(PastorTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(PastorTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_VALUE, $value, $comparison);
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
     * @see       filterByUserProfile()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(PastorTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(PastorTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the fname column
     *
     * Example usage:
     * <code>
     * $query->filterByFname('fooValue');   // WHERE fname = 'fooValue'
     * $query->filterByFname('%fooValue%'); // WHERE fname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByFname($fname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_FNAME, $fname, $comparison);
    }

    /**
     * Filter the query on the lname column
     *
     * Example usage:
     * <code>
     * $query->filterByLname('fooValue');   // WHERE lname = 'fooValue'
     * $query->filterByLname('%fooValue%'); // WHERE lname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByLname($lname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_LNAME, $lname, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the contact_date column
     *
     * Example usage:
     * <code>
     * $query->filterByContactDate('fooValue');   // WHERE contact_date = 'fooValue'
     * $query->filterByContactDate('%fooValue%'); // WHERE contact_date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contactDate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByContactDate($contactDate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contactDate)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_CONTACT_DATE, $contactDate, $comparison);
    }

    /**
     * Filter the query on the contact_time column
     *
     * Example usage:
     * <code>
     * $query->filterByContactTime('fooValue');   // WHERE contact_time = 'fooValue'
     * $query->filterByContactTime('%fooValue%'); // WHERE contact_time LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contactTime The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByContactTime($contactTime = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contactTime)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_CONTACT_TIME, $contactTime, $comparison);
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
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PastorTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PastorTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PastorTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \UserProfile object
     *
     * @param \UserProfile|ObjectCollection $userProfile The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPastorQuery The current query, for fluid interface
     */
    public function filterByUserProfile($userProfile, $comparison = null)
    {
        if ($userProfile instanceof \UserProfile) {
            return $this
                ->addUsingAlias(PastorTableMap::COL_USER_ID, $userProfile->getValue(), $comparison);
        } elseif ($userProfile instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PastorTableMap::COL_USER_ID, $userProfile->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildPastorQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPastor $pastor Object to remove from the list of results
     *
     * @return $this|ChildPastorQuery The current query, for fluid interface
     */
    public function prune($pastor = null)
    {
        if ($pastor) {
            $this->addUsingAlias(PastorTableMap::COL_VALUE, $pastor->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pastor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PastorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PastorTableMap::clearInstancePool();
            PastorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PastorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PastorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PastorTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PastorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PastorQuery
