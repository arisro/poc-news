Feature: News API Routes
	In order to interact with the news component
	we need to have a RESTful API.

	Scenario: Simple news list
		When I send a GET request to "/api/news"
		Then the response code should be 200
		And the JSON response should contain 0 items

	Scenario: Creating a news
		Given I have the payload:
		"""
		{
			"title": "Dummy news",
			"body": "This is just a test news!"
		}
		"""
		When I send a POST request to "/api/news"
		Then the response code should be 200
		When I send a GET request to "/api/news"
		Then the JSON response should contain 1 item
		And there is 1 row of "\Poc\News\News"