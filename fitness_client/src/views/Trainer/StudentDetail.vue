<template>
	<MainLayout>
		<div class="app-container p-0">
			<div class="d-flex justify-content-between align-content-center mb-3">
				<h3 class="p-0" v-if="assignments.length > 0">
					Course: {{ assignments[0].course_title ?? "" }}
				</h3>
				<Search @search="searchVideo"/>
			</div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Title</th>
						<th scope="col">Description</th>
						<th scope="col">Video</th>
						<th scope="col">Student's video</th>
						<th scope="col">Score</th>
						<th scope="col" style="width: 300px">Comment</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(assignment, index) in assignments" :key="assignment.id">
						<td>{{ index + 1 + (pagination.current_page -1 ) * 5  }}</td>
						<td>{{ assignment.title }}</td>
						<td style="max-width: 250px;">
							<SeeMore :text="assignment.description" :maxLength="80"/>
						</td>
						<td>
                            <video width="250" controls>
                                <source :src="assignment.link_video" type="video/mp4">
                            </video>
						</td>
						<td>
							<video width="250" controls v-if="assignment.submission.length > 0">
								<source :src="assignment.submission[0].link_video" type="video/mp4"/>
							</video>
							<span v-else>Not submit</span>
						</td>
						<td>
							<div class="mb-2">
								<input
									name="grade"
									type="number"
									min="0"
									max="10"
									style="width: 50px"
									v-if="assignment.submission.length > 0"
									v-model="assignment.submission[0].grade"
								/>
								<span v-if="assignment.submission.length > 0">/10</span>
							</div>
						</td>
						<td>
							<div v-if="assignment.submission.length > 0">
								<textarea
								v-model="assignment.submission[0].feed_back"
								name="feed_back"
								class="w-100"
								rows="4"
								></textarea>
							</div>
						</td>
						<td>
							<button
								v-if="assignment.submission.length > 0"
								class="btn btn-primary"
								@click="updateSubmission(assignment.submission[0].id,assignment.submission[0].feed_back, assignment.submission[0].grade)"
							>
								Submit
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<Pagination 
				:pagination="pagination"
				:to="`account/student-management/course/${courseId}/student/${studentId}`"
			/>
		</div>
	</MainLayout>
</template>

<script setup>
	import MainLayout from "@/layout/MainLayout.vue";
	import Pagination from '@/components/Pagination.vue';
	import SeeMore from "@/components/SeeMore.vue";
	import Search from '@/components/Search.vue';
	import { onBeforeMount, watch, ref, defineProps } from "vue";
	import { useRoute, useRouter } from "vue-router";
	import axios from "axios";

	const props = defineProps(["studentId", "courseId"]);

	const assignments = ref([]);
	const pagination = ref({});
	const route = useRoute();
	const router = useRouter();

	onBeforeMount(() => {
		fetchAssignments()
	});

	watch(route, () => {
		fetchAssignments();
	});

	const fetchAssignments = async () => {
		const page= route.query.page;
		const search= route.query.search;

		try {
			const response = await axios.get(
				`user/enrollment/get/${props.studentId}/${props.courseId}?page=${page}`,
				{params: {search: search}}
			);
			assignments.value = response.data.data;
			pagination.value = response.data.meta;
			
		} catch (error) {
			if (error.response && error.response.status === 404) {
				router.push("/");
			} else {
				console.log(error.response);
			}
		}
	};

	const updateSubmission = async (id,feed_back, grade) => {
		try {
			let data = new FormData();
			data.append("feed_back", feed_back);
			data.append("grade", grade);
			const response = await axios.post(`/user/submission/update/${id}`,data)

			if(response){
				window.location.reload()
			}
		} catch (error) {
			console.log(error);
		}
	};

	const searchVideo = (query) => {
		if (query != '') {
			router.push(`/account/student-management/course/${props.courseId}/student/${props.studentId}?search=${query}`);
		} else {
			router.push(`/account/student-management/course/${props.courseId}/student/${props.studentId}`);
		}
	}
</script>