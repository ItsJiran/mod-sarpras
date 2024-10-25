<template>

	<page-crud v-if=" checkRoute('infrastructure-maintenance') "	
		page-name="infrastructure-maintenance"
		page-key="maintenance"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-maintenance') "	
		page-name="infrastructure-asset-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-maintenance') "	
		page-name="infrastructure-document-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-document"
		parent-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-maintenance') "	
		page-name="infrastructure-unit-asset-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-unit-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-maintenance') "	
		page-name="infrastructure-unit-asset-document-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-unit-asset-document"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-maintenance') "	
		page-name="infrastructure-unit-document-maintenance"
		page-key="maintenance"
		parent-name="infrastructure-unit-document"
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
