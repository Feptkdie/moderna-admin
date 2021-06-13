<template>
  <div class="home-sliders mt-3 mb-3">
  	<p>Sliders</p>
  	
  	<div class="d-flex">
  		<div class="card ml-3 mb-3" style="width: 250px;" v-for="(slider, index) in sliders" :key="index">
			  <img :src="slider.url" class="card-img-top" alt="slide" style="max-height:200px;">
			  <div class="card-body">
			  	<button type="button" @click="deleteSlider(slider)" class="btn btn-sm btn-danger">Delete</button>
			  </div>
			</div>
  	</div>

    <button type="button" class="btn btn-success rounded mb-3" @click="addFile">Add slide</button>
    <ul class="list-group" >
      <li class="list-group-item" v-for="file in files" :key="file.id">
        <input type="file" name="files[]" accept="image/*" @change="previewImage" :data-id="file.id">
        <img :src="file.base64Url" v-if="file.base64Url" class="img-fluid" style="max-width:100px;">
        <button type="button" class="btn btn-sm btn-danger ml-2" @click="remove(file)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
	props: ["dataSliders"],
  data() {
    return {
      count: 0,
      files: [],
      sliders: []
    }
  },
  created() {
  	if (this.dataSliders && JSON.parse(this.dataSliders).length > 0) {
  		this.sliders = JSON.parse(this.dataSliders);
  	}
  	console.log(this.dataSliders);
  },
  methods: {
    addFile() {
   		if (this.files.length > 5 ) {
   			alert("Max 5 image");
   		} else {
   			this.count = this.count + 1;
	      this.files.push({
	        id: this.count,
	        base64Url: ""
	      });	
   		}
    },
    remove(file) {
      const index = this.files.indexOf(file);
      this.files.splice(index, 1);
    },
    deleteSlider(slider) {
    	if (confirm("Are you delete this slide ?")) {
	    	axios.post("/settings/slider-delete", { url: slider.url }).then((res) => {
	    		if (res.data.success) {
	    			window.location.href = "/settings";
	    		}
	    		console.log(res);
	    	}).catch((err) => {
	    		console.log(err);
	    	});
	    }
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
    }
  }
}
</script>

<style>
.carousel{
height: 100px !important;
} 
.carousel-inner .item{
	height:500px !important;
	background-size:cover !important;
	background-position: center center !important;
	}
</style>