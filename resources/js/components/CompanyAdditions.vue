<template>
  <div class="company-additions">
  	<input type="hidden" name="json_data" :value="JSON.stringify(items)">

  	<p>Additions</p>
  	<button type="button" class="btn btn-success btn-sm mb-3" @click="add">Add</button>
    <div class="input-group mb-3" v-for="(item, index) in items" :key="index">
		  <input type="text" class="form-control" placeholder="Label" v-model="item.label">
		  <input type="text" class="form-control" placeholder="Value" v-model="item.value">
		   <div class="input-group-prepend">
		    <button type="button" class="btn btn-sm btn-danger" @click="remove(index)">Delete</button>
		  </div>
		</div>
		
  </div>
</template>

<script>
  export default {
  	props: ["dataCompany"],
    data() {
    	return {
    		items: []
    	}
    },
    created() {
      if (this.dataCompany && this.dataCompany.json_data) {
        var list = JSON.parse(this.dataCompany.json_data);
        if (list.length > 0) {
          this.items = list;
        }        
      }
    },
    methods: {
    	add() {
    		if (this.items.length >= 10) {
    			alert("Max 10 field!");
	    	} else {
	    		this.items.push({
	    			label: "",
	    			value: "",
	    		});	
	    	}
    	},
    	remove(index) {
        if (confirm("Are you delete ?")) {
          this.items.splice(index, 1);  
        }
    	}
    }
  }
</script>