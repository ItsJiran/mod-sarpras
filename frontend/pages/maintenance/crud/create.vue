<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ 
			combos : { morph_type_keys, types },
			record }">
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
						<v-text-field
							label="Deskripsi"
							v-model="record.description"
						></v-text-field>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="types" 
						label="Tipe Perawatan"
						v-model="record.type"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row v-if="record.type != undefined && record.tpe == 'berkala'" dense>
					<v-col cols="12">
						<v-combobox
						:items="types" 
						label="Tipe Perawatan"
						v-model="record.type"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

				<v-row dense>
					<v-col cols="12">
						<v-combobox
						:items="morph_type_keys" 
						label="Tipe Target Perawatan"
						v-model="record.maintenanceable_type"
						:return-object="false"
						></v-combobox>
					</v-col>
				</v-row>

			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "infrastructure-maintenance-create",
};
</script>
