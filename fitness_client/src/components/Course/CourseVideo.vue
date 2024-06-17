<template>
    <div class="card border-secondary mb-3" v-if="!video.deleteOldVideo">
        <div class="card-header">
            <button type="button" class="btn-close btn-danger" aria-label="Close" @click="$emit('removeVideo', video)"></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="videoTitle" class="form-label">Video title</label>
                        <input
                            name="title_video"
                            type="text"
                            class="form-control"
                            v-model="video.title"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="courseTitle" class="form-label">Link Video:</label>
                        <input
                            name="link_video"
                            type="file"
                            class="form-control"
                            @change="handleChangeVideo($event)"
                        />
                    </div>
                    <div>
                        <video width="250" controls v-if="video.link_video">
                            <source :src="video.link_video" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                <label for="videoTitle" class="form-label">Video Description</label>
                <textarea
                    name="description_video"
                    type="text"
                    class="form-control"
                    v-model="video.description"
                    
                />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
    const props = defineProps({
        video: {},
    })
    onMounted(() => {
        if (!props.video.hasOwnProperty('file')) {
            props.video.file = 0;
        }
    }) 
        
    const handleChangeVideo = (e) => {
        props.video.file = e.target.files[0];
    }
</script>