# Domain Driven Design

> Any fool can write code that a computer can understand. Good programmers write code that humans can understand.
> 
> Refactoring: Improving the Design of Existing Code, 1999


## The Big Blue Book

**Domain-Driven Design: Tackling Complexity in the Heart of Software**
> a broad framework for making design decisions and a vocabulary for discussing domain design

* Written by Eric Evans
* 560 Pages

## Elevator Pitch
**DDD is a creative collaboration between domain practitioners and software practitioners that focuses on the *core domain* and speaks using an *ubiquitous language* within an explicitly *bounded context*.**


### You Right Now

![asleep](sleeping.jpg)

### Stick With Me
DDD is about writing code that is simple, and looks exactly like the business model it tries to represent.



## Build a New Feature With "The Alternative"

i.e. Model View Controller separates everything for us already.  Just use an MVC framework (CakePHP! Laravel! Primer!) and that's all you need.

* MVC separates functional concerns but not business concerns.
* "Fat Model Skinny Controller" === "Ball of mud in front of a router"
* Everything shared gets pushed down into a single layer; **everything**.
* Deep Object Hierarchy (Model extends AppModel extends BaseModel extends...) 
* There is no guidance on the Model layer.
* DDD is not an alternative to MVC.


## Overview

1. Bounded Context
2. Ubiquitous Language
3. Model-Driven Design
4. Layered Architecture
5. Building Blocks


