<template>
  <div v-bind:class="{active: showModalAdd}" class="modal">
    <h2>Добавить сотрудника</h2>
    <form v-on:submit.prevent="store">
      <label>
          Имя
          <input class="name" type="text" name="name" v-model="persName" required>
      </label>
      <label>
          Дата
          <input class="date" type="date" name="date" v-model="persDate" required>
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
        
      };
    },
    methods: {
      close() {
        //console.log(this.showModalAdd);
        this.showModalAdd = false;
      },
      store() {
        axios
          .post('/page/store/',{name: this.persName, date: this.persDate })
          .then(response => {
            this.showModal = false;
            this.$emit('added');
            console.log('Добавлено'); 
          })
          .catch(error => {
            console.log(error);
            this.errored = true;
          })
          .finally(() => (this.loading = false));      
      }
    },
    props: ['showModalAdd']
  }  
</script>
