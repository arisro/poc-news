Feature: News API v1 Routes
	In order to interact with the news component
	we need to have a RESTful API.

	Background:
		Given there are 3 "Poc\News\Article"s

	Scenario: Simple news list
		When I send a GET request to "/api/v1/news"
		Then the response code should be 200
		And the JSON response should contain 3 items

	Scenario: Creating a news successfully
		Given I have the payload:
		"""
		{
			"title": "Dummy news",
			"body": "This is just a test news!"
		}
		"""
		When I send a POST request to "/api/v1/news"
		Then the response code should be 201
		# also check the returned object is an Article
		When I send a GET request to "/api/v1/news"
		Then the JSON response should contain 4 items
		And there are 4 rows of "\Poc\News\Article"

	Scenario: Creating a news with invalid data
		Given I have the payload:
		"""
		{
			"title": "",
			"body": "This is just a test news!"
		}
		"""
		When I send a POST request to "/api/v1/news"
		Then the response code should be 400
		# response should containt 'errors'

	Scenario: Updating a non-existent news
		Given I have the payload:
		"""
		{
			"title": "dummy",
			"body": "This is just a test news!"
		}
		"""
		When I send a PUT request to "/api/v1/news/99"
		Then the response code should be 404

	Scenario: Updating a news with invalid data
		Given I have the payload:
		"""
		{
			"title": "1",
			"body": "This is just a test news!"
		}
		"""
		When I send a PUT request to "/api/v1/news/1"
		Then the response code should be 400

	Scenario: Updating a news successfully
		Given I have the payload:
		"""
		{
			"title": "Dummy title",
			"body": "This is just a test news!"
		}
		"""
		When I send a PUT request to "/api/v1/news/1"
		Then the response code should be 200
		# and instance of object an Article

	Scenario: Retrieve an article
		When I send a GET request to "/api/v1/news/1"
		Then the response code should be 200
		# And the JSON response should an instance of Article

	Scenario: Retrieving a not existent article
		When I send a GET request to "/api/v1/news/99"
		Then the response code should be 404

	Scenario: Deleting a non-existent article
		When I send a DELETE request to "/api/v1/news/99"
		Then the response code should be 404

	Scenario: Deleting an article successfully
		When I send a DELETE request to "/api/v1/news/3"
		Then the response code should be 204
		When I send a GET request to "/api/v1/news/3"
		Then the response code should be 404