<?php

namespace Base;

use \About as ChildAbout;
use \AboutQuery as ChildAboutQuery;
use \Church as ChildChurch;
use \ChurchQuery as ChildChurchQuery;
use \Devotions as ChildDevotions;
use \DevotionsQuery as ChildDevotionsQuery;
use \Econnect as ChildEconnect;
use \EconnectQuery as ChildEconnectQuery;
use \Events as ChildEvents;
use \EventsQuery as ChildEventsQuery;
use \Facebook as ChildFacebook;
use \FacebookQuery as ChildFacebookQuery;
use \Give as ChildGive;
use \GiveParishCurrency as ChildGiveParishCurrency;
use \GiveParishCurrencyQuery as ChildGiveParishCurrencyQuery;
use \GiveParishMethods as ChildGiveParishMethods;
use \GiveParishMethodsQuery as ChildGiveParishMethodsQuery;
use \GiveQuery as ChildGiveQuery;
use \GiveType as ChildGiveType;
use \GiveTypeQuery as ChildGiveTypeQuery;
use \Letters as ChildLetters;
use \LettersQuery as ChildLettersQuery;
use \LiveStream as ChildLiveStream;
use \LiveStreamQuery as ChildLiveStreamQuery;
use \Media as ChildMedia;
use \MediaQuery as ChildMediaQuery;
use \Ministry as ChildMinistry;
use \MinistryQuery as ChildMinistryQuery;
use \Parish as ChildParish;
use \ParishQuery as ChildParishQuery;
use \ParishSegment as ChildParishSegment;
use \ParishSegmentQuery as ChildParishSegmentQuery;
use \Twitter as ChildTwitter;
use \TwitterQuery as ChildTwitterQuery;
use \UserFamily as ChildUserFamily;
use \UserFamilyQuery as ChildUserFamilyQuery;
use \UserLogin as ChildUserLogin;
use \UserLoginQuery as ChildUserLoginQuery;
use \UserProfile as ChildUserProfile;
use \UserProfileQuery as ChildUserProfileQuery;
use \UserSubscription as ChildUserSubscription;
use \UserSubscriptionQuery as ChildUserSubscriptionQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AboutTableMap;
use Map\DevotionsTableMap;
use Map\EconnectTableMap;
use Map\EventsTableMap;
use Map\FacebookTableMap;
use Map\GiveParishCurrencyTableMap;
use Map\GiveParishMethodsTableMap;
use Map\GiveTableMap;
use Map\GiveTypeTableMap;
use Map\LettersTableMap;
use Map\LiveStreamTableMap;
use Map\MediaTableMap;
use Map\MinistryTableMap;
use Map\ParishSegmentTableMap;
use Map\ParishTableMap;
use Map\TwitterTableMap;
use Map\UserFamilyTableMap;
use Map\UserLoginTableMap;
use Map\UserProfileTableMap;
use Map\UserSubscriptionTableMap;
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
 * Base class that represents a row from the 'parish' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Parish implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ParishTableMap';


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
     * The value for the church_id field.
     * 
     * @var        int
     */
    protected $church_id;

    /**
     * The value for the name field.
     * 
     * @var        string
     */
    protected $name;

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
     * The value for the lat field.
     * 
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $lat;

    /**
     * The value for the lng field.
     * 
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $lng;

    /**
     * The value for the formatted_address field.
     * 
     * @var        string
     */
    protected $formatted_address;

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
     * The value for the logo field.
     * 
     * @var        string
     */
    protected $logo;

    /**
     * The value for the overseer field.
     * 
     * @var        string
     */
    protected $overseer;

    /**
     * The value for the enabled field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $enabled;

    /**
     * The value for the created_at field.
     * 
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $created_at;

    /**
     * @var        ChildChurch
     */
    protected $aChurch;

    /**
     * @var        ObjectCollection|ChildAbout[] Collection to store aggregation of ChildAbout objects.
     */
    protected $collAbouts;
    protected $collAboutsPartial;

    /**
     * @var        ObjectCollection|ChildDevotions[] Collection to store aggregation of ChildDevotions objects.
     */
    protected $collDevotionss;
    protected $collDevotionssPartial;

    /**
     * @var        ObjectCollection|ChildEconnect[] Collection to store aggregation of ChildEconnect objects.
     */
    protected $collEconnects;
    protected $collEconnectsPartial;

    /**
     * @var        ObjectCollection|ChildEvents[] Collection to store aggregation of ChildEvents objects.
     */
    protected $collEventss;
    protected $collEventssPartial;

    /**
     * @var        ObjectCollection|ChildFacebook[] Collection to store aggregation of ChildFacebook objects.
     */
    protected $collFacebooks;
    protected $collFacebooksPartial;

    /**
     * @var        ObjectCollection|ChildGive[] Collection to store aggregation of ChildGive objects.
     */
    protected $collGives;
    protected $collGivesPartial;

    /**
     * @var        ObjectCollection|ChildGiveParishCurrency[] Collection to store aggregation of ChildGiveParishCurrency objects.
     */
    protected $collGiveParishCurrencies;
    protected $collGiveParishCurrenciesPartial;

    /**
     * @var        ObjectCollection|ChildGiveParishMethods[] Collection to store aggregation of ChildGiveParishMethods objects.
     */
    protected $collGiveParishMethodss;
    protected $collGiveParishMethodssPartial;

    /**
     * @var        ObjectCollection|ChildGiveType[] Collection to store aggregation of ChildGiveType objects.
     */
    protected $collGiveTypes;
    protected $collGiveTypesPartial;

    /**
     * @var        ObjectCollection|ChildLetters[] Collection to store aggregation of ChildLetters objects.
     */
    protected $collLetterss;
    protected $collLetterssPartial;

    /**
     * @var        ObjectCollection|ChildLiveStream[] Collection to store aggregation of ChildLiveStream objects.
     */
    protected $collLiveStreams;
    protected $collLiveStreamsPartial;

    /**
     * @var        ObjectCollection|ChildMedia[] Collection to store aggregation of ChildMedia objects.
     */
    protected $collMedias;
    protected $collMediasPartial;

    /**
     * @var        ObjectCollection|ChildMinistry[] Collection to store aggregation of ChildMinistry objects.
     */
    protected $collMinistries;
    protected $collMinistriesPartial;

    /**
     * @var        ObjectCollection|ChildParishSegment[] Collection to store aggregation of ChildParishSegment objects.
     */
    protected $collParishSegments;
    protected $collParishSegmentsPartial;

    /**
     * @var        ObjectCollection|ChildTwitter[] Collection to store aggregation of ChildTwitter objects.
     */
    protected $collTwitters;
    protected $collTwittersPartial;

    /**
     * @var        ObjectCollection|ChildUserFamily[] Collection to store aggregation of ChildUserFamily objects.
     */
    protected $collUserFamilies;
    protected $collUserFamiliesPartial;

    /**
     * @var        ObjectCollection|ChildUserLogin[] Collection to store aggregation of ChildUserLogin objects.
     */
    protected $collUserLogins;
    protected $collUserLoginsPartial;

    /**
     * @var        ObjectCollection|ChildUserProfile[] Collection to store aggregation of ChildUserProfile objects.
     */
    protected $collUserProfiles;
    protected $collUserProfilesPartial;

    /**
     * @var        ObjectCollection|ChildUserSubscription[] Collection to store aggregation of ChildUserSubscription objects.
     */
    protected $collUserSubscriptions;
    protected $collUserSubscriptionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAbout[]
     */
    protected $aboutsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDevotions[]
     */
    protected $devotionssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEconnect[]
     */
    protected $econnectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvents[]
     */
    protected $eventssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFacebook[]
     */
    protected $facebooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGive[]
     */
    protected $givesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGiveParishCurrency[]
     */
    protected $giveParishCurrenciesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGiveParishMethods[]
     */
    protected $giveParishMethodssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGiveType[]
     */
    protected $giveTypesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildLetters[]
     */
    protected $letterssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildLiveStream[]
     */
    protected $liveStreamsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMedia[]
     */
    protected $mediasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMinistry[]
     */
    protected $ministriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParishSegment[]
     */
    protected $parishSegmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTwitter[]
     */
    protected $twittersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserFamily[]
     */
    protected $userFamiliesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserLogin[]
     */
    protected $userLoginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserProfile[]
     */
    protected $userProfilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserSubscription[]
     */
    protected $userSubscriptionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->lat = '0';
        $this->lng = '0';
        $this->country = 'USA';
        $this->enabled = false;
    }

    /**
     * Initializes internal state of Base\Parish object.
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
     * Compares this with another <code>Parish</code> instance.  If
     * <code>obj</code> is an instance of <code>Parish</code>, delegates to
     * <code>equals(Parish)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Parish The current object, for fluid interface
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
     * Get the [church_id] column value.
     * 
     * @return int
     */
    public function getChurchId()
    {
        return $this->church_id;
    }

    /**
     * Get the [name] column value.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Get the [lat] column value.
     * 
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Get the [lng] column value.
     * 
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Get the [formatted_address] column value.
     * 
     * @return string
     */
    public function getFormattedAddress()
    {
        return $this->formatted_address;
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
     * Get the [logo] column value.
     * 
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Get the [overseer] column value.
     * 
     * @return string
     */
    public function getOverseer()
    {
        return $this->overseer;
    }

    /**
     * Get the [enabled] column value.
     * 
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Get the [enabled] column value.
     * 
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getEnabled();
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
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[ParishTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

    /**
     * Set the value of [church_id] column.
     * 
     * @param int $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setChurchId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->church_id !== $v) {
            $this->church_id = $v;
            $this->modifiedColumns[ParishTableMap::COL_CHURCH_ID] = true;
        }

        if ($this->aChurch !== null && $this->aChurch->getValue() !== $v) {
            $this->aChurch = null;
        }

        return $this;
    } // setChurchId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ParishTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[ParishTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [city] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[ParishTableMap::COL_CITY] = true;
        }

        return $this;
    } // setCity()

    /**
     * Set the value of [state] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[ParishTableMap::COL_STATE] = true;
        }

        return $this;
    } // setState()

    /**
     * Set the value of [zip] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->zip !== $v) {
            $this->zip = $v;
            $this->modifiedColumns[ParishTableMap::COL_ZIP] = true;
        }

        return $this;
    } // setZip()

    /**
     * Set the value of [lat] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[ParishTableMap::COL_LAT] = true;
        }

        return $this;
    } // setLat()

    /**
     * Set the value of [lng] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[ParishTableMap::COL_LNG] = true;
        }

        return $this;
    } // setLng()

    /**
     * Set the value of [formatted_address] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setFormattedAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->formatted_address !== $v) {
            $this->formatted_address = $v;
            $this->modifiedColumns[ParishTableMap::COL_FORMATTED_ADDRESS] = true;
        }

        return $this;
    } // setFormattedAddress()

    /**
     * Set the value of [country] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->country !== $v) {
            $this->country = $v;
            $this->modifiedColumns[ParishTableMap::COL_COUNTRY] = true;
        }

        return $this;
    } // setCountry()

    /**
     * Set the value of [phone] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[ParishTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[ParishTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [logo] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->logo !== $v) {
            $this->logo = $v;
            $this->modifiedColumns[ParishTableMap::COL_LOGO] = true;
        }

        return $this;
    } // setLogo()

    /**
     * Set the value of [overseer] column.
     * 
     * @param string $v new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setOverseer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->overseer !== $v) {
            $this->overseer = $v;
            $this->modifiedColumns[ParishTableMap::COL_OVERSEER] = true;
        }

        return $this;
    } // setOverseer()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setEnabled($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->enabled !== $v) {
            $this->enabled = $v;
            $this->modifiedColumns[ParishTableMap::COL_ENABLED] = true;
        }

        return $this;
    } // setEnabled()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ParishTableMap::COL_CREATED_AT] = true;
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
            if ($this->lat !== '0') {
                return false;
            }

            if ($this->lng !== '0') {
                return false;
            }

            if ($this->country !== 'USA') {
                return false;
            }

            if ($this->enabled !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ParishTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ParishTableMap::translateFieldName('ChurchId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->church_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ParishTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ParishTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ParishTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ParishTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ParishTableMap::translateFieldName('Zip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ParishTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ParishTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ParishTableMap::translateFieldName('FormattedAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->formatted_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ParishTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType)];
            $this->country = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ParishTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ParishTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ParishTableMap::translateFieldName('Logo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->logo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ParishTableMap::translateFieldName('Overseer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->overseer = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ParishTableMap::translateFieldName('Enabled', TableMap::TYPE_PHPNAME, $indexType)];
            $this->enabled = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ParishTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = ParishTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Parish'), 0, $e);
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
        if ($this->aChurch !== null && $this->church_id !== $this->aChurch->getValue()) {
            $this->aChurch = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ParishTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildParishQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aChurch = null;
            $this->collAbouts = null;

            $this->collDevotionss = null;

            $this->collEconnects = null;

            $this->collEventss = null;

            $this->collFacebooks = null;

            $this->collGives = null;

            $this->collGiveParishCurrencies = null;

            $this->collGiveParishMethodss = null;

            $this->collGiveTypes = null;

            $this->collLetterss = null;

            $this->collLiveStreams = null;

            $this->collMedias = null;

            $this->collMinistries = null;

            $this->collParishSegments = null;

            $this->collTwitters = null;

            $this->collUserFamilies = null;

            $this->collUserLogins = null;

            $this->collUserProfiles = null;

            $this->collUserSubscriptions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Parish::setDeleted()
     * @see Parish::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParishTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildParishQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ParishTableMap::DATABASE_NAME);
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
                ParishTableMap::addInstanceToPool($this);
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

            if ($this->aChurch !== null) {
                if ($this->aChurch->isModified() || $this->aChurch->isNew()) {
                    $affectedRows += $this->aChurch->save($con);
                }
                $this->setChurch($this->aChurch);
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

            if ($this->aboutsScheduledForDeletion !== null) {
                if (!$this->aboutsScheduledForDeletion->isEmpty()) {
                    \AboutQuery::create()
                        ->filterByPrimaryKeys($this->aboutsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->aboutsScheduledForDeletion = null;
                }
            }

            if ($this->collAbouts !== null) {
                foreach ($this->collAbouts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->devotionssScheduledForDeletion !== null) {
                if (!$this->devotionssScheduledForDeletion->isEmpty()) {
                    \DevotionsQuery::create()
                        ->filterByPrimaryKeys($this->devotionssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->devotionssScheduledForDeletion = null;
                }
            }

            if ($this->collDevotionss !== null) {
                foreach ($this->collDevotionss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->econnectsScheduledForDeletion !== null) {
                if (!$this->econnectsScheduledForDeletion->isEmpty()) {
                    \EconnectQuery::create()
                        ->filterByPrimaryKeys($this->econnectsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->econnectsScheduledForDeletion = null;
                }
            }

            if ($this->collEconnects !== null) {
                foreach ($this->collEconnects as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->eventssScheduledForDeletion !== null) {
                if (!$this->eventssScheduledForDeletion->isEmpty()) {
                    \EventsQuery::create()
                        ->filterByPrimaryKeys($this->eventssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->eventssScheduledForDeletion = null;
                }
            }

            if ($this->collEventss !== null) {
                foreach ($this->collEventss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->facebooksScheduledForDeletion !== null) {
                if (!$this->facebooksScheduledForDeletion->isEmpty()) {
                    \FacebookQuery::create()
                        ->filterByPrimaryKeys($this->facebooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->facebooksScheduledForDeletion = null;
                }
            }

            if ($this->collFacebooks !== null) {
                foreach ($this->collFacebooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->giveParishCurrenciesScheduledForDeletion !== null) {
                if (!$this->giveParishCurrenciesScheduledForDeletion->isEmpty()) {
                    \GiveParishCurrencyQuery::create()
                        ->filterByPrimaryKeys($this->giveParishCurrenciesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->giveParishCurrenciesScheduledForDeletion = null;
                }
            }

            if ($this->collGiveParishCurrencies !== null) {
                foreach ($this->collGiveParishCurrencies as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->giveParishMethodssScheduledForDeletion !== null) {
                if (!$this->giveParishMethodssScheduledForDeletion->isEmpty()) {
                    \GiveParishMethodsQuery::create()
                        ->filterByPrimaryKeys($this->giveParishMethodssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->giveParishMethodssScheduledForDeletion = null;
                }
            }

            if ($this->collGiveParishMethodss !== null) {
                foreach ($this->collGiveParishMethodss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->giveTypesScheduledForDeletion !== null) {
                if (!$this->giveTypesScheduledForDeletion->isEmpty()) {
                    \GiveTypeQuery::create()
                        ->filterByPrimaryKeys($this->giveTypesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->giveTypesScheduledForDeletion = null;
                }
            }

            if ($this->collGiveTypes !== null) {
                foreach ($this->collGiveTypes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->letterssScheduledForDeletion !== null) {
                if (!$this->letterssScheduledForDeletion->isEmpty()) {
                    \LettersQuery::create()
                        ->filterByPrimaryKeys($this->letterssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->letterssScheduledForDeletion = null;
                }
            }

            if ($this->collLetterss !== null) {
                foreach ($this->collLetterss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->liveStreamsScheduledForDeletion !== null) {
                if (!$this->liveStreamsScheduledForDeletion->isEmpty()) {
                    \LiveStreamQuery::create()
                        ->filterByPrimaryKeys($this->liveStreamsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->liveStreamsScheduledForDeletion = null;
                }
            }

            if ($this->collLiveStreams !== null) {
                foreach ($this->collLiveStreams as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mediasScheduledForDeletion !== null) {
                if (!$this->mediasScheduledForDeletion->isEmpty()) {
                    \MediaQuery::create()
                        ->filterByPrimaryKeys($this->mediasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mediasScheduledForDeletion = null;
                }
            }

            if ($this->collMedias !== null) {
                foreach ($this->collMedias as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ministriesScheduledForDeletion !== null) {
                if (!$this->ministriesScheduledForDeletion->isEmpty()) {
                    \MinistryQuery::create()
                        ->filterByPrimaryKeys($this->ministriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ministriesScheduledForDeletion = null;
                }
            }

            if ($this->collMinistries !== null) {
                foreach ($this->collMinistries as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->parishSegmentsScheduledForDeletion !== null) {
                if (!$this->parishSegmentsScheduledForDeletion->isEmpty()) {
                    \ParishSegmentQuery::create()
                        ->filterByPrimaryKeys($this->parishSegmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->parishSegmentsScheduledForDeletion = null;
                }
            }

            if ($this->collParishSegments !== null) {
                foreach ($this->collParishSegments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->twittersScheduledForDeletion !== null) {
                if (!$this->twittersScheduledForDeletion->isEmpty()) {
                    \TwitterQuery::create()
                        ->filterByPrimaryKeys($this->twittersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->twittersScheduledForDeletion = null;
                }
            }

            if ($this->collTwitters !== null) {
                foreach ($this->collTwitters as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userFamiliesScheduledForDeletion !== null) {
                if (!$this->userFamiliesScheduledForDeletion->isEmpty()) {
                    \UserFamilyQuery::create()
                        ->filterByPrimaryKeys($this->userFamiliesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userFamiliesScheduledForDeletion = null;
                }
            }

            if ($this->collUserFamilies !== null) {
                foreach ($this->collUserFamilies as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userLoginsScheduledForDeletion !== null) {
                if (!$this->userLoginsScheduledForDeletion->isEmpty()) {
                    \UserLoginQuery::create()
                        ->filterByPrimaryKeys($this->userLoginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userLoginsScheduledForDeletion = null;
                }
            }

            if ($this->collUserLogins !== null) {
                foreach ($this->collUserLogins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userProfilesScheduledForDeletion !== null) {
                if (!$this->userProfilesScheduledForDeletion->isEmpty()) {
                    \UserProfileQuery::create()
                        ->filterByPrimaryKeys($this->userProfilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userProfilesScheduledForDeletion = null;
                }
            }

            if ($this->collUserProfiles !== null) {
                foreach ($this->collUserProfiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userSubscriptionsScheduledForDeletion !== null) {
                if (!$this->userSubscriptionsScheduledForDeletion->isEmpty()) {
                    \UserSubscriptionQuery::create()
                        ->filterByPrimaryKeys($this->userSubscriptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userSubscriptionsScheduledForDeletion = null;
                }
            }

            if ($this->collUserSubscriptions !== null) {
                foreach ($this->collUserSubscriptions as $referrerFK) {
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

        $this->modifiedColumns[ParishTableMap::COL_VALUE] = true;
        if (null !== $this->value) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ParishTableMap::COL_VALUE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ParishTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }
        if ($this->isColumnModified(ParishTableMap::COL_CHURCH_ID)) {
            $modifiedColumns[':p' . $index++]  = 'church_id';
        }
        if ($this->isColumnModified(ParishTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ParishTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(ParishTableMap::COL_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'city';
        }
        if ($this->isColumnModified(ParishTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(ParishTableMap::COL_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'zip';
        }
        if ($this->isColumnModified(ParishTableMap::COL_LAT)) {
            $modifiedColumns[':p' . $index++]  = 'lat';
        }
        if ($this->isColumnModified(ParishTableMap::COL_LNG)) {
            $modifiedColumns[':p' . $index++]  = 'lng';
        }
        if ($this->isColumnModified(ParishTableMap::COL_FORMATTED_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'formatted_address';
        }
        if ($this->isColumnModified(ParishTableMap::COL_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'country';
        }
        if ($this->isColumnModified(ParishTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'phone';
        }
        if ($this->isColumnModified(ParishTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(ParishTableMap::COL_LOGO)) {
            $modifiedColumns[':p' . $index++]  = 'logo';
        }
        if ($this->isColumnModified(ParishTableMap::COL_OVERSEER)) {
            $modifiedColumns[':p' . $index++]  = 'overseer';
        }
        if ($this->isColumnModified(ParishTableMap::COL_ENABLED)) {
            $modifiedColumns[':p' . $index++]  = 'enabled';
        }
        if ($this->isColumnModified(ParishTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }

        $sql = sprintf(
            'INSERT INTO parish (%s) VALUES (%s)',
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
                    case 'church_id':                        
                        $stmt->bindValue($identifier, $this->church_id, PDO::PARAM_INT);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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
                    case 'lat':                        
                        $stmt->bindValue($identifier, $this->lat, PDO::PARAM_STR);
                        break;
                    case 'lng':                        
                        $stmt->bindValue($identifier, $this->lng, PDO::PARAM_STR);
                        break;
                    case 'formatted_address':                        
                        $stmt->bindValue($identifier, $this->formatted_address, PDO::PARAM_STR);
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
                    case 'logo':                        
                        $stmt->bindValue($identifier, $this->logo, PDO::PARAM_STR);
                        break;
                    case 'overseer':                        
                        $stmt->bindValue($identifier, $this->overseer, PDO::PARAM_STR);
                        break;
                    case 'enabled':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
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
        $pos = ParishTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getChurchId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getAddress();
                break;
            case 4:
                return $this->getCity();
                break;
            case 5:
                return $this->getState();
                break;
            case 6:
                return $this->getZip();
                break;
            case 7:
                return $this->getLat();
                break;
            case 8:
                return $this->getLng();
                break;
            case 9:
                return $this->getFormattedAddress();
                break;
            case 10:
                return $this->getCountry();
                break;
            case 11:
                return $this->getPhone();
                break;
            case 12:
                return $this->getEmail();
                break;
            case 13:
                return $this->getLogo();
                break;
            case 14:
                return $this->getOverseer();
                break;
            case 15:
                return $this->getEnabled();
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

        if (isset($alreadyDumpedObjects['Parish'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Parish'][$this->hashCode()] = true;
        $keys = ParishTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getValue(),
            $keys[1] => $this->getChurchId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getAddress(),
            $keys[4] => $this->getCity(),
            $keys[5] => $this->getState(),
            $keys[6] => $this->getZip(),
            $keys[7] => $this->getLat(),
            $keys[8] => $this->getLng(),
            $keys[9] => $this->getFormattedAddress(),
            $keys[10] => $this->getCountry(),
            $keys[11] => $this->getPhone(),
            $keys[12] => $this->getEmail(),
            $keys[13] => $this->getLogo(),
            $keys[14] => $this->getOverseer(),
            $keys[15] => $this->getEnabled(),
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
            if (null !== $this->aChurch) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'church';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'church';
                        break;
                    default:
                        $key = 'Church';
                }
        
                $result[$key] = $this->aChurch->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAbouts) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'abouts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'abouts';
                        break;
                    default:
                        $key = 'Abouts';
                }
        
                $result[$key] = $this->collAbouts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDevotionss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'devotionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'devotionss';
                        break;
                    default:
                        $key = 'Devotionss';
                }
        
                $result[$key] = $this->collDevotionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEconnects) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'econnects';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'econnects';
                        break;
                    default:
                        $key = 'Econnects';
                }
        
                $result[$key] = $this->collEconnects->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEventss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'eventss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'eventss';
                        break;
                    default:
                        $key = 'Eventss';
                }
        
                $result[$key] = $this->collEventss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFacebooks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'facebooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'facebooks';
                        break;
                    default:
                        $key = 'Facebooks';
                }
        
                $result[$key] = $this->collFacebooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collGiveParishCurrencies) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giveParishCurrencies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'give_parish_currencies';
                        break;
                    default:
                        $key = 'GiveParishCurrencies';
                }
        
                $result[$key] = $this->collGiveParishCurrencies->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGiveParishMethodss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giveParishMethodss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'give_parish_methodss';
                        break;
                    default:
                        $key = 'GiveParishMethodss';
                }
        
                $result[$key] = $this->collGiveParishMethodss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGiveTypes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giveTypes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'give_types';
                        break;
                    default:
                        $key = 'GiveTypes';
                }
        
                $result[$key] = $this->collGiveTypes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLetterss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'letterss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'letterss';
                        break;
                    default:
                        $key = 'Letterss';
                }
        
                $result[$key] = $this->collLetterss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLiveStreams) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'liveStreams';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'live_streams';
                        break;
                    default:
                        $key = 'LiveStreams';
                }
        
                $result[$key] = $this->collLiveStreams->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMedias) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'medias';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'medias';
                        break;
                    default:
                        $key = 'Medias';
                }
        
                $result[$key] = $this->collMedias->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMinistries) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ministries';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ministries';
                        break;
                    default:
                        $key = 'Ministries';
                }
        
                $result[$key] = $this->collMinistries->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collParishSegments) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'parishSegments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'parish_segments';
                        break;
                    default:
                        $key = 'ParishSegments';
                }
        
                $result[$key] = $this->collParishSegments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTwitters) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'twitters';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'twitters';
                        break;
                    default:
                        $key = 'Twitters';
                }
        
                $result[$key] = $this->collTwitters->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserFamilies) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userFamilies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_families';
                        break;
                    default:
                        $key = 'UserFamilies';
                }
        
                $result[$key] = $this->collUserFamilies->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserLogins) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userLogins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_logins';
                        break;
                    default:
                        $key = 'UserLogins';
                }
        
                $result[$key] = $this->collUserLogins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserProfiles) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userProfiles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_profiles';
                        break;
                    default:
                        $key = 'UserProfiles';
                }
        
                $result[$key] = $this->collUserProfiles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserSubscriptions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userSubscriptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_subscriptions';
                        break;
                    default:
                        $key = 'UserSubscriptions';
                }
        
                $result[$key] = $this->collUserSubscriptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Parish
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ParishTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Parish
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setValue($value);
                break;
            case 1:
                $this->setChurchId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setAddress($value);
                break;
            case 4:
                $this->setCity($value);
                break;
            case 5:
                $this->setState($value);
                break;
            case 6:
                $this->setZip($value);
                break;
            case 7:
                $this->setLat($value);
                break;
            case 8:
                $this->setLng($value);
                break;
            case 9:
                $this->setFormattedAddress($value);
                break;
            case 10:
                $this->setCountry($value);
                break;
            case 11:
                $this->setPhone($value);
                break;
            case 12:
                $this->setEmail($value);
                break;
            case 13:
                $this->setLogo($value);
                break;
            case 14:
                $this->setOverseer($value);
                break;
            case 15:
                $this->setEnabled($value);
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
        $keys = ParishTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setValue($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setChurchId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setState($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setZip($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLat($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLng($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setFormattedAddress($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCountry($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setPhone($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setEmail($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLogo($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setOverseer($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setEnabled($arr[$keys[15]]);
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
     * @return $this|\Parish The current object, for fluid interface
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
        $criteria = new Criteria(ParishTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ParishTableMap::COL_VALUE)) {
            $criteria->add(ParishTableMap::COL_VALUE, $this->value);
        }
        if ($this->isColumnModified(ParishTableMap::COL_CHURCH_ID)) {
            $criteria->add(ParishTableMap::COL_CHURCH_ID, $this->church_id);
        }
        if ($this->isColumnModified(ParishTableMap::COL_NAME)) {
            $criteria->add(ParishTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ParishTableMap::COL_ADDRESS)) {
            $criteria->add(ParishTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(ParishTableMap::COL_CITY)) {
            $criteria->add(ParishTableMap::COL_CITY, $this->city);
        }
        if ($this->isColumnModified(ParishTableMap::COL_STATE)) {
            $criteria->add(ParishTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(ParishTableMap::COL_ZIP)) {
            $criteria->add(ParishTableMap::COL_ZIP, $this->zip);
        }
        if ($this->isColumnModified(ParishTableMap::COL_LAT)) {
            $criteria->add(ParishTableMap::COL_LAT, $this->lat);
        }
        if ($this->isColumnModified(ParishTableMap::COL_LNG)) {
            $criteria->add(ParishTableMap::COL_LNG, $this->lng);
        }
        if ($this->isColumnModified(ParishTableMap::COL_FORMATTED_ADDRESS)) {
            $criteria->add(ParishTableMap::COL_FORMATTED_ADDRESS, $this->formatted_address);
        }
        if ($this->isColumnModified(ParishTableMap::COL_COUNTRY)) {
            $criteria->add(ParishTableMap::COL_COUNTRY, $this->country);
        }
        if ($this->isColumnModified(ParishTableMap::COL_PHONE)) {
            $criteria->add(ParishTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(ParishTableMap::COL_EMAIL)) {
            $criteria->add(ParishTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(ParishTableMap::COL_LOGO)) {
            $criteria->add(ParishTableMap::COL_LOGO, $this->logo);
        }
        if ($this->isColumnModified(ParishTableMap::COL_OVERSEER)) {
            $criteria->add(ParishTableMap::COL_OVERSEER, $this->overseer);
        }
        if ($this->isColumnModified(ParishTableMap::COL_ENABLED)) {
            $criteria->add(ParishTableMap::COL_ENABLED, $this->enabled);
        }
        if ($this->isColumnModified(ParishTableMap::COL_CREATED_AT)) {
            $criteria->add(ParishTableMap::COL_CREATED_AT, $this->created_at);
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
        $criteria = ChildParishQuery::create();
        $criteria->add(ParishTableMap::COL_VALUE, $this->value);

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
     * @param      object $copyObj An object of \Parish (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setChurchId($this->getChurchId());
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setCity($this->getCity());
        $copyObj->setState($this->getState());
        $copyObj->setZip($this->getZip());
        $copyObj->setLat($this->getLat());
        $copyObj->setLng($this->getLng());
        $copyObj->setFormattedAddress($this->getFormattedAddress());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setLogo($this->getLogo());
        $copyObj->setOverseer($this->getOverseer());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAbouts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAbout($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDevotionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDevotions($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEconnects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEconnect($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEventss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEvents($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFacebooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFacebook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGives() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGive($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGiveParishCurrencies() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGiveParishCurrency($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGiveParishMethodss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGiveParishMethods($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGiveTypes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGiveType($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getLetterss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLetters($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getLiveStreams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLiveStream($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMedias() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMedia($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMinistries() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMinistry($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getParishSegments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParishSegment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTwitters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTwitter($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserFamilies() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserFamily($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserLogins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserLogin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserProfiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserProfile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserSubscriptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserSubscription($relObj->copy($deepCopy));
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
     * @return \Parish Clone of current object.
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
     * Declares an association between this object and a ChildChurch object.
     *
     * @param  ChildChurch $v
     * @return $this|\Parish The current object (for fluent API support)
     * @throws PropelException
     */
    public function setChurch(ChildChurch $v = null)
    {
        if ($v === null) {
            $this->setChurchId(NULL);
        } else {
            $this->setChurchId($v->getValue());
        }

        $this->aChurch = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildChurch object, it will not be re-added.
        if ($v !== null) {
            $v->addParish($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildChurch object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildChurch The associated ChildChurch object.
     * @throws PropelException
     */
    public function getChurch(ConnectionInterface $con = null)
    {
        if ($this->aChurch === null && ($this->church_id !== null)) {
            $this->aChurch = ChildChurchQuery::create()->findPk($this->church_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aChurch->addParishes($this);
             */
        }

        return $this->aChurch;
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
        if ('About' == $relationName) {
            return $this->initAbouts();
        }
        if ('Devotions' == $relationName) {
            return $this->initDevotionss();
        }
        if ('Econnect' == $relationName) {
            return $this->initEconnects();
        }
        if ('Events' == $relationName) {
            return $this->initEventss();
        }
        if ('Facebook' == $relationName) {
            return $this->initFacebooks();
        }
        if ('Give' == $relationName) {
            return $this->initGives();
        }
        if ('GiveParishCurrency' == $relationName) {
            return $this->initGiveParishCurrencies();
        }
        if ('GiveParishMethods' == $relationName) {
            return $this->initGiveParishMethodss();
        }
        if ('GiveType' == $relationName) {
            return $this->initGiveTypes();
        }
        if ('Letters' == $relationName) {
            return $this->initLetterss();
        }
        if ('LiveStream' == $relationName) {
            return $this->initLiveStreams();
        }
        if ('Media' == $relationName) {
            return $this->initMedias();
        }
        if ('Ministry' == $relationName) {
            return $this->initMinistries();
        }
        if ('ParishSegment' == $relationName) {
            return $this->initParishSegments();
        }
        if ('Twitter' == $relationName) {
            return $this->initTwitters();
        }
        if ('UserFamily' == $relationName) {
            return $this->initUserFamilies();
        }
        if ('UserLogin' == $relationName) {
            return $this->initUserLogins();
        }
        if ('UserProfile' == $relationName) {
            return $this->initUserProfiles();
        }
        if ('UserSubscription' == $relationName) {
            return $this->initUserSubscriptions();
        }
    }

    /**
     * Clears out the collAbouts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAbouts()
     */
    public function clearAbouts()
    {
        $this->collAbouts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAbouts collection loaded partially.
     */
    public function resetPartialAbouts($v = true)
    {
        $this->collAboutsPartial = $v;
    }

    /**
     * Initializes the collAbouts collection.
     *
     * By default this just sets the collAbouts collection to an empty array (like clearcollAbouts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAbouts($overrideExisting = true)
    {
        if (null !== $this->collAbouts && !$overrideExisting) {
            return;
        }

        $collectionClassName = AboutTableMap::getTableMap()->getCollectionClassName();

        $this->collAbouts = new $collectionClassName;
        $this->collAbouts->setModel('\About');
    }

    /**
     * Gets an array of ChildAbout objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAbout[] List of ChildAbout objects
     * @throws PropelException
     */
    public function getAbouts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAboutsPartial && !$this->isNew();
        if (null === $this->collAbouts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAbouts) {
                // return empty collection
                $this->initAbouts();
            } else {
                $collAbouts = ChildAboutQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAboutsPartial && count($collAbouts)) {
                        $this->initAbouts(false);

                        foreach ($collAbouts as $obj) {
                            if (false == $this->collAbouts->contains($obj)) {
                                $this->collAbouts->append($obj);
                            }
                        }

                        $this->collAboutsPartial = true;
                    }

                    return $collAbouts;
                }

                if ($partial && $this->collAbouts) {
                    foreach ($this->collAbouts as $obj) {
                        if ($obj->isNew()) {
                            $collAbouts[] = $obj;
                        }
                    }
                }

                $this->collAbouts = $collAbouts;
                $this->collAboutsPartial = false;
            }
        }

        return $this->collAbouts;
    }

    /**
     * Sets a collection of ChildAbout objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $abouts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setAbouts(Collection $abouts, ConnectionInterface $con = null)
    {
        /** @var ChildAbout[] $aboutsToDelete */
        $aboutsToDelete = $this->getAbouts(new Criteria(), $con)->diff($abouts);

        
        $this->aboutsScheduledForDeletion = $aboutsToDelete;

        foreach ($aboutsToDelete as $aboutRemoved) {
            $aboutRemoved->setParish(null);
        }

        $this->collAbouts = null;
        foreach ($abouts as $about) {
            $this->addAbout($about);
        }

        $this->collAbouts = $abouts;
        $this->collAboutsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related About objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related About objects.
     * @throws PropelException
     */
    public function countAbouts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAboutsPartial && !$this->isNew();
        if (null === $this->collAbouts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAbouts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAbouts());
            }

            $query = ChildAboutQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collAbouts);
    }

    /**
     * Method called to associate a ChildAbout object to this object
     * through the ChildAbout foreign key attribute.
     *
     * @param  ChildAbout $l ChildAbout
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addAbout(ChildAbout $l)
    {
        if ($this->collAbouts === null) {
            $this->initAbouts();
            $this->collAboutsPartial = true;
        }

        if (!$this->collAbouts->contains($l)) {
            $this->doAddAbout($l);

            if ($this->aboutsScheduledForDeletion and $this->aboutsScheduledForDeletion->contains($l)) {
                $this->aboutsScheduledForDeletion->remove($this->aboutsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAbout $about The ChildAbout object to add.
     */
    protected function doAddAbout(ChildAbout $about)
    {
        $this->collAbouts[]= $about;
        $about->setParish($this);
    }

    /**
     * @param  ChildAbout $about The ChildAbout object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeAbout(ChildAbout $about)
    {
        if ($this->getAbouts()->contains($about)) {
            $pos = $this->collAbouts->search($about);
            $this->collAbouts->remove($pos);
            if (null === $this->aboutsScheduledForDeletion) {
                $this->aboutsScheduledForDeletion = clone $this->collAbouts;
                $this->aboutsScheduledForDeletion->clear();
            }
            $this->aboutsScheduledForDeletion[]= clone $about;
            $about->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collDevotionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDevotionss()
     */
    public function clearDevotionss()
    {
        $this->collDevotionss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDevotionss collection loaded partially.
     */
    public function resetPartialDevotionss($v = true)
    {
        $this->collDevotionssPartial = $v;
    }

    /**
     * Initializes the collDevotionss collection.
     *
     * By default this just sets the collDevotionss collection to an empty array (like clearcollDevotionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDevotionss($overrideExisting = true)
    {
        if (null !== $this->collDevotionss && !$overrideExisting) {
            return;
        }

        $collectionClassName = DevotionsTableMap::getTableMap()->getCollectionClassName();

        $this->collDevotionss = new $collectionClassName;
        $this->collDevotionss->setModel('\Devotions');
    }

    /**
     * Gets an array of ChildDevotions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDevotions[] List of ChildDevotions objects
     * @throws PropelException
     */
    public function getDevotionss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDevotionssPartial && !$this->isNew();
        if (null === $this->collDevotionss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDevotionss) {
                // return empty collection
                $this->initDevotionss();
            } else {
                $collDevotionss = ChildDevotionsQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDevotionssPartial && count($collDevotionss)) {
                        $this->initDevotionss(false);

                        foreach ($collDevotionss as $obj) {
                            if (false == $this->collDevotionss->contains($obj)) {
                                $this->collDevotionss->append($obj);
                            }
                        }

                        $this->collDevotionssPartial = true;
                    }

                    return $collDevotionss;
                }

                if ($partial && $this->collDevotionss) {
                    foreach ($this->collDevotionss as $obj) {
                        if ($obj->isNew()) {
                            $collDevotionss[] = $obj;
                        }
                    }
                }

                $this->collDevotionss = $collDevotionss;
                $this->collDevotionssPartial = false;
            }
        }

        return $this->collDevotionss;
    }

    /**
     * Sets a collection of ChildDevotions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $devotionss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setDevotionss(Collection $devotionss, ConnectionInterface $con = null)
    {
        /** @var ChildDevotions[] $devotionssToDelete */
        $devotionssToDelete = $this->getDevotionss(new Criteria(), $con)->diff($devotionss);

        
        $this->devotionssScheduledForDeletion = $devotionssToDelete;

        foreach ($devotionssToDelete as $devotionsRemoved) {
            $devotionsRemoved->setParish(null);
        }

        $this->collDevotionss = null;
        foreach ($devotionss as $devotions) {
            $this->addDevotions($devotions);
        }

        $this->collDevotionss = $devotionss;
        $this->collDevotionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Devotions objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Devotions objects.
     * @throws PropelException
     */
    public function countDevotionss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDevotionssPartial && !$this->isNew();
        if (null === $this->collDevotionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDevotionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDevotionss());
            }

            $query = ChildDevotionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collDevotionss);
    }

    /**
     * Method called to associate a ChildDevotions object to this object
     * through the ChildDevotions foreign key attribute.
     *
     * @param  ChildDevotions $l ChildDevotions
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addDevotions(ChildDevotions $l)
    {
        if ($this->collDevotionss === null) {
            $this->initDevotionss();
            $this->collDevotionssPartial = true;
        }

        if (!$this->collDevotionss->contains($l)) {
            $this->doAddDevotions($l);

            if ($this->devotionssScheduledForDeletion and $this->devotionssScheduledForDeletion->contains($l)) {
                $this->devotionssScheduledForDeletion->remove($this->devotionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDevotions $devotions The ChildDevotions object to add.
     */
    protected function doAddDevotions(ChildDevotions $devotions)
    {
        $this->collDevotionss[]= $devotions;
        $devotions->setParish($this);
    }

    /**
     * @param  ChildDevotions $devotions The ChildDevotions object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeDevotions(ChildDevotions $devotions)
    {
        if ($this->getDevotionss()->contains($devotions)) {
            $pos = $this->collDevotionss->search($devotions);
            $this->collDevotionss->remove($pos);
            if (null === $this->devotionssScheduledForDeletion) {
                $this->devotionssScheduledForDeletion = clone $this->collDevotionss;
                $this->devotionssScheduledForDeletion->clear();
            }
            $this->devotionssScheduledForDeletion[]= clone $devotions;
            $devotions->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Devotionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDevotions[] List of ChildDevotions objects
     */
    public function getDevotionssJoinMediaType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDevotionsQuery::create(null, $criteria);
        $query->joinWith('MediaType', $joinBehavior);

        return $this->getDevotionss($query, $con);
    }

    /**
     * Clears out the collEconnects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEconnects()
     */
    public function clearEconnects()
    {
        $this->collEconnects = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEconnects collection loaded partially.
     */
    public function resetPartialEconnects($v = true)
    {
        $this->collEconnectsPartial = $v;
    }

    /**
     * Initializes the collEconnects collection.
     *
     * By default this just sets the collEconnects collection to an empty array (like clearcollEconnects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEconnects($overrideExisting = true)
    {
        if (null !== $this->collEconnects && !$overrideExisting) {
            return;
        }

        $collectionClassName = EconnectTableMap::getTableMap()->getCollectionClassName();

        $this->collEconnects = new $collectionClassName;
        $this->collEconnects->setModel('\Econnect');
    }

    /**
     * Gets an array of ChildEconnect objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEconnect[] List of ChildEconnect objects
     * @throws PropelException
     */
    public function getEconnects(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEconnectsPartial && !$this->isNew();
        if (null === $this->collEconnects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEconnects) {
                // return empty collection
                $this->initEconnects();
            } else {
                $collEconnects = ChildEconnectQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEconnectsPartial && count($collEconnects)) {
                        $this->initEconnects(false);

                        foreach ($collEconnects as $obj) {
                            if (false == $this->collEconnects->contains($obj)) {
                                $this->collEconnects->append($obj);
                            }
                        }

                        $this->collEconnectsPartial = true;
                    }

                    return $collEconnects;
                }

                if ($partial && $this->collEconnects) {
                    foreach ($this->collEconnects as $obj) {
                        if ($obj->isNew()) {
                            $collEconnects[] = $obj;
                        }
                    }
                }

                $this->collEconnects = $collEconnects;
                $this->collEconnectsPartial = false;
            }
        }

        return $this->collEconnects;
    }

    /**
     * Sets a collection of ChildEconnect objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $econnects A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setEconnects(Collection $econnects, ConnectionInterface $con = null)
    {
        /** @var ChildEconnect[] $econnectsToDelete */
        $econnectsToDelete = $this->getEconnects(new Criteria(), $con)->diff($econnects);

        
        $this->econnectsScheduledForDeletion = $econnectsToDelete;

        foreach ($econnectsToDelete as $econnectRemoved) {
            $econnectRemoved->setParish(null);
        }

        $this->collEconnects = null;
        foreach ($econnects as $econnect) {
            $this->addEconnect($econnect);
        }

        $this->collEconnects = $econnects;
        $this->collEconnectsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Econnect objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Econnect objects.
     * @throws PropelException
     */
    public function countEconnects(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEconnectsPartial && !$this->isNew();
        if (null === $this->collEconnects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEconnects) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEconnects());
            }

            $query = ChildEconnectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collEconnects);
    }

    /**
     * Method called to associate a ChildEconnect object to this object
     * through the ChildEconnect foreign key attribute.
     *
     * @param  ChildEconnect $l ChildEconnect
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addEconnect(ChildEconnect $l)
    {
        if ($this->collEconnects === null) {
            $this->initEconnects();
            $this->collEconnectsPartial = true;
        }

        if (!$this->collEconnects->contains($l)) {
            $this->doAddEconnect($l);

            if ($this->econnectsScheduledForDeletion and $this->econnectsScheduledForDeletion->contains($l)) {
                $this->econnectsScheduledForDeletion->remove($this->econnectsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEconnect $econnect The ChildEconnect object to add.
     */
    protected function doAddEconnect(ChildEconnect $econnect)
    {
        $this->collEconnects[]= $econnect;
        $econnect->setParish($this);
    }

    /**
     * @param  ChildEconnect $econnect The ChildEconnect object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeEconnect(ChildEconnect $econnect)
    {
        if ($this->getEconnects()->contains($econnect)) {
            $pos = $this->collEconnects->search($econnect);
            $this->collEconnects->remove($pos);
            if (null === $this->econnectsScheduledForDeletion) {
                $this->econnectsScheduledForDeletion = clone $this->collEconnects;
                $this->econnectsScheduledForDeletion->clear();
            }
            $this->econnectsScheduledForDeletion[]= clone $econnect;
            $econnect->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collEventss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventss()
     */
    public function clearEventss()
    {
        $this->collEventss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventss collection loaded partially.
     */
    public function resetPartialEventss($v = true)
    {
        $this->collEventssPartial = $v;
    }

    /**
     * Initializes the collEventss collection.
     *
     * By default this just sets the collEventss collection to an empty array (like clearcollEventss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventss($overrideExisting = true)
    {
        if (null !== $this->collEventss && !$overrideExisting) {
            return;
        }

        $collectionClassName = EventsTableMap::getTableMap()->getCollectionClassName();

        $this->collEventss = new $collectionClassName;
        $this->collEventss->setModel('\Events');
    }

    /**
     * Gets an array of ChildEvents objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvents[] List of ChildEvents objects
     * @throws PropelException
     */
    public function getEventss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventssPartial && !$this->isNew();
        if (null === $this->collEventss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventss) {
                // return empty collection
                $this->initEventss();
            } else {
                $collEventss = ChildEventsQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventssPartial && count($collEventss)) {
                        $this->initEventss(false);

                        foreach ($collEventss as $obj) {
                            if (false == $this->collEventss->contains($obj)) {
                                $this->collEventss->append($obj);
                            }
                        }

                        $this->collEventssPartial = true;
                    }

                    return $collEventss;
                }

                if ($partial && $this->collEventss) {
                    foreach ($this->collEventss as $obj) {
                        if ($obj->isNew()) {
                            $collEventss[] = $obj;
                        }
                    }
                }

                $this->collEventss = $collEventss;
                $this->collEventssPartial = false;
            }
        }

        return $this->collEventss;
    }

    /**
     * Sets a collection of ChildEvents objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setEventss(Collection $eventss, ConnectionInterface $con = null)
    {
        /** @var ChildEvents[] $eventssToDelete */
        $eventssToDelete = $this->getEventss(new Criteria(), $con)->diff($eventss);

        
        $this->eventssScheduledForDeletion = $eventssToDelete;

        foreach ($eventssToDelete as $eventsRemoved) {
            $eventsRemoved->setParish(null);
        }

        $this->collEventss = null;
        foreach ($eventss as $events) {
            $this->addEvents($events);
        }

        $this->collEventss = $eventss;
        $this->collEventssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Events objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Events objects.
     * @throws PropelException
     */
    public function countEventss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventssPartial && !$this->isNew();
        if (null === $this->collEventss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventss());
            }

            $query = ChildEventsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collEventss);
    }

    /**
     * Method called to associate a ChildEvents object to this object
     * through the ChildEvents foreign key attribute.
     *
     * @param  ChildEvents $l ChildEvents
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addEvents(ChildEvents $l)
    {
        if ($this->collEventss === null) {
            $this->initEventss();
            $this->collEventssPartial = true;
        }

        if (!$this->collEventss->contains($l)) {
            $this->doAddEvents($l);

            if ($this->eventssScheduledForDeletion and $this->eventssScheduledForDeletion->contains($l)) {
                $this->eventssScheduledForDeletion->remove($this->eventssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEvents $events The ChildEvents object to add.
     */
    protected function doAddEvents(ChildEvents $events)
    {
        $this->collEventss[]= $events;
        $events->setParish($this);
    }

    /**
     * @param  ChildEvents $events The ChildEvents object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeEvents(ChildEvents $events)
    {
        if ($this->getEventss()->contains($events)) {
            $pos = $this->collEventss->search($events);
            $this->collEventss->remove($pos);
            if (null === $this->eventssScheduledForDeletion) {
                $this->eventssScheduledForDeletion = clone $this->collEventss;
                $this->eventssScheduledForDeletion->clear();
            }
            $this->eventssScheduledForDeletion[]= clone $events;
            $events->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collFacebooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFacebooks()
     */
    public function clearFacebooks()
    {
        $this->collFacebooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFacebooks collection loaded partially.
     */
    public function resetPartialFacebooks($v = true)
    {
        $this->collFacebooksPartial = $v;
    }

    /**
     * Initializes the collFacebooks collection.
     *
     * By default this just sets the collFacebooks collection to an empty array (like clearcollFacebooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFacebooks($overrideExisting = true)
    {
        if (null !== $this->collFacebooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = FacebookTableMap::getTableMap()->getCollectionClassName();

        $this->collFacebooks = new $collectionClassName;
        $this->collFacebooks->setModel('\Facebook');
    }

    /**
     * Gets an array of ChildFacebook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFacebook[] List of ChildFacebook objects
     * @throws PropelException
     */
    public function getFacebooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFacebooksPartial && !$this->isNew();
        if (null === $this->collFacebooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFacebooks) {
                // return empty collection
                $this->initFacebooks();
            } else {
                $collFacebooks = ChildFacebookQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFacebooksPartial && count($collFacebooks)) {
                        $this->initFacebooks(false);

                        foreach ($collFacebooks as $obj) {
                            if (false == $this->collFacebooks->contains($obj)) {
                                $this->collFacebooks->append($obj);
                            }
                        }

                        $this->collFacebooksPartial = true;
                    }

                    return $collFacebooks;
                }

                if ($partial && $this->collFacebooks) {
                    foreach ($this->collFacebooks as $obj) {
                        if ($obj->isNew()) {
                            $collFacebooks[] = $obj;
                        }
                    }
                }

                $this->collFacebooks = $collFacebooks;
                $this->collFacebooksPartial = false;
            }
        }

        return $this->collFacebooks;
    }

    /**
     * Sets a collection of ChildFacebook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $facebooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setFacebooks(Collection $facebooks, ConnectionInterface $con = null)
    {
        /** @var ChildFacebook[] $facebooksToDelete */
        $facebooksToDelete = $this->getFacebooks(new Criteria(), $con)->diff($facebooks);

        
        $this->facebooksScheduledForDeletion = $facebooksToDelete;

        foreach ($facebooksToDelete as $facebookRemoved) {
            $facebookRemoved->setParish(null);
        }

        $this->collFacebooks = null;
        foreach ($facebooks as $facebook) {
            $this->addFacebook($facebook);
        }

        $this->collFacebooks = $facebooks;
        $this->collFacebooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Facebook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Facebook objects.
     * @throws PropelException
     */
    public function countFacebooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFacebooksPartial && !$this->isNew();
        if (null === $this->collFacebooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFacebooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFacebooks());
            }

            $query = ChildFacebookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collFacebooks);
    }

    /**
     * Method called to associate a ChildFacebook object to this object
     * through the ChildFacebook foreign key attribute.
     *
     * @param  ChildFacebook $l ChildFacebook
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addFacebook(ChildFacebook $l)
    {
        if ($this->collFacebooks === null) {
            $this->initFacebooks();
            $this->collFacebooksPartial = true;
        }

        if (!$this->collFacebooks->contains($l)) {
            $this->doAddFacebook($l);

            if ($this->facebooksScheduledForDeletion and $this->facebooksScheduledForDeletion->contains($l)) {
                $this->facebooksScheduledForDeletion->remove($this->facebooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFacebook $facebook The ChildFacebook object to add.
     */
    protected function doAddFacebook(ChildFacebook $facebook)
    {
        $this->collFacebooks[]= $facebook;
        $facebook->setParish($this);
    }

    /**
     * @param  ChildFacebook $facebook The ChildFacebook object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeFacebook(ChildFacebook $facebook)
    {
        if ($this->getFacebooks()->contains($facebook)) {
            $pos = $this->collFacebooks->search($facebook);
            $this->collFacebooks->remove($pos);
            if (null === $this->facebooksScheduledForDeletion) {
                $this->facebooksScheduledForDeletion = clone $this->collFacebooks;
                $this->facebooksScheduledForDeletion->clear();
            }
            $this->facebooksScheduledForDeletion[]= clone $facebook;
            $facebook->setParish(null);
        }

        return $this;
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
     * If this ChildParish is new, it will return
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
                    ->filterByParish($this)
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
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setGives(Collection $gives, ConnectionInterface $con = null)
    {
        /** @var ChildGive[] $givesToDelete */
        $givesToDelete = $this->getGives(new Criteria(), $con)->diff($gives);

        
        $this->givesScheduledForDeletion = $givesToDelete;

        foreach ($givesToDelete as $giveRemoved) {
            $giveRemoved->setParish(null);
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
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collGives);
    }

    /**
     * Method called to associate a ChildGive object to this object
     * through the ChildGive foreign key attribute.
     *
     * @param  ChildGive $l ChildGive
     * @return $this|\Parish The current object (for fluent API support)
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
        $give->setParish($this);
    }

    /**
     * @param  ChildGive $give The ChildGive object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
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
            $give->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Gives from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGive[] List of ChildGive objects
     */
    public function getGivesJoinUserProfile(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGiveQuery::create(null, $criteria);
        $query->joinWith('UserProfile', $joinBehavior);

        return $this->getGives($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Gives from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
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
     * Clears out the collGiveParishCurrencies collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGiveParishCurrencies()
     */
    public function clearGiveParishCurrencies()
    {
        $this->collGiveParishCurrencies = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGiveParishCurrencies collection loaded partially.
     */
    public function resetPartialGiveParishCurrencies($v = true)
    {
        $this->collGiveParishCurrenciesPartial = $v;
    }

    /**
     * Initializes the collGiveParishCurrencies collection.
     *
     * By default this just sets the collGiveParishCurrencies collection to an empty array (like clearcollGiveParishCurrencies());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGiveParishCurrencies($overrideExisting = true)
    {
        if (null !== $this->collGiveParishCurrencies && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiveParishCurrencyTableMap::getTableMap()->getCollectionClassName();

        $this->collGiveParishCurrencies = new $collectionClassName;
        $this->collGiveParishCurrencies->setModel('\GiveParishCurrency');
    }

    /**
     * Gets an array of ChildGiveParishCurrency objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGiveParishCurrency[] List of ChildGiveParishCurrency objects
     * @throws PropelException
     */
    public function getGiveParishCurrencies(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveParishCurrenciesPartial && !$this->isNew();
        if (null === $this->collGiveParishCurrencies || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGiveParishCurrencies) {
                // return empty collection
                $this->initGiveParishCurrencies();
            } else {
                $collGiveParishCurrencies = ChildGiveParishCurrencyQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGiveParishCurrenciesPartial && count($collGiveParishCurrencies)) {
                        $this->initGiveParishCurrencies(false);

                        foreach ($collGiveParishCurrencies as $obj) {
                            if (false == $this->collGiveParishCurrencies->contains($obj)) {
                                $this->collGiveParishCurrencies->append($obj);
                            }
                        }

                        $this->collGiveParishCurrenciesPartial = true;
                    }

                    return $collGiveParishCurrencies;
                }

                if ($partial && $this->collGiveParishCurrencies) {
                    foreach ($this->collGiveParishCurrencies as $obj) {
                        if ($obj->isNew()) {
                            $collGiveParishCurrencies[] = $obj;
                        }
                    }
                }

                $this->collGiveParishCurrencies = $collGiveParishCurrencies;
                $this->collGiveParishCurrenciesPartial = false;
            }
        }

        return $this->collGiveParishCurrencies;
    }

    /**
     * Sets a collection of ChildGiveParishCurrency objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $giveParishCurrencies A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setGiveParishCurrencies(Collection $giveParishCurrencies, ConnectionInterface $con = null)
    {
        /** @var ChildGiveParishCurrency[] $giveParishCurrenciesToDelete */
        $giveParishCurrenciesToDelete = $this->getGiveParishCurrencies(new Criteria(), $con)->diff($giveParishCurrencies);

        
        $this->giveParishCurrenciesScheduledForDeletion = $giveParishCurrenciesToDelete;

        foreach ($giveParishCurrenciesToDelete as $giveParishCurrencyRemoved) {
            $giveParishCurrencyRemoved->setParish(null);
        }

        $this->collGiveParishCurrencies = null;
        foreach ($giveParishCurrencies as $giveParishCurrency) {
            $this->addGiveParishCurrency($giveParishCurrency);
        }

        $this->collGiveParishCurrencies = $giveParishCurrencies;
        $this->collGiveParishCurrenciesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GiveParishCurrency objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GiveParishCurrency objects.
     * @throws PropelException
     */
    public function countGiveParishCurrencies(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveParishCurrenciesPartial && !$this->isNew();
        if (null === $this->collGiveParishCurrencies || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGiveParishCurrencies) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGiveParishCurrencies());
            }

            $query = ChildGiveParishCurrencyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collGiveParishCurrencies);
    }

    /**
     * Method called to associate a ChildGiveParishCurrency object to this object
     * through the ChildGiveParishCurrency foreign key attribute.
     *
     * @param  ChildGiveParishCurrency $l ChildGiveParishCurrency
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addGiveParishCurrency(ChildGiveParishCurrency $l)
    {
        if ($this->collGiveParishCurrencies === null) {
            $this->initGiveParishCurrencies();
            $this->collGiveParishCurrenciesPartial = true;
        }

        if (!$this->collGiveParishCurrencies->contains($l)) {
            $this->doAddGiveParishCurrency($l);

            if ($this->giveParishCurrenciesScheduledForDeletion and $this->giveParishCurrenciesScheduledForDeletion->contains($l)) {
                $this->giveParishCurrenciesScheduledForDeletion->remove($this->giveParishCurrenciesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGiveParishCurrency $giveParishCurrency The ChildGiveParishCurrency object to add.
     */
    protected function doAddGiveParishCurrency(ChildGiveParishCurrency $giveParishCurrency)
    {
        $this->collGiveParishCurrencies[]= $giveParishCurrency;
        $giveParishCurrency->setParish($this);
    }

    /**
     * @param  ChildGiveParishCurrency $giveParishCurrency The ChildGiveParishCurrency object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeGiveParishCurrency(ChildGiveParishCurrency $giveParishCurrency)
    {
        if ($this->getGiveParishCurrencies()->contains($giveParishCurrency)) {
            $pos = $this->collGiveParishCurrencies->search($giveParishCurrency);
            $this->collGiveParishCurrencies->remove($pos);
            if (null === $this->giveParishCurrenciesScheduledForDeletion) {
                $this->giveParishCurrenciesScheduledForDeletion = clone $this->collGiveParishCurrencies;
                $this->giveParishCurrenciesScheduledForDeletion->clear();
            }
            $this->giveParishCurrenciesScheduledForDeletion[]= clone $giveParishCurrency;
            $giveParishCurrency->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related GiveParishCurrencies from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGiveParishCurrency[] List of ChildGiveParishCurrency objects
     */
    public function getGiveParishCurrenciesJoinGiveCurrency(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGiveParishCurrencyQuery::create(null, $criteria);
        $query->joinWith('GiveCurrency', $joinBehavior);

        return $this->getGiveParishCurrencies($query, $con);
    }

    /**
     * Clears out the collGiveParishMethodss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGiveParishMethodss()
     */
    public function clearGiveParishMethodss()
    {
        $this->collGiveParishMethodss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGiveParishMethodss collection loaded partially.
     */
    public function resetPartialGiveParishMethodss($v = true)
    {
        $this->collGiveParishMethodssPartial = $v;
    }

    /**
     * Initializes the collGiveParishMethodss collection.
     *
     * By default this just sets the collGiveParishMethodss collection to an empty array (like clearcollGiveParishMethodss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGiveParishMethodss($overrideExisting = true)
    {
        if (null !== $this->collGiveParishMethodss && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiveParishMethodsTableMap::getTableMap()->getCollectionClassName();

        $this->collGiveParishMethodss = new $collectionClassName;
        $this->collGiveParishMethodss->setModel('\GiveParishMethods');
    }

    /**
     * Gets an array of ChildGiveParishMethods objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGiveParishMethods[] List of ChildGiveParishMethods objects
     * @throws PropelException
     */
    public function getGiveParishMethodss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveParishMethodssPartial && !$this->isNew();
        if (null === $this->collGiveParishMethodss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGiveParishMethodss) {
                // return empty collection
                $this->initGiveParishMethodss();
            } else {
                $collGiveParishMethodss = ChildGiveParishMethodsQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGiveParishMethodssPartial && count($collGiveParishMethodss)) {
                        $this->initGiveParishMethodss(false);

                        foreach ($collGiveParishMethodss as $obj) {
                            if (false == $this->collGiveParishMethodss->contains($obj)) {
                                $this->collGiveParishMethodss->append($obj);
                            }
                        }

                        $this->collGiveParishMethodssPartial = true;
                    }

                    return $collGiveParishMethodss;
                }

                if ($partial && $this->collGiveParishMethodss) {
                    foreach ($this->collGiveParishMethodss as $obj) {
                        if ($obj->isNew()) {
                            $collGiveParishMethodss[] = $obj;
                        }
                    }
                }

                $this->collGiveParishMethodss = $collGiveParishMethodss;
                $this->collGiveParishMethodssPartial = false;
            }
        }

        return $this->collGiveParishMethodss;
    }

    /**
     * Sets a collection of ChildGiveParishMethods objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $giveParishMethodss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setGiveParishMethodss(Collection $giveParishMethodss, ConnectionInterface $con = null)
    {
        /** @var ChildGiveParishMethods[] $giveParishMethodssToDelete */
        $giveParishMethodssToDelete = $this->getGiveParishMethodss(new Criteria(), $con)->diff($giveParishMethodss);

        
        $this->giveParishMethodssScheduledForDeletion = $giveParishMethodssToDelete;

        foreach ($giveParishMethodssToDelete as $giveParishMethodsRemoved) {
            $giveParishMethodsRemoved->setParish(null);
        }

        $this->collGiveParishMethodss = null;
        foreach ($giveParishMethodss as $giveParishMethods) {
            $this->addGiveParishMethods($giveParishMethods);
        }

        $this->collGiveParishMethodss = $giveParishMethodss;
        $this->collGiveParishMethodssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GiveParishMethods objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GiveParishMethods objects.
     * @throws PropelException
     */
    public function countGiveParishMethodss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveParishMethodssPartial && !$this->isNew();
        if (null === $this->collGiveParishMethodss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGiveParishMethodss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGiveParishMethodss());
            }

            $query = ChildGiveParishMethodsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collGiveParishMethodss);
    }

    /**
     * Method called to associate a ChildGiveParishMethods object to this object
     * through the ChildGiveParishMethods foreign key attribute.
     *
     * @param  ChildGiveParishMethods $l ChildGiveParishMethods
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addGiveParishMethods(ChildGiveParishMethods $l)
    {
        if ($this->collGiveParishMethodss === null) {
            $this->initGiveParishMethodss();
            $this->collGiveParishMethodssPartial = true;
        }

        if (!$this->collGiveParishMethodss->contains($l)) {
            $this->doAddGiveParishMethods($l);

            if ($this->giveParishMethodssScheduledForDeletion and $this->giveParishMethodssScheduledForDeletion->contains($l)) {
                $this->giveParishMethodssScheduledForDeletion->remove($this->giveParishMethodssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGiveParishMethods $giveParishMethods The ChildGiveParishMethods object to add.
     */
    protected function doAddGiveParishMethods(ChildGiveParishMethods $giveParishMethods)
    {
        $this->collGiveParishMethodss[]= $giveParishMethods;
        $giveParishMethods->setParish($this);
    }

    /**
     * @param  ChildGiveParishMethods $giveParishMethods The ChildGiveParishMethods object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeGiveParishMethods(ChildGiveParishMethods $giveParishMethods)
    {
        if ($this->getGiveParishMethodss()->contains($giveParishMethods)) {
            $pos = $this->collGiveParishMethodss->search($giveParishMethods);
            $this->collGiveParishMethodss->remove($pos);
            if (null === $this->giveParishMethodssScheduledForDeletion) {
                $this->giveParishMethodssScheduledForDeletion = clone $this->collGiveParishMethodss;
                $this->giveParishMethodssScheduledForDeletion->clear();
            }
            $this->giveParishMethodssScheduledForDeletion[]= clone $giveParishMethods;
            $giveParishMethods->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related GiveParishMethodss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGiveParishMethods[] List of ChildGiveParishMethods objects
     */
    public function getGiveParishMethodssJoinGiveMethods(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGiveParishMethodsQuery::create(null, $criteria);
        $query->joinWith('GiveMethods', $joinBehavior);

        return $this->getGiveParishMethodss($query, $con);
    }

    /**
     * Clears out the collGiveTypes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGiveTypes()
     */
    public function clearGiveTypes()
    {
        $this->collGiveTypes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGiveTypes collection loaded partially.
     */
    public function resetPartialGiveTypes($v = true)
    {
        $this->collGiveTypesPartial = $v;
    }

    /**
     * Initializes the collGiveTypes collection.
     *
     * By default this just sets the collGiveTypes collection to an empty array (like clearcollGiveTypes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGiveTypes($overrideExisting = true)
    {
        if (null !== $this->collGiveTypes && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiveTypeTableMap::getTableMap()->getCollectionClassName();

        $this->collGiveTypes = new $collectionClassName;
        $this->collGiveTypes->setModel('\GiveType');
    }

    /**
     * Gets an array of ChildGiveType objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGiveType[] List of ChildGiveType objects
     * @throws PropelException
     */
    public function getGiveTypes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveTypesPartial && !$this->isNew();
        if (null === $this->collGiveTypes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGiveTypes) {
                // return empty collection
                $this->initGiveTypes();
            } else {
                $collGiveTypes = ChildGiveTypeQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGiveTypesPartial && count($collGiveTypes)) {
                        $this->initGiveTypes(false);

                        foreach ($collGiveTypes as $obj) {
                            if (false == $this->collGiveTypes->contains($obj)) {
                                $this->collGiveTypes->append($obj);
                            }
                        }

                        $this->collGiveTypesPartial = true;
                    }

                    return $collGiveTypes;
                }

                if ($partial && $this->collGiveTypes) {
                    foreach ($this->collGiveTypes as $obj) {
                        if ($obj->isNew()) {
                            $collGiveTypes[] = $obj;
                        }
                    }
                }

                $this->collGiveTypes = $collGiveTypes;
                $this->collGiveTypesPartial = false;
            }
        }

        return $this->collGiveTypes;
    }

    /**
     * Sets a collection of ChildGiveType objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $giveTypes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setGiveTypes(Collection $giveTypes, ConnectionInterface $con = null)
    {
        /** @var ChildGiveType[] $giveTypesToDelete */
        $giveTypesToDelete = $this->getGiveTypes(new Criteria(), $con)->diff($giveTypes);

        
        $this->giveTypesScheduledForDeletion = $giveTypesToDelete;

        foreach ($giveTypesToDelete as $giveTypeRemoved) {
            $giveTypeRemoved->setParish(null);
        }

        $this->collGiveTypes = null;
        foreach ($giveTypes as $giveType) {
            $this->addGiveType($giveType);
        }

        $this->collGiveTypes = $giveTypes;
        $this->collGiveTypesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GiveType objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GiveType objects.
     * @throws PropelException
     */
    public function countGiveTypes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGiveTypesPartial && !$this->isNew();
        if (null === $this->collGiveTypes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGiveTypes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGiveTypes());
            }

            $query = ChildGiveTypeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collGiveTypes);
    }

    /**
     * Method called to associate a ChildGiveType object to this object
     * through the ChildGiveType foreign key attribute.
     *
     * @param  ChildGiveType $l ChildGiveType
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addGiveType(ChildGiveType $l)
    {
        if ($this->collGiveTypes === null) {
            $this->initGiveTypes();
            $this->collGiveTypesPartial = true;
        }

        if (!$this->collGiveTypes->contains($l)) {
            $this->doAddGiveType($l);

            if ($this->giveTypesScheduledForDeletion and $this->giveTypesScheduledForDeletion->contains($l)) {
                $this->giveTypesScheduledForDeletion->remove($this->giveTypesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGiveType $giveType The ChildGiveType object to add.
     */
    protected function doAddGiveType(ChildGiveType $giveType)
    {
        $this->collGiveTypes[]= $giveType;
        $giveType->setParish($this);
    }

    /**
     * @param  ChildGiveType $giveType The ChildGiveType object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeGiveType(ChildGiveType $giveType)
    {
        if ($this->getGiveTypes()->contains($giveType)) {
            $pos = $this->collGiveTypes->search($giveType);
            $this->collGiveTypes->remove($pos);
            if (null === $this->giveTypesScheduledForDeletion) {
                $this->giveTypesScheduledForDeletion = clone $this->collGiveTypes;
                $this->giveTypesScheduledForDeletion->clear();
            }
            $this->giveTypesScheduledForDeletion[]= clone $giveType;
            $giveType->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collLetterss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addLetterss()
     */
    public function clearLetterss()
    {
        $this->collLetterss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collLetterss collection loaded partially.
     */
    public function resetPartialLetterss($v = true)
    {
        $this->collLetterssPartial = $v;
    }

    /**
     * Initializes the collLetterss collection.
     *
     * By default this just sets the collLetterss collection to an empty array (like clearcollLetterss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLetterss($overrideExisting = true)
    {
        if (null !== $this->collLetterss && !$overrideExisting) {
            return;
        }

        $collectionClassName = LettersTableMap::getTableMap()->getCollectionClassName();

        $this->collLetterss = new $collectionClassName;
        $this->collLetterss->setModel('\Letters');
    }

    /**
     * Gets an array of ChildLetters objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildLetters[] List of ChildLetters objects
     * @throws PropelException
     */
    public function getLetterss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collLetterssPartial && !$this->isNew();
        if (null === $this->collLetterss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLetterss) {
                // return empty collection
                $this->initLetterss();
            } else {
                $collLetterss = ChildLettersQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collLetterssPartial && count($collLetterss)) {
                        $this->initLetterss(false);

                        foreach ($collLetterss as $obj) {
                            if (false == $this->collLetterss->contains($obj)) {
                                $this->collLetterss->append($obj);
                            }
                        }

                        $this->collLetterssPartial = true;
                    }

                    return $collLetterss;
                }

                if ($partial && $this->collLetterss) {
                    foreach ($this->collLetterss as $obj) {
                        if ($obj->isNew()) {
                            $collLetterss[] = $obj;
                        }
                    }
                }

                $this->collLetterss = $collLetterss;
                $this->collLetterssPartial = false;
            }
        }

        return $this->collLetterss;
    }

    /**
     * Sets a collection of ChildLetters objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $letterss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setLetterss(Collection $letterss, ConnectionInterface $con = null)
    {
        /** @var ChildLetters[] $letterssToDelete */
        $letterssToDelete = $this->getLetterss(new Criteria(), $con)->diff($letterss);

        
        $this->letterssScheduledForDeletion = $letterssToDelete;

        foreach ($letterssToDelete as $lettersRemoved) {
            $lettersRemoved->setParish(null);
        }

        $this->collLetterss = null;
        foreach ($letterss as $letters) {
            $this->addLetters($letters);
        }

        $this->collLetterss = $letterss;
        $this->collLetterssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Letters objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Letters objects.
     * @throws PropelException
     */
    public function countLetterss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collLetterssPartial && !$this->isNew();
        if (null === $this->collLetterss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLetterss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getLetterss());
            }

            $query = ChildLettersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collLetterss);
    }

    /**
     * Method called to associate a ChildLetters object to this object
     * through the ChildLetters foreign key attribute.
     *
     * @param  ChildLetters $l ChildLetters
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addLetters(ChildLetters $l)
    {
        if ($this->collLetterss === null) {
            $this->initLetterss();
            $this->collLetterssPartial = true;
        }

        if (!$this->collLetterss->contains($l)) {
            $this->doAddLetters($l);

            if ($this->letterssScheduledForDeletion and $this->letterssScheduledForDeletion->contains($l)) {
                $this->letterssScheduledForDeletion->remove($this->letterssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildLetters $letters The ChildLetters object to add.
     */
    protected function doAddLetters(ChildLetters $letters)
    {
        $this->collLetterss[]= $letters;
        $letters->setParish($this);
    }

    /**
     * @param  ChildLetters $letters The ChildLetters object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeLetters(ChildLetters $letters)
    {
        if ($this->getLetterss()->contains($letters)) {
            $pos = $this->collLetterss->search($letters);
            $this->collLetterss->remove($pos);
            if (null === $this->letterssScheduledForDeletion) {
                $this->letterssScheduledForDeletion = clone $this->collLetterss;
                $this->letterssScheduledForDeletion->clear();
            }
            $this->letterssScheduledForDeletion[]= clone $letters;
            $letters->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Letterss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildLetters[] List of ChildLetters objects
     */
    public function getLetterssJoinLetterType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildLettersQuery::create(null, $criteria);
        $query->joinWith('LetterType', $joinBehavior);

        return $this->getLetterss($query, $con);
    }

    /**
     * Clears out the collLiveStreams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addLiveStreams()
     */
    public function clearLiveStreams()
    {
        $this->collLiveStreams = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collLiveStreams collection loaded partially.
     */
    public function resetPartialLiveStreams($v = true)
    {
        $this->collLiveStreamsPartial = $v;
    }

    /**
     * Initializes the collLiveStreams collection.
     *
     * By default this just sets the collLiveStreams collection to an empty array (like clearcollLiveStreams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLiveStreams($overrideExisting = true)
    {
        if (null !== $this->collLiveStreams && !$overrideExisting) {
            return;
        }

        $collectionClassName = LiveStreamTableMap::getTableMap()->getCollectionClassName();

        $this->collLiveStreams = new $collectionClassName;
        $this->collLiveStreams->setModel('\LiveStream');
    }

    /**
     * Gets an array of ChildLiveStream objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildLiveStream[] List of ChildLiveStream objects
     * @throws PropelException
     */
    public function getLiveStreams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collLiveStreamsPartial && !$this->isNew();
        if (null === $this->collLiveStreams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLiveStreams) {
                // return empty collection
                $this->initLiveStreams();
            } else {
                $collLiveStreams = ChildLiveStreamQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collLiveStreamsPartial && count($collLiveStreams)) {
                        $this->initLiveStreams(false);

                        foreach ($collLiveStreams as $obj) {
                            if (false == $this->collLiveStreams->contains($obj)) {
                                $this->collLiveStreams->append($obj);
                            }
                        }

                        $this->collLiveStreamsPartial = true;
                    }

                    return $collLiveStreams;
                }

                if ($partial && $this->collLiveStreams) {
                    foreach ($this->collLiveStreams as $obj) {
                        if ($obj->isNew()) {
                            $collLiveStreams[] = $obj;
                        }
                    }
                }

                $this->collLiveStreams = $collLiveStreams;
                $this->collLiveStreamsPartial = false;
            }
        }

        return $this->collLiveStreams;
    }

    /**
     * Sets a collection of ChildLiveStream objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $liveStreams A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setLiveStreams(Collection $liveStreams, ConnectionInterface $con = null)
    {
        /** @var ChildLiveStream[] $liveStreamsToDelete */
        $liveStreamsToDelete = $this->getLiveStreams(new Criteria(), $con)->diff($liveStreams);

        
        $this->liveStreamsScheduledForDeletion = $liveStreamsToDelete;

        foreach ($liveStreamsToDelete as $liveStreamRemoved) {
            $liveStreamRemoved->setParish(null);
        }

        $this->collLiveStreams = null;
        foreach ($liveStreams as $liveStream) {
            $this->addLiveStream($liveStream);
        }

        $this->collLiveStreams = $liveStreams;
        $this->collLiveStreamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related LiveStream objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related LiveStream objects.
     * @throws PropelException
     */
    public function countLiveStreams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collLiveStreamsPartial && !$this->isNew();
        if (null === $this->collLiveStreams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLiveStreams) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getLiveStreams());
            }

            $query = ChildLiveStreamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collLiveStreams);
    }

    /**
     * Method called to associate a ChildLiveStream object to this object
     * through the ChildLiveStream foreign key attribute.
     *
     * @param  ChildLiveStream $l ChildLiveStream
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addLiveStream(ChildLiveStream $l)
    {
        if ($this->collLiveStreams === null) {
            $this->initLiveStreams();
            $this->collLiveStreamsPartial = true;
        }

        if (!$this->collLiveStreams->contains($l)) {
            $this->doAddLiveStream($l);

            if ($this->liveStreamsScheduledForDeletion and $this->liveStreamsScheduledForDeletion->contains($l)) {
                $this->liveStreamsScheduledForDeletion->remove($this->liveStreamsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildLiveStream $liveStream The ChildLiveStream object to add.
     */
    protected function doAddLiveStream(ChildLiveStream $liveStream)
    {
        $this->collLiveStreams[]= $liveStream;
        $liveStream->setParish($this);
    }

    /**
     * @param  ChildLiveStream $liveStream The ChildLiveStream object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeLiveStream(ChildLiveStream $liveStream)
    {
        if ($this->getLiveStreams()->contains($liveStream)) {
            $pos = $this->collLiveStreams->search($liveStream);
            $this->collLiveStreams->remove($pos);
            if (null === $this->liveStreamsScheduledForDeletion) {
                $this->liveStreamsScheduledForDeletion = clone $this->collLiveStreams;
                $this->liveStreamsScheduledForDeletion->clear();
            }
            $this->liveStreamsScheduledForDeletion[]= clone $liveStream;
            $liveStream->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collMedias collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMedias()
     */
    public function clearMedias()
    {
        $this->collMedias = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMedias collection loaded partially.
     */
    public function resetPartialMedias($v = true)
    {
        $this->collMediasPartial = $v;
    }

    /**
     * Initializes the collMedias collection.
     *
     * By default this just sets the collMedias collection to an empty array (like clearcollMedias());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMedias($overrideExisting = true)
    {
        if (null !== $this->collMedias && !$overrideExisting) {
            return;
        }

        $collectionClassName = MediaTableMap::getTableMap()->getCollectionClassName();

        $this->collMedias = new $collectionClassName;
        $this->collMedias->setModel('\Media');
    }

    /**
     * Gets an array of ChildMedia objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMedia[] List of ChildMedia objects
     * @throws PropelException
     */
    public function getMedias(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMediasPartial && !$this->isNew();
        if (null === $this->collMedias || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMedias) {
                // return empty collection
                $this->initMedias();
            } else {
                $collMedias = ChildMediaQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMediasPartial && count($collMedias)) {
                        $this->initMedias(false);

                        foreach ($collMedias as $obj) {
                            if (false == $this->collMedias->contains($obj)) {
                                $this->collMedias->append($obj);
                            }
                        }

                        $this->collMediasPartial = true;
                    }

                    return $collMedias;
                }

                if ($partial && $this->collMedias) {
                    foreach ($this->collMedias as $obj) {
                        if ($obj->isNew()) {
                            $collMedias[] = $obj;
                        }
                    }
                }

                $this->collMedias = $collMedias;
                $this->collMediasPartial = false;
            }
        }

        return $this->collMedias;
    }

    /**
     * Sets a collection of ChildMedia objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $medias A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setMedias(Collection $medias, ConnectionInterface $con = null)
    {
        /** @var ChildMedia[] $mediasToDelete */
        $mediasToDelete = $this->getMedias(new Criteria(), $con)->diff($medias);

        
        $this->mediasScheduledForDeletion = $mediasToDelete;

        foreach ($mediasToDelete as $mediaRemoved) {
            $mediaRemoved->setParish(null);
        }

        $this->collMedias = null;
        foreach ($medias as $media) {
            $this->addMedia($media);
        }

        $this->collMedias = $medias;
        $this->collMediasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Media objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Media objects.
     * @throws PropelException
     */
    public function countMedias(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMediasPartial && !$this->isNew();
        if (null === $this->collMedias || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMedias) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMedias());
            }

            $query = ChildMediaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collMedias);
    }

    /**
     * Method called to associate a ChildMedia object to this object
     * through the ChildMedia foreign key attribute.
     *
     * @param  ChildMedia $l ChildMedia
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addMedia(ChildMedia $l)
    {
        if ($this->collMedias === null) {
            $this->initMedias();
            $this->collMediasPartial = true;
        }

        if (!$this->collMedias->contains($l)) {
            $this->doAddMedia($l);

            if ($this->mediasScheduledForDeletion and $this->mediasScheduledForDeletion->contains($l)) {
                $this->mediasScheduledForDeletion->remove($this->mediasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMedia $media The ChildMedia object to add.
     */
    protected function doAddMedia(ChildMedia $media)
    {
        $this->collMedias[]= $media;
        $media->setParish($this);
    }

    /**
     * @param  ChildMedia $media The ChildMedia object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeMedia(ChildMedia $media)
    {
        if ($this->getMedias()->contains($media)) {
            $pos = $this->collMedias->search($media);
            $this->collMedias->remove($pos);
            if (null === $this->mediasScheduledForDeletion) {
                $this->mediasScheduledForDeletion = clone $this->collMedias;
                $this->mediasScheduledForDeletion->clear();
            }
            $this->mediasScheduledForDeletion[]= clone $media;
            $media->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Medias from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMedia[] List of ChildMedia objects
     */
    public function getMediasJoinMediaCategories(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMediaQuery::create(null, $criteria);
        $query->joinWith('MediaCategories', $joinBehavior);

        return $this->getMedias($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related Medias from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMedia[] List of ChildMedia objects
     */
    public function getMediasJoinMediaType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMediaQuery::create(null, $criteria);
        $query->joinWith('MediaType', $joinBehavior);

        return $this->getMedias($query, $con);
    }

    /**
     * Clears out the collMinistries collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMinistries()
     */
    public function clearMinistries()
    {
        $this->collMinistries = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMinistries collection loaded partially.
     */
    public function resetPartialMinistries($v = true)
    {
        $this->collMinistriesPartial = $v;
    }

    /**
     * Initializes the collMinistries collection.
     *
     * By default this just sets the collMinistries collection to an empty array (like clearcollMinistries());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMinistries($overrideExisting = true)
    {
        if (null !== $this->collMinistries && !$overrideExisting) {
            return;
        }

        $collectionClassName = MinistryTableMap::getTableMap()->getCollectionClassName();

        $this->collMinistries = new $collectionClassName;
        $this->collMinistries->setModel('\Ministry');
    }

    /**
     * Gets an array of ChildMinistry objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMinistry[] List of ChildMinistry objects
     * @throws PropelException
     */
    public function getMinistries(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMinistriesPartial && !$this->isNew();
        if (null === $this->collMinistries || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMinistries) {
                // return empty collection
                $this->initMinistries();
            } else {
                $collMinistries = ChildMinistryQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMinistriesPartial && count($collMinistries)) {
                        $this->initMinistries(false);

                        foreach ($collMinistries as $obj) {
                            if (false == $this->collMinistries->contains($obj)) {
                                $this->collMinistries->append($obj);
                            }
                        }

                        $this->collMinistriesPartial = true;
                    }

                    return $collMinistries;
                }

                if ($partial && $this->collMinistries) {
                    foreach ($this->collMinistries as $obj) {
                        if ($obj->isNew()) {
                            $collMinistries[] = $obj;
                        }
                    }
                }

                $this->collMinistries = $collMinistries;
                $this->collMinistriesPartial = false;
            }
        }

        return $this->collMinistries;
    }

    /**
     * Sets a collection of ChildMinistry objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ministries A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setMinistries(Collection $ministries, ConnectionInterface $con = null)
    {
        /** @var ChildMinistry[] $ministriesToDelete */
        $ministriesToDelete = $this->getMinistries(new Criteria(), $con)->diff($ministries);

        
        $this->ministriesScheduledForDeletion = $ministriesToDelete;

        foreach ($ministriesToDelete as $ministryRemoved) {
            $ministryRemoved->setParish(null);
        }

        $this->collMinistries = null;
        foreach ($ministries as $ministry) {
            $this->addMinistry($ministry);
        }

        $this->collMinistries = $ministries;
        $this->collMinistriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Ministry objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Ministry objects.
     * @throws PropelException
     */
    public function countMinistries(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMinistriesPartial && !$this->isNew();
        if (null === $this->collMinistries || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMinistries) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMinistries());
            }

            $query = ChildMinistryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collMinistries);
    }

    /**
     * Method called to associate a ChildMinistry object to this object
     * through the ChildMinistry foreign key attribute.
     *
     * @param  ChildMinistry $l ChildMinistry
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addMinistry(ChildMinistry $l)
    {
        if ($this->collMinistries === null) {
            $this->initMinistries();
            $this->collMinistriesPartial = true;
        }

        if (!$this->collMinistries->contains($l)) {
            $this->doAddMinistry($l);

            if ($this->ministriesScheduledForDeletion and $this->ministriesScheduledForDeletion->contains($l)) {
                $this->ministriesScheduledForDeletion->remove($this->ministriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMinistry $ministry The ChildMinistry object to add.
     */
    protected function doAddMinistry(ChildMinistry $ministry)
    {
        $this->collMinistries[]= $ministry;
        $ministry->setParish($this);
    }

    /**
     * @param  ChildMinistry $ministry The ChildMinistry object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeMinistry(ChildMinistry $ministry)
    {
        if ($this->getMinistries()->contains($ministry)) {
            $pos = $this->collMinistries->search($ministry);
            $this->collMinistries->remove($pos);
            if (null === $this->ministriesScheduledForDeletion) {
                $this->ministriesScheduledForDeletion = clone $this->collMinistries;
                $this->ministriesScheduledForDeletion->clear();
            }
            $this->ministriesScheduledForDeletion[]= clone $ministry;
            $ministry->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collParishSegments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParishSegments()
     */
    public function clearParishSegments()
    {
        $this->collParishSegments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParishSegments collection loaded partially.
     */
    public function resetPartialParishSegments($v = true)
    {
        $this->collParishSegmentsPartial = $v;
    }

    /**
     * Initializes the collParishSegments collection.
     *
     * By default this just sets the collParishSegments collection to an empty array (like clearcollParishSegments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParishSegments($overrideExisting = true)
    {
        if (null !== $this->collParishSegments && !$overrideExisting) {
            return;
        }

        $collectionClassName = ParishSegmentTableMap::getTableMap()->getCollectionClassName();

        $this->collParishSegments = new $collectionClassName;
        $this->collParishSegments->setModel('\ParishSegment');
    }

    /**
     * Gets an array of ChildParishSegment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParishSegment[] List of ChildParishSegment objects
     * @throws PropelException
     */
    public function getParishSegments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParishSegmentsPartial && !$this->isNew();
        if (null === $this->collParishSegments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParishSegments) {
                // return empty collection
                $this->initParishSegments();
            } else {
                $collParishSegments = ChildParishSegmentQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParishSegmentsPartial && count($collParishSegments)) {
                        $this->initParishSegments(false);

                        foreach ($collParishSegments as $obj) {
                            if (false == $this->collParishSegments->contains($obj)) {
                                $this->collParishSegments->append($obj);
                            }
                        }

                        $this->collParishSegmentsPartial = true;
                    }

                    return $collParishSegments;
                }

                if ($partial && $this->collParishSegments) {
                    foreach ($this->collParishSegments as $obj) {
                        if ($obj->isNew()) {
                            $collParishSegments[] = $obj;
                        }
                    }
                }

                $this->collParishSegments = $collParishSegments;
                $this->collParishSegmentsPartial = false;
            }
        }

        return $this->collParishSegments;
    }

    /**
     * Sets a collection of ChildParishSegment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $parishSegments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setParishSegments(Collection $parishSegments, ConnectionInterface $con = null)
    {
        /** @var ChildParishSegment[] $parishSegmentsToDelete */
        $parishSegmentsToDelete = $this->getParishSegments(new Criteria(), $con)->diff($parishSegments);

        
        $this->parishSegmentsScheduledForDeletion = $parishSegmentsToDelete;

        foreach ($parishSegmentsToDelete as $parishSegmentRemoved) {
            $parishSegmentRemoved->setParish(null);
        }

        $this->collParishSegments = null;
        foreach ($parishSegments as $parishSegment) {
            $this->addParishSegment($parishSegment);
        }

        $this->collParishSegments = $parishSegments;
        $this->collParishSegmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ParishSegment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ParishSegment objects.
     * @throws PropelException
     */
    public function countParishSegments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParishSegmentsPartial && !$this->isNew();
        if (null === $this->collParishSegments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParishSegments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParishSegments());
            }

            $query = ChildParishSegmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collParishSegments);
    }

    /**
     * Method called to associate a ChildParishSegment object to this object
     * through the ChildParishSegment foreign key attribute.
     *
     * @param  ChildParishSegment $l ChildParishSegment
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addParishSegment(ChildParishSegment $l)
    {
        if ($this->collParishSegments === null) {
            $this->initParishSegments();
            $this->collParishSegmentsPartial = true;
        }

        if (!$this->collParishSegments->contains($l)) {
            $this->doAddParishSegment($l);

            if ($this->parishSegmentsScheduledForDeletion and $this->parishSegmentsScheduledForDeletion->contains($l)) {
                $this->parishSegmentsScheduledForDeletion->remove($this->parishSegmentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildParishSegment $parishSegment The ChildParishSegment object to add.
     */
    protected function doAddParishSegment(ChildParishSegment $parishSegment)
    {
        $this->collParishSegments[]= $parishSegment;
        $parishSegment->setParish($this);
    }

    /**
     * @param  ChildParishSegment $parishSegment The ChildParishSegment object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeParishSegment(ChildParishSegment $parishSegment)
    {
        if ($this->getParishSegments()->contains($parishSegment)) {
            $pos = $this->collParishSegments->search($parishSegment);
            $this->collParishSegments->remove($pos);
            if (null === $this->parishSegmentsScheduledForDeletion) {
                $this->parishSegmentsScheduledForDeletion = clone $this->collParishSegments;
                $this->parishSegmentsScheduledForDeletion->clear();
            }
            $this->parishSegmentsScheduledForDeletion[]= clone $parishSegment;
            $parishSegment->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related ParishSegments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParishSegment[] List of ChildParishSegment objects
     */
    public function getParishSegmentsJoinSegment(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParishSegmentQuery::create(null, $criteria);
        $query->joinWith('Segment', $joinBehavior);

        return $this->getParishSegments($query, $con);
    }

    /**
     * Clears out the collTwitters collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTwitters()
     */
    public function clearTwitters()
    {
        $this->collTwitters = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTwitters collection loaded partially.
     */
    public function resetPartialTwitters($v = true)
    {
        $this->collTwittersPartial = $v;
    }

    /**
     * Initializes the collTwitters collection.
     *
     * By default this just sets the collTwitters collection to an empty array (like clearcollTwitters());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTwitters($overrideExisting = true)
    {
        if (null !== $this->collTwitters && !$overrideExisting) {
            return;
        }

        $collectionClassName = TwitterTableMap::getTableMap()->getCollectionClassName();

        $this->collTwitters = new $collectionClassName;
        $this->collTwitters->setModel('\Twitter');
    }

    /**
     * Gets an array of ChildTwitter objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTwitter[] List of ChildTwitter objects
     * @throws PropelException
     */
    public function getTwitters(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTwittersPartial && !$this->isNew();
        if (null === $this->collTwitters || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTwitters) {
                // return empty collection
                $this->initTwitters();
            } else {
                $collTwitters = ChildTwitterQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTwittersPartial && count($collTwitters)) {
                        $this->initTwitters(false);

                        foreach ($collTwitters as $obj) {
                            if (false == $this->collTwitters->contains($obj)) {
                                $this->collTwitters->append($obj);
                            }
                        }

                        $this->collTwittersPartial = true;
                    }

                    return $collTwitters;
                }

                if ($partial && $this->collTwitters) {
                    foreach ($this->collTwitters as $obj) {
                        if ($obj->isNew()) {
                            $collTwitters[] = $obj;
                        }
                    }
                }

                $this->collTwitters = $collTwitters;
                $this->collTwittersPartial = false;
            }
        }

        return $this->collTwitters;
    }

    /**
     * Sets a collection of ChildTwitter objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $twitters A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setTwitters(Collection $twitters, ConnectionInterface $con = null)
    {
        /** @var ChildTwitter[] $twittersToDelete */
        $twittersToDelete = $this->getTwitters(new Criteria(), $con)->diff($twitters);

        
        $this->twittersScheduledForDeletion = $twittersToDelete;

        foreach ($twittersToDelete as $twitterRemoved) {
            $twitterRemoved->setParish(null);
        }

        $this->collTwitters = null;
        foreach ($twitters as $twitter) {
            $this->addTwitter($twitter);
        }

        $this->collTwitters = $twitters;
        $this->collTwittersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Twitter objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Twitter objects.
     * @throws PropelException
     */
    public function countTwitters(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTwittersPartial && !$this->isNew();
        if (null === $this->collTwitters || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTwitters) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTwitters());
            }

            $query = ChildTwitterQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collTwitters);
    }

    /**
     * Method called to associate a ChildTwitter object to this object
     * through the ChildTwitter foreign key attribute.
     *
     * @param  ChildTwitter $l ChildTwitter
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addTwitter(ChildTwitter $l)
    {
        if ($this->collTwitters === null) {
            $this->initTwitters();
            $this->collTwittersPartial = true;
        }

        if (!$this->collTwitters->contains($l)) {
            $this->doAddTwitter($l);

            if ($this->twittersScheduledForDeletion and $this->twittersScheduledForDeletion->contains($l)) {
                $this->twittersScheduledForDeletion->remove($this->twittersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTwitter $twitter The ChildTwitter object to add.
     */
    protected function doAddTwitter(ChildTwitter $twitter)
    {
        $this->collTwitters[]= $twitter;
        $twitter->setParish($this);
    }

    /**
     * @param  ChildTwitter $twitter The ChildTwitter object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeTwitter(ChildTwitter $twitter)
    {
        if ($this->getTwitters()->contains($twitter)) {
            $pos = $this->collTwitters->search($twitter);
            $this->collTwitters->remove($pos);
            if (null === $this->twittersScheduledForDeletion) {
                $this->twittersScheduledForDeletion = clone $this->collTwitters;
                $this->twittersScheduledForDeletion->clear();
            }
            $this->twittersScheduledForDeletion[]= clone $twitter;
            $twitter->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserFamilies collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserFamilies()
     */
    public function clearUserFamilies()
    {
        $this->collUserFamilies = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserFamilies collection loaded partially.
     */
    public function resetPartialUserFamilies($v = true)
    {
        $this->collUserFamiliesPartial = $v;
    }

    /**
     * Initializes the collUserFamilies collection.
     *
     * By default this just sets the collUserFamilies collection to an empty array (like clearcollUserFamilies());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserFamilies($overrideExisting = true)
    {
        if (null !== $this->collUserFamilies && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserFamilyTableMap::getTableMap()->getCollectionClassName();

        $this->collUserFamilies = new $collectionClassName;
        $this->collUserFamilies->setModel('\UserFamily');
    }

    /**
     * Gets an array of ChildUserFamily objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserFamily[] List of ChildUserFamily objects
     * @throws PropelException
     */
    public function getUserFamilies(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFamiliesPartial && !$this->isNew();
        if (null === $this->collUserFamilies || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserFamilies) {
                // return empty collection
                $this->initUserFamilies();
            } else {
                $collUserFamilies = ChildUserFamilyQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserFamiliesPartial && count($collUserFamilies)) {
                        $this->initUserFamilies(false);

                        foreach ($collUserFamilies as $obj) {
                            if (false == $this->collUserFamilies->contains($obj)) {
                                $this->collUserFamilies->append($obj);
                            }
                        }

                        $this->collUserFamiliesPartial = true;
                    }

                    return $collUserFamilies;
                }

                if ($partial && $this->collUserFamilies) {
                    foreach ($this->collUserFamilies as $obj) {
                        if ($obj->isNew()) {
                            $collUserFamilies[] = $obj;
                        }
                    }
                }

                $this->collUserFamilies = $collUserFamilies;
                $this->collUserFamiliesPartial = false;
            }
        }

        return $this->collUserFamilies;
    }

    /**
     * Sets a collection of ChildUserFamily objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userFamilies A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setUserFamilies(Collection $userFamilies, ConnectionInterface $con = null)
    {
        /** @var ChildUserFamily[] $userFamiliesToDelete */
        $userFamiliesToDelete = $this->getUserFamilies(new Criteria(), $con)->diff($userFamilies);

        
        $this->userFamiliesScheduledForDeletion = $userFamiliesToDelete;

        foreach ($userFamiliesToDelete as $userFamilyRemoved) {
            $userFamilyRemoved->setParish(null);
        }

        $this->collUserFamilies = null;
        foreach ($userFamilies as $userFamily) {
            $this->addUserFamily($userFamily);
        }

        $this->collUserFamilies = $userFamilies;
        $this->collUserFamiliesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserFamily objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserFamily objects.
     * @throws PropelException
     */
    public function countUserFamilies(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFamiliesPartial && !$this->isNew();
        if (null === $this->collUserFamilies || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserFamilies) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserFamilies());
            }

            $query = ChildUserFamilyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collUserFamilies);
    }

    /**
     * Method called to associate a ChildUserFamily object to this object
     * through the ChildUserFamily foreign key attribute.
     *
     * @param  ChildUserFamily $l ChildUserFamily
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addUserFamily(ChildUserFamily $l)
    {
        if ($this->collUserFamilies === null) {
            $this->initUserFamilies();
            $this->collUserFamiliesPartial = true;
        }

        if (!$this->collUserFamilies->contains($l)) {
            $this->doAddUserFamily($l);

            if ($this->userFamiliesScheduledForDeletion and $this->userFamiliesScheduledForDeletion->contains($l)) {
                $this->userFamiliesScheduledForDeletion->remove($this->userFamiliesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserFamily $userFamily The ChildUserFamily object to add.
     */
    protected function doAddUserFamily(ChildUserFamily $userFamily)
    {
        $this->collUserFamilies[]= $userFamily;
        $userFamily->setParish($this);
    }

    /**
     * @param  ChildUserFamily $userFamily The ChildUserFamily object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeUserFamily(ChildUserFamily $userFamily)
    {
        if ($this->getUserFamilies()->contains($userFamily)) {
            $pos = $this->collUserFamilies->search($userFamily);
            $this->collUserFamilies->remove($pos);
            if (null === $this->userFamiliesScheduledForDeletion) {
                $this->userFamiliesScheduledForDeletion = clone $this->collUserFamilies;
                $this->userFamiliesScheduledForDeletion->clear();
            }
            $this->userFamiliesScheduledForDeletion[]= clone $userFamily;
            $userFamily->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserLogins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserLogins()
     */
    public function clearUserLogins()
    {
        $this->collUserLogins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserLogins collection loaded partially.
     */
    public function resetPartialUserLogins($v = true)
    {
        $this->collUserLoginsPartial = $v;
    }

    /**
     * Initializes the collUserLogins collection.
     *
     * By default this just sets the collUserLogins collection to an empty array (like clearcollUserLogins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserLogins($overrideExisting = true)
    {
        if (null !== $this->collUserLogins && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserLoginTableMap::getTableMap()->getCollectionClassName();

        $this->collUserLogins = new $collectionClassName;
        $this->collUserLogins->setModel('\UserLogin');
    }

    /**
     * Gets an array of ChildUserLogin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserLogin[] List of ChildUserLogin objects
     * @throws PropelException
     */
    public function getUserLogins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserLoginsPartial && !$this->isNew();
        if (null === $this->collUserLogins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserLogins) {
                // return empty collection
                $this->initUserLogins();
            } else {
                $collUserLogins = ChildUserLoginQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserLoginsPartial && count($collUserLogins)) {
                        $this->initUserLogins(false);

                        foreach ($collUserLogins as $obj) {
                            if (false == $this->collUserLogins->contains($obj)) {
                                $this->collUserLogins->append($obj);
                            }
                        }

                        $this->collUserLoginsPartial = true;
                    }

                    return $collUserLogins;
                }

                if ($partial && $this->collUserLogins) {
                    foreach ($this->collUserLogins as $obj) {
                        if ($obj->isNew()) {
                            $collUserLogins[] = $obj;
                        }
                    }
                }

                $this->collUserLogins = $collUserLogins;
                $this->collUserLoginsPartial = false;
            }
        }

        return $this->collUserLogins;
    }

    /**
     * Sets a collection of ChildUserLogin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userLogins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setUserLogins(Collection $userLogins, ConnectionInterface $con = null)
    {
        /** @var ChildUserLogin[] $userLoginsToDelete */
        $userLoginsToDelete = $this->getUserLogins(new Criteria(), $con)->diff($userLogins);

        
        $this->userLoginsScheduledForDeletion = $userLoginsToDelete;

        foreach ($userLoginsToDelete as $userLoginRemoved) {
            $userLoginRemoved->setParish(null);
        }

        $this->collUserLogins = null;
        foreach ($userLogins as $userLogin) {
            $this->addUserLogin($userLogin);
        }

        $this->collUserLogins = $userLogins;
        $this->collUserLoginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserLogin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserLogin objects.
     * @throws PropelException
     */
    public function countUserLogins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserLoginsPartial && !$this->isNew();
        if (null === $this->collUserLogins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserLogins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserLogins());
            }

            $query = ChildUserLoginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collUserLogins);
    }

    /**
     * Method called to associate a ChildUserLogin object to this object
     * through the ChildUserLogin foreign key attribute.
     *
     * @param  ChildUserLogin $l ChildUserLogin
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addUserLogin(ChildUserLogin $l)
    {
        if ($this->collUserLogins === null) {
            $this->initUserLogins();
            $this->collUserLoginsPartial = true;
        }

        if (!$this->collUserLogins->contains($l)) {
            $this->doAddUserLogin($l);

            if ($this->userLoginsScheduledForDeletion and $this->userLoginsScheduledForDeletion->contains($l)) {
                $this->userLoginsScheduledForDeletion->remove($this->userLoginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserLogin $userLogin The ChildUserLogin object to add.
     */
    protected function doAddUserLogin(ChildUserLogin $userLogin)
    {
        $this->collUserLogins[]= $userLogin;
        $userLogin->setParish($this);
    }

    /**
     * @param  ChildUserLogin $userLogin The ChildUserLogin object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeUserLogin(ChildUserLogin $userLogin)
    {
        if ($this->getUserLogins()->contains($userLogin)) {
            $pos = $this->collUserLogins->search($userLogin);
            $this->collUserLogins->remove($pos);
            if (null === $this->userLoginsScheduledForDeletion) {
                $this->userLoginsScheduledForDeletion = clone $this->collUserLogins;
                $this->userLoginsScheduledForDeletion->clear();
            }
            $this->userLoginsScheduledForDeletion[]= clone $userLogin;
            $userLogin->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related UserLogins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserLogin[] List of ChildUserLogin objects
     */
    public function getUserLoginsJoinRoles(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserLoginQuery::create(null, $criteria);
        $query->joinWith('Roles', $joinBehavior);

        return $this->getUserLogins($query, $con);
    }

    /**
     * Clears out the collUserProfiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserProfiles()
     */
    public function clearUserProfiles()
    {
        $this->collUserProfiles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserProfiles collection loaded partially.
     */
    public function resetPartialUserProfiles($v = true)
    {
        $this->collUserProfilesPartial = $v;
    }

    /**
     * Initializes the collUserProfiles collection.
     *
     * By default this just sets the collUserProfiles collection to an empty array (like clearcollUserProfiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserProfiles($overrideExisting = true)
    {
        if (null !== $this->collUserProfiles && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserProfileTableMap::getTableMap()->getCollectionClassName();

        $this->collUserProfiles = new $collectionClassName;
        $this->collUserProfiles->setModel('\UserProfile');
    }

    /**
     * Gets an array of ChildUserProfile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserProfile[] List of ChildUserProfile objects
     * @throws PropelException
     */
    public function getUserProfiles(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserProfilesPartial && !$this->isNew();
        if (null === $this->collUserProfiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserProfiles) {
                // return empty collection
                $this->initUserProfiles();
            } else {
                $collUserProfiles = ChildUserProfileQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserProfilesPartial && count($collUserProfiles)) {
                        $this->initUserProfiles(false);

                        foreach ($collUserProfiles as $obj) {
                            if (false == $this->collUserProfiles->contains($obj)) {
                                $this->collUserProfiles->append($obj);
                            }
                        }

                        $this->collUserProfilesPartial = true;
                    }

                    return $collUserProfiles;
                }

                if ($partial && $this->collUserProfiles) {
                    foreach ($this->collUserProfiles as $obj) {
                        if ($obj->isNew()) {
                            $collUserProfiles[] = $obj;
                        }
                    }
                }

                $this->collUserProfiles = $collUserProfiles;
                $this->collUserProfilesPartial = false;
            }
        }

        return $this->collUserProfiles;
    }

    /**
     * Sets a collection of ChildUserProfile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userProfiles A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setUserProfiles(Collection $userProfiles, ConnectionInterface $con = null)
    {
        /** @var ChildUserProfile[] $userProfilesToDelete */
        $userProfilesToDelete = $this->getUserProfiles(new Criteria(), $con)->diff($userProfiles);

        
        $this->userProfilesScheduledForDeletion = $userProfilesToDelete;

        foreach ($userProfilesToDelete as $userProfileRemoved) {
            $userProfileRemoved->setParish(null);
        }

        $this->collUserProfiles = null;
        foreach ($userProfiles as $userProfile) {
            $this->addUserProfile($userProfile);
        }

        $this->collUserProfiles = $userProfiles;
        $this->collUserProfilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserProfile objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserProfile objects.
     * @throws PropelException
     */
    public function countUserProfiles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserProfilesPartial && !$this->isNew();
        if (null === $this->collUserProfiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserProfiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserProfiles());
            }

            $query = ChildUserProfileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collUserProfiles);
    }

    /**
     * Method called to associate a ChildUserProfile object to this object
     * through the ChildUserProfile foreign key attribute.
     *
     * @param  ChildUserProfile $l ChildUserProfile
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addUserProfile(ChildUserProfile $l)
    {
        if ($this->collUserProfiles === null) {
            $this->initUserProfiles();
            $this->collUserProfilesPartial = true;
        }

        if (!$this->collUserProfiles->contains($l)) {
            $this->doAddUserProfile($l);

            if ($this->userProfilesScheduledForDeletion and $this->userProfilesScheduledForDeletion->contains($l)) {
                $this->userProfilesScheduledForDeletion->remove($this->userProfilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserProfile $userProfile The ChildUserProfile object to add.
     */
    protected function doAddUserProfile(ChildUserProfile $userProfile)
    {
        $this->collUserProfiles[]= $userProfile;
        $userProfile->setParish($this);
    }

    /**
     * @param  ChildUserProfile $userProfile The ChildUserProfile object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeUserProfile(ChildUserProfile $userProfile)
    {
        if ($this->getUserProfiles()->contains($userProfile)) {
            $pos = $this->collUserProfiles->search($userProfile);
            $this->collUserProfiles->remove($pos);
            if (null === $this->userProfilesScheduledForDeletion) {
                $this->userProfilesScheduledForDeletion = clone $this->collUserProfiles;
                $this->userProfilesScheduledForDeletion->clear();
            }
            $this->userProfilesScheduledForDeletion[]= clone $userProfile;
            $userProfile->setParish(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserSubscriptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserSubscriptions()
     */
    public function clearUserSubscriptions()
    {
        $this->collUserSubscriptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserSubscriptions collection loaded partially.
     */
    public function resetPartialUserSubscriptions($v = true)
    {
        $this->collUserSubscriptionsPartial = $v;
    }

    /**
     * Initializes the collUserSubscriptions collection.
     *
     * By default this just sets the collUserSubscriptions collection to an empty array (like clearcollUserSubscriptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserSubscriptions($overrideExisting = true)
    {
        if (null !== $this->collUserSubscriptions && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserSubscriptionTableMap::getTableMap()->getCollectionClassName();

        $this->collUserSubscriptions = new $collectionClassName;
        $this->collUserSubscriptions->setModel('\UserSubscription');
    }

    /**
     * Gets an array of ChildUserSubscription objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParish is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserSubscription[] List of ChildUserSubscription objects
     * @throws PropelException
     */
    public function getUserSubscriptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserSubscriptionsPartial && !$this->isNew();
        if (null === $this->collUserSubscriptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserSubscriptions) {
                // return empty collection
                $this->initUserSubscriptions();
            } else {
                $collUserSubscriptions = ChildUserSubscriptionQuery::create(null, $criteria)
                    ->filterByParish($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserSubscriptionsPartial && count($collUserSubscriptions)) {
                        $this->initUserSubscriptions(false);

                        foreach ($collUserSubscriptions as $obj) {
                            if (false == $this->collUserSubscriptions->contains($obj)) {
                                $this->collUserSubscriptions->append($obj);
                            }
                        }

                        $this->collUserSubscriptionsPartial = true;
                    }

                    return $collUserSubscriptions;
                }

                if ($partial && $this->collUserSubscriptions) {
                    foreach ($this->collUserSubscriptions as $obj) {
                        if ($obj->isNew()) {
                            $collUserSubscriptions[] = $obj;
                        }
                    }
                }

                $this->collUserSubscriptions = $collUserSubscriptions;
                $this->collUserSubscriptionsPartial = false;
            }
        }

        return $this->collUserSubscriptions;
    }

    /**
     * Sets a collection of ChildUserSubscription objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userSubscriptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function setUserSubscriptions(Collection $userSubscriptions, ConnectionInterface $con = null)
    {
        /** @var ChildUserSubscription[] $userSubscriptionsToDelete */
        $userSubscriptionsToDelete = $this->getUserSubscriptions(new Criteria(), $con)->diff($userSubscriptions);

        
        $this->userSubscriptionsScheduledForDeletion = $userSubscriptionsToDelete;

        foreach ($userSubscriptionsToDelete as $userSubscriptionRemoved) {
            $userSubscriptionRemoved->setParish(null);
        }

        $this->collUserSubscriptions = null;
        foreach ($userSubscriptions as $userSubscription) {
            $this->addUserSubscription($userSubscription);
        }

        $this->collUserSubscriptions = $userSubscriptions;
        $this->collUserSubscriptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserSubscription objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserSubscription objects.
     * @throws PropelException
     */
    public function countUserSubscriptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserSubscriptionsPartial && !$this->isNew();
        if (null === $this->collUserSubscriptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserSubscriptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserSubscriptions());
            }

            $query = ChildUserSubscriptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParish($this)
                ->count($con);
        }

        return count($this->collUserSubscriptions);
    }

    /**
     * Method called to associate a ChildUserSubscription object to this object
     * through the ChildUserSubscription foreign key attribute.
     *
     * @param  ChildUserSubscription $l ChildUserSubscription
     * @return $this|\Parish The current object (for fluent API support)
     */
    public function addUserSubscription(ChildUserSubscription $l)
    {
        if ($this->collUserSubscriptions === null) {
            $this->initUserSubscriptions();
            $this->collUserSubscriptionsPartial = true;
        }

        if (!$this->collUserSubscriptions->contains($l)) {
            $this->doAddUserSubscription($l);

            if ($this->userSubscriptionsScheduledForDeletion and $this->userSubscriptionsScheduledForDeletion->contains($l)) {
                $this->userSubscriptionsScheduledForDeletion->remove($this->userSubscriptionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserSubscription $userSubscription The ChildUserSubscription object to add.
     */
    protected function doAddUserSubscription(ChildUserSubscription $userSubscription)
    {
        $this->collUserSubscriptions[]= $userSubscription;
        $userSubscription->setParish($this);
    }

    /**
     * @param  ChildUserSubscription $userSubscription The ChildUserSubscription object to remove.
     * @return $this|ChildParish The current object (for fluent API support)
     */
    public function removeUserSubscription(ChildUserSubscription $userSubscription)
    {
        if ($this->getUserSubscriptions()->contains($userSubscription)) {
            $pos = $this->collUserSubscriptions->search($userSubscription);
            $this->collUserSubscriptions->remove($pos);
            if (null === $this->userSubscriptionsScheduledForDeletion) {
                $this->userSubscriptionsScheduledForDeletion = clone $this->collUserSubscriptions;
                $this->userSubscriptionsScheduledForDeletion->clear();
            }
            $this->userSubscriptionsScheduledForDeletion[]= clone $userSubscription;
            $userSubscription->setParish(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related UserSubscriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserSubscription[] List of ChildUserSubscription objects
     */
    public function getUserSubscriptionsJoinUserLogin(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserSubscriptionQuery::create(null, $criteria);
        $query->joinWith('UserLogin', $joinBehavior);

        return $this->getUserSubscriptions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related UserSubscriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserSubscription[] List of ChildUserSubscription objects
     */
    public function getUserSubscriptionsJoinUserPlan(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserSubscriptionQuery::create(null, $criteria);
        $query->joinWith('UserPlan', $joinBehavior);

        return $this->getUserSubscriptions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Parish is new, it will return
     * an empty collection; or if this Parish has previously
     * been saved, it will retrieve related UserSubscriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Parish.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserSubscription[] List of ChildUserSubscription objects
     */
    public function getUserSubscriptionsJoinUserPayment(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserSubscriptionQuery::create(null, $criteria);
        $query->joinWith('UserPayment', $joinBehavior);

        return $this->getUserSubscriptions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aChurch) {
            $this->aChurch->removeParish($this);
        }
        $this->value = null;
        $this->church_id = null;
        $this->name = null;
        $this->address = null;
        $this->city = null;
        $this->state = null;
        $this->zip = null;
        $this->lat = null;
        $this->lng = null;
        $this->formatted_address = null;
        $this->country = null;
        $this->phone = null;
        $this->email = null;
        $this->logo = null;
        $this->overseer = null;
        $this->enabled = null;
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
            if ($this->collAbouts) {
                foreach ($this->collAbouts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDevotionss) {
                foreach ($this->collDevotionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEconnects) {
                foreach ($this->collEconnects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventss) {
                foreach ($this->collEventss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFacebooks) {
                foreach ($this->collFacebooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGives) {
                foreach ($this->collGives as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGiveParishCurrencies) {
                foreach ($this->collGiveParishCurrencies as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGiveParishMethodss) {
                foreach ($this->collGiveParishMethodss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGiveTypes) {
                foreach ($this->collGiveTypes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collLetterss) {
                foreach ($this->collLetterss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collLiveStreams) {
                foreach ($this->collLiveStreams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMedias) {
                foreach ($this->collMedias as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMinistries) {
                foreach ($this->collMinistries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParishSegments) {
                foreach ($this->collParishSegments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTwitters) {
                foreach ($this->collTwitters as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFamilies) {
                foreach ($this->collUserFamilies as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserLogins) {
                foreach ($this->collUserLogins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserProfiles) {
                foreach ($this->collUserProfiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserSubscriptions) {
                foreach ($this->collUserSubscriptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAbouts = null;
        $this->collDevotionss = null;
        $this->collEconnects = null;
        $this->collEventss = null;
        $this->collFacebooks = null;
        $this->collGives = null;
        $this->collGiveParishCurrencies = null;
        $this->collGiveParishMethodss = null;
        $this->collGiveTypes = null;
        $this->collLetterss = null;
        $this->collLiveStreams = null;
        $this->collMedias = null;
        $this->collMinistries = null;
        $this->collParishSegments = null;
        $this->collTwitters = null;
        $this->collUserFamilies = null;
        $this->collUserLogins = null;
        $this->collUserProfiles = null;
        $this->collUserSubscriptions = null;
        $this->aChurch = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ParishTableMap::DEFAULT_STRING_FORMAT);
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
