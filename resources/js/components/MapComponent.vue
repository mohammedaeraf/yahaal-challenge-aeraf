<template>
    <div class="w3-container">
        <div class="w3-dropdown-hover">
            <button class="w3-button w3-black">Filter</button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" @click="filterPersons('')" class="w3-bar-item w3-button">All</a>
                <a href="#" @click="filterPersons('Male')" class="w3-bar-item w3-button">Male</a>
                <a href="#" @click="filterPersons('Female')" class="w3-bar-item w3-button">Female</a>
            </div>
        </div>
        <div class="w3-row-padding" style="margin:0 -16px">
            <div id="map"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                persons: '',
                personsAll: '',
                searchText: '',
                map: null,
                mapCenter: {lat: 0, lng: 0},
                markers: [],
                gender: '',
                selectedCity: 'none',
                selectedCityObj: '',
                cities: [
                    {
                        title: 'London',
                        lat: '51.5285582',
                        lon: '-0.2416808'
                    },
                    {
                        title: 'Paris',
                        lat: '48.8588377',
                        lon: '2.2770203'
                    },
                    {
                        title: 'Kansas',
                        lat: '39.0915837',
                        lon: '-94.8559036'
                    }
                ] 
            }
        },
        mounted() {
            this.getPersons();
            this.initMap();
        },
        methods: {
            getPersons() {
                axios.get('/api/persons')
                .then(response => {
                    this.personsAll = response.data;
                    this.persons = this.personsAll;
                })
                .catch(err => console.error(err));
            },
            initMap() {
                setTimeout(() => {
                    this.map = new google.maps.Map(document.getElementById('map'), {
                    center: this.mapCenter,
                    zoom: 1,
                    maxZoom: 20,
                    minZoom: 3,
                    zoomControl: true
                });

                this.setMarkers();

                }, 2000)
                
            },  // end of initMap()

            setMarkers() {
                this.persons.map((person) => {
                    let contentString = `
                        <div class="w3-card w3-light-grey">
                            <h5>${person.first_name} ${person.last_name}</h5>
                            <p>${person.gender}</p>
                            <p>${person.lat} ${person.lon}</p>
                        </div>
                        `;

                    const infoWindow = new google.maps.InfoWindow({
                        content: contentString,
                    });

                    let iconUrl = "http://maps.google.com/mapfiles/ms/icons/";

                    let markerColor = person.gender === 'Male' ? 'blue' : 'pink';
                    iconUrl += markerColor + "-dot.png";

                    let marker = new google.maps.Marker({
                        position: new google.maps.LatLng(person.lat, person.lon),
                        //map: this.map,
                        icon: {
                            url: iconUrl
                        }
                    });

                    marker.addListener("click", () => {
                        infoWindow.open(this.map, marker);
                    });

                    this.markers.push(marker);
                }); // end of this.persons.map

                this.displayMarkers();

            },  // end of setMarkers()

            displayMarkers() {
                for (let i = 0; i < this.markers.length; i++) {
                    this.markers[i].setMap(this.map);
                }
            },

            deleteMarkers() {

                for (let marker of this.markers) {
                    marker.setMap(null);
                }
                this.markers = [];
            },

            resetMarkers() {
                this.deleteMarkers();
                this.setMarkers();
            },

            filterPersons(gender) {

                setTimeout(() => this.getPersons(), 3000);

                if (gender === '') {
                    this.initMap();
                    return true;
                }

                this.gender = gender;

                let filterPersons = (arr) => {
                    return arr.filter((el) => {
                        if (el.gender === undefined) return false;

                        return el.gender.toString() === this.gender ? true : false;
                    })
                }

                this.persons = filterPersons(this.personsAll);
                this.resetMarkers();
            },

        } // end of methods
    } // end of component
</script>
