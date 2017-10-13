<?php

namespace Base;

use \Parish as ChildParish;
use \ParishQuery as ChildParishQuery;
use \UserLogin as ChildUserLogin;
use \UserLoginQuery as ChildUserLoginQuery;
use \UserPayment as ChildUserPayment;
use \UserPaymentQuery as ChildUserPaymentQuery;
use \UserPlan as ChildUserPlan;
use \UserPlanQuery as ChildUserPlanQuery;
use \UserSubscriptionQuery as ChildUserSubscriptionQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\UserSubscriptionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'user_subscription' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class UserSubscription implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserSubscriptionTableMap';


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
     * The value for the plan_id field.
     * 
     * @var        int
     */
    protected $plan_id;

    /**
     * The value for the user_id field.
     * 
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the parish_id field.
     * 
     * @var        int
     */
    protected $parish_id;

    /**
     * The value for the status field.
     * 
     * @var        boolean
     */
    protected $status;

    /**
     * The value for the start_date field.
     * 
     * @var        DateTime
     */
    protected $start_date;

    /**
     * The value for the end_date field.
     * 
     * @var        DateTime
     */
    protected $end_date;

    /**
     * The value for the pay_id field.
     * 
     * @var        int
     */
    protected $pay_id;

    /**
     * The value for the customer_ref field.
     * 
     * @var        string
     */
    protected $customer_ref;

    /**
     * The value for the mileage field.
     * 
     * @var        string
     */
    protected $mileage;

    /**
     * @var        ChildUserLogin
     */
    protected $aUserLogin;

    /**
     * @var        ChildUserPlan
     */
    protected $aUserPlan;

    /**
     * @var        ChildUserPayment
     */
    protected $aUserPayment;

    /**
     * @var        ChildParish
     */
    protected $aParish;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\UserSubscription object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>UserSubscription</code> instance.  If
     * <code>obj</code> is an instance of <code>UserSubscription</code>, delegates to
     * <code>equals(UserSubscription)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UserSubscription The current object, for fluid interface
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
     * Get the [plan_id] column value.
     * 
     * @return int
     */
    public function getPlanId()
    {
        return $this->plan_id;
    }

    /**
     * Get the [user_id] column value.
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * Get the [status] column value.
     * 
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [status] column value.
     * 
     * @return boolean
     */
    public function isStatus()
    {
        return $this->getStatus();
    }

    /**
     * Get the [optionally formatted] temporal [start_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = NULL)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTimeInterface ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = NULL)
    {
        if ($format === null) {
            return $this->end_date;
        } else {
            return $this->end_date instanceof \DateTimeInterface ? $this->end_date->format($format) : null;
        }
    }

    /**
     * Get the [pay_id] column value.
     * 
     * @return int
     */
    public function getPayId()
    {
        return $this->pay_id;
    }

    /**
     * Get the [customer_ref] column value.
     * 
     * @return string
     */
    public function getCustomerRef()
    {
        return $this->customer_ref;
    }

    /**
     * Get the [mileage] column value.
     * 
     * @return string
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set the value of [value] column.
     * 
     * @param int $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

    /**
     * Set the value of [plan_id] column.
     * 
     * @param int $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setPlanId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->plan_id !== $v) {
            $this->plan_id = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_PLAN_ID] = true;
        }

        if ($this->aUserPlan !== null && $this->aUserPlan->getValue() !== $v) {
            $this->aUserPlan = null;
        }

        return $this;
    } // setPlanId()

    /**
     * Set the value of [user_id] column.
     * 
     * @param int $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_USER_ID] = true;
        }

        if ($this->aUserLogin !== null && $this->aUserLogin->getValue() !== $v) {
            $this->aUserLogin = null;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [parish_id] column.
     * 
     * @param int $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setParishId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parish_id !== $v) {
            $this->parish_id = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_PARISH_ID] = true;
        }

        if ($this->aParish !== null && $this->aParish->getValue() !== $v) {
            $this->aParish = null;
        }

        return $this;
    } // setParishId()

    /**
     * Sets the value of the [status] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->start_date->format("Y-m-d H:i:s.u")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserSubscriptionTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->end_date->format("Y-m-d H:i:s.u")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserSubscriptionTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Set the value of [pay_id] column.
     * 
     * @param int $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setPayId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->pay_id !== $v) {
            $this->pay_id = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_PAY_ID] = true;
        }

        if ($this->aUserPayment !== null && $this->aUserPayment->getValue() !== $v) {
            $this->aUserPayment = null;
        }

        return $this;
    } // setPayId()

    /**
     * Set the value of [customer_ref] column.
     * 
     * @param string $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setCustomerRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->customer_ref !== $v) {
            $this->customer_ref = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_CUSTOMER_REF] = true;
        }

        return $this;
    } // setCustomerRef()

    /**
     * Set the value of [mileage] column.
     * 
     * @param string $v new value
     * @return $this|\UserSubscription The current object (for fluent API support)
     */
    public function setMileage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mileage !== $v) {
            $this->mileage = $v;
            $this->modifiedColumns[UserSubscriptionTableMap::COL_MILEAGE] = true;
        }

        return $this;
    } // setMileage()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserSubscriptionTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserSubscriptionTableMap::translateFieldName('PlanId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->plan_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserSubscriptionTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserSubscriptionTableMap::translateFieldName('ParishId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parish_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserSubscriptionTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserSubscriptionTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserSubscriptionTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserSubscriptionTableMap::translateFieldName('PayId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pay_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserSubscriptionTableMap::translateFieldName('CustomerRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserSubscriptionTableMap::translateFieldName('Mileage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mileage = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = UserSubscriptionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\UserSubscription'), 0, $e);
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
        if ($this->aUserPlan !== null && $this->plan_id !== $this->aUserPlan->getValue()) {
            $this->aUserPlan = null;
        }
        if ($this->aUserLogin !== null && $this->user_id !== $this->aUserLogin->getValue()) {
            $this->aUserLogin = null;
        }
        if ($this->aParish !== null && $this->parish_id !== $this->aParish->getValue()) {
            $this->aParish = null;
        }
        if ($this->aUserPayment !== null && $this->pay_id !== $this->aUserPayment->getValue()) {
            $this->aUserPayment = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserSubscriptionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUserLogin = null;
            $this->aUserPlan = null;
            $this->aUserPayment = null;
            $this->aParish = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UserSubscription::setDeleted()
     * @see UserSubscription::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserSubscriptionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserSubscriptionTableMap::DATABASE_NAME);
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
                UserSubscriptionTableMap::addInstanceToPool($this);
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

            if ($this->aUserLogin !== null) {
                if ($this->aUserLogin->isModified() || $this->aUserLogin->isNew()) {
                    $affectedRows += $this->aUserLogin->save($con);
                }
                $this->setUserLogin($this->aUserLogin);
            }

            if ($this->aUserPlan !== null) {
                if ($this->aUserPlan->isModified() || $this->aUserPlan->isNew()) {
                    $affectedRows += $this->aUserPlan->save($con);
                }
                $this->setUserPlan($this->aUserPlan);
            }

            if ($this->aUserPayment !== null) {
                if ($this->aUserPayment->isModified() || $this->aUserPayment->isNew()) {
                    $affectedRows += $this->aUserPayment->save($con);
                }
                $this->setUserPayment($this->aUserPayment);
            }

            if ($this->aParish !== null) {
                if ($this->aParish->isModified() || $this->aParish->isNew()) {
                    $affectedRows += $this->aParish->save($con);
                }
                $this->setParish($this->aParish);
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

        $this->modifiedColumns[UserSubscriptionTableMap::COL_VALUE] = true;
        if (null !== $this->value) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserSubscriptionTableMap::COL_VALUE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PLAN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'plan_id';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PARISH_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parish_id';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PAY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'pay_id';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_CUSTOMER_REF)) {
            $modifiedColumns[':p' . $index++]  = 'customer_ref';
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_MILEAGE)) {
            $modifiedColumns[':p' . $index++]  = 'mileage';
        }

        $sql = sprintf(
            'INSERT INTO user_subscription (%s) VALUES (%s)',
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
                    case 'plan_id':                        
                        $stmt->bindValue($identifier, $this->plan_id, PDO::PARAM_INT);
                        break;
                    case 'user_id':                        
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'parish_id':                        
                        $stmt->bindValue($identifier, $this->parish_id, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, (int) $this->status, PDO::PARAM_INT);
                        break;
                    case 'start_date':                        
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':                        
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'pay_id':                        
                        $stmt->bindValue($identifier, $this->pay_id, PDO::PARAM_INT);
                        break;
                    case 'customer_ref':                        
                        $stmt->bindValue($identifier, $this->customer_ref, PDO::PARAM_STR);
                        break;
                    case 'mileage':                        
                        $stmt->bindValue($identifier, $this->mileage, PDO::PARAM_STR);
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
        $pos = UserSubscriptionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPlanId();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getParishId();
                break;
            case 4:
                return $this->getStatus();
                break;
            case 5:
                return $this->getStartDate();
                break;
            case 6:
                return $this->getEndDate();
                break;
            case 7:
                return $this->getPayId();
                break;
            case 8:
                return $this->getCustomerRef();
                break;
            case 9:
                return $this->getMileage();
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

        if (isset($alreadyDumpedObjects['UserSubscription'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UserSubscription'][$this->hashCode()] = true;
        $keys = UserSubscriptionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getValue(),
            $keys[1] => $this->getPlanId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getParishId(),
            $keys[4] => $this->getStatus(),
            $keys[5] => $this->getStartDate(),
            $keys[6] => $this->getEndDate(),
            $keys[7] => $this->getPayId(),
            $keys[8] => $this->getCustomerRef(),
            $keys[9] => $this->getMileage(),
        );
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }
        
        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aUserLogin) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userLogin';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_login';
                        break;
                    default:
                        $key = 'UserLogin';
                }
        
                $result[$key] = $this->aUserLogin->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserPlan) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userPlan';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_plan';
                        break;
                    default:
                        $key = 'UserPlan';
                }
        
                $result[$key] = $this->aUserPlan->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserPayment) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userPayment';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_payment';
                        break;
                    default:
                        $key = 'UserPayment';
                }
        
                $result[$key] = $this->aUserPayment->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
     * @return $this|\UserSubscription
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserSubscriptionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\UserSubscription
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setValue($value);
                break;
            case 1:
                $this->setPlanId($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setParishId($value);
                break;
            case 4:
                $this->setStatus($value);
                break;
            case 5:
                $this->setStartDate($value);
                break;
            case 6:
                $this->setEndDate($value);
                break;
            case 7:
                $this->setPayId($value);
                break;
            case 8:
                $this->setCustomerRef($value);
                break;
            case 9:
                $this->setMileage($value);
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
        $keys = UserSubscriptionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setValue($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPlanId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setParishId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStatus($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStartDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEndDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPayId($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCustomerRef($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMileage($arr[$keys[9]]);
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
     * @return $this|\UserSubscription The current object, for fluid interface
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
        $criteria = new Criteria(UserSubscriptionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserSubscriptionTableMap::COL_VALUE)) {
            $criteria->add(UserSubscriptionTableMap::COL_VALUE, $this->value);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PLAN_ID)) {
            $criteria->add(UserSubscriptionTableMap::COL_PLAN_ID, $this->plan_id);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_USER_ID)) {
            $criteria->add(UserSubscriptionTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PARISH_ID)) {
            $criteria->add(UserSubscriptionTableMap::COL_PARISH_ID, $this->parish_id);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_STATUS)) {
            $criteria->add(UserSubscriptionTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_START_DATE)) {
            $criteria->add(UserSubscriptionTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_END_DATE)) {
            $criteria->add(UserSubscriptionTableMap::COL_END_DATE, $this->end_date);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_PAY_ID)) {
            $criteria->add(UserSubscriptionTableMap::COL_PAY_ID, $this->pay_id);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_CUSTOMER_REF)) {
            $criteria->add(UserSubscriptionTableMap::COL_CUSTOMER_REF, $this->customer_ref);
        }
        if ($this->isColumnModified(UserSubscriptionTableMap::COL_MILEAGE)) {
            $criteria->add(UserSubscriptionTableMap::COL_MILEAGE, $this->mileage);
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
        $criteria = ChildUserSubscriptionQuery::create();
        $criteria->add(UserSubscriptionTableMap::COL_VALUE, $this->value);

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
     * @param      object $copyObj An object of \UserSubscription (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPlanId($this->getPlanId());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setParishId($this->getParishId());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());
        $copyObj->setPayId($this->getPayId());
        $copyObj->setCustomerRef($this->getCustomerRef());
        $copyObj->setMileage($this->getMileage());
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
     * @return \UserSubscription Clone of current object.
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
     * Declares an association between this object and a ChildUserLogin object.
     *
     * @param  ChildUserLogin $v
     * @return $this|\UserSubscription The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserLogin(ChildUserLogin $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getValue());
        }

        $this->aUserLogin = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUserLogin object, it will not be re-added.
        if ($v !== null) {
            $v->addUserSubscription($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUserLogin object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUserLogin The associated ChildUserLogin object.
     * @throws PropelException
     */
    public function getUserLogin(ConnectionInterface $con = null)
    {
        if ($this->aUserLogin === null && ($this->user_id !== null)) {
            $this->aUserLogin = ChildUserLoginQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserLogin->addUserSubscriptions($this);
             */
        }

        return $this->aUserLogin;
    }

    /**
     * Declares an association between this object and a ChildUserPlan object.
     *
     * @param  ChildUserPlan $v
     * @return $this|\UserSubscription The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserPlan(ChildUserPlan $v = null)
    {
        if ($v === null) {
            $this->setPlanId(NULL);
        } else {
            $this->setPlanId($v->getValue());
        }

        $this->aUserPlan = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUserPlan object, it will not be re-added.
        if ($v !== null) {
            $v->addUserSubscription($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUserPlan object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUserPlan The associated ChildUserPlan object.
     * @throws PropelException
     */
    public function getUserPlan(ConnectionInterface $con = null)
    {
        if ($this->aUserPlan === null && ($this->plan_id !== null)) {
            $this->aUserPlan = ChildUserPlanQuery::create()->findPk($this->plan_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserPlan->addUserSubscriptions($this);
             */
        }

        return $this->aUserPlan;
    }

    /**
     * Declares an association between this object and a ChildUserPayment object.
     *
     * @param  ChildUserPayment $v
     * @return $this|\UserSubscription The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserPayment(ChildUserPayment $v = null)
    {
        if ($v === null) {
            $this->setPayId(NULL);
        } else {
            $this->setPayId($v->getValue());
        }

        $this->aUserPayment = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUserPayment object, it will not be re-added.
        if ($v !== null) {
            $v->addUserSubscription($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUserPayment object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUserPayment The associated ChildUserPayment object.
     * @throws PropelException
     */
    public function getUserPayment(ConnectionInterface $con = null)
    {
        if ($this->aUserPayment === null && ($this->pay_id !== null)) {
            $this->aUserPayment = ChildUserPaymentQuery::create()->findPk($this->pay_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserPayment->addUserSubscriptions($this);
             */
        }

        return $this->aUserPayment;
    }

    /**
     * Declares an association between this object and a ChildParish object.
     *
     * @param  ChildParish $v
     * @return $this|\UserSubscription The current object (for fluent API support)
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
            $v->addUserSubscription($this);
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
                $this->aParish->addUserSubscriptions($this);
             */
        }

        return $this->aParish;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUserLogin) {
            $this->aUserLogin->removeUserSubscription($this);
        }
        if (null !== $this->aUserPlan) {
            $this->aUserPlan->removeUserSubscription($this);
        }
        if (null !== $this->aUserPayment) {
            $this->aUserPayment->removeUserSubscription($this);
        }
        if (null !== $this->aParish) {
            $this->aParish->removeUserSubscription($this);
        }
        $this->value = null;
        $this->plan_id = null;
        $this->user_id = null;
        $this->parish_id = null;
        $this->status = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->pay_id = null;
        $this->customer_ref = null;
        $this->mileage = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
        } // if ($deep)

        $this->aUserLogin = null;
        $this->aUserPlan = null;
        $this->aUserPayment = null;
        $this->aParish = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserSubscriptionTableMap::DEFAULT_STRING_FORMAT);
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
