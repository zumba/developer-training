# Ubiquitous Language

> For first you write a sentence,
> And then you chop it small;
> Then mix the bits, and sort them out
> Just as they chance to fall:
> The order of the phrases makes
> No difference at all.
> 
> —Lewis Carroll, “Poeta Fit, Non Nascitur”

## Fractured Language

Within a single bounded context, language can be fractured in ways that undermine efforts to apply sophisticated modeling.

### Case Study: Products

#### Party in Pink™ Love Racerback - A0P00087

* Netsuite
  * **ITEM NAME/NUMBER**:  A0P00087
  * **DISPLAY NAME/CODE**: Party in Pink™ Love Racerback
  * **SALES DESCRIPTION**: Party in Pink Love Racerback
* Zumbawear Department
  * **Product Number**: A0P00087
  * **Product**: Party in Pink™ Love Racerback
  *  **??**: Party in Pink Love Racerback
* Our PHP Code:
  * `$product['code']`: A0P00087
  * `$product['name']`: Party in Pink™ Love Racerback
  * `$product['display_name']`: Party in Pink Love Racerback


1. The terminology of day-to-day discussions is disconnected from the terminology embedded in the code.
2. **Translation blunts communication.**  If I ask someone about the product code, what value do I want? Which language am I using?

## Define One Dictionary

1. Build a common, rigorous language between developers, users, and business units.
2. This language should be based on the Domain Model used by the business, and modeled in the software.
3. Domain experts should object to terms or structures that are awkward or inadequate to convey domain understanding.
4. Developers should watch for ambiguity or inconsistency that will trip up design.

### Example: Mixing Dictionaries

```php
$time = Time::fromValues($hours, $minutes);
$time = Time::fromString($time);
$time = Time::fromMinutesSinceMidnight($minutesSinceMidnight);
```

Three different vocabularies:

* `fromString` "string" is a PHP implementation detail. What is a string to the business?
* `fromValues` "values" is a generic programming term.  What values?
* `fromMinutesSinceMidnight` is part of the domain language.

```php
$time = Time::fromHoursAndMinutes($hours, $minutes);
$time = Time::fromText($time);
$time = Time::fromMinutesSinceMidnight($minutesSinceMidnight);
```

**Takeaway:** Use the business model as the backbone of a language. Commit the team to exercising that language relentlessly in all communication within the team and in the code. Within a bounded context, use the same language in diagrams, writing, and especially speech.

