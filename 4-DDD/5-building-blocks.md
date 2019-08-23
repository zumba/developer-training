# Building Blocks

1. Value Objects
2. Entities
3. Domain Services
4. Repositories

## Value Object

* Describes or computes some characteristic of a thing.
* Has no conceptual identity.
* Is immutable.
* Protects invariants (most validation goes here).

### Value Object Example

```php
namespace Zumba\Domain\Shipping;

use Respect\Validation\Validator;

class CountryCode {
    protected $code;
    protected function __construct(string $code)
    {
        $this->code = $code;
    }
    public static function fromText(string $code) : CurrencyCode
    {
        if (!Validator::countryCode()->validate($code)) {
            throw new InvalidCountryCode();
        }
        return new static($code);
    }
    public function __toString() : string
    {
        return $this->code;
    }
}
```

### Isn't that overkill?

Q: Why can't I just use a string in my entity?

A: That's called **Primitive Obsession**

### Primitive Obsession

1. Primitives "simulate" a type.  Using only strings and numbers everywhere is not semantic.
2. Sometimes entities have many fields.  Using primitives for these fields forces the entity to perform a *lot* of validations.
3. Value Objects invert the need to "validate everywhere".
   * If you have a "string" for a country code, do you trust it?  You probably check `!empty($code)` on it here, and again before you save it to the database, and again in the controller, and again...
   * With a Value Object `CountryCode` you know it isn't empty because it was already validated when it was constructed.

## Entity

* May have attributes (value objects).  Attributes may change over time, but entity identity does not change.
* Distinguished by it's identity, not it's attributes.
* Typically does not validate attributes (should be done in the value objects themselves), but can validate cross-cutting validations that span multiple attributes.


### Entity Example

```php
namespace Zumba\Domain\Shipping;

use \Zumba\Domain\Universal\Identifier\Uuid;

class Customer {
    protected $id;
    protected $name;
    protected function __construct(Uuid $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public static function fromOrder(Order $order) : Customer
    {
        $id = Uuid::fromText((string)$order->customerId());
        $name = Name::fromText((string)$order->customerName());
        return new static($id, $name);
    }
    public function name() : Name
    {
        return $this->name;
    }
    public function id() : Uuid
    {
        return $this->id;
    }
}
```

## Domain Service

> Sometimes, it just isn’t a thing.

Forcing a model or a value object to have the responsibility of such a requirement either distorts the meaning of those objects, or violates SRP.

### Example

Scenario:  When a) resetting a password, b) creating a new password, or c) asking the backend if a user's chosen password is valid, we need to:

* ensure that a chosen password is not in a blacklist (of 10,000 passwords),
* does not contain the user's username, and
* has never been used by that user before.

```php
namespace Zumba\Domain\Authentication;

class PasswordPolicy {
	protected $blacklist;
	protected $passwords;
	protected function __construct(BlacklistRepository $blacklist, passwords $passwords) {
		$this->blacklist = $blacklist;
		$this->passwords = $passwords;
	}
	public static function fromBlacklistAndPasswords(
        BlacklistRepository $blacklist,
		Passwords $passwords
	) : PasswordPolicy
    {
		return new static($blacklist, $passwords);
	}
	public function verify(Record $record, Password $password) : bool {
		// password cannot contain the user's username
		$record->checkPasswordForUsername($password);

		// password cannot be in the blacklist.
		if ($this->blacklist->contains(Hash::insecureHashFromPassword($password))) {
			throw new PasswordBlacklisted();
		}

		// password can never be used more than once.
		if ($this->passwords->contains($record->id(), $password)) {
			throw new PasswordAlreadyUsed();
		}
		return true;
	}
}
```

## Repositories

> Query access to objects in the domain, expressed in the ubiquitous language.

The sheer technical complexity of dealing with a database (connection, transactions, mapping entities to table fields, normalization, joins, etc.) quickly swamps the code and dwarfs the domain code.  This leads developers to dumb-down the domain layer, making the model irrelevant.

Repositories (in our code) serve as a boundary and between the database model and the domain model.  Repositories translate database model data to-and-from domain entities.

* Separates the persistence / storage mechanism from the business logic.
* Simplifies the database model.
* Behaves as an adapter between the ubiquitous language of the domain and the system / framework language of the application.

### Repository Example

```php
namespace Zumba\Domain\Shipping;

use \Zumba\Model\User;

class CustomerRepository {
    protected $model;
    protected static function __construct(User $model)
    {
        $this->model = $model;
    }
    public static function fromUserModel(User $model) : CustomerRepository
    {
        return new static($model);
    }
    public function getById(Uuid $customerId) : Customer
    {
        $data = $this->model->findUSerById((string)$customerId);
        return Customer::fromData($data['id'] ?? '', $data['name'] ?? '');
    }
    public function store(Customer $customer) : void
    {
        $this->model->save((string)$customer->id(), [
            'name' => (string)$customer->name()
        ]);
    }
}
```