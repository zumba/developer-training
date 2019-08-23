# Model Driven design

Tightly relating the code to the underlying business model gives the code meaning and makes the model relevant.

The Domain Model code should reflect the business model

* The domain should not model the framework used or programming terms.
  * No mentions of `request` or `http` when talking about the domain.
  * No mentions of `Cache` or `db transaction` etc.
* The domain should not model the tables in the database
  * The business does not normalize their domain model like we do in the database.
  * Translation from the Domain model to the Database model happens in a repository (more on this later).
