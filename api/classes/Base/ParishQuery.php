<?php

namespace Base;

use \Parish as ChildParish;
use \ParishQuery as ChildParishQuery;
use \Exception;
use \PDO;
use Map\ParishTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'parish' table.
 *
 * 
 *
 * @method     ChildParishQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildParishQuery orderByChurchId($order = Criteria::ASC) Order by the church_id column
 * @method     ChildParishQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildParishQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildParishQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildParishQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildParishQuery orderByZip($order = Criteria::ASC) Order by the zip column
 * @method     ChildParishQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildParishQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildParishQuery orderByFormattedAddress($order = Criteria::ASC) Order by the formatted_address column
 * @method     ChildParishQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildParishQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildParishQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildParishQuery orderByLogo($order = Criteria::ASC) Order by the logo column
 * @method     ChildParishQuery orderByOverseer($order = Criteria::ASC) Order by the overseer column
 * @method     ChildParishQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method     ChildParishQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildParishQuery groupByValue() Group by the value column
 * @method     ChildParishQuery groupByChurchId() Group by the church_id column
 * @method     ChildParishQuery groupByName() Group by the name column
 * @method     ChildParishQuery groupByAddress() Group by the address column
 * @method     ChildParishQuery groupByCity() Group by the city column
 * @method     ChildParishQuery groupByState() Group by the state column
 * @method     ChildParishQuery groupByZip() Group by the zip column
 * @method     ChildParishQuery groupByLat() Group by the lat column
 * @method     ChildParishQuery groupByLng() Group by the lng column
 * @method     ChildParishQuery groupByFormattedAddress() Group by the formatted_address column
 * @method     ChildParishQuery groupByCountry() Group by the country column
 * @method     ChildParishQuery groupByPhone() Group by the phone column
 * @method     ChildParishQuery groupByEmail() Group by the email column
 * @method     ChildParishQuery groupByLogo() Group by the logo column
 * @method     ChildParishQuery groupByOverseer() Group by the overseer column
 * @method     ChildParishQuery groupByEnabled() Group by the enabled column
 * @method     ChildParishQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildParishQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildParishQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildParishQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildParishQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildParishQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildParishQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildParishQuery leftJoinChurch($relationAlias = null) Adds a LEFT JOIN clause to the query using the Church relation
 * @method     ChildParishQuery rightJoinChurch($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Church relation
 * @method     ChildParishQuery innerJoinChurch($relationAlias = null) Adds a INNER JOIN clause to the query using the Church relation
 *
 * @method     ChildParishQuery joinWithChurch($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Church relation
 *
 * @method     ChildParishQuery leftJoinWithChurch() Adds a LEFT JOIN clause and with to the query using the Church relation
 * @method     ChildParishQuery rightJoinWithChurch() Adds a RIGHT JOIN clause and with to the query using the Church relation
 * @method     ChildParishQuery innerJoinWithChurch() Adds a INNER JOIN clause and with to the query using the Church relation
 *
 * @method     ChildParishQuery leftJoinAbout($relationAlias = null) Adds a LEFT JOIN clause to the query using the About relation
 * @method     ChildParishQuery rightJoinAbout($relationAlias = null) Adds a RIGHT JOIN clause to the query using the About relation
 * @method     ChildParishQuery innerJoinAbout($relationAlias = null) Adds a INNER JOIN clause to the query using the About relation
 *
 * @method     ChildParishQuery joinWithAbout($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the About relation
 *
 * @method     ChildParishQuery leftJoinWithAbout() Adds a LEFT JOIN clause and with to the query using the About relation
 * @method     ChildParishQuery rightJoinWithAbout() Adds a RIGHT JOIN clause and with to the query using the About relation
 * @method     ChildParishQuery innerJoinWithAbout() Adds a INNER JOIN clause and with to the query using the About relation
 *
 * @method     ChildParishQuery leftJoinDevotions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Devotions relation
 * @method     ChildParishQuery rightJoinDevotions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Devotions relation
 * @method     ChildParishQuery innerJoinDevotions($relationAlias = null) Adds a INNER JOIN clause to the query using the Devotions relation
 *
 * @method     ChildParishQuery joinWithDevotions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Devotions relation
 *
 * @method     ChildParishQuery leftJoinWithDevotions() Adds a LEFT JOIN clause and with to the query using the Devotions relation
 * @method     ChildParishQuery rightJoinWithDevotions() Adds a RIGHT JOIN clause and with to the query using the Devotions relation
 * @method     ChildParishQuery innerJoinWithDevotions() Adds a INNER JOIN clause and with to the query using the Devotions relation
 *
 * @method     ChildParishQuery leftJoinEconnect($relationAlias = null) Adds a LEFT JOIN clause to the query using the Econnect relation
 * @method     ChildParishQuery rightJoinEconnect($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Econnect relation
 * @method     ChildParishQuery innerJoinEconnect($relationAlias = null) Adds a INNER JOIN clause to the query using the Econnect relation
 *
 * @method     ChildParishQuery joinWithEconnect($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Econnect relation
 *
 * @method     ChildParishQuery leftJoinWithEconnect() Adds a LEFT JOIN clause and with to the query using the Econnect relation
 * @method     ChildParishQuery rightJoinWithEconnect() Adds a RIGHT JOIN clause and with to the query using the Econnect relation
 * @method     ChildParishQuery innerJoinWithEconnect() Adds a INNER JOIN clause and with to the query using the Econnect relation
 *
 * @method     ChildParishQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildParishQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildParishQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildParishQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildParishQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildParishQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildParishQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     ChildParishQuery leftJoinFacebook($relationAlias = null) Adds a LEFT JOIN clause to the query using the Facebook relation
 * @method     ChildParishQuery rightJoinFacebook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Facebook relation
 * @method     ChildParishQuery innerJoinFacebook($relationAlias = null) Adds a INNER JOIN clause to the query using the Facebook relation
 *
 * @method     ChildParishQuery joinWithFacebook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Facebook relation
 *
 * @method     ChildParishQuery leftJoinWithFacebook() Adds a LEFT JOIN clause and with to the query using the Facebook relation
 * @method     ChildParishQuery rightJoinWithFacebook() Adds a RIGHT JOIN clause and with to the query using the Facebook relation
 * @method     ChildParishQuery innerJoinWithFacebook() Adds a INNER JOIN clause and with to the query using the Facebook relation
 *
 * @method     ChildParishQuery leftJoinGive($relationAlias = null) Adds a LEFT JOIN clause to the query using the Give relation
 * @method     ChildParishQuery rightJoinGive($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Give relation
 * @method     ChildParishQuery innerJoinGive($relationAlias = null) Adds a INNER JOIN clause to the query using the Give relation
 *
 * @method     ChildParishQuery joinWithGive($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Give relation
 *
 * @method     ChildParishQuery leftJoinWithGive() Adds a LEFT JOIN clause and with to the query using the Give relation
 * @method     ChildParishQuery rightJoinWithGive() Adds a RIGHT JOIN clause and with to the query using the Give relation
 * @method     ChildParishQuery innerJoinWithGive() Adds a INNER JOIN clause and with to the query using the Give relation
 *
 * @method     ChildParishQuery leftJoinGiveParishCurrency($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveParishCurrency relation
 * @method     ChildParishQuery rightJoinGiveParishCurrency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveParishCurrency relation
 * @method     ChildParishQuery innerJoinGiveParishCurrency($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveParishCurrency relation
 *
 * @method     ChildParishQuery joinWithGiveParishCurrency($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveParishCurrency relation
 *
 * @method     ChildParishQuery leftJoinWithGiveParishCurrency() Adds a LEFT JOIN clause and with to the query using the GiveParishCurrency relation
 * @method     ChildParishQuery rightJoinWithGiveParishCurrency() Adds a RIGHT JOIN clause and with to the query using the GiveParishCurrency relation
 * @method     ChildParishQuery innerJoinWithGiveParishCurrency() Adds a INNER JOIN clause and with to the query using the GiveParishCurrency relation
 *
 * @method     ChildParishQuery leftJoinGiveParishMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveParishMethods relation
 * @method     ChildParishQuery rightJoinGiveParishMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveParishMethods relation
 * @method     ChildParishQuery innerJoinGiveParishMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveParishMethods relation
 *
 * @method     ChildParishQuery joinWithGiveParishMethods($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveParishMethods relation
 *
 * @method     ChildParishQuery leftJoinWithGiveParishMethods() Adds a LEFT JOIN clause and with to the query using the GiveParishMethods relation
 * @method     ChildParishQuery rightJoinWithGiveParishMethods() Adds a RIGHT JOIN clause and with to the query using the GiveParishMethods relation
 * @method     ChildParishQuery innerJoinWithGiveParishMethods() Adds a INNER JOIN clause and with to the query using the GiveParishMethods relation
 *
 * @method     ChildParishQuery leftJoinGiveType($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiveType relation
 * @method     ChildParishQuery rightJoinGiveType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiveType relation
 * @method     ChildParishQuery innerJoinGiveType($relationAlias = null) Adds a INNER JOIN clause to the query using the GiveType relation
 *
 * @method     ChildParishQuery joinWithGiveType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GiveType relation
 *
 * @method     ChildParishQuery leftJoinWithGiveType() Adds a LEFT JOIN clause and with to the query using the GiveType relation
 * @method     ChildParishQuery rightJoinWithGiveType() Adds a RIGHT JOIN clause and with to the query using the GiveType relation
 * @method     ChildParishQuery innerJoinWithGiveType() Adds a INNER JOIN clause and with to the query using the GiveType relation
 *
 * @method     ChildParishQuery leftJoinLetters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Letters relation
 * @method     ChildParishQuery rightJoinLetters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Letters relation
 * @method     ChildParishQuery innerJoinLetters($relationAlias = null) Adds a INNER JOIN clause to the query using the Letters relation
 *
 * @method     ChildParishQuery joinWithLetters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Letters relation
 *
 * @method     ChildParishQuery leftJoinWithLetters() Adds a LEFT JOIN clause and with to the query using the Letters relation
 * @method     ChildParishQuery rightJoinWithLetters() Adds a RIGHT JOIN clause and with to the query using the Letters relation
 * @method     ChildParishQuery innerJoinWithLetters() Adds a INNER JOIN clause and with to the query using the Letters relation
 *
 * @method     ChildParishQuery leftJoinLiveStream($relationAlias = null) Adds a LEFT JOIN clause to the query using the LiveStream relation
 * @method     ChildParishQuery rightJoinLiveStream($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LiveStream relation
 * @method     ChildParishQuery innerJoinLiveStream($relationAlias = null) Adds a INNER JOIN clause to the query using the LiveStream relation
 *
 * @method     ChildParishQuery joinWithLiveStream($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the LiveStream relation
 *
 * @method     ChildParishQuery leftJoinWithLiveStream() Adds a LEFT JOIN clause and with to the query using the LiveStream relation
 * @method     ChildParishQuery rightJoinWithLiveStream() Adds a RIGHT JOIN clause and with to the query using the LiveStream relation
 * @method     ChildParishQuery innerJoinWithLiveStream() Adds a INNER JOIN clause and with to the query using the LiveStream relation
 *
 * @method     ChildParishQuery leftJoinMedia($relationAlias = null) Adds a LEFT JOIN clause to the query using the Media relation
 * @method     ChildParishQuery rightJoinMedia($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Media relation
 * @method     ChildParishQuery innerJoinMedia($relationAlias = null) Adds a INNER JOIN clause to the query using the Media relation
 *
 * @method     ChildParishQuery joinWithMedia($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Media relation
 *
 * @method     ChildParishQuery leftJoinWithMedia() Adds a LEFT JOIN clause and with to the query using the Media relation
 * @method     ChildParishQuery rightJoinWithMedia() Adds a RIGHT JOIN clause and with to the query using the Media relation
 * @method     ChildParishQuery innerJoinWithMedia() Adds a INNER JOIN clause and with to the query using the Media relation
 *
 * @method     ChildParishQuery leftJoinMinistry($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ministry relation
 * @method     ChildParishQuery rightJoinMinistry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ministry relation
 * @method     ChildParishQuery innerJoinMinistry($relationAlias = null) Adds a INNER JOIN clause to the query using the Ministry relation
 *
 * @method     ChildParishQuery joinWithMinistry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ministry relation
 *
 * @method     ChildParishQuery leftJoinWithMinistry() Adds a LEFT JOIN clause and with to the query using the Ministry relation
 * @method     ChildParishQuery rightJoinWithMinistry() Adds a RIGHT JOIN clause and with to the query using the Ministry relation
 * @method     ChildParishQuery innerJoinWithMinistry() Adds a INNER JOIN clause and with to the query using the Ministry relation
 *
 * @method     ChildParishQuery leftJoinParishSegment($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParishSegment relation
 * @method     ChildParishQuery rightJoinParishSegment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParishSegment relation
 * @method     ChildParishQuery innerJoinParishSegment($relationAlias = null) Adds a INNER JOIN clause to the query using the ParishSegment relation
 *
 * @method     ChildParishQuery joinWithParishSegment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ParishSegment relation
 *
 * @method     ChildParishQuery leftJoinWithParishSegment() Adds a LEFT JOIN clause and with to the query using the ParishSegment relation
 * @method     ChildParishQuery rightJoinWithParishSegment() Adds a RIGHT JOIN clause and with to the query using the ParishSegment relation
 * @method     ChildParishQuery innerJoinWithParishSegment() Adds a INNER JOIN clause and with to the query using the ParishSegment relation
 *
 * @method     ChildParishQuery leftJoinTwitter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Twitter relation
 * @method     ChildParishQuery rightJoinTwitter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Twitter relation
 * @method     ChildParishQuery innerJoinTwitter($relationAlias = null) Adds a INNER JOIN clause to the query using the Twitter relation
 *
 * @method     ChildParishQuery joinWithTwitter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Twitter relation
 *
 * @method     ChildParishQuery leftJoinWithTwitter() Adds a LEFT JOIN clause and with to the query using the Twitter relation
 * @method     ChildParishQuery rightJoinWithTwitter() Adds a RIGHT JOIN clause and with to the query using the Twitter relation
 * @method     ChildParishQuery innerJoinWithTwitter() Adds a INNER JOIN clause and with to the query using the Twitter relation
 *
 * @method     ChildParishQuery leftJoinUserFamily($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserFamily relation
 * @method     ChildParishQuery rightJoinUserFamily($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserFamily relation
 * @method     ChildParishQuery innerJoinUserFamily($relationAlias = null) Adds a INNER JOIN clause to the query using the UserFamily relation
 *
 * @method     ChildParishQuery joinWithUserFamily($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserFamily relation
 *
 * @method     ChildParishQuery leftJoinWithUserFamily() Adds a LEFT JOIN clause and with to the query using the UserFamily relation
 * @method     ChildParishQuery rightJoinWithUserFamily() Adds a RIGHT JOIN clause and with to the query using the UserFamily relation
 * @method     ChildParishQuery innerJoinWithUserFamily() Adds a INNER JOIN clause and with to the query using the UserFamily relation
 *
 * @method     ChildParishQuery leftJoinUserLogin($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLogin relation
 * @method     ChildParishQuery rightJoinUserLogin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLogin relation
 * @method     ChildParishQuery innerJoinUserLogin($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLogin relation
 *
 * @method     ChildParishQuery joinWithUserLogin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserLogin relation
 *
 * @method     ChildParishQuery leftJoinWithUserLogin() Adds a LEFT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildParishQuery rightJoinWithUserLogin() Adds a RIGHT JOIN clause and with to the query using the UserLogin relation
 * @method     ChildParishQuery innerJoinWithUserLogin() Adds a INNER JOIN clause and with to the query using the UserLogin relation
 *
 * @method     ChildParishQuery leftJoinUserProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserProfile relation
 * @method     ChildParishQuery rightJoinUserProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserProfile relation
 * @method     ChildParishQuery innerJoinUserProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the UserProfile relation
 *
 * @method     ChildParishQuery joinWithUserProfile($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserProfile relation
 *
 * @method     ChildParishQuery leftJoinWithUserProfile() Adds a LEFT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildParishQuery rightJoinWithUserProfile() Adds a RIGHT JOIN clause and with to the query using the UserProfile relation
 * @method     ChildParishQuery innerJoinWithUserProfile() Adds a INNER JOIN clause and with to the query using the UserProfile relation
 *
 * @method     ChildParishQuery leftJoinUserSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSubscription relation
 * @method     ChildParishQuery rightJoinUserSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSubscription relation
 * @method     ChildParishQuery innerJoinUserSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSubscription relation
 *
 * @method     ChildParishQuery joinWithUserSubscription($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSubscription relation
 *
 * @method     ChildParishQuery leftJoinWithUserSubscription() Adds a LEFT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildParishQuery rightJoinWithUserSubscription() Adds a RIGHT JOIN clause and with to the query using the UserSubscription relation
 * @method     ChildParishQuery innerJoinWithUserSubscription() Adds a INNER JOIN clause and with to the query using the UserSubscription relation
 *
 * @method     \ChurchQuery|\AboutQuery|\DevotionsQuery|\EconnectQuery|\EventsQuery|\FacebookQuery|\GiveQuery|\GiveParishCurrencyQuery|\GiveParishMethodsQuery|\GiveTypeQuery|\LettersQuery|\LiveStreamQuery|\MediaQuery|\MinistryQuery|\ParishSegmentQuery|\TwitterQuery|\UserFamilyQuery|\UserLoginQuery|\UserProfileQuery|\UserSubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildParish findOne(ConnectionInterface $con = null) Return the first ChildParish matching the query
 * @method     ChildParish findOneOrCreate(ConnectionInterface $con = null) Return the first ChildParish matching the query, or a new ChildParish object populated from the query conditions when no match is found
 *
 * @method     ChildParish findOneByValue(int $value) Return the first ChildParish filtered by the value column
 * @method     ChildParish findOneByChurchId(int $church_id) Return the first ChildParish filtered by the church_id column
 * @method     ChildParish findOneByName(string $name) Return the first ChildParish filtered by the name column
 * @method     ChildParish findOneByAddress(string $address) Return the first ChildParish filtered by the address column
 * @method     ChildParish findOneByCity(string $city) Return the first ChildParish filtered by the city column
 * @method     ChildParish findOneByState(string $state) Return the first ChildParish filtered by the state column
 * @method     ChildParish findOneByZip(string $zip) Return the first ChildParish filtered by the zip column
 * @method     ChildParish findOneByLat(string $lat) Return the first ChildParish filtered by the lat column
 * @method     ChildParish findOneByLng(string $lng) Return the first ChildParish filtered by the lng column
 * @method     ChildParish findOneByFormattedAddress(string $formatted_address) Return the first ChildParish filtered by the formatted_address column
 * @method     ChildParish findOneByCountry(string $country) Return the first ChildParish filtered by the country column
 * @method     ChildParish findOneByPhone(string $phone) Return the first ChildParish filtered by the phone column
 * @method     ChildParish findOneByEmail(string $email) Return the first ChildParish filtered by the email column
 * @method     ChildParish findOneByLogo(string $logo) Return the first ChildParish filtered by the logo column
 * @method     ChildParish findOneByOverseer(string $overseer) Return the first ChildParish filtered by the overseer column
 * @method     ChildParish findOneByEnabled(boolean $enabled) Return the first ChildParish filtered by the enabled column
 * @method     ChildParish findOneByCreatedAt(string $created_at) Return the first ChildParish filtered by the created_at column *

 * @method     ChildParish requirePk($key, ConnectionInterface $con = null) Return the ChildParish by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOne(ConnectionInterface $con = null) Return the first ChildParish matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParish requireOneByValue(int $value) Return the first ChildParish filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByChurchId(int $church_id) Return the first ChildParish filtered by the church_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByName(string $name) Return the first ChildParish filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByAddress(string $address) Return the first ChildParish filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByCity(string $city) Return the first ChildParish filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByState(string $state) Return the first ChildParish filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByZip(string $zip) Return the first ChildParish filtered by the zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByLat(string $lat) Return the first ChildParish filtered by the lat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByLng(string $lng) Return the first ChildParish filtered by the lng column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByFormattedAddress(string $formatted_address) Return the first ChildParish filtered by the formatted_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByCountry(string $country) Return the first ChildParish filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByPhone(string $phone) Return the first ChildParish filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByEmail(string $email) Return the first ChildParish filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByLogo(string $logo) Return the first ChildParish filtered by the logo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByOverseer(string $overseer) Return the first ChildParish filtered by the overseer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByEnabled(boolean $enabled) Return the first ChildParish filtered by the enabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParish requireOneByCreatedAt(string $created_at) Return the first ChildParish filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParish[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildParish objects based on current ModelCriteria
 * @method     ChildParish[]|ObjectCollection findByValue(int $value) Return ChildParish objects filtered by the value column
 * @method     ChildParish[]|ObjectCollection findByChurchId(int $church_id) Return ChildParish objects filtered by the church_id column
 * @method     ChildParish[]|ObjectCollection findByName(string $name) Return ChildParish objects filtered by the name column
 * @method     ChildParish[]|ObjectCollection findByAddress(string $address) Return ChildParish objects filtered by the address column
 * @method     ChildParish[]|ObjectCollection findByCity(string $city) Return ChildParish objects filtered by the city column
 * @method     ChildParish[]|ObjectCollection findByState(string $state) Return ChildParish objects filtered by the state column
 * @method     ChildParish[]|ObjectCollection findByZip(string $zip) Return ChildParish objects filtered by the zip column
 * @method     ChildParish[]|ObjectCollection findByLat(string $lat) Return ChildParish objects filtered by the lat column
 * @method     ChildParish[]|ObjectCollection findByLng(string $lng) Return ChildParish objects filtered by the lng column
 * @method     ChildParish[]|ObjectCollection findByFormattedAddress(string $formatted_address) Return ChildParish objects filtered by the formatted_address column
 * @method     ChildParish[]|ObjectCollection findByCountry(string $country) Return ChildParish objects filtered by the country column
 * @method     ChildParish[]|ObjectCollection findByPhone(string $phone) Return ChildParish objects filtered by the phone column
 * @method     ChildParish[]|ObjectCollection findByEmail(string $email) Return ChildParish objects filtered by the email column
 * @method     ChildParish[]|ObjectCollection findByLogo(string $logo) Return ChildParish objects filtered by the logo column
 * @method     ChildParish[]|ObjectCollection findByOverseer(string $overseer) Return ChildParish objects filtered by the overseer column
 * @method     ChildParish[]|ObjectCollection findByEnabled(boolean $enabled) Return ChildParish objects filtered by the enabled column
 * @method     ChildParish[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildParish objects filtered by the created_at column
 * @method     ChildParish[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ParishQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ParishQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Parish', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildParishQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildParishQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildParishQuery) {
            return $criteria;
        }
        $query = new ChildParishQuery();
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
     * @return ChildParish|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParishTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ParishTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildParish A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value, church_id, name, address, city, state, zip, lat, lng, formatted_address, country, phone, email, logo, overseer, enabled, created_at FROM parish WHERE value = :p0';
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
            /** @var ChildParish $obj */
            $obj = new ChildParish();
            $obj->hydrate($row);
            ParishTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildParish|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ParishTableMap::COL_VALUE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ParishTableMap::COL_VALUE, $keys, Criteria::IN);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(ParishTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(ParishTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the church_id column
     *
     * Example usage:
     * <code>
     * $query->filterByChurchId(1234); // WHERE church_id = 1234
     * $query->filterByChurchId(array(12, 34)); // WHERE church_id IN (12, 34)
     * $query->filterByChurchId(array('min' => 12)); // WHERE church_id > 12
     * </code>
     *
     * @see       filterByChurch()
     *
     * @param     mixed $churchId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByChurchId($churchId = null, $comparison = null)
    {
        if (is_array($churchId)) {
            $useMinMax = false;
            if (isset($churchId['min'])) {
                $this->addUsingAlias(ParishTableMap::COL_CHURCH_ID, $churchId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($churchId['max'])) {
                $this->addUsingAlias(ParishTableMap::COL_CHURCH_ID, $churchId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_CHURCH_ID, $churchId, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_ADDRESS, $address, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_CITY, $city, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_STATE, $state, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByZip($zip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($zip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_ZIP, $zip, $comparison);
    }

    /**
     * Filter the query on the lat column
     *
     * Example usage:
     * <code>
     * $query->filterByLat('fooValue');   // WHERE lat = 'fooValue'
     * $query->filterByLat('%fooValue%'); // WHERE lat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lat The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByLat($lat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lat)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_LAT, $lat, $comparison);
    }

    /**
     * Filter the query on the lng column
     *
     * Example usage:
     * <code>
     * $query->filterByLng('fooValue');   // WHERE lng = 'fooValue'
     * $query->filterByLng('%fooValue%'); // WHERE lng LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lng The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByLng($lng = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lng)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_LNG, $lng, $comparison);
    }

    /**
     * Filter the query on the formatted_address column
     *
     * Example usage:
     * <code>
     * $query->filterByFormattedAddress('fooValue');   // WHERE formatted_address = 'fooValue'
     * $query->filterByFormattedAddress('%fooValue%'); // WHERE formatted_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $formattedAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByFormattedAddress($formattedAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($formattedAddress)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_FORMATTED_ADDRESS, $formattedAddress, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_COUNTRY, $country, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_PHONE, $phone, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByLogo($logo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_LOGO, $logo, $comparison);
    }

    /**
     * Filter the query on the overseer column
     *
     * Example usage:
     * <code>
     * $query->filterByOverseer('fooValue');   // WHERE overseer = 'fooValue'
     * $query->filterByOverseer('%fooValue%'); // WHERE overseer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $overseer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByOverseer($overseer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($overseer)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_OVERSEER, $overseer, $comparison);
    }

    /**
     * Filter the query on the enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabled(true); // WHERE enabled = true
     * $query->filterByEnabled('yes'); // WHERE enabled = true
     * </code>
     *
     * @param     boolean|string $enabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ParishTableMap::COL_ENABLED, $enabled, $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ParishTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ParishTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParishTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Church object
     *
     * @param \Church|ObjectCollection $church The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByChurch($church, $comparison = null)
    {
        if ($church instanceof \Church) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_CHURCH_ID, $church->getValue(), $comparison);
        } elseif ($church instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParishTableMap::COL_CHURCH_ID, $church->toKeyValue('PrimaryKey', 'Value'), $comparison);
        } else {
            throw new PropelException('filterByChurch() only accepts arguments of type \Church or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Church relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinChurch($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Church');

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
            $this->addJoinObject($join, 'Church');
        }

        return $this;
    }

    /**
     * Use the Church relation Church object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchQuery A secondary query class using the current class as primary query
     */
    public function useChurchQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChurch($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Church', '\ChurchQuery');
    }

    /**
     * Filter the query by a related \About object
     *
     * @param \About|ObjectCollection $about the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByAbout($about, $comparison = null)
    {
        if ($about instanceof \About) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $about->getParishId(), $comparison);
        } elseif ($about instanceof ObjectCollection) {
            return $this
                ->useAboutQuery()
                ->filterByPrimaryKeys($about->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAbout() only accepts arguments of type \About or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the About relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinAbout($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('About');

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
            $this->addJoinObject($join, 'About');
        }

        return $this;
    }

    /**
     * Use the About relation About object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AboutQuery A secondary query class using the current class as primary query
     */
    public function useAboutQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAbout($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'About', '\AboutQuery');
    }

    /**
     * Filter the query by a related \Devotions object
     *
     * @param \Devotions|ObjectCollection $devotions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByDevotions($devotions, $comparison = null)
    {
        if ($devotions instanceof \Devotions) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $devotions->getParishId(), $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
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
     * Filter the query by a related \Econnect object
     *
     * @param \Econnect|ObjectCollection $econnect the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByEconnect($econnect, $comparison = null)
    {
        if ($econnect instanceof \Econnect) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $econnect->getParishId(), $comparison);
        } elseif ($econnect instanceof ObjectCollection) {
            return $this
                ->useEconnectQuery()
                ->filterByPrimaryKeys($econnect->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEconnect() only accepts arguments of type \Econnect or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Econnect relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinEconnect($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Econnect');

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
            $this->addJoinObject($join, 'Econnect');
        }

        return $this;
    }

    /**
     * Use the Econnect relation Econnect object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EconnectQuery A secondary query class using the current class as primary query
     */
    public function useEconnectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEconnect($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Econnect', '\EconnectQuery');
    }

    /**
     * Filter the query by a related \Events object
     *
     * @param \Events|ObjectCollection $events the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Events) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $events->getParishId(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            return $this
                ->useEventsQuery()
                ->filterByPrimaryKeys($events->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEvents() only accepts arguments of type \Events or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Events relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinEvents($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Events');

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
            $this->addJoinObject($join, 'Events');
        }

        return $this;
    }

    /**
     * Use the Events relation Events object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EventsQuery A secondary query class using the current class as primary query
     */
    public function useEventsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvents($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Events', '\EventsQuery');
    }

    /**
     * Filter the query by a related \Facebook object
     *
     * @param \Facebook|ObjectCollection $facebook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByFacebook($facebook, $comparison = null)
    {
        if ($facebook instanceof \Facebook) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $facebook->getParishId(), $comparison);
        } elseif ($facebook instanceof ObjectCollection) {
            return $this
                ->useFacebookQuery()
                ->filterByPrimaryKeys($facebook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFacebook() only accepts arguments of type \Facebook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Facebook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinFacebook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Facebook');

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
            $this->addJoinObject($join, 'Facebook');
        }

        return $this;
    }

    /**
     * Use the Facebook relation Facebook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FacebookQuery A secondary query class using the current class as primary query
     */
    public function useFacebookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFacebook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Facebook', '\FacebookQuery');
    }

    /**
     * Filter the query by a related \Give object
     *
     * @param \Give|ObjectCollection $give the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByGive($give, $comparison = null)
    {
        if ($give instanceof \Give) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $give->getParishId(), $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
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
     * Filter the query by a related \GiveParishCurrency object
     *
     * @param \GiveParishCurrency|ObjectCollection $giveParishCurrency the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByGiveParishCurrency($giveParishCurrency, $comparison = null)
    {
        if ($giveParishCurrency instanceof \GiveParishCurrency) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $giveParishCurrency->getParishId(), $comparison);
        } elseif ($giveParishCurrency instanceof ObjectCollection) {
            return $this
                ->useGiveParishCurrencyQuery()
                ->filterByPrimaryKeys($giveParishCurrency->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiveParishCurrency() only accepts arguments of type \GiveParishCurrency or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveParishCurrency relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinGiveParishCurrency($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveParishCurrency');

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
            $this->addJoinObject($join, 'GiveParishCurrency');
        }

        return $this;
    }

    /**
     * Use the GiveParishCurrency relation GiveParishCurrency object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveParishCurrencyQuery A secondary query class using the current class as primary query
     */
    public function useGiveParishCurrencyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveParishCurrency($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveParishCurrency', '\GiveParishCurrencyQuery');
    }

    /**
     * Filter the query by a related \GiveParishMethods object
     *
     * @param \GiveParishMethods|ObjectCollection $giveParishMethods the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByGiveParishMethods($giveParishMethods, $comparison = null)
    {
        if ($giveParishMethods instanceof \GiveParishMethods) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $giveParishMethods->getParishId(), $comparison);
        } elseif ($giveParishMethods instanceof ObjectCollection) {
            return $this
                ->useGiveParishMethodsQuery()
                ->filterByPrimaryKeys($giveParishMethods->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiveParishMethods() only accepts arguments of type \GiveParishMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveParishMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinGiveParishMethods($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveParishMethods');

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
            $this->addJoinObject($join, 'GiveParishMethods');
        }

        return $this;
    }

    /**
     * Use the GiveParishMethods relation GiveParishMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveParishMethodsQuery A secondary query class using the current class as primary query
     */
    public function useGiveParishMethodsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveParishMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveParishMethods', '\GiveParishMethodsQuery');
    }

    /**
     * Filter the query by a related \GiveType object
     *
     * @param \GiveType|ObjectCollection $giveType the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByGiveType($giveType, $comparison = null)
    {
        if ($giveType instanceof \GiveType) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $giveType->getParishId(), $comparison);
        } elseif ($giveType instanceof ObjectCollection) {
            return $this
                ->useGiveTypeQuery()
                ->filterByPrimaryKeys($giveType->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiveType() only accepts arguments of type \GiveType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiveType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinGiveType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiveType');

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
            $this->addJoinObject($join, 'GiveType');
        }

        return $this;
    }

    /**
     * Use the GiveType relation GiveType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GiveTypeQuery A secondary query class using the current class as primary query
     */
    public function useGiveTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiveType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiveType', '\GiveTypeQuery');
    }

    /**
     * Filter the query by a related \Letters object
     *
     * @param \Letters|ObjectCollection $letters the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByLetters($letters, $comparison = null)
    {
        if ($letters instanceof \Letters) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $letters->getParishId(), $comparison);
        } elseif ($letters instanceof ObjectCollection) {
            return $this
                ->useLettersQuery()
                ->filterByPrimaryKeys($letters->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLetters() only accepts arguments of type \Letters or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Letters relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinLetters($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Letters');

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
            $this->addJoinObject($join, 'Letters');
        }

        return $this;
    }

    /**
     * Use the Letters relation Letters object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LettersQuery A secondary query class using the current class as primary query
     */
    public function useLettersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLetters($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Letters', '\LettersQuery');
    }

    /**
     * Filter the query by a related \LiveStream object
     *
     * @param \LiveStream|ObjectCollection $liveStream the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByLiveStream($liveStream, $comparison = null)
    {
        if ($liveStream instanceof \LiveStream) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $liveStream->getParishId(), $comparison);
        } elseif ($liveStream instanceof ObjectCollection) {
            return $this
                ->useLiveStreamQuery()
                ->filterByPrimaryKeys($liveStream->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLiveStream() only accepts arguments of type \LiveStream or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LiveStream relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinLiveStream($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LiveStream');

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
            $this->addJoinObject($join, 'LiveStream');
        }

        return $this;
    }

    /**
     * Use the LiveStream relation LiveStream object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LiveStreamQuery A secondary query class using the current class as primary query
     */
    public function useLiveStreamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLiveStream($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LiveStream', '\LiveStreamQuery');
    }

    /**
     * Filter the query by a related \Media object
     *
     * @param \Media|ObjectCollection $media the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByMedia($media, $comparison = null)
    {
        if ($media instanceof \Media) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $media->getParishId(), $comparison);
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
     * @return $this|ChildParishQuery The current query, for fluid interface
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
     * Filter the query by a related \Ministry object
     *
     * @param \Ministry|ObjectCollection $ministry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByMinistry($ministry, $comparison = null)
    {
        if ($ministry instanceof \Ministry) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $ministry->getParishId(), $comparison);
        } elseif ($ministry instanceof ObjectCollection) {
            return $this
                ->useMinistryQuery()
                ->filterByPrimaryKeys($ministry->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMinistry() only accepts arguments of type \Ministry or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ministry relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinMinistry($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ministry');

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
            $this->addJoinObject($join, 'Ministry');
        }

        return $this;
    }

    /**
     * Use the Ministry relation Ministry object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MinistryQuery A secondary query class using the current class as primary query
     */
    public function useMinistryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMinistry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ministry', '\MinistryQuery');
    }

    /**
     * Filter the query by a related \ParishSegment object
     *
     * @param \ParishSegment|ObjectCollection $parishSegment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByParishSegment($parishSegment, $comparison = null)
    {
        if ($parishSegment instanceof \ParishSegment) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $parishSegment->getParishId(), $comparison);
        } elseif ($parishSegment instanceof ObjectCollection) {
            return $this
                ->useParishSegmentQuery()
                ->filterByPrimaryKeys($parishSegment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParishSegment() only accepts arguments of type \ParishSegment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParishSegment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinParishSegment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParishSegment');

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
            $this->addJoinObject($join, 'ParishSegment');
        }

        return $this;
    }

    /**
     * Use the ParishSegment relation ParishSegment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ParishSegmentQuery A secondary query class using the current class as primary query
     */
    public function useParishSegmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParishSegment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParishSegment', '\ParishSegmentQuery');
    }

    /**
     * Filter the query by a related \Twitter object
     *
     * @param \Twitter|ObjectCollection $twitter the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByTwitter($twitter, $comparison = null)
    {
        if ($twitter instanceof \Twitter) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $twitter->getParishId(), $comparison);
        } elseif ($twitter instanceof ObjectCollection) {
            return $this
                ->useTwitterQuery()
                ->filterByPrimaryKeys($twitter->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTwitter() only accepts arguments of type \Twitter or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Twitter relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinTwitter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Twitter');

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
            $this->addJoinObject($join, 'Twitter');
        }

        return $this;
    }

    /**
     * Use the Twitter relation Twitter object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TwitterQuery A secondary query class using the current class as primary query
     */
    public function useTwitterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTwitter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Twitter', '\TwitterQuery');
    }

    /**
     * Filter the query by a related \UserFamily object
     *
     * @param \UserFamily|ObjectCollection $userFamily the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByUserFamily($userFamily, $comparison = null)
    {
        if ($userFamily instanceof \UserFamily) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $userFamily->getUserId(), $comparison);
        } elseif ($userFamily instanceof ObjectCollection) {
            return $this
                ->useUserFamilyQuery()
                ->filterByPrimaryKeys($userFamily->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserFamily() only accepts arguments of type \UserFamily or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserFamily relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinUserFamily($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserFamily');

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
            $this->addJoinObject($join, 'UserFamily');
        }

        return $this;
    }

    /**
     * Use the UserFamily relation UserFamily object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserFamilyQuery A secondary query class using the current class as primary query
     */
    public function useUserFamilyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserFamily($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserFamily', '\UserFamilyQuery');
    }

    /**
     * Filter the query by a related \UserLogin object
     *
     * @param \UserLogin|ObjectCollection $userLogin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByUserLogin($userLogin, $comparison = null)
    {
        if ($userLogin instanceof \UserLogin) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $userLogin->getParishId(), $comparison);
        } elseif ($userLogin instanceof ObjectCollection) {
            return $this
                ->useUserLoginQuery()
                ->filterByPrimaryKeys($userLogin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserLogin() only accepts arguments of type \UserLogin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserLogin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinUserLogin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserLogin');

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
            $this->addJoinObject($join, 'UserLogin');
        }

        return $this;
    }

    /**
     * Use the UserLogin relation UserLogin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserLoginQuery A secondary query class using the current class as primary query
     */
    public function useUserLoginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserLogin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserLogin', '\UserLoginQuery');
    }

    /**
     * Filter the query by a related \UserProfile object
     *
     * @param \UserProfile|ObjectCollection $userProfile the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByUserProfile($userProfile, $comparison = null)
    {
        if ($userProfile instanceof \UserProfile) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $userProfile->getParishId(), $comparison);
        } elseif ($userProfile instanceof ObjectCollection) {
            return $this
                ->useUserProfileQuery()
                ->filterByPrimaryKeys($userProfile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserProfile() only accepts arguments of type \UserProfile or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserProfile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinUserProfile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserProfile');

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
            $this->addJoinObject($join, 'UserProfile');
        }

        return $this;
    }

    /**
     * Use the UserProfile relation UserProfile object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserProfileQuery A secondary query class using the current class as primary query
     */
    public function useUserProfileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserProfile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserProfile', '\UserProfileQuery');
    }

    /**
     * Filter the query by a related \UserSubscription object
     *
     * @param \UserSubscription|ObjectCollection $userSubscription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParishQuery The current query, for fluid interface
     */
    public function filterByUserSubscription($userSubscription, $comparison = null)
    {
        if ($userSubscription instanceof \UserSubscription) {
            return $this
                ->addUsingAlias(ParishTableMap::COL_VALUE, $userSubscription->getParishId(), $comparison);
        } elseif ($userSubscription instanceof ObjectCollection) {
            return $this
                ->useUserSubscriptionQuery()
                ->filterByPrimaryKeys($userSubscription->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserSubscription() only accepts arguments of type \UserSubscription or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserSubscription relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function joinUserSubscription($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserSubscription');

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
            $this->addJoinObject($join, 'UserSubscription');
        }

        return $this;
    }

    /**
     * Use the UserSubscription relation UserSubscription object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserSubscriptionQuery A secondary query class using the current class as primary query
     */
    public function useUserSubscriptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserSubscription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSubscription', '\UserSubscriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildParish $parish Object to remove from the list of results
     *
     * @return $this|ChildParishQuery The current query, for fluid interface
     */
    public function prune($parish = null)
    {
        if ($parish) {
            $this->addUsingAlias(ParishTableMap::COL_VALUE, $parish->getValue(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the parish table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParishTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ParishTableMap::clearInstancePool();
            ParishTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ParishTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ParishTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ParishTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ParishTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ParishQuery
