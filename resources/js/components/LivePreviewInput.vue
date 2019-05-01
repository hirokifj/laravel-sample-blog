<template>
    <div>
        <label :for="keyName" class="form__label">
            <span class="label-text">サムネイル画像</span>
        </label>
        <input type="file" class="u-mb-small" :name="keyName" accept="image/*" @change="onFileChange($event)">

        <figure v-if="imageData" class="img-wrap">
            <img :src="imageData">
            <figcaption class="caption">【添付する画像】</figcaption>
        </figure>
        <figure v-else-if="oldImg" class="img-wrap">
            <img :src="oldImg">
            <figcaption class="caption">【現在、設定中の画像】</figcaption>
        </figure>
    </div>
</template>

<script>
    export default {
        props: ['keyName', 'oldImg'],
        data: function() {
            return {
                imageData: '',
            }
        },
        methods: {
            onFileChange(e) {
                const files = e.target.files

                if(files.length > 0) {
                    const file = files[0]
                    const reader = new FileReader()

                    reader.onload = (e) => {
                        this.imageData = e.target.result
                    }
                    reader.readAsDataURL(file)
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
.img-wrap {
    & img {
        width: 50%;
        height: auto;
    }
}
.caption {
    color: #999;
}
</style>
