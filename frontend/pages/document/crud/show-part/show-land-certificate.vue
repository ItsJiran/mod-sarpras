<template>
	<v-card-text>
		<v-row dense>
			<v-col cols="12">
				<v-text-field
					label="Nik"
					v-model="record.nik"
				></v-text-field>
			</v-col>
		</v-row>
		<v-row dense>
			<v-col cols="12">
				<v-text-field
					label="Nip"
					v-model="record.nip"
				></v-text-field>
			</v-col>
		</v-row>
	</v-card-text>
</template>

<script>
export default {
	name: "infrastructure-document-show-land-certificate",
	props: ['record'],
};
</script>
