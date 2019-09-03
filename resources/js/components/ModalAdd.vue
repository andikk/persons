<template>
  <div class="modal" v-bind:class="{active: showModalAdd}">
    <button class="modal__close" @click="close">&times;</button>
    <h2>Добавить сотрудника</h2>
    
    <form v-on:submit.prevent="store">
      <div class="modal__element">
        <label class="modal__label" for="name">Имя</label>
        <input class="modal__name" type="text" name="name" v-model="persName" required>  
      </div>
      
      <div class="modal__element">
        <label class="modal__label" for="date">Дата</label>    
        <input class="modal__date" type="date" name="date" v-model="persDate" required>  
      </div>
            
      <button class="btn" type="submit">Добавить</button>     
    </form>

    <div class="modal__error" v-if="errored">
      <ul>
        <li v-for="(error, index) in errors">{{ error }}</li>
      </ul> 
    </div>
    
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
        errors: []     
      };
    },
    methods: {
      close() {
        this.$emit('closed');
      },
      store() {
        axios
          .post('/store/',{name: this.persName, date: this.persDate })
          .then(response => {
            this.persName = '';
            this.persDate = '';
            this.$emit('added');           
          })
          .catch(error => {
            this.errors = error.response.data.errors; 
            this.errored = true;
          });             
      }
    },
    props: ['showModalAdd']
  }  
</script>
