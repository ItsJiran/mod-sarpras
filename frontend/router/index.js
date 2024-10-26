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
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/create.vue"
						),
				},
				{
					path: ":asset/show",
					name: "infrastructure-unit-asset-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/show.vue"
						),
				},		
				{
					path: ":asset/edit",
					name: "infrastructure-unit-asset-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/asset/crud/edit.vue"
						),
				},
			]
		},

		{
			path: "unit/:unit/asset/:asset/document",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-unit-asset-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/show.vue"
						),
				},		
				{
					path: ":document/edit",
					name: "infrastructure-unit-asset-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/edit.vue"
						),
				},
			]
		},


		{
			path: "unit/:unit/document",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-unit-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/show.vue"
						),
				},		
				{
					path: ":document/edit",
					name: "infrastructure-unit-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/edit.vue"
						),
				},
			]
		},

		{
			path: "unit/:unit/asset/:asset/document",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-unit-asset-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/show.vue"
						),
				},		
				{
					path: ":document/edit",
					name: "infrastructure-unit-asset-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/edit.vue"
						),
				},	
			]
		},

		{
			path: "unit/:unit/asset/:asset/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-unit-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-unit-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},	
			]
		},

		{
			path: "document",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/show.vue"
						),
				},		
				{
					path: ":document/edit",
					name: "infrastructure-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/create.vue"
						),
				},
				{
					path: ":tax/show",
					name: "infrastructure-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/show.vue"
						),
				},		
				{
					path: ":tax/edit",
					name: "infrastructure-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
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
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/create.vue"
						),
				},
				{
					path: ":document/show",
					name: "infrastructure-asset-document-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/show.vue"
						),
				},
				{
					path: ":document/edit",
					name: "infrastructure-asset-document-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/document/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/create.vue"
						),
				},
				{
					path: ":tax/show",
					name: "infrastructure-asset-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/show.vue"
						),
				},		
				{
					path: ":tax/edit",
					name: "infrastructure-asset-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/tax/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-asset-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-asset-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-unit-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},
				{
					path: ":maintenance/edit",
					name: "infrastructure-unit-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},			
			]
		},


		{
			path: "unit/:unit/asset/:asset/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-unit-asset-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},
				{
					path: ":maintenance/edit",
					name: "infrastructure-unit-asset-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/create.vue"
						),
				},
				{
					path: ":maintenance/show",
					name: "infrastructure-unit-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/show.vue"
						),
				},		
				{
					path: ":maintenance/edit",
					name: "infrastructure-unit-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/maintenance/crud/edit.vue"
						),
				},
			]
		},
	],
};
