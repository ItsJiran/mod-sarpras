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
			path: "unit/:unit/asset",
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
				{
					path: "create",
					name: "infrastructure-unit-asset-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit-asset/crud/create.vue"
						),
				},
				{
					path: ":asset/show",
					name: "infrastructure-unit-asset-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit-asset/crud/show.vue"
						),
				},		
				{
					path: ":asset/edit",
					name: "infrastructure-unit-asset-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/unit-asset/crud/edit.vue"
						),
				},
			]
		},

		{
			path: "asset",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/create.vue"
						),
				},
				{
					path: ":asset/show",
					name: "infrastructure-asset-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/show.vue"
						),
				},		
				{
					path: ":asset/edit",
					name: "infrastructure-asset-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-asset-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-document/crud/show.vue"
						),
				},		
				{
					path: ":document/edit",
					name: "infrastructure-asset-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-document/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset-maintenance/crud/edit.vue"
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
