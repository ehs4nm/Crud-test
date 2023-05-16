# Laravel CRUD Test Assignment

This repository contains the implementation of my Laravel CRUD Test Assignment. The assignment includes various tasks related to Test-Driven Development (TDD), Domain-Driven Design (DDD), Behavior-Driven Development (BDD), Clean Architecture, and other stuff (all nice challenging 😃). The goal of the assignment is to showcase your understanding and proficiency in these areas. 
I have gathered some steps i've done here:

# Project Structure Overview
Understanding the project structure is essential for maintaining and extending the codebase. Here's an overview of the key directories in the project:
App
├───Adapters
│   ├───Presenters
│   └───ViewModels
├───Application
│   ├───DTO
│   ├───Mappers
│   └───UseCases
│       └───Customer
│           ├───Commands
│           └───Queries
├───Console
├───Domains
│   ├───Factories
│   ├───Interfaces
│   ├───Models
│   └───ValueObjects
├───Exceptions
├───Http
│   ├───Controllers
│   └───Middleware
├───Providers
└───Repositories

I haven't seperated the presention layer (also the Adapters folder is there for any chance of refactoring) and all tests are in laravel default folder (it could be placed within each corresponding layer of my application.)
I have useed [this](https://github.com/Orphail/laravel-ddd "a suggested laravel DDD and CA, without having to give away most of the features we love from Laravel"), [this](https://dev.to/bdelespierre/how-to-implement-clean-architecture-with-laravel-2f2i " a working implementation of the Clean Architecture principles inside a Laravel app") and [this](https://github.com/bdelespierre/laravel-clean-architecture-demo) for adapting the CA structure,


## RESULTS
| # 	| Description                                      	| Status 	|
|---	|--------------------------------------------------	|--------	|
| 1 	| TDD                                              	| Done ✅ 	|
| 2 	| DDD                                              	| Done ✅ 	|
| 3 	| BDD                                              	| Done ✅ 	|
| 4 	| Clean architecture (CA)                           | Done ✅ 	|
| 5 	| CQRS pattern                                      | Done ✅ 	|
| 6 	| Clean git commits that shows your work progress. 	| Done ✅ 	|
| 7 	| Use PHP 8.2                               	    | Done ✅ 	|
| 8 	| validate the phone number (Google LibPhoneNumber) | Done ✅ 	|
| 9 	| Store the phone number (varchar(20))              | Done ✅    |
| 10 	|                                                   | Done ✅ 	|
| 11 	| Customers must be unique in database: By ```Firstname```, ```Lastname``` and ```DateOfBirth```. 	| Done ✅ 	|
| 12 	| Email must be unique in the database.             | Done ✅ 	|
| 13 	| create a pull request (code review)               | Done ✅ 	|
| 14 	| clone the repository in a new github repository in private mode 	| Done ✅    |
| 15 	| share with ID: ```mason-chase```               	| Done ✅    |
| 16 	| Event sourcing                     	| Not yet 	|
| 17 	| A Valid email and a valid bank account check       	| Not yet 	|
| 18 	| Docker-compose that loads database service automatically with ```docker-compose up``` 	|   Not yet 	|
| 19 	| Web UI      	| Not yet 	|
| 20 	| Swagger     	| Not yet 	|
 

* I have done a lot of researches to decide on the architecture (CA) I know it needs more work and updates. Presentation layer is missing and needs to be addressed. I just made a few choice to implement it.


## TEST RESULTS
During the project different aspects of the project is tested and below you may see the test results.

![](./docs/test-results.png)

