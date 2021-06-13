<template>
  <div class="car-multiple-upload mt-3 mb-3">
    <div class="d-flex" v-if="dataMode == 'edit'">
  		<div class="card ml-3 mb-3" style="width: 250px;" v-for="(image, index) in dataImages" :key="index">
			  <img :src="image.url" class="card-img-top" alt="slide" style="max-height:200px;">
			  <div class="card-body">
			  	<button type="button" @click="deleteImage(image)" class="btn btn-sm btn-danger">Delete</button>
			  </div>
			</div>
  	</div>

    <button type="button" class="btn btn-success rounded mb-3" @click="addFile">Зураг нэмэх</button>
    <ul class="list-group" >
      <li class="list-group-item" v-for="file in files" :key="file.id">
        <input type="file" name="files[]" accept="image/*" @change="previewImage" :data-id="file.id">
        <img :src="file.base64Url" v-if="file.base64Url" class="img-fluid" style="max-width:100px;">
        <button type="button" class="btn btn-sm btn-danger ml-2" @click="remove(file)">Устгах</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["dataMode", "dataId", "dataImages"],
  data() {
    return {
      count: 0,
      files: []
    }
  },
  methods: {
    addFile() {
      this.count = this.count + 1;
      this.files.push({
        id: this.count,
        base64Url: ""
      });
    },
    remove(file) {
      const index = this.files.indexOf(file);
      this.files.splice(index, 1);
    },
    previewImage(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = (e) => {
          const file = this.files.find(file => file.id == input.dataset.id);
          file.base64Url = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    },
    deleteImage(image) {
    	if (confirm("Are you delete this image ?")) {
	    	axios.post("/cars/image-delete/" + image.id).then((res) => {
	    		if (res.data.success) {
	    			window.location.href = "/cars/" + this.dataId + "/edit";
	    		}
	    		console.log(res);
	    	}).catch((err) => {
	    		console.log(err);
	    	});
	    }
    },
  }
}
</script>