<template>
  <div class="page" v-bind:class="{page__overlay: showModalAdd||showModalEdit}">
    <h1>Список сотрудников</h1>
    <button class="btn" @click="showModalAdd = true">Добавить</button>
    
    <div class="page__sort">
      <p>Сортировка 
        <select v-model="sortParam">
          <option selected value="name">Имя</option>
          <option value="date">Дата</option>
        </select> 
      </p>
       
    </div>
    
    
    <table class="table">
      <tr>
        <td><a @click="sortParam='name'">Имя</a></td>
        <td><a @click="sortParam='date'">Дата</a></td>
        <td>Действие</td>
      </tr>
      <div class="page__loading" v-if="loading">Загружаю список...</div>
      <tr v-for="(person, index) in sortedList">
        <td>{{ person.name }}</td>
        <td>{{ new Date(person.date) | dateFormat('DD.MM.YYYY')}}</td>

        <td>
          <button class="btn btn--edit" @click="edit(person.id, person.name, person.date)">Править</button>
          <button class="btn btn--del" @click="del(person.id)">Удалить</button> 
        </td>
      </tr>

    </table>

    <div v-show="showInfo" class="page__info">
      <p class="page__message">{{ message }}</p>
    </div>

    <app-add 
      :showModal = "showModalAdd" 
      @close="showModalAdd = false"
      @added="added">
    </app-add>

    <app-edit
      :showModal = "showModalEdit" 
      :persIdEdit="persIdEdit"
      :persNameEdit="persNameEdit"
      :persDateEdit="persDateEdit"
      @edited="edited" 
      @close="showModalEdit = false">
    </app-edit>

  </div>
 
</template>

<script>

  import axios from 'axios';
  import Add from './Add.vue';
  import Edit from './Edit.vue';
  
  export default {
    data() {
      return {
        persons: [],
        persIdEdit: '',
        persNameEdit: '',
        persDateEdit: '',
        loading: true,
        errored: false,
        showModalAdd: false,
        showModalEdit: false,
        sortParam: 'name',
        showInfo: false,
        message: ''
      };
    },
    methods: {
      loadList() {
        axios
        .get('/api/list/')
        .then(response => {
          this.persons = response.data.data
        })
        .catch(error => {
          this.showMessage("Ошибка при загрузки перечня сотрудников");
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
      },

      showMessage(message) {
        this.message = message;
        this.showInfo = true;
        setTimeout(() => this.showInfo = false, 3000);
      },
      
      added() {
        this.loadList();
        this.showModalAdd = false;
        this.showMessage('Добавлено');
      },

      edited() {
        this.loadList();
        this.showModalEdit = false;
        this.showMessage('Изменения внесены');
      },

      edit(persId, persName, persDate) {
        this.persIdEdit = persId;
        this.persNameEdit = persName;
        this.persDateEdit = persDate;
        this.showModalEdit = true;
      },

      del(persId) {
         const url = '/api/delete/' + persId;
         axios
          .post(url)
          .then(response => {
            this.loadList(); 
            this.showMessage('Запись уадалена');
          })
          .catch(error => {
            this.showMessage("Ошибка при удалении записи");
            console.log(error);
            this.errored = true;
          });      
      },     
    },

    mounted() {
      this.loadList(); 
    },

    computed: {
      sortedList() {
        const sortByName = (d1, d2) => ((d1.name.toLowerCase() > d2.name.toLowerCase()) ? 1 : -1);
        const sortByDate = (d1, d2) => ((d1.date > d2.date) ? 1 : -1);
        
        switch (this.sortParam) {
          case 'name': return this.persons.sort(sortByName);
          case 'date': return this.persons.sort(sortByDate);
          default: return this.persons;
        }
      },
    },

    components: {
      appEdit: Edit,
      appAdd: Add
    }
  }
  
</script>

<style>
  .page {
    padding-left: 15px;
    padding-right: 15px;
  }

  .page__overlay {
    overflow-y: hidden;
  }  
  
  .page__overlay::before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.7);
  }
  
  .page__info {
    position: fixed;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 4px;
    border: 1px solid #af9f9f;
    background-color: #f1f1f1;
    padding: 30px;
  }

  .page__message {
    color: #42b983;
  }

  .page__sort {
    margin-bottom: 16px;
  }
  
  .page__sort select {
    min-width: 100px; 
  }

  .table td {
    padding-right: 30px;
    padding-bottom: 8px;
  }
  
  
</style>