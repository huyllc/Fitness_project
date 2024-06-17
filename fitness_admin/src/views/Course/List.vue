<template>
    <MainLayout>
        <Search :title="'List Course'" @search="handleSearch" />
        <div>
            <table class="table table-hover mt-3">
                <thead class="">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="courses.length > 0" v-for="course in courses" :key="course.id">
                        <td>{{ course.id }}</td>
                        <td>{{ course.title }}</td>
                        <td>
                            <img :src="course.thumbnail" alt="" width="150px">
                        </td>
                        <td>
                            <span class="" v-if="course.is_published == 1">
                                Accepted
                            </span>
                            <span class="" v-if="course.is_published == 0">
                                Rejected
                            </span>
                        </td>
                        <td>
                            <router-link :to="`/courses/${course.id}`" class="btn btn-to-detail text-decoration-none">View</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination 
                :pagination="paginationCourses"
                :to="'courses'"
            />
        </div>
    </MainLayout>
</template>

<script setup>
    import BlockTotal from '@/components/BlockTotal.vue';
    import MainLayout from '@/layout/MainLayout.vue';
    import Pagination from '@/components/Pagination.vue';
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from 'axios';

    const courses = ref({});
    const paginationCourses = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        getCourses();
    });

    watch(route, () => {
        getCourses();
    });

    /**
     * Get Course List
     */
    const getCourses = async () => {
        const page= route.query.page;
        const search = route.query.search;
        try {
            const response = await axios.get(`admin/course/get?page=${page ?? ''}&search=${search ?? ''}`, {params: {limit: 4}});
            courses.value = response.data.data;
            paginationCourses.value = response.data;
        } catch (err) {
            console.log(err);
        }
    };

    /**
     * Search Course
     */
    const handleSearch = (searchValue) => {
        if (searchValue != "") {
            router.push(`?search=${searchValue}`);
        } else {
            router.push(``);
        }
    };
</script>

<style lang="scss">
.btn-to-detail {
    border: 1px solid #5932EA;
	color: #5932EA;

	&:hover{
		background: #5932EA;
		color: #FFF;
	}
}

td {
  vertical-align: middle;
}
</style>