<template>
    <MainLayout>
        <div>
            <Search
                :title="`Trainer: ${userTrainer.name}`"
                @search="handleSearch"
            />
            <table class="table table-hover mt-3">
                <thead class="">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Time</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-if="userTrainerCourses.length > 0"
                        v-for="course in userTrainerCourses"
                        :key="course.id"
                    >
                        <td>{{ course.title }}</td>
                        <td style="max-width: 350px">
                            <SeeMore
                                :text="course.description"
                                :maxLength="80"
                            />
                        </td>
                        <td>
                            {{ course.duration }}
                            {{ course.duration == 1 ? "Month" : "Months" }}
                        </td>
                        <td>
                            <img :src="course.thumbnail" alt="" width="150px" />
                        </td>
                        <td>
                            <span v-if="course.is_published == 1">
                                Accepted
                            </span>
                            <span v-if="course.is_published == 0">
                                Rejected
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <router-link
                                    :to="`/trainers/course/${course.id}`"
                                    class="btn btn-to-detail text-decoration-none"
                                    >Student Manage</router-link
                                >
                                <router-link
                                    :to="`/courses/${course.id}`"
                                    class="btn btn-to-detail text-decoration-none"
                                    >View</router-link
                                >
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-block">
            <Pagination :pagination="pagination" :to="`trainers/${id}`" />
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from "@/layout/MainLayout.vue";
    import Pagination from "@/components/Pagination.vue";
    import SeeMore from "@/components/Seemore.vue";
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted, defineProps } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from 'axios';

    const props =  defineProps(["id"]);

    const components = {
        MainLayout,
        Pagination,
        SeeMore,
        Search,
    };

    const userTrainer = ref([]);
    const userTrainerCourses = ref([]);
    const pagination = ref({});
    const route = useRoute();
    const router = useRouter();

    onMounted(() => {
        getTrainerProfile();
    });

    watch(route, () => {
        getTrainerProfile();
    });

    const getTrainerProfile = async () => {
        try {
            const page = route.query.page;
            const search = route.query.search;
            
            const { data } = await axios.get(
                `admin/user/trainer/${props.id}?page=${page ?? ""}&search=${search ?? ""}`,
                { params: { limit: 4 } }
            );
            
            userTrainer.value = data.trainer;
            userTrainerCourses.value = data.courses.data;
            pagination.value = data.courses;
        } catch (err) {
            throw new Error("error", err);
        }
    };

    const handleSearch = (searchValue) => {
        if (searchValue !== "") {
            router.push(`${props.id}?search=${searchValue}`);
        } else {
            router.push(`${props.id}`);
        }
    };
</script>



<style lang="scss">
.btn-to-detail {
    border: 1px solid #5932ea;
    color: #5932ea;
    width: max-content;

    &:hover {
        background: #5932ea;
        color: #fff;
    }
}

.btn {
    margin-left: 5px;
    margin-right: 5px;
}

td {
    vertical-align: middle;
}
</style>