todoAppRoutes.push(
	{
		path: '/news',
		templateUrl: TodoApp.getPathForTemplate('poc/news/templates/news/index.html'),
		controller: 'newsListController'
	}
);

todoAppRoutes.push(
	{
		path: '/news/admin',
		templateUrl: TodoApp.getPathForTemplate('poc/news/templates/news/admin.html'),
		controller: 'newsAdminController'
	}
);

todoAppRoutes.push(
	{
		path: '/news/:newsId',
		templateUrl: TodoApp.getPathForTemplate('poc/news/templates/news/show.html'),
		controller: 'newsShowController'
	}
);