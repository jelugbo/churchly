<?php

namespace Base;

use \Devotions as ChildDevotions;
use \DevotionsQuery as ChildDevotionsQuery;
use \Exception;
use \PDO;
use Map\DevotionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'devotions' table.
 *
 * 
 *
 * @method     ChildDevotionsQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildDevotionsQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildDevotionsQuery orderByDevotionDate($order = Criteria::ASC) Order by the devotion_date column
 * @method     ChildDevotionsQuery orderByTopic($order = Criteria::ASC) Order by the topic column
 * @method     ChildDevotionsQuery orderByVerse($order = Criteria::ASC) Order by the verse column
 * @method     ChildDevotionsQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildDevotionsQuery orderByHasMedia($order = Criteria::ASC) Order by the has_media column
 * @method     ChildDevotionsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildDevotionsQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildDevotionsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildDevotionsQuery groupByValue() Group by the value column
 * @method     ChildDevotionsQuery groupByParishId() Group by the parish_id column
 * @method     ChildDevotionsQuery groupByDevotionDate() Group by the devotion_date column
 * @method     ChildDevotionsQuery groupByTopic() Group by the topic column
 * @method     ChildDevotionsQuery groupByVerse() Group by the verse column
 * @method     ChildDevotionsQuery groupByContent() Group by the content column
 * @method     ChildDevotionsQuery groupByHasMedia() Group by the has_media column
 * @method     ChildDevotionsQuery groupByType() Group by the type column
 * @method     ChildDevotionsQuery groupByUrl() Group by the url column
 * @method     ChildDevotionsQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildDevotionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDevotionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDevotionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDevotionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDevotionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDevotionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDevotionsQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildDevotionsQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildDevotionsQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildDevotionsQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildDevotionsQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildDevotionsQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildDevotionsQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     ChildDevotionsQuery leftJoinMediaType($relationAlias = null) Adds a LEFT JOIN clause to the query using the MediaType relation
 * @method     ChildDevotionsQuery rightJoinMediaType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MediaType relation
 * @method     ChildDevotionsQuery innerJoinMediaType($relationAlias = null) Adds a INNER JOIN clause to the query using the MediaType relation
 *
 * @method     ChildDevotionsQuery joinWithMediaType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MediaType relation
 *
 * @method     ChildDevotionsQuery leftJoinWithMediaType() Adds a LEFT JOIN clause and with to the query using the MediaType relation
 * @method     ChildDevotionsQuery rightJoinWithMediaType() Adds a RIGHT JOIN clause and with to the query using the MediaType relation
 * @method     ChildDevotionsQuery innerJoinWithMediaType() Adds a INNER JOIN clause and with to the query using the MediaType relation
 *
 * @method     \ParishQuery|\MediaTypeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDevotions findOne(ConnectionInterface $con = null) Return the first ChildDevotions matching the query
 * @method     ChildDevotions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDevotions matching the query, or a new ChildDevotions object populated from the query conditions when no match is found
 *
 * @method     ChildDevotions findOneByValue(int $value) Return the first ChildDevotions filtered by the value column
 * @method     ChildDevotions findOneByParishId(int $parish_id) Return the first ChildDevotions filtered by the parish_id column
 * @method     ChildDevotions findOneByDevotionDate(string $devotion_date) Return the first ChildDevotions filtered by the devotion_date column
 * @method     ChildDevotions findOneByTopic(string $topic) Return the first ChildDevotions filtered by the topic column
 * @method     ChildDevotions findOneByVerse(string $verse) Return the first ChildDevotions filtered by the verse column
 * @method     ChildDevotions findOneByContent(string $content) Return the first ChildDevotions filtered by the content column
 * @method     ChildDevotions findOneByHasMedia(boolean $has_media) Return the first ChildDevotions filtered by the has_media column
 * @method     ChildDevotions findOneByType(int $type) Return the first ChildDevotions filtered by the type column
 * @method     ChildDevotions findOneByUrl(string $url) Return the first ChildDevotions filtered by the url column
 * @method     ChildDevotions findOneByCreatedAt(string $created_at) Return the first ChildDevotions filtered by the created_at column *

 * @method     ChildDevotions requirePk($key, ConnectionInterface $con = null) Return the ChildDevotions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOne(ConnectionInterface $con = null) Return the first ChildDevotions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDevotions requireOneByValue(int $value) Return the first ChildDevotions filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByParishId(int $parish_id) Return the first ChildDevotions filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByDevotionDate(string $devotion_date) Return the first ChildDevotions filtered by the devotion_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByTopic(string $topic) Return the first ChildDevotions filtered by the topic column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByVerse(string $verse) Return the first ChildDevotions filtered by the verse column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByContent(string $content) Return the first ChildDevotions filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByHasMedia(boolean $has_media) Return the first ChildDevotions filtered by the has_media column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByType(int $type) Return the first ChildDevotions filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByUrl(string $url) Return the first ChildDevotions filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevotions requireOneByCreatedAt(string $created_at) Return the first ChildDevotions filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDevotions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDevotions objects based on current ModelCriteria
 * @method     ChildDevotions[]|ObjectCollection findByValue(int $value) Return ChildDevotions objects filtered by the value column
 * @method     ChildDevotions[]|ObjectCollection findByParishId(int $parish_id) Return ChildDevotions objects filtered by the parish_id column
 * @method     ChildDevotions[]|ObjectCollection findByDevotionDate(string $devotion_date) Return ChildDevotions objects filtered by the devotion_date column
 * @method     ChildDevotions[]|ObjectCollection findByTopic(string $topic) Return ChildDevotions objects filtered by the topic column
 * @method     ChildDevotions[]|ObjectCollection findByVerse(string $verse) Return ChildDevotions objects filtered by the verse column
 * @method     ChildDevotions[]|ObjectCollection findByContent(string $content) Return ChildDevotions objects filtered by the content column
 * @method     ChildDevotions[]|ObjectCollection findByHasMedia(boolean $has_media) Return ChildDevotions objects filtered by the has_media column
 * @method     ChildDevotions[]|ObjectCollection findByType(int $type) Return ChildDevotions objects filtered by the type column
 * @method     ChildDevotions[]|ObjectCollection findByUrl(string $url) Return ChildDevotions objects filtered by the url column
 * @method     ChildDevotions[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildDevotions objects filtered by the created_at column
 * @method     ChildDevotions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DevotionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DevotionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Devotions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDevotionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDevotionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDevotionsQuery) {
            return $criteria;
        }
        $query = new ChildDevotionsQuery();
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
     * @return ChildDevotions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DevotionsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DevotionsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDevotions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, parish_id, devotion_date, topic, verse, content, has_media, type, url, created_at FROM devotions WHERE value = :p0';
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
            /** @var ChildDevotions $obj */
            $obj = new ChildDevotions();
            $obj->hydrate($row);
            DevotionsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDevotions|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the devotion_date column
     *
     * Example usage:
     * <code>
     * $query->filterByDevotionDate('2011-03-14'); // WHERE devotion_date = '2011-03-14'
     * $query->filterByDevotionDate('now'); // WHERE devotion_date = '2011-03-14'
     * $query->filterByDevotionDate(array('max' => 'yesterday')); // WHERE devotion_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $devotionDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByDevotionDate($devotionDate = null, $comparison = null)
    {
        if (is_array($devotionDate)) {
            $useMinMax = false;
            if (isset($devotionDate['min'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_DEVOTION_DATE, $devotionDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($devotionDate['max'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_DEVOTION_DATE, $devotionDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_DEVOTION_DATE, $devotionDate, $comparison);
    }

    /**
     * Filter the query on the topic column
     *
     * Example usage:
     * <code>
     * $query->filterByTopic('fooValue');   // WHERE topic = 'fooValue'
     * $query->filterByTopic('%fooValue%'); // WHERE topic LIKE '%fooValue%'
     * </code>
     *
     * @param     string $topic The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByTopic($topic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($topic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_TOPIC, $topic, $comparison);
    }

    /**
     * Filter the query on the verse column
     *
     * Example usage:
     * <code>
     * $query->filterByVerse('fooValue');   // WHERE verse = 'fooValue'
     * $query->filterByVerse('%fooValue%'); // WHERE verse LIKE '%fooValue%'
     * </code>
     *
     * @param     string $verse The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByVerse($verse = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($verse)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_VERSE, $verse, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the has_media column
     *
     * Example usage:
     * <code>
     * $query->filterByHasMedia(true); // WHERE has_media = true
     * $query->filterByHasMedia('yes'); // WHERE has_media = true
     * </code>
     *
     * @param     boolean|string $hasMedia The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByHasMedia($hasMedia = null, $comparison = null)
    {
        if (is_string($hasMedia)) {
            $hasMedia = in_array(strtolower($hasMedia), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_HAS_MEDIA, $hasMedia, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE type = 1234
     * $query->filterByType(array(12, 34)); // WHERE type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE type > 12
     * </code>
     *
     * @see       filterByMediaType()
     *
     * @param     mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DevotionsTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DevotionsTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(DevotionsTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DevotionsTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
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
     * Filter the query by a related \MediaType object
     *
     * @param \MediaType|ObjectCollection $mediaType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDevotionsQuery The current query, for fluid interface
     */
    public function filterByMediaType($mediaType, $comparison = null)
    {
        if ($mediaType instanceof \MediaType) {
            return $this
                ->addUsingAlias(DevotionsTableMap::COL_TYPE, $mediaType->getValue(), $comparison);
        } elseif ($mediaType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DevotionsTableMap::COL_TYPE, $mediaType->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByMediaType() only accepts arguments of type \MediaType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MediaType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function joinMediaType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MediaType');

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
            $this->addJoinObject($join, 'MediaType');
        }

        return $this;
    }

    /**
     * Use the MediaType relation MediaType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MediaTypeQuery A secondary query class using the current class as primary query
     */
    public function useMediaTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMediaType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MediaType', '\MediaTypeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDevotions $devotions Object to remove from the list of results
     *
     * @return $this|ChildDevotionsQuery The current query, for fluid interface
     */
    public function prune($devotions = null)
    {
        if ($devotions) {
            $this->addUsingAlias(DevotionsTableMap::COL_VALUE, $devotions->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the devotions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DevotionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DevotionsTableMap::clearInstancePool();
            DevotionsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DevotionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DevotionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DevotionsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DevotionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DevotionsQuery
