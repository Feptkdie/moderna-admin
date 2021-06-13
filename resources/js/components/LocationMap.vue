<template>
  <div class="mb-4">
    <input type="hidden" name="coord_x" :value="latLng.lat">
    <input type="hidden" name="coord_y" :value="latLng.lng">

    <div class="map-title mt-3 mb-3">Location:</div>
    <div class="p-2 bg-white rounded border">
      <div id="location-map"></div>
    </div>
  </div>
</template>

<script>
import { Loader } from "@googlemaps/js-api-loader";

const loader = new Loader({
  apiKey: "AIzaSyDVcH1Ipr1jyZerPuWGctiXT-6fl1lN1tI",
  libraries: ["places"]
});

export default {
  props: ["dataName", "dataCoordX", "dataCoordY"],
  data() {
    return {
      latLng : {
        lat: 47.9199332,
        lng: 106.9173425
      }, 
      mapOptions: {
        center: {
          lat: 47.9199332,
          lng: 106.9173425
        },
        zoom: 13
      }
    }
  },
  created() {
    if (this.dataCoordX) {
      this.mapOptions.center.lat = parseFloat(this.dataCoordX);
      this.latLng.lat = parseFloat(this.dataCoordX);
    }

    if (this.dataCoordY) {
      this.mapOptions.center.lng = parseFloat(this.dataCoordY);
      this.latLng.lng = parseFloat(this.dataCoordY);
    }
  },
  mounted() {
    loader.load().then(() => {
      const map = new google.maps.Map(document.getElementById("location-map"), this.mapOptions);
      const marker = new google.maps.Marker({
        position: this.latLng,
        map,
        draggable: true
      });
      
      const infowindow = new google.maps.InfoWindow({
        content: this.dataName,
      });

      marker.addListener("click", () => {
        infowindow.open(marker.get("location-map"), marker);
      });
      
      new google.maps.event.addListener(marker, "dragend", (evt) => {
        this.latLng.lat = evt.latLng.lat();
        this.latLng.lng = evt.latLng.lng();
      });
    })
    .catch(e => {
      console.log(e);
    });
  }
}
</script>

<style lang="scss" scoped>
  #location-map {
    width: 100%;
    min-height: 600px;;
  }
</style>