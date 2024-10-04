<template>	
	<page-crud v-if=" checkRoute('infrastructure-document') "
		page-name="infrastructure-document"
		page-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document') "	
		page-name="infrastructure-asset-document"
		page-key="document"
		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document') "	
		page-name="infrastructure-unit-asset-document"
		page-key="document"
		parent-name="infrastructure-unit-asset"
		parent-key="asset"
	></page-crud>
</template>

<script>
export default {
	name: "infrastructure-document",
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
