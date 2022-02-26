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
            this.getData();
        },
        methods: {
            getData() {
                console.log('calling api')
            }
        }
    }
</script>
