<template>
	<page-crud v-if="checkRoute('infrastructure-record-note')"
		page-name="infrastructure-record-note"
		page-key="note"
	></page-crud>

	<page-crud v-if="checkRoute('infrastructure-deadline-note')"
		page-name="infrastructure-deadline-note"
		page-key="note"
	></page-crud>

	<!-- +=================================================+ -->
	<!-- +---------------------TAX-------------------------+ -->
	<!-- +=================================================+ -->

	<page-crud v-if="checkRoute('infrastructure-tax-note')"
		page-name="infrastructure-tax-note"
		page-key="note"

		parent-name="infrastructure-tax"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-tax-note') "	
		page-name="infrastructure-asset-tax-note"
		page-key="note"
		
		parent-name="infrastructure-asset-tax"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-tax-note') "	
		page-name="infrastructure-asset-document-tax-note"
		page-key="note"

		parent-name="infrastructure-asset-document-tax"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-tax-note') "	
		page-name="infrastructure-document-tax-note"
		page-key="note"

		parent-name="infrastructure-document-tax"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-tax-note') "	
		page-name="infrastructure-unit-asset-tax-note"
		page-key="note"

		parent-name="infrastructure-unit-asset-tax"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-tax-note') "	
		page-name="infrastructure-unit-asset-document-tax-note"
		page-key="note"

		parent-name="infrastructure-unit-asset-document"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-tax-note') "	
		page-name="infrastructure-unit-document-tax-note"
		page-key="note"

		parent-name="infrastructure-unit-document-tax"
		parent-key="record"
	></page-crud>

	<!-- +=================================================+ -->
	<!-- +---------------------TAX-------------------------+ -->
	<!-- +=================================================+ -->

	<page-crud v-if="checkRoute('infrastructure-maintenance-note')"
		page-name="infrastructure-maintenance-note"
		page-key="note"

		parent-name="infrastructure-maintenance"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-maintenance-note') "	
		page-name="infrastructure-asset-maintenance-note"
		page-key="note"
		
		parent-name="infrastructure-asset-maintenance"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-maintenance-note') "	
		page-name="infrastructure-asset-document-maintenance-note"
		page-key="note"

		parent-name="infrastructure-asset-document-maintenance"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-maintenance-note') "	
		page-name="infrastructure-document-maintenance-note"
		page-key="note"

		parent-name="infrastructure-document-maintenance"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-maintenance-note') "	
		page-name="infrastructure-unit-asset-maintenance-note"
		page-key="note"

		parent-name="infrastructure-unit-asset-maintenance"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-maintenance-note') "	
		page-name="infrastructure-unit-asset-document-maintenance-note"
		page-key="note"

		parent-name="infrastructure-unit-asset-document"
		parent-key="record"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-maintenance-note') "	
		page-name="infrastructure-unit-document-maintenance-note"
		page-key="note"

		parent-name="infrastructure-unit-document-maintenance"
		parent-key="record"
	></page-crud>

</template>

<script>
export default {
	name: "infrastructure-record-note",
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
