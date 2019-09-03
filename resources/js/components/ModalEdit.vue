<template>
  <div class="modal" v-bind:class="{active: this.showModalEdit}">
    <button class="modal__close" @click="close">&times;</button>

    <h2>Редактировать сотрудника</h2>
   
    <form v-on:submit.prevent="edit">
      <div class="modal__element">
        <label class="modal__label" for="name">Имя</label>
        <input class="modal__name" type="text" name="name" v-model="newPersName" required>  
      </div>
      
      <div class="modal__element">
        <label class="modal__label" for="date">Дата</label>    
        <input class="modal__date" type="date" name="date" v-model="newPersDate" required>  
      </div>
      
      <button class="btn" type="submit">Сохранить</button>   
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
        newPersName: '',
        newPersDate: '',
        errored: false,
        errors: [] 
      };
    },
    watch: {
      showModalEdit: function () {
        this.newPersName = this.persNameEdit;
        this.newPersDate = this.persDateEdit;   
      },
    },
    methods: {
      close() {
        this.$emit('closed');
      },
      edit() {
        axios
          .post('/update',{id: this.persIdEdit, name: this.newPersName, date: this.newPersDate })
          .then(response => {
            this.$emit('edited');           
          })
          .catch(error => {
            this.errors = error.response.data.errors; 
            this.errored = true;
          });      
      }
    },
    props: ['showModalEdit', 'persIdEdit', 'persNameEdit', 'persDateEdit']
  }  
</script>
