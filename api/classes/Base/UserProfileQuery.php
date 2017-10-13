<?php

namespace Base;

use \UserProfile as ChildUserProfile;
use \UserProfileQuery as ChildUserProfileQuery;
use \Exception;
use \PDO;
use Map\UserProfileTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_profile' table.
 *
 * 
 *
 * @method     ChildUserProfileQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUserProfileQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildUserProfileQuery orderByFname($order = Criteria::ASC) Order by the fname column
 * @method     ChildUserProfileQuery orderByLname($order = Criteria::ASC) Order by the lname column
 * @method     ChildUserProfileQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildUserProfileQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildUserProfileQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildUserProfileQuery orderByZip($order = Criteria::ASC) Order by the zip column
 * @method     ChildUserProfileQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildUserProfileQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildUserProfileQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserProfileQuery orderByDob($order = Criteria::ASC) Order by the dob column
 * @method     ChildUserProfileQuery orderByMarried($order = Criteria::ASC) Order by the married column
 * @method     ChildUserProfileQuery orderByWedding($order = Criteria::ASC) Order by the wedding column
 * @method     ChildUserProfileQuery orderByPushId($order = Criteria::ASC) Order by the push_id column
 * @method     ChildUserProfileQuery orderByPlatform($order = Criteria::ASC) Order by the platform column
 * @method     ChildUserProfileQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildUserProfileQuery groupByValue() Group by the value column
 * @method     ChildUserProfileQuery groupByParishId() Group by the parish_id column
 * @method     ChildUserProfileQuery groupByFname() Group by the fname column
 * @method     ChildUserProfileQuery groupByLname() Group by the lname column
 * @method     ChildUserProfileQuery groupByAddress() Group by the address column
 * @method     ChildUserProfileQuery groupByCity() Group by the city column
 * @method     ChildUserProfileQuery groupByState() Group by the state column
 * @method     ChildUserProfileQuery groupByZip() Group by the zip column
 * @method     ChildUserProfileQuery groupByCountry() Group by the country column
 * @method     ChildUserProfileQuery groupByPhone() Group by the phone column
 * @method     ChildUserProfileQuery groupByEmail() Group by the email column
 * @method     ChildUserProfileQuery groupByDob() Group by the dob column
 * @method     ChildUserProfileQuery groupByMarried() Group by the married column
 * @method     ChildUserProfileQuery groupByWedding() Group by the wedding column
 * @method     ChildUserProfileQuery groupByPushId() Group by the push_id column
 * @method     ChildUserProfileQuery groupByPlatform() Group by the platform column
 * @method     ChildUserProfileQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildUserProfileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserProfileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserProfileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserProfileQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserProfileQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserProfileQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserProfileQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildUserProfileQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildUserProfileQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildUserProfileQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildUserProfileQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserProfileQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildUserProfileQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildUserProfileQuery leftJoinGive($relationAlias = null) Adds a LEFT JOIN clause to the query using the Give relation
 * @method     ChildUserProfileQuery rightJoinGive($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Give relation
 * @method     ChildUserProfileQuery innerJoinGive($relationAlias = null) Adds a INNER JOIN clause to the query using the Give relation
 *
 * @method     ChildUserProfileQuery joinWithGive($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Give relation
 *
 * @method     ChildUserProfileQuery leftJoinWithGive() Adds a LEFT JOIN clause and with to the query using the Give relation
 * @method     ChildUserProfileQuery rightJoinWithGive() Adds a RIGHT JOIN clause and with to the query using the Give relation
 * @method     ChildUserProfileQuery innerJoinWithGive() Adds a INNER JOIN clause and with to the query using the Give relation
 *
 * @method     ChildUserProfileQuery leftJoinPastor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pastor relation
 * @method     ChildUserProfileQuery rightJoinPastor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pastor relation
 * @method     ChildUserProfileQuery innerJoinPastor($relationAlias = null) Adds a INNER JOIN clause to the query using the Pastor relation
 *
 * @method     ChildUserProfileQuery joinWithPastor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pastor relation
 *
 * @method     ChildUserProfileQuery leftJoinWithPastor() Adds a LEFT JOIN clause and with to the query using the Pastor relation
 * @method     ChildUserProfileQuery rightJoinWithPastor() Adds a RIGHT JOIN clause and with to the query using the Pastor relation
 * @method     ChildUserProfileQuery innerJoinWithPastor() Adds a INNER JOIN clause and with to the query using the Pastor relation
 *
 * @method     ChildUserProfileQuery leftJoinPrayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Prayer relation
 * @method     ChildUserProfileQuery rightJoinPrayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Prayer relation
 * @method     ChildUserProfileQuery innerJoinPrayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Prayer relation
 *
 * @method     ChildUserProfileQuery joinWithPrayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Prayer relation
 *
 * @method     ChildUserProfileQuery leftJoinWithPrayer() Adds a LEFT JOIN clause and with to the query using the Prayer relation
 * @method     ChildUserProfileQuery rightJoinWithPrayer() Adds a RIGHT JOIN clause and with to the query using the Prayer relation
 * @method     ChildUserProfileQuery innerJoinWithPrayer() Adds a INNER JOIN clause and with to the query using the Prayer relation
 *
 * @method     ChildUserProfileQuery leftJoinPushRegister($relationAlias = null) Adds a LEFT JOIN clause to the query using the PushRegister relation
 * @method     ChildUserProfileQuery rightJoinPushRegister($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PushRegister relation
 * @method     ChildUserProfileQuery innerJoinPushRegister($relationAlias = null) Adds a INNER JOIN clause to the query using the PushRegister relation
 *
 * @method     ChildUserProfileQuery joinWithPushRegister($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PushRegister relation
 *
 * @method     ChildUserProfileQuery leftJoinWithPushRegister() Adds a LEFT JOIN clause and with to the query using the PushRegister relation
 * @method     ChildUserProfileQuery rightJoinWithPushRegister() Adds a RIGHT JOIN clause and with to the query using the PushRegister relation
 * @method     ChildUserProfileQuery innerJoinWithPushRegister() Adds a INNER JOIN clause and with to the query using the PushRegister relation
 *
 * @method     ChildUserProfileQuery leftJoinTestimonials($relationAlias = null) Adds a LEFT JOIN clause to the query using the Testimonials relation
 * @method     ChildUserProfileQuery rightJoinTestimonials($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Testimonials relation
 * @method     ChildUserProfileQuery innerJoinTestimonials($relationAlias = null) Adds a INNER JOIN clause to the query using the Testimonials relation
 *
 * @method     ChildUserProfileQuery joinWithTestimonials($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Testimonials relation
 *
 * @method     ChildUserProfileQuery leftJoinWithTestimonials() Adds a LEFT JOIN clause and with to the query using the Testimonials relation
 * @method     ChildUserProfileQuery rightJoinWithTestimonials() Adds a RIGHT JOIN clause and with to the query using the Testimonials relation
 * @method     ChildUserProfileQuery innerJoinWithTestimonials() Adds a INNER JOIN clause and with to the query using the Testimonials relation
 *
 * @method     \ParishQuery|\GiveQuery|\PastorQuery|\PrayerQuery|\PushRegisterQuery|\TestimonialsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserProfile findOne(ConnectionInterface $con = null) Return the first ChildUserProfile matching the query
 * @method     ChildUserProfile findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserProfile matching the query, or a new ChildUserProfile object populated from the query conditions when no match is found
 *
 * @method     ChildUserProfile findOneByValue(int $value) Return the first ChildUserProfile filtered by the value column
 * @method     ChildUserProfile findOneByParishId(int $parish_id) Return the first ChildUserProfile filtered by the parish_id column
 * @method     ChildUserProfile findOneByFname(string $fname) Return the first ChildUserProfile filtered by the fname column
 * @method     ChildUserProfile findOneByLname(string $lname) Return the first ChildUserProfile filtered by the lname column
 * @method     ChildUserProfile findOneByAddress(string $address) Return the first ChildUserProfile filtered by the address column
 * @method     ChildUserProfile findOneByCity(string $city) Return the first ChildUserProfile filtered by the city column
 * @method     ChildUserProfile findOneByState(string $state) Return the first ChildUserProfile filtered by the state column
 * @method     ChildUserProfile findOneByZip(string $zip) Return the first ChildUserProfile filtered by the zip column
 * @method     ChildUserProfile findOneByCountry(string $country) Return the first ChildUserProfile filtered by the country column
 * @method     ChildUserProfile findOneByPhone(string $phone) Return the first ChildUserProfile filtered by the phone column
 * @method     ChildUserProfile findOneByEmail(string $email) Return the first ChildUserProfile filtered by the email column
 * @method     ChildUserProfile findOneByDob(string $dob) Return the first ChildUserProfile filtered by the dob column
 * @method     ChildUserProfile findOneByMarried(boolean $married) Return the first ChildUserProfile filtered by the married column
 * @method     ChildUserProfile findOneByWedding(string $wedding) Return the first ChildUserProfile filtered by the wedding column
 * @method     ChildUserProfile findOneByPushId(string $push_id) Return the first ChildUserProfile filtered by the push_id column
 * @method     ChildUserProfile findOneByPlatform(string $platform) Return the first ChildUserProfile filtered by the platform column
 * @method     ChildUserProfile findOneByCreatedAt(string $created_at) Return the first ChildUserProfile filtered by the created_at column *

 * @method     ChildUserProfile requirePk($key, ConnectionInterface $con = null) Return the ChildUserProfile by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOne(ConnectionInterface $con = null) Return the first ChildUserProfile matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserProfile requireOneByValue(int $value) Return the first ChildUserProfile filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByParishId(int $parish_id) Return the first ChildUserProfile filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByFname(string $fname) Return the first ChildUserProfile filtered by the fname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByLname(string $lname) Return the first ChildUserProfile filtered by the lname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByAddress(string $address) Return the first ChildUserProfile filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByCity(string $city) Return the first ChildUserProfile filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByState(string $state) Return the first ChildUserProfile filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByZip(string $zip) Return the first ChildUserProfile filtered by the zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByCountry(string $country) Return the first ChildUserProfile filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByPhone(string $phone) Return the first ChildUserProfile filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByEmail(string $email) Return the first ChildUserProfile filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByDob(string $dob) Return the first ChildUserProfile filtered by the dob column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByMarried(boolean $married) Return the first ChildUserProfile filtered by the married column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByWedding(string $wedding) Return the first ChildUserProfile filtered by the wedding column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByPushId(string $push_id) Return the first ChildUserProfile filtered by the push_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByPlatform(string $platform) Return the first ChildUserProfile filtered by the platform column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserProfile requireOneByCreatedAt(string $created_at) Return the first ChildUserProfile filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserProfile[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserProfile objects based on current ModelCriteria
 * @method     ChildUserProfile[]|ObjectCollection findByValue(int $value) Return ChildUserProfile objects filtered by the value column
 * @method     ChildUserProfile[]|ObjectCollection findByParishId(int $parish_id) Return ChildUserProfile objects filtered by the parish_id column
 * @method     ChildUserProfile[]|ObjectCollection findByFname(string $fname) Return ChildUserProfile objects filtered by the fname column
 * @method     ChildUserProfile[]|ObjectCollection findByLname(string $lname) Return ChildUserProfile objects filtered by the lname column
 * @method     ChildUserProfile[]|ObjectCollection findByAddress(string $address) Return ChildUserProfile objects filtered by the address column
 * @method     ChildUserProfile[]|ObjectCollection findByCity(string $city) Return ChildUserProfile objects filtered by the city column
 * @method     ChildUserProfile[]|ObjectCollection findByState(string $state) Return ChildUserProfile objects filtered by the state column
 * @method     ChildUserProfile[]|ObjectCollection findByZip(string $zip) Return ChildUserProfile objects filtered by the zip column
 * @method     ChildUserProfile[]|ObjectCollection findByCountry(string $country) Return ChildUserProfile objects filtered by the country column
 * @method     ChildUserProfile[]|ObjectCollection findByPhone(string $phone) Return ChildUserProfile objects filtered by the phone column
 * @method     ChildUserProfile[]|ObjectCollection findByEmail(string $email) Return ChildUserProfile objects filtered by the email column
 * @method     ChildUserProfile[]|ObjectCollection findByDob(string $dob) Return ChildUserProfile objects filtered by the dob column
 * @method     ChildUserProfile[]|ObjectCollection findByMarried(boolean $married) Return ChildUserProfile objects filtered by the married column
 * @method     ChildUserProfile[]|ObjectCollection findByWedding(string $wedding) Return ChildUserProfile objects filtered by the wedding column
 * @method     ChildUserProfile[]|ObjectCollection findByPushId(string $push_id) Return ChildUserProfile objects filtered by the push_id column
 * @method     ChildUserProfile[]|ObjectCollection findByPlatform(string $platform) Return ChildUserProfile objects filtered by the platform column
 * @method     ChildUserProfile[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserProfile objects filtered by the created_at column
 * @method     ChildUserProfile[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserProfileQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserProfileQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UserProfile', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserProfileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserProfileQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserProfileQuery) {
            return $criteria;
        }
        $query = new ChildUserProfileQuery();
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
     * @return ChildUserProfile|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserProfileTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserProfileTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserProfile A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, parish_id, fname, lname, address, city, state, zip, country, phone, email, dob, married, wedding, push_id, platform, created_at FROM user_profile WHERE value = :p0';
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
            /** @var ChildUserProfile $obj */
            $obj = new ChildUserProfile();
            $obj->hydrate($row);
            UserProfileTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserProfile|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_PARISH_ID, $parishId, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByFname($fname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_FNAME, $fname, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByLname($lname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_LNAME, $lname, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_CITY, $city, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%'); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip('fooValue');   // WHERE zip = 'fooValue'
     * $query->filterByZip('%fooValue%'); // WHERE zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $zip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByZip($zip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($zip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_ZIP, $zip, $comparison);
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%'); // WHERE country LIKE '%fooValue%'
     * </code>
     *
     * @param     string $country The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_COUNTRY, $country, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_PHONE, $phone, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the dob column
     *
     * Example usage:
     * <code>
     * $query->filterByDob('fooValue');   // WHERE dob = 'fooValue'
     * $query->filterByDob('%fooValue%'); // WHERE dob LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dob The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByDob($dob = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dob)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_DOB, $dob, $comparison);
    }

    /**
     * Filter the query on the married column
     *
     * Example usage:
     * <code>
     * $query->filterByMarried(true); // WHERE married = true
     * $query->filterByMarried('yes'); // WHERE married = true
     * </code>
     *
     * @param     boolean|string $married The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByMarried($married = null, $comparison = null)
    {
        if (is_string($married)) {
            $married = in_array(strtolower($married), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_MARRIED, $married, $comparison);
    }

    /**
     * Filter the query on the wedding column
     *
     * Example usage:
     * <code>
     * $query->filterByWedding('fooValue');   // WHERE wedding = 'fooValue'
     * $query->filterByWedding('%fooValue%'); // WHERE wedding LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wedding The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByWedding($wedding = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wedding)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_WEDDING, $wedding, $comparison);
    }

    /**
     * Filter the query on the push_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPushId('fooValue');   // WHERE push_id = 'fooValue'
     * $query->filterByPushId('%fooValue%'); // WHERE push_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pushId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPushId($pushId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pushId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_PUSH_ID, $pushId, $comparison);
    }

    /**
     * Filter the query on the platform column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatform('fooValue');   // WHERE platform = 'fooValue'
     * $query->filterByPlatform('%fooValue%'); // WHERE platform LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platform The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPlatform($platform = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platform)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_PLATFORM, $platform, $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserProfileTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserProfileTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserProfileTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
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
     * Filter the query by a related \Give object
     *
     * @param \Give|ObjectCollection $give the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByGive($give, $comparison = null)
    {
        if ($give instanceof \Give) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_VALUE, $give->getProfileId(), $comparison);
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
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
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
     * Filter the query by a related \Pastor object
     *
     * @param \Pastor|ObjectCollection $pastor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPastor($pastor, $comparison = null)
    {
        if ($pastor instanceof \Pastor) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_VALUE, $pastor->getUserId(), $comparison);
        } elseif ($pastor instanceof ObjectCollection) {
            return $this
                ->usePastorQuery()
                ->filterByPrimaryKeys($pastor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPastor() only accepts arguments of type \Pastor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pastor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function joinPastor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pastor');

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
            $this->addJoinObject($join, 'Pastor');
        }

        return $this;
    }

    /**
     * Use the Pastor relation Pastor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PastorQuery A secondary query class using the current class as primary query
     */
    public function usePastorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPastor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pastor', '\PastorQuery');
    }

    /**
     * Filter the query by a related \Prayer object
     *
     * @param \Prayer|ObjectCollection $prayer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPrayer($prayer, $comparison = null)
    {
        if ($prayer instanceof \Prayer) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_VALUE, $prayer->getUserId(), $comparison);
        } elseif ($prayer instanceof ObjectCollection) {
            return $this
                ->usePrayerQuery()
                ->filterByPrimaryKeys($prayer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPrayer() only accepts arguments of type \Prayer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Prayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function joinPrayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Prayer');

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
            $this->addJoinObject($join, 'Prayer');
        }

        return $this;
    }

    /**
     * Use the Prayer relation Prayer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PrayerQuery A secondary query class using the current class as primary query
     */
    public function usePrayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPrayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Prayer', '\PrayerQuery');
    }

    /**
     * Filter the query by a related \PushRegister object
     *
     * @param \PushRegister|ObjectCollection $pushRegister the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByPushRegister($pushRegister, $comparison = null)
    {
        if ($pushRegister instanceof \PushRegister) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_VALUE, $pushRegister->getUserId(), $comparison);
        } elseif ($pushRegister instanceof ObjectCollection) {
            return $this
                ->usePushRegisterQuery()
                ->filterByPrimaryKeys($pushRegister->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPushRegister() only accepts arguments of type \PushRegister or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PushRegister relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function joinPushRegister($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PushRegister');

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
            $this->addJoinObject($join, 'PushRegister');
        }

        return $this;
    }

    /**
     * Use the PushRegister relation PushRegister object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PushRegisterQuery A secondary query class using the current class as primary query
     */
    public function usePushRegisterQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPushRegister($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PushRegister', '\PushRegisterQuery');
    }

    /**
     * Filter the query by a related \Testimonials object
     *
     * @param \Testimonials|ObjectCollection $testimonials the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserProfileQuery The current query, for fluid interface
     */
    public function filterByTestimonials($testimonials, $comparison = null)
    {
        if ($testimonials instanceof \Testimonials) {
            return $this
                ->addUsingAlias(UserProfileTableMap::COL_VALUE, $testimonials->getUserId(), $comparison);
        } elseif ($testimonials instanceof ObjectCollection) {
            return $this
                ->useTestimonialsQuery()
                ->filterByPrimaryKeys($testimonials->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTestimonials() only accepts arguments of type \Testimonials or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Testimonials relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function joinTestimonials($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Testimonials');

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
            $this->addJoinObject($join, 'Testimonials');
        }

        return $this;
    }

    /**
     * Use the Testimonials relation Testimonials object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TestimonialsQuery A secondary query class using the current class as primary query
     */
    public function useTestimonialsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTestimonials($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Testimonials', '\TestimonialsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserProfile $userProfile Object to remove from the list of results
     *
     * @return $this|ChildUserProfileQuery The current query, for fluid interface
     */
    public function prune($userProfile = null)
    {
        if ($userProfile) {
            $this->addUsingAlias(UserProfileTableMap::COL_VALUE, $userProfile->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_profile table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserProfileTableMap::clearInstancePool();
            UserProfileTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserProfileTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserProfileTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserProfileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserProfileQuery
