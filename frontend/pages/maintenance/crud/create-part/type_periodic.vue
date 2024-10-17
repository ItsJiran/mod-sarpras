<template>
    <v-row v-if="record.type != undefined && record.type == 'berkala'" dense>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Hari"
            v-model="record.period_number_day"
            :min="0"
            ></v-number-input>
        </v-col>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Bulan"
            v-model="record.period_number_month"
            :min="0"
            ></v-number-input>
        </v-col>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Tahun"
            v-model="record.period_number_year"
            :min="0"
            ></v-number-input>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "infrastructure-maintenance-create-type-period",
        props: ['record','data'],
    }
</script>