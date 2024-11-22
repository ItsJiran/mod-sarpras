<template>
	<page-crud v-if=" checkRoute('infrastructure-record') "
		page-name="infrastructure-record"
		page-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-deadline') "
		page-name="infrastructure-deadline"
		page-key="record"
	></page-crud>

	<!-- +=================================================+ -->
	<!-- +------------------MAINTENANCE--------------------+ -->
	<!-- +=================================================+ -->

	<page-crud v-if=" checkRoute('infrastructure-tax') "
		page-name="infrastructure-tax"
		page-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-tax') "	
		page-name="infrastructure-asset-tax"
		page-key="record"

		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-tax') "	
		page-name="infrastructure-asset-document-tax"
		page-key="record"

		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-tax') "	
		page-name="infrastructure-document-tax"
		page-key="record"

		parent-name="infrastructure-document"
		parent-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-tax') "	
		page-name="infrastructure-unit-asset-tax"
		page-key="record"

		parent-name="infrastructure-unit-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-tax') "	
		page-name="infrastructure-unit-asset-document-tax"
		page-key="record"

		parent-name="infrastructure-unit-asset-document"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-tax') "	
		page-name="infrastructure-unit-document-tax"
		page-key="tax"
		
		parent-name="infrastructure-unit-document"
		parent-key="document"
	></page-crud>

	<!-- +=================================================+ -->
	<!-- +---------------------TAX-------------------------+ -->
	<!-- +=================================================+ -->

	<page-crud v-if=" checkRoute('infrastructure-maintenance') "
		page-name="infrastructure-maintenance"
		page-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-maintenance') "	
		page-name="infrastructure-asset-maintenance"
		page-key="record"

		parent-name="infrastructure-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-maintenance') "	
		page-name="infrastructure-asset-document-maintenance"
		page-key="record"

		parent-name="infrastructure-asset-document"
		parent-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-maintenance') "	
		page-name="infrastructure-document-maintenance"
		page-key="record"

		parent-name="infrastructure-document"
		parent-key="document"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-maintenance') "	
		page-name="infrastructure-unit-asset-maintenance"
		page-key="record"

		parent-name="infrastructure-unit-asset"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-maintenance') "	
		page-name="infrastructure-unit-asset-document-maintenance"
		page-key="record"

		parent-name="infrastructure-unit-asset-document"
		parent-key="asset"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-maintenance') "	
		page-name="infrastructure-unit-document-maintenance"
		page-key="record"
		
		parent-name="infrastructure-unit-document"
		parent-key="document"
	></page-crud>
</template>

<script>
export default {
	name: "infrastructure-record",
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
