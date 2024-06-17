<template>
    <main-layout>
        <div class="container">
            <div class="align-items-center justify-content-center mb-3">
                <h3 class="d-inline-block">Student: {{ userStudent.name }}</h3>
                <form>
                    <div class="form-group row">
                        <div class="col-6 mt-2">
                            <label for="name">Name</label>
                            <input
                                type="name"
                                name="name"
                                class="form-control mt-2"
                                id="name"
                                readonly
                                :value="userStudent.name"
                            />
                        </div>
                        <div class="col-6 mt-2">
                            <label for="exampleFormControlInput1"
                                >Email address</label
                            >
                            <input
                                type="email"
                                class="form-control mt-2"
                                id="email"
                                readonly
                                :value="userStudent.email"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 mt-2">
                            <label for="name">Sex</label>
                            <input
                                type="sex"
                                name="sex"
                                class="form-control mt-2"
                                id="sex"
                                readonly
                                :value="
                                    userStudent.user_sex === 1
                                        ? 'Female'
                                        : 'Male'
                                "
                            />
                        </div>
                        <div class="col-6 mt-2">
                            <label for="name">Birthday</label>
                            <input
                                type="birthday"
                                name="birthday"
                                class="form-control mt-2"
                                id="birthday"
                                readonly
                                :value="userStudent.user_birthday"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 mt-2">
                            <label for="picture">Picture</label>
                            <div class="d-flex mt-2" style="width: 100%">
                                <img
                                    :src="userStudent.user_picture"
                                    class="logo-img"
                                    style="height: 100px; width: auto"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="detail" class="mt-2">Description:</label>
                        <textarea
                            style="height: 150px"
                            type="detail"
                            name="detail"
                            readonly
                            class="form-control shadow-none mt-1"
                            :value="userStudent.user_description"
                        >
                        </textarea>
                    </div>
                </form>
            </div>
            <Search :title="'List Course'" @search="handleSearch" />
            <table class="table table-hover mt-3">
                <thead class="">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Time</th>
                        <th scope="col">Thumbnail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="course in studentCourses" :key="course.id">
                        <td>{{ course.title }}</td>
                        <td style="max-width: 450px">
                            <SeeMore
                                :text="course.description"
                                :maxLength="150"
                            />
                        </td>
                        <td>
                            {{ course.duration }}
                            {{ course.duration == 1 ? "Month" : "Months" }}
                        </td>
                        <td>
                            <img :src="course.thumbnail" alt="" width="150px" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination-block">
                <Pagination :pagination="pagination" :to="`students/${id}`" />
            </div>
        </div>
    </main-layout>
</template>


<script setup>
    import BlockTotal from "@/components/BlockTotal.vue";
    import MainLayout from "@/layout/MainLayout.vue";
    import SeeMore from "@/components/Seemore.vue";
    import Pagination from "@/components/Pagination.vue";
    import Search from "@/components/Search.vue";
    import { ref, watch, onMounted, defineProps } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import axios from "axios";

    const props = defineProps(["id"]);

    const components = {
        MainLayout,
        BlockTotal,
        SeeMore,
        Pagination,
        Search,
    };

    const userStudent = ref([]);
    const studentCourses = ref([]);
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
     * Get Student Profile
     */
    const getStudentProfile = async () => {
        try {
            const page = route.query.page;
            const search = route.query.search;
            const { data } = await axios.get(
                `admin/user/student/${props.id}?page=${page ?? ""}&search=${
                    search ?? ""
                }`,
                { params: { limit: 5 } }
            );
            userStudent.value = data.student;
            studentCourses.value = data.courses.data;
            pagination.value = data.courses;
        } catch (err) {
            throw new Error("error", err);
        }
    };

    /**
     * Search Course
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