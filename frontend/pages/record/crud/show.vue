<template>
	<form-show
		with-helpdesk
	>
		<template v-slot:default="{ 
			record,
			combos : { 
				morph_record, 
				morph_record_keys, 

				morph_target, 
				morph_target_keys, 
			},
			}">
			<v-card-text>

				<!-- ------------------------ -->
				<!-- +--- DEFAULT PROPS ----+ -->

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
							label="Deskripsi"
							v-model="record.description"
							:readonly="true"
						></v-text-field>
					</v-col>
				</v-row>

				<!-- + ----------------------- + -->
				<!-- + --- TIPE Record ---- + -->

				<div class="text-overline mt-6">Tipe Record</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_record_keys" 
						label="Tipe Record"
						v-model="record.recordable_type_key"
						:readonly="true"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.recordable_type_key"
				/>

				<!-- ---------------------------------------- -->
				<!-- +--- DEADLINE TIPE Record MODEL ----+ -->

				<div class="text-overline mt-6">Tujuan Record</div>
				<v-divider :thickness="3" class="mt-3 mb-6" />

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_target_keys" 
						:return-object="false"
						label="Record Untuk"
						v-model="record.targetable_type_key"		
						@update:model-value="changeTargetType(record,this)"	
						:readonly="true"
						></v-combobox>
					</v-col>
				</v-row>

				<component 
					:record="record" 
					:data="this" 
					:is="record.targetable_type_key"
				/>	

			</v-card-text>
		</template>

		<template v-slot:info="{theme}">

			<v-btn
				class="mt-3"
				:color="theme"
				block
				variant="flat"
				@click="redirectPage('note')"
			>List Catatan</v-btn>

		</template>
	</form-show>
</template>

<script>

// TARGETABLE TYPE
import Asset from "./show-part/asset";
import Document from "./show-part/document";

// recordable TYPE
import Log from "./show-part/type_log.vue";
import Periodic from "./show-part/type_periodic.vue";

export default {
	name: "infrastructure-record-show",
	components : {	
		// TARGETABLE TYPE
		Asset,
		Document,

		// recordable TYPE
		Log,
		Periodic,
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
	}
};
</script>
