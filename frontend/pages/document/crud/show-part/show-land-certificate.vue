<template>
	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Nik"
				v-model="record.nik"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>
	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Nip"
				v-model="record.nip"
				:readonly="true"
			></v-text-field>
		</v-col>
	</v-row>
</template>

<script>
import { readonly } from 'vue';

export default {
	name: "infrastructure-document-show-land-certificate",
	props: ['record'],
};
</script>
