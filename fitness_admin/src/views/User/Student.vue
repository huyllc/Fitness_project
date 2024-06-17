<template>
    <MainLayout>
        <div class="student">
            <Search :title="'List Student'" @search="handleSearch" />
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Picture</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(profile, index) in userStudent" :key="index">
                    <td>{{ profile.name }}</td>
                    <td>{{ profile.email }}</td>
                    <td>
                        <img :src="profile.user_picture" width="60" height="60" />
                    </td>
                    <td>
                        <div class="button-group">
                        <RouterLink
                            :to="{ path: 'students/' + profile.id }"
                            type="button"
                            class="btn btn-to-detail"
                        >
                            Detail
                        </RouterLink>
                        </div>
                    </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :pagination="paginationStudent" :to="'students'" />
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from "@/layout/MainLayout.vue";
    import Pagination from "@/components/Pagination.vue";
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from 'axios';
        
    const components = {
        MainLayout,
        Pagination,
        Search
    };

    const userStudent = ref({});
    const paginationStudent = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        getProfileStudent();
    });

    watch(route, () => {
        getProfileStudent();
    });

    /**
     * Get Profile Student
     */
    const getProfileStudent = async () => {
        try {
            const page = route.query.page;
            const search = route.query.search;
            const { data } = await axios.get(`admin/user?page=${page ?? ""}&search=${search ?? ""}`, { params: { limit: 8 } });
            userStudent.value = data.student.data;
            paginationStudent.value = data.student.pagination;
        } catch (err) {
            throw new Error("error", err);
        }
    };

    /**
     * Search Student
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
    width: max-content;

	&:hover{
		background: #5932EA;
		color: #FFF;
	}
}

td {
  vertical-align: middle;
}

ul {
  justify-content: center;
}
</style>