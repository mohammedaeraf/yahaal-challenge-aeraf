<template>
    <div class="w3-container w3-row-padding w3-margin-bottom">
        <div class="w3-dropdown-hover w3-third">
            <button class="w3-button w3-lightgray">Filter by Gender</button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" @click="filterPersonsByGender('')" class="w3-bar-item w3-button">All</a>
                <a href="#" @click="filterPersonsByGender('Male')" class="w3-bar-item w3-button">Male</a>
                <a href="#" @click="filterPersonsByGender('Female')" class="w3-bar-item w3-button">Female</a>
            </div>
        </div>
        <div class="w3-dropdown-hover w3-third">
            <button class="w3-button w3-blue">Filter by City (within 2000 Km)</button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" class="w3-bar-item w3-button" @click="filterPersonsByCity('')">None</a>
                <a v-for="city in cities" :value="city.title" @click="filterPersonsByCity(city.title)"
                 href="#"  class="w3-bar-item w3-button">{{ city.title }}</a>
            </div>
        </div>
         <div class="w3-third">
            <input v-model="searchText" class="w3-input" type="text" placeholder="Enter letter to search" maxlength="1">
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
                cities: [
                    {
                        title: 'London',
                        lat: '51.509865',
                        lon: '-0.118092'
                    },
                    {
                        title: 'Paris',
                        lat: '48.864716',
                        lon: '2.349014'
                    },
                    {
                        title: 'Kansas',
                        lat: '39.011902',
                        lon: '-98.484245'
                    }
                ] 
            }
        },
        mounted() {
            this.getPersons();
            this.initMap();
        },
        watch: {
            searchText: function (oldValue, newValue) {
                this.filterPersonsByName(oldValue);
            }
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

            filterPersonsByGender(gender) {

                // if all selected, load all persons data and reset markers
                if (gender === '') {
                    this.persons = this.personsAll;
                    this.resetMarkers();
                    return true;
                }

                this.gender = gender;

                let filterPersons = (persons) => {
                    return persons.filter((person) => {
                        if (person.gender === undefined) return false;

                        return person.gender.toString() === this.gender ? true : false;
                    })
                }

                this.persons = filterPersons(this.personsAll);
                this.resetMarkers();
            },

            filterPersonsByName(value) {

                const filterItems = (persons, searchStr) => {
                    return persons.filter((person) => {
                        if (person.first_name === undefined) {
                            return false;
                        }
                        searchStr = searchStr.toLowerCase();
                        let fName = person.first_name.toLowerCase();
                        let lName = person.last_name.toLowerCase();

                        if ( fName.startsWith(searchStr) || lName.startsWith(searchStr) ) {
                            return true;
                        }
                    })
                }

                this.persons = filterItems(this.personsAll, this.searchText);

                if (value === '') {
                    this.persons = this.personsAll;
                }

                this.resetMarkers();
            },

            filterPersonsByCity(cityTitle) {
                // show all persons, reset center and markers
                if (cityTitle === ''){
                    this.persons = this.personsAll;
                    this.mapCenter = new google.maps.LatLng(0,0);
                    this.map.panTo(this.mapCenter);
                    this.resetMarkers();
                    return true;
                }

                let cityObj = this.cities.filter((city) => {
                    return city.title === cityTitle;
                })

                const filterPersons = (persons) => {
                    return persons.filter((person) => {
                        if (person.first_name === undefined) {
                            return false;
                        }

                        let p1 = new google.maps.LatLng(cityObj[0].lat,cityObj[0].lon);
                        let p2 = new google.maps.LatLng(person.lat,person.lon);

                        let rad = function(x) {
                            return x * Math.PI / 180;
                        };

                        let R = 6378137;
                        let dLat = rad(p2.lat() - p1.lat());
                        let dLong = rad(p2.lng() - p1.lng());
                        let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
                            Math.sin(dLong / 2) * Math.sin(dLong / 2);
                        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        let distInMetres = R * c;
                        let distInKm = distInMetres/1000;

                        if (distInKm < 2000) {
                            return true;
                        }
                    })
                }

                this.persons = filterPersons(this.personsAll);

                this.mapCenter = new google.maps.LatLng(cityObj[0].lat,cityObj[0].lon);
                this.map.panTo(this.mapCenter);
                this.resetMarkers();
                
            }
        } // end of methods
    } // end of component
</script>
