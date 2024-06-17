<template>
    <MainLayout>
		<TrainerListCourse :courses="userCourses" v-if="user_type === 'pt'" :pagination="pagination" @search-query-changed="handleSearchQueryChange"/>
		<StudentListCourses :courses="userCourses" v-if="user_type === 'student'" :pagination="pagination" @search-query-changed="handleSearchQueryChange"/>
		<Pagination 
            :pagination="pagination"
			:to="'account/mycourses'"
        />
	</MainLayout>
</template>


<script setup>
	import MainLayout from '@/layout/MainLayout.vue'
	import TrainerListCourse from '@/views/Trainer/TrainerListCourse.vue'
	import StudentListCourses from '@/views/Student/StudentListCourses.vue'
	import Pagination from '@/components/Pagination.vue'
	import { getCookie } from '@/utils/cookie'
	import { onMounted, ref, watch } from 'vue'
	import { useRouter, useRoute } from "vue-router";
	import axios from 'axios'

	const user_type = getCookie('user_type')
	const userCourses = ref([])
	const pagination = ref({})
	const router = useRouter()
	const route = useRoute()

	watch(route, () => {
		getUserCourses()
	})
	onMounted(() => {
		getUserCourses()
	})
	const handleSearchQueryChange = async (query) => {
		if (query) {
			query = '?search=' + query
		}
		router.push("mycourses" + query)
		getUserCourses()
	}
	const getUserCourses = async () => {
		try {
			const page = route.query.page;
			const query = route.query.search;
			const response = await axios.get(`user/courses?page=${page}${query ? '&search=' + query : ""}`);
			userCourses.value = response.data.data;
			pagination.value = response.data.meta;
		} catch (err) {
			throw new Error(err);
		}
	}
</script>