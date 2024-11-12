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

	<v-row dense>
		<v-col cols="12">
			<v-currency-field
				label="Atas Nama"
				v-model="record.atas_nama"
			></v-currency-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="6">
			<v-currency-field
				label="Luas Tanah Bumi"
				v-model="record.luas_bumi"
			></v-currency-field>
		</v-col>
		<v-col cols="6">
			<v-date-input
				label="Luas Tanah Bangunan"				
				v-model="record.luas_bangunan"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="6">
			<v-currency-field
				label="Njop Tanah Bumi"
				v-model="record.njop_bumi"
			></v-currency-field>
		</v-col>
		<v-col cols="6">
			<v-date-input
				label="Njop Tanah Bangunan"				
				v-model="record.njop_bangunan"
			></v-date-input>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-currency-field
				label="Alamat Wajib Pajak"
				v-model="record.alamat_wajib_pajak"
			></v-currency-field>
		</v-col>
	</v-row>

	<v-row dense>
		<v-col cols="12">
			<v-currency-field
				label="Alamat Objek Pajak"
				v-model="record.alamat_objek_pajak"
			></v-currency-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-asset-create-land",
	props: ['record'],
};
</script>
