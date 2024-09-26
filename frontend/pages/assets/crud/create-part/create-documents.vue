<template>
	
	<v-row dense>
		<v-col cols="12">
			<v-text-field
				label="Name"
				v-model="record.name"
			></v-text-field>
		</v-col>
	</v-row>

</template>

<script>
export default {
	name: "infrastructure-assets-create-documents",
	props: ['record'],
};
</script>
