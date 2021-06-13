<template>
  <div class="car-categories mb-3">
    <div class="form-group">
      <label for="cat1">Бүлэг:</label>
      <select class="form-control" id="cat1" v-model="cat1.val">
        <option value="" selected>-- Бүлэг нэмэх --</option>
        <option v-for="dataCategory in dataCategories" :key="dataCategory.id" :value="dataCategory.id">
          {{ dataCategory.name }}
        </option>
      </select>
    </div>
    <div class="form-group" v-if="cat1.val">
      <label for="cat2">Үйлдвэрлэгч</label>
      <select class="form-control" id="cat2" v-model="cat2.val">
        <option value="" selected>-- Үйлдвэрлэгч нэмэх --</option>
        <option v-for="opt in cat2.options" :key="opt.id" :value="opt.id">
          {{ opt.name }}
        </option>  
      </select>
    </div>

    <div class="form-group">
      <label for="name">{{ catName }}:</label>
      <input type="hidden" name="category_id" :value="category_id">
      <input type="text" name="name" class="form-control" id="name" :placeholder="catPlaceholderName">
    </div>
  </div>
</template>

<script>
export default {
  props: ["dataCategories"],
  data() {
    return {
      catName: "Бүлгийн нэр",
      catPlaceholderName: "Жишээ нь : Суудлын",
      category_id: "",
      cat1: {
        val: ""
      },
      cat2: {
        show: false,
        val: "",
        options: []
      }
    }
  },
  created() {
    console.log(this.dataCategories);
  },
  watch: {
    "cat1.val": function(dataId) {
      this.category_id = dataId;
      this.cat2.val = "";
      
      if (dataId) {
        this.catName = "Үйдвэрлэгчийн нэр";
        this.catPlaceholderName = "Жишээ нь : Hyundai";
        let filterCategory = this.dataCategories.find(data => data.id == dataId);
        if (filterCategory) {
          this.cat2.options = filterCategory.children_categories;
        }
      } else {
        this.catName = "Бүлгийн нэр";
        this.catPlaceholderName = "Жишээ нь : Суудлын";
      }
    },
    "cat2.val": function(dataId) {
      if (dataId) {
        this.category_id = dataId;
        this.catName = "Загварын нэр";
        this.catPlaceholderName = "Жишээ нь : Sonata-7";
      } else {
        this.category_id = this.cat1.val;
        this.catName = "Үйдвэрлэгчийн нэр";
        this.catPlaceholderName = "Жишээ нь : Hyundai";
      }
    }
  }
}
</script>