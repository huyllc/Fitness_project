<template>
    <MainLayout>
        <div class="app-container p-0">
            <div class="row mb-4 align-items-center">
                <div class="col-8">
                    <h1>{{ courseTitle }}</h1>
                </div>
                <div class="col-4 d-flex gap-3 justify-content-end">
                    <form action="" class="form-group" @submit.prevent="searchVideo($event)">
                        <input
                            type="text"
                            name="search"
                            class="form-control w-100 flex-grow-1"
                            placeholder="search"
                            v-model="searchValue"
                        />
                    </form>
                    <button type="button" class="btn btn-create-review px-4" data-bs-toggle="modal" data-bs-target="#modal-review">
                        Create Review
                    </button>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Video</th>
                        <th scope="col">Submit</th>
                        <th scope="col" style="width: 80px">Score</th>
                        <th scope="col" style="width: 300px">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(assingment, index) in assignments" :key="index">
                        <td>{{ index + 1 + (pagination.current_page -1 ) * 5  }}</td>
                        <td>{{ assingment.title }}</td>
                        <td style="max-width: 200px;">
                            <SeeMore :text="assingment.description" :maxLength="100"/>
                        </td>
                        <td>
                            <video width="250" controls>
                                <source :src="assingment.link_video" type="video/mp4">
                            </video>
                        </td>
                        <td v-if="assingment.submission.length <= 0">
                            <div class="mb-2">
                                <input class="form-control" type="file" @change="chooseVideo">
                            </div>
                            <button class="btn btn-primary" @click="handleUploadVideo($event, assingment.id)">Submit</button>
                        </td>
                        <td v-else>
                            <video width="250" controls>
                                <source :src="`http://127.0.0.1:8000/storage/${assingment.submission[0].link_video}`" type="video/mp4">
                            </video>
                        </td>
                        <td>
                            <span>
                                {{ 
                                    assingment.submission.length > 0 && assingment.submission[0].grade !== null 
                                    ?  assingment.submission[0].grade + "/10" 
                                    :  ".../10"
                                }}
                            </span>
                        </td>
                        <td>
                            <SeeMore 
                                v-if="assingment.submission.length > 0 && assingment.submission[0].feed_back !== null" :text="assingment.submission[0].feed_back"
                                :maxLength="80"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination 
				:pagination="pagination"
				:to="`account/mycourses/${courseId}`"
			/>

            <div class="modal fade" id="modal-review" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="w-100 p-2" rows="5" placeholder="Enter your review..." v-model="review.content"></textarea>
                            <div class="rating fs-3 d-flex gap-2 flex-row-reverse">
                                <span @click="setRatingReview(5)" :class="{ active: review.rate === 5 }">&#9733</span>
                                <span @click="setRatingReview(4)" :class="{ active: review.rate === 4 }">&#9733</span>
                                <span @click="setRatingReview(3)" :class="{ active: review.rate === 3 }">&#9733</span>
                                <span @click="setRatingReview(2)" :class="{ active: review.rate === 2 }">&#9733</span>
                                <span @click="setRatingReview(1)" :class="{ active: review.rate === 1 }">&#9733</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-submit-review px-3" @click="handleSubmitReview">Sent Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>

import MainLayout from '@/layout/MainLayout.vue';
import Pagination from '@/components/Pagination.vue';
import SeeMore from '@/components/SeeMore.vue';
import { ref, watch, onMounted, defineProps } from 'vue';
import { getCookie } from '@/utils/cookie';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { useStore } from 'vuex';


const props = defineProps(["courseId"]);

const assignments = ref([]);
const videoSubmit = ref(null);
const submission = ref([]);
const courseTitle = ref("");
const pagination = ref({});
const searchValue = ref("");
const closeModal = ref(null);
const route = useRoute();
const router = useRouter();
const store = useStore();

const review = ref({
    rate: null,
    content: '',
    course_id: props.courseId
});

onMounted(() => {
    fetchAssignment();
    getCourse();
});

watch(route, () => {
    fetchAssignment();
});

const fetchAssignment = async () => {
    const page = route.query.page; 
    const search = route.query.search;
    try {
        const response = await axios.get(`assignments/${props.courseId}?page=${page}`, {params: {search: search}} );
        if (response.data) {
            assignments.value = response.data.data;
            pagination.value = response.data.meta;
        }
    } catch (error) {
        if (error.response && error.response.status === 404) {
            // router.push('/');
        } else {
            console.log(error.response);
        }
    }
};

const chooseVideo = (event) => {
    videoSubmit.value = event.target.files[0];
};

const handleUploadVideo = async (event, assignment_id) => {
    let data = new FormData();
    if (videoSubmit.value == null || videoSubmit.value.type !== 'video/mp4') {
        $store.dispatch('setToast', {
            content: "Your video type is not valid",
            show: true,
            type: 'fail'
        });
        return;
    }
    data.append('file', videoSubmit.value);
    data.append('student_id', getCookie('c_user'));
    data.append('assignment_id', assignment_id);
    try {
        const response = await axios.post('user/submission/store', data);
        if (!response.data.error) {
            store.dispatch('setToast', {
                content: 'Congratulations, you have successfully uploaded the video',
                show: true,
                type: 'success'
            });
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } else {
            store.dispatch('setToast', {
                content: response.data.message,
                show: true
            });
        }
    } catch (err) {
        console.log(err.response);
    }
};

const getCourse = async () => {
    try {
        const response = await axios.get(`course/${props.courseId}`);
        courseTitle.value = response.data.data.title;
    } catch (err) {
        throw new Error(err);
    }
};

const searchVideo = (e) => {
    if (searchValue.value !== '') {
        router.push(`${props.courseId}?search=${searchValue.value}`);
    } else {
        router.push(`${props.courseId}`);
    }
};

const setRatingReview = (rating) => {
    review.value.rate = rating;
};

const handleSubmitReview = async () => {
    try {
        const response = await axios.post('review/store', review.value);
        if (!response.data.error) {
            closeModal.value.click();
            review.value.content = '';
            review.value.rate = null;
            store.dispatch('setToast', {
                content: response.data.message,
                type: 'success',
                show: true,
                expires: 0
            });
        }
    } catch (err) {
        throw new Error(err);
    }
    console.log(review.value);
};

</script>

<style lang="scss">
.assignment-fb{
    &.show-less{
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        width: 100%;
        max-width: 100%;
    }
}

.btn-create-review {
	background: #000;
	color: #fff;
	font-weight: 600;

	&:hover {
		background: #ff4300;
		color: #fff;
	}
}

#modal-review{
    textarea{
        border: 1px solid #ccc;
        border-radius: 8px;
        resize: none;
    }

    .btn-submit-review{
        background: #ff4300;
        color: white;
    }

    .rating{
        span{
            cursor: pointer;
            transition: all 0.25s;

            &:hover{
                color: orange;
                transform: scale(1.2);

                & ~ span{
                    color: orange;
                    transform: scale(1.2);
                }
            }

            &.active {
                color: orange;
                transform: scale(1.2);

                & ~ span{
                    color: orange;
                    transform: scale(1.2);
                }
            }
        }
    }
}
</style>