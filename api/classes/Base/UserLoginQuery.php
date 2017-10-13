<?php

namespace Base;

use \UserLogin as ChildUserLogin;
use \UserLoginQuery as ChildUserLoginQuery;
use \Exception;
use \PDO;
use Map\UserLoginTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_login' table.
 *
 * 
 *
 * @method     ChildUserLoginQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUserLoginQuery orderByEnvelope($order = Criteria::ASC) Order by the envelope column
 * @method     ChildUserLoginQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserLoginQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUserLoginQuery orderBySalt($order = Criteria::ASC) Order by the salt column
 * @method     ChildUserLoginQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildUserLoginQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 * @method     ChildUserLoginQuery orderByLastLogin($order = Criteria::ASC) Order by the last_login column
 * @method     ChildUserLoginQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method     ChildUserLoginQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildUserLoginQuery groupByValue() Group by the value column
 * @method     ChildUserLoginQuery groupByEnvelope() Group by the envelope column
 * @method     ChildUserLoginQuery groupByEmail() Group by the email column
 * @method     ChildUserLoginQuery groupByPassword() Group by the password column
 * @method     ChildUserLoginQuery groupBySalt() Group by the salt column
 * @method     ChildUserLoginQuery groupByParishId() Group by the parish_id column
 * @method     ChildUserLoginQuery groupByRoleId() Group by the role_id column
 * @method     ChildUserLoginQuery groupByLastLogin() Group by the last_login column
 * @method     ChildUserLoginQuery groupByEnabled() Group by the enabled column
 * @method     ChildUserLoginQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildUserLoginQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserLoginQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserLoginQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserLoginQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserLoginQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserLoginQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserLoginQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildUserLoginQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildUserLoginQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildUserLoginQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildUserLoginQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserLoginQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserLoginQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildUserLoginQuery leftJoinRoles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Roles relation
 * @method     ChildUserLoginQuery rightJoinRoles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Roles relation
 * @method     ChildUserLoginQuery innerJoinRoles($relationAlias = null) Adds a INNER JOIN clause to the query using the Roles relation
 *
 * @method     ChildUserLoginQuery joinWithRoles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Roles relation
 *
 * @method     ChildUserLoginQuery leftJoinWithRoles() Adds a LEFT JOIN clause and with to the query using the Roles relation
 * @method     ChildUserLoginQuery rightJoinWithRoles() Adds a RIGHT JOIN clause and with to the query using the Roles relation
 * @method     ChildUserLoginQuery innerJoinWithRoles() Adds a INNER JOIN clause and with to the query using the Roles relation
 *
 * @method     ChildUserLoginQuery leftJoinUserPayment($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserPayment relation
 * @method     ChildUserLoginQuery rightJoinUserPayment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserPayment relation
 * @method     ChildUserLoginQuery innerJoinUserPayment($relationAlias = null) Adds a INNER JOIN clause to the query using the UserPayment relation
 *
 * @method     ChildUserLoginQuery joinWithUserPayment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserPayment relation
 *
 * @method     ChildUserLoginQuery leftJoinWithUserPayment() Adds a LEFT JOIN clause and with to the query using the UserPayment relation
 * @method     ChildUserLoginQuery rightJoinWithUserPayment() Adds a RIGHT JOIN clause and with to the query using the UserPayment relation
 * @method     ChildUserLoginQuery innerJoinWithUserPayment() Adds a INNER JOIN clause and with to the query using the UserPayment relation
 *
 * @method     ChildUserLoginQuery leftJoinUserSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserLoginQuery rightJoinUserSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSubscription relation
 * @method     ChildUserLoginQuery innerJoinUserSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSubscription relation
 *
 * @method     ChildUserLoginQuery joinWithUserSubscription($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSubscription relation
 *
 * @method     ChildUserLoginQuery leftJoinWithUserSubscription() Adds a LEFT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserLoginQuery rightJoinWithUserSubscription() Adds a RIGHT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildUserLoginQuery innerJoinWithUserSubscription() Adds a INNER JOIN clause and with to the query using the UserSubscription relation
 *
 * @method     \ParishQuery|\RolesQuery|\UserPaymentQuery|\UserSubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserLogin findOne(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query
 * @method     ChildUserLogin findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query, or a new ChildUserLogin object populated from the query conditions when no match is found
 *
 * @method     ChildUserLogin findOneByValue(int $value) Return the first ChildUserLogin filtered by the value column
 * @method     ChildUserLogin findOneByEnvelope(string $envelope) Return the first ChildUserLogin filtered by the envelope column
 * @method     ChildUserLogin findOneByEmail(string $email) Return the first ChildUserLogin filtered by the email column
 * @method     ChildUserLogin findOneByPassword(string $password) Return the first ChildUserLogin filtered by the password column
 * @method     ChildUserLogin findOneBySalt(string $salt) Return the first ChildUserLogin filtered by the salt column
 * @method     ChildUserLogin findOneByParishId(int $parish_id) Return the first ChildUserLogin filtered by the parish_id column
 * @method     ChildUserLogin findOneByRoleId(int $role_id) Return the first ChildUserLogin filtered by the role_id column
 * @method     ChildUserLogin findOneByLastLogin(string $last_login) Return the first ChildUserLogin filtered by the last_login column
 * @method     ChildUserLogin findOneByEnabled(int $enabled) Return the first ChildUserLogin filtered by the enabled column
 * @method     ChildUserLogin findOneByCreatedAt(string $created_at) Return the first ChildUserLogin filtered by the created_at column *

 * @method     ChildUserLogin requirePk($key, ConnectionInterface $con = null) Return the ChildUserLogin by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOne(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserLogin requireOneByValue(int $value) Return the first ChildUserLogin filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByEnvelope(string $envelope) Return the first ChildUserLogin filtered by the envelope column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByEmail(string $email) Return the first ChildUserLogin filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByPassword(string $password) Return the first ChildUserLogin filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneBySalt(string $salt) Return the first ChildUserLogin filtered by the salt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByParishId(int $parish_id) Return the first ChildUserLogin filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByRoleId(int $role_id) Return the first ChildUserLogin filtered by the role_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByLastLogin(string $last_login) Return the first ChildUserLogin filtered by the last_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByEnabled(int $enabled) Return the first ChildUserLogin filtered by the enabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByCreatedAt(string $created_at) Return the first ChildUserLogin filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserLogin[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserLogin objects based on current ModelCriteria
 * @method     ChildUserLogin[]|ObjectCollection findByValue(int $value) Return ChildUserLogin objects filtered by the value column
 * @method     ChildUserLogin[]|ObjectCollection findByEnvelope(string $envelope) Return ChildUserLogin objects filtered by the envelope column
 * @method     ChildUserLogin[]|ObjectCollection findByEmail(string $email) Return ChildUserLogin objects filtered by the email column
 * @method     ChildUserLogin[]|ObjectCollection findByPassword(string $password) Return ChildUserLogin objects filtered by the password column
 * @method     ChildUserLogin[]|ObjectCollection findBySalt(string $salt) Return ChildUserLogin objects filtered by the salt column
 * @method     ChildUserLogin[]|ObjectCollection findByParishId(int $parish_id) Return ChildUserLogin objects filtered by the parish_id column
 * @method     ChildUserLogin[]|ObjectCollection findByRoleId(int $role_id) Return ChildUserLogin objects filtered by the role_id column
 * @method     ChildUserLogin[]|ObjectCollection findByLastLogin(string $last_login) Return ChildUserLogin objects filtered by the last_login column
 * @method     ChildUserLogin[]|ObjectCollection findByEnabled(int $enabled) Return ChildUserLogin objects filtered by the enabled column
 * @method     ChildUserLogin[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserLogin objects filtered by the created_at column
 * @method     ChildUserLogin[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserLoginQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserLoginQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UserLogin', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserLoginQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserLoginQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserLoginQuery) {
            return $criteria;
        }
        $query = new ChildUserLoginQuery();
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
     * @return ChildUserLogin|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserLoginTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserLoginTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserLogin A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, envelope, email, password, salt, parish_id, role_id, last_login, enabled, created_at FROM user_login WHERE value = :p0';
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
            /** @var ChildUserLogin $obj */
            $obj = new ChildUserLogin();
            $obj->hydrate($row);
            UserLoginTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserLogin|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the envelope column
     *
     * Example usage:
     * <code>
     * $query->filterByEnvelope('fooValue');   // WHERE envelope = 'fooValue'
     * $query->filterByEnvelope('%fooValue%'); // WHERE envelope LIKE '%fooValue%'
     * </code>
     *
     * @param     string $envelope The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByEnvelope($envelope = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($envelope)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ENVELOPE, $envelope, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the salt column
     *
     * Example usage:
     * <code>
     * $query->filterBySalt('fooValue');   // WHERE salt = 'fooValue'
     * $query->filterBySalt('%fooValue%'); // WHERE salt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $salt The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterBySalt($salt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($salt)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_SALT, $salt, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the role_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE role_id = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE role_id IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE role_id > 12
     * </code>
     *
     * @see       filterByRoles()
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin('2011-03-14'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin('now'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin(array('max' => 'yesterday')); // WHERE last_login > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByLastLogin($lastLogin = null, $comparison = null)
    {
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_LAST_LOGIN, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_LAST_LOGIN, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_LAST_LOGIN, $lastLogin, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_array($enabled)) {
            $useMinMax = false;
            if (isset($enabled['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ENABLED, $enabled['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enabled['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ENABLED, $enabled['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ENABLED, $enabled, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(UserLoginTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserLoginTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
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
     * Filter the query by a related \Roles object
     *
     * @param \Roles|ObjectCollection $roles The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByRoles($roles, $comparison = null)
    {
        if ($roles instanceof \Roles) {
            return $this
                ->addUsingAlias(UserLoginTableMap::COL_ROLE_ID, $roles->getValue(), $comparison);
        } elseif ($roles instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserLoginTableMap::COL_ROLE_ID, $roles->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByRoles() only accepts arguments of type \Roles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Roles relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function joinRoles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Roles');

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
            $this->addJoinObject($join, 'Roles');
        }

        return $this;
    }

    /**
     * Use the Roles relation Roles object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RolesQuery A secondary query class using the current class as primary query
     */
    public function useRolesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRoles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Roles', '\RolesQuery');
    }

    /**
     * Filter the query by a related \UserPayment object
     *
     * @param \UserPayment|ObjectCollection $userPayment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByUserPayment($userPayment, $comparison = null)
    {
        if ($userPayment instanceof \UserPayment) {
            return $this
                ->addUsingAlias(UserLoginTableMap::COL_VALUE, $userPayment->getUserId(), $comparison);
        } elseif ($userPayment instanceof ObjectCollection) {
            return $this
                ->useUserPaymentQuery()
                ->filterByPrimaryKeys($userPayment->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function joinUserPayment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useUserPaymentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserPayment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserPayment', '\UserPaymentQuery');
    }

    /**
     * Filter the query by a related \UserSubscription object
     *
     * @param \UserSubscription|ObjectCollection $userSubscription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByUserSubscription($userSubscription, $comparison = null)
    {
        if ($userSubscription instanceof \UserSubscription) {
            return $this
                ->addUsingAlias(UserLoginTableMap::COL_VALUE, $userSubscription->getUserId(), $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function joinUserSubscription($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useUserSubscriptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserSubscription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSubscription', '\UserSubscriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserLogin $userLogin Object to remove from the list of results
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function prune($userLogin = null)
    {
        if ($userLogin) {
            $this->addUsingAlias(UserLoginTableMap::COL_VALUE, $userLogin->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_login table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserLoginTableMap::clearInstancePool();
            UserLoginTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserLoginTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserLoginTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserLoginTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserLoginQuery
