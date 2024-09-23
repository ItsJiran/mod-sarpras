export default {
	path: "/infrastructure",
	meta: { requiredAuth: true },
	component: () =>
		import(
			/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/Base.vue"
		),
	children: [
		{
			path: "",
			redirect: { name: "infrastructure-dashboard" },
		},

		{
			path: "dashboard",
			name: "infrastructure-dashboard",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/dashboard/index.vue"
				),
		},

		// pagename
		// {
		// 	path: "pagename",
		// 	component: () =>
		// 		import(
		// 			/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/pagename/index.vue"
		// 		),
		// 	children: [
		// 		{
		// 			path: "",
		// 			name: "infrastructure-pagename",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/pagename/crud/data.vue"
		// 				),
		// 		},

		// 		{
		// 			path: "create",
		// 			name: "infrastructure-pagename-create",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/pagename/crud/create.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/edit",
		// 			name: "infrastructure-pagename-edit",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/pagename/crud/edit.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/show",
		// 			name: "infrastructure-pagename-show",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/pagename/crud/show.vue"
		// 				),
		// 		},
		// 	],
		// },
	],
};
