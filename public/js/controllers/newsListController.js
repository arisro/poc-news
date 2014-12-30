angular.module('todoApp')
	.controller('newsListController', function($scope, $http, News) {
		$scope.newsData = {};
		$scope.loading = true;

		News.get()
			.success(function(data) {
				$scope.news = data;
				$scope.loading = false;
			});
	});