<?php

namespace Base;

use \Letters as ChildLetters;
use \LettersQuery as ChildLettersQuery;
use \Exception;
use \PDO;
use Map\LettersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'letters' table.
 *
 * 
 *
 * @method     ChildLettersQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildLettersQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildLettersQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method     ChildLettersQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildLettersQuery orderBySenderName($order = Criteria::ASC) Order by the sender_name column
 * @method     ChildLettersQuery orderBySenderEmail($order = Criteria::ASC) Order by the sender_email column
 * @method     ChildLettersQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method     ChildLettersQuery orderByLetter($order = Criteria::ASC) Order by the letter column
 * @method     ChildLettersQuery orderByPublished($order = Criteria::ASC) Order by the published column
 * @method     ChildLettersQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildLettersQuery groupByValue() Group by the value column
 * @method     ChildLettersQuery groupByParishId() Group by the parish_id column
 * @method     ChildLettersQuery groupByTypeId() Group by the type_id column
 * @method     ChildLettersQuery groupByName() Group by the name column
 * @method     ChildLettersQuery groupBySenderName() Group by the sender_name column
 * @method     ChildLettersQuery groupBySenderEmail() Group by the sender_email column
 * @method     ChildLettersQuery groupBySubject() Group by the subject column
 * @method     ChildLettersQuery groupByLetter() Group by the letter column
 * @method     ChildLettersQuery groupByPublished() Group by the published column
 * @method     ChildLettersQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildLettersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLettersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLettersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLettersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLettersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLettersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLettersQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildLettersQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildLettersQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildLettersQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildLettersQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildLettersQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildLettersQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildLettersQuery leftJoinLetterType($relationAlias = null) Adds a LEFT JOIN clause to the query using the LetterType relation
 * @method     ChildLettersQuery rightJoinLetterType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LetterType relation
 * @method     ChildLettersQuery innerJoinLetterType($relationAlias = null) Adds a INNER JOIN clause to the query using the LetterType relation
 *
 * @method     ChildLettersQuery joinWithLetterType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the LetterType relation
 *
 * @method     ChildLettersQuery leftJoinWithLetterType() Adds a LEFT JOIN clause and with to the query using the LetterType relation
 * @method     ChildLettersQuery rightJoinWithLetterType() Adds a RIGHT JOIN clause and with to the query using the LetterType relation
 * @method     ChildLettersQuery innerJoinWithLetterType() Adds a INNER JOIN clause and with to the query using the LetterType relation
 *
 * @method     ChildLettersQuery leftJoinJobQueue($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobQueue relation
 * @method     ChildLettersQuery rightJoinJobQueue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobQueue relation
 * @method     ChildLettersQuery innerJoinJobQueue($relationAlias = null) Adds a INNER JOIN clause to the query using the JobQueue relation
 *
 * @method     ChildLettersQuery joinWithJobQueue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JobQueue relation
 *
 * @method     ChildLettersQuery leftJoinWithJobQueue() Adds a LEFT JOIN clause and with to the query using the JobQueue relation
 * @method     ChildLettersQuery rightJoinWithJobQueue() Adds a RIGHT JOIN clause and with to the query using the JobQueue relation
 * @method     ChildLettersQuery innerJoinWithJobQueue() Adds a INNER JOIN clause and with to the query using the JobQueue relation
 *
 * @method     \ParishQuery|\LetterTypeQuery|\JobQueueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLetters findOne(ConnectionInterface $con = null) Return the first ChildLetters matching the query
 * @method     ChildLetters findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLetters matching the query, or a new ChildLetters object populated from the query conditions when no match is found
 *
 * @method     ChildLetters findOneByValue(int $value) Return the first ChildLetters filtered by the value column
 * @method     ChildLetters findOneByParishId(int $parish_id) Return the first ChildLetters filtered by the parish_id column
 * @method     ChildLetters findOneByTypeId(int $type_id) Return the first ChildLetters filtered by the type_id column
 * @method     ChildLetters findOneByName(string $name) Return the first ChildLetters filtered by the name column
 * @method     ChildLetters findOneBySenderName(string $sender_name) Return the first ChildLetters filtered by the sender_name column
 * @method     ChildLetters findOneBySenderEmail(string $sender_email) Return the first ChildLetters filtered by the sender_email column
 * @method     ChildLetters findOneBySubject(string $subject) Return the first ChildLetters filtered by the subject column
 * @method     ChildLetters findOneByLetter(string $letter) Return the first ChildLetters filtered by the letter column
 * @method     ChildLetters findOneByPublished(boolean $published) Return the first ChildLetters filtered by the published column
 * @method     ChildLetters findOneByCreatedAt(string $created_at) Return the first ChildLetters filtered by the created_at column *

 * @method     ChildLetters requirePk($key, ConnectionInterface $con = null) Return the ChildLetters by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOne(ConnectionInterface $con = null) Return the first ChildLetters matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLetters requireOneByValue(int $value) Return the first ChildLetters filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByParishId(int $parish_id) Return the first ChildLetters filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByTypeId(int $type_id) Return the first ChildLetters filtered by the type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByName(string $name) Return the first ChildLetters filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneBySenderName(string $sender_name) Return the first ChildLetters filtered by the sender_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneBySenderEmail(string $sender_email) Return the first ChildLetters filtered by the sender_email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneBySubject(string $subject) Return the first ChildLetters filtered by the subject column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByLetter(string $letter) Return the first ChildLetters filtered by the letter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByPublished(boolean $published) Return the first ChildLetters filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLetters requireOneByCreatedAt(string $created_at) Return the first ChildLetters filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLetters[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLetters objects based on current ModelCriteria
 * @method     ChildLetters[]|ObjectCollection findByValue(int $value) Return ChildLetters objects filtered by the value column
 * @method     ChildLetters[]|ObjectCollection findByParishId(int $parish_id) Return ChildLetters objects filtered by the parish_id column
 * @method     ChildLetters[]|ObjectCollection findByTypeId(int $type_id) Return ChildLetters objects filtered by the type_id column
 * @method     ChildLetters[]|ObjectCollection findByName(string $name) Return ChildLetters objects filtered by the name column
 * @method     ChildLetters[]|ObjectCollection findBySenderName(string $sender_name) Return ChildLetters objects filtered by the sender_name column
 * @method     ChildLetters[]|ObjectCollection findBySenderEmail(string $sender_email) Return ChildLetters objects filtered by the sender_email column
 * @method     ChildLetters[]|ObjectCollection findBySubject(string $subject) Return ChildLetters objects filtered by the subject column
 * @method     ChildLetters[]|ObjectCollection findByLetter(string $letter) Return ChildLetters objects filtered by the letter column
 * @method     ChildLetters[]|ObjectCollection findByPublished(boolean $published) Return ChildLetters objects filtered by the published column
 * @method     ChildLetters[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildLetters objects filtered by the created_at column
 * @method     ChildLetters[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LettersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LettersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Letters', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLettersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLettersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLettersQuery) {
            return $criteria;
        }
        $query = new ChildLettersQuery();
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
     * @return ChildLetters|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LettersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LettersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildLetters A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, parish_id, type_id, name, sender_name, sender_email, subject, letter, published, created_at FROM letters WHERE value = :p0';
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
            /** @var ChildLetters $obj */
            $obj = new ChildLetters();
            $obj->hydrate($row);
            LettersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLetters|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LettersTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LettersTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(LettersTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(LettersTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(LettersTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(LettersTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_id = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_id > 12
     * </code>
     *
     * @see       filterByLetterType()
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(LettersTableMap::COL_TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(LettersTableMap::COL_TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the sender_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderName('fooValue');   // WHERE sender_name = 'fooValue'
     * $query->filterBySenderName('%fooValue%'); // WHERE sender_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senderName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterBySenderName($senderName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senderName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_SENDER_NAME, $senderName, $comparison);
    }

    /**
     * Filter the query on the sender_email column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderEmail('fooValue');   // WHERE sender_email = 'fooValue'
     * $query->filterBySenderEmail('%fooValue%'); // WHERE sender_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senderEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterBySenderEmail($senderEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senderEmail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_SENDER_EMAIL, $senderEmail, $comparison);
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_SUBJECT, $subject, $comparison);
    }

    /**
     * Filter the query on the letter column
     *
     * Example usage:
     * <code>
     * $query->filterByLetter('fooValue');   // WHERE letter = 'fooValue'
     * $query->filterByLetter('%fooValue%'); // WHERE letter LIKE '%fooValue%'
     * </code>
     *
     * @param     string $letter The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByLetter($letter = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($letter)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_LETTER, $letter, $comparison);
    }

    /**
     * Filter the query on the published column
     *
     * Example usage:
     * <code>
     * $query->filterByPublished(true); // WHERE published = true
     * $query->filterByPublished('yes'); // WHERE published = true
     * </code>
     *
     * @param     boolean|string $published The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_string($published)) {
            $published = in_array(strtolower($published), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(LettersTableMap::COL_PUBLISHED, $published, $comparison);
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(LettersTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(LettersTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LettersTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLettersQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(LettersTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LettersTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
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
     * Filter the query by a related \LetterType object
     *
     * @param \LetterType|ObjectCollection $letterType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLettersQuery The current query, for fluid interface
     */
    public function filterByLetterType($letterType, $comparison = null)
    {
        if ($letterType instanceof \LetterType) {
            return $this
                ->addUsingAlias(LettersTableMap::COL_TYPE_ID, $letterType->getValue(), $comparison);
        } elseif ($letterType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LettersTableMap::COL_TYPE_ID, $letterType->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByLetterType() only accepts arguments of type \LetterType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LetterType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function joinLetterType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LetterType');

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
            $this->addJoinObject($join, 'LetterType');
        }

        return $this;
    }

    /**
     * Use the LetterType relation LetterType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LetterTypeQuery A secondary query class using the current class as primary query
     */
    public function useLetterTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLetterType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LetterType', '\LetterTypeQuery');
    }

    /**
     * Filter the query by a related \JobQueue object
     *
     * @param \JobQueue|ObjectCollection $jobQueue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLettersQuery The current query, for fluid interface
     */
    public function filterByJobQueue($jobQueue, $comparison = null)
    {
        if ($jobQueue instanceof \JobQueue) {
            return $this
                ->addUsingAlias(LettersTableMap::COL_VALUE, $jobQueue->getLetterId(), $comparison);
        } elseif ($jobQueue instanceof ObjectCollection) {
            return $this
                ->useJobQueueQuery()
                ->filterByPrimaryKeys($jobQueue->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildLettersQuery The current query, for fluid interface
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
     * @param   ChildLetters $letters Object to remove from the list of results
     *
     * @return $this|ChildLettersQuery The current query, for fluid interface
     */
    public function prune($letters = null)
    {
        if ($letters) {
            $this->addUsingAlias(LettersTableMap::COL_VALUE, $letters->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the letters table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LettersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LettersTableMap::clearInstancePool();
            LettersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LettersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LettersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            LettersTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            LettersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LettersQuery
