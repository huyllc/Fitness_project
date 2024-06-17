<template>
    <div class="container">
        <div class="row">
            <h1 v-if="action == 'Add'">Add Course</h1>
            <h1 v-else>Update Course</h1>
        </div>
        <form @submit.prevent="createAndUpdateCourse">
            <div class="mb-3">
                <label for="courseTitle" class="form-label">Course title</label>
                <input name="title" type="text" class="form-control" id="courseTitle" v-model="course.title" />
                <span v-if="errors.title" class="text-danger">
                    {{"*" + errors.title}}
                </span>
            </div>
            <div class="mb-3">
                <label for="courseDescription" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"
                    v-model="course.description"></textarea>
                <span v-if="errors.description" class="text-danger">
                    {{"*" + errors.description}}
                </span>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" id="courseTitle" v-model="userProfile.name" disabled />
                </div>
                <div class="col-3">
                    <label class="form-label">Duration (months):</label>
                    <input name="duration" type="number" class="form-control" v-model="course.duration" />
                    <span v-if="errors.duration" class="text-danger">
                        {{"*" + errors.duration}}
                    </span>
                </div>
                <div class="col-3">
                    <label class="form-label">Level:</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Cấp độ</option>
                        <option value="1">Khó</option>
                        <option value="2">Trung bình</option>
                        <option value="3">Dễ</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail:</label>
                <input type="file" class="form-control" name="thumbnail" @change="handleImageSelected" />
                <div class="thumnail">
                    <img v-show="!imageUrl" :src="course.thumbnail" width="400" height="200" />
                    <img v-show="imageUrl" :src="imageUrl" width="400" height="200" />
                </div>
                <p v-if="errors.thumbnail" class="text-danger">
                    {{ "*" + errors.thumbnail }}
                </p>
            </div>
            <div class="mb-3">
                <h2 for="thumbnail" class="form-label">Course's video:</h2>
                <CourseVideo v-if="action === 'Add'" v-for="(video, index) in listVideos" :key="index" :video="video"
                    @remove-video="handleRemoveVideo"></CourseVideo>
                <CourseVideo v-if="action === 'Update'" v-for="(video, index) in listVideos" :key="index" :video="video"
                    @remove-video="handleRemoveVideo"></CourseVideo>
                <div class="mb-3">
                    <button type="button" class="btn btn-success" @click="addMoreVideo">
                        Add new video
                    </button>
                </div>
            </div>
            <div class="text-center mb-3">
                <button class="btn btn-primary text">Submit</button>
            </div>
        </form>
    </div>
</template>
<script setup>
    import { computed, onMounted, ref, watch } from "vue";
    import { getCookie } from "@/utils/cookie";
    import CourseVideo from "./CourseVideo.vue";
    import { useRoute, useRouter } from "vue-router";
    import { useStore } from "vuex";
    import axios from "axios";

    const router = useRouter()
    const route = useRoute()
    const store = useStore()
    const imageFile = ref({});
    const imageUrl = ref("");

    const handleImageSelected = (event) => {
        imageFile.value = event.target.files[0];
    }
    watch(imageFile, (current) => {
        if (!(current instanceof File)) {
            return;
        }

        let fileReader = new FileReader();

        fileReader.readAsDataURL(current);

        fileReader.addEventListener("load", () => {
            imageUrl.value = fileReader.result;
        });
    });
    const action = ref("Add")
    const errors = ref("")
    const course =  ref({
        title: "",
        user_id: getCookie("c_user"),
        description: "",
        duration: "",
        title_video: "",
        description_video: "",
    })
    const listVideos = ref([])
    const new_video = ref(0)

    onMounted(() => {
        if (route.params.id !== undefined) {
            getCourse(route.params.id);
        }
    })
    const userProfile = computed(() => {
        return store.getters.getUserInfor;
    })
    computed(() => {
        return store.getters.getToast;
    })

    const addMoreVideo = () => {
        listVideos.value.push({
            title: "",
            description: "",
            file: 0,
            link_video: "",
            new_video: new_video.value,
        });
        new_video.value++;
    }
    const handleRemoveVideo = (video) => {
        if (video.hasOwnProperty("new_video")) {
            const index = listVideos.value.findIndex(
                (item) => item.new_video == video.new_video
            );
            listVideos.value.splice(index, 1);
        } else {
            const index = listVideos.value.findIndex((item) => item.id == video.id);
            listVideos.value[index].deleteOldVideo = true;
        }
    }
    const createAndUpdateCourse = async () => {
        let data = new FormData();
        data.append("user_id", course.value.user_id);
        data.append("thumbnail", imageFile.value);
        data.append("title", course.value.title);
        data.append("description", course.value.description);
        data.append("duration", course.value.duration);
        listVideos.value.forEach((obj, index) => {
            Object.keys(obj).forEach((key) => {
                if (obj[key] instanceof File) {
                    data.append(`listVideos[${index}][${key}]`, obj[key]);
                } else {
                    data.append(`listVideos[${index}][${key}]`, obj[key]);
                }
            });
        });

        if (action.value == "Add") {
            try {
                const response = await axios.post("course", data);

                if (response) {
                    store.dispatch("fetchUserProfile");
                    router.push("/account/mycourses");
                }
                store.dispatch("setToast", {
                    content: "Create Success",
                    show: true,
                    type: "success",
                });
            } catch (error) {
                errors.value = error.response.data.details;
            }
        } else {
            try {
                data.append("_method", "put");
                const response = await axios.post(
                    `course/${route.params.id}`,
                    data
                );

                if (response) {
                    store.dispatch("fetchUserProfile");
                    router.push("/account/mycourses");
                }
                store.dispatch("setToast", {
                    content: "Update Success",
                    show: true,
                    type: "success",
                });
            } catch (error) {
                errors.value = error.response.data.details;
            }
        }
    }
    const getCourse = async (id) =>{
        action.value = "Update";
        const response = await axios.get(`course/${id}`);
        course.value = response.data.data;
        console.log(course.value)
        if (course.value.videos.length > 0) {
            listVideos.value = course.value.videos;
        }
    }
</script>