<template>
    <MainLayout>
        <div class="trainer">
            <Search :title="'List Trainer'" @search="handleSearch" />
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
                    <tr v-for="(profile, index) in userTrainer" :key="index">
                        <td>{{ profile.name }}</td>
                        <td>{{ profile.email }}</td>
                        <td>
                            <img :src="profile.user_picture" width="60" height="60" />
                        </td>
                        <td>
                            <div class="button-group">
                                <RouterLink 
                                    :to="{ path: '/trainers/' + profile.id }" 
                                    type="button"
                                    class="btn btn-outline-primary"
                                >
                                    Detail
                                </RouterLink>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination-block">
                <Pagination :pagination="paginationTrainer" :to="'trainers/'" />
            </div>
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
        Search,
    };

    const userTrainer = ref({});
    const paginationTrainer = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        getProfileTrainer();
    });

    watch(route, () => {
        getProfileTrainer();
    });

    /**
     * Get Profile Trainer
     */
    const getProfileTrainer = async () =>  {
        try {
            const page = route.query.page;
            const search = route.query.search;
            const { data } = await axios.get(
                `admin/user?page=${page ?? ""}&search=${search ?? ""}`,
                { params: { limit: 8 } }
            );
            userTrainer.value = data.trainer.data;
            paginationTrainer.value = data.trainer.pagination;
        } catch (err) {
            throw new Error("error", err);
        }
    };

    /**
     * Search Trainer
     */
    const handleSearch = (searchValue) => {
        if (searchValue != "") {
            router.push(`?search=${searchValue}`);
        } else {
            router.push(``);
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