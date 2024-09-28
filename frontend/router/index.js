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

		{
			path: "unit",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/crud/data.vue"
						),
				},
				{
					path: ":unit/show",
					name: "infrastructure-unit-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/crud/show.vue"
						),
				},
			],
		},

		{
			path: "unit-asset",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit-asset/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit-asset/crud/data.vue"
						),
				},
			]
		},


		{
			path: "assets",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-assets",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-assets-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/crud/create.vue"
						),
				},
				{
					path: ":assets/show",
					name: "infrastructure-assets-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/crud/show.vue"
						),
				},		
				{
					path: ":assets/edit",
					name: "infrastructure-assets-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/crud/edit.vue"
						),
				},			
			]
		},

		// {
		// 	path: "assets",
		// 	component: () =>
		// 		import(
		// 			/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/assets/index.vue"
		// 		),
		// 	children: [
		// 		{
		// 			path: "",
		// 			name: "infrastructure-assets",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/assets/create/data.vue"
		// 				),
		// 		},
		// 		{
		// 			path: "create",
		// 			name: "infrastructure-assets-create",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/assets/crud/create.vue"
		// 				),
		// 		},
		// 		{
		// 			path: "edit",
		// 			name: "infrastructure-assets-edit",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/assets/crud/edit.vue"
		// 				),
		// 		},
		// 		{
		// 			path: "show",
		// 			name: "infrastructure-assets-show",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit/assets/crud/show.vue"
		// 				),
		// 		},
		// 	]
		// },

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
