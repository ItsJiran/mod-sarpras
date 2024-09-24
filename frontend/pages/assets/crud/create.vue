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

			</v-card-text>
		</template>
	</form-create>
</template>

<script>

// assets type form
import CreateLand from "./create-part/create-land";
import CreateDocuments from "./create-part/create-documents";
import CreateElectronic from "./create-part/create-electronic";
import CreateFurniture from "./create-part/create-furniture";
import CreateVehicle from "./create-part/create-vehicle";

export default {
	name: "infrastructure-assets-create",

	methods : {
		getAssetsType : function (record,store) {
		},
	},

	setup( props, {methods} ) {
		console.log(methods)
	}
};
</script>
