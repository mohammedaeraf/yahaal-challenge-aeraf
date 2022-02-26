<template>
  <div class="w3-container">
    <h5>Gender Stats</h5>
    <p>Male</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-blue" :style="{width:malePercent}">{{ maleCount }}</div>
    </div>

    <p>Female</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-pink" :style="{width:femalePercent}">{{ femaleCount }}</div>
    </div>
  </div>
    
</template>

<script>
    export default {
        data() {
            return {
                persons: '',
                totalCount: 0,
                maleCount: 0,
                femaleCount: 0,
                malePercent: 0,
                femalePercent: 0
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                console.log('calling api')
                axios.get('/api/persons')
                    .then(response => {
                        console.log(response)
                        this.persons = response.data;
                        console.log(this.persons)
                        this.totalCount = this.persons.length;

                        this.persons.filter((person) => {
                            person.gender === 'Male' ? this.maleCount++ : this.femaleCount++ ;
                        })
                        
                        this.malePercent = (this.maleCount * 100 / this.totalCount).toFixed(2) + '%';
                        this.femalePercent = (this.femaleCount * 100 / this.totalCount).toFixed(2) + '%';
                    })
                    .catch(err => console.error(err));
            }
        }
    }
</script>
