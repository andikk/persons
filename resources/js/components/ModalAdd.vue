<template>
  <div class="modal">
    <h2>Добавить сотрудника</h2>
    <form v-on:submit.prevent="store">
      <label>
          Имя
          <input class="name" type="text" name="name" v-model="persName" required>
      </label>
      <label>
          Дата
          <input class="date" type="date" name="date" v-model="persDate">
      </label>
      
      <button class="submit" type="submit">+</button>
      
    </form>

    <button class="close" @click="close">x</button>
  </div>  
</template>

<script>
  import axios from 'axios';
  export default {
    data() {
      return {
        persName: '',
        persDate: '',
        errored: false,
        loading: true
      };
    },
    methods: {
      close() {
        this.$emit('closed');
      },
      store() {
        axios
          .post('/page/store/',{name: this.persName, date: this.persDate })
          .then(response => {
            this.$emit('added');           
          })
          .catch(error => {
            console.log(error.response.data.errors);
            this.errored = true;
          })
          .finally(() => (this.loading = false));      
      }
    }
  }  
</script>
