# Articles APIs
This is a simple article api

# Requirements
PHP 7+, Docker and Composer are required.

# Installation
Start a docker machine
Clone the repository

After cloning the repository, Run:
1. Copy .env.example to a new file .env

2. Edit mail configuration in .env, change
    
   	MAIL_DRIVER=
    
    MAIL_HOST=
    
    MAIL_PORT=
    
    MAIL_USERNAME=
    
    MAIL_PASSWORD=
    
    MAIL_ENCRYPTION=
    
3. Edit APP_API_KEY= in .env
4. Open terminal and navigate to the app's directory
5. Run 'docker-compose up' to start the docker containers
6. Run 'docker-compose exec web bash ./start-fresh.sh' to migrate, clear cache and create default user
7. App can now be accessed on localhost:9000 and API on localhost:9000/api/...

# Endpoints
| Name  | Method |  URL |   Protected |
| ------------- | ------------- | ------------- | ------------- |
| List Articles | GET  | /articles  | no  |
| Create Article | POST  | /articles  | yes  |
| Get an Article | GET  | /articles/{id}  | no  |
| Update an Article | PUT/PATCH  | /articles/{id}  | yes  |
| Delete an Article | DELETE  | /articles/{id}  | yes  |
| Rate an Article | POST  | /articles/{id}/rating  | no  |
| Get my Articles | GET  | /my-articles  | yes  |
| Register User | post  | /register  | no |
| Login User | post  | /login  | no |
| Get User details | get  | /user  | yes |
| Search for article (name, year, article_type) | post  | /search  | no |


# Usage
1. Next,you login as default user with credentials in the config/default.php file. Make a post request to the login route with credentials

	"email" : “timothy33.tf@gmail.com”
	
	Password: “secret”
	
2. After successful login, a token is generated. Use token to a request every protected route

# Example Requests and Responses
### Register
    - url : localhost:9000/api/register
    - Request json: {'email': 'email address', password: 'password', name: 'user name'}
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY0ZDkxYzJl..."
    }
    
### Login
    - url : localhost:9000/api/login
    - method: POST
    - request json: {'email': 'email address', password: 'password'}
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6....."
    }
    
### Get User Details
    - url : localhost:9000/api/user
    - method : GET
    - headers: {'Content-Type' : 'application/json', Authorization: 'Bearer '. token}
    - response: 
    Status: 200
    {
    "user": {
        "id": 2,
        "name": "Timothy",
        "email": "email",
        "email_verified_at": null,
        "created_at": "2019-09-15 21:04:50",
        "updated_at": "2019-09-15 21:04:50"
        }
    }
    
### Create Article
    - url : localhost:9000/api/articles
    - method : POST
    - request json: {'title': 'John ohn hn', 'year': '2013', 'article_type': 'Frictional Journal'}
    - headers: {'Content-Type' : 'application/json', Authorization: 'Bearer '. token}
    - response: 
    Status: 200
    {
    "success": true,
    "data": {
        "title": "John ohn hn",
        "year": "2013",
        "article_type": "Frictional Journal",
        "author": 2,
        "updated_at": "2019-09-15 21:14:58",
        "created_at": "2019-09-15 21:14:58",
        "id": 1
        }
    }
    
### Get my Articles
    - url : localhost:9000/api/my-articles
    - method : GET
    - headers: {'Content-Type' : 'application/json', Authorization: 'Bearer '. token}
    - response: 
    Status: 200
    {
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "John ohn hn",
            "year": "2013",
            "author": "2",
            "article_type": "Frictional Journal",
            "deleted_at": null,
            "created_at": "2019-09-15 21:14:58",
            "updated_at": "2019-09-15 21:14:58"
          }
       ]
    }
    
### Get Articles
    - url : localhost:9000/api/articles
    - method : GET
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "John ohn hn",
            "year": "2013",
            "author": "2",
            "article_type": "Frictional Journal",
            "deleted_at": null,
            "created_at": "2019-09-15 21:14:58",
            "updated_at": "2019-09-15 21:14:58"
          }
       ]
    }

### Get Articles By ID
    - url : localhost:9000/api/articles/1
    - method : GET
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "John ohn hn",
            "year": "2013",
            "author": "2",
            "article_type": "Frictional Journal",
            "deleted_at": null,
            "created_at": "2019-09-15 21:14:58",
            "updated_at": "2019-09-15 21:14:58"
          }
       ]
    }
    
### Update Article
    - url : localhost:9000/api/articles/1
    - method : PUT
    - request json: {'year': '2011'}
    - headers: {'Content-Type' : 'application/json', Authorization: 'Bearer '. token}
    - response: 
    Status: 200
    {
    "success": true,
    "message": "Article has been updated"
    }
    
### Delete Article
    - url : localhost:9000/api/articles/1
    - method : DELETE
    - headers: {'Content-Type' : 'application/json', Authorization: 'Bearer '. token}
    - response: 
    Status: 200
    {
    "success": true,
    "message": "Article Deleted successfully"
    }
    
### Rating Article
    - url : localhost:9000/api/articles/1/rating
    - method : POST
    - request json: {"rating" : 5}
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
    "success": true,
    "message": "You have rated successfully"
    }

### Search Article
    - url : localhost:9000/api/search
    - method : POST
    - request json: {"query" : 2013}
    - headers: {'Content-Type' : 'application/json'}
    - response: 
    Status: 200
    {
    "success": true,
    "data": [
        {
            "searchable": {
                "id": 1,
                "title": "John ohn hn",
                "year": "2013",
                "author": "2",
                "article_type": "Frictional Journal",
                "deleted_at": null,
                "created_at": "2019-09-15 21:14:58",
                "updated_at": "2019-09-15 21:14:58"
            },
            "title": "John ohn hn",
            "url": "http://localhost:9000/api/articles/1",
                "type": "articles"
            }
        ]
    }
    
# Testing 
1. Run 'docker-compose up' to start the docker containers
2. Run 'docker-compose exec web bash ./run-tests.sh' to run test


# Contributing
All contributions are welcomed and can be made in form of pull requests

# Security Vulnerabilities
If you discover a security vulnerability within Articles APIs, please send an e-mail to Fadayini Timothy at timothy33.tf@gmail.com 

# License
Articles APIs is software licensed under the MIT license.


