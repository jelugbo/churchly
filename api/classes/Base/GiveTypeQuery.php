<?php

namespace Base;

use \GiveType as ChildGiveType;
use \GiveTypeQuery as ChildGiveTypeQuery;
use \Exception;
use \PDO;
use Map\GiveTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'give_type' table.
 *
 * 
 *
 * @method     ChildGiveTypeQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildGiveTypeQuery orderByParishId($order = Criteria::ASC) Order by the parish_id column
 * @method     ChildGiveTypeQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildGiveTypeQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildGiveTypeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildGiveTypeQuery groupByValue() Group by the value column
 * @method     ChildGiveTypeQuery groupByParishId() Group by the parish_id column
 * @method     ChildGiveTypeQuery groupByCode() Group by the code column
 * @method     ChildGiveTypeQuery groupByName() Group by the name column
 * @method     ChildGiveTypeQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildGiveTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGiveTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGiveTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGiveTypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGiveTypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGiveTypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGiveTypeQuery leftJoinParish($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parish relation
 * @method     ChildGiveTypeQuery rightJoinParish($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parish relation
 * @method     ChildGiveTypeQuery innerJoinParish($relationAlias = null) Adds a INNER JOIN clause to the query using the Parish relation
 *
 * @method     ChildGiveTypeQuery joinWithParish($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parish relation
 *
 * @method     ChildGiveTypeQuery leftJoinWithParish() Adds a LEFT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveTypeQuery rightJoinWithParish() Adds a RIGHT JOIN clause and with to the query using the Parish relation
 * @method     ChildGiveTypeQuery innerJoinWithParish() Adds a INNER JOIN clause and with to the query using the Parish relation
 *
 * @method     \ParishQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGiveType findOne(ConnectionInterface $con = null) Return the first ChildGiveType matching the query
 * @method     ChildGiveType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGiveType matching the query, or a new ChildGiveType object populated from the query conditions when no match is found
 *
 * @method     ChildGiveType findOneByValue(int $value) Return the first ChildGiveType filtered by the value column
 * @method     ChildGiveType findOneByParishId(int $parish_id) Return the first ChildGiveType filtered by the parish_id column
 * @method     ChildGiveType findOneByCode(string $code) Return the first ChildGiveType filtered by the code column
 * @method     ChildGiveType findOneByName(string $name) Return the first ChildGiveType filtered by the name column
 * @method     ChildGiveType findOneByCreatedAt(string $created_at) Return the first ChildGiveType filtered by the created_at column *

 * @method     ChildGiveType requirePk($key, ConnectionInterface $con = null) Return the ChildGiveType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveType requireOne(ConnectionInterface $con = null) Return the first ChildGiveType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGiveType requireOneByValue(int $value) Return the first ChildGiveType filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveType requireOneByParishId(int $parish_id) Return the first ChildGiveType filtered by the parish_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveType requireOneByCode(string $code) Return the first ChildGiveType filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveType requireOneByName(string $name) Return the first ChildGiveType filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGiveType requireOneByCreatedAt(string $created_at) Return the first ChildGiveType filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGiveType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGiveType objects based on current ModelCriteria
 * @method     ChildGiveType[]|ObjectCollection findByValue(int $value) Return ChildGiveType objects filtered by the value column
 * @method     ChildGiveType[]|ObjectCollection findByParishId(int $parish_id) Return ChildGiveType objects filtered by the parish_id column
 * @method     ChildGiveType[]|ObjectCollection findByCode(string $code) Return ChildGiveType objects filtered by the code column
 * @method     ChildGiveType[]|ObjectCollection findByName(string $name) Return ChildGiveType objects filtered by the name column
 * @method     ChildGiveType[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildGiveType objects filtered by the created_at column
 * @method     ChildGiveType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GiveTypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GiveTypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\GiveType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGiveTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGiveTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGiveTypeQuery) {
            return $criteria;
        }
        $query = new ChildGiveTypeQuery();
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
     * @return ChildGiveType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GiveTypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GiveTypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGiveType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, parish_id, code, name, created_at FROM give_type WHERE value = :p0';
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
            /** @var ChildGiveType $obj */
            $obj = new ChildGiveType();
            $obj->hydrate($row);
            GiveTypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGiveType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByParishId($parishId = null, $comparison = null)
    {
        if (is_array($parishId)) {
            $useMinMax = false;
            if (isset($parishId['min'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_PARISH_ID, $parishId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parishId['max'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_PARISH_ID, $parishId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTypeTableMap::COL_PARISH_ID, $parishId, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTypeTableMap::COL_CODE, $code, $comparison);
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTypeTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GiveTypeTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiveTypeTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Parish object
     *
     * @param \Parish|ObjectCollection $parish The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGiveTypeQuery The current query, for fluid interface
     */
    public function filterByParish($parish, $comparison = null)
    {
        if ($parish instanceof \Parish) {
            return $this
                ->addUsingAlias(GiveTypeTableMap::COL_PARISH_ID, $parish->getValue(), $comparison);
        } elseif ($parish instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiveTypeTableMap::COL_PARISH_ID, $parish->toKeyValue('PrimaryKey', 'Value'), $comparison);
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
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildGiveType $giveType Object to remove from the list of results
     *
     * @return $this|ChildGiveTypeQuery The current query, for fluid interface
     */
    public function prune($giveType = null)
    {
        if ($giveType) {
            $this->addUsingAlias(GiveTypeTableMap::COL_VALUE, $giveType->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the give_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GiveTypeTableMap::clearInstancePool();
            GiveTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GiveTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GiveTypeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GiveTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GiveTypeQuery
