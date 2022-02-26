<template>
    <div class="w3-container">
        <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-dark-grey">
                <h5>Map</h5>
                <div id="map"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            console.log('loading map')
            this.initMap();
        },
        methods: {
            
            initMap() {
                setTimeout(() => {
                    const uluru = { lat: -25.344, lng: 131.036 };
                    const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 4,
                    center: uluru,
                    });

                    const marker = new google.maps.Marker({
                        position: uluru,
                        map: map,
                    });

                }, 2000)
                
            }
        }
    }
</script>
