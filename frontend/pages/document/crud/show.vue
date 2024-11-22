<template>
	<form-show
		with-helpdesk
	>
			<template v-slot:default="{ 
				combos: { type_key, units, units_slug, type_status_map, status },			
				record
				}">
			<v-card-text>

				<v-row dense>					
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							:readonly="true"
						></v-text-field>
					</v-col>
					<v-col cols="12">
						<v-text-field
							label="Description"
							v-model="record.description"
							:readonly="true"
						></v-text-field>
					</v-col>
					<v-col cols="12">
						<v-combobox
						:items="status" 
						label="Status"
						v-model="record.status"
						:return-object="false"
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<div class="text-overline mt-6">Form Document</div>
				<v-divider :thickness="3" class="mt-3 mb-5" />

				<v-row dense>					
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Document"
						v-model="record.documentable_type_key"
						:return-object="false"
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<component :record="record" :is="record.documentable_type_key"/>	

				<div class="text-overline mt-6">Terhubung Ke Unit</div>
				<v-divider :thickness="3" class="mt-3 mb-5" />

				<v-row v-if="record.unit != undefined" dense>
						<v-col cols="6">
							<v-text-field
								label="Nama Unit"
								v-model="record.unit.name"
								:readonly="true"					
							></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="units_slug" 
							label="Pilih Unit"
							v-model="record.unit.slug"
							:readonly="true"
							></v-combobox>
						</v-col>
					</v-row>

				<div class="text-overline mt-6">Terhubung Ke Asset</div>
				<v-divider :thickness="3" class="mt-3 mb-5" />

				<div v-if="record.asset != undefined && record.asset.id == undefined" dense>
					Tidak Terhubung Dengan Aset Manapun
				</div>

				<div v-if="record.asset != undefined && record.asset.id != undefined && record.asset.slug_unit != undefined" dense>				
					<v-row dense>
						<v-col cols="12">
							<v-combobox
							:items="assets_types" 
							label="Pilih Tipe Asset"
							v-model="record.asset.asset_type_key"
							:readonly="true"
							></v-combobox>
						</v-col>	
					</v-row>

					<v-row dense>
						<v-col cols="6">
						<v-text-field
							label="Nama Asset"
							v-model="record.asset.name"
							:readonly="true"
						></v-text-field>
						</v-col>
						<v-col cols="6">
							<v-combobox
							:items="assets_slugs_combos" 
							label="Pilih Asset Slug"
							v-model="record.asset.slug"
							:readonly="true"
							></v-combobox>
						</v-col>
					</v-row>
				</div>

			</v-card-text>
		</template>

		<template v-slot:info="{ theme }">

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('maintenance')"
				>List Maintenance</v-btn>

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('tax')"
				>List Tax</v-btn>

		</template>
	</form-show>
</template>

<script>
import LandCertificate from "./show-part/show-land-certificate";
export default {
	name: "infrastructure-document-show",
	components : {
		LandCertificate,
	},
	data(){
		return {
			
		}
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
