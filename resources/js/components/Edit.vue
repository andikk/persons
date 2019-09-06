<template>
  <app-modal :showModal= "showModal" @close="close">

    <h2>Редактировать сотрудника</h2>
   
    <form class="form" v-on:submit.prevent="edit">
      <div class="form__element">
        <label class="form__label" for="name">Имя</label>

        <ValidationProvider name="name" rules="required">
          <div slot-scope="{ errors }">
            <input class="form__name" type="text" name="name" v-model="newPersName" required>
            <p>{{ errors[0] }}</p>
          </div>
        </ValidationProvider>  

      </div>
      
      <div class="form__element">
        <label class="form__label" for="date">Дата</label>    

        <ValidationProvider name="date" :rules="{ required: true, regex: /^\d{4} \d{6}$/ }">
          <div slot-scope="{ errors }">
            <input class="form__date" type="date" name="date" v-model="newPersDate" required>
            <p>{{ errors[0] }}</p>
          </div>
        </ValidationProvider> 

      </div>
      
      <button class="btn" type="submit">Сохранить</button>   
    </form>

    <div class="form__error" v-if="errored">
      <ul>
        <li v-for="(error, index) in errors">{{ error }}</li>
      </ul> 
    </div>

  </app-modal> 
</template>

<script>
  import Modal from './Modal.vue';
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
      showModal: function () {
        this.newPersName = this.persNameEdit;
        this.newPersDate = this.persDateEdit;   
      },
    },
    methods: {
      close() {
        this.$emit('close');
      },
      edit() {
        axios
          .post('/api/update',{id: this.persIdEdit, name: this.newPersName, date: this.newPersDate })
          .then(response => {
            this.$emit('edited');           
          })
          .catch(error => {
            this.errors = error.response.data.errors; 
            this.errored = true;
          });      
      }
    },
    components: {
      appModal: Modal
    },
    props: ['showModal', 'persIdEdit', 'persNameEdit', 'persDateEdit']
  }  
</script>
