<template>
	<page-crud v-if=" checkRoute('infrastructure-tax') "
		page-name="infrastructure-tax"
		page-key="tax"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-tax') "	
		page-name="infrastructure-asset-tax"
		page-key="tax"
		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-tax') "	
		page-name="infrastructure-asset-document-tax"
		page-key="tax"
		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-tax') "	
		page-name="infrastructure-document-tax"
		page-key="tax"
		parent-name="infrastructure-document"
		parent-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-tax') "	
		page-name="infrastructure-unit-asset-tax"
		page-key="tax"
		parent-name="infrastructure-unit-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-tax') "	
		page-name="infrastructure-unit-asset-document-tax"
		page-key="tax"
		parent-name="infrastructure-unit-asset-document"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-tax') "	
		page-name="infrastructure-unit-document-tax"
		page-key="tax"
		parent-name="infrastructure-unit-document"
		parent-key="document"
	></page-crud>
</template>

<script>
export default {
	name: "infrastructure-tax",
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
