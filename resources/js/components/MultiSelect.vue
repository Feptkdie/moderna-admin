<template>
  <div class="form-group">
    <label>Categories</label>
    <multiselect 
      v-model="categories_id" 
      :options="dataCategories.map(category => category.id)" 
      :custom-label="opt => dataCategories.find(category => category.id == opt).name"
      :multiple="true"
    >
    </multiselect>
    <input type="hidden" name="categories_id" :value="categories_id">
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
  components: {
    Multiselect
  },
  props: ["dataMode", "dataSelectedCategories", "dataCategories"],
  data() {
    return {
      categoryOptions: [],
      categories_id: ""
    }
  },
  created() {
    if (this.dataMode == "edit") {
      if (this.dataSelectedCategories && this.dataSelectedCategories.length) {
        this.categories_id = this.dataSelectedCategories;
      }
    }
  }
}
</script>
