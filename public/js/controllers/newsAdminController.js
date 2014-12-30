angular.module('todoApp')
	.controller('newsAdminController', function($scope, $http, News) {
		$scope.newsData = {};
		$scope.loading = true;

		News.get()
			.success(function(data) {
				$scope.news = data;
				$scope.loading = false;
			});

		$scope.submitNews = function() {
			$scope.loading = true;

			News.save($scope.newsData)
				.success(function(data) {
					News.get()
						.success(function(getData) {
							$scope.news = getData;
							$scope.loading = false;
						})
				})
				.error(function(data) {
					console.log(data);
				});
		};

		$scope.editNews = function(news) {
			$scope.newsData = news;
		};

		$scope.formReset = function() {
			$scope.newsData = {};
		}

		$scope.deleteNews = function(news) {
			News.destroy(news.id)
				.success(function(data) {
					var index = $scope.news.indexOf(news);
  					$scope.news.splice(index, 1);
				});
		};
	});