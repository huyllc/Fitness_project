<template>
    <MainLayout>
        <div>
            <div class="mb-3">
                <label for="courseTitle" class="form-label">Course's name</label>
                <input
                    name="title"
                    type="text"
                    class="form-control"
                    :value="course.title"
                    disabled
                />
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="courseDescription" class="form-label">Description</label>
                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            disabled
                        >{{ course.description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" id="courseTitle" value="Test User" disabled />
                </div>
                <div class="col-3">
                    <label class="form-label">Time (months)</label>
                    <input
                        name="duration"
                        type="number"
                        class="form-control"
                        disabled
                        :value="course.duration"
                    />
                </div>
                <div class="col-3">
                    <label class="form-label">Difficulty</label>
                    <select
                        class="form-select"
                        aria-label="Default select example"
                        disabled
                    >
                        <option selected>Open this select menu</option>
                        <option value="1">Khó</option>
                        <option value="2">Trung bình</option>
                        <option value="3">Dễ</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label d-block">Thumbnail</label>
                        <img class="d-block" :src="course.thumbnail" alt="" style="width: 200px">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Course Lessons:</label>
                <div class="card border-secondary mb-3" v-for="video in course.videos" :key="video.id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="videoTitle" class="form-label">Video title</label>
                                    <input
                                        name="title_video"
                                        type="text"
                                        class="form-control"
                                        disabled
                                        :value="video.title"
                                    />
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="courseTitle" class="form-label">Video</label>
                                <video class="d-block w-100" controls>
                                    <source :src="video.link_video" type="video/mp4">
                                </video>
                            </div>
                            <div class="col-9">
                                <label for="videoTitle" class="form-label">Video description</label>
                                <textarea
                                    name="description_video"
                                    type="text"
                                    class="form-control"
                                    disabled
                                >{{ video.description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-3">
                <button 
                    class="btn btn-primary text mx-3" 
                    :class="{'disabled': course.is_published == 1}" 
                    @click="updateStatusCourse(1)"
                >
                    {{course.is_published == 1 ? 'Accepted' : 'Accept' }}
                </button>
                <button 
                    class="btn btn-danger text mx-3" 
                    :class="{'disabled': course.is_published == 0}"
                    @click="updateStatusCourse(0)"
                >
                    {{course.is_published == 0 ? 'Rejected' : 'Reject' }}
                </button>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '@/layout/MainLayout.vue';
    import { ref, onMounted, defineProps } from "vue";
    import axios from 'axios';

    const props = defineProps(['id']);
    const course = ref({});

    onMounted(() => {
        getCourse();
    });

    /**
     * Get Course Detail
     */
    const getCourse = async () => {
        try {
            const response = await axios.get(`admin/course/get/${props.id}`);
            course.value = response.data.data;
        } catch (err) {
            console.log(err);
        } 
    };

    /**
     * Update Status Of Course
     */
    const updateStatusCourse = async (status) => {
        try {
            const response = await axios.put(`admin/course/update/${course.value.id}`, {status: status});
            
            if (!response.data.error) {
                window.location.reload();
            }
        } catch (err) {
            throw new Error(err);
        }
    };
</script>