<template>
  <app-modal :showModal= "showModal" @close="close">
    <h2>Добавить сотрудника</h2>
    
    <form class="form" v-on:submit.prevent="store">
      <div class="form__element">
        <label class="form__label" for="name">Имя</label>
        
        <ValidationProvider name="name" rules="required">
          <div slot-scope="{ errors }">
            <input class="form__name" type="text" name="name" v-model="persName" required>
            <p>{{ errors[0] }}</p>
          </div>
        </ValidationProvider>  
      
      </div>
      
      <div class="form__element">
        <label class="form__label" for="date">Дата</label>    
      
        <ValidationProvider name="date" :rules="{ required: true, regex: /^\d{2}\.d{2}\.d{4}$/ }">
          <div slot-scope="{ errors }"> 
            <input class="form__date" type="date" name="date" v-model="persDate" required>
            <p>{{ errors[0] }}</p>
          </div>
        </ValidationProvider>  
      </div>
            
      <button class="btn" type="submit">Добавить</button>     
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
        persName: '',
        persDate: '',
        errored: false,
        errors: []     
      };
    },
    watch: {
      showModal: function () {
        this.persName = '';
        this.persDate = '';   
        this.errored = false;
      },
    },
    methods: {
      store() {
        axios
          .post('/api/store/',{name: this.persName, date: this.persDate })
          .then(response => {
            this.persName = '';
            this.persDate = '';
            this.$emit('added');           
          })
          .catch(error => {
            this.errors = error.response.data.errors; 
            this.errored = true;
          });             
      },
      close() {
        this.$emit('close');
      }
    },

    components: {
      appModal: Modal
    },
    props: ['showModal']
  }  
</script>
