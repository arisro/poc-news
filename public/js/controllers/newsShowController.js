angular.module('todoApp')
	.controller('newsShowController', function($scope, $routeParams, $http, News) {
		$scope.news = {};
		$scope.loading = true;

		News.get($routeParams.newsId)
			.success(function(data) {
				$scope.news = data;
				$scope.loading = false;
			})
			.error(function(data, err) {
				$scope.loading = false;
				if (err == 404) {
					$scope.news = {title: 'News not found.', body: '' };
				} else {
					window.location = '/';
				}
			});
	});