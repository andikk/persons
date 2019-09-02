<template>
  <div class="modal" v-bind:class="{active: this.showModalEdit}">
    <h2>Добавить сотрудника</h2>
   
    <form v-on:submit.prevent="edit">
      <label>
          Имя
          <input class="name" type="text" name="name" v-model="newPersName" required>
      </label>
      <label>
          Дата
          <input class="date" type="date" name="date" v-model="newPersDate" required>
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
        newPersName: '',
        newPersDate: '',
        errored: false,
        loading: true
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
            console.log(error);
            this.errored = true;
          })
          .finally(() => (this.loading = false));      
      }
    },
    props: ['showModalEdit', 'persIdEdit', 'persNameEdit', 'persDateEdit']
  }  
</script>
