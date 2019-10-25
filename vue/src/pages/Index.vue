<template>
  <div>
    <h1>Index</h1>
  </div>
</template>

<script>
import ApiService from '../services/api.service';

export default {
  name: 'Index',
  created(){
    this.ping();
  },
  methods: {
    ping(){
      ApiService.get('site/ping')
        .then(res => { console.log(res); })
        .catch(err => { console.log(err); });
    }
  },
}
</script>