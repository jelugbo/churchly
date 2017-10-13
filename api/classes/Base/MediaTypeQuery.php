<?php

namespace Base;

use \MediaType as ChildMediaType;
use \MediaTypeQuery as ChildMediaTypeQuery;
use \Exception;
use \PDO;
use Map\MediaTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'media_type' table.
 *
 * 
 *
 * @method     ChildMediaTypeQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildMediaTypeQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildMediaTypeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildMediaTypeQuery groupByValue() Group by the value column
 * @method     ChildMediaTypeQuery groupByName() Group by the Name column
 * @method     ChildMediaTypeQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildMediaTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMediaTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMediaTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMediaTypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMediaTypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMediaTypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMediaTypeQuery leftJoinDevotions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Devotions relation
 * @method     ChildMediaTypeQuery rightJoinDevotions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Devotions relation
 * @method     ChildMediaTypeQuery innerJoinDevotions($relationAlias = null) Adds a INNER JOIN clause to the query using the Devotions relation
 *
 * @method     ChildMediaTypeQuery joinWithDevotions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Devotions relation
 *
 * @method     ChildMediaTypeQuery leftJoinWithDevotions() Adds a LEFT JOIN clause and with to the query using the Devotions relation
 * @method     ChildMediaTypeQuery rightJoinWithDevotions() Adds a RIGHT JOIN clause and with to the query using the Devotions relation
 * @method     ChildMediaTypeQuery innerJoinWithDevotions() Adds a INNER JOIN clause and with to the query using the Devotions relation
 *
 * @method     ChildMediaTypeQuery leftJoinMedia($relationAlias = null) Adds a LEFT JOIN clause to the query using the Media relation
 * @method     ChildMediaTypeQuery rightJoinMedia($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Media relation
 * @method     ChildMediaTypeQuery innerJoinMedia($relationAlias = null) Adds a INNER JOIN clause to the query using the Media relation
 *
 * @method     ChildMediaTypeQuery joinWithMedia($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Media relation
 *
 * @method     ChildMediaTypeQuery leftJoinWithMedia() Adds a LEFT JOIN clause and with to the query using the Media relation
 * @method     ChildMediaTypeQuery rightJoinWithMedia() Adds a RIGHT JOIN clause and with to the query using the Media relation
 * @method     ChildMediaTypeQuery innerJoinWithMedia() Adds a INNER JOIN clause and with to the query using the Media relation
 *
 * @method     \DevotionsQuery|\MediaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMediaType findOne(ConnectionInterface $con = null) Return the first ChildMediaType matching the query
 * @method     ChildMediaType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMediaType matching the query, or a new ChildMediaType object populated from the query conditions when no match is found
 *
 * @method     ChildMediaType findOneByValue(int $value) Return the first ChildMediaType filtered by the value column
 * @method     ChildMediaType findOneByName(string $Name) Return the first ChildMediaType filtered by the Name column
 * @method     ChildMediaType findOneByCreatedAt(string $created_at) Return the first ChildMediaType filtered by the created_at column *

 * @method     ChildMediaType requirePk($key, ConnectionInterface $con = null) Return the ChildMediaType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMediaType requireOne(ConnectionInterface $con = null) Return the first ChildMediaType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMediaType requireOneByValue(int $value) Return the first ChildMediaType filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMediaType requireOneByName(string $Name) Return the first ChildMediaType filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMediaType requireOneByCreatedAt(string $created_at) Return the first ChildMediaType filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMediaType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMediaType objects based on current ModelCriteria
 * @method     ChildMediaType[]|ObjectCollection findByValue(int $value) Return ChildMediaType objects filtered by the value column
 * @method     ChildMediaType[]|ObjectCollection findByName(string $Name) Return ChildMediaType objects filtered by the Name column
 * @method     ChildMediaType[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildMediaType objects filtered by the created_at column
 * @method     ChildMediaType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MediaTypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MediaTypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MediaType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMediaTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMediaTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMediaTypeQuery) {
            return $criteria;
        }
        $query = new ChildMediaTypeQuery();
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
     * @return ChildMediaType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MediaTypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MediaTypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMediaType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, Name, created_at FROM media_type WHERE value = :p0';
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
            /** @var ChildMediaType $obj */
            $obj = new ChildMediaType();
            $obj->hydrate($row);
            MediaTypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMediaType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MediaTypeTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MediaTypeTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MediaTypeTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MediaTypeTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Devotions object
     *
     * @param \Devotions|ObjectCollection $devotions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByDevotions($devotions, $comparison = null)
    {
        if ($devotions instanceof \Devotions) {
            return $this
                ->addUsingAlias(MediaTypeTableMap::COL_VALUE, $devotions->getType(), $comparison);
        } elseif ($devotions instanceof ObjectCollection) {
            return $this
                ->useDevotionsQuery()
                ->filterByPrimaryKeys($devotions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDevotions() only accepts arguments of type \Devotions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Devotions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function joinDevotions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Devotions');

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
            $this->addJoinObject($join, 'Devotions');
        }

        return $this;
    }

    /**
     * Use the Devotions relation Devotions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DevotionsQuery A secondary query class using the current class as primary query
     */
    public function useDevotionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDevotions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Devotions', '\DevotionsQuery');
    }

    /**
     * Filter the query by a related \Media object
     *
     * @param \Media|ObjectCollection $media the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMediaTypeQuery The current query, for fluid interface
     */
    public function filterByMedia($media, $comparison = null)
    {
        if ($media instanceof \Media) {
            return $this
                ->addUsingAlias(MediaTypeTableMap::COL_VALUE, $media->getType(), $comparison);
        } elseif ($media instanceof ObjectCollection) {
            return $this
                ->useMediaQuery()
                ->filterByPrimaryKeys($media->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMedia() only accepts arguments of type \Media or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Media relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function joinMedia($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Media');

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
            $this->addJoinObject($join, 'Media');
        }

        return $this;
    }

    /**
     * Use the Media relation Media object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MediaQuery A secondary query class using the current class as primary query
     */
    public function useMediaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMedia($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Media', '\MediaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMediaType $mediaType Object to remove from the list of results
     *
     * @return $this|ChildMediaTypeQuery The current query, for fluid interface
     */
    public function prune($mediaType = null)
    {
        if ($mediaType) {
            $this->addUsingAlias(MediaTypeTableMap::COL_VALUE, $mediaType->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the media_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MediaTypeTableMap::clearInstancePool();
            MediaTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MediaTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MediaTypeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MediaTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MediaTypeQuery
