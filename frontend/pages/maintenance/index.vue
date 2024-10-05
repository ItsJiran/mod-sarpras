<template>

	<page-crud v-if=" checkRoute('infrastructure-asset-maintenance')  "	
		page-name="infrastructure-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-maintenance') "	
		page-name="infrastructure-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-document"
		parent-key="document"
	></page-crud>

</template>

<script>
export default {
	name: "infrastructure-maintenance",
	methods : {
		checkRoute : function (name = "") {
			// route_name
			let route_name = this.$router.currentRoute._value.name;
			let methods = ['show','delete','update','edit','create'];

			for ( let method of methods ) 
				route_name = route_name.replaceAll('-' + method,'');
			
			return route_name == name;
		}
	}
};
</script>
