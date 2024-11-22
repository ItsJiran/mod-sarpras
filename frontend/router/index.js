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

		// + ==============================================================================================
		// + -------------------------------- UNIT ASSET PAGES JS -----------------------------------------
		// + ==============================================================================================

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

		// + ==============================================================================================
		// + ------------------------------ UNIT DOCUMENT PAGES JS ----------------------------------------
		// + ==============================================================================================

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
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},
				{
					path: ":record/edit",
					name: "infrastructure-unit-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/maintenance/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-unit-asset-maintenance-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},
				{
					path: ":note/edit",
					name: "infrastructure-unit-asset-maintenance-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/maintenance/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-unit-asset-maintenance-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},
				{
					path: ":used/edit",
					name: "infrastructure-unit-asset-maintenance-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-asset-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},
				{
					path: ":record/edit",
					name: "infrastructure-unit-asset-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/tax/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-tax-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-tax-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-unit-asset-tax-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},
				{
					path: ":note/edit",
					name: "infrastructure-unit-asset-tax-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/tax/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-tax-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-tax-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-unit-asset-tax-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},
				{
					path: ":used/edit",
					name: "infrastructure-unit-asset-tax-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-asset-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},
				{
					path: ":record/edit",
					name: "infrastructure-unit-asset-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/asset/:asset/document/:document/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-document-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-document-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-asset-document-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},
				{
					path: ":record/edit",
					name: "infrastructure-unit-asset-document-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "unit/:unit/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-unit-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},
			]
		},

		{
			path: "unit/:unit/document/:document/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-document-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-document-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-document-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-unit-document-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},
			]
		},

		// + ==============================================================================================
		// + -------------------------------- UNIT ASSET MAINTENANCE PAGES JS -----------------------------
		// + ==============================================================================================

		{
			path: "unit/:unit/asset/:asset/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-unit-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-unit-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-unit-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-unit-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},	
			]
		},

		// + ==============================================================================================
		// + -------------------------------- DOCUMENT PAGES JS -------------------------------------------
		// + ==============================================================================================

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
			path: "document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		// + ==============================================================================================
		// + ----------------------------------- DEADLINE PAGES JS ---------------------------------------------
		// + ==============================================================================================

		{
			path: "deadline",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-deadline",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-deadline-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-deadline-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-deadline-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "deadline/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-deadline-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-deadline-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-deadline-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-deadline-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "deadline/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-deadline-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-deadline-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-deadline-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-deadline-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		// + ==============================================================================================
		// + ----------------------------------- TAX PAGES JS ---------------------------------------------
		// + ==============================================================================================

		{
			path: "tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "tax/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-tax-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-tax-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-tax-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-tax-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "tax/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-tax-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-tax-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-tax-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},		
				{
					path: ":used/edit",
					name: "infrastructure-tax-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		// + ==============================================================================================
		// + --------------------------------- MAINTENANCES PAGES JS --------------------------------------
		// + ==============================================================================================

		{	
			path: "maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "maintenance/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-maintenance-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-maintenance-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-maintenance-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-maintenance-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "maintenance/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-maintenance-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-maintenance-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-maintenance-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},		
				{
					path: ":used/edit",
					name: "infrastructure-maintenance-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		// + ==============================================================================================
		// + --------------------------------- ASSET PAGES JS ---------------------------------------------
		// + ==============================================================================================

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
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-asset-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-asset-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-asset-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-asset-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		// + ==============================================================================================
		// + --------------------------------- ASSET PAGES JS ---------------------------------------------
		// + ==============================================================================================

		{
			path: "asset/:asset/document/:document/maintenance",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-maintenance",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-maintenance-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-asset-document-maintenance-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-asset-document-maintenance-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document/:document/maintenance/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-maintenance-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-maintenance-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-asset-document-maintenance-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-asset-document-maintenance-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document/:document/maintenance/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-maintenance-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-maintenance-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-asset-document-maintenance-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},		
				{
					path: ":used/edit",
					name: "infrastructure-asset-document-maintenance-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document/:document/tax",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-tax",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-tax-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/create.vue"
						),
				},
				{
					path: ":record/show",
					name: "infrastructure-asset-document-tax-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/show.vue"
						),
				},		
				{
					path: ":record/edit",
					name: "infrastructure-asset-document-tax-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record/crud/edit.vue"
						),
				},			
			]
		},


		{
			path: "asset/:asset/document/:document/tax/:record/note",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-tax-note",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-tax-note-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/create.vue"
						),
				},
				{
					path: ":note/show",
					name: "infrastructure-asset-document-tax-note-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/show.vue"
						),
				},		
				{
					path: ":note/edit",
					name: "infrastructure-asset-document-tax-note-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note/crud/edit.vue"
						),
				},			
			]
		},

		{
			path: "asset/:asset/document/:document/tax/:record/note/:note/used",
			component: () =>
				import(
					/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/index.vue"
				),
			children: [
				{
					path: "",
					name: "infrastructure-asset-document-tax-note-used",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/data.vue"
						),
				},
				{
					path: "create",
					name: "infrastructure-asset-document-tax-note-used-create",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/create.vue"
						),
				},
				{
					path: ":used/show",
					name: "infrastructure-asset-document-tax-note-used-show",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/show.vue"
						),
				},		
				{
					path: ":used/edit",
					name: "infrastructure-asset-document-tax-note-used-edit",
					component: () =>
						import(
							/* webpackChunkName: "infrastructure" */ "@modules/infrastructure/frontend/pages/record-note-used/crud/edit.vue"
						),
				},			
			]
		},

	],
};
