<template>
	<div class="container">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h3 class="p-0">List Courses</h3>	
			<div class="d-flex justify-content-between align-content-center gap-3">
				<Search @search="emitSearchQuery"/>
				<router-link to="/course/create" class="btn btn-create-course">
					Create New Course
				</router-link>
			</div>
		</div>

		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Course Title</th>
					<th scope="col">Description</th>
					<th scope="col">Time</th>
					<th scope="col">Thumbnail</th>
					<th scope="col">Status</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(course, index) in this.courses" :key="index">
					<td>{{ index + 1 + (pagination.current_page - 1) * 5 }}</td>
					<td>{{ course.title }}</td>
					<td style="max-width: 350px;">
						<SeeMore :text="course.description" :maxLength="120"/>
					</td>
					<td class="text-center">{{ course.duration }} {{ course.duration == 1 ? 'Month' : 'Months' }}</td>
					<td>
						<img :src="course.thumbnail" width="60" height="60" />
					</td>
					<td>{{ course.is_published ? "Allow" : "Considering" }}</td>
					<td>
						<RouterLink
							v-if="course.is_published == 1"
							:to="{ path: '/account/student-management/course/' + course.id }"
							type="button"
							class="btn me-2 btn-to-student"
							>Detail</RouterLink
						>
						<RouterLink
							:to="{ path: '/course/' + course.id + '/update' }"
							type="button"
							class="btn me-2 btn-edit"
							>Edit</RouterLink
						>
						<button
							v-if="!course.is_published"
							type="button"
							class="btn btn-outline-danger"
							@click="deleteCourse(course.id)"
						>Delete</button>
					</td>
				</tr>
			</tbody>
		</table>
  	</div>
</template>

<script setup>
	import { ref } from 'vue';
	import { getCookie } from '@/utils/cookie';
	import SeeMore from '@/components/SeeMore.vue';
	import Search from '@/components/Search.vue';
	import axios from 'axios';
	
	const props = defineProps({
		courses: {
			type: Array,
			default: () => []
		},
		pagination: {
			type: Object,
			default: () => ({})
		}
	});
	
	const emit = defineEmits(["search-query-changed"]);
	
	const user_type = ref(getCookie('user_type'));

	const emitSearchQuery = (query) => {
		emit('search-query-changed', query);
	};

	const deleteCourse = async (id) => {
		const response = await axios.delete(`course/${id}`);
	};
</script>

<style lang="scss">
.btn-to-student,
.btn-edit {
	border: 1px solid #ff4300;
	color: #ff4300;

	&:hover {
		background: #ff4300;
		color: #fff;
	}
}

.btn-create-course {
	background: #000;
	color: #fff;
	font-weight: 600;

	&:hover {
		background: #ff4300;
		color: #fff;
	}
}
</style>
