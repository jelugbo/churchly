<?php

namespace Base;

use \Give as ChildGive;
use \GiveParishMethods as ChildGiveParishMethods;
use \GiveParishMethodsQuery as ChildGiveParishMethodsQuery;
use \GiveQuery as ChildGiveQuery;
use \GiveSplit as ChildGiveSplit;
use \GiveSplitQuery as ChildGiveSplitQuery;
use \Parish as ChildParish;
use \ParishQuery as ChildParishQuery;
use \UserProfile as ChildUserProfile;
use \UserProfileQuery as ChildUserProfileQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\GiveSplitTableMap;
use Map\GiveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'give' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Give implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GiveTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the value field.
     * 
     * @var        int
     */
    protected $value;

    /**
     * The value for the profile_id field.
     * 
     * @var        int
     */
    protected $profile_id;

    /**
     * The value for the parish_id field.
     * 
     * @var        int
     */
    protected $parish_id;

    /**
     * The value for the method_id field.
     * 
     * @var        int
     */
    protected $method_id;

    /**
     * The value for the currency field.
     * 
     * @var        string
     */
    protected $currency;

    /**
     * The value for the total field.
     * 
     * @var        string
     */
    protected $total;

    /**
     * The value for the txn_ref field.
     * 
     * @var        string
     */
    protected $txn_ref;

    /**
     * The value for the txn_status field.
     * 
     * @var        string
     */
    protected $txn_status;

    /**
     * The value for the description field.
     * 
     * @var        string
     */
    protected $description;

    /**
     * The value for the card_id field.
     * 
     * @var        string
     */
    protected $card_id;

    /**
     * The value for the created_at field.
     * 
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $created_at;

    /**
     * @var        ChildParish
     */
    protected $aParish;

    /**
     * @var        ChildUserProfile
     */
    protected $aUserProfile;

    /**
     * @var        ChildGiveParishMethods
     */
    protected $aGiveParishMethods;

    /**
     * @var        ObjectCollection|ChildGiveSplit[] Collection to store aggregation of ChildGiveSplit objects.
     */
    protected $collGiveSplits;
    protected $collGiveSplitsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGiveSplit[]
     */
    protected $giveSplitsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of Base\Give object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Give</code> instance.  If
     * <code>obj</code> is an instance of <code>Give</code>, delegates to
     * <code>equals(Give)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Give The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [value] column value.
     * 
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the [profile_id] column value.
     * 
     * @return int
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * Get the [parish_id] column value.
     * 
     * @return int
     */
    public function getParishId()
    {
        return $this->parish_id;
    }

    /**
     * Get the [method_id] column value.
     * 
     * @return int
     */
    public function getMethodId()
    {
        return $this->method_id;
    }

    /**
     * Get the [currency] column value.
     * 
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get the [total] column value.
     * 
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get the [txn_ref] column value.
     * 
     * @return string
     */
    public function getTxnRef()
    {
        return $this->txn_ref;
    }

    /**
     * Get the [txn_status] column value.
     * 
     * @return string
     */
    public function getTxnStatus()
    {
        return $this->txn_status;
    }

    /**
     * Get the [description] column value.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [card_id] column value.
     * 
     * @return string
     */
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Set the value of [value] column.
     * 
     * @param int $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[GiveTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

    /**
     * Set the value of [profile_id] column.
     * 
     * @param int $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setProfileId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->profile_id !== $v) {
            $this->profile_id = $v;
            $this->modifiedColumns[GiveTableMap::COL_PROFILE_ID] = true;
        }

        if ($this->aUserProfile !== null && $this->aUserProfile->getValue() !== $v) {
            $this->aUserProfile = null;
        }

        return $this;
    } // setProfileId()

    /**
     * Set the value of [parish_id] column.
     * 
     * @param int $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setParishId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parish_id !== $v) {
            $this->parish_id = $v;
            $this->modifiedColumns[GiveTableMap::COL_PARISH_ID] = true;
        }

        if ($this->aParish !== null && $this->aParish->getValue() !== $v) {
            $this->aParish = null;
        }

        return $this;
    } // setParishId()

    /**
     * Set the value of [method_id] column.
     * 
     * @param int $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setMethodId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->method_id !== $v) {
            $this->method_id = $v;
            $this->modifiedColumns[GiveTableMap::COL_METHOD_ID] = true;
        }

        if ($this->aGiveParishMethods !== null && $this->aGiveParishMethods->getValue() !== $v) {
            $this->aGiveParishMethods = null;
        }

        return $this;
    } // setMethodId()

    /**
     * Set the value of [currency] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setCurrency($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->currency !== $v) {
            $this->currency = $v;
            $this->modifiedColumns[GiveTableMap::COL_CURRENCY] = true;
        }

        return $this;
    } // setCurrency()

    /**
     * Set the value of [total] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[GiveTableMap::COL_TOTAL] = true;
        }

        return $this;
    } // setTotal()

    /**
     * Set the value of [txn_ref] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setTxnRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->txn_ref !== $v) {
            $this->txn_ref = $v;
            $this->modifiedColumns[GiveTableMap::COL_TXN_REF] = true;
        }

        return $this;
    } // setTxnRef()

    /**
     * Set the value of [txn_status] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setTxnStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->txn_status !== $v) {
            $this->txn_status = $v;
            $this->modifiedColumns[GiveTableMap::COL_TXN_STATUS] = true;
        }

        return $this;
    } // setTxnStatus()

    /**
     * Set the value of [description] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[GiveTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [card_id] column.
     * 
     * @param string $v new value
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setCardId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->card_id !== $v) {
            $this->card_id = $v;
            $this->modifiedColumns[GiveTableMap::COL_CARD_ID] = true;
        }

        return $this;
    } // setCardId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Give The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GiveTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GiveTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GiveTableMap::translateFieldName('ProfileId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->profile_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GiveTableMap::translateFieldName('ParishId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parish_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GiveTableMap::translateFieldName('MethodId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->method_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : GiveTableMap::translateFieldName('Currency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : GiveTableMap::translateFieldName('Total', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : GiveTableMap::translateFieldName('TxnRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->txn_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : GiveTableMap::translateFieldName('TxnStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->txn_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : GiveTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : GiveTableMap::translateFieldName('CardId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->card_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : GiveTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = GiveTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Give'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUserProfile !== null && $this->profile_id !== $this->aUserProfile->getValue()) {
            $this->aUserProfile = null;
        }
        if ($this->aParish !== null && $this->parish_id !== $this->aParish->getValue()) {
            $this->aParish = null;
        }
        if ($this->aGiveParishMethods !== null && $this->method_id !== $this->aGiveParishMethods->getValue()) {
            $this->aGiveParishMethods = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GiveTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGiveQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aParish = null;
            $this->aUserProfile = null;
            $this->aGiveParishMethods = null;
            $this->collGiveSplits = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Give::setDeleted()
     * @see Give::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGiveQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiveTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GiveTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aParish !== null) {
                if ($this->aParish->isModified() || $this->aParish->isNew()) {
                    $affectedRows += $this->aParish->save($con);
                }
                $this->setParish($this->aParish);
            }

            if ($this->aUserProfile !== null) {
                if ($this->aUserProfile->isModified() || $this->aUserProfile->isNew()) {
                    $affectedRows += $this->aUserProfile->save($con);
                }
                $this->setUserProfile($this->aUserProfile);
            }

            if ($this->aGiveParishMethods !== null) {
                if ($this->aGiveParishMethods->isModified() || $this->aGiveParishMethods->isNew()) {
                    $affectedRows += $this->aGiveParishMethods->save($con);
                }
                $this->setGiveParishMethods($this->aGiveParishMethods);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->giveSplitsScheduledForDeletion !== null) {
                if (!$this->giveSplitsScheduledForDeletion->isEmpty()) {
                    \GiveSplitQuery::create()
                        ->filterByPrimaryKeys($this->giveSplitsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->giveSplitsScheduledForDeletion = null;
                }
            }

            if ($this->collGiveSplits !== null) {
                foreach ($this->collGiveSplits as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[GiveTableMap::COL_VALUE] = true;
        if (null !== $this->value) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GiveTableMap::COL_VALUE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GiveTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }
        if ($this->isColumnModified(GiveTableMap::COL_PROFILE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'profile_id';
        }
        if ($this->isColumnModified(GiveTableMap::COL_PARISH_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parish_id';
        }
        if ($this->isColumnModified(GiveTableMap::COL_METHOD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'method_id';
        }
        if ($this->isColumnModified(GiveTableMap::COL_CURRENCY)) {
            $modifiedColumns[':p' . $index++]  = 'currency';
        }
        if ($this->isColumnModified(GiveTableMap::COL_TOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'total';
        }
        if ($this->isColumnModified(GiveTableMap::COL_TXN_REF)) {
            $modifiedColumns[':p' . $index++]  = 'txn_ref';
        }
        if ($this->isColumnModified(GiveTableMap::COL_TXN_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'txn_status';
        }
        if ($this->isColumnModified(GiveTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(GiveTableMap::COL_CARD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'card_id';
        }
        if ($this->isColumnModified(GiveTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }

        $sql = sprintf(
            'INSERT INTO give (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'value':                        
                        $stmt->bindValue($identifier, $this->value, PDO::PARAM_INT);
                        break;
                    case 'profile_id':                        
                        $stmt->bindValue($identifier, $this->profile_id, PDO::PARAM_INT);
                        break;
                    case 'parish_id':                        
                        $stmt->bindValue($identifier, $this->parish_id, PDO::PARAM_INT);
                        break;
                    case 'method_id':                        
                        $stmt->bindValue($identifier, $this->method_id, PDO::PARAM_INT);
                        break;
                    case 'currency':                        
                        $stmt->bindValue($identifier, $this->currency, PDO::PARAM_STR);
                        break;
                    case 'total':                        
                        $stmt->bindValue($identifier, $this->total, PDO::PARAM_STR);
                        break;
                    case 'txn_ref':                        
                        $stmt->bindValue($identifier, $this->txn_ref, PDO::PARAM_STR);
                        break;
                    case 'txn_status':                        
                        $stmt->bindValue($identifier, $this->txn_status, PDO::PARAM_STR);
                        break;
                    case 'description':                        
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'card_id':                        
                        $stmt->bindValue($identifier, $this->card_id, PDO::PARAM_STR);
                        break;
                    case 'created_at':                        
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setValue($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GiveTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getValue();
                break;
            case 1:
                return $this->getProfileId();
                break;
            case 2:
                return $this->getParishId();
                break;
            case 3:
                return $this->getMethodId();
                break;
            case 4:
                return $this->getCurrency();
                break;
            case 5:
                return $this->getTotal();
                break;
            case 6:
                return $this->getTxnRef();
                break;
            case 7:
                return $this->getTxnStatus();
                break;
            case 8:
                return $this->getDescription();
                break;
            case 9:
                return $this->getCardId();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Give'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Give'][$this->hashCode()] = true;
        $keys = GiveTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getValue(),
            $keys[1] => $this->getProfileId(),
            $keys[2] => $this->getParishId(),
            $keys[3] => $this->getMethodId(),
            $keys[4] => $this->getCurrency(),
            $keys[5] => $this->getTotal(),
            $keys[6] => $this->getTxnRef(),
            $keys[7] => $this->getTxnStatus(),
            $keys[8] => $this->getDescription(),
            $keys[9] => $this->getCardId(),
            $keys[10] => $this->getCreatedAt(),
        );
        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aParish) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'parish';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'parish';
                        break;
                    default:
                        $key = 'Parish';
                }
        
                $result[$key] = $this->aParish->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserProfile) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userProfile';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_profile';
                        break;
                    default:
                        $key = 'UserProfile';
                }
        
                $result[$key] = $this->aUserProfile->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aGiveParishMethods) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giveParishMethods';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'give_parish_methods';
                        break;
                    default:
                        $key = 'GiveParishMethods';
                }
        
                $result[$key] = $this->aGiveParishMethods->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collGiveSplits) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giveSplits';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'give_splits';
                        break;
                    default:
                        $key = 'GiveSplits';
                }
        
                $result[$key] = $this->collGiveSplits->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Give
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GiveTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Give
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setValue($value);
                break;
            case 1:
                $this->setProfileId($value);
                break;
            case 2:
                $this->setParishId($value);
                break;
            case 3:
                $this->setMethodId($value);
                break;
            case 4:
                $this->setCurrency($value);
                break;
            case 5:
                $this->setTotal($value);
                break;
            case 6:
                $this->setTxnRef($value);
                break;
            case 7:
                $this->setTxnStatus($value);
                break;
            case 8:
                $this->setDescription($value);
                break;
            case 9:
                $this->setCardId($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GiveTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setValue($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProfileId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setParishId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMethodId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCurrency($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTotal($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTxnRef($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTxnStatus($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDescription($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCardId($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Give The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GiveTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GiveTableMap::COL_VALUE)) {
            $criteria->add(GiveTableMap::COL_VALUE, $this->value);
        }
        if ($this->isColumnModified(GiveTableMap::COL_PROFILE_ID)) {
            $criteria->add(GiveTableMap::COL_PROFILE_ID, $this->profile_id);
        }
        if ($this->isColumnModified(GiveTableMap::COL_PARISH_ID)) {
            $criteria->add(GiveTableMap::COL_PARISH_ID, $this->parish_id);
        }
        if ($this->isColumnModified(GiveTableMap::COL_METHOD_ID)) {
            $criteria->add(GiveTableMap::COL_METHOD_ID, $this->method_id);
        }
        if ($this->isColumnModified(GiveTableMap::COL_CURRENCY)) {
            $criteria->add(GiveTableMap::COL_CURRENCY, $this->currency);
        }
        if ($this->isColumnModified(GiveTableMap::COL_TOTAL)) {
            $criteria->add(GiveTableMap::COL_TOTAL, $this->total);
        }
        if ($this->isColumnModified(GiveTableMap::COL_TXN_REF)) {
            $criteria->add(GiveTableMap::COL_TXN_REF, $this->txn_ref);
        }
        if ($this->isColumnModified(GiveTableMap::COL_TXN_STATUS)) {
            $criteria->add(GiveTableMap::COL_TXN_STATUS, $this->txn_status);
        }
        if ($this->isColumnModified(GiveTableMap::COL_DESCRIPTION)) {
            $criteria->add(GiveTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(GiveTableMap::COL_CARD_ID)) {
            $criteria->add(GiveTableMap::COL_CARD_ID, $this->card_id);
        }
        if ($this->isColumnModified(GiveTableMap::COL_CREATED_AT)) {
            $criteria->add(GiveTableMap::COL_CREATED_AT, $this->created_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGiveQuery::create();
        $criteria->add(GiveTableMap::COL_VALUE, $this->value);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getValue();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getValue();
    }

    /**
     * Generic method to set the primary key (value column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setValue($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getValue();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Give (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProfileId($this->getProfileId());
        $copyObj->setParishId($this->getParishId());
        $copyObj->setMethodId($this->getMethodId());
        $copyObj->setCurrency($this->getCurrency());
        $copyObj->setTotal($this->getTotal());
        $copyObj->setTxnRef($this->getTxnRef());
        $copyObj->setTxnStatus($this->getTxnStatus());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setCardId($this->getCardId());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGiveSplits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGiveSplit($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setValue(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Give Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildParish object.
     *
     * @param  ChildParish $v
     * @return $this|\Give The current object (for fluent API support)
     * @throws PropelException
     */
    public function setParish(ChildParish $v = null)
    {
        if ($v === null) {
            $this->setParishId(NULL);
        } else {
            $this->setParishId($v->getValue());
        }

        $this->aParish = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildParish object, it will not be re-added.
        if ($v !== null) {
            $v->addGive($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildParish object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildParish The associated ChildParish object.
     * @throws PropelException
     */
    public function getParish(ConnectionInterface $con = null)
    {
        if ($this->aParish === null && ($this->parish_id !== null)) {
            $this->aParish = ChildParishQuery::create()->findPk($this->parish_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aParish->addGives($this);
             */
        }

        return $this->aParish;
    }

    /**
     * Declares an association between this object and a ChildUserProfile object.
     *
     * @param  ChildUserProfile $v
     * @return $this|\Give The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserProfile(ChildUserProfile $v = null)
    {
        if ($v === null) {
            $this->setProfileId(NULL);
        } else {
            $this->setProfileId($v->getValue());
        }

        $this->aUserProfile = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUserProfile object, it will not be re-added.
        if ($v !== null) {
            $v->addGive($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUserProfile object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUserProfile The associated ChildUserProfile object.
     * @throws PropelException
     */
    public function getUserProfile(ConnectionInterface $con = null)
    {
        if ($this->aUserProfile === null && ($this->profile_id !== null)) {
            $this->aUserProfile = ChildUserProfileQuery::create()->findPk($this->profile_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserProfile->addGives($this);
             */
        }

        return $this->aUserProfile;
    }

    /**
     * Declares an association between this object and a ChildGiveParishMethods object.
     *
     * @param  ChildGiveParishMethods $v
     * @return $this|\Give The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGiveParishMethods(ChildGiveParishMethods $v = null)
    {
        if ($v === null) {
            $this->setMethodId(NULL);
        } else {
            $this->setMethodId($v->getValue());
        }

        $this->aGiveParishMethods = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGiveParishMethods object, it will not be re-added.
        if ($v !== null) {
            $v->addGive($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGiveParishMethods object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGiveParishMethods The associated ChildGiveParishMethods object.
     * @throws PropelException
     */
    public function getGiveParishMethods(ConnectionInterface $con = null)
    {
        if ($this->aGiveParishMethods === null && ($this->method_id !== null)) {
            $this->aGiveParishMethods = ChildGiveParishMethodsQuery::create()->findPk($this->method_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGiveParishMethods->addGives($this);
             */
        }

        return $this->aGiveParishMethods;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('GiveSplit' == $relationName) {
            return $this->initGiveSplits();
        }
    }

    /**
     * Clears out the collGiveSplits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGiveSplits()
     */
    public function clearGiveSplits()
    {
        $this->collGiveSplits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGiveSplits collection loaded partially.
     */
    public function resetPartialGiveSplits($v = true)
    {
        $this->collGiveSplitsPartial = $v;
    }

    /**
     * Initializes the collGiveSplits collection.
     *
     * By default this just sets the collGiveSplits collection to an empty array (like clearcollGiveSplits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGiveSplits($overrideExisting = true)
    {
        if (null !== $this->collGiveSplits && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiveSplitTableMap::getTableMap()->getCollectionClassName();

        $this->collGiveSplits = new $collectionClassName;
        $this->collGiveSplits->setModel('\GiveSplit');
    }

    /**
     * Gets an array of ChildGiveSplit objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGive is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGiveSplit[] List of ChildGiveSplit objects
     * @throws PropelException
     */
    public function getGiveSplits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveSplitsPartial && !$this->isNew();
        if (null === $this->collGiveSplits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGiveSplits) {
                // return empty collection
                $this->initGiveSplits();
            } else {
                $collGiveSplits = ChildGiveSplitQuery::create(null, $criteria)
                    ->filterByGive($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGiveSplitsPartial && count($collGiveSplits)) {
                        $this->initGiveSplits(false);

                        foreach ($collGiveSplits as $obj) {
                            if (false == $this->collGiveSplits->contains($obj)) {
                                $this->collGiveSplits->append($obj);
                            }
                        }

                        $this->collGiveSplitsPartial = true;
                    }

                    return $collGiveSplits;
                }

                if ($partial && $this->collGiveSplits) {
                    foreach ($this->collGiveSplits as $obj) {
                        if ($obj->isNew()) {
                            $collGiveSplits[] = $obj;
                        }
                    }
                }

                $this->collGiveSplits = $collGiveSplits;
                $this->collGiveSplitsPartial = false;
            }
        }

        return $this->collGiveSplits;
    }

    /**
     * Sets a collection of ChildGiveSplit objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $giveSplits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGive The current object (for fluent API support)
     */
    public function setGiveSplits(Collection $giveSplits, ConnectionInterface $con = null)
    {
        /** @var ChildGiveSplit[] $giveSplitsToDelete */
        $giveSplitsToDelete = $this->getGiveSplits(new Criteria(), $con)->diff($giveSplits);

        
        $this->giveSplitsScheduledForDeletion = $giveSplitsToDelete;

        foreach ($giveSplitsToDelete as $giveSplitRemoved) {
            $giveSplitRemoved->setGive(null);
        }

        $this->collGiveSplits = null;
        foreach ($giveSplits as $giveSplit) {
            $this->addGiveSplit($giveSplit);
        }

        $this->collGiveSplits = $giveSplits;
        $this->collGiveSplitsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GiveSplit objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GiveSplit objects.
     * @throws PropelException
     */
    public function countGiveSplits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveSplitsPartial && !$this->isNew();
        if (null === $this->collGiveSplits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGiveSplits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGiveSplits());
            }

            $query = ChildGiveSplitQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGive($this)
                ->count($con);
        }

        return count($this->collGiveSplits);
    }

    /**
     * Method called to associate a ChildGiveSplit object to this object
     * through the ChildGiveSplit foreign key attribute.
     *
     * @param  ChildGiveSplit $l ChildGiveSplit
     * @return $this|\Give The current object (for fluent API support)
     */
    public function addGiveSplit(ChildGiveSplit $l)
    {
        if ($this->collGiveSplits === null) {
            $this->initGiveSplits();
            $this->collGiveSplitsPartial = true;
        }

        if (!$this->collGiveSplits->contains($l)) {
            $this->doAddGiveSplit($l);

            if ($this->giveSplitsScheduledForDeletion and $this->giveSplitsScheduledForDeletion->contains($l)) {
                $this->giveSplitsScheduledForDeletion->remove($this->giveSplitsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGiveSplit $giveSplit The ChildGiveSplit object to add.
     */
    protected function doAddGiveSplit(ChildGiveSplit $giveSplit)
    {
        $this->collGiveSplits[]= $giveSplit;
        $giveSplit->setGive($this);
    }

    /**
     * @param  ChildGiveSplit $giveSplit The ChildGiveSplit object to remove.
     * @return $this|ChildGive The current object (for fluent API support)
     */
    public function removeGiveSplit(ChildGiveSplit $giveSplit)
    {
        if ($this->getGiveSplits()->contains($giveSplit)) {
            $pos = $this->collGiveSplits->search($giveSplit);
            $this->collGiveSplits->remove($pos);
            if (null === $this->giveSplitsScheduledForDeletion) {
                $this->giveSplitsScheduledForDeletion = clone $this->collGiveSplits;
                $this->giveSplitsScheduledForDeletion->clear();
            }
            $this->giveSplitsScheduledForDeletion[]= clone $giveSplit;
            $giveSplit->setGive(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aParish) {
            $this->aParish->removeGive($this);
        }
        if (null !== $this->aUserProfile) {
            $this->aUserProfile->removeGive($this);
        }
        if (null !== $this->aGiveParishMethods) {
            $this->aGiveParishMethods->removeGive($this);
        }
        $this->value = null;
        $this->profile_id = null;
        $this->parish_id = null;
        $this->method_id = null;
        $this->currency = null;
        $this->total = null;
        $this->txn_ref = null;
        $this->txn_status = null;
        $this->description = null;
        $this->card_id = null;
        $this->created_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collGiveSplits) {
                foreach ($this->collGiveSplits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGiveSplits = null;
        $this->aParish = null;
        $this->aUserProfile = null;
        $this->aGiveParishMethods = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GiveTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
