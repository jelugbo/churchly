<?php

namespace Base;

use \BibleChapters as ChildBibleChapters;
use \BibleChaptersQuery as ChildBibleChaptersQuery;
use \Exception;
use \PDO;
use Map\BibleChaptersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'bible_chapters' table.
 *
 * 
 *
 * @method     ChildBibleChaptersQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildBibleChaptersQuery orderByBookId($order = Criteria::ASC) Order by the book_id column
 * @method     ChildBibleChaptersQuery orderByChapter($order = Criteria::ASC) Order by the chapter column
 *
 * @method     ChildBibleChaptersQuery groupByValue() Group by the value column
 * @method     ChildBibleChaptersQuery groupByBookId() Group by the book_id column
 * @method     ChildBibleChaptersQuery groupByChapter() Group by the chapter column
 *
 * @method     ChildBibleChaptersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBibleChaptersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBibleChaptersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBibleChaptersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBibleChaptersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBibleChaptersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBibleChaptersQuery leftJoinBibleBooks($relationAlias = null) Adds a LEFT JOIN clause to the query using the BibleBooks relation
 * @method     ChildBibleChaptersQuery rightJoinBibleBooks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BibleBooks relation
 * @method     ChildBibleChaptersQuery innerJoinBibleBooks($relationAlias = null) Adds a INNER JOIN clause to the query using the BibleBooks relation
 *
 * @method     ChildBibleChaptersQuery joinWithBibleBooks($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BibleBooks relation
 *
 * @method     ChildBibleChaptersQuery leftJoinWithBibleBooks() Adds a LEFT JOIN clause and with to the query using the BibleBooks relation
 * @method     ChildBibleChaptersQuery rightJoinWithBibleBooks() Adds a RIGHT JOIN clause and with to the query using the BibleBooks relation
 * @method     ChildBibleChaptersQuery innerJoinWithBibleBooks() Adds a INNER JOIN clause and with to the query using the BibleBooks relation
 *
 * @method     ChildBibleChaptersQuery leftJoinBibleVerses($relationAlias = null) Adds a LEFT JOIN clause to the query using the BibleVerses relation
 * @method     ChildBibleChaptersQuery rightJoinBibleVerses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BibleVerses relation
 * @method     ChildBibleChaptersQuery innerJoinBibleVerses($relationAlias = null) Adds a INNER JOIN clause to the query using the BibleVerses relation
 *
 * @method     ChildBibleChaptersQuery joinWithBibleVerses($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BibleVerses relation
 *
 * @method     ChildBibleChaptersQuery leftJoinWithBibleVerses() Adds a LEFT JOIN clause and with to the query using the BibleVerses relation
 * @method     ChildBibleChaptersQuery rightJoinWithBibleVerses() Adds a RIGHT JOIN clause and with to the query using the BibleVerses relation
 * @method     ChildBibleChaptersQuery innerJoinWithBibleVerses() Adds a INNER JOIN clause and with to the query using the BibleVerses relation
 *
 * @method     \BibleBooksQuery|\BibleVersesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBibleChapters findOne(ConnectionInterface $con = null) Return the first ChildBibleChapters matching the query
 * @method     ChildBibleChapters findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBibleChapters matching the query, or a new ChildBibleChapters object populated from the query conditions when no match is found
 *
 * @method     ChildBibleChapters findOneByValue(int $value) Return the first ChildBibleChapters filtered by the value column
 * @method     ChildBibleChapters findOneByBookId(int $book_id) Return the first ChildBibleChapters filtered by the book_id column
 * @method     ChildBibleChapters findOneByChapter(int $chapter) Return the first ChildBibleChapters filtered by the chapter column *

 * @method     ChildBibleChapters requirePk($key, ConnectionInterface $con = null) Return the ChildBibleChapters by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBibleChapters requireOne(ConnectionInterface $con = null) Return the first ChildBibleChapters matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBibleChapters requireOneByValue(int $value) Return the first ChildBibleChapters filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBibleChapters requireOneByBookId(int $book_id) Return the first ChildBibleChapters filtered by the book_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBibleChapters requireOneByChapter(int $chapter) Return the first ChildBibleChapters filtered by the chapter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBibleChapters[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBibleChapters objects based on current ModelCriteria
 * @method     ChildBibleChapters[]|ObjectCollection findByValue(int $value) Return ChildBibleChapters objects filtered by the value column
 * @method     ChildBibleChapters[]|ObjectCollection findByBookId(int $book_id) Return ChildBibleChapters objects filtered by the book_id column
 * @method     ChildBibleChapters[]|ObjectCollection findByChapter(int $chapter) Return ChildBibleChapters objects filtered by the chapter column
 * @method     ChildBibleChapters[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BibleChaptersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BibleChaptersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BibleChapters', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBibleChaptersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBibleChaptersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBibleChaptersQuery) {
            return $criteria;
        }
        $query = new ChildBibleChaptersQuery();
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
     * @return ChildBibleChapters|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BibleChaptersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BibleChaptersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBibleChapters A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, book_id, chapter FROM bible_chapters WHERE value = :p0';
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
            /** @var ChildBibleChapters $obj */
            $obj = new ChildBibleChapters();
            $obj->hydrate($row);
            BibleChaptersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBibleChapters|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the book_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBookId(1234); // WHERE book_id = 1234
     * $query->filterByBookId(array(12, 34)); // WHERE book_id IN (12, 34)
     * $query->filterByBookId(array('min' => 12)); // WHERE book_id > 12
     * </code>
     *
     * @see       filterByBibleBooks()
     *
     * @param     mixed $bookId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByBookId($bookId = null, $comparison = null)
    {
        if (is_array($bookId)) {
            $useMinMax = false;
            if (isset($bookId['min'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_BOOK_ID, $bookId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bookId['max'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_BOOK_ID, $bookId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BibleChaptersTableMap::COL_BOOK_ID, $bookId, $comparison);
    }

    /**
     * Filter the query on the chapter column
     *
     * Example usage:
     * <code>
     * $query->filterByChapter(1234); // WHERE chapter = 1234
     * $query->filterByChapter(array(12, 34)); // WHERE chapter IN (12, 34)
     * $query->filterByChapter(array('min' => 12)); // WHERE chapter > 12
     * </code>
     *
     * @param     mixed $chapter The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByChapter($chapter = null, $comparison = null)
    {
        if (is_array($chapter)) {
            $useMinMax = false;
            if (isset($chapter['min'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_CHAPTER, $chapter['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($chapter['max'])) {
                $this->addUsingAlias(BibleChaptersTableMap::COL_CHAPTER, $chapter['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BibleChaptersTableMap::COL_CHAPTER, $chapter, $comparison);
    }

    /**
     * Filter the query by a related \BibleBooks object
     *
     * @param \BibleBooks|ObjectCollection $bibleBooks The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByBibleBooks($bibleBooks, $comparison = null)
    {
        if ($bibleBooks instanceof \BibleBooks) {
            return $this
                ->addUsingAlias(BibleChaptersTableMap::COL_BOOK_ID, $bibleBooks->getValue(), $comparison);
        } elseif ($bibleBooks instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BibleChaptersTableMap::COL_BOOK_ID, $bibleBooks->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByBibleBooks() only accepts arguments of type \BibleBooks or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BibleBooks relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function joinBibleBooks($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BibleBooks');

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
            $this->addJoinObject($join, 'BibleBooks');
        }

        return $this;
    }

    /**
     * Use the BibleBooks relation BibleBooks object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BibleBooksQuery A secondary query class using the current class as primary query
     */
    public function useBibleBooksQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBibleBooks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BibleBooks', '\BibleBooksQuery');
    }

    /**
     * Filter the query by a related \BibleVerses object
     *
     * @param \BibleVerses|ObjectCollection $bibleVerses the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function filterByBibleVerses($bibleVerses, $comparison = null)
    {
        if ($bibleVerses instanceof \BibleVerses) {
            return $this
                ->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $bibleVerses->getChapterId(), $comparison);
        } elseif ($bibleVerses instanceof ObjectCollection) {
            return $this
                ->useBibleVersesQuery()
                ->filterByPrimaryKeys($bibleVerses->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBibleVerses() only accepts arguments of type \BibleVerses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BibleVerses relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function joinBibleVerses($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BibleVerses');

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
            $this->addJoinObject($join, 'BibleVerses');
        }

        return $this;
    }

    /**
     * Use the BibleVerses relation BibleVerses object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BibleVersesQuery A secondary query class using the current class as primary query
     */
    public function useBibleVersesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBibleVerses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BibleVerses', '\BibleVersesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBibleChapters $bibleChapters Object to remove from the list of results
     *
     * @return $this|ChildBibleChaptersQuery The current query, for fluid interface
     */
    public function prune($bibleChapters = null)
    {
        if ($bibleChapters) {
            $this->addUsingAlias(BibleChaptersTableMap::COL_VALUE, $bibleChapters->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the bible_chapters table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BibleChaptersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BibleChaptersTableMap::clearInstancePool();
            BibleChaptersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BibleChaptersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BibleChaptersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            BibleChaptersTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            BibleChaptersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BibleChaptersQuery
