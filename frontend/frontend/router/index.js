export default {
	path: "/sarpras",
	meta: { requiredAuth: true },
	component: () =>
		import(
			/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/Base.vue"
		),
	children: [
		{
			path: "",
			redirect: { name: "sarpras-dashboard" },
		},

		{
			path: "dashboard",
			name: "sarpras-dashboard",
			component: () =>
				import(
					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/dashboard/index.vue"
				),
		},

		{
			path: "unit",			
			component: () =>
				import(
					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/unit/index.vue"
				),
			children: [
				{
					path: "",
					name: "sarpras-unit",
					component: () =>
						import(
							/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/unit/crud/data.vue"
						),
				},
			],

		},

		{
			path: "assets",
			component: () =>
				import(
					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/assets/index.vue"
				),
			children: [
				{
					path: "",
					name: "sarpras-assets",
					component: () =>
						import(
							/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/assets/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "sarpras-assets-create",
					component: () =>
						import(
							/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/assets/crud/create.vue"
						),
				}	
			]
		},


		

		// pagename
		// {
		// 	path: "pagename",
		// 	component: () =>
		// 		import(
		// 			/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/pagename/index.vue"
		// 		),
		// 	children: [
		// 		{
		// 			path: "",
		// 			name: "sarpras-pagename",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/pagename/crud/data.vue"
		// 				),
		// 		},

		// 		{
		// 			path: "create",
		// 			name: "sarpras-pagename-create",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/pagename/crud/create.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/edit",
		// 			name: "sarpras-pagename-edit",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/pagename/crud/edit.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/show",
		// 			name: "sarpras-pagename-show",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "sarpras" */ "@modules/sarpras/frontend/pages/pagename/crud/show.vue"
		// 				),
		// 		},
		// 	],
		// },
	],
};
