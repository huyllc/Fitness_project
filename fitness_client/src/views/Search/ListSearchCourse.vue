<template>
    <MainLayout>
        <div class="app-container">
            <List
                v-if="courses.length > 0"
                :page="page"
                :courses="courses"
                :pagination="pagination"
                :searchTerm="searchTerm"
            />
            <h1 v-if="!loading && courses.length <= 0" class="text-center">
                Không tìm thấy!
            </h1>
            <div class="text-center" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/layout/MainLayout.vue";
import List from "@/views/Search/List.vue";
import { onMounted, ref, watch, computed } from 'vue'
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import axios from "axios";
    const route = useRoute() 
    const store = useStore()
    const courses = ref([])
    const pagination = ref({})
    const loading = ref(false)

    watch(route, () => {
		getCourses()
	})

    onMounted(() => {
        getCourses();
    })  
    const getCourses = async() => {
        const searchTerm = route.query.search;
        const page = route.query.page;
        loading.value = true;

        try {
            const response = await axios.get(
                `search/?page=${page}&search=${searchTerm}`, { params: { limit: 9 } }
            );
            if (response.data) {
                courses.value = response.data.data;
                pagination.value = response.data.meta;
                loading.value = false;
            }
        } catch (err) {
            console.log(err.response);
        }
    }
    computed(() => store.getters.getUserInfor)
</script>
