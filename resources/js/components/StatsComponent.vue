<template>
    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-half">
            <div class="w3-container w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-male w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>{{ maleCount }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Male</h4>
            </div>
        </div>
        <div class="w3-half">
            <div class="w3-container w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-female w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>{{ femaleCount }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Female</h4>
            </div>
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
