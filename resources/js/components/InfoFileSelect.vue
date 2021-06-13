<template>
  <div class="info-fileselect__container">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="file_mode" id="exampleRadios1" v-model="fileType" value="image">
      <label class="form-check-label" for="exampleRadios1">
        Image
      </label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="file_mode" id="exampleRadios2" v-model="fileType" value="video">
      <label class="form-check-label" for="exampleRadios2">
        Video
      </label>
    </div>
    <div class="mt-3 mb-3">
      <input class="form-control-file border border-input-color bg-white p-1 rounded" name="file_path" type="file" v-if="fileType == 'image'">
      <input type="text" class="form-control" name="file_path" v-model="file_video" placeholder="video id" v-if="fileType == 'video'">

      <div v-if="dataMode == 'edit'">
        <div v-if="fileType == 'image' && dataInfo.file_mode == 'image'" class="mt-3 mb-3">
          <img :src="dataInfo.file_path" class="img-fluid" style="max-width:200px;" v-if="dataInfo.file_path">
        </div>

        <div v-if="fileType == 'video' && dataInfo.file_mode == 'video'" class="mt-3 mb-3">
          <iframe width="200" :src="'https://www.youtube.com/embed/' + dataInfo.file_path" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" v-if="dataInfo.file_path"></iframe>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["dataMode", "dataInfo"],
  data() {
    return {
      fileType: "image",
      file_video: ""
    }
  },
  created() {
    if (this.dataMode == "edit" && this.dataInfo) {
      this.fileType = this.dataInfo.file_mode;

      if (this.dataInfo.file_mode == "video" && this.dataInfo.file_path) {
        this.file_video = this.dataInfo.file_path;
      }
    }
  }
}
</script>