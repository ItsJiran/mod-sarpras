<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos: { type_key },
			record,
			store,
		 }">
			<v-card-text>
				
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="type_key" 
						label="Tipe Assets"
						v-model="record.assets_type_key"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<!-- Tanah  -->
				<v-template v-if=" record.assets_type_key == 'Tanah' ">
					Tanah
				</v-template>

				<!-- KENDARAAN  -->
				<v-template v-if=" record.assets_type_key == 'Kendaraan' ">
					Kendaraan
				</v-template>

				<!-- PERABOTAN  -->
				<v-template v-if=" record.assets_type_key == 'Perabotan' ">
					Perabotan
				</v-template>
				
				<!-- ELEKTRONIk  -->
				<v-template v-if=" record.assets_type_key == 'Elektronik' ">
					Elektronik
				</v-template>
		
				<!-- ELEKTRONIk  -->
				<v-template v-if=" record.assets_type_key == 'Dokumen' ">
					Dokumen
				</v-template>				

			</v-card-text>
		</template>
	</form-create>
</template>

<script>

import CreateLand from "./create-land";
import CreateDocuments from "./create-documents";
import CreateElectronic from "./create-electronic";
import CreateFurniture from "./create-furniture";
import CreateVehicle from "./create-vehicle";

export default {
	name: "sarpras-assets-create",
	
	
	methods : {
		getAssetsType : function (record,store) {
			// if(store.combos == undefined) {
			// 	store.combos = {};
			// }

			// if(store.combos.type_key == undefined) {
			// 	store.combos.type_key = [];
			// }
	
			// this.$http(`sarpras/api/combos/type`).then(
			// 	(response) => {
			// 		store.combos.type = response.setups.combos.type_key;					
			// 	}
			// );

			// return store.combos.type;
		},
	},

	setup( props, {methods} ) {
		console.log(methods)
	}
};
</script>
