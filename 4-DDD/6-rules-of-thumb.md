# Rules of Thumb

There are some common pitfalls when working in a system such as this, and the following rules of thumb should make things easier.

## #1 - Prefer to use Uuid wherever possible.

`\Zumba\Domain\Universal\Identifier\Uuid`

* Auto-increment does not scale
  * Integers get big.
  * Service Oriented Architecture.
* Auto-increment ties the domain to the database
  * What about ES? What about Mongo?

## #2 - Don't misapply DRY principle

* A shipping customer entity is not a support customer entity, even though they share a few concepts and attributes.
* The shared kernel is `\Zumba\Domain\Universal`.  Only put objects in this namespace that can be shared by *many* bounded contexts, and represent something universal.

## #3 - Put validations in Value Objects.

* If you need to validate something, you probably have a Value Object on your hands, looking to get out.
* Avoid Primitive Obsession.

## #4 - Don't let your business logic leak.

* Think about the password policy service.
  * It's tempting to do these things in a controller or a model method somewhere.
  * Push business invariants down into the domain.

## #5 - At first, forget about the database.

* Build simple classes in the domain.  Focus on the business logic.
* Perform business logic in memory.  Pure methods.
* Write your repositories last.

## #6 Avoid overly broad, generic entity names.

**User** starts off as a perfectly fine name for an entity, until you end up putting *everything* in the `User` class.  It is better to avoid generic or overly-broad names like `User`.  Think about alternatives that are related to your bounded context:

### Alternatives to `User`
* A Blogging platform would have `Author` or maybe `Blogger`
* And admin application could have `Auditor` or `Agent` or something related to the domain.
* In the `Zumba\Domain\Authentication` namespace, I use `Record` to represent a user's identity record.  There is no `User` entity in the login code.

## #7 Embrace generic value objects where it makes sense.

Examples:

* `Zumba\Domain\Universal\Email\Address`
* `Zumba\Domain\Universal\Password\PlainText`
* `Zumba\Domain\Universal\Money\Currency`

