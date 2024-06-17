<template>
	<MainLayout>
        <Search :title="'List Student'" @search="handleSearch" />
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">No. </th>
                    <th scope="col">Student name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Birthday</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in userStudent" :key="index">
                    <td>{{ index + 1 + (pagination.current_page -1 ) * 5  }}</td>
                    <td>{{ data.student.name }}</td>
                    <td>{{ data.student.email }}</td>
                    <td>{{ data.student.profile.sex ? "Female" : "Male" }}</td>
                    <td>{{ data.student.profile.birthday }}</td>
                </tr>
            </tbody>
        </table>
        <Pagination 
            :pagination="pagination"
            :to="`trainers/course/${id}`"
        />
	</MainLayout>
</template>

<script setup>
    import MainLayout from '@/layout/MainLayout.vue';
    import Pagination from '@/components/Pagination.vue';
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted, defineProps } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from 'axios';

    const props = defineProps(["id"]);

    const components = {
        MainLayout,
        Pagination,
        Search
    };

    const userStudent = ref({});
    const pagination = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        getStudentProfile();
    });

    watch(route, () => {
        getStudentProfile();
    });

    /**
     * Get List Student Of Course
     */
    const getStudentProfile = async () => {
        try {
            const page= route.query.page;
            const search= route.query.search;
            const {data} = await axios.get(`admin/user/trainer/course/${props.id}?page=${page ?? ''}&search=${search ?? ''}`, 
                                            {params: { limit: 5 }});
            userStudent.value = data.data;
            pagination.value = data.meta;
        } catch (err) {
            throw new Error("error", err);
        }
    };

    /**
     * Search Student
     */
    const handleSearch = (searchValue) => {
        if (searchValue != "") {
            router.push(`${props.id}?search=${searchValue}`);
        } else {
            router.push(`${props.id}`);
        }
    };
</script>

<style scoped>
.btn {
    margin-left: 5px;
    margin-right: 5px;
}

td {
    vertical-align: middle;
}

</style>