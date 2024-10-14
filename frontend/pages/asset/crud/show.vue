<template>
	<form-show
		with-helpdesk
	>
	
	<!-- ========================  -->
	<!--   THIS IS DEFAULT FORM    -->
	<!-- ========================  -->

		<template v-slot:default="{ record }">
			<v-card-text>
				
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Slug"
							v-model="record.slug"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Assets"
						v-model="record.asset_type_key"
						:return-object="false"
						:readonly="true"
						></v-combobox>
					</v-col>	
				</v-row>

				<v-row dense>
					<v-col cols="6">
						<v-text-field
							label="Nama Unit"
							v-model="record.unit_name"
							:readonly="true"					
						></v-text-field>
					</v-col>
					<v-col cols="6">
						<v-combobox
						label="Slug Unit"
						v-model="record.slug_unit"
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:return-object="false"
						:readonly="true"					
						label="Status Asset"
						v-model="record.status"			
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record"
					:is="record.asset_type_key"/>							
			</v-card-text>
		</template>

	<!-- ========================  -->
	<!--     THIS IS HELP DESK     -->
	<!-- ========================  -->

		<template v-slot:helpdesk="{ theme }">

			<div class="text-overline mt-4">Aksi</div>
			<v-divider></v-divider>

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('document')"
				>List Documents</v-btn
			>

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('maintenance')"
				>List Maintenance</v-btn
			>

		</template>
	</form-show>
</template>

<script>

// assets type form
import Land from "./show-part/show-land";
import Electronic from "./show-part/show-electronic";
import Furniture from "./show-part/show-furniture";
import Vehicle from "./show-part/show-vehicle";

export default {
	name: "infrastructure-asset-show",

	components : {
		Land,
		Electronic,
		Furniture,
		Vehicle,
	},

	methods : {
		redirectPage : function ( name = '' ) {
			const current_route = this.$router.currentRoute._value;
			const current_route_name = current_route.name;
			
			let target_methods = ['show','create','delete','update'];
			let current_route_name_clean = current_route_name;

			for ( let method of target_methods )
				current_route_name_clean = current_route_name_clean.replaceAll(method,'');
			
			let redirect_to = current_route_name_clean + name;
			return this.$router.push({ name : redirect_to });
		}

	},
};
</script>
