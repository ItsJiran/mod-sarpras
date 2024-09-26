<template  v-slot:default="{ 
	combos: { type_key, units, units_slug, units_status_map },
	record,
	store,
 }">

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Harga Dapat"
				v-model="record.receive_price"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Tanggal Dapat"
				v-model="record.receive_date"
			></v-text-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Tanggal Dapat"
				v-model="record.receive_date"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-assets-create-land",
	props: ['record'],
};
</script>
