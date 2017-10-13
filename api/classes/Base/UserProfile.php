<?php

namespace Base;

use \Give as ChildGive;
use \GiveQuery as ChildGiveQuery;
use \Parish as ChildParish;
use \ParishQuery as ChildParishQuery;
use \Pastor as ChildPastor;
use \PastorQuery as ChildPastorQuery;
use \Prayer as ChildPrayer;
use \PrayerQuery as ChildPrayerQuery;
use \PushRegister as ChildPushRegister;
use \PushRegisterQuery as ChildPushRegisterQuery;
use \Testimonials as ChildTestimonials;
use \TestimonialsQuery as ChildTestimonialsQuery;
use \UserProfile as ChildUserProfile;
use \UserProfileQuery as ChildUserProfileQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\GiveTableMap;
use Map\PastorTableMap;
use Map\PrayerTableMap;
use Map\PushRegisterTableMap;
use Map\TestimonialsTableMap;
use Map\UserProfileTableMap;
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
 * Base class that represents a row from the 'user_profile' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class UserProfile implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserProfileTableMap';


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
     * The value for the parish_id field.
     * 
     * @var        int
     */
    protected $parish_id;

    /**
     * The value for the fname field.
     * 
     * @var        string
     */
    protected $fname;

    /**
     * The value for the lname field.
     * 
     * @var        string
     */
    protected $lname;

    /**
     * The value for the address field.
     * 
     * @var        string
     */
    protected $address;

    /**
     * The value for the city field.
     * 
     * @var        string
     */
    protected $city;

    /**
     * The value for the state field.
     * 
     * @var        string
     */
    protected $state;

    /**
     * The value for the zip field.
     * 
     * @var        string
     */
    protected $zip;

    /**
     * The value for the country field.
     * 
     * Note: this column has a database default value of: 'USA'
     * @var        string
     */
    protected $country;

    /**
     * The value for the phone field.
     * 
     * @var        string
     */
    protected $phone;

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * The value for the dob field.
     * 
     * @var        string
     */
    protected $dob;

    /**
     * The value for the married field.
     * 
     * @var        boolean
     */
    protected $married;

    /**
     * The value for the wedding field.
     * 
     * @var        string
     */
    protected $wedding;

    /**
     * The value for the push_id field.
     * 
     * @var        string
     */
    protected $push_id;

    /**
     * The value for the platform field.
     * 
     * @var        string
     */
    protected $platform;

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
     * @var        ObjectCollection|ChildGive[] Collection to store aggregation of ChildGive objects.
     */
    protected $collGives;
    protected $collGivesPartial;

    /**
     * @var        ObjectCollection|ChildPastor[] Collection to store aggregation of ChildPastor objects.
     */
    protected $collPastors;
    protected $collPastorsPartial;

    /**
     * @var        ObjectCollection|ChildPrayer[] Collection to store aggregation of ChildPrayer objects.
     */
    protected $collPrayers;
    protected $collPrayersPartial;

    /**
     * @var        ObjectCollection|ChildPushRegister[] Collection to store aggregation of ChildPushRegister objects.
     */
    protected $collPushRegisters;
    protected $collPushRegistersPartial;

    /**
     * @var        ObjectCollection|ChildTestimonials[] Collection to store aggregation of ChildTestimonials objects.
     */
    protected $collTestimonialss;
    protected $collTestimonialssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGive[]
     */
    protected $givesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPastor[]
     */
    protected $pastorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPrayer[]
     */
    protected $prayersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPushRegister[]
     */
    protected $pushRegistersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTestimonials[]
     */
    protected $testimonialssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->country = 'USA';
    }

    /**
     * Initializes internal state of Base\UserProfile object.
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
     * Compares this with another <code>UserProfile</code> instance.  If
     * <code>obj</code> is an instance of <code>UserProfile</code>, delegates to
     * <code>equals(UserProfile)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UserProfile The current object, for fluid interface
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
     * Get the [parish_id] column value.
     * 
     * @return int
     */
    public function getParishId()
    {
        return $this->parish_id;
    }

    /**
     * Get the [fname] column value.
     * 
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Get the [lname] column value.
     * 
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Get the [address] column value.
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [city] column value.
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the [state] column value.
     * 
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the [zip] column value.
     * 
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Get the [country] column value.
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the [phone] column value.
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [dob] column value.
     * 
     * @return string
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Get the [married] column value.
     * 
     * @return boolean
     */
    public function getMarried()
    {
        return $this->married;
    }

    /**
     * Get the [married] column value.
     * 
     * @return boolean
     */
    public function isMarried()
    {
        return $this->getMarried();
    }

    /**
     * Get the [wedding] column value.
     * 
     * @return string
     */
    public function getWedding()
    {
        return $this->wedding;
    }

    /**
     * Get the [push_id] column value.
     * 
     * @return string
     */
    public function getPushId()
    {
        return $this->push_id;
    }

    /**
     * Get the [platform] column value.
     * 
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
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
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

    /**
     * Set the value of [parish_id] column.
     * 
     * @param int $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setParishId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parish_id !== $v) {
            $this->parish_id = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_PARISH_ID] = true;
        }

        if ($this->aParish !== null && $this->aParish->getValue() !== $v) {
            $this->aParish = null;
        }

        return $this;
    } // setParishId()

    /**
     * Set the value of [fname] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setFname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fname !== $v) {
            $this->fname = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_FNAME] = true;
        }

        return $this;
    } // setFname()

    /**
     * Set the value of [lname] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setLname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lname !== $v) {
            $this->lname = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_LNAME] = true;
        }

        return $this;
    } // setLname()

    /**
     * Set the value of [address] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [city] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_CITY] = true;
        }

        return $this;
    } // setCity()

    /**
     * Set the value of [state] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_STATE] = true;
        }

        return $this;
    } // setState()

    /**
     * Set the value of [zip] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->zip !== $v) {
            $this->zip = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_ZIP] = true;
        }

        return $this;
    } // setZip()

    /**
     * Set the value of [country] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->country !== $v) {
            $this->country = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_COUNTRY] = true;
        }

        return $this;
    } // setCountry()

    /**
     * Set the value of [phone] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [dob] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setDob($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dob !== $v) {
            $this->dob = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_DOB] = true;
        }

        return $this;
    } // setDob()

    /**
     * Sets the value of the [married] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setMarried($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->married !== $v) {
            $this->married = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_MARRIED] = true;
        }

        return $this;
    } // setMarried()

    /**
     * Set the value of [wedding] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setWedding($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wedding !== $v) {
            $this->wedding = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_WEDDING] = true;
        }

        return $this;
    } // setWedding()

    /**
     * Set the value of [push_id] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setPushId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->push_id !== $v) {
            $this->push_id = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_PUSH_ID] = true;
        }

        return $this;
    } // setPushId()

    /**
     * Set the value of [platform] column.
     * 
     * @param string $v new value
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setPlatform($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform !== $v) {
            $this->platform = $v;
            $this->modifiedColumns[UserProfileTableMap::COL_PLATFORM] = true;
        }

        return $this;
    } // setPlatform()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserProfileTableMap::COL_CREATED_AT] = true;
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
            if ($this->country !== 'USA') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserProfileTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserProfileTableMap::translateFieldName('ParishId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parish_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserProfileTableMap::translateFieldName('Fname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserProfileTableMap::translateFieldName('Lname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserProfileTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserProfileTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserProfileTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserProfileTableMap::translateFieldName('Zip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserProfileTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType)];
            $this->country = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserProfileTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UserProfileTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UserProfileTableMap::translateFieldName('Dob', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dob = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UserProfileTableMap::translateFieldName('Married', TableMap::TYPE_PHPNAME, $indexType)];
            $this->married = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : UserProfileTableMap::translateFieldName('Wedding', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wedding = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : UserProfileTableMap::translateFieldName('PushId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->push_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : UserProfileTableMap::translateFieldName('Platform', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : UserProfileTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = UserProfileTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\UserProfile'), 0, $e);
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
        if ($this->aParish !== null && $this->parish_id !== $this->aParish->getValue()) {
            $this->aParish = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(UserProfileTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserProfileQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aParish = null;
            $this->collGives = null;

            $this->collPastors = null;

            $this->collPrayers = null;

            $this->collPushRegisters = null;

            $this->collTestimonialss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UserProfile::setDeleted()
     * @see UserProfile::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserProfileQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserProfileTableMap::DATABASE_NAME);
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
                UserProfileTableMap::addInstanceToPool($this);
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

            if ($this->givesScheduledForDeletion !== null) {
                if (!$this->givesScheduledForDeletion->isEmpty()) {
                    \GiveQuery::create()
                        ->filterByPrimaryKeys($this->givesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->givesScheduledForDeletion = null;
                }
            }

            if ($this->collGives !== null) {
                foreach ($this->collGives as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pastorsScheduledForDeletion !== null) {
                if (!$this->pastorsScheduledForDeletion->isEmpty()) {
                    \PastorQuery::create()
                        ->filterByPrimaryKeys($this->pastorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pastorsScheduledForDeletion = null;
                }
            }

            if ($this->collPastors !== null) {
                foreach ($this->collPastors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->prayersScheduledForDeletion !== null) {
                if (!$this->prayersScheduledForDeletion->isEmpty()) {
                    \PrayerQuery::create()
                        ->filterByPrimaryKeys($this->prayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->prayersScheduledForDeletion = null;
                }
            }

            if ($this->collPrayers !== null) {
                foreach ($this->collPrayers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pushRegistersScheduledForDeletion !== null) {
                if (!$this->pushRegistersScheduledForDeletion->isEmpty()) {
                    foreach ($this->pushRegistersScheduledForDeletion as $pushRegister) {
                        // need to save related object because we set the relation to null
                        $pushRegister->save($con);
                    }
                    $this->pushRegistersScheduledForDeletion = null;
                }
            }

            if ($this->collPushRegisters !== null) {
                foreach ($this->collPushRegisters as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->testimonialssScheduledForDeletion !== null) {
                if (!$this->testimonialssScheduledForDeletion->isEmpty()) {
                    \TestimonialsQuery::create()
                        ->filterByPrimaryKeys($this->testimonialssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->testimonialssScheduledForDeletion = null;
                }
            }

            if ($this->collTestimonialss !== null) {
                foreach ($this->collTestimonialss as $referrerFK) {
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

        $this->modifiedColumns[UserProfileTableMap::COL_VALUE] = true;
        if (null !== $this->value) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserProfileTableMap::COL_VALUE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserProfileTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PARISH_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parish_id';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_FNAME)) {
            $modifiedColumns[':p' . $index++]  = 'fname';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_LNAME)) {
            $modifiedColumns[':p' . $index++]  = 'lname';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'city';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'zip';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'country';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'phone';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_DOB)) {
            $modifiedColumns[':p' . $index++]  = 'dob';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_MARRIED)) {
            $modifiedColumns[':p' . $index++]  = 'married';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_WEDDING)) {
            $modifiedColumns[':p' . $index++]  = 'wedding';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PUSH_ID)) {
            $modifiedColumns[':p' . $index++]  = 'push_id';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PLATFORM)) {
            $modifiedColumns[':p' . $index++]  = 'platform';
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }

        $sql = sprintf(
            'INSERT INTO user_profile (%s) VALUES (%s)',
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
                    case 'parish_id':                        
                        $stmt->bindValue($identifier, $this->parish_id, PDO::PARAM_INT);
                        break;
                    case 'fname':                        
                        $stmt->bindValue($identifier, $this->fname, PDO::PARAM_STR);
                        break;
                    case 'lname':                        
                        $stmt->bindValue($identifier, $this->lname, PDO::PARAM_STR);
                        break;
                    case 'address':                        
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'city':                        
                        $stmt->bindValue($identifier, $this->city, PDO::PARAM_STR);
                        break;
                    case 'state':                        
                        $stmt->bindValue($identifier, $this->state, PDO::PARAM_STR);
                        break;
                    case 'zip':                        
                        $stmt->bindValue($identifier, $this->zip, PDO::PARAM_STR);
                        break;
                    case 'country':                        
                        $stmt->bindValue($identifier, $this->country, PDO::PARAM_STR);
                        break;
                    case 'phone':                        
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'dob':                        
                        $stmt->bindValue($identifier, $this->dob, PDO::PARAM_STR);
                        break;
                    case 'married':
                        $stmt->bindValue($identifier, (int) $this->married, PDO::PARAM_INT);
                        break;
                    case 'wedding':                        
                        $stmt->bindValue($identifier, $this->wedding, PDO::PARAM_STR);
                        break;
                    case 'push_id':                        
                        $stmt->bindValue($identifier, $this->push_id, PDO::PARAM_STR);
                        break;
                    case 'platform':                        
                        $stmt->bindValue($identifier, $this->platform, PDO::PARAM_STR);
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
        $pos = UserProfileTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getParishId();
                break;
            case 2:
                return $this->getFname();
                break;
            case 3:
                return $this->getLname();
                break;
            case 4:
                return $this->getAddress();
                break;
            case 5:
                return $this->getCity();
                break;
            case 6:
                return $this->getState();
                break;
            case 7:
                return $this->getZip();
                break;
            case 8:
                return $this->getCountry();
                break;
            case 9:
                return $this->getPhone();
                break;
            case 10:
                return $this->getEmail();
                break;
            case 11:
                return $this->getDob();
                break;
            case 12:
                return $this->getMarried();
                break;
            case 13:
                return $this->getWedding();
                break;
            case 14:
                return $this->getPushId();
                break;
            case 15:
                return $this->getPlatform();
                break;
            case 16:
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

        if (isset($alreadyDumpedObjects['UserProfile'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UserProfile'][$this->hashCode()] = true;
        $keys = UserProfileTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getValue(),
            $keys[1] => $this->getParishId(),
            $keys[2] => $this->getFname(),
            $keys[3] => $this->getLname(),
            $keys[4] => $this->getAddress(),
            $keys[5] => $this->getCity(),
            $keys[6] => $this->getState(),
            $keys[7] => $this->getZip(),
            $keys[8] => $this->getCountry(),
            $keys[9] => $this->getPhone(),
            $keys[10] => $this->getEmail(),
            $keys[11] => $this->getDob(),
            $keys[12] => $this->getMarried(),
            $keys[13] => $this->getWedding(),
            $keys[14] => $this->getPushId(),
            $keys[15] => $this->getPlatform(),
            $keys[16] => $this->getCreatedAt(),
        );
        if ($result[$keys[16]] instanceof \DateTime) {
            $result[$keys[16]] = $result[$keys[16]]->format('c');
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
            if (null !== $this->collGives) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gives';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gives';
                        break;
                    default:
                        $key = 'Gives';
                }
        
                $result[$key] = $this->collGives->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPastors) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pastors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pastors';
                        break;
                    default:
                        $key = 'Pastors';
                }
        
                $result[$key] = $this->collPastors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPrayers) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'prayers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'prayers';
                        break;
                    default:
                        $key = 'Prayers';
                }
        
                $result[$key] = $this->collPrayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPushRegisters) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pushRegisters';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'push_registers';
                        break;
                    default:
                        $key = 'PushRegisters';
                }
        
                $result[$key] = $this->collPushRegisters->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTestimonialss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'testimonialss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'testimonialss';
                        break;
                    default:
                        $key = 'Testimonialss';
                }
        
                $result[$key] = $this->collTestimonialss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\UserProfile
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserProfileTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\UserProfile
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setValue($value);
                break;
            case 1:
                $this->setParishId($value);
                break;
            case 2:
                $this->setFname($value);
                break;
            case 3:
                $this->setLname($value);
                break;
            case 4:
                $this->setAddress($value);
                break;
            case 5:
                $this->setCity($value);
                break;
            case 6:
                $this->setState($value);
                break;
            case 7:
                $this->setZip($value);
                break;
            case 8:
                $this->setCountry($value);
                break;
            case 9:
                $this->setPhone($value);
                break;
            case 10:
                $this->setEmail($value);
                break;
            case 11:
                $this->setDob($value);
                break;
            case 12:
                $this->setMarried($value);
                break;
            case 13:
                $this->setWedding($value);
                break;
            case 14:
                $this->setPushId($value);
                break;
            case 15:
                $this->setPlatform($value);
                break;
            case 16:
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
        $keys = UserProfileTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setValue($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setParishId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLname($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAddress($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCity($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setState($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setZip($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCountry($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPhone($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setEmail($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setDob($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setMarried($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setWedding($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setPushId($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setPlatform($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setCreatedAt($arr[$keys[16]]);
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
     * @return $this|\UserProfile The current object, for fluid interface
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
        $criteria = new Criteria(UserProfileTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserProfileTableMap::COL_VALUE)) {
            $criteria->add(UserProfileTableMap::COL_VALUE, $this->value);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PARISH_ID)) {
            $criteria->add(UserProfileTableMap::COL_PARISH_ID, $this->parish_id);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_FNAME)) {
            $criteria->add(UserProfileTableMap::COL_FNAME, $this->fname);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_LNAME)) {
            $criteria->add(UserProfileTableMap::COL_LNAME, $this->lname);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_ADDRESS)) {
            $criteria->add(UserProfileTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_CITY)) {
            $criteria->add(UserProfileTableMap::COL_CITY, $this->city);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_STATE)) {
            $criteria->add(UserProfileTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_ZIP)) {
            $criteria->add(UserProfileTableMap::COL_ZIP, $this->zip);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_COUNTRY)) {
            $criteria->add(UserProfileTableMap::COL_COUNTRY, $this->country);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PHONE)) {
            $criteria->add(UserProfileTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_EMAIL)) {
            $criteria->add(UserProfileTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_DOB)) {
            $criteria->add(UserProfileTableMap::COL_DOB, $this->dob);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_MARRIED)) {
            $criteria->add(UserProfileTableMap::COL_MARRIED, $this->married);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_WEDDING)) {
            $criteria->add(UserProfileTableMap::COL_WEDDING, $this->wedding);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PUSH_ID)) {
            $criteria->add(UserProfileTableMap::COL_PUSH_ID, $this->push_id);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_PLATFORM)) {
            $criteria->add(UserProfileTableMap::COL_PLATFORM, $this->platform);
        }
        if ($this->isColumnModified(UserProfileTableMap::COL_CREATED_AT)) {
            $criteria->add(UserProfileTableMap::COL_CREATED_AT, $this->created_at);
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
        $criteria = ChildUserProfileQuery::create();
        $criteria->add(UserProfileTableMap::COL_VALUE, $this->value);

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
     * @param      object $copyObj An object of \UserProfile (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParishId($this->getParishId());
        $copyObj->setFname($this->getFname());
        $copyObj->setLname($this->getLname());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setCity($this->getCity());
        $copyObj->setState($this->getState());
        $copyObj->setZip($this->getZip());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setDob($this->getDob());
        $copyObj->setMarried($this->getMarried());
        $copyObj->setWedding($this->getWedding());
        $copyObj->setPushId($this->getPushId());
        $copyObj->setPlatform($this->getPlatform());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGives() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGive($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPastors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPastor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPrayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPrayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPushRegisters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPushRegister($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTestimonialss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTestimonials($relObj->copy($deepCopy));
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
     * @return \UserProfile Clone of current object.
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
     * @return $this|\UserProfile The current object (for fluent API support)
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
            $v->addUserProfile($this);
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
                $this->aParish->addUserProfiles($this);
             */
        }

        return $this->aParish;
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
        if ('Give' == $relationName) {
            return $this->initGives();
        }
        if ('Pastor' == $relationName) {
            return $this->initPastors();
        }
        if ('Prayer' == $relationName) {
            return $this->initPrayers();
        }
        if ('PushRegister' == $relationName) {
            return $this->initPushRegisters();
        }
        if ('Testimonials' == $relationName) {
            return $this->initTestimonialss();
        }
    }

    /**
     * Clears out the collGives collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGives()
     */
    public function clearGives()
    {
        $this->collGives = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGives collection loaded partially.
     */
    public function resetPartialGives($v = true)
    {
        $this->collGivesPartial = $v;
    }

    /**
     * Initializes the collGives collection.
     *
     * By default this just sets the collGives collection to an empty array (like clearcollGives());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGives($overrideExisting = true)
    {
        if (null !== $this->collGives && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiveTableMap::getTableMap()->getCollectionClassName();

        $this->collGives = new $collectionClassName;
        $this->collGives->setModel('\Give');
    }

    /**
     * Gets an array of ChildGive objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserProfile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGive[] List of ChildGive objects
     * @throws PropelException
     */
    public function getGives(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGivesPartial && !$this->isNew();
        if (null === $this->collGives || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGives) {
                // return empty collection
                $this->initGives();
            } else {
                $collGives = ChildGiveQuery::create(null, $criteria)
                    ->filterByUserProfile($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGivesPartial && count($collGives)) {
                        $this->initGives(false);

                        foreach ($collGives as $obj) {
                            if (false == $this->collGives->contains($obj)) {
                                $this->collGives->append($obj);
                            }
                        }

                        $this->collGivesPartial = true;
                    }

                    return $collGives;
                }

                if ($partial && $this->collGives) {
                    foreach ($this->collGives as $obj) {
                        if ($obj->isNew()) {
                            $collGives[] = $obj;
                        }
                    }
                }

                $this->collGives = $collGives;
                $this->collGivesPartial = false;
            }
        }

        return $this->collGives;
    }

    /**
     * Sets a collection of ChildGive objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gives A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function setGives(Collection $gives, ConnectionInterface $con = null)
    {
        /** @var ChildGive[] $givesToDelete */
        $givesToDelete = $this->getGives(new Criteria(), $con)->diff($gives);

        
        $this->givesScheduledForDeletion = $givesToDelete;

        foreach ($givesToDelete as $giveRemoved) {
            $giveRemoved->setUserProfile(null);
        }

        $this->collGives = null;
        foreach ($gives as $give) {
            $this->addGive($give);
        }

        $this->collGives = $gives;
        $this->collGivesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Give objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Give objects.
     * @throws PropelException
     */
    public function countGives(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGivesPartial && !$this->isNew();
        if (null === $this->collGives || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGives) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGives());
            }

            $query = ChildGiveQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserProfile($this)
                ->count($con);
        }

        return count($this->collGives);
    }

    /**
     * Method called to associate a ChildGive object to this object
     * through the ChildGive foreign key attribute.
     *
     * @param  ChildGive $l ChildGive
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function addGive(ChildGive $l)
    {
        if ($this->collGives === null) {
            $this->initGives();
            $this->collGivesPartial = true;
        }

        if (!$this->collGives->contains($l)) {
            $this->doAddGive($l);

            if ($this->givesScheduledForDeletion and $this->givesScheduledForDeletion->contains($l)) {
                $this->givesScheduledForDeletion->remove($this->givesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGive $give The ChildGive object to add.
     */
    protected function doAddGive(ChildGive $give)
    {
        $this->collGives[]= $give;
        $give->setUserProfile($this);
    }

    /**
     * @param  ChildGive $give The ChildGive object to remove.
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function removeGive(ChildGive $give)
    {
        if ($this->getGives()->contains($give)) {
            $pos = $this->collGives->search($give);
            $this->collGives->remove($pos);
            if (null === $this->givesScheduledForDeletion) {
                $this->givesScheduledForDeletion = clone $this->collGives;
                $this->givesScheduledForDeletion->clear();
            }
            $this->givesScheduledForDeletion[]= clone $give;
            $give->setUserProfile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserProfile is new, it will return
     * an empty collection; or if this UserProfile has previously
     * been saved, it will retrieve related Gives from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserProfile.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGive[] List of ChildGive objects
     */
    public function getGivesJoinParish(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGiveQuery::create(null, $criteria);
        $query->joinWith('Parish', $joinBehavior);

        return $this->getGives($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserProfile is new, it will return
     * an empty collection; or if this UserProfile has previously
     * been saved, it will retrieve related Gives from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserProfile.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGive[] List of ChildGive objects
     */
    public function getGivesJoinGiveParishMethods(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGiveQuery::create(null, $criteria);
        $query->joinWith('GiveParishMethods', $joinBehavior);

        return $this->getGives($query, $con);
    }

    /**
     * Clears out the collPastors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPastors()
     */
    public function clearPastors()
    {
        $this->collPastors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPastors collection loaded partially.
     */
    public function resetPartialPastors($v = true)
    {
        $this->collPastorsPartial = $v;
    }

    /**
     * Initializes the collPastors collection.
     *
     * By default this just sets the collPastors collection to an empty array (like clearcollPastors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPastors($overrideExisting = true)
    {
        if (null !== $this->collPastors && !$overrideExisting) {
            return;
        }

        $collectionClassName = PastorTableMap::getTableMap()->getCollectionClassName();

        $this->collPastors = new $collectionClassName;
        $this->collPastors->setModel('\Pastor');
    }

    /**
     * Gets an array of ChildPastor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserProfile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPastor[] List of ChildPastor objects
     * @throws PropelException
     */
    public function getPastors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPastorsPartial && !$this->isNew();
        if (null === $this->collPastors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPastors) {
                // return empty collection
                $this->initPastors();
            } else {
                $collPastors = ChildPastorQuery::create(null, $criteria)
                    ->filterByUserProfile($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPastorsPartial && count($collPastors)) {
                        $this->initPastors(false);

                        foreach ($collPastors as $obj) {
                            if (false == $this->collPastors->contains($obj)) {
                                $this->collPastors->append($obj);
                            }
                        }

                        $this->collPastorsPartial = true;
                    }

                    return $collPastors;
                }

                if ($partial && $this->collPastors) {
                    foreach ($this->collPastors as $obj) {
                        if ($obj->isNew()) {
                            $collPastors[] = $obj;
                        }
                    }
                }

                $this->collPastors = $collPastors;
                $this->collPastorsPartial = false;
            }
        }

        return $this->collPastors;
    }

    /**
     * Sets a collection of ChildPastor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pastors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function setPastors(Collection $pastors, ConnectionInterface $con = null)
    {
        /** @var ChildPastor[] $pastorsToDelete */
        $pastorsToDelete = $this->getPastors(new Criteria(), $con)->diff($pastors);

        
        $this->pastorsScheduledForDeletion = $pastorsToDelete;

        foreach ($pastorsToDelete as $pastorRemoved) {
            $pastorRemoved->setUserProfile(null);
        }

        $this->collPastors = null;
        foreach ($pastors as $pastor) {
            $this->addPastor($pastor);
        }

        $this->collPastors = $pastors;
        $this->collPastorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pastor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pastor objects.
     * @throws PropelException
     */
    public function countPastors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPastorsPartial && !$this->isNew();
        if (null === $this->collPastors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPastors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPastors());
            }

            $query = ChildPastorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserProfile($this)
                ->count($con);
        }

        return count($this->collPastors);
    }

    /**
     * Method called to associate a ChildPastor object to this object
     * through the ChildPastor foreign key attribute.
     *
     * @param  ChildPastor $l ChildPastor
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function addPastor(ChildPastor $l)
    {
        if ($this->collPastors === null) {
            $this->initPastors();
            $this->collPastorsPartial = true;
        }

        if (!$this->collPastors->contains($l)) {
            $this->doAddPastor($l);

            if ($this->pastorsScheduledForDeletion and $this->pastorsScheduledForDeletion->contains($l)) {
                $this->pastorsScheduledForDeletion->remove($this->pastorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPastor $pastor The ChildPastor object to add.
     */
    protected function doAddPastor(ChildPastor $pastor)
    {
        $this->collPastors[]= $pastor;
        $pastor->setUserProfile($this);
    }

    /**
     * @param  ChildPastor $pastor The ChildPastor object to remove.
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function removePastor(ChildPastor $pastor)
    {
        if ($this->getPastors()->contains($pastor)) {
            $pos = $this->collPastors->search($pastor);
            $this->collPastors->remove($pos);
            if (null === $this->pastorsScheduledForDeletion) {
                $this->pastorsScheduledForDeletion = clone $this->collPastors;
                $this->pastorsScheduledForDeletion->clear();
            }
            $this->pastorsScheduledForDeletion[]= clone $pastor;
            $pastor->setUserProfile(null);
        }

        return $this;
    }

    /**
     * Clears out the collPrayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPrayers()
     */
    public function clearPrayers()
    {
        $this->collPrayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPrayers collection loaded partially.
     */
    public function resetPartialPrayers($v = true)
    {
        $this->collPrayersPartial = $v;
    }

    /**
     * Initializes the collPrayers collection.
     *
     * By default this just sets the collPrayers collection to an empty array (like clearcollPrayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPrayers($overrideExisting = true)
    {
        if (null !== $this->collPrayers && !$overrideExisting) {
            return;
        }

        $collectionClassName = PrayerTableMap::getTableMap()->getCollectionClassName();

        $this->collPrayers = new $collectionClassName;
        $this->collPrayers->setModel('\Prayer');
    }

    /**
     * Gets an array of ChildPrayer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserProfile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPrayer[] List of ChildPrayer objects
     * @throws PropelException
     */
    public function getPrayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPrayersPartial && !$this->isNew();
        if (null === $this->collPrayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPrayers) {
                // return empty collection
                $this->initPrayers();
            } else {
                $collPrayers = ChildPrayerQuery::create(null, $criteria)
                    ->filterByUserProfile($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPrayersPartial && count($collPrayers)) {
                        $this->initPrayers(false);

                        foreach ($collPrayers as $obj) {
                            if (false == $this->collPrayers->contains($obj)) {
                                $this->collPrayers->append($obj);
                            }
                        }

                        $this->collPrayersPartial = true;
                    }

                    return $collPrayers;
                }

                if ($partial && $this->collPrayers) {
                    foreach ($this->collPrayers as $obj) {
                        if ($obj->isNew()) {
                            $collPrayers[] = $obj;
                        }
                    }
                }

                $this->collPrayers = $collPrayers;
                $this->collPrayersPartial = false;
            }
        }

        return $this->collPrayers;
    }

    /**
     * Sets a collection of ChildPrayer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $prayers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function setPrayers(Collection $prayers, ConnectionInterface $con = null)
    {
        /** @var ChildPrayer[] $prayersToDelete */
        $prayersToDelete = $this->getPrayers(new Criteria(), $con)->diff($prayers);

        
        $this->prayersScheduledForDeletion = $prayersToDelete;

        foreach ($prayersToDelete as $prayerRemoved) {
            $prayerRemoved->setUserProfile(null);
        }

        $this->collPrayers = null;
        foreach ($prayers as $prayer) {
            $this->addPrayer($prayer);
        }

        $this->collPrayers = $prayers;
        $this->collPrayersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Prayer objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Prayer objects.
     * @throws PropelException
     */
    public function countPrayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPrayersPartial && !$this->isNew();
        if (null === $this->collPrayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPrayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPrayers());
            }

            $query = ChildPrayerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserProfile($this)
                ->count($con);
        }

        return count($this->collPrayers);
    }

    /**
     * Method called to associate a ChildPrayer object to this object
     * through the ChildPrayer foreign key attribute.
     *
     * @param  ChildPrayer $l ChildPrayer
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function addPrayer(ChildPrayer $l)
    {
        if ($this->collPrayers === null) {
            $this->initPrayers();
            $this->collPrayersPartial = true;
        }

        if (!$this->collPrayers->contains($l)) {
            $this->doAddPrayer($l);

            if ($this->prayersScheduledForDeletion and $this->prayersScheduledForDeletion->contains($l)) {
                $this->prayersScheduledForDeletion->remove($this->prayersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPrayer $prayer The ChildPrayer object to add.
     */
    protected function doAddPrayer(ChildPrayer $prayer)
    {
        $this->collPrayers[]= $prayer;
        $prayer->setUserProfile($this);
    }

    /**
     * @param  ChildPrayer $prayer The ChildPrayer object to remove.
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function removePrayer(ChildPrayer $prayer)
    {
        if ($this->getPrayers()->contains($prayer)) {
            $pos = $this->collPrayers->search($prayer);
            $this->collPrayers->remove($pos);
            if (null === $this->prayersScheduledForDeletion) {
                $this->prayersScheduledForDeletion = clone $this->collPrayers;
                $this->prayersScheduledForDeletion->clear();
            }
            $this->prayersScheduledForDeletion[]= clone $prayer;
            $prayer->setUserProfile(null);
        }

        return $this;
    }

    /**
     * Clears out the collPushRegisters collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPushRegisters()
     */
    public function clearPushRegisters()
    {
        $this->collPushRegisters = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPushRegisters collection loaded partially.
     */
    public function resetPartialPushRegisters($v = true)
    {
        $this->collPushRegistersPartial = $v;
    }

    /**
     * Initializes the collPushRegisters collection.
     *
     * By default this just sets the collPushRegisters collection to an empty array (like clearcollPushRegisters());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPushRegisters($overrideExisting = true)
    {
        if (null !== $this->collPushRegisters && !$overrideExisting) {
            return;
        }

        $collectionClassName = PushRegisterTableMap::getTableMap()->getCollectionClassName();

        $this->collPushRegisters = new $collectionClassName;
        $this->collPushRegisters->setModel('\PushRegister');
    }

    /**
     * Gets an array of ChildPushRegister objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserProfile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPushRegister[] List of ChildPushRegister objects
     * @throws PropelException
     */
    public function getPushRegisters(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPushRegistersPartial && !$this->isNew();
        if (null === $this->collPushRegisters || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPushRegisters) {
                // return empty collection
                $this->initPushRegisters();
            } else {
                $collPushRegisters = ChildPushRegisterQuery::create(null, $criteria)
                    ->filterByUserProfile($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPushRegistersPartial && count($collPushRegisters)) {
                        $this->initPushRegisters(false);

                        foreach ($collPushRegisters as $obj) {
                            if (false == $this->collPushRegisters->contains($obj)) {
                                $this->collPushRegisters->append($obj);
                            }
                        }

                        $this->collPushRegistersPartial = true;
                    }

                    return $collPushRegisters;
                }

                if ($partial && $this->collPushRegisters) {
                    foreach ($this->collPushRegisters as $obj) {
                        if ($obj->isNew()) {
                            $collPushRegisters[] = $obj;
                        }
                    }
                }

                $this->collPushRegisters = $collPushRegisters;
                $this->collPushRegistersPartial = false;
            }
        }

        return $this->collPushRegisters;
    }

    /**
     * Sets a collection of ChildPushRegister objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pushRegisters A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function setPushRegisters(Collection $pushRegisters, ConnectionInterface $con = null)
    {
        /** @var ChildPushRegister[] $pushRegistersToDelete */
        $pushRegistersToDelete = $this->getPushRegisters(new Criteria(), $con)->diff($pushRegisters);

        
        $this->pushRegistersScheduledForDeletion = $pushRegistersToDelete;

        foreach ($pushRegistersToDelete as $pushRegisterRemoved) {
            $pushRegisterRemoved->setUserProfile(null);
        }

        $this->collPushRegisters = null;
        foreach ($pushRegisters as $pushRegister) {
            $this->addPushRegister($pushRegister);
        }

        $this->collPushRegisters = $pushRegisters;
        $this->collPushRegistersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PushRegister objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PushRegister objects.
     * @throws PropelException
     */
    public function countPushRegisters(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPushRegistersPartial && !$this->isNew();
        if (null === $this->collPushRegisters || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPushRegisters) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPushRegisters());
            }

            $query = ChildPushRegisterQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserProfile($this)
                ->count($con);
        }

        return count($this->collPushRegisters);
    }

    /**
     * Method called to associate a ChildPushRegister object to this object
     * through the ChildPushRegister foreign key attribute.
     *
     * @param  ChildPushRegister $l ChildPushRegister
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function addPushRegister(ChildPushRegister $l)
    {
        if ($this->collPushRegisters === null) {
            $this->initPushRegisters();
            $this->collPushRegistersPartial = true;
        }

        if (!$this->collPushRegisters->contains($l)) {
            $this->doAddPushRegister($l);

            if ($this->pushRegistersScheduledForDeletion and $this->pushRegistersScheduledForDeletion->contains($l)) {
                $this->pushRegistersScheduledForDeletion->remove($this->pushRegistersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPushRegister $pushRegister The ChildPushRegister object to add.
     */
    protected function doAddPushRegister(ChildPushRegister $pushRegister)
    {
        $this->collPushRegisters[]= $pushRegister;
        $pushRegister->setUserProfile($this);
    }

    /**
     * @param  ChildPushRegister $pushRegister The ChildPushRegister object to remove.
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function removePushRegister(ChildPushRegister $pushRegister)
    {
        if ($this->getPushRegisters()->contains($pushRegister)) {
            $pos = $this->collPushRegisters->search($pushRegister);
            $this->collPushRegisters->remove($pos);
            if (null === $this->pushRegistersScheduledForDeletion) {
                $this->pushRegistersScheduledForDeletion = clone $this->collPushRegisters;
                $this->pushRegistersScheduledForDeletion->clear();
            }
            $this->pushRegistersScheduledForDeletion[]= $pushRegister;
            $pushRegister->setUserProfile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UserProfile is new, it will return
     * an empty collection; or if this UserProfile has previously
     * been saved, it will retrieve related PushRegisters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UserProfile.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPushRegister[] List of ChildPushRegister objects
     */
    public function getPushRegistersJoinEconnect(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPushRegisterQuery::create(null, $criteria);
        $query->joinWith('Econnect', $joinBehavior);

        return $this->getPushRegisters($query, $con);
    }

    /**
     * Clears out the collTestimonialss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTestimonialss()
     */
    public function clearTestimonialss()
    {
        $this->collTestimonialss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTestimonialss collection loaded partially.
     */
    public function resetPartialTestimonialss($v = true)
    {
        $this->collTestimonialssPartial = $v;
    }

    /**
     * Initializes the collTestimonialss collection.
     *
     * By default this just sets the collTestimonialss collection to an empty array (like clearcollTestimonialss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTestimonialss($overrideExisting = true)
    {
        if (null !== $this->collTestimonialss && !$overrideExisting) {
            return;
        }

        $collectionClassName = TestimonialsTableMap::getTableMap()->getCollectionClassName();

        $this->collTestimonialss = new $collectionClassName;
        $this->collTestimonialss->setModel('\Testimonials');
    }

    /**
     * Gets an array of ChildTestimonials objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUserProfile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTestimonials[] List of ChildTestimonials objects
     * @throws PropelException
     */
    public function getTestimonialss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTestimonialssPartial && !$this->isNew();
        if (null === $this->collTestimonialss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTestimonialss) {
                // return empty collection
                $this->initTestimonialss();
            } else {
                $collTestimonialss = ChildTestimonialsQuery::create(null, $criteria)
                    ->filterByUserProfile($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTestimonialssPartial && count($collTestimonialss)) {
                        $this->initTestimonialss(false);

                        foreach ($collTestimonialss as $obj) {
                            if (false == $this->collTestimonialss->contains($obj)) {
                                $this->collTestimonialss->append($obj);
                            }
                        }

                        $this->collTestimonialssPartial = true;
                    }

                    return $collTestimonialss;
                }

                if ($partial && $this->collTestimonialss) {
                    foreach ($this->collTestimonialss as $obj) {
                        if ($obj->isNew()) {
                            $collTestimonialss[] = $obj;
                        }
                    }
                }

                $this->collTestimonialss = $collTestimonialss;
                $this->collTestimonialssPartial = false;
            }
        }

        return $this->collTestimonialss;
    }

    /**
     * Sets a collection of ChildTestimonials objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $testimonialss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function setTestimonialss(Collection $testimonialss, ConnectionInterface $con = null)
    {
        /** @var ChildTestimonials[] $testimonialssToDelete */
        $testimonialssToDelete = $this->getTestimonialss(new Criteria(), $con)->diff($testimonialss);

        
        $this->testimonialssScheduledForDeletion = $testimonialssToDelete;

        foreach ($testimonialssToDelete as $testimonialsRemoved) {
            $testimonialsRemoved->setUserProfile(null);
        }

        $this->collTestimonialss = null;
        foreach ($testimonialss as $testimonials) {
            $this->addTestimonials($testimonials);
        }

        $this->collTestimonialss = $testimonialss;
        $this->collTestimonialssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Testimonials objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Testimonials objects.
     * @throws PropelException
     */
    public function countTestimonialss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTestimonialssPartial && !$this->isNew();
        if (null === $this->collTestimonialss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTestimonialss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTestimonialss());
            }

            $query = ChildTestimonialsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserProfile($this)
                ->count($con);
        }

        return count($this->collTestimonialss);
    }

    /**
     * Method called to associate a ChildTestimonials object to this object
     * through the ChildTestimonials foreign key attribute.
     *
     * @param  ChildTestimonials $l ChildTestimonials
     * @return $this|\UserProfile The current object (for fluent API support)
     */
    public function addTestimonials(ChildTestimonials $l)
    {
        if ($this->collTestimonialss === null) {
            $this->initTestimonialss();
            $this->collTestimonialssPartial = true;
        }

        if (!$this->collTestimonialss->contains($l)) {
            $this->doAddTestimonials($l);

            if ($this->testimonialssScheduledForDeletion and $this->testimonialssScheduledForDeletion->contains($l)) {
                $this->testimonialssScheduledForDeletion->remove($this->testimonialssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTestimonials $testimonials The ChildTestimonials object to add.
     */
    protected function doAddTestimonials(ChildTestimonials $testimonials)
    {
        $this->collTestimonialss[]= $testimonials;
        $testimonials->setUserProfile($this);
    }

    /**
     * @param  ChildTestimonials $testimonials The ChildTestimonials object to remove.
     * @return $this|ChildUserProfile The current object (for fluent API support)
     */
    public function removeTestimonials(ChildTestimonials $testimonials)
    {
        if ($this->getTestimonialss()->contains($testimonials)) {
            $pos = $this->collTestimonialss->search($testimonials);
            $this->collTestimonialss->remove($pos);
            if (null === $this->testimonialssScheduledForDeletion) {
                $this->testimonialssScheduledForDeletion = clone $this->collTestimonialss;
                $this->testimonialssScheduledForDeletion->clear();
            }
            $this->testimonialssScheduledForDeletion[]= clone $testimonials;
            $testimonials->setUserProfile(null);
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
            $this->aParish->removeUserProfile($this);
        }
        $this->value = null;
        $this->parish_id = null;
        $this->fname = null;
        $this->lname = null;
        $this->address = null;
        $this->city = null;
        $this->state = null;
        $this->zip = null;
        $this->country = null;
        $this->phone = null;
        $this->email = null;
        $this->dob = null;
        $this->married = null;
        $this->wedding = null;
        $this->push_id = null;
        $this->platform = null;
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
            if ($this->collGives) {
                foreach ($this->collGives as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPastors) {
                foreach ($this->collPastors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrayers) {
                foreach ($this->collPrayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPushRegisters) {
                foreach ($this->collPushRegisters as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTestimonialss) {
                foreach ($this->collTestimonialss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGives = null;
        $this->collPastors = null;
        $this->collPrayers = null;
        $this->collPushRegisters = null;
        $this->collTestimonialss = null;
        $this->aParish = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserProfileTableMap::DEFAULT_STRING_FORMAT);
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
