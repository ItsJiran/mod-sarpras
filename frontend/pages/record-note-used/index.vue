<template>
	<page-crud v-if="checkRoute('infrastructure-record-note-used')"
		page-name="infrastructure-record-note-used"
		page-key="used"
	></page-crud>

	<page-crud v-if="checkRoute('infrastructure-tax-note-used')"
		page-name="infrastructure-tax-note-used"
		page-key="used"
		
		parent-name="infrastructure-tax-note-used"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-tax-note-used') "	
		page-name="infrastructure-asset-tax-note-used"
		page-key="used"

		parent-name="infrastructure-asset-tax-note"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-asset-document-tax-note-used') "	
		page-name="infrastructure-asset-document-tax-note-used"
		page-key="used"

		parent-name="infrastructure-asset-document-tax-note"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-document-tax-note-used') "	
		page-name="infrastructure-document-tax-note-used"
		page-key="used"

		parent-name="infrastructure-document-tax-note"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-tax-note-used') "	
		page-name="infrastructure-unit-asset-tax-note-used"
		page-key="used"

		parent-name="infrastructure-unit-asset-tax-note"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-asset-document-tax-note-used') "	
		page-name="infrastructure-unit-asset-document-tax-note-used"
		page-key="used"

		parent-name="infrastructure-unit-asset-document-tax-note"
		parent-key="note"
	></page-crud>

	<page-crud v-if=" checkRoute('infrastructure-unit-document-tax-note-used') "	
		page-name="infrastructure-unit-document-tax-note-used"
		page-key="used"

		parent-name="infrastructure-unit-document-tax-note"
		parent-key="note"
	></page-crud>
</template>

<script>
export default {
	name: "infrastructure-record-note-used",
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
