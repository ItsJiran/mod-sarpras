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
						label="Pilih Unit"
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
	<!--     THIS IS HELP DESK      -->
	<!-- ========================  -->

		<template v-slot:helpdesk>


		</template>
	</form-show>
</template>

<script>

// assets type form
import Land from "./show-part/show-land";
import Document from "./show-part/show-documents";
import Electronic from "./show-part/show-electronic";
import Furniture from "./show-part/show-furniture";
import Vehicle from "./show-part/show-vehicle";

export default {
	name: "infrastructure-assets-show",

	components : {
		Land,
		Document,
		Electronic,
		Furniture,
		Vehicle,
	},

	methods : {
	},
};
</script>
