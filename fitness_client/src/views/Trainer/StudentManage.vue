<template>
	<MainLayout>
		<div class="container-lg">
			<div class="block-table">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h3 class="p-0">{{ courseTitle }}</h3>
					<Search @search="searchStudent"/>
				</div>
				<div class="shadow p-2 mb-3 rounded">
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Student name</th>
								<th scope="col">Sex</th>
								<th scope="col">Email</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(data, index) in students" :key="index">
								<td>{{ index + 1 + (pagination.current_page -1 ) * 5  }}</td>
								<td>{{ data.student.name }}</td>
								<td>{{ data.student.sex ? "Male" : "Female" }}</td>
								<td>{{ data.student.email }}</td>
								<td>
									<router-link
										:to="{
											name: 'student-management-detail', 
											params: {courseId: route.params.id, studentId: data.student.id}
										}"
										type="button"
										class="btn manage-student-detail"
									>Detail</router-link>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<Pagination 
				:pagination="pagination"
				:to="`account/student-management/course/${course_id}`"
			/>
		</div>
	</MainLayout>
</template>

<script setup>
	import MainLayout from "@/layout/MainLayout.vue";
	import Pagination from "@/components/Pagination.vue";
	import Search from "@/components/Search.vue";
	import { onMounted, ref, watch, defineProps } from 'vue';
	import { useRoute, useRouter } from "vue-router";
	import axios from "axios";

	const student = ref([]);
	const students = ref([]);
	const pagination = ref({});
	const courseTitle = ref("");
	const route = useRoute();
	const router = useRouter();
	const course_id = route.params.id;

	watch(route, () =>{
		getListStudent();
	});

	onMounted(() => {
		getListStudent();
		getCourse();
	});

	const getListStudent = async () => {
		const page= route.query.page;
		const search= route.query.search;

		const response = await axios.get(
			`/user/enrollment/course/${course_id}?page=${page ?? ''}&search=${search ?? ''}`
		);

		if (response.data) {
			students.value = ref([]);
			if (response.data.data.length > 0) {
				students.value = response.data.data;
			}
			pagination.value = response.data.meta;
		}
	};

	const getCourse = async () =>  {
		try {
			const response = await axios.get(`course/${course_id}`);
			courseTitle.value = response.data.data.title;
		} catch (err) {
			throw new Error(err);
		}
	};

	const searchStudent = (query) => {
		if (query != '') {
			router.push(`/account/student-management/course/${course_id}?search=${query}`);
		} else {
			router.push(`/account/student-management/course/${course_id}`);
		}
	};
</script>

<style lang="scss">
.manage-student-detail{
	border: 1px solid #FF4300;
	color: #FF4300;

	&:hover{
		background: #FF4300;
		color: #FFF;
	}
}
</style>
