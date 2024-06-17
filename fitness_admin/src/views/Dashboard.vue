<template>
    <MainLayout>
        <div class="row">
            <div class="col-4">
                <BlockTotal :title="'Total Trainers'" :count="total.total_trainer" />
            </div>
            <div class="col-4">
                <BlockTotal :title="'Total Students'" :count="total.total_student"/>
            </div>
            <div class="col-4"> 
                <BlockTotal :title="'Total Courses'" :count="total.total_course"/>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '@/layout/MainLayout.vue';
    import BlockTotal from '@/components/BlockTotal.vue';
    import { onMounted, ref } from 'vue';
    import axios from 'axios';

    const total = ref({});

    onMounted(() => {
        getTotal();
    })

    const getTotal = async () => {
        try {
            const response = await axios.get('admin/total');

            total.value = response.data;
        } catch (err) {
            throw new Error('error', err);
        }
    };
</script>