<template v-slot:default="{ 
	combos: { type_key },
	record,
	store,
 }">
	<h1>Documents</h1>
</template>

<script>
export default {
	setup(){
		console.log(record,store);
	},	
	name: "infrastructure-assets-create-documents",
};
</script>
