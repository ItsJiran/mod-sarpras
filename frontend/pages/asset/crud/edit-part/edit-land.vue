<template v-slot:default="{ 
	record,
 }">
	<v-row dense>
		<v-col cols="6">
			<v-currency-field
				label="Harga Dapat"
				v-model="record.receive_price"
			></v-currency-field>
		</v-col>
		<v-col cols="6">
			<v-date-input
				label="Tanggal Dapat"
				v-model="record.receive_date"
			></v-date-input>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-edit-land",
	props: ['record'],
};
</script>
