<template>
    <!-- -------------------------------------- -->
    <!-- +--- PERIODE TANGGAL PEMBAYARAN ----+ -->

    <v-row dense>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Hari"
            v-model="record.period_number_day"
            :readonly="true"
            :min="0"
            ></v-number-input>
        </v-col>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Bulan"
            v-model="record.period_number_month"
            :readonly="true"
            :min="0"
            ></v-number-input>
        </v-col>
        <v-col cols="4">
            <v-number-input
            label="Jumlah Tahun"
            v-model="record.period_number_year"
            :readonly="true"
            :min="0"
            ></v-number-input>
        </v-col>
    </v-row>

    <!-- -------------------------------------- -->
    <!-- +--- DEADLINE TANGGAL PEMBAYARAN ----+ -->

    <div class="text-overline mt-6">Deadline Tanggal Pembayaran</div>
    <v-divider :thickness="3" class="mt-3 mb-6" />

    <v-row dense>
        <v-col cols="12">
            <v-date-input
                label="Deadine Tanggal Pembayaran"
                v-model="record.duedate"
                :readonly="true"
            ></v-date-input>
        </v-col>
    </v-row>
    
</template>

<script>
    export default {
        name: "infrastructure-maintenance-create-type-period",
        props: ['record','data'],
    }
</script>