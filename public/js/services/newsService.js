angular.module('todoApp')
	.factory('News', function($http) {
		var resourceUrl = '/api/v1/news';

		return {
			get: function(id) {
				if (id) {
					return $http.get(resourceUrl + '/' + id);
				} else {
					return $http.get(resourceUrl);
				}
			},

			save: function(newsData) {
				if (newsData.id) {
					return $http({
						method: 'PUT',
						url: resourceUrl + '/' + newsData.id,
						headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
						data: $.param(newsData)
					});
				} else {
					return $http({
						method: 'POST',
						url: resourceUrl,
						headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
						data: $.param(newsData)
					});
				}
			},

			destroy: function(id) {
				return $http.delete(resourceUrl + '/' + id);
			}
		}
	});