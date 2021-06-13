<template>
  <div class="car-categories-filter">
    <div class="form-group">
      <label for="cat1">Бүлэг:</label>
      <select class="form-control" id="cat1" v-model="cat1.val" name="car_group_id">
        <option value="" selected>-- Бүлэг сонгох --</option>
        <option v-for="dataCategory in dataCategories" :key="dataCategory.id" :value="dataCategory.id">
          {{ dataCategory.name }}
        </option>
      </select>
    </div>
    <div class="form-group" v-if="cat1.val">
      <label for="cat2">Үйлдвэрлэгч</label>
      <select class="form-control" id="cat2" v-model="cat2.val" name="car_mark_id">
        <option value="" selected>-- Үйлдвэрлэгч сонгох --</option>
        <option v-for="opt in cat2.options" :key="opt.id" :value="opt.id">
          {{ opt.name }}
        </option>  
      </select>
    </div>
    <div class="form-group" v-if="cat2.val">
      <label for="cat3">Загвар</label>
      <select class="form-control" id="cat3" v-model="cat3.val" name="car_model_id">
        <option value="" selected>-- Загвар сонгох --</option>
        <option v-for="opt in cat3.options" :key="opt.id" :value="opt.id">
          {{ opt.name }}
        </option>  
      </select>
    </div>
  </div>
</template>

<script>
export default {
  props: ["dataMode", "dataCar", "dataCategories"],
  data() {
    return {
      cat1: {
        val: ""
      },
      cat2: {
        val: "",
        options: []
      },
      cat3: {
        val: "",
        options: []
      }
    }
  },
  created() {
    if (this.dataMode == "edit") {
      if (this.dataCar && this.dataCar.car_group_id) {
        this.cat1.val = this.dataCar.car_group_id;

        if (this.dataCar.car_mark_id) {
          this.cat2.val = this.dataCar.car_mark_id;
        }

        if (this.dataCar.car_model_id) {
          this.cat3.val = this.dataCar.car_model_id;
        }
      }
      console.log(this.dataCar);
    }
  },
  watch: {
    "cat1.val": function(dataId) {
      // this.cat2.val = "";
      // this.cat3.val = "";
      if (dataId) {
        let filterCategory = this.dataCategories.find(data => data.id == dataId);
        if (filterCategory) {
          this.cat2.options = filterCategory.children_categories;
        }
      } 
    },
    "cat2.val": function(dataId) {
      // this.cat3.val = "";
      if (dataId) {
        let filterCategory = this.cat2.options.find(data => data.id == dataId);
        if (filterCategory) {
          this.cat3.options = filterCategory.children_categories;
        }
      } 
    }
  }
}
</script>